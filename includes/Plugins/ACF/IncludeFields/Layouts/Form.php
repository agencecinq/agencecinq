<?php
/**
 * ACF layout: Form
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn/Plugins/ACF/IncludeFields/Layouts
 */

namespace WPCinquanteEtUn\Plugins\ACF\IncludeFields\Layouts;

use WPCinquanteEtUn\Plugins\ACF\IncludeFields\AcfFieldHelpers;

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
			'label'      => __( 'Form', 'wp-cinquante-et-un' ),
			'display'    => 'block',
			'max'        => 1,
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_form' ),
				array(
					'key'        => 'field_' . $key . '_form_tab_content',
					'label'      => __( 'Content', 'wp-cinquante-et-un' ),
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_form_content',
					'label'      => __( 'Content', 'wp-cinquante-et-un' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'           => 'field_' . $key . '_form_content_form',
							'label'         => __( 'Form', 'wp-cinquante-et-un' ),
							'name'          => 'form',
							'aria-label'    => __( 'Form', 'wp-cinquante-et-un' ),
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
