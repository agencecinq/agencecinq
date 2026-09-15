<?php
/**
 * 404
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AgenceCinq
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

use AgenceCinq\Models\Error404;
use Timber\{ Timber };

$templates = array( 'pages/404.html.twig' );
$data      = Timber::context();

$data['post'] = Error404::context( $data['theme']['404'] ?? null );

Timber::render( $templates, $data );
