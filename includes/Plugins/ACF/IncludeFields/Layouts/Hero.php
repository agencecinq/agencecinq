<?php
/**
 * ACF layout: Hero
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn/Plugins/ACF/IncludeFields/Layouts
 */

namespace WPCinquanteEtUn\Plugins\ACF\IncludeFields\Layouts;

use WPCinquanteEtUn\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Hero block layout.
 */
class Hero {

	/**
	 * Returns the layout array for the Hero block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_hero',
			'name'       => 'hero',
			'label'      => __( 'Hero', 'wp-cinquante-et-un' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_hero' ),
				...AcfFieldHelpers::media( $key . '_hero' ),
				array(
					'key'        => 'field_' . $key . '_hero_content_tab',
					'label'      => __( 'Content', 'wp-cinquante-et-un' ),
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_hero_content',
					'label'      => __( 'Content', 'wp-cinquante-et-un' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'           => 'field_' . $key . '_hero_content_title',
							'label'         => __( 'Title', 'wp-cinquante-et-un' ),
							'name'          => 'title',
							'aria-label'    => __( 'Title', 'wp-cinquante-et-un' ),
							'type'          => 'text',
							'placeholder'   => __( 'Enter the title of the block', 'wp-cinquante-et-un' ),
							'default_value' => '',
						),
						array(
							'key'        => 'field_' . $key . '_hero_content_heading',
							'label'      => __( 'Heading', 'wp-cinquante-et-un' ),
							'name'       => 'heading',
							'aria-label' => __( 'Heading', 'wp-cinquante-et-un' ),
							'type'       => 'clone',
							'clone'      => array( 'field_clones_heading' ),
							'display'    => 'seamless',
							'layout'     => 'block',
						),
						array(
							'key'           => 'field_' . $key . '_hero_content_link',
							'label'         => __( 'Link', 'wp-cinquante-et-un' ),
							'name'          => 'link',
							'aria-label'    => __( 'Link', 'wp-cinquante-et-un' ),
							'type'          => 'link',
							'placeholder'   => __( 'Enter the URL of the link', 'wp-cinquante-et-un' ),
							'default_value' => '',
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_hero_footer_tab',
					'label'      => __( 'Footer', 'wp-cinquante-et-un' ),
					'aria-label' => __( 'Footer', 'wp-cinquante-et-un' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_hero_footer',
					'label'      => __( 'Footer', 'wp-cinquante-et-un' ),
					'name'       => 'footer',
					'aria-label' => __( 'Footer', 'wp-cinquante-et-un' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'          => 'field_' . $key . '_hero_footer_items',
							'label'        => __( 'Items', 'wp-cinquante-et-un' ),
							'name'         => 'items',
							'aria-label'   => __( 'Items', 'wp-cinquante-et-un' ),
							'type'         => 'repeater',
							'instructions' => __( 'Add up to 3 items. Leave empty to hide the footer.', 'wp-cinquante-et-un' ),
							'layout'       => 'block',
							'max'          => 3,
							'button_label' => __( 'Add Item', 'wp-cinquante-et-un' ),
							'sub_fields'   => array(
								array(
									'key'     => 'field_' . $key . '_hero_footer_items_image',
									'label'   => __( 'Image', 'wp-cinquante-et-un' ),
									'name'    => 'image',
									'aria-label' => __( 'Image', 'wp-cinquante-et-un' ),
									'type'    => 'image',
									'instructions' => '<em>' . __( 'Optional', 'wp-cinquante-et-un' ) . '</em>',
									'wrapper' => array(
										'width' => 4 * 100 / 12,
									),
									'preview_size' => 'thumbnail',
									'return_format' => 'id',
									'parent_repeater' => 'field_' . $key . '_hero_footer_items',
								),
								array(
									'key'     => 'field_' . $key . '_hero_footer_items_title',
									'label'   => __( 'Title', 'wp-cinquante-et-un' ),
									'name'    => 'title',
									'aria-label' => __( 'Title', 'wp-cinquante-et-un' ),
									'type'    => 'text',
									'wrapper' => array(
										'width' => 8 * 100 / 12,
									),
									'placeholder' => __( 'Enter the title of the item', 'wp-cinquante-et-un' ),
									'parent_repeater' => 'field_' . $key . '_hero_footer_items',
								),
							),
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_hero_featured_posts_tab',
					'label'      => __( 'Featured Posts', 'wp-cinquante-et-un' ),
					'aria-label' => __( 'Featured Posts', 'wp-cinquante-et-un' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_hero_featured_posts',
					'label'      => __( 'Featured Posts', 'wp-cinquante-et-un' ),
					'name'       => 'featured_posts',
					'aria-label' => __( 'Featured Posts', 'wp-cinquante-et-un' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'           => 'field_' . $key . '_hero_featured_posts_posts',
							'label'         => __( 'Posts', 'wp-cinquante-et-un' ),
							'name'          => 'posts',
							'aria-label'    => __( 'Posts', 'wp-cinquante-et-un' ),
							'type'          => 'relationship',
							'post_type'     => 'post',
							'multiple'      => true,
							'return_format' => 'id',
						),
					),
				),
			),
		);
	}
}
