<?php
/**
 * ACF layout: Code Guide
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Code Guide block layout.
 */
class CodeGuide {

	/**
	 * Returns the layout array for the Code Guide block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_code_guide',
			'name'       => 'code_guide',
			'label'      => __( 'Code Guide', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_code_guide_content_tab',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_code_guide_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'   => 'field_' . $key . '_code_guide_content_badge',
							'label' => __( 'Badge', 'agencecinq' ),
							'name'  => 'badge',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_' . $key . '_code_guide_content_overline',
							'label' => __( 'Overline', 'agencecinq' ),
							'name'  => 'overline',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_' . $key . '_code_guide_content_title',
							'label' => __( 'Title', 'agencecinq' ),
							'name'  => 'title',
							'type'  => 'text',
						),
						array(
							'key'     => 'field_' . $key . '_code_guide_content_heading',
							'label'   => __( 'Heading', 'agencecinq' ),
							'name'    => 'heading',
							'type'    => 'clone',
							'clone'   => array( 'field_clones_heading' ),
							'display' => 'seamless',
							'layout'  => 'block',
						),
						array(
							'key'       => 'field_' . $key . '_code_guide_content_text',
							'label'     => __( 'Text', 'agencecinq' ),
							'name'      => 'text',
							'type'      => 'textarea',
							'rows'      => 3,
							'new_lines' => 'br',
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_code_guide_aside_tab',
					'label'      => __( 'Aside', 'agencecinq' ),
					'aria-label' => __( 'Aside', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_code_guide_aside',
					'label'      => __( 'Aside', 'agencecinq' ),
					'name'       => 'aside',
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'   => 'field_' . $key . '_code_guide_aside_label',
							'label' => __( 'Label', 'agencecinq' ),
							'name'  => 'label',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_' . $key . '_code_guide_aside_title',
							'label' => __( 'Title', 'agencecinq' ),
							'name'  => 'title',
							'type'  => 'text',
						),
						array(
							'key'       => 'field_' . $key . '_code_guide_aside_text',
							'label'     => __( 'Text', 'agencecinq' ),
							'name'      => 'text',
							'type'      => 'textarea',
							'rows'      => 2,
							'new_lines' => 'br',
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_code_guide_columns_tab',
					'label'      => __( 'Columns', 'agencecinq' ),
					'aria-label' => __( 'Columns', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_code_guide_columns',
					'label'        => __( 'Columns', 'agencecinq' ),
					'name'         => 'columns',
					'type'         => 'repeater',
					'layout'       => 'block',
					'min'          => 1,
					'max'          => 2,
					'button_label' => __( 'Add Column', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'             => 'field_' . $key . '_code_guide_columns_style',
							'label'           => __( 'Style', 'agencecinq' ),
							'name'            => 'style',
							'type'            => 'select',
							'choices'         => array(
								'open'   => __( 'Open', 'agencecinq' ),
								'framed' => __( 'Framed', 'agencecinq' ),
							),
							'default_value'   => 'open',
							'parent_repeater' => 'field_' . $key . '_code_guide_columns',
						),
						array(
							'key'             => 'field_' . $key . '_code_guide_columns_index',
							'label'           => __( 'Index', 'agencecinq' ),
							'name'            => 'index',
							'type'            => 'text',
							'parent_repeater' => 'field_' . $key . '_code_guide_columns',
						),
						array(
							'key'             => 'field_' . $key . '_code_guide_columns_overline',
							'label'           => __( 'Overline', 'agencecinq' ),
							'name'            => 'overline',
							'type'            => 'text',
							'parent_repeater' => 'field_' . $key . '_code_guide_columns',
						),
						array(
							'key'             => 'field_' . $key . '_code_guide_columns_title',
							'label'           => __( 'Title', 'agencecinq' ),
							'name'            => 'title',
							'type'            => 'text',
							'parent_repeater' => 'field_' . $key . '_code_guide_columns',
						),
						array(
							'key'             => 'field_' . $key . '_code_guide_columns_meta',
							'label'           => __( 'Meta', 'agencecinq' ),
							'name'            => 'meta',
							'type'            => 'text',
							'parent_repeater' => 'field_' . $key . '_code_guide_columns',
						),
						array(
							'key'             => 'field_' . $key . '_code_guide_columns_snippets',
							'label'           => __( 'Snippets', 'agencecinq' ),
							'name'            => 'snippets',
							'type'            => 'repeater',
							'layout'          => 'block',
							'button_label'    => __( 'Add Snippet', 'agencecinq' ),
							'parent_repeater' => 'field_' . $key . '_code_guide_columns',
							'sub_fields'      => array(
								array(
									'key'             => 'field_' . $key . '_code_guide_columns_snippets_language',
									'label'           => __( 'Language', 'agencecinq' ),
									'name'            => 'language',
									'type'            => 'text',
									'parent_repeater' => 'field_' . $key . '_code_guide_columns_snippets',
								),
								array(
									'key'             => 'field_' . $key . '_code_guide_columns_snippets_code',
									'label'           => __( 'Code', 'agencecinq' ),
									'name'            => 'code',
									'type'            => 'textarea',
									'rows'            => 6,
									'new_lines'       => '',
									'parent_repeater' => 'field_' . $key . '_code_guide_columns_snippets',
								),
							),
						),
						array(
							'key'             => 'field_' . $key . '_code_guide_columns_note',
							'label'           => __( 'Note', 'agencecinq' ),
							'name'            => 'note',
							'type'            => 'textarea',
							'rows'            => 2,
							'new_lines'       => 'br',
							'parent_repeater' => 'field_' . $key . '_code_guide_columns',
						),
						array(
							'key'             => 'field_' . $key . '_code_guide_columns_note_icon',
							'label'           => __( 'Note icon', 'agencecinq' ),
							'name'            => 'note_icon',
							'type'            => 'text',
							'instructions'    => __( 'Sprite icon name, e.g. folder-git.', 'agencecinq' ),
							'parent_repeater' => 'field_' . $key . '_code_guide_columns',
						),
					),
				),
				...AcfFieldHelpers::settings( $key . '_code_guide' ),
			),
		);
	}
}
