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


/**
 * Get the destination languages for the Weglot plugin.
 *
 * @param array $args
 *   - class: string
 *   - id: string
 *   - show_flags: bool
 *   - show_names: bool
 *   - name_format: string
 *   - include_original: bool
 * @return array
 */
function cinq_custom_language_selector( array $args = array() ): array {

	if ( ! function_exists( 'weglot_get_current_language' ) ) {
		return array();
	}

	$defaults = array(
		'class'            => 'weglot-custom-select',
		'id'               => 'weglot-language-selector',
		'show_flags'       => false,
		'show_names'       => true,
		'name_format'      => 'local', // 'local', 'english', 'code'
		'include_original' => true,
	);

	$args = wp_parse_args( $args, $defaults );

	$current_language    = weglot_get_current_language();
	$service             = weglot_get_service( 'Language_Service_Weglot' );
	$request_url_service = weglot_get_request_url_service();
	$languages           = $service->get_original_and_destination_languages(
		$request_url_service->is_allowed_private()
	);

	$original_language = $service->get_original_language();

	if ( empty( $languages ) ) {
		return array();
	}

	$options = array();

	foreach ( $languages as $language ) {
		if ( ! $args['include_original'] &&
			$language->getInternalCode() === $original_language->getInternalCode() ) {
			continue;
		}

		$language_url = $request_url_service->get_weglot_url()->getForLanguage( $language, true );

		if ( ! $language_url ) {
			continue;
		}

		$display_name = '';
		switch ( $args['name_format'] ) {
			case 'english':
				$display_name = $language->getEnglishName();
				break;
			case 'code':
				$display_name = strtoupper( $language->getExternalCode() );
				break;
			case 'local':
			default:
				$display_name = $language->getLocalName();
				break;
		}

		$options[] = array(
			'code'          => $language->getInternalCode(),
			'external_code' => $language->getExternalCode(),
			'name'          => $display_name,
			'url'           => $language_url,
			'current'    => $language->getInternalCode() === $current_language,
		);
	}

	return $options;
}
