<?php
/**
 * GitHub repositories
 *
 * Fetches all non-fork, non-archived repositories from the GitHub API and caches them.
 *
 * @package WordPress
 * @subpackage AgenceCinq/GitHub
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\GitHub;

/**
 * GitHub repositories client.
 */
class Repositories {

	/**
	 * Transient key for the raw API payload.
	 */
	private const TRANSIENT_KEY = 'agencecinq_github_repositories';

	/**
	 * Max repositories per GitHub API page (API hard limit).
	 */
	private const PER_PAGE = 100;

	/**
	 * Cache lifetime in seconds.
	 */
	private const CACHE_TTL = DAY_IN_SECONDS;

	/**
	 * Returns cached GitHub repositories.
	 *
	 * @return array<int, array<string, mixed>>
	 */
	public static function all(): array {
		$cached = get_transient( self::TRANSIENT_KEY );

		if ( is_array( $cached ) ) {
			return $cached;
		}

		$raw = self::fetch();

		if ( ! is_array( $raw ) ) {
			return array();
		}

		set_transient( self::TRANSIENT_KEY, $raw, self::CACHE_TTL );

		return $raw;
	}

	/**
	 * Fetches all repositories from GitHub (paginated).
	 *
	 * @return array<int, array<string, mixed>>|null
	 */
	private static function fetch(): ?array {
		$args = array(
			'timeout' => 8,
			'headers' => array(
				'Accept'               => 'application/vnd.github+json',
				'X-GitHub-Api-Version' => '2022-11-28',
				'User-Agent'           => 'agencecinq-website',
			),
		);

		$token = self::token();

		if ( '' !== $token ) {
			$args['headers']['Authorization'] = 'Bearer ' . $token;
		}

		$rows = array();
		$page = 1;

		do {
			$url = sprintf(
				'https://api.github.com/orgs/agencecinq/repos?sort=pushed&per_page=%d&type=all&page=%d',
				self::PER_PAGE,
				$page
			);

			$response = wp_remote_get( $url, $args );

			if ( is_wp_error( $response ) ) {
				return null;
			}

			if ( 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
				return null;
			}

			$body = json_decode( wp_remote_retrieve_body( $response ), true );

			if ( ! is_array( $body ) ) {
				return null;
			}

			foreach ( $body as $repo ) {
				if ( ! is_array( $repo ) ) {
					continue;
				}

				if ( ! empty( $repo['fork'] ) || ! empty( $repo['archived'] ) ) {
					continue;
				}

				if ( empty( $repo['name'] ) ) {
					continue;
				}

				$rows[] = $repo;
			}

			$has_more = count( $body ) === self::PER_PAGE;
			++$page;
		} while ( $has_more );

		return $rows;
	}

	/**
	 * Returns the GitHub token from wp-config, if defined.
	 *
	 * @return string
	 */
	private static function token(): string {
		if ( defined( 'CINQ_GITHUB_TOKEN' ) && is_string( CINQ_GITHUB_TOKEN ) ) {
			return CINQ_GITHUB_TOKEN;
		}

		return '';
	}
}
