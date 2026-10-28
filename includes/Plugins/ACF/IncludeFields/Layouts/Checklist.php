<?php
/**
 * ACF layout: Checklist
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Checklist block layout.
 */
class Checklist {

	/**
	 * Returns the layout array for the Checklist block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_checklist',
			'name'       => 'checklist',
			'label'      => __( 'Checklist', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_checklist_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_checklist_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'        => 'field_' . $key . '_checklist_content_eyebrow',
							'label'      => __( 'Eyebrow', 'agencecinq' ),
							'name'       => 'eyebrow',
							'aria-label' => __( 'Eyebrow', 'agencecinq' ),
							'type'       => 'text',
						),
						array(
							'key'         => 'field_' . $key . '_checklist_content_title',
							'label'       => __( 'Title', 'agencecinq' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( '6 points to tell whether your site is an asset.', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_checklist_content_text',
							'label'       => __( 'Text', 'agencecinq' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'agencecinq' ),
							'type'        => 'textarea',
							'rows'        => 3,
							'new_lines'   => '',
							'placeholder' => __( 'Enter the lead text of the block', 'agencecinq' ),
						),
						array(
							'key'        => 'field_' . $key . '_checklist_content_heading',
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
					'key'          => 'field_' . $key . '_checklist_points',
					'label'        => __( 'Points', 'agencecinq' ),
					'name'         => 'points',
					'aria-label'   => __( 'Points', 'agencecinq' ),
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => __( 'Add Point', 'agencecinq' ),
					'instructions' => __( 'One point per row, numbered in its order: what to check, then the question to ask.', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'             => 'field_' . $key . '_checklist_points_title',
							'label'           => __( 'Title', 'agencecinq' ),
							'name'            => 'title',
							'aria-label'      => __( 'Title', 'agencecinq' ),
							'type'            => 'text',
							'required'        => 1,
							'parent_repeater' => 'field_' . $key . '_checklist_points',
						),
						array(
							'key'             => 'field_' . $key . '_checklist_points_text',
							'label'           => __( 'Question', 'agencecinq' ),
							'name'            => 'text',
							'aria-label'      => __( 'Question', 'agencecinq' ),
							'type'            => 'text',
							'parent_repeater' => 'field_' . $key . '_checklist_points',
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_checklist_links',
					'label'      => __( 'Links', 'agencecinq' ),
					'name'       => 'links',
					'aria-label' => __( 'Links', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'           => 'field_' . $key . '_checklist_links_0',
							'label'         => __( 'Link', 'agencecinq' ),
							'name'          => '0',
							'aria-label'    => __( 'Link', 'agencecinq' ),
							'type'          => 'link',
							'return_format' => 'array',
							'wrapper'       => array(
								'width' => 6 * 100 / 12,
							),
						),
						array(
							'key'           => 'field_' . $key . '_checklist_links_1',
							'label'         => __( 'Secondary link', 'agencecinq' ),
							'name'          => '1',
							'aria-label'    => __( 'Secondary link', 'agencecinq' ),
							'type'          => 'link',
							'return_format' => 'array',
							'instructions'  => __( 'Optional outlined button next to the primary CTA.', 'agencecinq' ),
							'wrapper'       => array(
								'width' => 6 * 100 / 12,
							),
						),
					),
				),
				...AcfFieldHelpers::settings( $key . '_checklist' ),
			),
		);
	}
}
