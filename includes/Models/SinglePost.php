<?php
/**
 * Single Post
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn/Models
 */

namespace WPCinquanteEtUn\Models;

use Timber\{ Timber, Post, PostCollectionInterface };

/**
 * Single Post
 *
 * Custom model for single post pages.
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn/Models
 */
class SinglePost extends Post {

	/**
	 * Generates and returns the table of contents for a single post.
	 *
	 * This function scans the post content for headings and builds a structured
	 * table of contents, which can be used for easy navigation within the post.
	 *
	 * @return array An array representing the table of contents, with each entry containing the title and anchor.
	 */
	public function table_of_contents(): array {
		$content           = $this->post_content;
		$matches           = array();
		$table_of_contents = array();
		$updated_content   = $content;
		$used_anchors      = array();

		// Find all h2 and h3 headings.
		preg_match_all( '/<(h2|h3)\b[^>]*>(.*?)<\/\1>/is', $content, $matches, PREG_SET_ORDER );

		$h2 = null;

		foreach ( $matches as $match ) {
			$tag   = strtolower( $match[1] );
			$title = wp_strip_all_tags( $match[2] );
			$base  = sanitize_title( $title );

			if ( empty( $title ) || empty( $base ) ) {
				continue; // Skip empty titles.
			}

			// Ensure unique anchor (WordPress-style: base, base-2, base-3…).
			$anchor = $base;
			if ( isset( $used_anchors[ $anchor ] ) ) {
				$used_anchors[ $anchor ] += 1;
				$anchor                   = $base . '-' . $used_anchors[ $anchor ];
			} else {
				$used_anchors[ $anchor ] = 1;
			}

			// Replace only the first occurrence to avoid duplicate IDs when the same heading appears twice.
			$heading = sprintf( '<%1$s id="%2$s">%3$s</%1$s>', $tag, esc_attr( $anchor ), $match[2] );
			$pos     = strpos( $updated_content, $match[0] );
			if ( false !== $pos ) {
				$updated_content = substr_replace( $updated_content, $heading, $pos, strlen( $match[0] ) );
			}

			if ( 'h2' === $tag ) {
				$h2                  = array(
					'title'    => $title,
					'anchor'   => $anchor,
					'tag'      => $tag,
					'children' => array(),
				);
				$table_of_contents[] = $h2;
			} elseif ( 'h3' === $tag ) {
				if ( $h2 && ! empty( $table_of_contents ) ) {
					$table_of_contents[ count( $table_of_contents ) - 1 ]['children'][] = array(
						'title'  => $title,
						'anchor' => $anchor,
						'tag'    => $tag,
					);
				} else {
					$table_of_contents[] = array(
						'title'    => $title,
						'anchor'   => $anchor,
						'tag'      => $tag,
						'children' => array(),
					);
				}
			}
		}

		// Update the post content with headings with IDs.
		$this->content = apply_filters( 'the_content', $updated_content );

		return $table_of_contents;
	}


	/**
	 * Generates and returns the shareable URL for the current post.
	 *
	 * @return string The URL that can be used to share the post.
	 */
	public function share_url(): string {
		return 'mailto:?subject=' . pll__( 'I wanted you to see this post' ) . '&amp;body=' . pll__( 'Check out this post' ) . ' ' . $this->link . '.'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}


	/**
	 * Retrieves related posts for the current post.
	 *
	 * This method fetches posts that are related to the current post,
	 * typically based on shared categories, tags, or other criteria.
	 *
	 * @return PostCollectionInterface|null A collection of related posts or `null` if none are found.
	 */
	public function related_posts(): PostCollectionInterface|null {
		$categories = wp_get_post_categories( $this->ID, array( 'fields' => 'ids' ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.wp_get_post_categories_wp_get_post_categories

		$args = array(
			'post_type'      => 'post',
			'posts_per_page' => 3,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'post__not_in'   => array( $this->ID ), // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_post__not_in
			'category__in'   => $categories,
		);

		$posts = Timber::get_posts( $args );

		if ( 0 === count( $posts ) ) {
			$args = array(
				'post_type'      => 'post',
				'posts_per_page' => 3,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'post__not_in'   => array( $this->ID ), // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_post__not_in
			);

			return Timber::get_posts( $args );
		}

		return $posts;
	}
}
