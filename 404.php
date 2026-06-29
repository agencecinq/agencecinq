<?php
/**
 * 404
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

use Timber\{ Timber };

$templates    = array( 'pages/404.html.twig' );
$data         = Timber::context();
$data['post'] = array(
	'title'   => __( 'Oups', 'wp-cinquante-et-un' ),
	'content' => __( 'Page does not exist', 'wp-cinquante-et-un' ),
);

Timber::render( $templates, $data );
