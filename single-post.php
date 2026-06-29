<?php
/**
 * Single post template file
 *
 * This template is used to display a single post.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WPCinquanteEtUn
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

use Timber\{ Timber };

$templates = array( 'pages/single-post.html.twig' );
$data      = Timber::context();

Timber::render( $templates, $data );
