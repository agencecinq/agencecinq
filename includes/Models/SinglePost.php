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
		return cinq_estimate_reading_time( (string) $this->post_content );
	}
}
