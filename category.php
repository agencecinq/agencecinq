<?php
/**
 * Category template file
 *
 * The name of the category, the text and the blocks of Posts > Archive, and the posts of the category.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage AgenceCinq
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

use Timber\{ Timber };

$category                 = Timber::get_term( get_queried_object_id() );
$templates                = array( 'pages/archive-page.html.twig' );
$data                     = Timber::context();
$data['title']            = single_cat_title( '', false );
$data['text']             = get_field( 'text', 'archive_posts' );
$data['blocks']           = get_field( 'blocks', 'archive_posts' );
$data['current_category'] = $category;

Timber::render( $templates, $data );
