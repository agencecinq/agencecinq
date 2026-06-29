<?php
/**
 * SavePost Class
 *
 * @package WPCinquanteEtUn
 * @subpackage WPCinquanteEtUn/Plugins/ACF
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace WPCinquanteEtUn\Plugins\ACF;

use WPCinquanteEtUn\Service;

/**
 * SavePost Class
 *
 * Extension point hooked on acf/save_post. Add per-project logic here
 * (post-processing of fields after a save). Empty by default.
 */
class SavePost implements Service {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run(): void {
		add_filter( 'acf/save_post', array( $this, 'save_post' ), 20, 1 );
	}

	/**
	 * Handles the saving of a post using its ID.
	 *
	 * @param int|string $post_id The ID of the post being saved.
	 * @return void
	 */
	public function save_post( int|string $post_id ): void {
		if ( ! is_numeric( $post_id ) || (int) $post_id <= 0 ) {
			return;
		}

		// Add project-specific post-save logic here.
	}
}
