<?php
/**
 * ACF layout: Hero
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

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
			'label'      => __( 'Hero', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_hero' ),
				...AcfFieldHelpers::media( $key . '_hero' ),
				array(
					'key'        => 'field_' . $key . '_hero_content_tab',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_hero_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'           => 'field_' . $key . '_hero_content_title',
							'label'         => __( 'Title', 'agencecinq' ),
							'name'          => 'title',
							'aria-label'    => __( 'Title', 'agencecinq' ),
							'type'          => 'text',
							'placeholder'   => __( 'Enter the title of the block', 'agencecinq' ),
							'default_value' => '',
						),
						array(
							'key'        => 'field_' . $key . '_hero_content_heading',
							'label'      => __( 'Heading', 'agencecinq' ),
							'name'       => 'heading',
							'aria-label' => __( 'Heading', 'agencecinq' ),
							'type'       => 'clone',
							'clone'      => array( 'field_clones_heading' ),
							'display'    => 'seamless',
							'layout'     => 'block',
						),
						array(
							'key'           => 'field_' . $key . '_hero_content_link',
							'label'         => __( 'Link', 'agencecinq' ),
							'name'          => 'link',
							'aria-label'    => __( 'Link', 'agencecinq' ),
							'type'          => 'link',
							'placeholder'   => __( 'Enter the URL of the link', 'agencecinq' ),
							'default_value' => '',
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_hero_footer_tab',
					'label'      => __( 'Footer', 'agencecinq' ),
					'aria-label' => __( 'Footer', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_hero_footer',
					'label'      => __( 'Footer', 'agencecinq' ),
					'name'       => 'footer',
					'aria-label' => __( 'Footer', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'          => 'field_' . $key . '_hero_footer_items',
							'label'        => __( 'Items', 'agencecinq' ),
							'name'         => 'items',
							'aria-label'   => __( 'Items', 'agencecinq' ),
							'type'         => 'repeater',
							'instructions' => __( 'Add up to 3 items. Leave empty to hide the footer.', 'agencecinq' ),
							'layout'       => 'block',
							'max'          => 3,
							'button_label' => __( 'Add Item', 'agencecinq' ),
							'sub_fields'   => array(
								array(
									'key'     => 'field_' . $key . '_hero_footer_items_image',
									'label'   => __( 'Image', 'agencecinq' ),
									'name'    => 'image',
									'aria-label' => __( 'Image', 'agencecinq' ),
									'type'    => 'image',
									'instructions' => '<em>' . __( 'Optional', 'agencecinq' ) . '</em>',
									'wrapper' => array(
										'width' => 4 * 100 / 12,
									),
									'preview_size' => 'thumbnail',
									'return_format' => 'id',
									'parent_repeater' => 'field_' . $key . '_hero_footer_items',
								),
								array(
									'key'     => 'field_' . $key . '_hero_footer_items_title',
									'label'   => __( 'Title', 'agencecinq' ),
									'name'    => 'title',
									'aria-label' => __( 'Title', 'agencecinq' ),
									'type'    => 'text',
									'wrapper' => array(
										'width' => 8 * 100 / 12,
									),
									'placeholder' => __( 'Enter the title of the item', 'agencecinq' ),
									'parent_repeater' => 'field_' . $key . '_hero_footer_items',
								),
							),
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_hero_featured_posts_tab',
					'label'      => __( 'Featured Posts', 'agencecinq' ),
					'aria-label' => __( 'Featured Posts', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_hero_featured_posts',
					'label'      => __( 'Featured Posts', 'agencecinq' ),
					'name'       => 'featured_posts',
					'aria-label' => __( 'Featured Posts', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'           => 'field_' . $key . '_hero_featured_posts_posts',
							'label'         => __( 'Posts', 'agencecinq' ),
							'name'          => 'posts',
							'aria-label'    => __( 'Posts', 'agencecinq' ),
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
