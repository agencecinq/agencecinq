<?php
/**
 * ACF layout: ChildPages
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn/Plugins/ACF/IncludeFields/Layouts
 */

namespace WPCinquanteEtUn\Plugins\ACF\IncludeFields\Layouts;

use WPCinquanteEtUn\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * ChildPages block layout.
 */
class ChildPages {

	/**
	 * Returns the layout array for the ChildPages block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_child_pages',
			'name'       => 'child_pages',
			'label'      => __( 'Child Pages', 'wp-cinquante-et-un' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_child_pages_message',
					'label'      => __( 'Message', 'wp-cinquante-et-un' ),
					'name'       => 'message',
					'aria-label' => __( 'Message', 'wp-cinquante-et-un' ),
					'type'       => 'message',
					'message'    => __( 'Displays the child pages of the current page. Hidden when there are no child pages.', 'wp-cinquante-et-un' ),
				),
				...AcfFieldHelpers::settings( $key . '_child_pages' ),
			),
		);
	}
}
