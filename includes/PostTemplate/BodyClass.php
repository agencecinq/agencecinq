<?php
/**
 * BodyClass
 *
 * Addd custom body classes to the current post or page.
 *
 * @package WPCinquanteEtUn
 * @subpackage WPCinquanteEtUn/PostTemplate
 * @see https://developer.wordpress.org/reference/hooks/body_class/
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace WPCinquanteEtUn\PostTemplate;

use WPCinquanteEtUn\Service;

/**
 * BodyClass
 *
 * @see https://developer.wordpress.org/reference/hooks/body_class/
 *
 * @package WPCinquanteEtUn
 * @subpackage WPCinquanteEtUn/PostTemplate
 */
class BodyClass implements Service {

	/**
	 * Run default hooks and actions for WordPress
	 *
	 * @return void
	 */
	public function run(): void {
		add_filter( 'body_class', array( $this, 'body_classes' ), 10, 2 );
	}


	/**
	 * Filters the list of CSS body class names for the current post or page.
	 *
	 * Note that the filter function must return the array of classes after
	 * it is finished processing, or all of the classes will be cleared and
	 * could seriously impact the visual state of a user’s site.
	 *
	 * @param string[] $classes             An array of body class names.
	 * @param string[] $additional_classes An array of additional class names added to the body.
	 *
	 * @return array
	 */
	public function body_classes( array $classes, array $additional_classes ): array {
		return $classes;
	}
}
