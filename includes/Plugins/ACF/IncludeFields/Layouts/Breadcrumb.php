<?php
/**
 * ACF layout: Breadcrumb
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Breadcrumb block layout.
 */
class Breadcrumb {

	/**
	 * Returns the layout array for the Breadcrumb block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_breadcrumb',
			'name'       => 'breadcrumb',
			'label'      => __( 'Breadcrumb', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'     => 'field_' . $key . '_breadcrumb_message',
					'label'   => __( 'Breadcrumb', 'agencecinq' ),
					'name'    => '',
					'type'    => 'message',
					'message' => __( 'The levels down to the page, from Yoast SEO. Place it first, above the Page header. Recommended paddings: 24px top, 0 bottom.', 'agencecinq' ),
				),
				...AcfFieldHelpers::settings( $key . '_breadcrumb' ),
			),
		);
	}
}
