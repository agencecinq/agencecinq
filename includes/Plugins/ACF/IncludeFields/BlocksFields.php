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

use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\Accordion;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\ActionCards;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\ActivityLog;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\Breadcrumb;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\BulletList;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\Checklist;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\CodeGuide;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\Comparison;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\Configurator;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\ContactDetails;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\CredibilityBanner;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\Cta;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\DiffColumns;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\EditorialCards;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\FeatureCards;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\FormInfo;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\Gallery;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\ImageCards;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\InfoCards;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\LatestPosts;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\LinkGrid;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\LinkRow;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\ListingHeader;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\LogoWall;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\ModuleCatalog;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\NumberedList;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\PageHeader;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\PortraitGrid;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\PositioningBanner;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\PostGrid;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\PriceBreakdown;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\PricingTable;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\Quote;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\RichText;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\SignupForm;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\Stats;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\Steps;
use AgenceCinq\Plugins\ACF\IncludeFields\Layouts\Subscriptions;
use AgenceCinq\Service;

/**
 * Blocks Fields
 *
 * Loads advanced custom fields for blocks.
 */
class BlocksFields implements Service {

	/**
	 * Layout classes used for the blocks field (pages and case studies). Order = display order.
	 * Layouts that implement get_post_types() are hidden on other post types.
	 *
	 * @var array<int, class-string>
	 */
	private static $layouts = array(
		Accordion::class,
		ActionCards::class,
		ActivityLog::class,
		Breadcrumb::class,
		BulletList::class,
		Checklist::class,
		CodeGuide::class,
		Comparison::class,
		Configurator::class,
		ContactDetails::class,
		CredibilityBanner::class,
		Cta::class,
		DiffColumns::class,
		EditorialCards::class,
		FeatureCards::class,
		FormInfo::class,
		Gallery::class,
		ImageCards::class,
		InfoCards::class,
		LatestPosts::class,
		LinkGrid::class,
		LinkRow::class,
		ListingHeader::class,
		LogoWall::class,
		ModuleCatalog::class,
		NumberedList::class,
		PageHeader::class,
		PortraitGrid::class,
		PositioningBanner::class,
		PostGrid::class,
		PriceBreakdown::class,
		PricingTable::class,
		Quote::class,
		RichText::class,
		SignupForm::class,
		Stats::class,
		Steps::class,
		Subscriptions::class,
	);

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run(): void {
		add_action( 'acf/include_fields', array( $this, 'fields' ) );
		add_filter( 'acf/prepare_field/name=blocks', array( $this, 'filter_layouts_by_post_type' ) );
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
					'param'    => 'page_type',
					'operator' => '==',
					'value'    => 'front_page',
				),
			),
			array(
				array(
					'param'    => 'page_template',
					'operator' => '==',
					'value'    => 'page-templates/blocks-page.php',
				),
			),
			array(
				array(
					'param'    => 'page_type',
					'operator' => '==',
					'value'    => 'posts_page',
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

	/**
	 * Hides layouts that are not allowed on the current post type.
	 *
	 * @param mixed $field Field array or false.
	 * @return mixed
	 */
	public function filter_layouts_by_post_type( $field ) {
		if ( ! is_array( $field ) || empty( $field['layouts'] ) || ! is_array( $field['layouts'] ) ) {
			return $field;
		}

		$post_type      = $this->get_current_post_type();
		$hidden_layouts = $this->get_hidden_layout_names( $post_type );

		if ( empty( $hidden_layouts ) ) {
			return $field;
		}

		foreach ( $field['layouts'] as $layout_key => $layout ) {
			$name = $layout['name'] ?? '';

			if ( in_array( $name, $hidden_layouts, true ) ) {
				unset( $field['layouts'][ $layout_key ] );
			}
		}

		return $field;
	}

	/**
	 * Returns layout names that must be hidden for a post type.
	 *
	 * @param string $post_type Current post type.
	 * @return array<int, string>
	 */
	private function get_hidden_layout_names( string $post_type ): array {
		$hidden = array();

		foreach ( self::$layouts as $class ) {
			if ( ! is_callable( array( $class, 'get_post_types' ) ) ) {
				continue;
			}

			$allowed = $class::get_post_types();

			if ( empty( $allowed ) || in_array( $post_type, $allowed, true ) ) {
				continue;
			}

			$layout = $class::get_layout( 'blocks' );
			$name   = $layout['name'] ?? '';

			if ( '' !== $name ) {
				$hidden[] = $name;
			}
		}

		return $hidden;
	}

	/**
	 * Returns the post type of the post currently being edited.
	 *
	 * @return string
	 */
	private function get_current_post_type(): string {
		$post_id = 0;

		if ( function_exists( 'acf_maybe_get_POST' ) ) {
			$post_id = absint( acf_maybe_get_POST( 'post_id' ) );
		}

		if ( ! $post_id && function_exists( 'acf_get_form_data' ) ) {
			$post_id = absint( acf_get_form_data( 'post_id' ) );
		}

		if ( $post_id ) {
			$post_type = get_post_type( $post_id );

			if ( is_string( $post_type ) && '' !== $post_type ) {
				return $post_type;
			}
		}

		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;

		if ( $screen && ! empty( $screen->post_type ) ) {
			return $screen->post_type;
		}

		return '';
	}
}
