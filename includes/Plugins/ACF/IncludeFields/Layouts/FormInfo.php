<?php
/**
 * ACF layout: Form + Info
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Form + Info block layout.
 */
class FormInfo {

	/**
	 * Returns the layout array for the Form + Info block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_form_info',
			'name'       => 'form_info',
			'label'      => __( 'Form + Info', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_form_info_content_tab',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_form_info_content',
					'label'        => __( 'Content', 'agencecinq' ),
					'name'         => 'content',
					'aria-label'   => __( 'Content', 'agencecinq' ),
					'type'         => 'group',
					'layout'       => 'block',
					'instructions' => __( 'Contact page: two-column form on the left, coordinates on the right. Recommended paddings: 80px top, 104px bottom. The “your project in two lines” field must stay required in Contact Form 7.', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'           => 'field_' . $key . '_form_info_content_form',
							'label'         => __( 'Form', 'agencecinq' ),
							'name'          => 'form',
							'aria-label'    => __( 'Form', 'agencecinq' ),
							'type'          => 'post_object',
							'post_type'     => array( 'wpcf7_contact_form' ),
							'return_format' => 'id',
							'ui'            => 1,
							'allow_null'    => 1,
							'instructions'  => __( 'Select the Contact Form 7 form. Expected fields, two per row then full width: name, email, phone (optional), project type, budget (optional), project (required), submit.', 'agencecinq' ),
						),
						array(
							'key'           => 'field_' . $key . '_form_info_content_notice',
							'label'         => __( 'Notice', 'agencecinq' ),
							'name'          => 'notice',
							'aria-label'    => __( 'Notice', 'agencecinq' ),
							'type'          => 'textarea',
							'rows'          => 2,
							'new_lines'     => '',
							'default_value' => __( 'Reply within 24 hours. Your data stays with us, never sold.', 'agencecinq' ),
							'placeholder'   => __( 'Enter the notice shown under the submit button', 'agencecinq' ),
							'instructions'  => __( 'Mono line under the form. Privacy and response time, not a legal wall of text.', 'agencecinq' ),
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_form_info_info_tab',
					'label'      => __( 'Info', 'agencecinq' ),
					'aria-label' => __( 'Info', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_form_info_info',
					'label'        => __( 'Info', 'agencecinq' ),
					'name'         => 'info',
					'aria-label'   => __( 'Info', 'agencecinq' ),
					'type'         => 'group',
					'layout'       => 'block',
					'instructions' => __( 'The cities, email and phone come from Settings › Theme › Contact.', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'           => 'field_' . $key . '_form_info_info_locations_overline',
							'label'         => __( 'Locations overline', 'agencecinq' ),
							'name'          => 'locations_overline',
							'aria-label'    => __( 'Locations overline', 'agencecinq' ),
							'type'          => 'text',
							'default_value' => __( 'Where to find us', 'agencecinq' ),
							'placeholder'   => __( 'Enter the overline above the cities', 'agencecinq' ),
						),
						array(
							'key'           => 'field_' . $key . '_form_info_info_contact_overline',
							'label'         => __( 'Contact overline', 'agencecinq' ),
							'name'          => 'contact_overline',
							'aria-label'    => __( 'Contact overline', 'agencecinq' ),
							'type'          => 'text',
							'default_value' => __( 'Or directly', 'agencecinq' ),
							'placeholder'   => __( 'Enter the overline above the email and phone', 'agencecinq' ),
						),
					),
				),
				...AcfFieldHelpers::settings( $key . '_form_info' ),
			),
		);
	}
}
