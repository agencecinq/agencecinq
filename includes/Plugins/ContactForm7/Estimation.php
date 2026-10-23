<?php
/**
 * Contact Form 7 Estimation
 *
 * @package AgenceCinq
 * @subpackage AgenceCinq/Plugins/ContactForm7
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ContactForm7;

use AgenceCinq\Catalogue\Composition;
use AgenceCinq\Service;
use WPCF7_ContactForm;
use WPCF7_Mail;
use WPCF7_Submission;

/**
 * Contact Form 7 Estimation
 *
 * Carries the composition chosen in the configurator block to the booking form.
 * The block sends it as a GET (?socle=shopify:standard&modules[]=…). Every form gets a
 * hidden cinq_estimation field holding it once checked against the catalogue, and the
 * mail to the site gets the priced composition. Prices are always read from the
 * catalogue: the browser only says what was chosen, never how much it costs.
 *
 * @package AgenceCinq
 * @subpackage AgenceCinq/Plugins/ContactForm7
 */
class Estimation implements Service {

	/**
	 * Hidden field name.
	 */
	private const FIELD = 'cinq_estimation';

	/**
	 * Runs the service.
	 *
	 * @return void
	 */
	public function run(): void {
		add_filter( 'wpcf7_form_hidden_fields', array( $this, 'hidden_fields' ) );
		add_filter( 'wpcf7_mail_components', array( $this, 'mail_components' ), 10, 3 );
	}

	/**
	 * Adds the checked composition to every form.
	 *
	 * @param array<string, string> $fields Hidden fields.
	 * @return array<string, string>
	 */
	public function hidden_fields( array $fields ): array {
		// phpcs:disable WordPress.Security.NonceVerification.Recommended -- Read-only, public choice, checked against the catalogue.
		$package = isset( $_GET['socle'] ) ? sanitize_text_field( wp_unslash( $_GET['socle'] ) ) : '';
		$modules = isset( $_GET['modules'] ) ? array_map( 'sanitize_text_field', (array) wp_unslash( $_GET['modules'] ) ) : array();
		// phpcs:enable WordPress.Security.NonceVerification.Recommended

		if ( '' === $package ) {
			return $fields;
		}

		$composition = Composition::from_choice( $package, $modules );

		if ( null !== $composition ) {
			$fields[ self::FIELD ] = Composition::encode( $composition );
		}

		return $fields;
	}

	/**
	 * Appends the priced composition to the mail the site receives.
	 *
	 * @param array<string, mixed> $components   Mail components.
	 * @param WPCF7_ContactForm    $contact_form Contact form.
	 * @param WPCF7_Mail           $mail         Mail template.
	 * @return array<string, mixed>
	 */
	public function mail_components( array $components, $contact_form, $mail ): array { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundBeforeLastUsed -- Filter signature.
		if ( ! $mail instanceof WPCF7_Mail || 'mail' !== $mail->name() ) {
			return $components;
		}

		$submission = WPCF7_Submission::get_instance();
		$value      = $submission ? $submission->get_posted_string( self::FIELD ) : '';

		if ( '' === $value ) {
			return $components;
		}

		$composition = Composition::decode( $value );

		if ( null === $composition ) {
			return $components;
		}

		$legend = implode( "\n", array( __( 'Configurator estimate', 'agencecinq' ), ...Composition::lines( $composition ) ) );

		$components['body'] .= $mail->get( 'use_html' )
			? '<p>' . nl2br( esc_html( $legend ) ) . '</p>'
			: "\n\n" . $legend;

		return $components;
	}
}
