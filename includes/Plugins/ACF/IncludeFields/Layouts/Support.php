<?php
/**
 * ACF layout: Support
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn/Plugins/ACF/IncludeFields/Layouts
 */

namespace WPCinquanteEtUn\Plugins\ACF\IncludeFields\Layouts;

use WPCinquanteEtUn\Plugins\ACF\IncludeFields\AcfFieldHelpers;

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
			'label'      => __( 'Support', 'wp-cinquante-et-un' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_support' ),
				AcfFieldHelpers::radius( $key . '_support' ),
				array(
					'key'        => 'field_' . $key . '_support_tab_content',
					'label'      => __( 'Content', 'wp-cinquante-et-un' ),
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_support_content',
					'label'      => __( 'Content', 'wp-cinquante-et-un' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'           => 'field_' . $key . '_support_content_title',
							'label'         => __( 'Title', 'wp-cinquante-et-un' ),
							'name'          => 'title',
							'aria-label'    => __( 'Title', 'wp-cinquante-et-un' ),
							'type'          => 'text',
							'placeholder'   => __( 'Enter the title of the block', 'wp-cinquante-et-un' ),
							'default_value' => '',
						),
						array(
							'key'          => 'field_' . $key . '_support_content_items',
							'label'        => __( 'Items', 'wp-cinquante-et-un' ),
							'name'         => 'items',
							'aria-label'   => __( 'Items', 'wp-cinquante-et-un' ),
							'type'         => 'repeater',
							'layout'       => 'block',
							'button_label' => __( 'Add Item', 'wp-cinquante-et-un' ),
							'min'          => 1,
							'max'          => 6,
							'sub_fields'   => array(
								array(
									'key'             => 'field_' . $key . '_support_content_items_title',
									'label'           => __( 'Title', 'wp-cinquante-et-un' ),
									'name'            => 'title',
									'aria-label'      => __( 'Title', 'wp-cinquante-et-un' ),
									'type'            => 'text',
									'placeholder'     => __( 'Enter the title of the item', 'wp-cinquante-et-un' ),
									'parent_repeater' => 'field_' . $key . '_support_content_items',
								),
								array(
									'key'             => 'field_' . $key . '_support_content_items_text',
									'label'           => __( 'Text', 'wp-cinquante-et-un' ),
									'name'            => 'text',
									'aria-label'      => __( 'Text', 'wp-cinquante-et-un' ),
									'type'            => 'textarea',
									'rows'            => 3,
									'new_lines'       => 'br',
									'placeholder'     => __( 'Enter the description', 'wp-cinquante-et-un' ),
									'parent_repeater' => 'field_' . $key . '_support_content_items',
								),
								array(
									'key'             => 'field_' . $key . '_support_content_items_link',
									'label'           => __( 'Link', 'wp-cinquante-et-un' ),
									'name'            => 'link',
									'aria-label'      => __( 'Link', 'wp-cinquante-et-un' ),
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
