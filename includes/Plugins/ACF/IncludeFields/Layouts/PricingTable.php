<?php
/**
 * ACF layout: Pricing table
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;
use AgenceCinq\Plugins\ACF\IncludeFields\CatalogueChoices;

/**
 * Pricing table block layout.
 */
class PricingTable {

	/**
	 * Returns the layout array for the Pricing table block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_pricing_table',
			'name'       => 'pricing_table',
			'label'      => __( 'Pricing table', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_pricing_table_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_pricing_table_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'         => 'field_' . $key . '_pricing_table_content_eyebrow',
							'label'       => __( 'Eyebrow', 'agencecinq' ),
							'name'        => 'eyebrow',
							'aria-label'  => __( 'Eyebrow', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'Pricing', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_pricing_table_content_title',
							'label'       => __( 'Title', 'agencecinq' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'Shopify store creation', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_pricing_table_content_text',
							'label'       => __( 'Text', 'agencecinq' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'agencecinq' ),
							'type'        => 'textarea',
							'rows'        => 3,
							'new_lines'   => '',
							'placeholder' => __( 'Enter the lead text of the block', 'agencecinq' ),
						),
						array(
							'key'        => 'field_' . $key . '_pricing_table_content_heading',
							'label'      => __( 'Heading', 'agencecinq' ),
							'name'       => 'heading',
							'aria-label' => __( 'Heading', 'agencecinq' ),
							'type'       => 'clone',
							'clone'      => array( 'field_clones_heading' ),
							'display'    => 'seamless',
							'layout'     => 'block',
						),
						array(
							'key'           => 'field_' . $key . '_pricing_table_content_note',
							'label'         => __( 'Note', 'agencecinq' ),
							'name'          => 'note',
							'aria-label'    => __( 'Note', 'agencecinq' ),
							'type'          => 'text',
							'default_value' => __( 'Public prices, excluding tax. The Figma file and the code are in your name.', 'agencecinq' ),
							'instructions'  => __( 'Line under the cards.', 'agencecinq' ),
						),
						array(
							'key'           => 'field_' . $key . '_pricing_table_content_link',
							'label'         => __( 'Link', 'agencecinq' ),
							'name'          => 'link',
							'aria-label'    => __( 'Link', 'agencecinq' ),
							'type'          => 'link',
							'return_format' => 'array',
							'default_value' => array(
								'title'  => __( 'Book 30 minutes', 'agencecinq' ),
								'url'    => '',
								'target' => '',
							),
							'instructions'  => __( 'Primary CTA. Default label: Book 30 minutes. The diagnostic is never a first click.', 'agencecinq' ),
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_pricing_table_tab_catalogue',
					'label'      => __( 'Catalogue', 'agencecinq' ),
					'aria-label' => __( 'Catalogue', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_pricing_table_catalogue',
					'label'        => __( 'Catalogue', 'agencecinq' ),
					'name'         => 'catalogue',
					'aria-label'   => __( 'Catalogue', 'agencecinq' ),
					'type'         => 'group',
					'layout'       => 'block',
					'instructions' => __( 'The cards, their price, lead time or response time and three included lines come from Central, which is authoritative: check it before publishing. Three per row on desktop.', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'           => 'field_' . $key . '_pricing_table_catalogue_source',
							'label'         => __( 'Range', 'agencecinq' ),
							'name'          => 'source',
							'aria-label'    => __( 'Range', 'agencecinq' ),
							'type'          => 'button_group',
							'choices'       => array(
								'catalogue' => __( 'Packages', 'agencecinq' ),
								'retainers' => __( 'Retainers', 'agencecinq' ),
							),
							'default_value' => 'catalogue',
							'return_format' => 'value',
							'wrapper'       => array(
								'width' => 6 * 100 / 12,
							),
						),
						array(
							'key'           => 'field_' . $key . '_pricing_table_catalogue_platform',
							'label'         => __( 'Platform', 'agencecinq' ),
							'name'          => 'platform',
							'aria-label'    => __( 'Platform', 'agencecinq' ),
							'type'          => 'select',
							'choices'       => CatalogueChoices::platforms(),
							'return_format' => 'value',
							'wrapper'       => array(
								'width' => 6 * 100 / 12,
							),
						),
						array(
							'key'               => 'field_' . $key . '_pricing_table_catalogue_packages',
							'label'             => __( 'Packages', 'agencecinq' ),
							'name'              => 'packages',
							'aria-label'        => __( 'Packages', 'agencecinq' ),
							'type'              => 'checkbox',
							'choices'           => CatalogueChoices::packages(),
							'layout'            => 'horizontal',
							'return_format'     => 'value',
							'instructions'      => __( 'Packages of the platform to show. None ticked: every package of the platform.', 'agencecinq' ),
							'conditional_logic' => array(
								array(
									array(
										'field'    => 'field_' . $key . '_pricing_table_catalogue_source',
										'operator' => '==',
										'value'    => 'catalogue',
									),
								),
							),
						),
					),
				),
				...AcfFieldHelpers::settings( $key . '_pricing_table' ),
			),
		);
	}
}
