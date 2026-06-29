<?php
/**
 * ACF layout: Styleguide
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn/Plugins/ACF/IncludeFields/Layouts
 */

namespace WPCinquanteEtUn\Plugins\ACF\IncludeFields\Layouts;

/**
 * Styleguide block layout.
 */
class Styleguide {

	/**
	 * Returns the layout array for the Styleguide block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_styleguide',
			'name'       => 'styleguide',
			'label'      => __( 'Styleguide', 'wp-cinquante-et-un' ),
			'display'    => 'block',
			'sub_fields' => array(),
		);
	}
}
