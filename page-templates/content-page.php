<?php
/**
 * Template Name: Content
 *
 * @package AgenceCinq
 */

use Timber\Timber;

$templates = array( 'pages/content-page.html.twig' );
$data      = Timber::context();

Timber::render( $templates, $data );
