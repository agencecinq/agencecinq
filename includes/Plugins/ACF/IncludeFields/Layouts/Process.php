<?php
/**
 * ACF layout: Process
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Process block layout.
 */
class Process {

	/**
	 * Returns the layout array for the Process block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_process',
			'name'       => 'process',
			'label'      => __( 'Process', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_process' ),
				AcfFieldHelpers::radius( $key . '_process' ),
				array(
					'key'        => 'field_' . $key . '_process_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_process_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'         => 'field_' . $key . '_process_content_title',
							'label'       => __( 'Title', 'agencecinq' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'Enter the title of the block', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_process_content_subtitle',
							'label'       => __( 'Subtitle', 'agencecinq' ),
							'name'        => 'subtitle',
							'aria-label'  => __( 'Subtitle', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'Enter the subtitle of the block', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_process_content_text',
							'label'       => __( 'Text', 'agencecinq' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'agencecinq' ),
							'type'        => 'textarea',
							'rows'        => 4,
							'new_lines'   => 'br',
							'placeholder' => __( 'Optional explanatory text (e.g. right column).', 'agencecinq' ),
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_process_tab_steps',
					'label'      => __( 'Steps', 'agencecinq' ),
					'aria-label' => __( 'Steps', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_process_steps',
					'label'        => __( 'Steps', 'agencecinq' ),
					'name'         => 'steps',
					'aria-label'   => __( 'Steps', 'agencecinq' ),
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'Add Step', 'agencecinq' ),
					'min'          => 1,
					'max'          => 6,
					'sub_fields'   => array(
						array(
							'key'             => 'field_' . $key . '_process_steps_image',
							'label'           => __( 'Image', 'agencecinq' ),
							'name'            => 'image',
							'aria-label'      => __( 'Image', 'agencecinq' ),
							'type'            => 'image',
							'return_format'   => 'array',
							'preview_size'    => 'medium',
							'parent_repeater' => 'field_' . $key . '_process_steps',
						),
						array(
							'key'             => 'field_' . $key . '_process_steps_title',
							'label'           => __( 'Title', 'agencecinq' ),
							'name'            => 'title',
							'aria-label'      => __( 'Title', 'agencecinq' ),
							'type'            => 'text',
							'placeholder'     => __( 'Enter the title of the step', 'agencecinq' ),
							'parent_repeater' => 'field_' . $key . '_process_steps',
						),
						array(
							'key'             => 'field_' . $key . '_process_steps_text',
							'label'           => __( 'Text', 'agencecinq' ),
							'name'            => 'text',
							'aria-label'      => __( 'Text', 'agencecinq' ),
							'type'            => 'textarea',
							'rows'            => 3,
							'new_lines'       => 'br',
							'placeholder'     => __( 'Enter the description of the step', 'agencecinq' ),
							'parent_repeater' => 'field_' . $key . '_process_steps',
						),
						array(
							'key'             => 'field_' . $key . '_process_steps_logos',
							'label'           => __( 'Logos', 'agencecinq' ),
							'name'            => 'logos',
							'aria-label'      => __( 'Logos', 'agencecinq' ),
							'type'            => 'gallery',
							'return_format'   => 'id',
							'preview_size'    => 'thumbnail',
							'parent_repeater' => 'field_' . $key . '_process_steps',
						),
						array(
							'key'             => 'field_' . $key . '_process_steps_link',
							'label'           => __( 'Link', 'agencecinq' ),
							'name'            => 'link',
							'aria-label'      => __( 'Link', 'agencecinq' ),
							'type'            => 'link',
							'parent_repeater' => 'field_' . $key . '_process_steps',
						),
					),
				),
			),
		);
	}
}
