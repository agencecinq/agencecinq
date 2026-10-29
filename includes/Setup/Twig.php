<?php
/**
 * Twig
 *
 * @package AgenceCinq
 * @subpackage AgenceCinq/Setup
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Setup;

use Twig\Extra\Html\{ HtmlExtension };
use Twig\Extra\Intl\{ IntlExtension };
use Twig\{ TwigFilter, TwigFunction };
use AgenceCinq\Service;
use AgenceCinq\Catalogue\{ Catalogue };
use AgenceCinq\GitHub\{ Activity };

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

		$twig->addFunction( new TwigFunction( 'uniqid', 'uniqid' ) );

		// Phone number of a tel: link: digits and the leading +.
		$twig->addFilter(
			new TwigFilter(
				'tel',
				function ( $phone ) {
					return preg_replace( '/[^\d+]/', '', $phone );
				}
			)
		);

		// Public catalogue served by Central, null when it is unavailable.
		$twig->addFunction(
			new TwigFunction(
				'catalogue',
				function () {
					return Catalogue::instance();
				}
			)
		);

		// Colors from includes/schemes.php, for the styleguide and the scheme easter egg.
		$twig->addFunction( new TwigFunction( 'cinq_palette', 'cinq_palette' ) );
		$twig->addFunction( new TwigFunction( 'cinq_schemes', 'cinq_schemes' ) );

		// Repositories of the organization, last pushed first, and the weeks of commits of their default branch.
		$twig->addFunction( new TwigFunction( 'github_activity', array( Activity::class, 'get' ) ) );

		// Prices of a catalogue line, or of a manual item with the same fields, even when Central is unavailable.
		$twig->addFilter( new TwigFilter( 'price', array( Catalogue::class, 'price' ) ) );
		$twig->addFilter( new TwigFilter( 'retainer_tier', array( Catalogue::class, 'retainer_tier' ) ) );
		$twig->addFilter( new TwigFilter( 'retainer_price', array( Catalogue::class, 'retainer_price' ) ) );
		$twig->addFilter( new TwigFilter( 'offer_price', array( Catalogue::class, 'offer_price' ) ) );

		// Breadcrumb levels ({ url, text }) of the current page, from Yoast SEO.
		$twig->addFunction(
			new TwigFunction(
				'breadcrumbs',
				function (): array {
					return function_exists( 'YoastSEO' ) ? YoastSEO()->meta->for_current_page()->breadcrumbs : array();
				}
			)
		);

		return $twig;
	}
}
