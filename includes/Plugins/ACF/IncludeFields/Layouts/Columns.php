<?php
/**
 * ACF layout: Columns
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Columns block layout (two-column text).
 */
class Columns {

	/**
	 * Returns the layout array for the Columns block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_columns',
			'name'       => 'columns',
			'label'      => __( 'Columns', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_columns' ),
				array(
					'key'        => 'field_' . $key . '_columns_content_tab',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_columns_content',
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'         => 'field_' . $key . '_columns_content_column_left',
							'label'       => __( 'Left column', 'agencecinq' ),
							'name'        => 'column_left',
							'aria-label'  => __( 'Left column', 'agencecinq' ),
							'type'        => 'textarea',
							'rows'        => 6,
							'new_lines'   => 'br',
							'placeholder' => __( 'Enter the text for the left column', 'agencecinq' ),
							'wrapper'     => array(
								'width' => 50,
							),
						),
						array(
							'key'         => 'field_' . $key . '_columns_content_column_right',
							'label'       => __( 'Right column', 'agencecinq' ),
							'name'        => 'column_right',
							'aria-label'  => __( 'Right column', 'agencecinq' ),
							'type'        => 'textarea',
							'rows'        => 6,
							'new_lines'   => 'br',
							'placeholder' => __( 'Enter the text for the right column', 'agencecinq' ),
							'wrapper'     => array(
								'width' => 50,
							),
						),
					),
				),
			),
		);
	}
}
