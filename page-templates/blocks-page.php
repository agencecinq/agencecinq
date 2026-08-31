<?php
/**
 * Template Name: Blocks
 *
 * @package AgenceCinq
 */

use Timber\Timber;

$templates = array( 'pages/blocks-page.html.twig' );
$data      = Timber::context();

Timber::render( $templates, $data );
