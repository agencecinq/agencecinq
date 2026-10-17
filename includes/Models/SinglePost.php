<?php
/**
 * Single Post
 *
 * @package WordPress
 * @subpackage AgenceCinq/Models
 */

namespace AgenceCinq\Models;

use Timber\{ Post };

/**
 * Single Post
 *
 * Custom model for single post pages.
 *
 * @package WordPress
 * @subpackage AgenceCinq/Models
 */
class SinglePost extends Post {

	/**
	 * Estimated reading time in minutes, from the cinq-wp-reading-time mu-plugin.
	 *
	 * @return int 0 when the plugin is missing or the content is empty.
	 */
	public function reading_time(): int {
		return function_exists( 'cinq_wp_reading_time' ) ? cinq_wp_reading_time( $this->ID ) : 0;
	}
}
