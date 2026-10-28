<?php
/**
 * ACF layout: Numbered list
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Numbered list block layout.
 */
class NumberedList {

	/**
	 * Returns the layout array for the Numbered list block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_numbered_list',
			'name'       => 'numbered_list',
			'label'      => __( 'Numbered list', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_numbered_list_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_numbered_list_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'         => 'field_' . $key . '_numbered_list_content_eyebrow',
							'label'       => __( 'Eyebrow', 'agencecinq' ),
							'name'        => 'eyebrow',
							'aria-label'  => __( 'Eyebrow', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'What we commit to', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_numbered_list_content_title',
							'label'       => __( 'Title', 'agencecinq' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'What is decided before we start', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_numbered_list_content_text',
							'label'       => __( 'Text', 'agencecinq' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'agencecinq' ),
							'type'        => 'textarea',
							'rows'        => 3,
							'new_lines'   => '',
							'placeholder' => __( 'Enter the lead text of the block', 'agencecinq' ),
						),
						array(
							'key'        => 'field_' . $key . '_numbered_list_content_heading',
							'label'      => __( 'Heading', 'agencecinq' ),
							'name'       => 'heading',
							'aria-label' => __( 'Heading', 'agencecinq' ),
							'type'       => 'clone',
							'clone'      => array( 'field_clones_heading' ),
							'display'    => 'seamless',
							'layout'     => 'block',
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_numbered_list_tab_items',
					'label'      => __( 'Items', 'agencecinq' ),
					'aria-label' => __( 'Items', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_numbered_list_items',
					'label'        => __( 'Items', 'agencecinq' ),
					'name'         => 'items',
					'aria-label'   => __( 'Items', 'agencecinq' ),
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'Add Item', 'agencecinq' ),
					'instructions' => __( 'Numbered in order, from 01. Write numbers as figures: « 30 days », not « Thirty days ».', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'             => 'field_' . $key . '_numbered_list_items_title',
							'label'           => __( 'Title', 'agencecinq' ),
							'name'            => 'title',
							'aria-label'      => __( 'Title', 'agencecinq' ),
							'type'            => 'text',
							'required'        => 1,
							'parent_repeater' => 'field_' . $key . '_numbered_list_items',
						),
						array(
							'key'             => 'field_' . $key . '_numbered_list_items_text',
							'label'           => __( 'Text', 'agencecinq' ),
							'name'            => 'text',
							'aria-label'      => __( 'Text', 'agencecinq' ),
							'type'            => 'textarea',
							'rows'            => 2,
							'new_lines'       => '',
							'parent_repeater' => 'field_' . $key . '_numbered_list_items',
						),
					),
				),
				...AcfFieldHelpers::settings( $key . '_numbered_list' ),
			),
		);
	}
}
