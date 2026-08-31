<?php
/**
 * Post
 *
 * @package AgenceCinq
 * @subpackage AgenceCinq/Post
 */

namespace AgenceCinq;

use AgenceCinq\Service;

/**
 * Post class
 */
class Post implements Service {

	/**
	 * Runs initialization tasks.
	 *
	 * @access public
	 */
	public function run(): void {
		add_action( 'init', array( $this, 'add_post_type_supports' ) );
	}

	/**
	 * Adds post type supports.
	 *
	 * @access private
	 */
	public function add_post_type_supports(): void {
		add_post_type_support( 'page', 'excerpt' );
	}
}
