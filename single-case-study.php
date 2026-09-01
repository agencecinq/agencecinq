<?php
/**
 * Single case study template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AgenceCinq
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

use Timber\{ Timber };

$templates = array( 'pages/single-case-study.html.twig' );
$data      = Timber::context();

Timber::render( $templates, $data );
