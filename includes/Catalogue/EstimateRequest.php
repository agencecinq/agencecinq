<?php
/**
 * Estimate request
 *
 * POST /wp-json/cinq/v1/estimate: sends the estimate of the configurator by e-mail.
 *
 * @package WordPress
 * @subpackage AgenceCinq/Catalogue
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Catalogue;

use AgenceCinq\Service;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

/**
 * Estimate request.
 *
 * The configurator form posts here: the e-mail, the platform, the package of each platform and the modules.
 * The estimate is checked and priced again from the catalogue, then the visitor gets it by e-mail and CINQ
 * gets a copy. A script asking for JSON gets { email, total } or an error; the form posted without
 * JavaScript is sent back to its page, at {block}-sent or {block}-failed.
 */
class EstimateRequest implements Service {

	/**
	 * Requests allowed per IP and hour.
	 */
	private const RATE_LIMIT = 5;

	/**
	 * Runs the service.
	 *
	 * @return void
	 */
	public function run(): void {
		add_action( 'rest_api_init', array( $this, 'register_route' ) );
	}

	/**
	 * Registers the route. Nothing is required here: a form posted without JavaScript must come back to its
	 * page whatever it holds, so every value is checked in the callback.
	 *
	 * @return void
	 */
	public function register_route(): void {
		register_rest_route(
			'cinq/v1',
			'/estimate',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'handle' ),
				'permission_callback' => '__return_true',
				'args'                => array(
					'email'    => array(
						'type'    => 'string',
						'default' => '',
					),
					'platform' => array(
						'type'    => 'string',
						'default' => '',
					),
					'package'  => array(
						'type'                 => 'object',
						'additionalProperties' => array( 'type' => 'string' ),
						'default'              => array(),
					),
					'modules'  => array(
						'type'    => 'array',
						'items'   => array( 'type' => 'string' ),
						'default' => array(),
					),
					'source'   => array(
						'type'    => 'string',
						'default' => '',
					),
					'block'    => array(
						'type'    => 'string',
						'default' => '',
					),
					'website'  => array(
						'type'    => 'string',
						'default' => '',
					),
				),
			)
		);
	}

	/**
	 * Sends the estimate, then answers the script or sends the form back to its page.
	 *
	 * @param WP_REST_Request $request Request.
	 * @return WP_REST_Response|WP_Error
	 */
	public function handle( WP_REST_Request $request ): WP_REST_Response|WP_Error {
		$result = $this->estimate( $request );

		if ( str_contains( (string) $request->get_header( 'accept' ), 'application/json' ) ) {
			return $result;
		}

		$source   = wp_validate_redirect( esc_url_raw( (string) $request->get_param( 'source' ) ), home_url( '/' ) );
		$anchor   = sanitize_html_class( (string) $request->get_param( 'block' ) ) . ( is_wp_error( $result ) ? '-failed' : '-sent' );
		$response = new WP_REST_Response( null, 303 );

		$response->header( 'Location', strtok( $source, '#' ) . '#' . $anchor );

		return $response;
	}

	/**
	 * Checks the request, prices the estimate and sends it.
	 *
	 * @param WP_REST_Request $request Request.
	 * @return WP_REST_Response|WP_Error
	 */
	private function estimate( WP_REST_Request $request ): WP_REST_Response|WP_Error {
		$email = sanitize_email( (string) $request->get_param( 'email' ) );

		if ( ! is_email( $email ) ) {
			return new WP_Error( 'cinq_estimate_email', _x( 'This e-mail address looks incomplete. Example: name@company.com', 'estimate error', 'agencecinq' ), array( 'status' => 400 ) );
		}

		if ( ! self::within_rate_limit() ) {
			return new WP_Error( 'cinq_estimate_rate', _x( 'Too many estimates from this connection. Please try again in an hour.', 'estimate error', 'agencecinq' ), array( 'status' => 429 ) );
		}

		$platform = sanitize_key( (string) $request->get_param( 'platform' ) );
		$packages = (array) $request->get_param( 'package' );
		$estimate = Estimate::from_choice(
			$platform,
			sanitize_text_field( (string) ( $packages[ $platform ] ?? '' ) ),
			array_map( 'sanitize_text_field', (array) $request->get_param( 'modules' ) )
		);

		if ( null === $estimate ) {
			return new WP_Error( 'cinq_estimate_package', _x( 'This offer is no longer in the catalogue. Please reload the page.', 'estimate error', 'agencecinq' ), array( 'status' => 422 ) );
		}

		$source = wp_validate_redirect( esc_url_raw( (string) $request->get_param( 'source' ) ), home_url( '/' ) );

		// Honeypot: a bot gets the same answer, and nothing is sent.
		if ( '' === (string) $request->get_param( 'website' ) && ! self::send( $email, $estimate, $source ) ) {
			return new WP_Error(
				'cinq_estimate_mail',
				sprintf(
					/* translators: %s: contact e-mail address. */
					_x( 'The sending failed on our side. Please try again, or write to us at %s.', 'estimate error', 'agencecinq' ),
					self::recipient()
				),
				array( 'status' => 500 )
			);
		}

		return new WP_REST_Response(
			array(
				'email' => $email,
				'total' => Catalogue::price( $estimate->total() ),
			)
		);
	}

	/**
	 * Sends the estimate to the visitor and a copy to CINQ.
	 *
	 * @param string   $email    Visitor e-mail.
	 * @param Estimate $estimate Checked estimate.
	 * @param string   $source   Page the estimate was asked from.
	 * @return bool Whether the mail to the visitor left.
	 */
	private static function send( string $email, Estimate $estimate, string $source ): bool {
		$site      = get_bloginfo( 'name' );
		$total     = Catalogue::price( $estimate->total() );
		$lines     = implode( "\n", $estimate->lines() );
		$booking   = (string) ( self::contact()['link']['url'] ?? '' );
		$recipient = self::recipient();

		$body = array(
			_x( 'Hello,', 'estimate email', 'agencecinq' ),
			sprintf(
				/* translators: %s: site name. */
				_x( 'Here is your %s estimate, as you put it together on our website.', 'estimate email', 'agencecinq' ),
				$site
			),
			$lines,
			_x( 'This estimate lists your configuration line by line. The firm price is set after the diagnosis, on a written scope.', 'estimate email', 'agencecinq' )
				. ( $estimate->is_firm() ? '' : ' ' . _x( 'Lines marked “From” or “On quote” are priced during a meeting.', 'estimate email', 'agencecinq' ) ),
			$booking ? _x( 'To talk it over, book a 30-minute call:', 'estimate email', 'agencecinq' ) . "\n" . $booking : '',
			$site,
		);

		$sent = wp_mail(
			$email,
			sprintf(
				/* translators: 1: site name, 2: estimate total. */
				_x( 'Your %1$s estimate: %2$s', 'estimate email subject', 'agencecinq' ),
				$site,
				$total
			),
			implode( "\n\n", array_filter( $body ) ),
			array( 'Reply-To: ' . $recipient )
		);

		if ( $sent ) {
			wp_mail(
				$recipient,
				sprintf(
					/* translators: 1: visitor e-mail address, 2: estimate total. */
					_x( 'Estimate from the configurator: %1$s, %2$s', 'estimate copy subject', 'agencecinq' ),
					$email,
					$total
				),
				implode(
					"\n\n",
					array(
						/* translators: %s: visitor e-mail address. */
						sprintf( _x( 'E-mail: %s', 'estimate copy', 'agencecinq' ), $email ),
						$lines,
						/* translators: %s: page URL. */
						sprintf( _x( 'Page: %s', 'estimate copy', 'agencecinq' ), $source ),
					)
				),
				array( 'Reply-To: ' . $email )
			);
		}

		return $sent;
	}

	/**
	 * Counts the requests of this IP over the hour. The IP is hashed, never stored.
	 *
	 * @return bool False once the limit is reached.
	 */
	private static function within_rate_limit(): bool {
		$ip    = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
		$key   = 'agencecinq_estimate_' . substr( wp_hash( $ip ), 0, 20 );
		$count = (int) get_transient( $key );

		if ( $count >= self::RATE_LIMIT ) {
			return false;
		}

		set_transient( $key, $count + 1, HOUR_IN_SECONDS );

		return true;
	}

	/**
	 * Who gets the copies: the e-mail of the theme options, the admin e-mail without one.
	 *
	 * @return string
	 */
	private static function recipient(): string {
		$email = sanitize_email( (string) ( self::contact()['email'] ?? '' ) );

		return is_email( $email ) ? $email : (string) get_option( 'admin_email' );
	}

	/**
	 * Contact group of the theme options: e-mail, phone, booking link.
	 *
	 * @return array<string, mixed>
	 */
	private static function contact(): array {
		$theme = function_exists( 'get_field' ) ? get_field( 'theme', 'option' ) : null;

		return is_array( $theme['contact'] ?? null ) ? $theme['contact'] : array();
	}
}
