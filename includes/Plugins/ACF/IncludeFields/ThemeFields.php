<?php
/**
 * Theme Fields
 *
 * Registers ACF field group for the theme options page (Réglages > Thème).
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn/Plugins/ACF/IncludeFields
 */

namespace WPCinquanteEtUn\Plugins\ACF\IncludeFields;

use WPCinquanteEtUn\Service;

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
				'label'      => __( 'Theme', 'wp-cinquante-et-un' ),
				'name'       => 'theme_tab',
				'aria-label' => __( 'Theme', 'wp-cinquante-et-un' ),
				'type'       => 'tab',
			),
			array(
				'key'        => 'field_' . $key . '_theme',
				'label'      => __( 'Theme', 'wp-cinquante-et-un' ),
				'name'       => 'theme',
				'aria-label' => __( 'Theme', 'wp-cinquante-et-un' ),
				'type'       => 'group',
				'layout'     => 'block',
				'sub_fields' => array(
					array(
						'key'        => 'field_' . $key . '_theme_footer_tab',
						'label'      => __( 'Footer', 'wp-cinquante-et-un' ),
						'name'       => 'footer_tab',
						'aria-label' => __( 'Footer', 'wp-cinquante-et-un' ),
						'type'       => 'tab',
					),
					array(
						'key'        => 'field_' . $key . '_theme_footer',
						'label'      => __( 'Footer', 'wp-cinquante-et-un' ),
						'name'       => 'footer',
						'aria-label' => __( 'Footer', 'wp-cinquante-et-un' ),
						'type'       => 'group',
						'layout'     => 'block',
						'sub_fields' => array(
							array(
								'key'        => 'field_' . $key . '_theme_footer_push',
								'label'      => __( 'Push', 'wp-cinquante-et-un' ),
								'name'       => 'push',
								'aria-label' => __( 'Push', 'wp-cinquante-et-un' ),
								'type'       => 'group',
								'layout'     => 'block',
								'sub_fields' => array(
									array(
										'key'          => 'field_' . $key . '_theme_footer_push_title',
										'label'        => __( 'Title', 'wp-cinquante-et-un' ),
										'name'         => 'title',
										'aria-label'   => __( 'Title', 'wp-cinquante-et-un' ),
										'type'         => 'text',
										'placeholder'  => __( 'Title', 'wp-cinquante-et-un' ),
										'instructions' => __( 'Heading for the footer push block.', 'wp-cinquante-et-un' ),
									),
									array(
										'key'           => 'field_' . $key . '_theme_footer_push_choices',
										'label'         => __( 'Choices', 'wp-cinquante-et-un' ),
										'name'          => 'choices',
										'aria-label'    => __( 'Choices', 'wp-cinquante-et-un' ),
										'type'          => 'textarea',
										'rows'          => 6,
										'default_value' => "Éclairage public\nÉquipements urbains\nÉquipements sportifs\nTertiaire\nSolaire Connecté",
										'instructions'  => __( 'One choice per line. Used for input radio buttons in the footer and the select in the form.', 'wp-cinquante-et-un' ),
									),
									array(
										'key'           => 'field_' . $key . '_theme_footer_push_image',
										'label'         => __( 'Image', 'wp-cinquante-et-un' ),
										'name'          => 'image',
										'aria-label'    => __( 'Image', 'wp-cinquante-et-un' ),
										'type'          => 'image',
										'return_format' => 'id',
										'preview_size'  => 'medium',
										'instructions'  => __( 'Select or upload an image.', 'wp-cinquante-et-un' ) . ' <em>(' . __( 'Optional', 'wp-cinquante-et-un' ) . ')</em>.',
									),
								),
							),
							array(
								'key'        => 'field_' . $key . '_theme_footer_newsletter',
								'label'      => __( 'Newsletter', 'wp-cinquante-et-un' ),
								'name'       => 'newsletter',
								'aria-label' => __( 'Newsletter', 'wp-cinquante-et-un' ),
								'type'       => 'group',
								'layout'     => 'block',
								'sub_fields' => array(
									array(
										'key'          => 'field_' . $key . '_theme_footer_newsletter_title',
										'label'        => __( 'Title', 'wp-cinquante-et-un' ),
										'name'         => 'title',
										'aria-label'   => __( 'Title', 'wp-cinquante-et-un' ),
										'type'         => 'textarea',
										'rows'         => 2,
										'new_lines'    => 'br',
										'placeholder'  => __( 'Title', 'wp-cinquante-et-un' ),
										'instructions' => __( 'Heading for the newsletter block.', 'wp-cinquante-et-un' ) . ' <em>(' . __( 'Optional', 'wp-cinquante-et-un' ) . ')</em>.',
									),
									array(
										'key'          => 'field_' . $key . '_theme_footer_newsletter_subtitle',
										'label'        => __( 'Subtitle', 'wp-cinquante-et-un' ),
										'name'         => 'subtitle',
										'aria-label'   => __( 'Subtitle', 'wp-cinquante-et-un' ),
										'type'         => 'text',
										'placeholder'  => __( 'Subtitle', 'wp-cinquante-et-un' ),
										'instructions' => __( 'Subtitle for the newsletter block.', 'wp-cinquante-et-un' ) . ' <em>(' . __( 'Optional', 'wp-cinquante-et-un' ) . ')</em>.',
									),
									array(
										'key'          => 'field_' . $key . '_theme_footer_newsletter_text',
										'label'        => __( 'Text', 'wp-cinquante-et-un' ),
										'name'         => 'text',
										'aria-label'   => __( 'Text', 'wp-cinquante-et-un' ),
										'type'         => 'textarea',
										'rows'         => 2,
										'new_lines'    => 'br',
										'placeholder'  => __( 'Text', 'wp-cinquante-et-un' ),
										'instructions' => __( 'Text for the newsletter block.', 'wp-cinquante-et-un' ) . ' <em>(' . __( 'Optional', 'wp-cinquante-et-un' ) . ')</em>.',
									),
									array(
										'key'           => 'field_' . $key . '_theme_footer_newsletter_form',
										'label'         => __( 'Form', 'wp-cinquante-et-un' ),
										'name'          => 'form',
										'aria-label'    => __( 'Form', 'wp-cinquante-et-un' ),
										'type'          => 'post_object',
										'post_type'     => array( 'wpcf7_contact_form' ),
										'return_format' => 'id',
										'multiple'      => 0,
										'allow_null'    => 0,
										'ui'            => 1,
										'instructions'  => __( 'Select the Contact Form 7 form displayed in the footer.', 'wp-cinquante-et-un' ),
									),
								),
							),

						),
					),
					array(
						'key'        => 'field_' . $key . '_theme_contact_tab',
						'label'      => __( 'Contact', 'wp-cinquante-et-un' ),
						'name'       => 'contact_tab',
						'aria-label' => __( 'Contact', 'wp-cinquante-et-un' ),
						'type'       => 'tab',
					),
					array(
						'key'        => 'field_' . $key . '_theme_contact',
						'label'      => __( 'Contact', 'wp-cinquante-et-un' ),
						'name'       => 'contact',
						'aria-label' => __( 'Contact', 'wp-cinquante-et-un' ),
						'type'       => 'group',
						'layout'     => 'block',
						'sub_fields' => array(
							array(
								'key'           => 'field_' . $key . '_theme_contact_link',
								'label'         => __( 'Link', 'wp-cinquante-et-un' ),
								'name'          => 'link',
								'aria-label'    => __( 'Link', 'wp-cinquante-et-un' ),
								'type'          => 'link',
								'return_format' => 'array',
								'instructions'  => __( 'Enter the contact or CTA link URL.', 'wp-cinquante-et-un' ) . ' <em>(' . __( 'Optional', 'wp-cinquante-et-un' ) . ')</em>.',
							),
						),
					),
					array(
						'key'        => 'field_' . $key . '_theme_404_tab',
						'label'      => __( '404', 'wp-cinquante-et-un' ),
						'name'       => 'page_404_tab',
						'aria-label' => __( '404', 'wp-cinquante-et-un' ),
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
								'label'         => __( 'Image', 'wp-cinquante-et-un' ),
								'name'          => 'image',
								'aria-label'    => __( 'Image', 'wp-cinquante-et-un' ),
								'type'          => 'image',
								'return_format' => 'id',
								'preview_size'  => 'medium',
								'instructions'  => __( 'Select or upload an image for the 404 page.', 'wp-cinquante-et-un' ) . ' <em>(' . __( 'Optional', 'wp-cinquante-et-un' ) . ')</em>.',
							),
						),
					),
				),
			),
			array(
				'key'        => 'field_' . $key . '_menu_tab',
				'label'      => __( 'Menu', 'wp-cinquante-et-un' ),
				'name'       => 'menu',
				'aria-label' => __( 'Menu', 'wp-cinquante-et-un' ),
				'type'       => 'tab',
			),
			array(
				'key'        => 'field_' . $key . '_menus',
				'label'      => __( 'Menus', 'wp-cinquante-et-un' ),
				'name'       => 'menus',
				'aria-label' => __( 'Menus', 'wp-cinquante-et-un' ),
				'type'       => 'group',
				'layout'     => 'block',
				'sub_fields' => array(
					array(
						'key'        => 'field_' . $key . '_menus_main',
						'label'      => __( 'Main Menu', 'wp-cinquante-et-un' ),
						'name'       => 'main',
						'type'       => 'group',
						'layout'     => 'block',
						'sub_fields' => array(
							array(
								'key'          => 'field_' . $key . '_menus_main_submenu',
								'label'        => __( 'Submenu', 'wp-cinquante-et-un' ),
								'name'         => 'submenu',
								'type'         => 'repeater',
								'layout'       => 'block',
								'instructions' => __( 'Add submenu items. Each can have a menu, title, text, link title, and pushes.', 'wp-cinquante-et-un' ),
								'button_label' => __( 'Add Submenu Item', 'wp-cinquante-et-un' ),
								'sub_fields'   => array(
									array(
										'key'             => 'field_' . $key . '_menus_main_submenu_item',
										'label'           => __( 'Menu Item', 'wp-cinquante-et-un' ),
										'name'            => 'item',
										'type'            => 'menu_item_select',
										'menu'            => get_nav_menu_locations()['main'],
										'return_format'   => 'value',
										'placeholder'     => __( 'Select a menu to attach to this submenu', 'wp-cinquante-et-un' ),
										'allow_null'      => 1,
										'instructions'    => __( 'Select the menu to attach to this submenu.', 'wp-cinquante-et-un' ) . ' <em>(' . __( 'Optional', 'wp-cinquante-et-un' ) . ')</em>.',
										'parent_repeater' => 'field_' . $key . '_menus_main_submenu',
									),
									array(
										'key'             => 'field_' . $key . '_menus_main_submenu_title',
										'label'           => __( 'Title', 'wp-cinquante-et-un' ),
										'name'            => 'title',
										'type'            => 'text',
										'placeholder'     => __( 'Title', 'wp-cinquante-et-un' ),
										'instructions'    => __( 'Submenu heading.', 'wp-cinquante-et-un' ) . ' <em>(' . __( 'Optional', 'wp-cinquante-et-un' ) . ')</em>.',
										'parent_repeater' => 'field_' . $key . '_menus_main_submenu',
									),
									array(
										'key'             => 'field_' . $key . '_menus_main_submenu_text',
										'label'           => __( 'Text', 'wp-cinquante-et-un' ),
										'name'            => 'text',
										'type'            => 'textarea',
										'rows'            => 2,
										'new_lines'       => 'br',
										'placeholder'     => __( 'Text', 'wp-cinquante-et-un' ),
										'instructions'    => __( 'Short description.', 'wp-cinquante-et-un' ) . ' <em>(' . __( 'Optional', 'wp-cinquante-et-un' ) . ')</em>.',
										'parent_repeater' => 'field_' . $key . '_menus_main_submenu',
									),
									array(
										'key'             => 'field_' . $key . '_menus_main_submenu_link_title',
										'label'           => __( 'Link Title', 'wp-cinquante-et-un' ),
										'name'            => 'link_title',
										'type'            => 'text',
										'placeholder'     => __( 'Link Title', 'wp-cinquante-et-un' ),
										'instructions'    => __( 'Button or link label.', 'wp-cinquante-et-un' ) . ' <em>(' . __( 'Optional', 'wp-cinquante-et-un' ) . ')</em>.',
										'parent_repeater' => 'field_' . $key . '_menus_main_submenu',
									),
									array(
										'key'             => 'field_' . $key . '_menus_main_submenu_pushes',
										'label'           => __( 'Pushes', 'wp-cinquante-et-un' ),
										'name'            => 'pushes',
										'type'            => 'repeater',
										'layout'          => 'block',
										'max'             => 4,
										'instructions'    => __( 'Add up to 3 push items (overline, title, image, link).', 'wp-cinquante-et-un' ) . ' <em>(' . __( 'Optional', 'wp-cinquante-et-un' ) . ')</em>.',
										'parent_repeater' => 'field_' . $key . '_menus_main_submenu',
										'button_label'    => __( 'Add Push', 'wp-cinquante-et-un' ),
										'sub_fields'      => array(
											array(
												'key'     => 'field_' . $key . '_menus_main_submenu_pushes_mode',
												'label'   => __( 'Mode', 'wp-cinquante-et-un' ),
												'name'    => 'mode',
												'type'    => 'select',
												'choices' => array(
													'dark' => __( 'Dark', 'wp-cinquante-et-un' ),
													'light' => __( 'Light', 'wp-cinquante-et-un' ),
												),
												'default' => 'dark',
												'return_format' => 'value',
												'parent_repeater' => 'field_' . $key . '_menus_main_submenu_pushes',
												'instructions' => __( 'Select the mode for the push.', 'wp-cinquante-et-un' ) . ' <em>(' . __( 'Optional', 'wp-cinquante-et-un' ) . ')</em>.',
											),
											array(
												'key'   => 'field_' . $key . '_menus_main_submenu_pushes_overline',
												'label' => __( 'Overline', 'wp-cinquante-et-un' ),
												'name'  => 'overline',
												'type'  => 'text',
												'placeholder' => __( 'Overline', 'wp-cinquante-et-un' ),
												'parent_repeater' => 'field_' . $key . '_menus_main_submenu_pushes',
											),
											array(
												'key'   => 'field_' . $key . '_menus_main_submenu_pushes_title',
												'label' => __( 'Title', 'wp-cinquante-et-un' ),
												'name'  => 'title',
												'type'  => 'text',
												'placeholder' => __( 'Title', 'wp-cinquante-et-un' ),
												'parent_repeater' => 'field_' . $key . '_menus_main_submenu_pushes',
											),
											array(
												'key'   => 'field_' . $key . '_menus_main_submenu_pushes_image',
												'label' => __( 'Image', 'wp-cinquante-et-un' ),
												'name'  => 'image',
												'type'  => 'image',
												'return_format' => 'id',
												'preview_size' => 'medium',
											),
											array(
												'key'   => 'field_' . $key . '_menus_main_submenu_pushes_link',
												'label' => __( 'Link', 'wp-cinquante-et-un' ),
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
					'title'    => __( 'Theme Fields', 'wp-cinquante-et-un' ),
					'fields'   => $fields,
					'location' => $location,
				)
			);
		}
	}
}
