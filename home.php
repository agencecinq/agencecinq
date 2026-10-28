<?php
/**
 * Home template file
 *
 * The page for posts, set in Settings > Reading: shows its blocks, which list the posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AgenceCinq
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

use Timber\{ Timber };

$page_id      = absint( get_option( 'page_for_posts' ) );
$templates    = array( 'pages/blocks-page.html.twig' );
$data         = Timber::context();
$data['post'] = $page_id ? Timber::get_post( $page_id ) : null;

Timber::render( $templates, $data );
