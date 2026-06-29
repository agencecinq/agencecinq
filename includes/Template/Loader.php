<?php
/**
 * Loader
 *
 * Handles loading and redirecting template-related functionality.
 *
 * @package WPCinquanteEtUn
 * @subpackage WPCinquanteEtUn/Template
 * @see https://developer.wordpress.org/reference/hooks/template_redirect/
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace WPCinquanteEtUn\Template;

use WPCinquanteEtUn\Service;

/**
 * Handles loading and redirecting template-related functionality.
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn
 */
class Loader implements Service {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run(): void {
		add_action( 'template_redirect', array( $this, 'template_redirect' ) );
	}

	/**
	 * Redirect templates as needed.
	 *
	 * @return void
	 */
	public function template_redirect() {
	}
}
