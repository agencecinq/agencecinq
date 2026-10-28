<?php
/**
 * ACF layout: Steps
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Steps block layout.
 */
class Steps {

	/**
	 * Returns the layout array for the Steps block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_steps',
			'name'       => 'steps',
			'label'      => __( 'Steps', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_steps_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_steps_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'        => 'field_' . $key . '_steps_content_eyebrow',
							'label'      => __( 'Eyebrow', 'agencecinq' ),
							'name'       => 'eyebrow',
							'aria-label' => __( 'Eyebrow', 'agencecinq' ),
							'type'       => 'text',
						),
						array(
							'key'         => 'field_' . $key . '_steps_content_title',
							'label'       => __( 'Title', 'agencecinq' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'AI produces, the team reviews.', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_steps_content_text',
							'label'       => __( 'Text', 'agencecinq' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'agencecinq' ),
							'type'        => 'textarea',
							'rows'        => 3,
							'new_lines'   => '',
							'placeholder' => __( 'Enter the lead text of the block', 'agencecinq' ),
						),
						array(
							'key'        => 'field_' . $key . '_steps_content_heading',
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
					'key'          => 'field_' . $key . '_steps_steps',
					'label'        => __( 'Steps', 'agencecinq' ),
					'name'         => 'steps',
					'aria-label'   => __( 'Steps', 'agencecinq' ),
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => __( 'Add Step', 'agencecinq' ),
					'instructions' => __( 'One step per row, numbered in its order. Who holds it shows in a badge, and the legend lists the ones used.', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'             => 'field_' . $key . '_steps_steps_who',
							'label'           => __( 'Who', 'agencecinq' ),
							'name'            => 'who',
							'aria-label'      => __( 'Who', 'agencecinq' ),
							'type'            => 'select',
							'choices'         => array(
								'person' => __( 'Person', 'agencecinq' ),
								'ai'     => __( 'AI agent', 'agencecinq' ),
								'you'    => __( 'You', 'agencecinq' ),
							),
							'default_value'   => 'person',
							'parent_repeater' => 'field_' . $key . '_steps_steps',
						),
						array(
							'key'             => 'field_' . $key . '_steps_steps_title',
							'label'           => __( 'Title', 'agencecinq' ),
							'name'            => 'title',
							'aria-label'      => __( 'Title', 'agencecinq' ),
							'type'            => 'text',
							'required'        => 1,
							'parent_repeater' => 'field_' . $key . '_steps_steps',
						),
						array(
							'key'             => 'field_' . $key . '_steps_steps_text',
							'label'           => __( 'Text', 'agencecinq' ),
							'name'            => 'text',
							'aria-label'      => __( 'Text', 'agencecinq' ),
							'type'            => 'textarea',
							'rows'            => 2,
							'new_lines'       => '',
							'parent_repeater' => 'field_' . $key . '_steps_steps',
						),
					),
				),
				...AcfFieldHelpers::settings( $key . '_steps' ),
			),
		);
	}
}
