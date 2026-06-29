<?php
/**
 * Context
 *
 * @package WPCinquanteEtUn
 * @subpackage WPCinquanteEtUn/Setup
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace WPCinquanteEtUn\Setup;

use WPCinquanteEtUn\Service;
use Timber\{Timber, Site };
use WPCinquanteEtUn\Models\{ CategoryArchive, Page, Home, SinglePost };
use WP_Post;

/**
 * Context
 *
 * Adds custom data to the global context.
 *
 * @package WPCinquanteEtUn
 */
class Context extends Site implements Service {

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function run(): void {
		add_filter( 'timber/context', array( $this, 'add_socials_to_context' ) );
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/context', array( $this, 'add_menus_to_context' ) );
		add_filter( 'timber/post/classmap', array( $this, 'add_post_classmap' ) );
		add_filter( 'timber/term/classmap', array( $this, 'add_term_classmap' ) );
	}


	/**
	 * Add socials to context
	 *
	 * Add socials and share links to the global context.
	 *
	 * Then you can access them in Twig via the `socials` and `shares` variables.
	 *
	 * @example
	 * {% for social in socials %}
	 *  <a href="{{ social.url }}">{{ social.name }}</a>
	 * {% endfor %}
	 *
	 * @param array $context The global context.
	 *
	 * @return array
	 */
	public function add_socials_to_context( array $context ): array {
		// Share and Socials links.
		$socials = include get_template_directory() . '/includes/socials.php';

		foreach ( $socials as $social ) {
			if ( ! empty( $social['url'] ) ) {
				$context['socials'][ $social['id'] ] = $social;
			}

			if ( ! empty( $social['link'] ) ) {
				$context['shares'][ $social['id'] ] = $social;
			}
		}

		return $context;
	}


	/**
	 * Add custom data to the global context.
	 *
	 * @param array $context The global context.
	 *
	 * @return array
	 */
	public function add_to_context( array $context ): array {
		global $wp;

		$context['current_url']        = home_url( add_query_arg( array(), $wp->request ) );
		$context['privacy_policy_url'] = get_privacy_policy_url();
		$context['posts_url']          = get_permalink( get_option( 'page_for_posts' ) );
		$context['home_url']           = home_url( '/' );

		$context['theme'] = get_field( 'theme', 'option' );
		$context['menus'] = get_field( 'menus', 'option' );

		return $context;
	}

	/**
	 * Add post classmap
	 *
	 * Add custom post classmap.
	 *
	 * @param array $classmap Classmap.
	 *
	 * @see https://timber.github.io/docs/v2/guides/class-maps/#the-post-class-map
	 *
	 * @return array
	 */
	public function add_post_classmap( array $classmap ): array {
		$custom_classmap = array(
			'page' => function ( WP_Post $post ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found -- Reserved for future use.
				if ( is_home() ) {
					return Home::class;
				}

				return Page::class;
			},
			'post' => SinglePost::class,
		);

		return array_merge( $classmap, $custom_classmap );
	}


	/**
	 * Add term classmap
	 *
	 * Add custom term classmap.
	 *
	 * @param array $classmap Classmap.
	 *
	 * @see https://timber.github.io/docs/v2/guides/class-maps/#the-term-class-map
	 *
	 * @return array
	 */
	public function add_term_classmap( array $classmap ): array {
		$custom_classmap = array(
			'category' => CategoryArchive::class,
		);

		return array_merge( $classmap, $custom_classmap );
	}


	/**
	 * Add menus to context
	 *
	 * Add menus to the global context. Create your menu, assign it a location, and it will be
	 * available in Twig via the `nav_menus` variable.
	 *
	 * @example
	 * {% for item in nav_menus.main.get_items() %}
	 *   <a href="{{ item.link }}">{{ item.title }}</a>
	 * {% endfor %}
	 *
	 * @param array $context The global context.
	 *
	 * @see https://developer.wordpress.org/reference/functions/get_registered_nav_menus/
	 * @see https://timber.github.io/docs/v2/guides/menus/
	 *
	 * @return array
	 */
	public function add_menus_to_context( array $context ): array {
		$menus = get_registered_nav_menus();

		foreach ( $menus as $menu => $value ) {
			$context['nav_menus'][ $menu ] = Timber::get_menu( $menu );
		}

		return $context;
	}
}
