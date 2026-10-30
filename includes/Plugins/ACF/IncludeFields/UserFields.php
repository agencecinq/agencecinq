<?php
/**
 * User Fields
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields;

use AgenceCinq\Service;

/**
 * User Fields
 *
 * The author of a post: the job next to the name and the portrait, the biography being the native one.
 */
class UserFields implements Service {

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
	public function fields(): void {
		$key = 'user';

		$location = array(
			array(
				array(
					'param'    => 'user_form',
					'operator' => '==',
					'value'    => 'all',
				),
			),
		);

		$fields = array(
			array(
				'key'          => 'field_' . $key . '_job',
				'label'        => __( 'Job', 'agencecinq' ),
				'name'         => 'job',
				'aria-label'   => __( 'Job', 'agencecinq' ),
				'type'         => 'text',
				'placeholder'  => __( 'e.g. head of the agency', 'agencecinq' ),
				'instructions' => __( 'After the name, at the top of the posts.', 'agencecinq' ),
			),
			array(
				'key'           => 'field_' . $key . '_portrait',
				'label'         => __( 'Portrait', 'agencecinq' ),
				'name'          => 'portrait',
				'aria-label'    => __( 'Portrait', 'agencecinq' ),
				'type'          => 'image',
				'return_format' => 'id',
				'preview_size'  => 'thumbnail',
				'library'       => 'all',
				'instructions'  => __( 'Square, in black and white, at the top and the end of the posts. The name is written next to it, so it needs no alternative text.', 'agencecinq' ),
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group(
				array(
					'key'      => 'group_' . $key,
					'title'    => __( 'Author', 'agencecinq' ),
					'fields'   => $fields,
					'location' => $location,
				)
			);
		}
	}
}
