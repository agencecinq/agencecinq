<?php
/**
 * ACF layout: Diff columns
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Diff columns block layout.
 */
class DiffColumns {

	/**
	 * Returns the layout array for the Diff columns block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_diff_columns',
			'name'       => 'diff_columns',
			'label'      => __( 'Diff columns', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_diff_columns_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_diff_columns_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'         => 'field_' . $key . '_diff_columns_content_eyebrow',
							'label'       => __( 'Eyebrow', 'agencecinq' ),
							'name'        => 'eyebrow',
							'aria-label'  => __( 'Eyebrow', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'What changes', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_diff_columns_content_title',
							'label'       => __( 'Title', 'agencecinq' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'What changes on your site', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_diff_columns_content_text',
							'label'       => __( 'Text', 'agencecinq' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'agencecinq' ),
							'type'        => 'textarea',
							'rows'        => 3,
							'new_lines'   => '',
							'placeholder' => __( 'The 6 points of the diagnostic, before and after the redesign.', 'agencecinq' ),
						),
						array(
							'key'        => 'field_' . $key . '_diff_columns_content_heading',
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
					'key'        => 'field_' . $key . '_diff_columns_tab_lines',
					'label'      => __( 'Lines', 'agencecinq' ),
					'aria-label' => __( 'Lines', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_diff_columns_before',
					'label'        => __( 'Before', 'agencecinq' ),
					'name'         => 'before',
					'aria-label'   => __( 'Before', 'agencecinq' ),
					'type'         => 'group',
					'layout'       => 'block',
					'instructions' => __( 'Specific to the page. On a case study, only findings checked and approved by the client.', 'agencecinq' ),
					'wrapper'      => array(
						'width' => 6 * 100 / 12,
					),
					'sub_fields'   => self::column( $key . '_diff_columns_before', __( 'today', 'agencecinq' ), __( 'e.g. Slow on mobile', 'agencecinq' ) ),
				),
				array(
					'key'        => 'field_' . $key . '_diff_columns_after',
					'label'      => __( 'After', 'agencecinq' ),
					'name'       => 'after',
					'aria-label' => __( 'After', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'wrapper'    => array(
						'width' => 6 * 100 / 12,
					),
					'sub_fields' => self::column( $key . '_diff_columns_after', __( 'after the redesign', 'agencecinq' ), __( 'e.g. Speed measured at launch', 'agencecinq' ) ),
				),
				...AcfFieldHelpers::settings( $key . '_diff_columns' ),
			),
		);
	}

	/**
	 * Returns the fields of a column: its label and its lines.
	 *
	 * @param string $key         The field key prefix.
	 * @param string $label       Default label of the column.
	 * @param string $placeholder Placeholder of a line.
	 * @return array<int, array<string, mixed>>
	 */
	private static function column( string $key, string $label, string $placeholder ): array {
		return array(
			array(
				'key'           => 'field_' . $key . '_label',
				'label'         => __( 'Label', 'agencecinq' ),
				'name'          => 'label',
				'aria-label'    => __( 'Label', 'agencecinq' ),
				'type'          => 'text',
				'default_value' => $label,
			),
			array(
				'key'          => 'field_' . $key . '_lines',
				'label'        => __( 'Lines', 'agencecinq' ),
				'name'         => 'lines',
				'aria-label'   => __( 'Lines', 'agencecinq' ),
				'type'         => 'repeater',
				'layout'       => 'table',
				'button_label' => __( 'Add Line', 'agencecinq' ),
				'sub_fields'   => array(
					array(
						'key'             => 'field_' . $key . '_lines_text',
						'label'           => __( 'Text', 'agencecinq' ),
						'name'            => 'text',
						'aria-label'      => __( 'Text', 'agencecinq' ),
						'type'            => 'text',
						'placeholder'     => $placeholder,
						'parent_repeater' => 'field_' . $key . '_lines',
					),
				),
			),
		);
	}
}
