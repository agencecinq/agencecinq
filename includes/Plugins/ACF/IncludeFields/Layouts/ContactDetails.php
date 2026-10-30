<?php
/**
 * ACF layout: Contact details
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Contact details block layout.
 */
class ContactDetails {

	/**
	 * Returns the layout array for the Contact details block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_contact_details',
			'name'       => 'contact_details',
			'label'      => __( 'Contact details', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_contact_details_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_contact_details_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'        => 'field_' . $key . '_contact_details_content_eyebrow',
							'label'      => __( 'Eyebrow', 'agencecinq' ),
							'name'       => 'eyebrow',
							'aria-label' => __( 'Eyebrow', 'agencecinq' ),
							'type'       => 'text',
						),
						array(
							'key'         => 'field_' . $key . '_contact_details_content_title',
							'label'       => __( 'Title', 'agencecinq' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( '3 ways to reach us', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_contact_details_content_text',
							'label'       => __( 'Text', 'agencecinq' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'agencecinq' ),
							'type'        => 'textarea',
							'rows'        => 3,
							'new_lines'   => '',
							'placeholder' => __( 'Enter the lead text of the block', 'agencecinq' ),
						),
						array(
							'key'        => 'field_' . $key . '_contact_details_content_heading',
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
					'key'           => 'field_' . $key . '_contact_details_booking',
					'label'         => __( 'Booking', 'agencecinq' ),
					'name'          => 'booking',
					'aria-label'    => __( 'Booking', 'agencecinq' ),
					'type'          => 'true_false',
					'ui'            => 1,
					'default_value' => 1,
					'instructions'  => __( 'Shows the 30-minute call first, its button being the Contact link of the theme options. The phone and the email come from the theme options too.', 'agencecinq' ),
				),
				array(
					'key'         => 'field_' . $key . '_contact_details_note',
					'label'       => __( 'Note', 'agencecinq' ),
					'name'        => 'note',
					'aria-label'  => __( 'Note', 'agencecinq' ),
					'type'        => 'text',
					'placeholder' => __( 'e.g. Head office: 7 rue de Paris, 92110 Clichy.', 'agencecinq' ),
				),
				...AcfFieldHelpers::settings( $key . '_contact_details' ),
			),
		);
	}
}
