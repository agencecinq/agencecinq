<?php
/**
 * Case study category taxonomy template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AgenceCinq
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

use AgenceCinq\Taxonomy\CaseStudyCategory;
use Timber\{ Timber };

$templates          = array( 'pages/archive-case-study.html.twig' );
$data               = Timber::context();
$data['title']      = single_term_title( '', false );
$data['categories'] = CaseStudyCategory::terms();
$data['category']   = $data['term'];

Timber::render( $templates, $data );
