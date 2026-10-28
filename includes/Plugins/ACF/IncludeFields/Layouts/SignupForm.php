<?php
/**
 * ACF layout: Signup form
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Signup form block layout.
 */
class SignupForm {

	/**
	 * Returns the layout array for the Signup form block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_signup_form',
			'name'       => 'signup_form',
			'label'      => __( 'Signup form', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_signup_form_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_signup_form_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'         => 'field_' . $key . '_signup_form_content_title',
							'label'       => __( 'Title', 'agencecinq' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'agencecinq' ),
							'type'        => 'text',
							'required'    => 1,
							'placeholder' => __( 'The CINQ letter', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_signup_form_content_text',
							'label'       => __( 'Text', 'agencecinq' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'agencecinq' ),
							'type'        => 'textarea',
							'rows'        => 3,
							'new_lines'   => '',
							'placeholder' => __( 'Enter the lead text of the block', 'agencecinq' ),
						),
						array(
							'key'        => 'field_' . $key . '_signup_form_content_heading',
							'label'      => __( 'Heading', 'agencecinq' ),
							'name'       => 'heading',
							'aria-label' => __( 'Heading', 'agencecinq' ),
							'type'       => 'clone',
							'clone'      => array( 'field_clones_heading' ),
							'display'    => 'seamless',
							'layout'     => 'block',
						),
					),
				),
				array(
					'key'           => 'field_' . $key . '_signup_form_form',
					'label'         => __( 'Form', 'agencecinq' ),
					'name'          => 'form',
					'aria-label'    => __( 'Form', 'agencecinq' ),
					'type'          => 'post_object',
					'post_type'     => array( 'wpcf7_contact_form' ),
					'return_format' => 'id',
					'ui'            => 1,
					'required'      => 1,
					'instructions'  => __( 'Select the Contact Form 7 form: the email with its visible label, then the submit. Its message on success says what happens next.', 'agencecinq' ),
				),
				array(
					'key'           => 'field_' . $key . '_signup_form_note',
					'label'         => __( 'Note', 'agencecinq' ),
					'name'          => 'note',
					'aria-label'    => __( 'Note', 'agencecinq' ),
					'type'          => 'text',
					'default_value' => __( 'Your address is only used to send the letter.', 'agencecinq' ),
					'instructions'  => __( 'Under the form, followed by the link to the privacy policy.', 'agencecinq' ),
				),
				...AcfFieldHelpers::settings( $key . '_signup_form' ),
			),
		);
	}
}
