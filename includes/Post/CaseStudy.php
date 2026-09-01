<?php
/**
 * Case Study post type
 *
 * @package AgenceCinq
 * @subpackage AgenceCinq/Post
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Post;

use AgenceCinq\Service;

/**
 * CaseStudy class
 */
class CaseStudy implements Service {

	/**
	 * Post type slug.
	 *
	 * @var string
	 */
	public const POST_TYPE = 'case-study';

	/**
	 * Runs initialization tasks.
	 *
	 * @access public
	 */
	public function run(): void {
		add_action( 'init', array( $this, 'register_post_type' ) );
	}

	/**
	 * Registers the Case study post type.
	 *
	 * @return void
	 */
	public function register_post_type(): void {
		$labels = array(
			'name'                     => _x( 'Case studies', 'Post type general name', 'agencecinq' ),
			'singular_name'            => _x( 'Case study', 'Post type singular name', 'agencecinq' ),
			'menu_name'                => _x( 'Case studies', 'Admin Menu text', 'agencecinq' ),
			'name_admin_bar'           => _x( 'Case study', 'Add New on Toolbar', 'agencecinq' ),
			'add_new'                  => __( 'Add New', 'agencecinq' ),
			'add_new_item'             => __( 'Add New Case study', 'agencecinq' ),
			'new_item'                 => __( 'New Case study', 'agencecinq' ),
			'edit_item'                => __( 'Edit Case study', 'agencecinq' ),
			'view_item'                => __( 'View Case study', 'agencecinq' ),
			'view_items'               => __( 'View Case studies', 'agencecinq' ),
			'all_items'                => __( 'All Case studies', 'agencecinq' ),
			'search_items'             => __( 'Search Case studies', 'agencecinq' ),
			'parent_item_colon'        => __( 'Parent Case study:', 'agencecinq' ),
			'not_found'                => __( 'No case studies found.', 'agencecinq' ),
			'not_found_in_trash'       => __( 'No case studies found in Trash.', 'agencecinq' ),
			'archives'                 => __( 'Case study archives', 'agencecinq' ),
			'attributes'               => __( 'Case study attributes', 'agencecinq' ),
			'insert_into_item'         => __( 'Insert into case study', 'agencecinq' ),
			'uploaded_to_this_item'    => __( 'Uploaded to this case study', 'agencecinq' ),
			'featured_image'           => __( 'Featured image', 'agencecinq' ),
			'set_featured_image'       => __( 'Set featured image', 'agencecinq' ),
			'remove_featured_image'    => __( 'Remove featured image', 'agencecinq' ),
			'use_featured_image'       => __( 'Use as featured image', 'agencecinq' ),
			'filter_items_list'        => __( 'Filter case studies list', 'agencecinq' ),
			'items_list_navigation'    => __( 'Case studies list navigation', 'agencecinq' ),
			'items_list'               => __( 'Case studies list', 'agencecinq' ),
			'item_published'           => __( 'Case study published.', 'agencecinq' ),
			'item_published_privately' => __( 'Case study published privately.', 'agencecinq' ),
			'item_reverted_to_draft'   => __( 'Case study reverted to draft.', 'agencecinq' ),
			'item_trashed'             => __( 'Case study trashed.', 'agencecinq' ),
			'item_scheduled'           => __( 'Case study scheduled.', 'agencecinq' ),
			'item_updated'             => __( 'Case study updated.', 'agencecinq' ),
			'item_link'                => __( 'Case study Link', 'agencecinq' ),
			'item_link_description'    => __( 'A link to a case study.', 'agencecinq' ),
		);

		register_post_type(
			self::POST_TYPE,
			array(
				'labels'              => $labels,
				'label'               => __( 'Case study', 'agencecinq' ),
				'description'         => __( 'Case studies', 'agencecinq' ),
				'public'              => true,
				'hierarchical'        => false,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'show_in_rest'        => true,
				'menu_position'       => 21,
				'menu_icon'           => 'dashicons-portfolio',
				'capability_type'     => 'post',
				'supports'            => array( 'title', 'thumbnail', 'excerpt', 'revisions', 'page-attributes' ),
				'has_archive'         => true,
				'rewrite'             => array(
					'slug'       => 'case-study',
					'with_front' => false,
				),
				'query_var'           => true,
				'can_export'          => true,
				'delete_with_user'    => false,
			)
		);
	}
}
