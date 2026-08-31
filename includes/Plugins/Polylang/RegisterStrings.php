<?php

/**
 * Register Strings
 *
 * @package WordPress
 * @subpackage AgenceCinq\Plugins\Polylang
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\Polylang;

/**
 * Front Page Fields class
 *
 * @package WordPress
 * @subpackage AgenceCinq\Plugins\Polylang\RegisterStrings
 */
class RegisterStrings {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() {
		if ( function_exists( 'pll_the_languages' ) && function_exists( 'pll_register_string' ) ) {
			add_action( 'after_setup_theme', array( $this, 'register_strings' ) );
		}
	}

	/**
	 * Register strings for Polylang translation.
	 *
	 * * @see https://polylang.pro/doc/function-reference/#pll_register_string
	 *
	 * @return void
	 */
	public function register_strings(): void {
		// @example pll_register_string( 'context', 'string to translate', 'domain' );
	}
}
