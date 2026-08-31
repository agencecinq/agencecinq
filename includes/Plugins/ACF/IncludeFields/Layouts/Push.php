<?php
/**
 * ACF layout: Push
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

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
			'label'      => __( 'Push', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_push' ),
				array(
					'key'           => 'field_' . $key . '_push_image_position',
					'label'         => __( 'Image position', 'agencecinq' ),
					'name'          => 'image_position',
					'aria-label'    => __( 'Image position', 'agencecinq' ),
					'type'          => 'select',
					'instructions'  => __( 'Choose which side the image appears on.', 'agencecinq' ),
					'choices'       => array(
						'left'  => __( 'Image on the left', 'agencecinq' ),
						'right' => __( 'Image on the right', 'agencecinq' ),
					),
					'default_value' => 'right',
					'return_format' => 'value',
				),
				...AcfFieldHelpers::media( $key . '_push' ),
				array(
					'key'           => 'field_' . $key . '_push_object_fit',
					'label'         => __( 'Object Fit', 'agencecinq' ),
					'name'          => 'object_fit',
					'aria-label'    => __( 'Object Fit', 'agencecinq' ),
					'type'          => 'select',
					'choices'       => array(
						'object-cover'   => __( 'Cover', 'agencecinq' ),
						'object-contain' => __( 'Contain', 'agencecinq' ),
					),
					'default_value' => 'object-cover',
					'instructions'  => __( 'Cover fills the area (may crop). Contain fits inside (may show empty space).', 'agencecinq' ),
					'return_format' => 'value',
				),
				array(
					'key'        => 'field_' . $key . '_push_content_tab',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_push_content',
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'         => 'field_' . $key . '_push_content_title',
							'label'       => __( 'Title', 'agencecinq' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'Enter the title of the content', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_push_content_subtitle',
							'label'       => __( 'Subtitle', 'agencecinq' ),
							'name'        => 'subtitle',
							'aria-label'  => __( 'Subtitle', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'Enter the subtitle of the content', 'agencecinq' ),
						),
						array(
							'key'          => 'field_' . $key . '_push_content_text',
							'label'        => __( 'Text', 'agencecinq' ),
							'name'         => 'text',
							'aria-label'   => __( 'Text', 'agencecinq' ),
							'type'         => 'wysiwyg',
							'tabs'         => 'all',
							'toolbar'      => 'basic',
							'media_upload' => 0,
							'placeholder'  => __( 'Enter the text of the content', 'agencecinq' ),
						),
						array(
							'key'          => 'field_' . $key . '_push_content_link',
							'label'        => __( 'Link', 'agencecinq' ),
							'name'         => 'link',
							'aria-label'   => __( 'Link', 'agencecinq' ),
							'type'         => 'link',
							'instructions' => __( 'Enter the link URL.', 'agencecinq' ) . ' <em>(' . __( 'Optional', 'agencecinq' ) . ')</em>.',
						),
						array(
							'key'          => 'field_' . $key . '_push_content_items',
							'label'        => __( 'Items', 'agencecinq' ),
							'name'         => 'items',
							'aria-label'   => __( 'Items', 'agencecinq' ),
							'type'         => 'repeater',
							'layout'       => 'block',
							'button_label' => __( 'Add Item', 'agencecinq' ),
							'instructions' => __( 'Add points (icon, title, description).', 'agencecinq' ) . ' <em>(' . __( 'Optional', 'agencecinq' ) . ')</em>.',
							'min'          => 0,
							'max'          => 6,
							'sub_fields'   => array(
								array(
									'key'             => 'field_' . $key . '_push_content_items_icon',
									'label'           => __( 'Icon', 'agencecinq' ),
									'name'            => 'icon',
									'aria-label'      => __( 'Icon', 'agencecinq' ),
									'type'            => 'image',
									'return_format'   => 'id',
									'preview_size'    => 'thumbnail',
									'instructions'    => __( 'Select or upload an icon.', 'agencecinq' ) . ' <em>(' . __( 'Optional', 'agencecinq' ) . ')</em>.',
									'parent_repeater' => 'field_' . $key . '_push_content_items',
								),
								array(
									'key'             => 'field_' . $key . '_push_content_items_title',
									'label'           => __( 'Title', 'agencecinq' ),
									'name'            => 'title',
									'aria-label'      => __( 'Title', 'agencecinq' ),
									'type'            => 'text',
									'placeholder'     => __( 'Item title', 'agencecinq' ),
									'parent_repeater' => 'field_' . $key . '_push_content_items',
								),
								array(
									'key'             => 'field_' . $key . '_push_content_items_text',
									'label'           => __( 'Text', 'agencecinq' ),
									'name'            => 'text',
									'aria-label'      => __( 'Text', 'agencecinq' ),
									'type'            => 'textarea',
									'rows'            => 2,
									'new_lines'       => 'br',
									'placeholder'     => __( 'Enter the description', 'agencecinq' ),
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
