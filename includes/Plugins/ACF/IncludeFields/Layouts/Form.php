<?php
/**
 * ACF layout: Form
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Form block layout.
 */
class Form {

	/**
	 * Returns the layout array for the Gallery block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_form',
			'name'       => 'form',
			'label'      => __( 'Form', 'agencecinq' ),
			'display'    => 'block',
			'max'        => 1,
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_form' ),
				array(
					'key'        => 'field_' . $key . '_form_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_form_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'           => 'field_' . $key . '_form_content_form',
							'label'         => __( 'Form', 'agencecinq' ),
							'name'          => 'form',
							'aria-label'    => __( 'Form', 'agencecinq' ),
							'type'          => 'post_object',
							'post_type'     => 'wpcf7_contact_form',
							'return_format' => 'id',
							'multiple'      => 0,
							'allow_null'    => 0,
						),
					),
				),
			),
		);
	}
}
