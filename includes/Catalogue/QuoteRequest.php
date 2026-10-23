<?php
/**
 * Quote request
 *
 * POST /wp-json/cinq/v1/quote: sends the composition of the configurator by e-mail.
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
 * Quote request.
 *
 * The browser sends the e-mail and what was chosen, never a price: the composition
 * is checked and priced again from the catalogue. The visitor gets the estimate, CINQ
 * gets a copy, and Central is told in the background (Central::queue()).
 *
 * Always an estimate (estimation), never a quote (devis): the firm price is set after
 * the diagnosis, on a written scope.
 */
class QuoteRequest implements Service {

	/**
	 * Requests allowed per IP and hour.
	 */
	private const RATE_LIMIT = 5;

	/**
	 * Nonce action, localized as cinq.rest_nonce (Setup/Enqueue.php) and sent as X-WP-Nonce.
	 * The REST one: for a logged-in visitor WordPress checks it and keeps the user,
	 * without it the request would run logged out and no nonce made for the user would hold.
	 */
	private const NONCE_ACTION = 'wp_rest';

	/**
	 * Runs the service.
	 *
	 * @return void
	 */
	public function run(): void {
		add_action( 'rest_api_init', array( $this, 'register_route' ) );
	}

	/**
	 * Registers the route.
	 *
	 * @return void
	 */
	public function register_route(): void {
		register_rest_route(
			'cinq/v1',
			'/quote',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'handle' ),
				'permission_callback' => '__return_true',
				'args'                => array(
					'email'   => array(
						'type'     => 'string',
						'required' => true,
					),
					'socle'   => array(
						'type'     => 'string',
						'required' => true,
					),
					'modules' => array(
						'type'    => 'array',
						'items'   => array( 'type' => 'string' ),
						'default' => array(),
					),
					'booking' => array(
						'type'    => 'string',
						'default' => '',
					),
					'source'  => array(
						'type'    => 'string',
						'default' => '',
					),
					'website' => array(
						'type'    => 'string',
						'default' => '',
					),
				),
			)
		);
	}

	/**
	 * Sends the quote.
	 *
	 * @param WP_REST_Request $request Request.
	 * @return WP_REST_Response|WP_Error
	 */
	public function handle( WP_REST_Request $request ) {
		if ( ! wp_verify_nonce( (string) $request->get_header( 'x_wp_nonce' ), self::NONCE_ACTION ) ) {
			return new WP_Error( 'cinq_quote_expired', _x( 'The page has expired: please reload it, your selection will have to be redone.', 'quote expired', 'agencecinq' ), array( 'status' => 403 ) );
		}

		$email = sanitize_email( (string) $request->get_param( 'email' ) );

		if ( ! is_email( $email ) ) {
			return new WP_Error( 'cinq_quote_email', _x( 'This e-mail address seems incomplete. Example: name@company.fr', 'quote email', 'agencecinq' ), array( 'status' => 400 ) );
		}

		if ( ! self::within_rate_limit() ) {
			return new WP_Error( 'cinq_quote_rate', _x( 'Too many submissions from this connection. Please try again in an hour.', 'quote rate', 'agencecinq' ), array( 'status' => 429 ) );
		}

		$composition = Composition::from_choice(
			sanitize_text_field( (string) $request->get_param( 'socle' ) ),
			array_map( 'sanitize_text_field', (array) $request->get_param( 'modules' ) )
		);

		if ( null === $composition ) {
			return new WP_Error( 'cinq_quote_composition', _x( 'This offer is no longer in the catalogue: please reload the page.', 'quote composition', 'agencecinq' ), array( 'status' => 422 ) );
		}

		$booking = self::booking_url( (string) $request->get_param( 'booking' ), $composition );
		$source  = wp_validate_redirect( esc_url_raw( (string) $request->get_param( 'source' ) ), home_url( '/' ) );
		$total   = Catalogue::total_label( $composition['total'] );

		// Honeypot: a bot gets the same answer, and nothing is sent.
		if ( '' === (string) $request->get_param( 'website' ) ) {
			if ( ! self::send( $email, $composition, $booking, $source ) ) {
				return new WP_Error(
					'cinq_quote_mail',
					sprintf(
						/* translators: %s: contact email address. */
						_x( 'The sending failed on our side. Please try again, or write to us at %s.', 'quote mail', 'agencecinq' ),
						self::recipient()
					),
					array( 'status' => 500 )
				);
			}

			Central::queue( Central::payload( $email, $composition, $source ) );
		}

		return new WP_REST_Response(
			array(
				'email'   => $email,
				'total'   => $total,
				'booking' => $booking,
			)
		);
	}

	/**
	 * Sends the estimate to the visitor and a copy to CINQ.
	 *
	 * @param string               $email       Visitor e-mail.
	 * @param array<string, mixed> $composition Checked composition.
	 * @param string               $booking     Booking URL, the composition attached.
	 * @param string               $source      Page the estimate was asked from.
	 * @return bool Whether the visitor mail left.
	 */
	private static function send( string $email, array $composition, string $booking, string $source ): bool {
		$total = Catalogue::total_label( $composition['total'] );
		$lines = implode( "\n", Composition::lines( $composition ) );
		$from  = get_bloginfo( 'name' );

		$body = implode(
			"\n\n",
			array_filter(
				array(
					_x( 'Hello,', 'quote email greeting', 'agencecinq' ),
					sprintf(
						/* translators: %s: site name. */
						_x( 'Here is your %s estimate, as you put it together on our website.', 'quote email intro', 'agencecinq' ),
						$from
					),
					$lines,
					_x( 'This estimate lists your configuration line by line. The firm price is set after the assessment, based on a written scope.', 'quote email disclaimer', 'agencecinq' )
						. ( Composition::is_firm( $composition ) ? '' : ' ' . _x( 'Lines marked “From” or “On quote” are priced during a meeting.', 'quote email disclaimer', 'agencecinq' ) ),
					$booking ? _x( 'To discuss it, book a 30-minute call:', 'quote email booking', 'agencecinq' ) . "\n" . $booking : '',
					$from,
				)
			)
		);

		$sent = wp_mail(
			$email,
			sprintf(
				/* translators: 1: site name, 2: estimate total. */
				_x( 'Your %1$s estimate: %2$s', 'quote email subject', 'agencecinq' ),
				$from,
				$total
			),
			$body,
			array( 'Reply-To: ' . self::recipient() )
		);

		if ( $sent ) {
			wp_mail(
				self::recipient(),
				sprintf(
					/* translators: 1: visitor email address, 2: estimate total. */
					_x( 'Estimate sent from the estimator: %1$s, %2$s', 'quote notification subject', 'agencecinq' ),
					$email,
					$total
				),
				implode(
					"\n\n",
					array(
						/* translators: %s: visitor email address. */
						sprintf( _x( 'Email: %s', 'quote notification', 'agencecinq' ), $email ),
						$lines,
						/* translators: %s: page URL. */
						sprintf( _x( 'Page: %s', 'quote notification', 'agencecinq' ), $source ),
						/* translators: %s: booking URL. */
						$booking ? sprintf( _x( 'Booking link: %s', 'quote notification', 'agencecinq' ), $booking ) : '',
					)
				),
				array( 'Reply-To: ' . $email )
			);
		}

		return $sent;
	}

	/**
	 * The booking page with the composition, as the configurator form sends it.
	 * Only a page of this site: the link ends up in a mail sent from our domain.
	 *
	 * @param string               $url         Booking page from the block.
	 * @param array<string, mixed> $composition Checked composition.
	 * @return string Empty when the URL is not on this site.
	 */
	private static function booking_url( string $url, array $composition ): string {
		$url = wp_validate_redirect( esc_url_raw( $url ), '' );

		if ( '' === $url ) {
			return '';
		}

		$package = $composition['package'];

		return add_query_arg(
			array(
				'plateforme' => rawurlencode( $package['category']['id'] ?? '' ),
				'socle'      => rawurlencode( Composition::package_value( $composition ) ),
				'modules'    => array_map( 'rawurlencode', Composition::module_ids( $composition ) ),
			),
			$url
		);
	}

	/**
	 * Counts the requests of this IP over the hour. The IP is hashed, never stored.
	 *
	 * @return bool False once the limit is reached.
	 */
	private static function within_rate_limit(): bool {
		$ip    = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
		$key   = 'agencecinq_quote_' . substr( wp_hash( $ip ), 0, 20 );
		$count = (int) get_transient( $key );

		if ( $count >= self::RATE_LIMIT ) {
			return false;
		}

		set_transient( $key, $count + 1, HOUR_IN_SECONDS );

		return true;
	}

	/**
	 * Who gets the copies, overridable from wp-config.
	 *
	 * @return string
	 */
	private static function recipient(): string {
		if ( defined( 'CINQ_QUOTE_RECIPIENT' ) && is_string( CINQ_QUOTE_RECIPIENT ) ) {
			return CINQ_QUOTE_RECIPIENT;
		}

		return (string) get_option( 'admin_email' );
	}
}
