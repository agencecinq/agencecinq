<?php
/**
 * Template Name: Styleguide
 *
 * Living catalog of the design tokens, from the Figma foundations.
 *
 * @package AgenceCinq
 */

use Timber\Timber;

add_filter(
	'wp_robots',
	static function ( array $robots ): array {
		$robots['noindex']  = true;
		$robots['nofollow'] = true;

		return $robots;
	}
);

$templates = array( 'pages/styleguide-page.html.twig' );
$data      = Timber::context();

Timber::render( $templates, $data );
