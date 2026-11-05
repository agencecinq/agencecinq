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

$archive  = (array) get_field( 'archive_posts', 'option' );
$category = Timber::get_term();

$templates = array( 'pages/archive-page.html.twig' );
$data      = Timber::context(
	array(
		'post'       => array(
			'title'       => $category->name,
			'description' => $category->description ? $category->description : ( $archive['description'] ?? '' ),
			'blocks'      => $archive['blocks'] ?? array(),
		),
		'category'   => $category,
		'categories' => Timber::get_terms(
			array(
				'taxonomy'   => 'category',
				'hide_empty' => true,
			)
		),
	)
);

Timber::render( $templates, $data );
