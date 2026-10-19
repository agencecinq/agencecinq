<?php
/**
 * Catalogue client
 *
 * Fetches the public catalogue served by Central and caches it.
 *
 * @see https://github.com/agencecinq/central-v3/blob/main/docs/api-catalogue-public.md
 *
 * @package WordPress
 * @subpackage AgenceCinq/Catalogue
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Catalogue;

/**
 * Catalogue client.
 *
 * Two layers of cache:
 * - a transient, fresh for one minute, the freshness Central promises;
 * - an option holding the last good payload and its ETag, served when Central
 *   is down or answers something unexpected. A Central outage never empties
 *   the prices of the site.
 */
class Client {

	/**
	 * Contract version the theme knows how to read.
	 */
	public const VERSION = 'catalogue.v2';

	/**
	 * Default catalogue URL (root route: the whole catalogue in one call).
	 */
	private const URL = 'https://app.cinqteam.com/api/public/catalogue/cinq';

	/**
	 * Transient key for the fresh payload.
	 */
	private const TRANSIENT_KEY = 'agencecinq_catalogue';

	/**
	 * Option key for the last good payload and its ETag.
	 */
	private const OPTION_KEY = 'agencecinq_catalogue_fallback';

	/**
	 * Cache lifetime in seconds.
	 */
	private const CACHE_TTL = MINUTE_IN_SECONDS;

	/**
	 * Returns the catalogue payload, or null when it has never been fetched.
	 *
	 * @return array<string, mixed>|null
	 */
	public static function get(): ?array {
		$cached = get_transient( self::TRANSIENT_KEY );

		if ( is_array( $cached ) ) {
			return $cached;
		}

		$fallback = get_option( self::OPTION_KEY );
		$fallback = is_array( $fallback ) ? $fallback : array();
		$data     = self::fetch( $fallback );

		if ( null === $data ) {
			// Serve the last good payload, and wait a minute before asking Central again.
			$data = isset( $fallback['data'] ) && is_array( $fallback['data'] ) ? $fallback['data'] : null;
		}

		if ( null !== $data ) {
			set_transient( self::TRANSIENT_KEY, $data, self::CACHE_TTL );
		}

		return $data;
	}

	/**
	 * Empties the fresh cache. The fallback stays.
	 *
	 * @return void
	 */
	public static function flush(): void {
		delete_transient( self::TRANSIENT_KEY );
	}

	/**
	 * Fetches the catalogue from Central.
	 *
	 * @param array<string, mixed> $fallback Last good payload and its ETag.
	 * @return array<string, mixed>|null Null on any failure.
	 */
	private static function fetch( array $fallback ): ?array {
		$args = array(
			'timeout' => 5,
			'headers' => array(
				'Accept'     => 'application/json',
				'User-Agent' => 'agencecinq-website',
			),
		);

		if ( ! empty( $fallback['etag'] ) && ! empty( $fallback['data'] ) ) {
			$args['headers']['If-None-Match'] = $fallback['etag'];
		}

		$response = wp_remote_get( self::url(), $args );

		if ( is_wp_error( $response ) ) {
			return null;
		}

		$code = (int) wp_remote_retrieve_response_code( $response );

		if ( 304 === $code ) {
			return is_array( $fallback['data'] ?? null ) ? $fallback['data'] : null;
		}

		if ( 200 !== $code ) {
			return null;
		}

		$body = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( ! is_array( $body ) || self::VERSION !== ( $body['version'] ?? null ) ) {
			return null;
		}

		update_option(
			self::OPTION_KEY,
			array(
				'etag' => (string) wp_remote_retrieve_header( $response, 'etag' ),
				'data' => $body,
			),
			false
		);

		return $body;
	}

	/**
	 * Returns the catalogue URL, overridable from wp-config.
	 *
	 * @return string
	 */
	private static function url(): string {
		if ( defined( 'CINQ_CATALOGUE_URL' ) && is_string( CINQ_CATALOGUE_URL ) ) {
			return CINQ_CATALOGUE_URL;
		}

		return self::URL;
	}
}
