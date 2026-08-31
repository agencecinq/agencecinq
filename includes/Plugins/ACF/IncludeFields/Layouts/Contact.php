<?php
/**
 * ACF layout: Contact
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

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
			'label'      => __( 'Contact us', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_contact' ),
				...AcfFieldHelpers::media( $key . '_contact' ),
				array(
					'key'        => 'field_' . $key . '_contact_content_tab',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_contact_content',
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'           => 'field_' . $key . '_contact_content_image',
							'label'         => __( 'Image', 'agencecinq' ),
							'name'          => 'image',
							'aria-label'    => __( 'Image', 'agencecinq' ),
							'type'          => 'image',
							'return_format' => 'id',
						),
						array(
							'key'         => 'field_' . $key . '_contact_content_title',
							'label'       => __( 'Title', 'agencecinq' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'Enter the title', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_contact_content_text',
							'label'       => __( 'Text', 'agencecinq' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'agencecinq' ),
							'type'        => 'textarea',
							'rows'        => 4,
							'new_lines'   => 'br',
							'placeholder' => __( 'Enter the text', 'agencecinq' ),
						),
						array(
							'key'        => 'field_' . $key . '_contact_content_link',
							'label'      => __( 'Link', 'agencecinq' ),
							'name'       => 'link',
							'aria-label' => __( 'Link', 'agencecinq' ),
							'type'       => 'link',
						),
					),
				),
			),
		);
	}
}
