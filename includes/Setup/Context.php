<?php
/**
 * Context
 *
 * @package AgenceCinq
 * @subpackage AgenceCinq/Setup
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Setup;

use AgenceCinq\Service;
use Timber\{Timber, Site, Post };
use AgenceCinq\Models\{ SinglePost, CaseStudy, StyleguidePage };
use WP_Post;

/**
 * Context
 *
 * Adds custom data to the global context.
 *
 * @package AgenceCinq
 */
class Context extends Site implements Service {

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function run(): void {
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/context', array( $this, 'add_menus_to_context' ) );
		add_filter( 'timber/post/classmap', array( $this, 'add_post_classmap' ) );
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
			'page'       => function ( WP_Post $post ) {
				if ( 'page-templates/styleguide-page.php' === get_page_template_slug( $post ) ) {
					return StyleguidePage::class;
				}

				return Post::class;
			},
			'post'       => SinglePost::class,
			'case-study' => CaseStudy::class,
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

		foreach ( $menus as $key => $value ) {
			$context['nav_menus'][ $key ] = Timber::get_menu( $key );
		}

		return $context;
	}
}
