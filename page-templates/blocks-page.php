<?php
/**
 * Template Name: Blocks
 *
 * @package WPCinquanteEtUn
 */

use Timber\Timber;

$templates = array( 'pages/blocks-page.html.twig' );
$data      = Timber::context();

Timber::render( $templates, $data );
