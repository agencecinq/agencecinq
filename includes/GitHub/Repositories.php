<?php
/**
 * GitHub repositories
 *
 * Fetches the latest pushed repositories from the GitHub API and caches them.
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
	 * Number of repositories shown in the homepage hero.
	 */
	private const LIMIT = 5;

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
	 * Fetches repositories from GitHub.
	 *
	 * @return array<int, array<string, mixed>>|null
	 */
	private static function fetch(): ?array {
		$url  = 'https://api.github.com/orgs/agencecinq/repos?sort=pushed&per_page=30&type=all';
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

		$rows = array();

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

			if ( count( $rows ) >= self::LIMIT ) {
				break;
			}
		}

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
