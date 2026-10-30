<?php
/**
 * Case study archive template file
 *
 * Shows the blocks of the case studies page, set in Settings > Reading.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AgenceCinq
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

use AgenceCinq\Post\CaseStudy;
use Timber\{ Timber };

$page_id      = CaseStudy::page_id();
$templates    = array( 'pages/blocks-page.html.twig' );
$data         = Timber::context();
$data['post'] = $page_id ? Timber::get_post( $page_id ) : null;

Timber::render( $templates, $data );
