<?php
/**
 * ACF layout: Grid
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn/Plugins/ACF/IncludeFields/Layouts
 */

namespace WPCinquanteEtUn\Plugins\ACF\IncludeFields\Layouts;

use WPCinquanteEtUn\Plugins\ACF\IncludeFields\AcfFieldHelpers;

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
			'label'      => __( 'Grid', 'wp-cinquante-et-un' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_grid' ),
				array(
					'key'           => 'field_' . $key . '_grid_color_scheme',
					'label'         => __( 'Color Scheme', 'wp-cinquante-et-un' ),
					'name'          => 'color_scheme',
					'aria-label'    => __( 'Color Scheme', 'wp-cinquante-et-un' ),
					'type'          => 'select',
					'choices'       => array(
						'light' => __( 'Light', 'wp-cinquante-et-un' ),
						'dark'  => __( 'Dark', 'wp-cinquante-et-un' ),
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
					'label'      => __( 'Content', 'wp-cinquante-et-un' ),
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_grid_content',
					'label'      => __( 'Content', 'wp-cinquante-et-un' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'          => 'field_' . $key . '_grid_content_items',
							'label'        => __( 'Items', 'wp-cinquante-et-un' ),
							'name'         => 'items',
							'aria-label'   => __( 'Items', 'wp-cinquante-et-un' ),
							'type'         => 'repeater',
							'layout'       => 'block',
							'button_label' => __( 'Add Item', 'wp-cinquante-et-un' ),
							'sub_fields'   => array(
								array(
									'key'             => 'field_' . $key . '_grid_content_items_image',
									'label'           => __( 'Image', 'wp-cinquante-et-un' ),
									'name'            => 'image',
									'aria-label'      => __( 'Image', 'wp-cinquante-et-un' ),
									'type'            => 'image',
									'instructions'    => __( 'If a video is selected, the image will be ignored or used as a poster.', 'wp-cinquante-et-un' ) . ' <em>' . __( 'Optional', 'wp-cinquante-et-un' ) . '</em>.',
									'preview_size'    => 'thumbnail',
									'return_format'   => 'id',
									'parent_repeater' => 'field_' . $key . '_grid_content_items',
									'wrapper'         => array(
										'width' => 6 * 100 / 12,
									),
								),
								array(
									'key'             => 'field_' . $key . '_grid_content_items_video',
									'label'           => __( 'Video', 'wp-cinquante-et-un' ),
									'name'            => 'video',
									'aria-label'      => __( 'Video', 'wp-cinquante-et-un' ),
									'type'            => 'file',
									'parent_repeater' => 'field_' . $key . '_grid_content_items',
									'instructions'    => __( 'Supported formats: mp4, mpeg, avi, ogv, webm, and 3gp.', 'wp-cinquante-et-un' ) . ' <em>' . __( 'Optional', 'wp-cinquante-et-un' ) . '</em>.',
									'return_format'   => 'array',
									'library'         => 'all',
									'mime_types'      => 'mp4,mpeg,avi,ogv,webm,3gp',
									'wrapper'         => array(
										'width' => 6 * 100 / 12,
									),
								),
								array(
									'key'             => 'field_' . $key . '_grid_content_items_object_fit',
									'label'           => __( 'Object Fit', 'wp-cinquante-et-un' ),
									'name'            => 'object_fit',
									'aria-label'      => __( 'Object Fit', 'wp-cinquante-et-un' ),
									'type'            => 'select',
									'choices'         => array(
										'object-cover'   => __( 'Cover', 'wp-cinquante-et-un' ),
										'object-contain' => __( 'Contain', 'wp-cinquante-et-un' ),
									),
									'default_value'   => 'object-cover',
									'parent_repeater' => 'field_' . $key . '_grid_content_items',
									'instructions'    => __( 'Cover fills the area (may crop). Contain fits inside (may show empty space).', 'wp-cinquante-et-un' ),
									'return_format'   => 'value',
								),
								array(
									'key'             => 'field_' . $key . '_grid_content_items_title',
									'label'           => __( 'Title', 'wp-cinquante-et-un' ),
									'name'            => 'title',
									'aria-label'      => __( 'Title', 'wp-cinquante-et-un' ),
									'type'            => 'text',
									'placeholder'     => __( 'Enter the title of the item', 'wp-cinquante-et-un' ),
									'parent_repeater' => 'field_' . $key . '_grid_content_items',
								),
								array(
									'key'             => 'field_' . $key . '_grid_content_items_text',
									'label'           => __( 'Text', 'wp-cinquante-et-un' ),
									'name'            => 'text',
									'aria-label'      => __( 'Text', 'wp-cinquante-et-un' ),
									'type'            => 'textarea',
									'rows'            => 4,
									'new_lines'       => 'br',
									'placeholder'     => __( 'Enter the text of the item', 'wp-cinquante-et-un' ),
									'parent_repeater' => 'field_' . $key . '_grid_content_items',
								),
								array(
									'key'             => 'field_' . $key . '_grid_content_items_link',
									'label'           => __( 'Link', 'wp-cinquante-et-un' ),
									'name'            => 'link',
									'aria-label'      => __( 'Link', 'wp-cinquante-et-un' ),
									'type'            => 'link',
									'instructions'    => '<em>' . __( 'Optional', 'wp-cinquante-et-un' ) . '</em>',
									'placeholder'     => __( 'Enter the URL of the link', 'wp-cinquante-et-un' ),
									'parent_repeater' => 'field_' . $key . '_grid_content_items',
									'wrapper'         => array(
										'width' => 6 * 100 / 12,
									),
								),
								array(
									'key'             => 'field_' . $key . '_grid_content_items_logo',
									'label'           => __( 'Logo', 'wp-cinquante-et-un' ),
									'name'            => 'logo',
									'aria-label'      => __( 'Logo', 'wp-cinquante-et-un' ),
									'type'            => 'image',
									'instructions'    => '<em>' . __( 'Optional', 'wp-cinquante-et-un' ) . '</em>',
									'preview_size'    => 'thumbnail',
									'return_format'   => 'id',
									'parent_repeater' => 'field_' . $key . '_grid_content_items',
									'wrapper'         => array(
										'width' => 6 * 100 / 12,
									),
								),
								array(
									'key'             => 'field_' . $key . '_grid_content_items_background_color',
									'label'           => __( 'Background Color', 'wp-cinquante-et-un' ),
									'name'            => 'background_color',
									'aria-label'      => __( 'Background Color', 'wp-cinquante-et-un' ),
									'type'            => 'select',
									'choices'         => array(
										'bg-bleu'  => __( 'Blue', 'wp-cinquante-et-un' ),
										'bg-vert'  => __( 'Green', 'wp-cinquante-et-un' ),
										'bg-blanc' => __( 'White', 'wp-cinquante-et-un' ),
										'bg-rouge/80' => __( 'Red', 'wp-cinquante-et-un' ),
									),
									'default_value'   => 'bg-blanc',
									'parent_repeater' => 'field_' . $key . '_grid_content_items',
									'return_format'   => 'value',
									'wrapper'         => array(
										'width' => 4 * 100 / 12,
									),
								),
								array(
									'key'             => 'field_' . $key . '_grid_content_items_text_color',
									'label'           => __( 'Text Color', 'wp-cinquante-et-un' ),
									'name'            => 'text_color',
									'aria-label'      => __( 'Text Color', 'wp-cinquante-et-un' ),
									'type'            => 'select',
									'choices'         => array(
										'text-bleu'  => __( 'Blue', 'wp-cinquante-et-un' ),
										'text-blanc' => __( 'White', 'wp-cinquante-et-un' ),
									),
									'default_value'   => 'text-bleu',
									'parent_repeater' => 'field_' . $key . '_grid_content_items',
									'return_format'   => 'value',
									'wrapper'         => array(
										'width' => 4 * 100 / 12,
									),
								),
								array(
									'key'             => 'field_' . $key . '_grid_content_items_fill_color',
									'label'           => __( 'Fill Color', 'wp-cinquante-et-un' ),
									'name'            => 'fill_color',
									'aria-label'      => __( 'Fill Color', 'wp-cinquante-et-un' ),
									'type'            => 'select',
									'choices'         => array(
										'text-vert'  => __( 'Green', 'wp-cinquante-et-un' ),
										'text-blanc' => __( 'White', 'wp-cinquante-et-un' ),
									),
									'default_value'   => 'text-vert',
									'parent_repeater' => 'field_' . $key . '_grid_content_items',
									'return_format'   => 'value',
									'wrapper'         => array(
										'width' => 4 * 100 / 12,
									),
								),
								array(
									'key'             => 'field_' . $key . '_grid_content_items_column_span',
									'label'           => __( 'Column Span', 'wp-cinquante-et-un' ),
									'name'            => 'column_span',
									'aria-label'      => __( 'Column Span', 'wp-cinquante-et-un' ),
									'type'            => 'select',
									'choices'         => array(
										'lg:col-span-6' => __( 'Full', 'wp-cinquante-et-un' ),
										'lg:col-span-4' => __( 'Two Thirds', 'wp-cinquante-et-un' ),
										'lg:col-span-3' => __( 'Half', 'wp-cinquante-et-un' ),
										'lg:col-span-2' => __( 'One Third', 'wp-cinquante-et-un' ),
									),
									'default_value'   => 'lg:col-span-2',
									'parent_repeater' => 'field_' . $key . '_grid_content_items',
									'wrapper'         => array(
										'width' => 6 * 100 / 12,
									),
								),
								array(
									'key'             => 'field_' . $key . '_grid_content_items_row_span',
									'label'           => __( 'Row Span', 'wp-cinquante-et-un' ),
									'name'            => 'row_span',
									'aria-label'      => __( 'Row Span', 'wp-cinquante-et-un' ),
									'type'            => 'select',
									'choices'         => array(
										'lg:row-span-2' => __( 'Double', 'wp-cinquante-et-un' ),
										'lg:row-span-1' => __( 'Single', 'wp-cinquante-et-un' ),
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
