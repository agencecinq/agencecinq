<?php
/**
 * ACF layout: Marquee
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

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
			'label'      => __( 'Marquee', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_marquee' ),
				array(
					'key'           => 'field_' . $key . '_marquee_color_scheme',
					'label'         => __( 'Color Scheme', 'agencecinq' ),
					'name'          => 'color_scheme',
					'aria-label'    => __( 'Color Scheme', 'agencecinq' ),
					'type'          => 'select',
					'choices'       => array(
						'light' => __( 'Light', 'agencecinq' ),
						'dark'  => __( 'Dark', 'agencecinq' ),
					),
					'default_value' => 'light',
					'return_format' => 'value',
				),
				AcfFieldHelpers::radius( $key . '_marquee' ),
				array(
					'key'        => 'field_' . $key . '_marquee_tab_2',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_marquee_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'           => 'field_' . $key . '_marquee_content_title',
							'label'         => __( 'Title', 'agencecinq' ),
							'name'          => 'title',
							'aria-label'    => __( 'Title', 'agencecinq' ),
							'type'          => 'text',
							'placeholder'   => __( 'Enter the title of the block', 'agencecinq' ),
							'default_value' => '',
						),
					),
				),
			),
		);
	}
}
