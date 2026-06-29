<?php
/**
 * PostClass
 *
 * Add custom post classes to the current post.
 *
 * @package WPCinquanteEtUn
 * @subpackage WPCinquanteEtUn/PostTemplate
 * @see https://developer.wordpress.org/reference/hooks/post_class/
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace WPCinquanteEtUn\PostTemplate;

use WPCinquanteEtUn\Service;

/**
 * PostClass
 *
 * @see https://developer.wordpress.org/reference/hooks/post_class/
 *
 * @package WPCinquanteEtUn
 * @subpackage WPCinquanteEtUn/PostTemplate
 */
class PostClass implements Service {

	/**
	 * Run default hooks and actions for WordPress
	 *
	 * @return void
	 */
	public function run(): void {
		add_filter( 'post_class', array( $this, 'post_classes' ), 10, 3 );
	}


	/**
	 * Filters the list of CSS class names for the current post.
	 *
	 * @param string[] $classes             An array of post class names.
	 * @param string[] $additional_classes  An array of additional class names added to the post.
	 * @param int      $post_id             The post ID.
	 *
	 * @return array
	 */
	public function post_classes( array $classes, array $additional_classes, int $post_id ): array {
		return $classes;
	}
}
