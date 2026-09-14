<?php
/**
 * Post States
 *
 * @package AgenceCinq
 * @subpackage AgenceCinq/Template
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Template;

use AgenceCinq\Service;
use AgenceCinq\Taxonomy\PageCat;
use WP_Post;

/**
 * PostStates
 *
 * Adds a custom post state to the post/page edit screen.
 *
 * @package AgenceCinq
 */
class PostStates implements Service {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run(): void {
		add_filter( 'display_post_states', array( $this, 'filter_post_states' ), 10, 2 );
	}

	/**
	 * Post states
	 *
	 * Adds a custom post state to the post/page edit screen.
	 *
	 * @param string[] $post_states An array of post display states.
	 * @param WP_Post  $post        The current post object.
	 *
	 * @return array $states
	 */
	public function filter_post_states( array $post_states, WP_Post $post ) {

		$template = get_post_meta( $post->ID, '_wp_page_template', true );

		if ( 'page-templates/blocks-page.php' === $template ) {
			$post_states[] = __( 'Blocks Page', 'agencecinq' );
		}

		if ( 'page-templates/content-page.php' === $template ) {
			$post_states[] = __( 'Content Page', 'agencecinq' );
		}

		return $post_states;
	}
}
