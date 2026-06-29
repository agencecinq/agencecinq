<?php
/**
 * Home template file for the WPCinquanteEtUn WordPress theme.
 *
 * This template is used to display the homepage. home.php in WordPress is the page that
 * is set to display the latest posts.
 *
 * To setup your homepage, go into the WordPress admin panel, navigate to Settings > Reading,
 * and select "Your latest posts" for the homepage display option.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WPCinquanteEtUn
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

use Timber\{ Timber };

$templates = array( 'pages/archive-post.html.twig' );
$data      = Timber::context();

Timber::render( $templates, $data );
