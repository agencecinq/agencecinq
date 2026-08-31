<?php
/**
 * PageParentOrChildFields
 *
 * Registers ACF field group for pages that have a parent and/or at least one child.
 *
 * @package AgenceCinq
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields;

use AgenceCinq\Service;

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
				'label'      => __( 'General', 'agencecinq' ),
				'aria-label' => __( 'General', 'agencecinq' ),
				'type'       => 'tab',
			),
			array(
				'key'          => 'field_' . $key . '_general',
				'label'        => __( 'General', 'agencecinq' ),
				'name'         => 'general',
				'aria-label'   => __( 'General', 'agencecinq' ),
				'type'         => 'group',
				'instructions' => __( 'General settings for the page.', 'agencecinq' ),
				'layout'       => 'block',
				'sub_fields'   => array(
					array(
						'key'          => 'field_' . $key . '_general_title',
						'label'        => __( 'Title', 'agencecinq' ),
						'name'         => 'title',
						'aria-label'   => __( 'Title', 'agencecinq' ),
						'type'         => 'text',
						'placeholder'  => __( 'Page title', 'agencecinq' ),
						'instructions' => __( 'Enter the title of the page. Will be used as the page title.', 'agencecinq' ),
					),
					array(
						'key'          => 'field_' . $key . '_general_headline',
						'label'        => __( 'Headline', 'agencecinq' ),
						'name'         => 'headline',
						'aria-label'   => __( 'Headline', 'agencecinq' ),
						'type'         => 'text',
						'placeholder'  => __( 'Page headline', 'agencecinq' ),
						'instructions' => __( 'Enter the headline of the page. Will be used as the page headline in the tease page block for instance. If empty, the page title will be used.', 'agencecinq' ),
					),
				),
			),
			...AcfFieldHelpers::media( $key ),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group(
				array(
					'key'        => 'group_' . $key,
					'title'      => __( 'Page Parent Or Child Fields', 'agencecinq' ),
					'fields'     => $fields,
					'location'   => $location,
					'menu_order' => 1,
				)
			);
		}
	}
}
