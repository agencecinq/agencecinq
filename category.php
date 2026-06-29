<?php
/**
 * Category template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

use Timber\{ Timber };

$templates    = array( 'pages/archive-post.html.twig' );
$data         = Timber::context();
$data['post'] = $data['term'];

Timber::render( $templates, $data );
