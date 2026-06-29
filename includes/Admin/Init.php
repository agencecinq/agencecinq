<?php
/**
 * Class Init
 *
 * Initializes and manages admin-specific functionality for the WP_CINQ theme.
 *
 * @package WPCinquanteEtUn
 * @subpackage WPCinquanteEtUn/Admin
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace WPCinquanteEtUn\Admin;

use WPCinquanteEtUn\Service;

/**
 * Init
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn/Admin
 */
class Init implements Service {


	/**
	 * Socials.
	 *
	 * @var array
	 */
	public array $socials = array();

	/**
	 * Runs initialization tasks.
	 *
	 * @see https://developer.wordpress.org/reference/hooks/admin_init/
	 *
	 * @return void
	 */
	public function run(): void {
		add_action(
			'admin_init',
			function () {
				$this->socials = include get_template_directory() . '/includes/socials.php';
			}
		);

		add_action( 'admin_init', array( $this, 'add_settings_sections' ) );
		add_action( 'admin_init', array( $this, 'add_settings_fields' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Add Settings Sections
	 *
	 * @return void
	 */
	public function add_settings_sections(): void {
		foreach ( array( 'socials' ) as $section ) {
			add_settings_section(
				'settings_section_' . $section,
				'',
				array( $this, 'section_callback_function' ),
				$section
			);
		}
	}

	/**
	 * Add settings fields
	 *
	 * @return void
	 */
	public function add_settings_fields(): void {
		foreach ( $this->socials as $social ) {
			add_settings_field(
				$social['id'],
				$social['title'],
				array( $this, 'text_callback_function' ),
				'socials',
				'settings_section_socials',
				array(
					'type'        => 'url',
					'name'        => 'socials[' . $social['id'] . ']',
					'placeholder' => $social['placeholder'],
					'description' => $social['description'],
					'value'       => get_option( 'socials' )[ $social['id'] ] ?? '',
				)
			);
		}
	}


	/**
	 * Contacts callback function
	 *
	 * @return void
	 */
	public function section_callback_function(): void {
		echo '';
	}


	/**
	 * Text callback function
	 *
	 * @param array $args Args.
	 *
	 * @return void
	 */
	public function text_callback_function( array $args ): void {
		wp_form_controls_input(
			array(
				'type'        => $args['type'] ?? 'text',
				'name'        => $args['name'],
				'value'       => $args['value'],
				'placeholder' => $args['placeholder'] ?? '',
				'description' => $args['description'] ?? '',
			),
		);
	}

	/**
	 * Email callback function
	 *
	 * @param array $args Args.
	 *
	 * @return void
	 */
	public function email_callback_function( $args ): void {
		wp_form_controls_input(
			array(
				'type'        => 'email',
				'name'        => $args['name'],
				'value'       => $args['value'] ?? '',
				'placeholder' => $args['placeholder'],
				'description' => $args['description'],
				'attributes'  => array(
					'pattern'      => '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$',
					'autocomplete' => 'email',
					'aria-label'   => $args['label'],
				),
			)
		);
	}


	/**
	 * Textarea callback function
	 *
	 * @param array $args Arguments.
	 *
	 * @see https://core.trac.wordpress.org/browser/tags/5.6/src/wp-includes/post-template.php#L1163
	 * @return void
	 */
	public function textarea_callback_function( array $args ): void {
		wp_form_controls_textarea( $args );
	}


	/**
	 * Checkbox callback function
	 *
	 * @param array $args Args.
	 * @return void
	 */
	public function checkbox_callback_function( array $args ): void {
		wp_form_controls_checkbox(
			array(
				'name'        => $args['name'],
				'value'       => $args['value'] ?? '0',
				'description' => $args['description'] ?? '',
				'attributes'  => '1' === $args['value'] ? array( 'checked' => 'true' ) : array(),
			)
		);
	}

	/**
	 * Register settings
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_setting/
	 *
	 * @return void
	 */
	public function register_settings(): void {
		register_setting( 'socials', 'socials', array( $this, 'sanitize' ) );
	}

	/**
	 * Sanitize each setting field as needed.
	 *
	 * @param array|null $input {
	 *     Optional. Contains all settings fields as array keys.
	 *
	 *     @type string $socials[id]                Social network URLs, keyed by social ID.
	 * }
	 *
	 * @return array Sanitized settings array.
	 */
	public function sanitize( array|null $input ): array {
		if ( is_null( $input ) ) {
			return array();
		}
		$new_input = array();

		foreach ( $this->socials as $social ) {
			if ( isset( $input[ $social['id'] ] ) ) {
				$new_input[ $social['id'] ] = sanitize_text_field( $input[ $social['id'] ] );
			}
		}

		return $new_input;
	}
}
