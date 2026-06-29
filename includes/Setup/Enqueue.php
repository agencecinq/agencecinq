<?php
/**
 * Enqueue
 *
 * @package WPCinquanteEtUn
 * @subpackage WPCinquanteEtUn/Setup
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace WPCinquanteEtUn\Setup;

use WPCinquanteEtUn\{ Service, Vite };

/**
 * Theme asset enqueue setup.
 *
 * Registers and enqueues stylesheets and scripts used by the theme.
 *
 * @package WPCinquanteEtUn
 * @subpackage WPCinquanteEtUn\Setup
 */
class Enqueue implements Service {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run(): void {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'dequeue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_action( 'wp_head', array( $this, 'preload_wp_scripts' ) );
		add_action( 'wp_head', array( $this, 'preload_wp_styles' ) );
	}


	/**
	 * Enqueue styles.
	 *
	 * Enqueue stylesheets.
	 *
	 * @access public
	 * @return void
	 */
	public function enqueue_styles(): void {
		$deps = array();

		// Google Fonts.
		wp_register_style( 'google-fonts-montserrat', '//fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap', array(), null );
		$deps[] = 'google-fonts-montserrat';

		// register theme-style-css.
		$filename = Vite::asset( 'src/stylesheets/styles.css' );

		// enqueue theme-style-css into our head.
		wp_enqueue_style( get_theme_text_domain() . '-main', $filename, $deps, null );
		wp_enqueue_style( get_theme_text_domain() . '-style', get_stylesheet_uri(), array( get_theme_text_domain() . '-main' ), null );
	}


	/**
	 * Dequeue styles
	 *
	 * Remove styles that are not needed since we don't use the Gutenberg block styles.
	 *
	 * @access public
	 * @return void
	 */
	public function dequeue_styles(): void {
	}

	/**
	 * Enqueue scripts
	 *
	 * @access public
	 * @return void
	 */
	public function enqueue_scripts(): void {

		wp_deregister_script( 'jquery' );
		wp_deregister_script( 'wp-embed' );

		$deps = array();

		// Enqueue the Vite module.
		Vite::enqueue_script_module();

		wp_register_script_module(
			get_theme_text_domain() . '-main',
			Vite::asset( 'src/scripts/app.js' ),
			$deps,
			null
		);

		// We register an empty feature script to attach inline scripts to.
		wp_register_script( get_theme_text_domain() . '-feature', false );
		// These no-touch and no-js classes are added by default in the <html> tag by WordPress. We
		// replace them with touch/js classes when appropriate.
		wp_add_inline_script( get_theme_text_domain() . '-feature', '!function(e,n,o){("ontouchstart"in e||e.DocumentTouch&&n instanceof DocumentTouch||o.MaxTouchPoints>0||o.msMaxTouchPoints>0)&&(n.documentElement.className=n.documentElement.className.replace(/\bno-touch\b/,"touch")),n.documentElement.className=n.documentElement.className.replace(/\bno-js\b/,"js")}(window,document,navigator);' );
		// Detect Safari browser. We add an is-safari class to the <html> tag when Safari is detected.
		wp_add_inline_script( get_theme_text_domain() . '-feature', '/Safari/.test(navigator.userAgent)&&/Apple Computer/.test(navigator.vendor)&&(document.documentElement.className+=" is-safari");' );

		$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
		$current_url = is_singular() ? get_permalink() : ( $request_uri ? esc_url_raw( home_url( $request_uri ) ) : home_url() );

		$data = array(
			'template_directory_uri' => get_template_directory_uri(),
			'base_url'               => site_url(),
			'home_url'               => home_url( '/' ),
			'ajax_url'               => admin_url( 'admin-ajax.php' ),
			'api_url'                => home_url( 'wp-json' ),
			'current_url'            => $current_url,
			'nonce'                  => wp_create_nonce( 'security' ),
			'text_domain'            => get_theme_text_domain(),
		);

		// @TODO doesn't work with wp_enqueue_script_module so we use wp_add_inline_script attached to the feature script.
		wp_add_inline_script(
			get_theme_text_domain() . '-feature',
			'var cinq = ' . wp_json_encode(
				$data
			),
			'before'
		);

		wp_enqueue_script( get_theme_text_domain() . '-feature' );
		wp_enqueue_script_module( get_theme_text_domain() . '-main' );
	}


	/**
	 * Preload scripts
	 *
	 * We add preload links for our scripts for faster loading.
	 *
	 * @access public
	 * @return void
	 */
	public function preload_wp_scripts(): void {
		global $wp_scripts;

		foreach ( $wp_scripts->queue as $handle ) {
			if ( ! isset( $wp_scripts->registered[ $handle ] ) ) {
				continue;
			}
			$script = $wp_scripts->registered[ $handle ];

			if ( substr( $script->handle, 0, strlen( get_theme_text_domain() ) ) !== get_theme_text_domain() ) {
				continue;
			}

			if ( isset( $script->extra['group'] ) && 1 === $script->extra['group'] ) {
				$href = $script->src . ( $script->ver ? "?ver={$script->ver}" : '' );
				echo '<link rel="preload" as="script" href="' . esc_attr( $href ) . '">';
			}
		}
	}


	/**
	 * Preload styles
	 *
	 * We add preload links for our styles for faster loading.
	 *
	 * @access public
	 * @return void
	 */
	public function preload_wp_styles(): void {
		global $wp_styles;

		foreach ( $wp_styles->queue as $handle ) {
			$style = $wp_styles->registered[ $handle ];

			if ( substr( $style->handle, 0, strlen( get_theme_text_domain() ) ) !== get_theme_text_domain() ) {
				continue;
			}

			$href = $style->src . ( $style->ver ? "?ver={$style->ver}" : '' );
			echo '<link rel="preload" as="style" href="' . esc_attr( $href ) . '">';

		}
	}
}
