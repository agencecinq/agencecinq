<?php
/**
 * ACF layout: Link grid
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Link grid block layout.
 */
class LinkGrid {

	/**
	 * Returns the layout array for the Link grid block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_link_grid',
			'name'       => 'link_grid',
			'label'      => __( 'Link grid', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_link_grid_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_link_grid_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'         => 'field_' . $key . '_link_grid_content_eyebrow',
							'label'       => __( 'Eyebrow', 'agencecinq' ),
							'name'        => 'eyebrow',
							'aria-label'  => __( 'Eyebrow', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'Shopify', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_link_grid_content_title',
							'label'       => __( 'Title', 'agencecinq' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'What we do on Shopify', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_link_grid_content_text',
							'label'       => __( 'Text', 'agencecinq' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'agencecinq' ),
							'type'        => 'textarea',
							'rows'        => 3,
							'new_lines'   => '',
							'placeholder' => __( 'Enter the lead text of the block', 'agencecinq' ),
						),
						array(
							'key'        => 'field_' . $key . '_link_grid_content_heading',
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
					'key'          => 'field_' . $key . '_link_grid_cards',
					'label'        => __( 'Cards', 'agencecinq' ),
					'name'         => 'cards',
					'aria-label'   => __( 'Cards', 'agencecinq' ),
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => __( 'Add Card', 'agencecinq' ),
					'instructions' => __( 'One card per child page, three per row on desktop: the label of the link is the title of the card, the whole card leads to the page.', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'             => 'field_' . $key . '_link_grid_cards_link',
							'label'           => __( 'Link', 'agencecinq' ),
							'name'            => 'link',
							'aria-label'      => __( 'Link', 'agencecinq' ),
							'type'            => 'link',
							'return_format'   => 'array',
							'required'        => 1,
							'parent_repeater' => 'field_' . $key . '_link_grid_cards',
						),
						array(
							'key'             => 'field_' . $key . '_link_grid_cards_text',
							'label'           => __( 'Text', 'agencecinq' ),
							'name'            => 'text',
							'aria-label'      => __( 'Text', 'agencecinq' ),
							'type'            => 'textarea',
							'rows'            => 2,
							'new_lines'       => '',
							'parent_repeater' => 'field_' . $key . '_link_grid_cards',
						),
					),
				),
				...AcfFieldHelpers::settings( $key . '_link_grid' ),
			),
		);
	}
}
