<?php
/**
 * ACF layout: ChildPages
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

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
			'label'      => __( 'Child Pages', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_child_pages_message',
					'label'      => __( 'Message', 'agencecinq' ),
					'name'       => 'message',
					'aria-label' => __( 'Message', 'agencecinq' ),
					'type'       => 'message',
					'message'    => __( 'Displays the child pages of the current page. Hidden when there are no child pages.', 'agencecinq' ),
				),
				...AcfFieldHelpers::settings( $key . '_child_pages' ),
			),
		);
	}
}
