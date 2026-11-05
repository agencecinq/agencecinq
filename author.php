<?php
/**
 * Author template file
 *
 * The name, the portrait, the job and the biography of the author, their posts, then the blocks of
 * Posts > Archive.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AgenceCinq
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

use Timber\{ Timber };

$author_id      = get_queried_object_id();
$templates      = array( 'pages/archive-page.html.twig' );
$data           = Timber::context();
$data['title']  = get_the_author_meta( 'display_name', $author_id );
$data['text']   = get_the_author_meta( 'description', $author_id );
$data['blocks'] = get_field( 'blocks', 'archive_posts' );
$data['author'] = Timber::get_user( $author_id );

Timber::render( $templates, $data );
