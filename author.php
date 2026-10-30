<?php
/**
 * Author template file
 *
 * Shows the blocks of the page for posts, which list the posts of the author.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AgenceCinq
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

use Timber\{ Timber };

$page_id        = absint( get_option( 'page_for_posts' ) );
$templates      = array( 'pages/blocks-page.html.twig' );
$data           = Timber::context();
$data['post']   = $page_id ? Timber::get_post( $page_id ) : null;
$data['author'] = Timber::get_user( get_queried_object_id() );

Timber::render( $templates, $data );
