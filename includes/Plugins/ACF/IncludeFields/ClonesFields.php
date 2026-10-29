<?php // phpcs:ignore
/**
 * Clones Fields
 *
 * @package WordPress
 * @subpackage AgenceCinq
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields;

use AgenceCinq\Service;

/**
 * Clones Fields
 */
class ClonesFields implements Service {

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
		$key            = 'clones';
		$hide_on_screen = array();
		$location       = array();

		$fields = array(
			array(
				'key'          => 'field_' . $key . '_layout',
				'label'        => __( 'Layout', 'agencecinq' ),
				'name'         => 'layout',
				'aria-label'   => __( 'Layout', 'agencecinq' ),
				'type'         => 'group',
				'instructions' => __( 'Layout settings for the block.', 'agencecinq' ),
				'layout'       => 'block',
				'sub_fields'   => array(
					array(
						'key'           => 'field_' . $key . '_layout_color_scheme',
						'label'         => __( 'Color scheme', 'agencecinq' ),
						'name'          => 'color_scheme',
						'aria-label'    => __( 'Color scheme', 'agencecinq' ),
						'type'          => 'button_group',
						'instructions'  => __( 'Colors of the section, the Figma modes: Dark like the page, or Light to set it apart.', 'agencecinq' ),
						'choices'       => wp_list_pluck( cinq_schemes(), 'label' ),
						'default_value' => '',
						'return_format' => 'value',
						'layout'        => 'horizontal',
					),
					array(
						'key'          => 'field_' . $key . '_layout_paddings',
						'label'        => __( 'Paddings', 'agencecinq' ),
						'name'         => 'paddings',
						'aria-label'   => __( 'Paddings', 'agencecinq' ),
						'type'         => 'group',
						'instructions' => __( 'Padding settings for the block on desktop. On mobile paddings are multiplied by 0.75.', 'agencecinq' ) . '<br>' . __( "Don't forget to add extra padding on blocks that precede or follow by a rounded block.", 'agencecinq' ),
						'layout'       => 'block',
						'sub_fields'   => array(
							array(
								'key'           => 'field_' . $key . '_layout_paddings_top',
								'label'         => __( 'Top', 'agencecinq' ),
								'name'          => 'top',
								'aria-label'    => __( 'Top', 'agencecinq' ),
								'type'          => 'number',
								'instructions'  => __( 'Top padding in pixels', 'agencecinq' ),
								'default_value' => 104,
								'min'           => 0,
								'step'          => 1,
								'append'        => __( 'px', 'agencecinq' ),
								'wrapper'       => array(
									'width' => 6 * 100 / 12,
								),
							),
							array(
								'key'           => 'field_' . $key . '_layout_paddings_bottom',
								'label'         => __( 'Bottom', 'agencecinq' ),
								'name'          => 'bottom',
								'aria-label'    => __( 'Bottom', 'agencecinq' ),
								'type'          => 'number',
								'instructions'  => __( 'Bottom padding in pixels', 'agencecinq' ),
								'default_value' => 104,
								'min'           => 0,
								'step'          => 1,
								'append'        => __( 'px', 'agencecinq' ),
								'wrapper'       => array(
									'width' => 6 * 100 / 12,
								),
							),
						),
					),
				),
			),
			array(
				'key'           => 'field_' . $key . '_heading',
				'label'         => __( 'Heading', 'agencecinq' ),
				'name'          => 'heading',
				'aria-label'    => __( 'Heading', 'agencecinq' ),
				'type'          => 'select',
				'instructions'  => __( 'Choose the heading level for the title of the block. It is important to use heading levels in a hierarchical way for accessibility and SEO reasons.', 'agencecinq' ),
				'choices'       => array(
					'h1' => __( 'H1', 'agencecinq' ),
					'h2' => __( 'H2', 'agencecinq' ),
					'h3' => __( 'H3', 'agencecinq' ),
				),
				'default_value' => 'h2',
				'return_format' => 'value',
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {

			acf_add_local_field_group(
				array(
					'key'      => 'group_' . $key,
					'title'    => __( 'Clones Fields', 'agencecinq' ),
					'fields'   => $fields,
					'location' => $location,
					'active'   => false,
				)
			);

		}
	}
}
