<?php
/**
 * Home template file
 *
 * The page for posts, set in Settings > Reading: its title, the text and the blocks of Posts > Archive,
 * and all the posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AgenceCinq
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

use Timber\{ Timber };

$page_id                  = absint( get_option( 'page_for_posts' ) );
$templates                = array( 'pages/archive-page.html.twig' );
$data                     = Timber::context();
$data['title']            = $page_id ? get_the_title( $page_id ) : '';
$data['text']             = get_field( 'text', 'archive_posts' );
$data['blocks']           = get_field( 'blocks', 'archive_posts' );
$data['current_category'] = null;

Timber::render( $templates, $data );
