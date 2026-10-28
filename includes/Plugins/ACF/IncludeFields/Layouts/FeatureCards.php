<?php
/**
 * ACF layout: Feature cards
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Feature cards block layout.
 */
class FeatureCards {

	/**
	 * Returns the layout array for the Feature cards block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_feature_cards',
			'name'       => 'feature_cards',
			'label'      => __( 'Feature cards', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_feature_cards_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_feature_cards_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'         => 'field_' . $key . '_feature_cards_content_eyebrow',
							'label'       => __( 'Eyebrow', 'agencecinq' ),
							'name'        => 'eyebrow',
							'aria-label'  => __( 'Eyebrow', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'What comes back to you', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_feature_cards_content_title',
							'label'       => __( 'Title', 'agencecinq' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'You change providers without changing sites.', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_feature_cards_content_text',
							'label'       => __( 'Text', 'agencecinq' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'agencecinq' ),
							'type'        => 'textarea',
							'rows'        => 3,
							'new_lines'   => '',
							'placeholder' => __( 'Enter the lead text of the block', 'agencecinq' ),
						),
						array(
							'key'        => 'field_' . $key . '_feature_cards_content_heading',
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
					'key'        => 'field_' . $key . '_feature_cards_tab_cards',
					'label'      => __( 'Cards', 'agencecinq' ),
					'aria-label' => __( 'Cards', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_feature_cards_cards',
					'label'        => __( 'Cards', 'agencecinq' ),
					'name'         => 'cards',
					'aria-label'   => __( 'Cards', 'agencecinq' ),
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'Add Card', 'agencecinq' ),
					'instructions' => __( 'One card per thing handed over, four per row on desktop: the file name in monospace, then what it is.', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'             => 'field_' . $key . '_feature_cards_cards_file',
							'label'           => __( 'File', 'agencecinq' ),
							'name'            => 'file',
							'aria-label'      => __( 'File', 'agencecinq' ),
							'type'            => 'text',
							'placeholder'     => __( 'e.g. maquettes.fig', 'agencecinq' ),
							'wrapper'         => array(
								'width' => 4 * 100 / 12,
							),
							'parent_repeater' => 'field_' . $key . '_feature_cards_cards',
						),
						array(
							'key'             => 'field_' . $key . '_feature_cards_cards_title',
							'label'           => __( 'Title', 'agencecinq' ),
							'name'            => 'title',
							'aria-label'      => __( 'Title', 'agencecinq' ),
							'type'            => 'text',
							'required'        => 1,
							'wrapper'         => array(
								'width' => 8 * 100 / 12,
							),
							'parent_repeater' => 'field_' . $key . '_feature_cards_cards',
						),
						array(
							'key'             => 'field_' . $key . '_feature_cards_cards_text',
							'label'           => __( 'Text', 'agencecinq' ),
							'name'            => 'text',
							'aria-label'      => __( 'Text', 'agencecinq' ),
							'type'            => 'textarea',
							'rows'            => 2,
							'new_lines'       => '',
							'parent_repeater' => 'field_' . $key . '_feature_cards_cards',
						),
					),
				),
				...AcfFieldHelpers::settings( $key . '_feature_cards' ),
			),
		);
	}
}
