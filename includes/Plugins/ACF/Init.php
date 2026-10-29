<?php
/**
 * ACF Init
 *
 * @package AgenceCinq
 * @subpackage AgenceCinq/Plugins/ACF
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF;

use AgenceCinq\Service;

/**
 * ACF Init
 *
 * @package AgenceCinq
 * @subpackage AgenceCinq/Plugins/ACF
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */
class Init implements Service {

	/**
	 * Whether the locale was switched to register the fields.
	 *
	 * @var bool
	 */
	private bool $switched = false;

	/**
	 * Runs the initialization tasks.
	 *
	 * @return void
	 */
	public function run(): void {
		add_action( 'acf/init', array( $this, 'add_options_pages' ) );
		add_action( 'acf/include_fields', array( $this, 'switch_to_site_locale' ), 1 );
		add_action( 'acf/include_fields', array( $this, 'restore_locale' ), PHP_INT_MAX );
	}


	/**
	 * Registers the fields in the language of the site: their default values end up on the page,
	 * whatever the language of the admin profile.
	 *
	 * @return void
	 */
	public function switch_to_site_locale(): void {
		$this->switched = switch_to_locale( get_locale() );
	}


	/**
	 * Restores the language of the admin profile.
	 *
	 * @return void
	 */
	public function restore_locale(): void {
		if ( $this->switched ) {
			restore_previous_locale();
		}
	}


	/**
	 * Adds the options pages.
	 *
	 * @return void
	 */
	public function add_options_pages(): void {
		acf_add_options_page(
			array(
				'page_title'  => __( 'Theme', 'agencecinq' ),
				'menu_slug'   => 'options-theme',
				'parent_slug' => 'options-general.php',
				'position'    => '',
				'redirect'    => false,
			)
		);
	}
}
