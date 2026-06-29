<?php
/**
 * Twig
 *
 * @package WPCinquanteEtUn
 * @subpackage WPCinquanteEtUn/Setup
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace WPCinquanteEtUn\Setup;

use Twig\Extra\Html\{ HtmlExtension };
use Twig\Extra\Intl\{ IntlExtension };
use Twig\{ TwigFunction };
use WPCinquanteEtUn\{ Service, Vite };

/**
 * Twig
 */
class Twig implements Service {

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function run(): void {
		add_filter( 'timber/twig', array( $this, 'add_functions' ) );
		add_filter( 'timber/twig', array( $this, 'add_extensions' ) );
		add_filter( 'timber/twig/environment/options', array( $this, 'set_environment_options' ), 10, 1 );
	}



	/**
	 * Set options
	 *
	 * @param array $options Array of options.
	 *
	 * @return array $options
	 */
	public function set_environment_options( array $options ): array {
		$options['cache']       = WP_DEBUG ? false : true;
		$options['auto_reload'] = WP_DEBUG;

		return $options;
	}


	/**
	 * Add extensions
	 *
	 * @param object $twig Twig environment.
	 *
	 * @access public
	 *
	 * @return object $twig
	 */
	public function add_extensions( object $twig ): object {
		$twig->addExtension( new HtmlExtension() );
		$twig->addExtension( new IntlExtension() );

		return $twig;
	}


	/**
	 * Add functions
	 *
	 * @param object $twig Twig environment.
	 *
	 * @access public
	 *
	 * @return object $twig
	 */
	public function add_functions( object $twig ): object {
		$twig->addFunction(
			new TwigFunction(
				'html_class',
				function ( string $args = '' ) {
					return html_class( $args );
				}
			)
		);

		$twig->addFunction(
			new TwigFunction(
				'body_class',
				function ( $args = '' ) {
					return body_class( $args );
				}
			)
		);

		// Add get_extended function.
		if ( function_exists( 'get_extended' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'get_extended',
					function ( $content ) {
						return get_extended( $content );
					}
				)
			);
		}

		if ( function_exists( 'wp_get_document_title' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'wp_get_document_title',
					function () {
						return wp_get_document_title();
					}
				)
			);
		}

		$twig->addFunction( new TwigFunction( 'uniqid', 'uniqid' ) );

		$twig->addFunction(
			new TwigFunction(
				'asset',
				function ( $asset ) {
					return Vite::asset( $asset );
				}
			)
		);

		// Add Yoast Breadcrumbs function.
		$twig->addFunction(
			new TwigFunction(
				'yoast_breadcrumb',
				function ( $before = '<div class="text-mention-large">', $after = '</div>', $display = false ) {
					return function_exists( 'yoast_breadcrumb' ) ? yoast_breadcrumb( $before, $after, $display ) : '';
				}
			)
		);

		// Add Polylang function if it exists.
		if ( function_exists( 'pll__' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'pll__',
					fn( $text ) => pll__( $text )
				)
			);
		}

		if ( function_exists( 'pll_the_languages' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'pll_the_languages',
					function ( $args = array( 'raw' => true ) ) {
						return pll_the_languages( $args );
					}
				)
			);
		}

		// @see https://developer.wordpress.org/reference/functions/get_search_form/
		$twig->addFunction(
			new TwigFunction(
				'get_search_form',
				function ( $args = array( 'echo' => false ) ) {
					return get_search_form( $args );
				}
			)
		);

		// @see https://developer.wordpress.org/reference/functions/get_search_query/
		$twig->addFunction(
			new TwigFunction(
				'get_search_query',
				function () {
					return get_search_query();
				}
			)
		);

		return $twig;
	}
}
