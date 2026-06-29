<?php
/**
 * WordPress helpers function
 *
 * Helpers are auto-loaded via composer.json "files" directive.
 *
 * @package WPCinquanteEtUn
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

/**
 * Retrieve the classes for the html element as an array.
 *
 * @param  string|array $c One or more classes to add to the class list.
 * @return array Array of classes.
 * @access public
 */
function get_html_class( $c = '' ): array {
	$classes = array();

	if ( ! empty( $c ) ) {
		if ( ! is_array( $c ) ) {
			$c = preg_split( '#\s+#', $c );
		}
		$classes = array_merge( $classes, $c );
	} else {
		// Ensure that we always coerce class to being an array.
		$c = array();
	}
	$classes = array_map( 'esc_attr', $classes );
	/**
	 * Filter the list of CSS html classes for the current post or page.
	 *
	 * @param array  $classes An array of html classes.
	 * @param string $c   A comma-separated list of additional classes added to the html.
	 */
	$classes = apply_filters( 'html_class', $classes, $c );

	return array_unique( $classes );
}


/**
 * Display the classes for the html element.
 *
 * @param string|array $c One or more classes to add to the class list.
 * @return string
 */
function html_class( string $c = '' ): string {
	// Separates classes with a single space, collates classes for html element.
	return 'class="' . join( ' ', get_html_class( $c ) ) . '"';
}
