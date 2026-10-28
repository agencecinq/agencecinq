<?php
/**
 * ACF admin enqueue scripts
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/Input
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\Input;

use AgenceCinq\Service;

/**
 * Admin enqueue scripts
 *
 * Swatches on the color scheme button groups of the ACF screens.
 */
class AdminEnqueueScripts implements Service {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run(): void {
		add_action( 'acf/input/admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
	}

	/**
	 * Enqueues the color scheme swatches.
	 *
	 * @return void
	 */
	public function admin_enqueue_scripts(): void {
		wp_register_style( 'agencecinq-acf-swatches', false, array(), wp_get_theme()->get( 'Version' ) );
		wp_enqueue_style( 'agencecinq-acf-swatches' );
		wp_add_inline_style( 'agencecinq-acf-swatches', $this->swatches_css() );
	}

	/**
	 * Swatches on the `color_scheme` button groups: an « A » in the text color of the scheme, on its
	 * background, from includes/schemes.php.
	 *
	 * @return string CSS.
	 */
	private function swatches_css(): string {
		$labels = ".acf-field[data-name='color_scheme'] .acf-button-group label";
		$css    = $labels . '{display:inline-flex;align-items:center;gap:.4em}'
			. $labels . "::before{content:'A';width:1.25rem;height:1.25rem;flex-shrink:0;display:inline-flex;align-items:center;justify-content:center;border:1px solid rgba(0,0,0,.2);box-sizing:border-box;font:700 .6875rem/1 ui-sans-serif,system-ui,sans-serif}";

		foreach ( array_keys( cinq_schemes() ) as $slug ) {
			$css .= sprintf(
				"%s:has(input[value='%s'])::before{background:%s;color:%s}",
				$labels,
				$slug,
				cinq_scheme_color( $slug, 'background-color-default' ),
				cinq_scheme_color( $slug, 'text-color-primary' )
			);
		}

		return $css;
	}
}
