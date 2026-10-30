<?php
/**
 * Single Post
 *
 * @package WordPress
 * @subpackage AgenceCinq/Models
 */

namespace AgenceCinq\Models;

use Timber\{ Post, Timber };

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

	/**
	 * Returns the posts to read next: the latest of its categories, without it.
	 *
	 * @param int $count Number of posts.
	 * @return iterable<SinglePost>
	 */
	public function related( int $count = 3 ): iterable {
		return Timber::get_posts(
			array(
				'category__in'        => wp_get_post_categories( $this->ID ),
				'post__not_in'        => array( $this->ID ),
				'posts_per_page'      => $count,
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
			)
		);
	}

	/**
	 * Returns the Signup form block of the page for posts, which also closes every post.
	 *
	 * @return array<string, mixed>|null
	 */
	public function signup_form(): ?array {
		$page_id = absint( get_option( 'page_for_posts' ) );
		$blocks  = $page_id ? get_field( 'blocks', $page_id ) : array();

		foreach ( (array) $blocks as $block ) {
			if ( 'signup_form' === ( $block['acf_fc_layout'] ?? '' ) ) {
				return $block;
			}
		}

		return null;
	}
}
