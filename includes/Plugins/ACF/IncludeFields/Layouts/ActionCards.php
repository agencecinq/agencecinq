<?php
/**
 * ACF layout: Action cards
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;
use AgenceCinq\Plugins\ACF\IncludeFields\CatalogueChoices;

/**
 * Action cards block layout.
 */
class ActionCards {

	/**
	 * Returns the layout array for the Action cards block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_action_cards',
			'name'       => 'action_cards',
			'label'      => __( 'Action cards', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_action_cards_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_action_cards_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'         => 'field_' . $key . '_action_cards_content_eyebrow',
							'label'       => __( 'Eyebrow', 'agencecinq' ),
							'name'        => 'eyebrow',
							'aria-label'  => __( 'Eyebrow', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'Where to start', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_action_cards_content_title',
							'label'       => __( 'Title', 'agencecinq' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'Where does your site stand?', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_action_cards_content_text',
							'label'       => __( 'Text', 'agencecinq' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'agencecinq' ),
							'type'        => 'textarea',
							'rows'        => 3,
							'new_lines'   => '',
							'placeholder' => __( 'Enter the lead text of the block', 'agencecinq' ),
						),
						array(
							'key'        => 'field_' . $key . '_action_cards_content_heading',
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
					'key'        => 'field_' . $key . '_action_cards_tab_cards',
					'label'      => __( 'Cards', 'agencecinq' ),
					'aria-label' => __( 'Cards', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_action_cards_cards',
					'label'        => __( 'Cards', 'agencecinq' ),
					'name'         => 'cards',
					'aria-label'   => __( 'Cards', 'agencecinq' ),
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'Add Card', 'agencecinq' ),
					'instructions' => __( 'One card per situation: the offer that answers it and its price, read from the Central catalogue. Two per row on desktop.', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'             => 'field_' . $key . '_action_cards_cards_title',
							'label'           => __( 'Title', 'agencecinq' ),
							'name'            => 'title',
							'aria-label'      => __( 'Title', 'agencecinq' ),
							'type'            => 'text',
							'required'        => 1,
							'placeholder'     => __( 'Your showcase site has stayed old-fashioned', 'agencecinq' ),
							'parent_repeater' => 'field_' . $key . '_action_cards_cards',
						),
						array(
							'key'             => 'field_' . $key . '_action_cards_cards_text',
							'label'           => __( 'Text', 'agencecinq' ),
							'name'            => 'text',
							'aria-label'      => __( 'Text', 'agencecinq' ),
							'type'            => 'textarea',
							'rows'            => 2,
							'new_lines'       => '',
							'parent_repeater' => 'field_' . $key . '_action_cards_cards',
						),
						array(
							'key'             => 'field_' . $key . '_action_cards_cards_offer',
							'label'           => __( 'Offer', 'agencecinq' ),
							'name'            => 'offer',
							'aria-label'      => __( 'Offer', 'agencecinq' ),
							'type'            => 'text',
							'placeholder'     => __( 'e.g. WordPress redesign', 'agencecinq' ),
							'wrapper'         => array(
								'width' => 4 * 100 / 12,
							),
							'parent_repeater' => 'field_' . $key . '_action_cards_cards',
						),
						array(
							'key'             => 'field_' . $key . '_action_cards_cards_package',
							'label'           => __( 'Package', 'agencecinq' ),
							'name'            => 'package',
							'aria-label'      => __( 'Package', 'agencecinq' ),
							'type'            => 'select',
							'choices'         => CatalogueChoices::package_ids(),
							'allow_null'      => 1,
							'ui'              => 1,
							'instructions'    => __( 'The offer starts at this package: « From » its price.', 'agencecinq' ),
							'wrapper'         => array(
								'width' => 4 * 100 / 12,
							),
							'parent_repeater' => 'field_' . $key . '_action_cards_cards',
						),
						array(
							'key'             => 'field_' . $key . '_action_cards_cards_retainer',
							'label'           => __( 'Retainer', 'agencecinq' ),
							'name'            => 'retainer',
							'aria-label'      => __( 'Retainer', 'agencecinq' ),
							'type'            => 'select',
							'choices'         => CatalogueChoices::retainers(),
							'allow_null'      => 1,
							'ui'              => 1,
							'instructions'    => __( 'Optional. The monthly follow-up after the package: its price, then the price per month.', 'agencecinq' ),
							'wrapper'         => array(
								'width' => 4 * 100 / 12,
							),
							'parent_repeater' => 'field_' . $key . '_action_cards_cards',
						),
						array(
							'key'             => 'field_' . $key . '_action_cards_cards_link',
							'label'           => __( 'Link', 'agencecinq' ),
							'name'            => 'link',
							'aria-label'      => __( 'Link', 'agencecinq' ),
							'type'            => 'link',
							'return_format'   => 'array',
							'default_value'   => array(
								'title'  => __( 'See this situation', 'agencecinq' ),
								'url'    => '',
								'target' => '',
							),
							'instructions'    => __( 'The page of the situation. Screen readers hear the title of the card after the label.', 'agencecinq' ),
							'parent_repeater' => 'field_' . $key . '_action_cards_cards',
						),
					),
				),
				...AcfFieldHelpers::settings( $key . '_action_cards' ),
			),
		);
	}
}
