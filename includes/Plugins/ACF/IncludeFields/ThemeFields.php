<?php
/**
 * Theme Fields
 *
 * Registers ACF field group for the theme options page (Réglages > Thème).
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

		$menu_locations = get_nav_menu_locations();
		$main_menu_id   = $menu_locations['main'] ?? '';

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
								'key'        => 'field_' . $key . '_theme_footer_push',
								'label'      => __( 'Push', 'agencecinq' ),
								'name'       => 'push',
								'aria-label' => __( 'Push', 'agencecinq' ),
								'type'       => 'group',
								'layout'     => 'block',
								'sub_fields' => array(
									array(
										'key'          => 'field_' . $key . '_theme_footer_push_title',
										'label'        => __( 'Title', 'agencecinq' ),
										'name'         => 'title',
										'aria-label'   => __( 'Title', 'agencecinq' ),
										'type'         => 'text',
										'placeholder'  => __( 'Title', 'agencecinq' ),
										'instructions' => __( 'Heading for the footer push block.', 'agencecinq' ),
									),
									array(
										'key'           => 'field_' . $key . '_theme_footer_push_choices',
										'label'         => __( 'Choices', 'agencecinq' ),
										'name'          => 'choices',
										'aria-label'    => __( 'Choices', 'agencecinq' ),
										'type'          => 'textarea',
										'rows'          => 6,
										'default_value' => "Éclairage public\nÉquipements urbains\nÉquipements sportifs\nTertiaire\nSolaire Connecté",
										'instructions'  => __( 'One choice per line. Used for input radio buttons in the footer and the select in the form.', 'agencecinq' ),
									),
									array(
										'key'           => 'field_' . $key . '_theme_footer_push_image',
										'label'         => __( 'Image', 'agencecinq' ),
										'name'          => 'image',
										'aria-label'    => __( 'Image', 'agencecinq' ),
										'type'          => 'image',
										'return_format' => 'id',
										'preview_size'  => 'medium',
										'instructions'  => __( 'Select or upload an image.', 'agencecinq' ) . ' <em>(' . __( 'Optional', 'agencecinq' ) . ')</em>.',
									),
								),
							),
							array(
								'key'        => 'field_' . $key . '_theme_footer_newsletter',
								'label'      => __( 'Newsletter', 'agencecinq' ),
								'name'       => 'newsletter',
								'aria-label' => __( 'Newsletter', 'agencecinq' ),
								'type'       => 'group',
								'layout'     => 'block',
								'sub_fields' => array(
									array(
										'key'          => 'field_' . $key . '_theme_footer_newsletter_title',
										'label'        => __( 'Title', 'agencecinq' ),
										'name'         => 'title',
										'aria-label'   => __( 'Title', 'agencecinq' ),
										'type'         => 'textarea',
										'rows'         => 2,
										'new_lines'    => 'br',
										'placeholder'  => __( 'Title', 'agencecinq' ),
										'instructions' => __( 'Heading for the newsletter block.', 'agencecinq' ) . ' <em>(' . __( 'Optional', 'agencecinq' ) . ')</em>.',
									),
									array(
										'key'          => 'field_' . $key . '_theme_footer_newsletter_subtitle',
										'label'        => __( 'Subtitle', 'agencecinq' ),
										'name'         => 'subtitle',
										'aria-label'   => __( 'Subtitle', 'agencecinq' ),
										'type'         => 'text',
										'placeholder'  => __( 'Subtitle', 'agencecinq' ),
										'instructions' => __( 'Subtitle for the newsletter block.', 'agencecinq' ) . ' <em>(' . __( 'Optional', 'agencecinq' ) . ')</em>.',
									),
									array(
										'key'          => 'field_' . $key . '_theme_footer_newsletter_text',
										'label'        => __( 'Text', 'agencecinq' ),
										'name'         => 'text',
										'aria-label'   => __( 'Text', 'agencecinq' ),
										'type'         => 'textarea',
										'rows'         => 2,
										'new_lines'    => 'br',
										'placeholder'  => __( 'Text', 'agencecinq' ),
										'instructions' => __( 'Text for the newsletter block.', 'agencecinq' ) . ' <em>(' . __( 'Optional', 'agencecinq' ) . ')</em>.',
									),
									array(
										'key'           => 'field_' . $key . '_theme_footer_newsletter_form',
										'label'         => __( 'Form', 'agencecinq' ),
										'name'          => 'form',
										'aria-label'    => __( 'Form', 'agencecinq' ),
										'type'          => 'post_object',
										'post_type'     => array( 'wpcf7_contact_form' ),
										'return_format' => 'id',
										'multiple'      => 0,
										'allow_null'    => 0,
										'ui'            => 1,
										'instructions'  => __( 'Select the Contact Form 7 form displayed in the footer.', 'agencecinq' ),
									),
								),
							),

						),
					),
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
						'key'        => 'field_' . $key . '_theme_404',
						'label'      => '404',
						'name'       => '404',
						'aria-label' => '404',
						'type'       => 'group',
						'layout'     => 'block',
						'sub_fields' => array(
							array(
								'key'           => 'field_' . $key . '_404_image',
								'label'         => __( 'Image', 'agencecinq' ),
								'name'          => 'image',
								'aria-label'    => __( 'Image', 'agencecinq' ),
								'type'          => 'image',
								'return_format' => 'id',
								'preview_size'  => 'medium',
								'instructions'  => __( 'Select or upload an image for the 404 page.', 'agencecinq' ) . ' <em>(' . __( 'Optional', 'agencecinq' ) . ')</em>.',
							),
						),
					),
				),
			),
			array(
				'key'        => 'field_' . $key . '_menu_tab',
				'label'      => __( 'Menu', 'agencecinq' ),
				'name'       => 'menu',
				'aria-label' => __( 'Menu', 'agencecinq' ),
				'type'       => 'tab',
			),
			array(
				'key'        => 'field_' . $key . '_menus',
				'label'      => __( 'Menus', 'agencecinq' ),
				'name'       => 'menus',
				'aria-label' => __( 'Menus', 'agencecinq' ),
				'type'       => 'group',
				'layout'     => 'block',
				'sub_fields' => array(
					array(
						'key'        => 'field_' . $key . '_menus_main',
						'label'      => __( 'Main Menu', 'agencecinq' ),
						'name'       => 'main',
						'type'       => 'group',
						'layout'     => 'block',
						'sub_fields' => array(
							array(
								'key'          => 'field_' . $key . '_menus_main_submenu',
								'label'        => __( 'Submenu', 'agencecinq' ),
								'name'         => 'submenu',
								'type'         => 'repeater',
								'layout'       => 'block',
								'instructions' => __( 'Add submenu items. Each can have a menu, title, text, link title, and pushes.', 'agencecinq' ),
								'button_label' => __( 'Add Submenu Item', 'agencecinq' ),
								'sub_fields'   => array(
									array(
										'key'             => 'field_' . $key . '_menus_main_submenu_item',
										'label'           => __( 'Menu Item', 'agencecinq' ),
										'name'            => 'item',
										'type'            => 'menu_item_select',
										'menu'            => $main_menu_id,
										'return_format'   => 'value',
										'placeholder'     => __( 'Select a menu to attach to this submenu', 'agencecinq' ),
										'allow_null'      => 1,
										'instructions'    => __( 'Select the menu to attach to this submenu.', 'agencecinq' ) . ' <em>(' . __( 'Optional', 'agencecinq' ) . ')</em>.',
										'parent_repeater' => 'field_' . $key . '_menus_main_submenu',
									),
									array(
										'key'             => 'field_' . $key . '_menus_main_submenu_title',
										'label'           => __( 'Title', 'agencecinq' ),
										'name'            => 'title',
										'type'            => 'text',
										'placeholder'     => __( 'Title', 'agencecinq' ),
										'instructions'    => __( 'Submenu heading.', 'agencecinq' ) . ' <em>(' . __( 'Optional', 'agencecinq' ) . ')</em>.',
										'parent_repeater' => 'field_' . $key . '_menus_main_submenu',
									),
									array(
										'key'             => 'field_' . $key . '_menus_main_submenu_text',
										'label'           => __( 'Text', 'agencecinq' ),
										'name'            => 'text',
										'type'            => 'textarea',
										'rows'            => 2,
										'new_lines'       => 'br',
										'placeholder'     => __( 'Text', 'agencecinq' ),
										'instructions'    => __( 'Short description.', 'agencecinq' ) . ' <em>(' . __( 'Optional', 'agencecinq' ) . ')</em>.',
										'parent_repeater' => 'field_' . $key . '_menus_main_submenu',
									),
									array(
										'key'             => 'field_' . $key . '_menus_main_submenu_link_title',
										'label'           => __( 'Link Title', 'agencecinq' ),
										'name'            => 'link_title',
										'type'            => 'text',
										'placeholder'     => __( 'Link Title', 'agencecinq' ),
										'instructions'    => __( 'Button or link label.', 'agencecinq' ) . ' <em>(' . __( 'Optional', 'agencecinq' ) . ')</em>.',
										'parent_repeater' => 'field_' . $key . '_menus_main_submenu',
									),
									array(
										'key'             => 'field_' . $key . '_menus_main_submenu_pushes',
										'label'           => __( 'Pushes', 'agencecinq' ),
										'name'            => 'pushes',
										'type'            => 'repeater',
										'layout'          => 'block',
										'max'             => 4,
										'instructions'    => __( 'Add up to 3 push items (overline, title, image, link).', 'agencecinq' ) . ' <em>(' . __( 'Optional', 'agencecinq' ) . ')</em>.',
										'parent_repeater' => 'field_' . $key . '_menus_main_submenu',
										'button_label'    => __( 'Add Push', 'agencecinq' ),
										'sub_fields'      => array(
											array(
												'key'     => 'field_' . $key . '_menus_main_submenu_pushes_mode',
												'label'   => __( 'Mode', 'agencecinq' ),
												'name'    => 'mode',
												'type'    => 'select',
												'choices' => array(
													'dark' => __( 'Dark', 'agencecinq' ),
													'light' => __( 'Light', 'agencecinq' ),
												),
												'default' => 'dark',
												'return_format' => 'value',
												'parent_repeater' => 'field_' . $key . '_menus_main_submenu_pushes',
												'instructions' => __( 'Select the mode for the push.', 'agencecinq' ) . ' <em>(' . __( 'Optional', 'agencecinq' ) . ')</em>.',
											),
											array(
												'key'   => 'field_' . $key . '_menus_main_submenu_pushes_overline',
												'label' => __( 'Overline', 'agencecinq' ),
												'name'  => 'overline',
												'type'  => 'text',
												'placeholder' => __( 'Overline', 'agencecinq' ),
												'parent_repeater' => 'field_' . $key . '_menus_main_submenu_pushes',
											),
											array(
												'key'   => 'field_' . $key . '_menus_main_submenu_pushes_title',
												'label' => __( 'Title', 'agencecinq' ),
												'name'  => 'title',
												'type'  => 'text',
												'placeholder' => __( 'Title', 'agencecinq' ),
												'parent_repeater' => 'field_' . $key . '_menus_main_submenu_pushes',
											),
											array(
												'key'   => 'field_' . $key . '_menus_main_submenu_pushes_image',
												'label' => __( 'Image', 'agencecinq' ),
												'name'  => 'image',
												'type'  => 'image',
												'return_format' => 'id',
												'preview_size' => 'medium',
											),
											array(
												'key'   => 'field_' . $key . '_menus_main_submenu_pushes_link',
												'label' => __( 'Link', 'agencecinq' ),
												'name'  => 'link',
												'type'  => 'link',
												'return_format' => 'array',
												'parent_repeater' => 'field_' . $key . '_menus_main_submenu_pushes',
											),
										),
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
