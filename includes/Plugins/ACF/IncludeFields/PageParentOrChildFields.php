<?php
/**
 * PageParentOrChildFields
 *
 * Registers ACF field group for pages that have a parent and/or at least one child.
 *
 * @package WPCinquanteEtUn
 * @subpackage WPCinquanteEtUn/Plugins/ACF/IncludeFields
 */

namespace WPCinquanteEtUn\Plugins\ACF\IncludeFields;

use WPCinquanteEtUn\Service;

/**
 * Page Parent Or Child Fields
 *
 * Loads advanced custom fields for pages that have a parent OR at least one child.
 */
class PageParentOrChildFields implements Service {

	/**
	 * Register ACF field group include for pages with parent or children.
	 *
	 * @return void
	 */
	public function run(): void {
		add_filter( 'acf/include_fields', array( $this, 'fields' ) );
	}

	/**
	 * Registers the field group.
	 *
	 * @return void
	 */
	public function fields(): void {
		$key            = 'page_parent_or_child';
		$hide_on_screen = array();

		$location = array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'page',
				),
				array(
					'param'    => 'page_type',
					'operator' => '==',
					'value'    => 'parent',
				),
			),
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'page',
				),
				array(
					'param'    => 'page_type',
					'operator' => '==',
					'value'    => 'child',
				),
			),
		);

		$fields = array(
			array(
				'key'        => 'field_' . $key . '_general_tab',
				'label'      => __( 'General', 'wp-cinquante-et-un' ),
				'aria-label' => __( 'General', 'wp-cinquante-et-un' ),
				'type'       => 'tab',
			),
			array(
				'key'          => 'field_' . $key . '_general',
				'label'        => __( 'General', 'wp-cinquante-et-un' ),
				'name'         => 'general',
				'aria-label'   => __( 'General', 'wp-cinquante-et-un' ),
				'type'         => 'group',
				'instructions' => __( 'General settings for the page.', 'wp-cinquante-et-un' ),
				'layout'       => 'block',
				'sub_fields'   => array(
					array(
						'key'          => 'field_' . $key . '_general_title',
						'label'        => __( 'Title', 'wp-cinquante-et-un' ),
						'name'         => 'title',
						'aria-label'   => __( 'Title', 'wp-cinquante-et-un' ),
						'type'         => 'text',
						'placeholder'  => __( 'Page title', 'wp-cinquante-et-un' ),
						'instructions' => __( 'Enter the title of the page. Will be used as the page title.', 'wp-cinquante-et-un' ),
					),
					array(
						'key'          => 'field_' . $key . '_general_headline',
						'label'        => __( 'Headline', 'wp-cinquante-et-un' ),
						'name'         => 'headline',
						'aria-label'   => __( 'Headline', 'wp-cinquante-et-un' ),
						'type'         => 'text',
						'placeholder'  => __( 'Page headline', 'wp-cinquante-et-un' ),
						'instructions' => __( 'Enter the headline of the page. Will be used as the page headline in the tease page block for instance. If empty, the page title will be used.', 'wp-cinquante-et-un' ),
					),
				),
			),
			...AcfFieldHelpers::media( $key ),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group(
				array(
					'key'        => 'group_' . $key,
					'title'      => __( 'Page Parent Or Child Fields', 'wp-cinquante-et-un' ),
					'fields'     => $fields,
					'location'   => $location,
					'menu_order' => 1,
				)
			);
		}
	}
}
