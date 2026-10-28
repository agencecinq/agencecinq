<?php
/**
 * GitHub activity
 *
 * The repositories of the organization, last pushed first, and the commits of their default branch per
 * day over the last 26 weeks, from the GraphQL API. The query takes seconds: a page reads the stored
 * activity and, once it is an hour old, WP-Cron fetches it again in the background. Without access to the
 * history of a private repository, its commits are left out.
 *
 * @package WordPress
 * @subpackage AgenceCinq/GitHub
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\GitHub;

use AgenceCinq\Service;
use DateTimeImmutable;

/**
 * GitHub activity client.
 */
class Activity implements Service {

	/**
	 * Option of the repositories, the commits per day and when they expire.
	 */
	private const OPTION = 'agencecinq_github_activity';

	/**
	 * WP-Cron hook that fetches the activity again.
	 */
	private const HOOK = 'agencecinq_github_activity_refresh';

	/**
	 * Lifetime of the activity in seconds.
	 */
	private const CACHE_TTL = HOUR_IN_SECONDS;

	/**
	 * Delay before a failed request is tried again, in seconds.
	 */
	private const RETRY_TTL = 5 * MINUTE_IN_SECONDS;

	/**
	 * Weeks of commits, the current one included.
	 */
	private const WEEKS = 26;

