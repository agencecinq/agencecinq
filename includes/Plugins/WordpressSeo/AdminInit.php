<?php
/**
 * Admin Init
 *
 * @package AgenceCinq
 * @subpackage AgenceCinq/Plugins/Yoast
 */

namespace AgenceCinq\Plugins\WordpressSeo;

use AgenceCinq\Service;
use WP_Post;

/**
 * Admin Init
 *
 * Initializes the admin area.
 */
class AdminInit implements Service {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run(): void {
		add_filter( 'wpseo_breadcrumb_links', array( $this, 'breadcrumb_links' ) );
		add_filter( 'wpseo_metadesc', array( $this, 'author_description' ) );
	}

	/**
	 * Describes an author archive by the biography of the author, unless Yoast has a description for it.
	 *
	 * @param string $description Meta description from Yoast.
	 *
	 * @return string
	 */
	public function author_description( $description ): string {
		if ( $description || ! is_author() ) {
			return (string) $description;
		}

		return wp_strip_all_tags( get_the_author_meta( 'description', get_queried_object_id() ) );
	}

	/**
	 * Ensure Yoast breadcrumb includes all page ancestors (parent, grandparent, etc.).
	 *
	 * @param array $crumbs Breadcrumb links from Yoast (each item: url, text, optional id).
	 *
	 * @return array
	 */
	public function breadcrumb_links( array $crumbs ): array {
		if ( ! is_singular( 'page' ) || empty( $crumbs ) ) {
			return $crumbs;
		}

		$post = get_queried_object();
		if ( ! $post instanceof WP_Post ) {
			return $crumbs;
		}

		$ancestor_ids = get_post_ancestors( $post->ID );
		if ( empty( $ancestor_ids ) ) {
			return $crumbs;
		}

		// From root to direct parent (Yoast returns parent first, then grandparent, etc.).
		$ancestor_ids = array_reverse( $ancestor_ids );

		$ancestor_crumbs = array();
		foreach ( $ancestor_ids as $ancestor_id ) {
			$ancestor = get_post( $ancestor_id );
			if ( $ancestor instanceof WP_Post && 'publish' === $ancestor->post_status ) {
				$ancestor_crumbs[] = array(
					'url'  => get_permalink( $ancestor ),
					'text' => get_the_title( $ancestor ),
					'id'   => $ancestor->ID,
				);
			}
		}

		if ( empty( $ancestor_crumbs ) ) {
			return $crumbs;
		}

		// Insert ancestors between first crumb (home) and last crumb (current page).
		$first = array_slice( $crumbs, 0, 1 );
		$last  = array_slice( $crumbs, -1, 1 );

		return array_merge( $first, $ancestor_crumbs, $last );
	}
}
