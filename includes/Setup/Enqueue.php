<?php
/**
 * Enqueue
 *
 * @package AgenceCinq
 * @subpackage AgenceCinq/Setup
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Setup;

use AgenceCinq\{ Service, Vite };

/**
 * Theme asset enqueue setup.
 *
 * Registers and enqueues stylesheets and scripts used by the theme.
 *
 * @package AgenceCinq
 * @subpackage AgenceCinq\Setup
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
		add_filter( 'wp_preload_resources', array( $this, 'preload_resources' ) );
		add_filter( 'wp_resource_hints', array( $this, 'resource_hints' ), 10, 2 );
		add_filter( 'wp_speculation_rules_configuration', array( $this, 'speculation_rules_configuration' ) );
		add_filter( 'style_loader_tag', array( $this, 'style_loader_tag' ), 10, 2 );

		// Contact Form 7 scripts only on pages that render a form.
		add_filter( 'wpcf7_load_js', '__return_false' );
		add_action( 'wpcf7_shortcode_callback', 'wpcf7_enqueue_scripts' );
	}


	/**
	 * Load the Axeptio stylesheet without blocking the render.
	 *
	 * It only styles the placeholder of the Axeptio shortcode, inside the content:
	 * the cookie banner comes from the SDK.
	 *
	 * @param string $tag    Link tag.
	 * @param string $handle Style handle.
	 * @return string
	 */
	public function style_loader_tag( string $tag, string $handle ): string {
		if ( 'axeptio/main' !== $handle ) {
			return $tag;
		}

		return str_replace( "media='all'", "media='print' onload=\"this.media='all'\"", $tag );
	}


	/**
	 * Preload the fonts painted above the fold (Inter for titles and body,
	 * JetBrains Mono for eyebrows and buttons) so they are not discovered only once the CSS is parsed.
	 *
	 * @param array $resources Resources to preload.
	 * @return array
	 */
	public function preload_resources( array $resources ): array {
		foreach ( array( 'inter-variable', 'jetbrains-mono-variable' ) as $font ) {
			$resources[] = array(
				'href'        => Vite::asset( 'src/fonts/' . $font . '.woff2' ),
				'as'          => 'font',
				'type'        => 'font/woff2',
				'crossorigin' => 'anonymous',
			);
		}

		return $resources;
	}


	/**
	 * Connect to the Axeptio SDK origin ahead: the plugin injects the SDK from
	 * a script at the end of the body, so the browser only discovers it there.
	 *
	 * @param array  $urls          URLs to print for resource hints.
	 * @param string $relation_type Relation type the URLs are printed for.
	 * @return array
	 */
	public function resource_hints( array $urls, string $relation_type ): array {
		if ( 'preconnect' === $relation_type && wp_script_is( 'axeptio/sdk-script' ) ) {
			$urls[] = 'https://static.axept.io';
		}

		return $urls;
	}


	/**
	 * Prefetch a linked page after a short hover (`moderate`) rather than on
	 * click. Prefetch only: prerendering would run the page's scripts before
	 * it is shown. `null` (logged-in visitors, plain permalinks) keeps
	 * speculative loading off.
	 *
	 * @param array|null $config Speculation rules configuration.
	 * @return array|null
	 */
	public function speculation_rules_configuration( ?array $config ): ?array {
		if ( null === $config ) {
			return null;
		}

		return array(
			'mode'      => 'prefetch',
			'eagerness' => 'moderate',
		);
	}


	/**
	 * Enqueue styles.
	 *
	 * Enqueue stylesheets. Fonts are self-hosted: see src/stylesheets/base/font-face.css.
	 *
	 * @access public
	 * @return void
	 */
	public function enqueue_styles(): void {
		$filename = Vite::asset( 'src/stylesheets/styles.css' );

		wp_enqueue_style( get_theme_text_domain() . '-main', $filename, array(), null );
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

		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'contact-form-7' );
		wp_dequeue_style( 'contact-form-7-rtl' );
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
			'rest_nonce'             => wp_create_nonce( 'wp_rest' ),
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
