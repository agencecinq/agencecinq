<?php // phpcs:ignore
/**
 * Post Fields
 *
 * @package WordPress
 * @subpackage AgenceCinq
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields;

use AgenceCinq\Service;

/**
 * Post Fields
 */
class PostFields implements Service {

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
		$key            = 'post';
		$hide_on_screen = array();
		$location       = array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'post',
				),
			),
		);

		$fields = array(
			array(
				'key'        => 'field_' . $key . '_related_cases_tab',
				'label'      => __( 'Related Cases', 'agencecinq' ),
				'name'       => 'related_cases_tab',
				'aria-label' => __( 'Related Cases', 'agencecinq' ),
				'type'       => 'tab',
			),
			array(
				'key'          => 'field_' . $key . '_related_cases',
				'label'        => __( 'Related Cases', 'agencecinq' ),
				'name'         => 'related_cases',
				'aria-label'   => __( 'Related Cases', 'agencecinq' ),
				'type'         => 'repeater',
				'layout'       => 'block',
				'min'          => 0,
				'max'          => 3,
				'button_label' => __( 'Add Case Study', 'agencecinq' ),
				'instructions' => __( 'Two or three related cases at the end of the article. The link anchor is the client name, never See also.', 'agencecinq' ),
				'sub_fields'   => array(
					array(
						'key'             => 'field_' . $key . '_related_cases_case_study',
						'label'           => __( 'Case study', 'agencecinq' ),
						'name'            => 'case_study',
						'aria-label'      => __( 'Case study', 'agencecinq' ),
						'type'            => 'post_object',
						'post_type'       => array( 'case-study' ),
						'return_format'   => 'id',
						'ui'              => 1,
						'parent_repeater' => 'field_' . $key . '_related_cases',
					),
					array(
						'key'             => 'field_' . $key . '_related_cases_text',
						'label'           => __( 'Text', 'agencecinq' ),
						'name'            => 'text',
						'aria-label'      => __( 'Text', 'agencecinq' ),
						'type'            => 'text',
						'placeholder'     => __( 'site public + configurateur produit', 'agencecinq' ),
						'instructions'    => __( 'Short description after the platform. Optional.', 'agencecinq' ),
						'parent_repeater' => 'field_' . $key . '_related_cases',
					),
				),
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {

			acf_add_local_field_group(
				array(
					'key'      => 'group_' . $key,
					'title'    => __( 'Post Fields', 'agencecinq' ),
					'fields'   => $fields,
					'location' => $location,
				)
			);

		}
	}
}
