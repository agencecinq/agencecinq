<?php
/**
 * ACF layout: Process
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn/Plugins/ACF/IncludeFields/Layouts
 */

namespace WPCinquanteEtUn\Plugins\ACF\IncludeFields\Layouts;

use WPCinquanteEtUn\Plugins\ACF\IncludeFields\AcfFieldHelpers;

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
			'label'      => __( 'Process', 'wp-cinquante-et-un' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_process' ),
				AcfFieldHelpers::radius( $key . '_process' ),
				array(
					'key'        => 'field_' . $key . '_process_tab_content',
					'label'      => __( 'Content', 'wp-cinquante-et-un' ),
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_process_content',
					'label'      => __( 'Content', 'wp-cinquante-et-un' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'         => 'field_' . $key . '_process_content_title',
							'label'       => __( 'Title', 'wp-cinquante-et-un' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'wp-cinquante-et-un' ),
							'type'        => 'text',
							'placeholder' => __( 'Enter the title of the block', 'wp-cinquante-et-un' ),
						),
						array(
							'key'         => 'field_' . $key . '_process_content_subtitle',
							'label'       => __( 'Subtitle', 'wp-cinquante-et-un' ),
							'name'        => 'subtitle',
							'aria-label'  => __( 'Subtitle', 'wp-cinquante-et-un' ),
							'type'        => 'text',
							'placeholder' => __( 'Enter the subtitle of the block', 'wp-cinquante-et-un' ),
						),
						array(
							'key'         => 'field_' . $key . '_process_content_text',
							'label'       => __( 'Text', 'wp-cinquante-et-un' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'wp-cinquante-et-un' ),
							'type'        => 'textarea',
							'rows'        => 4,
							'new_lines'   => 'br',
							'placeholder' => __( 'Optional explanatory text (e.g. right column).', 'wp-cinquante-et-un' ),
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_process_tab_steps',
					'label'      => __( 'Steps', 'wp-cinquante-et-un' ),
					'aria-label' => __( 'Steps', 'wp-cinquante-et-un' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_process_steps',
					'label'        => __( 'Steps', 'wp-cinquante-et-un' ),
					'name'         => 'steps',
					'aria-label'   => __( 'Steps', 'wp-cinquante-et-un' ),
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'Add Step', 'wp-cinquante-et-un' ),
					'min'          => 1,
					'max'          => 6,
					'sub_fields'   => array(
						array(
							'key'             => 'field_' . $key . '_process_steps_image',
							'label'           => __( 'Image', 'wp-cinquante-et-un' ),
							'name'            => 'image',
							'aria-label'      => __( 'Image', 'wp-cinquante-et-un' ),
							'type'            => 'image',
							'return_format'   => 'array',
							'preview_size'    => 'medium',
							'parent_repeater' => 'field_' . $key . '_process_steps',
						),
						array(
							'key'             => 'field_' . $key . '_process_steps_title',
							'label'           => __( 'Title', 'wp-cinquante-et-un' ),
							'name'            => 'title',
							'aria-label'      => __( 'Title', 'wp-cinquante-et-un' ),
							'type'            => 'text',
							'placeholder'     => __( 'Enter the title of the step', 'wp-cinquante-et-un' ),
							'parent_repeater' => 'field_' . $key . '_process_steps',
						),
						array(
							'key'             => 'field_' . $key . '_process_steps_text',
							'label'           => __( 'Text', 'wp-cinquante-et-un' ),
							'name'            => 'text',
							'aria-label'      => __( 'Text', 'wp-cinquante-et-un' ),
							'type'            => 'textarea',
							'rows'            => 3,
							'new_lines'       => 'br',
							'placeholder'     => __( 'Enter the description of the step', 'wp-cinquante-et-un' ),
							'parent_repeater' => 'field_' . $key . '_process_steps',
						),
						array(
							'key'             => 'field_' . $key . '_process_steps_logos',
							'label'           => __( 'Logos', 'wp-cinquante-et-un' ),
							'name'            => 'logos',
							'aria-label'      => __( 'Logos', 'wp-cinquante-et-un' ),
							'type'            => 'gallery',
							'return_format'   => 'id',
							'preview_size'    => 'thumbnail',
							'parent_repeater' => 'field_' . $key . '_process_steps',
						),
						array(
							'key'             => 'field_' . $key . '_process_steps_link',
							'label'           => __( 'Link', 'wp-cinquante-et-un' ),
							'name'            => 'link',
							'aria-label'      => __( 'Link', 'wp-cinquante-et-un' ),
							'type'            => 'link',
							'parent_repeater' => 'field_' . $key . '_process_steps',
						),
					),
				),
			),
		);
	}
}
