<?php
/**
 * Class Page
 *
 * @package WPCinquanteEtUn
 * @subpackage WPCinquanteEtUn/Page
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace WPCinquanteEtUn\Post;

use Timber\{ Timber };
use WPCinquanteEtUn\Service;

/**
 * Page class
 */
class Page implements Service {

	/**
	 * Runs initialization tasks.
	 *
	 * @access public
	 */
	public function run(): void {
		add_action( 'wp_ajax_nopriv_child_pages_slideshow', array( $this, 'child_pages_slideshow' ) );
		add_action( 'wp_ajax_child_pages_slideshow', array( $this, 'child_pages_slideshow' ) );
	}


	/**
	 * Handles the AJAX request to load child pages slideshow HTML.
	 *
	 * @return void Outputs the response directly and terminates the script.
	 */
	public function child_pages_slideshow() {
		if ( ! isset( $_GET['nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_GET['nonce'] ) ), 'security' ) ) {
			wp_send_json_error( array( 'message' => __( 'Security verification failed. Please try again.', 'wp-cinquante-et-un' ) ), 403 );
			wp_die();
		}

		$id = isset( $_GET['id'] ) ? absint( wp_unslash( $_GET['id'] ) ) : 0;

		if ( ! $id ) {
			wp_send_json_error(
				array(
					'html'    => '',
					'message' => __( 'Invalid request.', 'wp-cinquante-et-un' ),
				),
				400
			);
			wp_die();
		}

		$parent = Timber::get_post( $id );

		if ( ! $parent ) {
			wp_send_json_error(
				array(
					'html'    => '',
					'message' => __( 'The requested content could not be found.', 'wp-cinquante-et-un' ),
				),
				404
			);
			wp_die();
		}

		$html = Timber::compile( 'blocks/_child-pages-by-parent-slideshow.html.twig', array( 'posts' => $parent->children( array( 'post_type' => 'page' ) ) ) );

		wp_send_json_success(
			array(
				'html'    => $html,
				'message' => __( 'Content loaded.', 'wp-cinquante-et-un' ),
			)
		);

		wp_die();
	}
}
