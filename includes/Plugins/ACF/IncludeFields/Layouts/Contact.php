<?php
/**
 * ACF layout: Contact
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn/Plugins/ACF/IncludeFields/Layouts
 */

namespace WPCinquanteEtUn\Plugins\ACF\IncludeFields\Layouts;

use WPCinquanteEtUn\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Contact block layout.
 */
class Contact {

	/**
	 * Returns the layout array for the Contact block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_contact',
			'name'       => 'contact',
			'label'      => __( 'Contact us', 'wp-cinquante-et-un' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_contact' ),
				...AcfFieldHelpers::media( $key . '_contact' ),
				array(
					'key'        => 'field_' . $key . '_contact_content_tab',
					'label'      => __( 'Content', 'wp-cinquante-et-un' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_contact_content',
					'name'       => 'content',
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'           => 'field_' . $key . '_contact_content_image',
							'label'         => __( 'Image', 'wp-cinquante-et-un' ),
							'name'          => 'image',
							'aria-label'    => __( 'Image', 'wp-cinquante-et-un' ),
							'type'          => 'image',
							'return_format' => 'id',
						),
						array(
							'key'         => 'field_' . $key . '_contact_content_title',
							'label'       => __( 'Title', 'wp-cinquante-et-un' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'wp-cinquante-et-un' ),
							'type'        => 'text',
							'placeholder' => __( 'Enter the title', 'wp-cinquante-et-un' ),
						),
						array(
							'key'         => 'field_' . $key . '_contact_content_text',
							'label'       => __( 'Text', 'wp-cinquante-et-un' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'wp-cinquante-et-un' ),
							'type'        => 'textarea',
							'rows'        => 4,
							'new_lines'   => 'br',
							'placeholder' => __( 'Enter the text', 'wp-cinquante-et-un' ),
						),
						array(
							'key'        => 'field_' . $key . '_contact_content_link',
							'label'      => __( 'Link', 'wp-cinquante-et-un' ),
							'name'       => 'link',
							'aria-label' => __( 'Link', 'wp-cinquante-et-un' ),
							'type'       => 'link',
						),
					),
				),
			),
		);
	}
}
