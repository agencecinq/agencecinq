<?php
/**
 * Contact Form 7 Form Tag
 *
 * @package WPCinquanteEtUn
 * @subpackage WPCinquanteEtUn/Plugins/ContactForm7
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace WPCinquanteEtUn\Plugins\ContactForm7;

use WPCinquanteEtUn\Service;

/**
 * Contact Form 7 Form Tag
 *
 * @package WPCinquanteEtUn
 * @subpackage WPCinquanteEtUn/Plugins/ContactForm7
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */
class FormTag implements Service {

	/**
	 * Runs the plugin.
	 *
	 * @return void
	 */
	public function run(): void {
		add_filter( 'wpcf7_form_tag', array( $this, 'form_tag' ) );
	}

	/**
	 * Form tag filter.
	 *
	 * Use [select domaine] in your form to populate the select with the choices from the theme options.
	 *
	 * @param array $tag The form tag (array in CF7 5.8+).
	 * @return array The form tag.
	 */
	public function form_tag( array $tag ): array {
		if ( 'select' !== ( $tag['basetype'] ?? '' ) || 'domaine' !== ( $tag['name'] ?? '' ) ) {
			return $tag;
		}

		$theme   = get_field( 'theme', 'option' );
		$choices = $theme['footer']['push']['choices'] ?? '';

		if ( ! $choices ) {
			return $tag;
		}

		$lines  = preg_split( "/\r\n|\r|\n/", $choices );
		$values = array();
		$labels = array();

		foreach ( $lines as $line ) {
			$line = trim( $line );

			if ( '' === $line ) {
				continue;
			}

			$labels[] = $line;
			// Match the Twig |sanitize filter used for the footer radio values.
			$values[] = sanitize_title( $line );
		}

		if ( empty( $values ) ) {
			return $tag;
		}

		$placeholder = __( 'Choose a domain', 'wp-cinquante-et-un' );

		array_unshift( $labels, $placeholder );
		array_unshift( $values, '' );

		$tag['values']     = $values;
		$tag['labels']     = $labels;
		$tag['raw_values'] = $values;

		// Pre-select option from URL param (e.g. ?domaine=Value) using CF7 helper.
		$parameter = '';

		if ( function_exists( 'wpcf7_superglobal_get' ) ) {
			$values = wpcf7_superglobal_get( 'domaine' );

			if ( is_array( $values ) && isset( $values[0] ) ) {
				$parameter = $values[0];
			} elseif ( is_string( $values ) ) {
				$parameter = $values;
			}
		}

		$value = '' !== $parameter ? sanitize_title( $parameter ) : '';

		if ( '' !== $value && in_array( $value, $tag['values'], true ) ) {
			$tag['options']   = $tag['options'] ?? array();
			$tag['options'][] = 'default:get';
		}

		return $tag;
	}
}
