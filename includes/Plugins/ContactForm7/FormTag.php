<?php
/**
 * Contact Form 7 Form Tag
 *
 * @package AgenceCinq
 * @subpackage AgenceCinq/Plugins/ContactForm7
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ContactForm7;

use AgenceCinq\Service;

/**
 * Contact Form 7 Form Tag
 *
 * @package AgenceCinq
 * @subpackage AgenceCinq/Plugins/ContactForm7
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */
class FormTag implements Service {

	/**
	 * Runs the plugin.
	 *
	 * @return void
	 */
	public function run(): void {
		add_filter( 'wpcf7_form_elements', array( $this, 'form_elements' ) );
	}

	/**
	 * Replaces the submit input with a button so the arrow can sit beside the label.
	 *
	 * @param string $content Form HTML.
	 * @return string
	 */
	public function form_elements( string $content ): string {
		return (string) preg_replace_callback(
			'/<input\b([^>]*\btype=["\']submit["\'][^>]*)\/?>/i',
			static function ( array $matches ): string {
				$attrs = $matches[1];
				$value = '';

				if ( preg_match( '/\bvalue=(["\'])(.*?)\1/i', $attrs, $value_match ) ) {
					$value = html_entity_decode( $value_match[2], ENT_QUOTES, 'UTF-8' );
					$attrs = preg_replace( '/\s*\bvalue=(["\']).*?\1/i', '', $attrs );
				}

				return sprintf(
					'<button %1$s><span>%2$s</span><span aria-hidden="true">→</span></button>',
					rtrim( (string) $attrs ),
					esc_html( $value )
				);
			},
			$content
		);
	}
}
