<?php
/**
 * WP Image Editor
 *
 * @package WPCinquanteEtUn
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace WPCinquanteEtUn;

/**
 * WP Image editor
 */
class WPImageEditor implements Service {

	/**
	 * Run default hooks and actions for WordPress
	 *
	 * @return void
	 */
	public function run(): void {
		add_filter( 'wp_editor_set_quality', array( $this, 'quality' ), 10, 2 );
	}

	/**
	 * Quality
	 *
	 * @param int    $quality   Quality level between 1 (low) and 100 (high).
	 * @param string $mime_type Image mime type.
	 *
	 * @see https://developer.wordpress.org/reference/hooks/wp_editor_set_quality/
	 *
	 * @return int
	 */
	public function quality( int $quality, string $mime_type ): int { // phpcs:ignore 
		return 100;
	}
}
