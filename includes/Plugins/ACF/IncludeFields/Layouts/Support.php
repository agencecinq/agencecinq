<?php
/**
 * ACF layout: Support
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Support block layout.
 */
class Support {

	/**
	 * Returns the layout array for the Support block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_support',
			'name'       => 'support',
			'label'      => __( 'Support', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_support' ),
				AcfFieldHelpers::radius( $key . '_support' ),
				array(
					'key'        => 'field_' . $key . '_support_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_support_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'           => 'field_' . $key . '_support_content_title',
							'label'         => __( 'Title', 'agencecinq' ),
							'name'          => 'title',
							'aria-label'    => __( 'Title', 'agencecinq' ),
							'type'          => 'text',
							'placeholder'   => __( 'Enter the title of the block', 'agencecinq' ),
							'default_value' => '',
						),
						array(
							'key'          => 'field_' . $key . '_support_content_items',
							'label'        => __( 'Items', 'agencecinq' ),
							'name'         => 'items',
							'aria-label'   => __( 'Items', 'agencecinq' ),
							'type'         => 'repeater',
							'layout'       => 'block',
							'button_label' => __( 'Add Item', 'agencecinq' ),
							'min'          => 1,
							'max'          => 6,
							'sub_fields'   => array(
								array(
									'key'             => 'field_' . $key . '_support_content_items_title',
									'label'           => __( 'Title', 'agencecinq' ),
									'name'            => 'title',
									'aria-label'      => __( 'Title', 'agencecinq' ),
									'type'            => 'text',
									'placeholder'     => __( 'Enter the title of the item', 'agencecinq' ),
									'parent_repeater' => 'field_' . $key . '_support_content_items',
								),
								array(
									'key'             => 'field_' . $key . '_support_content_items_text',
									'label'           => __( 'Text', 'agencecinq' ),
									'name'            => 'text',
									'aria-label'      => __( 'Text', 'agencecinq' ),
									'type'            => 'textarea',
									'rows'            => 3,
									'new_lines'       => 'br',
									'placeholder'     => __( 'Enter the description', 'agencecinq' ),
									'parent_repeater' => 'field_' . $key . '_support_content_items',
								),
								array(
									'key'             => 'field_' . $key . '_support_content_items_link',
									'label'           => __( 'Link', 'agencecinq' ),
									'name'            => 'link',
									'aria-label'      => __( 'Link', 'agencecinq' ),
									'type'            => 'link',
									'return_format'   => 'array',
									'parent_repeater' => 'field_' . $key . '_support_content_items',
								),
							),
						),
					),
				),
			),
		);
	}
}
