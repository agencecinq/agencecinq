<?php
/**
 * Central
 *
 * Tells Central about each quote sent from the configurator, in the background.
 *
 * @package WordPress
 * @subpackage AgenceCinq/Catalogue
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Catalogue;

use AgenceCinq\Service;

/**
 * Central.
 *
 * Each estimate is posted to Central's POST /api/public/estimations/{slug} as
 * `estimation.v1` JSON, with the shared secret as Bearer token. Central reads the
 * package and the modules again from its own catalogue and turns the estimate into an
 * inbound deal. Nothing is queued until CINQ_CENTRAL_QUOTES_URL and CINQ_CENTRAL_SECRET
 * are defined in wp-config (the same secret as ESTIMATIONS_SECRET on Central).
 *
 * The `id` is drawn here, once: retries carry the same one, and Central answers 200
 * without creating anything twice.
 *
 * The visitor never waits for Central: the mail leaves first, the notification runs on
 * WP-Cron and is tried again with a growing delay when Central does not answer.
 */
class Central implements Service {

	/**
	 * Cron hook.
	 */
	private const HOOK = 'agencecinq_central_quote';

	/**
	 * Attempts before giving up.
	 */
	private const MAX_ATTEMPTS = 5;

	/**
	 * Runs the service.
	 *
	 * @return void
	 */
	public function run(): void {
		add_action( self::HOOK, array( self::class, 'deliver' ), 10, 2 );
	}

	/**
	 * The `estimation.v1` payload: what was chosen, never what it costs. The total
	 * travels only as a witness; Central prices the composition itself.
	 *
	 * @param string               $email       Visitor e-mail.
	 * @param array<string, mixed> $composition Checked composition.
	 * @param string               $source      Page the estimate was asked from.
	 * @return array<string, mixed>
	 */
	public static function payload( string $email, array $composition, string $source ): array {
		$package = $composition['package'];

		return array(
			'version'     => 'estimation.v1',
			'id'          => wp_generate_uuid4(),
			'email'       => $email,
			'platform'    => $package['category']['id'] ?? '',
			'packageCode' => $package['code'] ?? '',
			'moduleIds'   => Composition::module_ids( $composition ),
			'total'       => array(
				'amountExclVat' => (float) $composition['total']['amount'],
				'mode'          => $composition['total']['mode'],
			),
			'sourceUrl'   => $source,
			'sentAt'      => gmdate( 'c' ),
		);
	}

	/**
	 * Queues a quote for Central.
	 *
	 * @param array<string, mixed> $payload The `estimation.v1` payload, from payload().
	 * @return void
	 */
	public static function queue( array $payload ): void {
		if ( ! self::configured() ) {
			return;
		}

		wp_schedule_single_event( time(), self::HOOK, array( $payload, 1 ) );
	}

	/**
	 * Posts a quote to Central, and plans another attempt when it fails.
	 *
	 * @param array<string, mixed> $payload Quote.
	 * @param int                  $attempt Attempt number, from 1.
	 * @return void
	 */
	public static function deliver( array $payload, int $attempt ): void {
		if ( ! self::configured() ) {
			return;
		}

		$response = wp_remote_post(
			CINQ_CENTRAL_QUOTES_URL,
			array(
				'timeout' => 10,
				'headers' => array(
					'Authorization' => 'Bearer ' . CINQ_CENTRAL_SECRET,
					'Content-Type'  => 'application/json',
				),
				'body'    => wp_json_encode( $payload ),
			)
		);

		$code = is_wp_error( $response ) ? 0 : (int) wp_remote_retrieve_response_code( $response );

		if ( $code >= 200 && $code < 300 ) {
			return;
		}

		// A 4xx other than 429 will not get better by waiting.
		if ( $attempt >= self::MAX_ATTEMPTS || ( $code >= 400 && $code < 500 && 429 !== $code ) ) {
			do_action( 'agencecinq_central_quote_failed', $payload, $code );
			return;
		}

		// 5, 10, 20, 40 minutes.
		wp_schedule_single_event( time() + 5 * MINUTE_IN_SECONDS * 2 ** ( $attempt - 1 ), self::HOOK, array( $payload, $attempt + 1 ) );
	}

	/**
	 * Whether the Central route and its secret are set.
	 *
	 * @return bool
	 */
	private static function configured(): bool {
		return defined( 'CINQ_CENTRAL_QUOTES_URL' ) && defined( 'CINQ_CENTRAL_SECRET' ) && CINQ_CENTRAL_QUOTES_URL && CINQ_CENTRAL_SECRET;
	}
}
