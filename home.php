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

$page_id   = absint( get_option( 'page_for_posts' ) );
$archive   = (array) get_field( 'archive_posts', 'option' );
$templates = array( 'pages/archive-page.html.twig' );
$data      = Timber::context();

$data['post']->description = $archive['description'] ?? '';
$data['post']->blocks      = $archive['blocks'] ?? array();
$data['categories']        = Timber::get_terms(
	array(
		'taxonomy'   => 'category',
		'hide_empty' => true,
	)
);

Timber::render( $templates, $data );
