<?php
/**
 * Front page
 *
 * The front-page.php is the file used by WordPress to display the site's front page. You can setup this page in
 * the WordPress admin under Settings > Reading. This template is used when a static front page is set.
 *
 * @package WPCinquanteEtUn
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

use Timber\{ Timber };

$templates = array( 'pages/blocks-page.html.twig' );
$data      = Timber::context();

Timber::render( $templates, $data );
