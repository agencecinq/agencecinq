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
	 * Estimated reading time in minutes (minimum 1 when the post has content).
	 *
	 * @return int
	 */
	public function reading_time(): int {
		$content = wp_strip_all_tags( (string) $this->post_content );
		$content = preg_replace( '/\s+/u', ' ', $content ?? '' );
		$content = trim( (string) $content );

		if ( '' === $content ) {
			return 0;
		}

		$words            = count( preg_split( '/\s+/u', $content, -1, PREG_SPLIT_NO_EMPTY ) );
		$words_per_minute = 200;

		return max( 1, (int) ceil( $words / $words_per_minute ) );
	}
}
