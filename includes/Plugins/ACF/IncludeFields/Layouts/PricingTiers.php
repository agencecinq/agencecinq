<?php
/**
 * ACF layout: PricingTiers
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Catalogue\Catalogue;
use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;
use AgenceCinq\Plugins\ACF\IncludeFields\CatalogueChoices;

/**
 * Pricing Tiers block layout.
 */
class PricingTiers {

	/**
	 * Returns the layout array for the Pricing Tiers block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_pricing_tiers',
			'name'       => 'pricing_tiers',
			'label'      => __( 'Pricing Tiers', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_pricing_tiers_content_tab',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_pricing_tiers_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'         => 'field_' . $key . '_pricing_tiers_content_title',
							'label'       => __( 'Title', 'agencecinq' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'Enter the title of the block', 'agencecinq' ),
						),
						array(
							'key'        => 'field_' . $key . '_pricing_tiers_content_heading',
							'label'      => __( 'Heading', 'agencecinq' ),
							'name'       => 'heading',
							'aria-label' => __( 'Heading', 'agencecinq' ),
							'type'       => 'clone',
							'clone'      => array( 'field_clones_heading' ),
							'display'    => 'seamless',
							'layout'     => 'block',
						),
						array(
							'key'         => 'field_' . $key . '_pricing_tiers_content_text',
							'label'       => __( 'Text', 'agencecinq' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'agencecinq' ),
							'type'        => 'textarea',
							'rows'        => 4,
							'new_lines'   => 'br',
							'placeholder' => __( 'Enter the introductory text of the block', 'agencecinq' ),
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_pricing_tiers_tab_items',
					'label'      => __( 'Tiers', 'agencecinq' ),
					'aria-label' => __( 'Tiers', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'           => 'field_' . $key . '_pricing_tiers_source',
					'label'         => __( 'Source', 'agencecinq' ),
					'name'          => 'source',
					'aria-label'    => __( 'Source', 'agencecinq' ),
					'type'          => 'button_group',
					'choices'       => array(
						'catalogue' => __( 'Packages', 'agencecinq' ),
						'retainers' => __( 'Retainers', 'agencecinq' ),
						'modules'   => __( 'Modules', 'agencecinq' ),
						'manual'    => __( 'Manual', 'agencecinq' ),
					),
					'default_value' => 'manual',
					'return_format' => 'value',
					'instructions'  => __( 'Packages, Retainers, Modules: the cards, prices, badges and included lines come from Central and follow its changes within the minute. Manual: for an offer outside the catalogue.', 'agencecinq' ),
				),
				array(
					'key'               => 'field_' . $key . '_pricing_tiers_catalogue',
					'label'             => __( 'Catalogue', 'agencecinq' ),
					'name'              => 'catalogue',
					'aria-label'        => __( 'Catalogue', 'agencecinq' ),
					'type'              => 'group',
					'layout'            => 'block',
					'conditional_logic' => self::when_source( $key, 'catalogue', 'retainers', 'modules' ),
					'sub_fields'        => array(
						array(
							'key'           => 'field_' . $key . '_pricing_tiers_catalogue_platform',
							'label'         => __( 'Platform', 'agencecinq' ),
							'name'          => 'platform',
							'aria-label'    => __( 'Platform', 'agencecinq' ),
							'type'          => 'select',
							'choices'       => CatalogueChoices::platforms(),
							'return_format' => 'value',
							'instructions'  => __( 'In the order of the catalogue, with the first four included lines. A package shows its lead time, a retainer its response time, a module its benefit.', 'agencecinq' ),
							'wrapper'       => array( 'width' => 100 / 3 ),
						),
						array(
							'key'           => 'field_' . $key . '_pricing_tiers_catalogue_featured',
							'label'         => __( 'Featured', 'agencecinq' ),
							'name'          => 'featured',
							'aria-label'    => __( 'Featured', 'agencecinq' ),
							'type'          => 'select',
							'choices'       => CatalogueChoices::lines(),
							'allow_null'    => 1,
							'return_format' => 'value',
							'instructions'  => __( 'Card to highlight (pistachio border and soft fill).', 'agencecinq' ),
							'wrapper'       => array( 'width' => 100 / 3 ),
						),
						array(
							'key'          => 'field_' . $key . '_pricing_tiers_catalogue_badge',
							'label'        => __( 'Badge', 'agencecinq' ),
							'name'         => 'badge',
							'aria-label'   => __( 'Badge', 'agencecinq' ),
							'type'         => 'text',
							'placeholder'  => __( 'e.g. Most chosen', 'agencecinq' ),
							'instructions' => __( 'Shown on the featured card, instead of its lead time or response time.', 'agencecinq' ),
							'wrapper'      => array( 'width' => 100 / 3 ),
						),
						array(
							'key'               => 'field_' . $key . '_pricing_tiers_catalogue_packages',
							'label'             => __( 'Packages', 'agencecinq' ),
							'name'              => 'packages',
							'aria-label'        => __( 'Packages', 'agencecinq' ),
							'type'              => 'checkbox',
							'choices'           => CatalogueChoices::packages(),
							'layout'            => 'horizontal',
							'return_format'     => 'value',
							'instructions'      => __( 'Packages of the platform to show. None ticked: every package of the platform.', 'agencecinq' ),
							'conditional_logic' => self::when_source( $key, 'catalogue' ),
						),
						array(
							'key'               => 'field_' . $key . '_pricing_tiers_catalogue_modules',
							'label'             => __( 'Modules', 'agencecinq' ),
							'name'              => 'modules',
							'aria-label'        => __( 'Modules', 'agencecinq' ),
							'type'              => 'checkbox',
							'choices'           => CatalogueChoices::modules(),
							'layout'            => 'vertical',
							'return_format'     => 'value',
							'required'          => 1,
							'instructions'      => __( 'Up to four modules of the platform to show.', 'agencecinq' ),
							'conditional_logic' => self::when_source( $key, 'modules' ),
						),
					),
				),
				array(
					'key'               => 'field_' . $key . '_pricing_tiers_items',
					'label'             => __( 'Tiers', 'agencecinq' ),
					'name'              => 'items',
					'aria-label'        => __( 'Tiers', 'agencecinq' ),
					'type'              => 'repeater',
					'layout'            => 'block',
					'min'               => 1,
					'max'               => 4,
					'button_label'      => __( 'Add Tier', 'agencecinq' ),
					'instructions'      => __( 'Up to four pricing cards in a row. Highlight at most one tier.', 'agencecinq' ),
					'conditional_logic' => self::when_source( $key, 'manual' ),
					'sub_fields'        => array(
						array(
							'key'             => 'field_' . $key . '_pricing_tiers_items_featured',
							'label'           => __( 'Featured', 'agencecinq' ),
							'name'            => 'featured',
							'aria-label'      => __( 'Featured', 'agencecinq' ),
							'type'            => 'true_false',
							'default_value'   => 0,
							'message'         => __( 'Highlight this tier (pistachio border and soft fill).', 'agencecinq' ),
							'parent_repeater' => 'field_' . $key . '_pricing_tiers_items',
						),
						array(
							'key'             => 'field_' . $key . '_pricing_tiers_items_badge',
							'label'           => __( 'Badge', 'agencecinq' ),
							'name'            => 'badge',
							'aria-label'      => __( 'Badge', 'agencecinq' ),
							'type'            => 'text',
							'placeholder'     => __( 'e.g. Most chosen', 'agencecinq' ),
							'instructions'    => __( 'Optional uppercase mono label. Independent of the featured highlight.', 'agencecinq' ),
							'parent_repeater' => 'field_' . $key . '_pricing_tiers_items',
						),
						array(
							'key'             => 'field_' . $key . '_pricing_tiers_items_name',
							'label'           => __( 'Title', 'agencecinq' ),
							'name'            => 'name',
							'aria-label'      => __( 'Title', 'agencecinq' ),
							'type'            => 'text',
							'placeholder'     => __( 'Enter the name of the tier', 'agencecinq' ),
							'parent_repeater' => 'field_' . $key . '_pricing_tiers_items',
						),
						array(
							'key'             => 'field_' . $key . '_pricing_tiers_items_priceExclVat',
							'label'           => __( 'Price', 'agencecinq' ),
							'name'            => 'priceExclVat',
							'aria-label'      => __( 'Price', 'agencecinq' ),
							'type'            => 'number',
							'min'             => 0,
							'placeholder'     => __( 'e.g. 14900', 'agencecinq' ),
							'append'          => __( '€ excl. VAT', 'agencecinq' ),
							'instructions'    => __( 'Global price, without a day rate or a number of days. Leave it empty on quote.', 'agencecinq' ),
							'wrapper'         => array( 'width' => 50 ),
							'parent_repeater' => 'field_' . $key . '_pricing_tiers_items',
						),
						array(
							'key'             => 'field_' . $key . '_pricing_tiers_items_priceMode',
							'label'           => __( 'Price Mode', 'agencecinq' ),
							'name'            => 'priceMode',
							'aria-label'      => __( 'Price Mode', 'agencecinq' ),
							'type'            => 'select',
							'choices'         => CatalogueChoices::price_modes(),
							'default_value'   => Catalogue::FIRM,
							'return_format'   => 'value',
							'wrapper'         => array( 'width' => 50 ),
							'parent_repeater' => 'field_' . $key . '_pricing_tiers_items',
						),
						array(
							'key'             => 'field_' . $key . '_pricing_tiers_items_included',
							'label'           => __( 'Included', 'agencecinq' ),
							'name'            => 'included',
							'aria-label'      => __( 'Included', 'agencecinq' ),
							'type'            => 'repeater',
							'layout'          => 'block',
							'max'             => 4,
							'button_label'    => __( 'Add Line', 'agencecinq' ),
							'instructions'    => __( 'Up to four included lines.', 'agencecinq' ),
							'parent_repeater' => 'field_' . $key . '_pricing_tiers_items',
							'sub_fields'      => array(
								array(
									'key'             => 'field_' . $key . '_pricing_tiers_items_included_text',
									'label'           => __( 'Text', 'agencecinq' ),
									'name'            => 'text',
									'aria-label'      => __( 'Text', 'agencecinq' ),
									'type'            => 'text',
									'placeholder'     => __( 'Enter the included line', 'agencecinq' ),
									'parent_repeater' => 'field_' . $key . '_pricing_tiers_items_included',
								),
							),
						),
					),
				),
				...AcfFieldHelpers::settings( $key . '_pricing_tiers' ),
			),
		);
	}

	/**
	 * Conditional logic: shows a field for some sources only.
	 *
	 * @param string $key        The field key prefix.
	 * @param string ...$sources 'catalogue', 'retainers', 'modules' or 'manual'.
	 * @return array<int, array<int, array<string, string>>>
	 */
	private static function when_source( string $key, string ...$sources ): array {
		return array_map(
			static fn( string $source ): array => array(
				array(
					'field'    => 'field_' . $key . '_pricing_tiers_source',
					'operator' => '==',
					'value'    => $source,
				),
			),
			$sources
		);
	}
}
