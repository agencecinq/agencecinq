<?php // phpcs:ignore
/**
 * Post Fields
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn
 */

namespace WPCinquanteEtUn\Plugins\ACF\IncludeFields;

use WPCinquanteEtUn\Service;

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
				'key'        => 'field_' . $key . '_general_tab',
				'label'      => __( 'General', 'wp-cinquante-et-un' ),
				'name'       => 'general',
				'aria-label' => __( 'General', 'wp-cinquante-et-un' ),
				'type'       => 'tab',
			),
			array(
				'key'        => 'field_' . $key . '_general',
				'label'      => __( 'General', 'wp-cinquante-et-un' ),
				'name'       => 'general',
				'aria-label' => __( 'General', 'wp-cinquante-et-un' ),
				'type'       => 'group',
				'layout'     => 'block',
				'sub_fields' => array(
					array(
						'key'          => 'field_' . $key . '_general_subtitle',
						'label'        => __( 'Subtitle', 'wp-cinquante-et-un' ),
						'name'         => 'subtitle',
						'aria-label'   => __( 'Subtitle', 'wp-cinquante-et-un' ),
						'type'         => 'text',
						'placeholder'  => __( 'Enter the subtitle of the post', 'wp-cinquante-et-un' ),
						'instructions' => __( 'Short post subtitle.', 'wp-cinquante-et-un' ) . ' <em>(' . __( 'Optional.', 'wp-cinquante-et-un' ) . ')</em>',
					),
					array(
						'key'        => 'field_' . $key . '_general_learn_more',
						'label'      => __( 'Learn more', 'wp-cinquante-et-un' ),
						'name'       => 'learn_more',
						'aria-label' => __( 'Learn more', 'wp-cinquante-et-un' ),
						'type'       => 'group',
						'layout'     => 'block',
						'sub_fields' => array(
							array(
								'key'          => 'field_' . $key . '_general_learn_more_title',
								'label'        => __( 'Title', 'wp-cinquante-et-un' ),
								'name'         => 'title',
								'aria-label'   => __( 'Title', 'wp-cinquante-et-un' ),
								'type'         => 'text',
								'placeholder'  => __( 'Enter the title of the learn more', 'wp-cinquante-et-un' ),
								'instructions' => __( 'The title of the learn more.', 'wp-cinquante-et-un' ),
							),
							array(
								'key'          => 'field_' . $key . '_general_learn_more_text',
								'label'        => __( 'Text', 'wp-cinquante-et-un' ),
								'name'         => 'text',
								'aria-label'   => __( 'Text', 'wp-cinquante-et-un' ),
								'type'         => 'text',
								'placeholder'  => __( 'Enter the text of the learn more', 'wp-cinquante-et-un' ),
								'instructions' => __( 'The text of the learn more.', 'wp-cinquante-et-un' ),
							),
						),
					),
				),
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {

			acf_add_local_field_group(
				array(
					'key'      => 'group_' . $key,
					'title'    => __( 'Post Fields', 'wp-cinquante-et-un' ),
					'fields'   => $fields,
					'location' => $location,
				)
			);

		}
	}
}
