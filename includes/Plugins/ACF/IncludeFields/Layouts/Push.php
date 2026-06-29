<?php
/**
 * ACF layout: Push
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn/Plugins/ACF/IncludeFields/Layouts
 */

namespace WPCinquanteEtUn\Plugins\ACF\IncludeFields\Layouts;

use WPCinquanteEtUn\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Push block layout.
 */
class Push {

	/**
	 * Returns the layout array for the Push block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_push',
			'name'       => 'push',
			'label'      => __( 'Push', 'wp-cinquante-et-un' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_push' ),
				array(
					'key'           => 'field_' . $key . '_push_image_position',
					'label'         => __( 'Image position', 'wp-cinquante-et-un' ),
					'name'          => 'image_position',
					'aria-label'    => __( 'Image position', 'wp-cinquante-et-un' ),
					'type'          => 'select',
					'instructions'  => __( 'Choose which side the image appears on.', 'wp-cinquante-et-un' ),
					'choices'       => array(
						'left'  => __( 'Image on the left', 'wp-cinquante-et-un' ),
						'right' => __( 'Image on the right', 'wp-cinquante-et-un' ),
					),
					'default_value' => 'right',
					'return_format' => 'value',
				),
				...AcfFieldHelpers::media( $key . '_push' ),
				array(
					'key'           => 'field_' . $key . '_push_object_fit',
					'label'         => __( 'Object Fit', 'wp-cinquante-et-un' ),
					'name'          => 'object_fit',
					'aria-label'    => __( 'Object Fit', 'wp-cinquante-et-un' ),
					'type'          => 'select',
					'choices'       => array(
						'object-cover'   => __( 'Cover', 'wp-cinquante-et-un' ),
						'object-contain' => __( 'Contain', 'wp-cinquante-et-un' ),
					),
					'default_value' => 'object-cover',
					'instructions'  => __( 'Cover fills the area (may crop). Contain fits inside (may show empty space).', 'wp-cinquante-et-un' ),
					'return_format' => 'value',
				),
				array(
					'key'        => 'field_' . $key . '_push_content_tab',
					'label'      => __( 'Content', 'wp-cinquante-et-un' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_push_content',
					'name'       => 'content',
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'         => 'field_' . $key . '_push_content_title',
							'label'       => __( 'Title', 'wp-cinquante-et-un' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'wp-cinquante-et-un' ),
							'type'        => 'text',
							'placeholder' => __( 'Enter the title of the content', 'wp-cinquante-et-un' ),
						),
						array(
							'key'         => 'field_' . $key . '_push_content_subtitle',
							'label'       => __( 'Subtitle', 'wp-cinquante-et-un' ),
							'name'        => 'subtitle',
							'aria-label'  => __( 'Subtitle', 'wp-cinquante-et-un' ),
							'type'        => 'text',
							'placeholder' => __( 'Enter the subtitle of the content', 'wp-cinquante-et-un' ),
						),
						array(
							'key'          => 'field_' . $key . '_push_content_text',
							'label'        => __( 'Text', 'wp-cinquante-et-un' ),
							'name'         => 'text',
							'aria-label'   => __( 'Text', 'wp-cinquante-et-un' ),
							'type'         => 'wysiwyg',
							'tabs'         => 'all',
							'toolbar'      => 'basic',
							'media_upload' => 0,
							'placeholder'  => __( 'Enter the text of the content', 'wp-cinquante-et-un' ),
						),
						array(
							'key'          => 'field_' . $key . '_push_content_link',
							'label'        => __( 'Link', 'wp-cinquante-et-un' ),
							'name'         => 'link',
							'aria-label'   => __( 'Link', 'wp-cinquante-et-un' ),
							'type'         => 'link',
							'instructions' => __( 'Enter the link URL.', 'wp-cinquante-et-un' ) . ' <em>(' . __( 'Optional', 'wp-cinquante-et-un' ) . ')</em>.',
						),
						array(
							'key'          => 'field_' . $key . '_push_content_items',
							'label'        => __( 'Items', 'wp-cinquante-et-un' ),
							'name'         => 'items',
							'aria-label'   => __( 'Items', 'wp-cinquante-et-un' ),
							'type'         => 'repeater',
							'layout'       => 'block',
							'button_label' => __( 'Add Item', 'wp-cinquante-et-un' ),
							'instructions' => __( 'Add points (icon, title, description).', 'wp-cinquante-et-un' ) . ' <em>(' . __( 'Optional', 'wp-cinquante-et-un' ) . ')</em>.',
							'min'          => 0,
							'max'          => 6,
							'sub_fields'   => array(
								array(
									'key'             => 'field_' . $key . '_push_content_items_icon',
									'label'           => __( 'Icon', 'wp-cinquante-et-un' ),
									'name'            => 'icon',
									'aria-label'      => __( 'Icon', 'wp-cinquante-et-un' ),
									'type'            => 'image',
									'return_format'   => 'id',
									'preview_size'    => 'thumbnail',
									'instructions'    => __( 'Select or upload an icon.', 'wp-cinquante-et-un' ) . ' <em>(' . __( 'Optional', 'wp-cinquante-et-un' ) . ')</em>.',
									'parent_repeater' => 'field_' . $key . '_push_content_items',
								),
								array(
									'key'             => 'field_' . $key . '_push_content_items_title',
									'label'           => __( 'Title', 'wp-cinquante-et-un' ),
									'name'            => 'title',
									'aria-label'      => __( 'Title', 'wp-cinquante-et-un' ),
									'type'            => 'text',
									'placeholder'     => __( 'Item title', 'wp-cinquante-et-un' ),
									'parent_repeater' => 'field_' . $key . '_push_content_items',
								),
								array(
									'key'             => 'field_' . $key . '_push_content_items_text',
									'label'           => __( 'Text', 'wp-cinquante-et-un' ),
									'name'            => 'text',
									'aria-label'      => __( 'Text', 'wp-cinquante-et-un' ),
									'type'            => 'textarea',
									'rows'            => 2,
									'new_lines'       => 'br',
									'placeholder'     => __( 'Enter the description', 'wp-cinquante-et-un' ),
									'parent_repeater' => 'field_' . $key . '_push_content_items',
								),
							),
						),
					),
				),
			),
		);
	}
}
