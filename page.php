<?php
/**
 * Page template file
 *
 * @package WPCinquanteEtUn
 * @subpackage WPCinquanteEtUn/Page
 */

use Timber\{ Timber };

$data      = Timber::context();
$templates = array( 'index.html.twig' );

$has_parent   = (int) $post->post_parent > 0;
$has_children = get_children(
	array(
		'post_parent' => $post->ID,
		'post_type'   => 'page',
		'post_status' => 'publish',
		'numberposts' => 1,
		'fields'      => 'ids',
	)
);

if ( $has_parent ) {
	$templates = array( 'pages/child-page.html.twig' );
}

if ( ! empty( $has_children ) && ! $has_parent ) {
	$templates = array( 'pages/parent-page.html.twig' );
}


Timber::render( $templates, $data );
