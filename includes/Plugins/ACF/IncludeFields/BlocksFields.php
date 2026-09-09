<?php
/**
 * Blocks Fields
 *
 * Registers ACF field group includes for blocks.
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields;

use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\AccordionGroup;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\CallToAction;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\EntryPoints;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\Hero;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\LatestPosts;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\PageHero;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\PositioningBanner;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\PricingRules;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\PricingTiers;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\References;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\Services;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\Styleguide;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\Subscriptions;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\Team;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\VerticalPipeline;
use AgenceCinq\Service;

/**
 * Blocks Fields
 *
 * Loads advanced custom fields for blocks.
 */
class BlocksFields implements Service {

	/**
	 * Layout classes used for the blocks field (pages and case studies). Order = display order.
	 *
	 * @var array<int, class-string>
	 */
	private static $layouts = array(
		AccordionGroup::class,
		CallToAction::class,
		EntryPoints::class,
		Hero::class,
		LatestPosts::class,
		PageHero::class,
		PositioningBanner::class,
		PricingRules::class,
		PricingTiers::class,
		References::class,
		Services::class,
		Styleguide::class,
		Subscriptions::class,
		Team::class,
		VerticalPipeline::class,
	);

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run(): void {
		add_action( 'acf/include_fields', array( $this, 'fields' ) );
	}

	/**
	 * Registers the field group.
	 *
	 * @return void
	 */
	public function fields() {
		$key            = 'blocks';
		$hide_on_screen = array();

		$location = array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'page',
				),
			),
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'case-study',
				),
			),
		);

		$fields = array(
			array(
				'key'          => 'field_' . $key,
				'label'        => __( 'Blocks', 'agencecinq' ),
				'name'         => 'blocks',
				'aria-label'   => __( 'Blocks', 'agencecinq' ),
				'type'         => 'flexible_content',
				'instructions' => __( 'Add and arrange blocks to build the page content.', 'agencecinq' ),
				'layouts'      => AcfFieldHelpers::get_layouts_from( $key, self::$layouts ),
				'button_label' => __( 'Add Block', 'agencecinq' ),
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group(
				array(
					'key'        => 'group_' . $key,
					'title'      => __( 'Blocks Fields', 'agencecinq' ),
					'fields'     => $fields,
					'location'   => $location,
					'menu_order' => 1,
				)
			);
		}
	}
}