	/**
	 * A page of repositories, each with the first page of its history.
	 */
	private const REPOSITORIES_QUERY = 'query($since: GitTimestamp!, $after: String) {
		organization(login: "agencecinq") {
			repositories(first: 100, after: $after, isFork: false, isArchived: false, orderBy: { field: PUSHED_AT, direction: DESC }) {
				pageInfo { hasNextPage endCursor }
				nodes {
					name
					isPrivate
					pushedAt
					repositoryTopics(first: 20) { nodes { topic { name } } }
					defaultBranchRef { target { ... on Commit { history(since: $since, first: 100) { pageInfo { hasNextPage endCursor } nodes { committedDate } } } } }
				}
			}
		}
	}';

	/**
	 * The next page of the history of a repository, past 100 commits.
	 */
	private const HISTORY_QUERY = 'query($name: String!, $since: GitTimestamp!, $after: String) {
		repository(owner: "agencecinq", name: $name) {
			defaultBranchRef { target { ... on Commit { history(since: $since, first: 100, after: $after) { pageInfo { hasNextPage endCursor } nodes { committedDate } } } } }
		}
	}';

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run(): void {
		add_action( self::HOOK, array( self::class, 'refresh' ) );
	}

	/**
	 * Returns the repositories, last pushed first, and the weeks of commits, empty until the first fetch.
	 *
	 * Each week holds a level per day from Monday, up to today: 0 without a commit, then 1 or 2 below or from
	 * the median of the days with commits. The weeks are empty when no commit is readable.
	 *
	 * @return array{repositories: array<int, array{name: string, private: bool, pushed_at: string, topics: array<int, string>}>, weeks: array<int, array<int, int>>}
	 */
	public static function get(): array {
		$stored = get_option( self::OPTION, array() );

		if ( ( $stored['expires'] ?? 0 ) < time() && ! wp_next_scheduled( self::HOOK ) ) {
			wp_schedule_single_event( time(), self::HOOK );
		}

		return array(
			'repositories' => $stored['repositories'] ?? array(),
			'weeks'        => self::weeks( $stored['days'] ?? array() ),
		);
	}

	/**
	 * Fetches the activity and stores it. A failed fetch keeps the previous activity and is tried again sooner.
	 *
	 * @return void
	 */
	public static function refresh(): void {
		$fetched = self::fetch();
		$stored  = $fetched ?? get_option( self::OPTION, array() );

		$stored['expires'] = time() + ( null === $fetched ? self::RETRY_TTL : self::CACHE_TTL );

		update_option( self::OPTION, $stored, false );
	}

	/**
	 * Monday of the first week, at midnight in the site timezone.
	 *
	 * @return DateTimeImmutable
	 */
	private static function start(): DateTimeImmutable {
		return ( new DateTimeImmutable( 'monday this week', wp_timezone() ) )->modify( '-' . ( self::WEEKS - 1 ) . ' weeks' );
	}

	/**
	 * Levels per day of each week, from the commits per date.
	 *
	 * @param array<string, int> $days Commits per Y-m-d date.
	 * @return array<int, array<int, int>>
	 */
	private static function weeks( array $days ): array {
		if ( ! array_sum( $days ) ) {
			return array();
		}

		$counts = array_values( array_filter( $days ) );
		sort( $counts );
		$median = $counts[ intdiv( count( $counts ), 2 ) ];

		$today = wp_date( 'Y-m-d' );
		$weeks = array();
		$day   = self::start();

		for ( $week = 0; $week < self::WEEKS; $week++ ) {
			for ( $weekday = 0; $weekday < 7; $weekday++, $day = $day->modify( '+1 day' ) ) {
				$date = $day->format( 'Y-m-d' );

				if ( $date > $today ) {
					break 2;
				}

				$count = $days[ $date ] ?? 0;

				$weeks[ $week ][] = $count ? ( $count < $median ? 1 : 2 ) : 0;
			}
		}

		return $weeks;
	}

	/**
	 * Fetches the repositories and counts the commits of their default branch per day.
	 *
	 * @return array{repositories: array<int, array<string, mixed>>, days: array<string, int>}|null
	 */
	private static function fetch(): ?array {
		$since        = self::start()->format( DATE_ATOM );
		$repositories = array();
		$days         = array();
		$after        = null;

		do {
			$data = self::request(
				self::REPOSITORIES_QUERY,
				array(
					'since' => $since,
					'after' => $after,
				)
			);

			if ( ! isset( $data['organization']['repositories'] ) ) {
				return null;
			}

			$page = $data['organization']['repositories'];

			foreach ( array_filter( $page['nodes'] ) as $node ) {
				$repositories[] = array(
					'name'      => $node['name'],
					'private'   => $node['isPrivate'],
					'pushed_at' => $node['pushedAt'],
					'topics'    => array_map(
						fn( $topic ) => $topic['topic']['name'],
						$node['repositoryTopics']['nodes']
					),
				);

				$history = $node['defaultBranchRef']['target']['history'] ?? null;

				while ( $history ) {
					foreach ( $history['nodes'] as $commit ) {
						$date          = wp_date( 'Y-m-d', strtotime( $commit['committedDate'] ) );
						$days[ $date ] = ( $days[ $date ] ?? 0 ) + 1;
					}

					$history = $history['pageInfo']['hasNextPage']
						? self::request(
							self::HISTORY_QUERY,
							array(
								'name'  => $node['name'],
								'since' => $since,
								'after' => $history['pageInfo']['endCursor'],
							)
						)['repository']['defaultBranchRef']['target']['history'] ?? null
						: null;
				}
			}

			$after = $page['pageInfo']['hasNextPage'] ? $page['pageInfo']['endCursor'] : null;
		} while ( $after );

		return array(
			'repositories' => $repositories,
			'days'         => $days,
		);
	}

	/**
	 * Sends a GraphQL query. Its data comes back even when some fields are refused, such as the history
	 * of a private repository the token cannot read.
	 *
	 * @param string               $query     GraphQL query.
	 * @param array<string, mixed> $variables Variables of the query.
	 * @return array<string, mixed>|null
	 */
	private static function request( string $query, array $variables ): ?array {
		$token = defined( 'CINQ_GITHUB_TOKEN' ) && is_string( CINQ_GITHUB_TOKEN ) ? CINQ_GITHUB_TOKEN : '';

		if ( '' === $token ) {
			return null;
		}

		$response = wp_remote_post(
			'https://api.github.com/graphql',
			array(
				'timeout' => 10,
				'headers' => array(
					'Authorization' => 'Bearer ' . $token,
					'Content-Type'  => 'application/json',
					'User-Agent'    => 'agencecinq-website',
				),
				'body'    => wp_json_encode(
					array(
						'query'     => $query,
						'variables' => $variables,
					)
				),
			)
		);

		if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
			return null;
		}

		$body = json_decode( wp_remote_retrieve_body( $response ), true );

		return is_array( $body['data'] ?? null ) ? $body['data'] : null;
	}
}
