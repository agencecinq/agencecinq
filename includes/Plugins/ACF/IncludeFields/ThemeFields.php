<?php
/**
 * Theme Fields
 *
 * Registers ACF field group for the theme options page (Settings > Theme).
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields;

use AgenceCinq\Service;

/**
 * Theme Fields
 *
 * Loads advanced custom fields for the theme options.
 */
class ThemeFields implements Service {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run(): void {
		add_action( 'acf/include_fields', array( $this, 'fields' ) );
	}

	/**
	 * Registers the field group.
	 *
	 * @return void
	 */
	public function fields(): void {
		$key = 'theme_fields';

		$location = array(
			array(
				array(
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => 'options-theme',
				),
			),
		);

		$fields = array(
			array(
				'key'        => 'field_' . $key . '_theme_tab',
				'label'      => __( 'Theme', 'agencecinq' ),
				'name'       => 'theme_tab',
				'aria-label' => __( 'Theme', 'agencecinq' ),
				'type'       => 'tab',
			),
			array(
				'key'        => 'field_' . $key . '_theme',
				'label'      => __( 'Theme', 'agencecinq' ),
				'name'       => 'theme',
				'aria-label' => __( 'Theme', 'agencecinq' ),
				'type'       => 'group',
				'layout'     => 'block',
				'sub_fields' => array(
					array(
						'key'        => 'field_' . $key . '_theme_contact_tab',
						'label'      => __( 'Contact', 'agencecinq' ),
						'name'       => 'contact_tab',
						'aria-label' => __( 'Contact', 'agencecinq' ),
						'type'       => 'tab',
					),
					array(
						'key'        => 'field_' . $key . '_theme_contact',
						'label'      => __( 'Contact', 'agencecinq' ),
						'name'       => 'contact',
						'aria-label' => __( 'Contact', 'agencecinq' ),
						'type'       => 'group',
						'layout'     => 'block',
						'sub_fields' => array(
							array(
								'key'           => 'field_' . $key . '_theme_contact_link',
								'label'         => __( 'Link', 'agencecinq' ),
								'name'          => 'link',
								'aria-label'    => __( 'Link', 'agencecinq' ),
								'type'          => 'link',
								'return_format' => 'array',
								'instructions'  => __( 'Enter the contact or CTA link URL.', 'agencecinq' ) . ' <em>(' . __( 'Optional', 'agencecinq' ) . ')</em>.',
							),
							array(
								'key'          => 'field_' . $key . '_theme_contact_locations',
								'label'        => __( 'Locations', 'agencecinq' ),
								'name'         => 'locations',
								'aria-label'   => __( 'Locations', 'agencecinq' ),
								'type'         => 'repeater',
								'layout'       => 'table',
								'button_label' => __( 'Add Location', 'agencecinq' ),
								'instructions' => __( 'Cities listed in the footer and in the Form + Info block.', 'agencecinq' ),
								'sub_fields'   => array(
									array(
										'key'             => 'field_' . $key . '_theme_contact_locations_title',
										'label'           => __( 'Title', 'agencecinq' ),
										'name'            => 'title',
										'aria-label'      => __( 'Title', 'agencecinq' ),
										'type'            => 'text',
										'placeholder'     => __( 'e.g. Paris', 'agencecinq' ),
										'parent_repeater' => 'field_' . $key . '_theme_contact_locations',
									),
								),
							),
							array(
								'key'           => 'field_' . $key . '_theme_contact_email',
								'label'         => __( 'Email', 'agencecinq' ),
								'name'          => 'email',
								'aria-label'    => __( 'Email', 'agencecinq' ),
								'type'          => 'email',
								'default_value' => 'contact@agencecinq.com',
								'placeholder'   => __( 'Enter the contact email', 'agencecinq' ),
							),
							array(
								'key'           => 'field_' . $key . '_theme_contact_phone',
								'label'         => __( 'Phone', 'agencecinq' ),
								'name'          => 'phone',
								'aria-label'    => __( 'Phone', 'agencecinq' ),
								'type'          => 'text',
								'default_value' => '06 73 77 86 08',
								'placeholder'   => __( 'Enter the phone number', 'agencecinq' ),
							),
							array(
								'key'           => 'field_' . $key . '_theme_contact_phone_note',
								'label'         => __( 'Phone note', 'agencecinq' ),
								'name'          => 'phone_note',
								'aria-label'    => __( 'Phone note', 'agencecinq' ),
								'type'          => 'text',
								'default_value' => __( 'Joachim, founder', 'agencecinq' ),
								'placeholder'   => __( 'e.g. Joachim, founder', 'agencecinq' ),
								'instructions'  => __( 'Shown after the number. Optional.', 'agencecinq' ),
							),
						),
					),
					array(
						'key'        => 'field_' . $key . '_theme_footer_tab',
						'label'      => __( 'Footer', 'agencecinq' ),
						'name'       => 'footer_tab',
						'aria-label' => __( 'Footer', 'agencecinq' ),
						'type'       => 'tab',
					),
					array(
						'key'        => 'field_' . $key . '_theme_footer',
						'label'      => __( 'Footer', 'agencecinq' ),
						'name'       => 'footer',
						'aria-label' => __( 'Footer', 'agencecinq' ),
						'type'       => 'group',
						'layout'     => 'block',
						'sub_fields' => array(
							array(
								'key'           => 'field_' . $key . '_footer_text',
								'label'         => __( 'Text', 'agencecinq' ),
								'name'          => 'text',
								'aria-label'    => __( 'Text', 'agencecinq' ),
								'type'          => 'text',
								'default_value' => __( 'A website is an asset. Not a liability you replace every three years.', 'agencecinq' ),
								'placeholder'   => __( 'Enter the text under the logo', 'agencecinq' ),
								'instructions'  => __( 'Short line under the logo.', 'agencecinq' ) . ' <em>(' . __( 'Optional', 'agencecinq' ) . ')</em>.',
							),
							array(
								'key'           => 'field_' . $key . '_footer_copyright',
								'label'         => __( 'Copyright', 'agencecinq' ),
								'name'          => 'copyright',
								'aria-label'    => __( 'Copyright', 'agencecinq' ),
								'type'          => 'text',
								'default_value' => 'CINQ · SAS · Clichy',
								'instructions'  => __( 'Company after the © and the year. The site name otherwise.', 'agencecinq' ) . ' <em>(' . __( 'Optional', 'agencecinq' ) . ')</em>.',
							),
						),
					),
					array(
						'key'        => 'field_' . $key . '_theme_404_tab',
						'label'      => __( '404', 'agencecinq' ),
						'name'       => 'page_404_tab',
						'aria-label' => __( '404', 'agencecinq' ),
						'type'       => 'tab',
					),
					array(
						'key'          => 'field_' . $key . '_theme_404',
						'label'        => '404',
						'name'         => '404',
						'aria-label'   => '404',
						'type'         => 'group',
						'layout'       => 'block',
						'instructions' => __( 'Branded 404 with fallback links to the pages that matter, never a dead end.', 'agencecinq' ),
						'sub_fields'   => array(
							array(
								'key'           => 'field_' . $key . '_404_overline',
								'label'         => __( 'Overline', 'agencecinq' ),
								'name'          => 'overline',
								'aria-label'    => __( 'Overline', 'agencecinq' ),
								'type'          => 'text',
								'default_value' => __( 'Error 404', 'agencecinq' ),
								'placeholder'   => __( 'Enter the overline of the 404 page', 'agencecinq' ),
								'instructions'  => __( 'Uppercase mono label above the title.', 'agencecinq' ),
							),
							array(
								'key'           => 'field_' . $key . '_404_title',
								'label'         => __( 'Title', 'agencecinq' ),
								'name'          => 'title',
								'aria-label'    => __( 'Title', 'agencecinq' ),
								'type'          => 'text',
								'default_value' => __( 'This page does not exist.', 'agencecinq' ),
								'placeholder'   => __( 'Enter the title of the 404 page', 'agencecinq' ),
								'instructions'  => __( 'Main heading of the 404 page. Always rendered as an H1.', 'agencecinq' ),
							),
							array(
								'key'           => 'field_' . $key . '_404_text',
								'label'         => __( 'Text', 'agencecinq' ),
								'name'          => 'text',
								'aria-label'    => __( 'Text', 'agencecinq' ),
								'type'          => 'textarea',
								'rows'          => 3,
								'new_lines'     => 'br',
								'default_value' => __( 'It may have been moved, or the link that brought you here was already broken. Here is where to pick up.', 'agencecinq' ),
								'placeholder'   => __( 'Enter the lead text of the 404 page', 'agencecinq' ),
								'instructions'  => __( 'Lead paragraph under the title.', 'agencecinq' ),
							),
							array(
								'key'           => 'field_' . $key . '_404_link',
								'label'         => __( 'Link', 'agencecinq' ),
								'name'          => 'link',
								'aria-label'    => __( 'Link', 'agencecinq' ),
								'type'          => 'link',
								'return_format' => 'array',
								'default_value' => array(
									'title'  => __( 'Back to home', 'agencecinq' ),
									'url'    => '',
									'target' => '',
								),
								'instructions'  => __( 'Primary CTA back to the home page.', 'agencecinq' ),
							),
							array(
								'key'          => 'field_' . $key . '_404_items',
								'label'        => __( 'Fallback links', 'agencecinq' ),
								'name'         => 'items',
								'aria-label'   => __( 'Fallback links', 'agencecinq' ),
								'type'         => 'repeater',
								'layout'       => 'table',
								'max'          => 4,
								'button_label' => __( 'Add Link', 'agencecinq' ),
								'instructions' => __( 'Shortcut links under the CTA (Shopify, WordPress, work, contact). Use explicit labels, never Learn more.', 'agencecinq' ),
								'sub_fields'   => array(
									array(
										'key'             => 'field_' . $key . '_404_items_link',
										'label'           => __( 'Link', 'agencecinq' ),
										'name'            => 'link',
										'aria-label'      => __( 'Link', 'agencecinq' ),
										'type'            => 'link',
										'return_format'   => 'array',
										'parent_repeater' => 'field_' . $key . '_404_items',
									),
								),
							),
						),
					),
				),
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group(
				array(
					'key'      => 'group_' . $key,
					'title'    => __( 'Theme Fields', 'agencecinq' ),
					'fields'   => $fields,
					'location' => $location,
				)
			);
		}
	}
}
