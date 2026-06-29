<?php
/**
 * ACF Init
 *
 * @package WPCinquanteEtUn
 * @subpackage WPCinquanteEtUn/Plugins/ACF
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace WPCinquanteEtUn\Plugins\ACF;

use WPCinquanteEtUn\Plugins\ACF\FieldTypes\MenuItemSelect;
use WPCinquanteEtUn\Service;

/**
 * ACF Init
 *
 * @package WPCinquanteEtUn
 * @subpackage WPCinquanteEtUn/Plugins/ACF
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */
class Init implements Service {

	/**
	 * Runs the initialization tasks.
	 *
	 * @return void
	 */
	public function run(): void {
		add_action( 'acf/init', array( $this, 'add_options_pages' ) );
		add_action( 'acf/init', array( $this, 'register_menu_item_select_field' ) );
	}


	/**
	 * Adds the options pages.
	 *
	 * @return void
	 */
	public function add_options_pages(): void {
		acf_add_options_page(
			array(
				'page_title'  => __( 'Archive', 'wp-cinquante-et-un' ),
				'menu_slug'   => 'archive-post',
				'parent_slug' => 'edit.php',
				'position'    => '',
				'redirect'    => false,
			)
		);

		acf_add_options_page(
			array(
				'page_title'  => __( 'Theme', 'wp-cinquante-et-un' ),
				'menu_slug'   => 'options-theme',
				'parent_slug' => 'options-general.php',
				'position'    => '',
				'redirect'    => false,
			)
		);
	}

	/**
	 * Registers the custom ACF field type "Menu Item Select".
	 *
	 * @return void
	 */
	public function register_menu_item_select_field(): void {
		if ( function_exists( 'acf_register_field_type' ) ) {
			acf_register_field_type( MenuItemSelect::class );
		}
	}
}
