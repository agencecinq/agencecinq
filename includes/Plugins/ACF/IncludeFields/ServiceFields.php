<?php
/**
 * Service Fields
 *
 * Registers the service type of a page in a side metabox. A page with a
 * service type declares the service it sells in the Yoast schema graph.
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields;

use AgenceCinq\Service;

/**
 * Service Fields
 *
 * Loads the service type field on pages.
 */
class ServiceFields implements Service {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run(): void {
		add_action( 'acf/include_fields', array( $this, 'fields' ) );
	}

	/**
	 * Registers the field group in the side column.
	 *
	 * @return void
	 */
	public function fields(): void {
		$key = 'service';

		$location = array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'page',
				),
			),
		);

		$fields = array(
			array(
				'key'          => 'field_' . $key . '_type',
				'label'        => __( 'Service type', 'agencecinq' ),
				'name'         => 'service_type',
				'aria-label'   => __( 'Service type', 'agencecinq' ),
				'type'         => 'text',
				'placeholder'  => __( 'e.g. Shopify store creation', 'agencecinq' ),
				'instructions' => __( 'Filled on a service page only: it declares the service in the structured data, with the prices of its pricing tables.', 'agencecinq' ),
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group(
				array(
					'key'                   => 'group_' . $key,
					'title'                 => __( 'Service', 'agencecinq' ),
					'fields'                => $fields,
					'location'              => $location,
					'menu_order'            => 10,
					'position'              => 'side',
					'style'                 => 'default',
					'label_placement'       => 'top',
					'instruction_placement' => 'label',
					'active'                => true,
				)
			);
		}
	}
}
