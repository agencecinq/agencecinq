<?php
/**
 * WPSettings
 *
 * @package AgenceCinq
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq;

/**
 * WP Settings
 */
class WPSettings implements Service {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run(): void {
		add_action( 'after_setup_theme', array( $this, 'register_menus' ) );
		add_action( 'after_setup_theme', array( $this, 'add_theme_supports' ) );
		add_action( 'after_setup_theme', array( $this, 'load_textdomain' ), 0 );
		add_filter( 'wp_robots', array( $this, 'robots' ) );
	}

	/**
	 * Mark 404 responses as noindex.
	 *
	 * @param array<string, bool|string> $robots Associative array of robots directives.
	 * @return array<string, bool|string>
	 */
	public function robots( array $robots ): array {
		if ( is_404() ) {
			$robots['noindex'] = true;
		}

		return $robots;
	}

	/**
	 * Load theme text domain for translations.
	 *
	 * @see https://developer.wordpress.org/reference/functions/load_theme_textdomain/
	 *
	 * @return void
	 */
	public function load_textdomain(): void {
		load_theme_textdomain( 'agencecinq', get_template_directory() . '/languages' );
	}

	/**
	 * Register nav menus
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_nav_menus/
	 *
	 * @return void
	 */
	public function register_menus(): void {
		register_nav_menus(
			array(
				'main'      => __( 'Main Menu', 'agencecinq' ),
				'secondary' => __( 'Secondary Menu', 'agencecinq' ),
				'footer'    => __( 'Footer Menu', 'agencecinq' ),
				'legals'    => __( 'Legals Menu', 'agencecinq' ),
			)
		);
	}

	/**
	 * Add theme supports
	 *
	 * @return void
	 */
	public function add_theme_supports(): void {
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @see https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);
	}
}
