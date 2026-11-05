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

$author_id = get_queried_object_id();
$archive   = (array) get_field( 'archive_posts', 'option' );
$templates = array( 'pages/archive-page.html.twig' );
$data      = Timber::context(
	array(
		'post'   => array(
			'title'       => get_the_author_meta( 'display_name', $author_id ),
			'description' => get_the_author_meta( 'description', $author_id ),
			'blocks'      => $archive['blocks'] ?? array(),
		),
		'author' => Timber::get_user( $author_id ),
	)
);

Timber::render( $templates, $data );
