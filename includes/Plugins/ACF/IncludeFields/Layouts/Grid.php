<?php
/**
 * ACF layout: Grid
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Grid block layout.
 */
class Grid {

	/**
	 * Returns the layout array for the Grid block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_grid',
			'name'       => 'grid',
			'label'      => __( 'Grid', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_grid' ),
				array(
					'key'           => 'field_' . $key . '_grid_color_scheme',
					'label'         => __( 'Color Scheme', 'agencecinq' ),
					'name'          => 'color_scheme',
					'aria-label'    => __( 'Color Scheme', 'agencecinq' ),
					'type'          => 'select',
					'choices'       => array(
						'light' => __( 'Light', 'agencecinq' ),
						'dark'  => __( 'Dark', 'agencecinq' ),
					),
					'default_value' => 'light',
					'return_format' => 'value',
					'wrapper'       => array(
						'width' => 6 * 100 / 12,
					),
				),
				AcfFieldHelpers::radius( $key . '_grid' ),
				array(
					'key'        => 'field_' . $key . '_grid_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_grid_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'          => 'field_' . $key . '_grid_content_items',
							'label'        => __( 'Items', 'agencecinq' ),
							'name'         => 'items',
							'aria-label'   => __( 'Items', 'agencecinq' ),
							'type'         => 'repeater',
							'layout'       => 'block',
							'button_label' => __( 'Add Item', 'agencecinq' ),
							'sub_fields'   => array(
								array(
									'key'             => 'field_' . $key . '_grid_content_items_image',
									'label'           => __( 'Image', 'agencecinq' ),
									'name'            => 'image',
									'aria-label'      => __( 'Image', 'agencecinq' ),
									'type'            => 'image',
									'instructions'    => __( 'If a video is selected, the image will be ignored or used as a poster.', 'agencecinq' ) . ' <em>' . __( 'Optional', 'agencecinq' ) . '</em>.',
									'preview_size'    => 'thumbnail',
									'return_format'   => 'id',
									'parent_repeater' => 'field_' . $key . '_grid_content_items',
									'wrapper'         => array(
										'width' => 6 * 100 / 12,
									),
								),
								array(
									'key'             => 'field_' . $key . '_grid_content_items_video',
									'label'           => __( 'Video', 'agencecinq' ),
									'name'            => 'video',
									'aria-label'      => __( 'Video', 'agencecinq' ),
									'type'            => 'file',
									'parent_repeater' => 'field_' . $key . '_grid_content_items',
									'instructions'    => __( 'Supported formats: mp4, mpeg, avi, ogv, webm, and 3gp.', 'agencecinq' ) . ' <em>' . __( 'Optional', 'agencecinq' ) . '</em>.',
									'return_format'   => 'array',
									'library'         => 'all',
									'mime_types'      => 'mp4,mpeg,avi,ogv,webm,3gp',
									'wrapper'         => array(
										'width' => 6 * 100 / 12,
									),
								),
								array(
									'key'             => 'field_' . $key . '_grid_content_items_object_fit',
									'label'           => __( 'Object Fit', 'agencecinq' ),
									'name'            => 'object_fit',
									'aria-label'      => __( 'Object Fit', 'agencecinq' ),
									'type'            => 'select',
									'choices'         => array(
										'object-cover'   => __( 'Cover', 'agencecinq' ),
										'object-contain' => __( 'Contain', 'agencecinq' ),
									),
									'default_value'   => 'object-cover',
									'parent_repeater' => 'field_' . $key . '_grid_content_items',
									'instructions'    => __( 'Cover fills the area (may crop). Contain fits inside (may show empty space).', 'agencecinq' ),
									'return_format'   => 'value',
								),
								array(
									'key'             => 'field_' . $key . '_grid_content_items_title',
									'label'           => __( 'Title', 'agencecinq' ),
									'name'            => 'title',
									'aria-label'      => __( 'Title', 'agencecinq' ),
									'type'            => 'text',
									'placeholder'     => __( 'Enter the title of the item', 'agencecinq' ),
									'parent_repeater' => 'field_' . $key . '_grid_content_items',
								),
								array(
									'key'             => 'field_' . $key . '_grid_content_items_text',
									'label'           => __( 'Text', 'agencecinq' ),
									'name'            => 'text',
									'aria-label'      => __( 'Text', 'agencecinq' ),
									'type'            => 'textarea',
									'rows'            => 4,
									'new_lines'       => 'br',
									'placeholder'     => __( 'Enter the text of the item', 'agencecinq' ),
									'parent_repeater' => 'field_' . $key . '_grid_content_items',
								),
								array(
									'key'             => 'field_' . $key . '_grid_content_items_link',
									'label'           => __( 'Link', 'agencecinq' ),
									'name'            => 'link',
									'aria-label'      => __( 'Link', 'agencecinq' ),
									'type'            => 'link',
									'instructions'    => '<em>' . __( 'Optional', 'agencecinq' ) . '</em>',
									'placeholder'     => __( 'Enter the URL of the link', 'agencecinq' ),
									'parent_repeater' => 'field_' . $key . '_grid_content_items',
									'wrapper'         => array(
										'width' => 6 * 100 / 12,
									),
								),
								array(
									'key'             => 'field_' . $key . '_grid_content_items_logo',
									'label'           => __( 'Logo', 'agencecinq' ),
									'name'            => 'logo',
									'aria-label'      => __( 'Logo', 'agencecinq' ),
									'type'            => 'image',
									'instructions'    => '<em>' . __( 'Optional', 'agencecinq' ) . '</em>',
									'preview_size'    => 'thumbnail',
									'return_format'   => 'id',
									'parent_repeater' => 'field_' . $key . '_grid_content_items',
									'wrapper'         => array(
										'width' => 6 * 100 / 12,
									),
								),
								array(
									'key'             => 'field_' . $key . '_grid_content_items_background_color',
									'label'           => __( 'Background Color', 'agencecinq' ),
									'name'            => 'background_color',
									'aria-label'      => __( 'Background Color', 'agencecinq' ),
									'type'            => 'select',
									'choices'         => array(
										'bg-blue'  => __( 'Blue', 'agencecinq' ),
										'bg-green'  => __( 'Green', 'agencecinq' ),
										'bg-off-white' => __( 'White', 'agencecinq' ),
										'bg-red/80' => __( 'Red', 'agencecinq' ),
									),
									'default_value'   => 'bg-off-white',
									'parent_repeater' => 'field_' . $key . '_grid_content_items',
									'return_format'   => 'value',
									'wrapper'         => array(
										'width' => 4 * 100 / 12,
									),
								),
								array(
									'key'             => 'field_' . $key . '_grid_content_items_text_color',
									'label'           => __( 'Text Color', 'agencecinq' ),
									'name'            => 'text_color',
									'aria-label'      => __( 'Text Color', 'agencecinq' ),
									'type'            => 'select',
									'choices'         => array(
										'text-blue'  => __( 'Blue', 'agencecinq' ),
										'text-off-white' => __( 'White', 'agencecinq' ),
									),
									'default_value'   => 'text-blue',
									'parent_repeater' => 'field_' . $key . '_grid_content_items',
									'return_format'   => 'value',
									'wrapper'         => array(
										'width' => 4 * 100 / 12,
									),
								),
								array(
									'key'             => 'field_' . $key . '_grid_content_items_fill_color',
									'label'           => __( 'Fill Color', 'agencecinq' ),
									'name'            => 'fill_color',
									'aria-label'      => __( 'Fill Color', 'agencecinq' ),
									'type'            => 'select',
									'choices'         => array(
										'text-green'  => __( 'Green', 'agencecinq' ),
										'text-off-white' => __( 'White', 'agencecinq' ),
									),
									'default_value'   => 'text-green',
									'parent_repeater' => 'field_' . $key . '_grid_content_items',
									'return_format'   => 'value',
									'wrapper'         => array(
										'width' => 4 * 100 / 12,
									),
								),
								array(
									'key'             => 'field_' . $key . '_grid_content_items_column_span',
									'label'           => __( 'Column Span', 'agencecinq' ),
									'name'            => 'column_span',
									'aria-label'      => __( 'Column Span', 'agencecinq' ),
									'type'            => 'select',
									'choices'         => array(
										'lg:col-span-6' => __( 'Full', 'agencecinq' ),
										'lg:col-span-4' => __( 'Two Thirds', 'agencecinq' ),
										'lg:col-span-3' => __( 'Half', 'agencecinq' ),
										'lg:col-span-2' => __( 'One Third', 'agencecinq' ),
									),
									'default_value'   => 'lg:col-span-2',
									'parent_repeater' => 'field_' . $key . '_grid_content_items',
									'wrapper'         => array(
										'width' => 6 * 100 / 12,
									),
								),
								array(
									'key'             => 'field_' . $key . '_grid_content_items_row_span',
									'label'           => __( 'Row Span', 'agencecinq' ),
									'name'            => 'row_span',
									'aria-label'      => __( 'Row Span', 'agencecinq' ),
									'type'            => 'select',
									'choices'         => array(
										'lg:row-span-2' => __( 'Double', 'agencecinq' ),
										'lg:row-span-1' => __( 'Single', 'agencecinq' ),
									),
									'default_value'   => 'lg:row-span-1',
									'parent_repeater' => 'field_' . $key . '_grid_content_items',
									'wrapper'         => array(
										'width' => 6 * 100 / 12,
									),
								),
							),
						),
					),
				),
			),
		);
	}
}
