<?php
/**
 * Vite
 *
 * @package WPCinquanteEtUn
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace WPCinquanteEtUn;

use Exception;

/**
 * Vite
 *
 * @package WPCinquanteEtUn
 */
class Vite implements Service {

	/**
	 * Flag to determine whether hot server is active.
	 *
	 * Set when boot() is called.
	 *
	 * @var bool
	 */
	private static bool $is_hot = false;

	/**
	 * The URI to the hot server.
	 *
	 * Set when boot() is called.
	 *
	 * @var string
	 */
	private static string $server;

	/**
	 * The path where compiled assets will go.
	 *
	 * @var string
	 */
	private static string $build_path = 'dist';

	/**
	 * Manifest file contents.
	 *
	 * Set when boot() is called.
	 *
	 * @var array
	 */
	private static array $manifest = array();


	/**
	 * Bootstrap Vite (satisfies Service contract). Delegates to static boot().
	 *
	 * @return void
	 */
	public function run(): void {
		self::boot( null, true );
	}


	/**
	 * Boot Vite (static entry point). Initializes state and optionally outputs the client script.
	 *
	 * @param  string|null $build_path Build path.
	 * @param  bool        $output     Whether to output the Vite client.
	 * @return string|null
	 * @throws Exception Exception.
	 */
	public static function boot( ?string $build_path = null, bool $output = true ): ?string {
		if ( is_admin() || wp_doing_ajax() || wp_is_json_request() ) {
			return null;
		}

		static::$is_hot = file_exists( static::hot_file_path() );

		// Have we got a build path override?
		if ( $build_path ) {
			static::$build_path = $build_path;
		}

		// Are we running hot?
		if ( static::$is_hot ) {
			// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Safe usage.
			static::$server = file_get_contents( static::hot_file_path() );
			$client         = static::$server . '/@vite/client';

			if ( $output ) {
				// phpcs:ignore 
				printf( '<script type="module" src="%s"></script>', $client );
			}

			return $client;
		}

		// we must have a manifest file...
		$manifest_path = static::build_path() . '/.vite/manifest.json';

		if ( ! file_exists( $manifest_path ) ) {
			throw new Exception( esc_html( __( 'No Vite Manifest exists. Should hot server be running?', 'wp-cinquante-et-un' ) ) );
		}

		// Store our manifest contents.
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Safe usage.
		static::$manifest = json_decode( file_get_contents( $manifest_path ), true );

		return null;
	}

	/**
	 * Enqueue the script module
	 *
	 * @param string|null $build_path Build path.
	 *
	 * @return void
	 * @throws Exception Exception.
	 */
	public static function enqueue_script_module( ?string $build_path = null ): void {
		// we only want to continue if we have a client.
		$client = self::boot( $build_path, false );

		if ( ! $client ) {
			return;
		}

		// Enqueue our client script.
		wp_enqueue_script_module( 'vite-client', $client, array(), null );
	}

	/**
	 * Return URI path to an asset.
	 *
	 * @param string $asset Asset path.
	 *
	 * @return string
	 * @throws Exception Exception.
	 */
	public static function asset( $asset ): string {
		if ( static::$is_hot ) {
			return static::$server . '/' . ltrim( $asset, '/' );
		}

		if ( ! array_key_exists( $asset, static::$manifest ) ) {
			/* translators: %s: asset path */
			throw new Exception( esc_html( sprintf( __( 'Unknown Vite build asset: %s', 'wp-cinquante-et-un' ), $asset ) ) );
		}

		return implode( '/', array( get_stylesheet_directory_uri(), static::$build_path, static::$manifest[ $asset ]['file'] ) );
	}

	/**
	 * Internal method to determine hot_file_path.
	 *
	 * @return string
	 */
	private static function hot_file_path(): string {
		return implode( '/', array( static::build_path(), 'hot' ) );
	}

	/**
	 * Internal method to determine build_path.
	 *
	 * @return string
	 */
	private static function build_path(): string {
		return implode( '/', array( get_stylesheet_directory(), static::$build_path ) );
	}

	/**
	 * Return URI path to an image.
	 *
	 * @param string $img Image path.
	 *
	 * @return string|null
	 * @throws Exception Exception.
	 */
	public static function img( string $img ): ?string {

		try {

			// set the asset path to the image.
			$asset = 'src/img/' . ltrim( $img, '/' );

			// if we're not running hot, return the asset.
			return static::asset( $asset );

		} catch ( Exception $e ) {

			// handle the exception here or log it if needed.
			// you can also return a default image or null in case of an error.
			return $e->getMessage(); // Optionally, you can retrieve the error message.

		}
	}
}
