<?php
/**
 * ACF layout: Comparison
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Comparison block layout.
 */
class Comparison {

	/**
	 * Returns the layout array for the Comparison block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_comparison',
			'name'       => 'comparison',
			'label'      => __( 'Comparison', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_comparison_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_comparison_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'         => 'field_' . $key . '_comparison_content_eyebrow',
							'label'       => __( 'Eyebrow', 'agencecinq' ),
							'name'        => 'eyebrow',
							'aria-label'  => __( 'Eyebrow', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'Before, after', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_comparison_content_title',
							'label'       => __( 'Title', 'agencecinq' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'The same site, turned into an asset.', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_comparison_content_text',
							'label'       => __( 'Text', 'agencecinq' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'agencecinq' ),
							'type'        => 'textarea',
							'rows'        => 3,
							'new_lines'   => '',
							'placeholder' => __( 'Enter the lead text of the block', 'agencecinq' ),
						),
						array(
							'key'        => 'field_' . $key . '_comparison_content_heading',
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
					'key'        => 'field_' . $key . '_comparison_tab_captures',
					'label'      => __( 'Captures', 'agencecinq' ),
					'aria-label' => __( 'Captures', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_comparison_before',
					'label'        => __( 'Before', 'agencecinq' ),
					'name'         => 'before',
					'aria-label'   => __( 'Before', 'agencecinq' ),
					'type'         => 'group',
					'layout'       => 'block',
					'instructions' => __( 'Capture of the former site, shown in greys. Its alternative text, in the media library, describes the page before.', 'agencecinq' ),
					'wrapper'      => array(
						'width' => 6 * 100 / 12,
					),
					'sub_fields'   => self::capture( $key . '_comparison_before', '2023' ),
				),
				array(
					'key'          => 'field_' . $key . '_comparison_after',
					'label'        => __( 'After', 'agencecinq' ),
					'name'         => 'after',
					'aria-label'   => __( 'After', 'agencecinq' ),
					'type'         => 'group',
					'layout'       => 'block',
					'instructions' => __( 'Capture of the new site, same framing. Its alternative text, in the media library, describes the page after.', 'agencecinq' ),
					'wrapper'      => array(
						'width' => 6 * 100 / 12,
					),
					'sub_fields'   => self::capture( $key . '_comparison_after', '2026' ),
				),
				array(
					'key'         => 'field_' . $key . '_comparison_legend',
					'label'       => __( 'Legend', 'agencecinq' ),
					'name'        => 'legend',
					'aria-label'  => __( 'Legend', 'agencecinq' ),
					'type'        => 'text',
					'placeholder' => __( 'Eigrene · B2B service · from an Elementor site to a custom WordPress', 'agencecinq' ),
				),
				array(
					'key'        => 'field_' . $key . '_comparison_tab_findings',
					'label'      => __( 'Findings', 'agencecinq' ),
					'aria-label' => __( 'Findings', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_comparison_findings',
					'label'        => __( 'Findings', 'agencecinq' ),
					'name'         => 'findings',
					'aria-label'   => __( 'Findings', 'agencecinq' ),
					'type'         => 'group',
					'layout'       => 'block',
					'instructions' => __( 'Written with the client after their interview: nothing invented. An empty finding is not shown.', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'        => 'field_' . $key . '_comparison_findings_blocked',
							'label'      => __( 'What was blocking', 'agencecinq' ),
							'name'       => 'blocked',
							'aria-label' => __( 'What was blocking', 'agencecinq' ),
							'type'       => 'textarea',
							'rows'       => 3,
							'new_lines'  => '',
						),
						array(
							'key'        => 'field_' . $key . '_comparison_findings_done',
							'label'      => __( 'What we did', 'agencecinq' ),
							'name'       => 'done',
							'aria-label' => __( 'What we did', 'agencecinq' ),
							'type'       => 'textarea',
							'rows'       => 3,
							'new_lines'  => '',
						),
						array(
							'key'        => 'field_' . $key . '_comparison_findings_regained',
							'label'      => __( 'What the client took back in hand', 'agencecinq' ),
							'name'       => 'regained',
							'aria-label' => __( 'What the client took back in hand', 'agencecinq' ),
							'type'       => 'textarea',
							'rows'       => 3,
							'new_lines'  => '',
						),
					),
				),
				...AcfFieldHelpers::settings( $key . '_comparison' ),
			),
		);
	}

	/**
	 * Returns the fields of a capture: the image and the year of the site.
	 *
	 * @param string $key         The field key prefix.
	 * @param string $placeholder Placeholder of the year.
	 * @return array<int, array<string, mixed>>
	 */
	private static function capture( string $key, string $placeholder ): array {
		return array(
			array(
				'key'           => 'field_' . $key . '_image',
				'label'         => __( 'Image', 'agencecinq' ),
				'name'          => 'image',
				'aria-label'    => __( 'Image', 'agencecinq' ),
				'type'          => 'image',
				'return_format' => 'id',
				'preview_size'  => 'medium',
			),
			array(
				'key'         => 'field_' . $key . '_year',
				'label'       => __( 'Year', 'agencecinq' ),
				'name'        => 'year',
				'aria-label'  => __( 'Year', 'agencecinq' ),
				'type'        => 'number',
				'min'         => 1990,
				'step'        => 1,
				'placeholder' => $placeholder,
			),
		);
	}
}
