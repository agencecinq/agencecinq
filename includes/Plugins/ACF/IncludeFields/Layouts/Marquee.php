<?php
/**
 * ACF layout: Marquee
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn/Plugins/ACF/IncludeFields/Layouts
 */

namespace WPCinquanteEtUn\Plugins\ACF\IncludeFields\Layouts;

use WPCinquanteEtUn\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Marquee block layout.
 */
class Marquee {

	/**
	 * Returns the layout array for the Marquee block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_marquee',
			'name'       => 'marquee',
			'label'      => __( 'Marquee', 'wp-cinquante-et-un' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_marquee' ),
				array(
					'key'           => 'field_' . $key . '_marquee_color_scheme',
					'label'         => __( 'Color Scheme', 'wp-cinquante-et-un' ),
					'name'          => 'color_scheme',
					'aria-label'    => __( 'Color Scheme', 'wp-cinquante-et-un' ),
					'type'          => 'select',
					'choices'       => array(
						'light' => __( 'Light', 'wp-cinquante-et-un' ),
						'dark'  => __( 'Dark', 'wp-cinquante-et-un' ),
					),
					'default_value' => 'light',
					'return_format' => 'value',
				),
				AcfFieldHelpers::radius( $key . '_marquee' ),
				array(
					'key'        => 'field_' . $key . '_marquee_tab_2',
					'label'      => __( 'Content', 'wp-cinquante-et-un' ),
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_marquee_content',
					'label'      => __( 'Content', 'wp-cinquante-et-un' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'           => 'field_' . $key . '_marquee_content_title',
							'label'         => __( 'Title', 'wp-cinquante-et-un' ),
							'name'          => 'title',
							'aria-label'    => __( 'Title', 'wp-cinquante-et-un' ),
							'type'          => 'text',
							'placeholder'   => __( 'Enter the title of the block', 'wp-cinquante-et-un' ),
							'default_value' => '',
						),
					),
				),
			),
		);
	}
}
