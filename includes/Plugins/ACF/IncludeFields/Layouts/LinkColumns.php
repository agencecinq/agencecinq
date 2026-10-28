<?php
/**
 * ACF layout: Link columns
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Link columns block layout.
 */
class LinkColumns {

	/**
	 * Returns the layout array for the Link columns block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_link_columns',
			'name'       => 'link_columns',
			'label'      => __( 'Link columns', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_link_columns_message',
					'label'      => __( 'Sitemap', 'agencecinq' ),
					'aria-label' => __( 'Sitemap', 'agencecinq' ),
					'type'       => 'message',
					'message'    => __( 'Shows the Sitemap Menu, in Appearance › Menus: its top-level items are the rubrics, their children the links. Recommended paddings: 56px top, 104px bottom.', 'agencecinq' ),
				),
				...AcfFieldHelpers::settings( $key . '_link_columns' ),
			),
		);
	}
}
