<?php
/**
 * ACF layout: Editorial Cards
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Editorial Cards block layout.
 */
class EditorialCards {

	/**
	 * Returns the layout array for the Editorial Cards block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_editorial_cards',
			'name'       => 'editorial_cards',
			'label'      => __( 'Editorial Cards', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_editorial_cards_content_tab',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_editorial_cards_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'         => 'field_' . $key . '_editorial_cards_content_overline',
							'label'       => __( 'Overline', 'agencecinq' ),
							'name'        => 'overline',
							'aria-label'  => __( 'Overline', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'Enter the overline of the block', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_editorial_cards_content_title',
							'label'       => __( 'Title', 'agencecinq' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'Enter the title of the block', 'agencecinq' ),
						),
						array(
							'key'        => 'field_' . $key . '_editorial_cards_content_heading',
							'label'      => __( 'Heading', 'agencecinq' ),
							'name'       => 'heading',
							'aria-label' => __( 'Heading', 'agencecinq' ),
							'type'       => 'clone',
							'clone'      => array( 'field_clones_heading' ),
							'display'    => 'seamless',
							'layout'     => 'block',
						),
						array(
							'key'         => 'field_' . $key . '_editorial_cards_content_text',
							'label'       => __( 'Text', 'agencecinq' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'agencecinq' ),
							'type'        => 'textarea',
							'rows'        => 3,
							'new_lines'   => 'br',
							'placeholder' => __( 'Enter the lead text of the block', 'agencecinq' ),
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_editorial_cards_cards_tab',
					'label'      => __( 'Cards', 'agencecinq' ),
					'aria-label' => __( 'Cards', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_editorial_cards_cards',
					'label'        => __( 'Cards', 'agencecinq' ),
					'name'         => 'cards',
					'aria-label'   => __( 'Cards', 'agencecinq' ),
					'type'         => 'repeater',
					'layout'       => 'block',
					'min'          => 0,
					'button_label' => __( 'Add Card', 'agencecinq' ),
					'instructions' => __( 'Editorial card grid. Add as many cards as needed (1–2 columns on tablet, up to 3 on large screens).', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'             => 'field_' . $key . '_editorial_cards_cards_overline',
							'label'           => __( 'Overline', 'agencecinq' ),
							'name'            => 'overline',
							'type'            => 'text',
							'parent_repeater' => 'field_' . $key . '_editorial_cards_cards',
						),
						array(
							'key'             => 'field_' . $key . '_editorial_cards_cards_title',
							'label'           => __( 'Title', 'agencecinq' ),
							'name'            => 'title',
							'type'            => 'text',
							'parent_repeater' => 'field_' . $key . '_editorial_cards_cards',
						),
						array(
							'key'             => 'field_' . $key . '_editorial_cards_cards_figure',
							'label'           => __( 'Figure', 'agencecinq' ),
							'name'            => 'figure',
							'type'            => 'text',
							'instructions'    => __( 'Optional large figure (e.g. 27 min). Takes priority over the data flow.', 'agencecinq' ),
							'parent_repeater' => 'field_' . $key . '_editorial_cards_cards',
						),
						array(
							'key'             => 'field_' . $key . '_editorial_cards_cards_flow_input',
							'label'           => __( 'Flow input', 'agencecinq' ),
							'name'            => 'flow_input',
							'type'            => 'text',
							'instructions'    => __( 'Optional. Shown with an arrow when no figure is set.', 'agencecinq' ),
							'parent_repeater' => 'field_' . $key . '_editorial_cards_cards',
							'wrapper'         => array(
								'width' => 6 * 100 / 12,
							),
						),
						array(
							'key'             => 'field_' . $key . '_editorial_cards_cards_flow_output',
							'label'           => __( 'Flow output', 'agencecinq' ),
							'name'            => 'flow_output',
							'type'            => 'text',
							'parent_repeater' => 'field_' . $key . '_editorial_cards_cards',
							'wrapper'         => array(
								'width' => 6 * 100 / 12,
							),
						),
						array(
							'key'             => 'field_' . $key . '_editorial_cards_cards_text',
							'label'           => __( 'Text', 'agencecinq' ),
							'name'            => 'text',
							'type'            => 'textarea',
							'rows'            => 2,
							'new_lines'       => 'br',
							'parent_repeater' => 'field_' . $key . '_editorial_cards_cards',
						),
					),
				),
				...AcfFieldHelpers::settings( $key . '_editorial_cards' ),
			),
		);
	}
}
