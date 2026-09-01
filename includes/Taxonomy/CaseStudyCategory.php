<?php
/**
 * Case study category taxonomy
 *
 * @package AgenceCinq
 * @subpackage AgenceCinq/Taxonomy
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Taxonomy;

use AgenceCinq\Service;
use Timber\Timber;

/**
 * CaseStudyCategory class
 *
 * Hierarchical taxonomy for the Case study post type (category-like).
 */
class CaseStudyCategory implements Service {

	/**
	 * Taxonomy slug.
	 *
	 * Prefixed with the post type so it never collides with the reserved `category` taxonomy.
	 *
	 * @var string
	 */
	public const TAXONOMY = 'case_study_category';

	/**
	 * Runs initialization tasks.
	 *
	 * @access public
	 */
	public function run(): void {
		add_action( 'init', array( $this, 'register_taxonomy' ) );
	}

	/**
	 * Returns case study category terms.
	 *
	 * @param bool $hide_empty Whether to hide empty terms.
	 * @return mixed Term collection.
	 */
	public static function terms( bool $hide_empty = true ) {
		return Timber::get_terms(
			array(
				'taxonomy'   => self::TAXONOMY,
				'hide_empty' => $hide_empty,
			)
		);
	}

	/**
	 * Registers the Case study category taxonomy.
	 *
	 * @return void
	 */
	public function register_taxonomy(): void {
		$labels = array(
			'name'                       => _x( 'Categories', 'taxonomy general name', 'agencecinq' ),
			'singular_name'              => _x( 'Category', 'taxonomy singular name', 'agencecinq' ),
			'menu_name'                  => __( 'Categories', 'agencecinq' ),
			'search_items'               => __( 'Search Categories', 'agencecinq' ),
			'popular_items'              => __( 'Popular Categories', 'agencecinq' ),
			'all_items'                  => __( 'All Categories', 'agencecinq' ),
			'parent_item'                => __( 'Parent Category', 'agencecinq' ),
			'parent_item_colon'          => __( 'Parent Category:', 'agencecinq' ),
			'edit_item'                  => __( 'Edit Category', 'agencecinq' ),
			'view_item'                  => __( 'View Category', 'agencecinq' ),
			'update_item'                => __( 'Update Category', 'agencecinq' ),
			'add_new_item'               => __( 'Add New Category', 'agencecinq' ),
			'new_item_name'              => __( 'New Category Name', 'agencecinq' ),
			'separate_items_with_commas' => __( 'Separate categories with commas', 'agencecinq' ),
			'add_or_remove_items'        => __( 'Add or remove categories', 'agencecinq' ),
			'choose_from_most_used'      => __( 'Choose from the most used categories', 'agencecinq' ),
			'not_found'                  => __( 'No categories found.', 'agencecinq' ),
			'no_terms'                   => __( 'No categories', 'agencecinq' ),
			'filter_by_item'             => __( 'Filter by category', 'agencecinq' ),
			'items_list_navigation'      => __( 'Categories list navigation', 'agencecinq' ),
			'items_list'                 => __( 'Categories list', 'agencecinq' ),
			'most_used'                  => _x( 'Most Used', 'categories', 'agencecinq' ),
			'back_to_items'              => __( '&larr; Go to Categories', 'agencecinq' ),
			'item_link'                  => __( 'Category Link', 'agencecinq' ),
			'item_link_description'      => __( 'A link to a category.', 'agencecinq' ),
		);

		register_taxonomy(
			self::TAXONOMY,
			array( 'case-study' ),
			array(
				'labels'             => $labels,
				'description'        => __( 'Categories for case studies.', 'agencecinq' ),
				'public'             => true,
				'publicly_queryable' => true,
				'hierarchical'       => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'show_in_nav_menus'  => true,
				'show_in_rest'       => true,
				'show_admin_column'  => true,
				'show_tagcloud'      => false,
				'show_in_quick_edit' => true,
				'query_var'          => true,
				'rewrite'            => array(
					'slug'         => 'case-study-category',
					'with_front'   => false,
					'hierarchical' => true,
				),
			)
		);
	}
}
