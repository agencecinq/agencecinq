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
		add_filter( 'script_module_data_' . get_theme_text_domain() . '-main', array( $this, 'script_module_data' ) );

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

		// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- Vite hashes the filename.
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

		wp_enqueue_script_module( get_theme_text_domain() . '-main' );
	}


	/**
	 * Data of the main module, read by src/scripts/theme.ts.
	 *
	 * A script module takes no inline script: WordPress prints this data as JSON
	 * in the footer, in script#wp-script-module-data-agencecinq-main.
	 *
	 * @param array $data Data of the module.
	 * @return array
	 */
	public function script_module_data( array $data ): array {
		$data['api_url']    = home_url( 'wp-json' );
		$data['rest_nonce'] = wp_create_nonce( 'wp_rest' );

		return $data;
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
