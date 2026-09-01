<?php
/**
 * Case study archive template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AgenceCinq
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

use Timber\{ Timber };

$templates     = array( 'pages/archive-case-study.html.twig' );
$data          = Timber::context();
$data['title'] = post_type_archive_title( '', false );

Timber::render( $templates, $data );
