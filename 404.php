<?php
/**
 * 404
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage AgenceCinq
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

use Timber\{ Timber };

$templates = array( 'pages/404.html.twig' );
$data      = Timber::context();
$theme_404 = $data['theme']['404'] ?? array();
$link      = $theme_404['link'] ?: array();

$data['post'] = array(
	'overline' => $theme_404['overline'] ?: __( 'Erreur 404', 'agencecinq' ),
	'title'    => isset( $theme_404['title'] ) ? $theme_404['title'] : __( 'This page does not exist.', 'agencecinq' ),
	'text'     => isset( $theme_404['text'] ) ? $theme_404['text'] : __( 'It may have been moved, or the link that brought you here was already broken. Here is where to pick up.', 'agencecinq' ),
	'link'     => array(
		'title'  => isset( $link['title'] ) && ! empty( $link['title'] ) ? $link['title'] : __( 'Retour à l\'accueil', 'agencecinq' ),
		'url'    => isset( $link['url'] ) && ! empty( $link['url'] ) ? $link['url'] : home_url( '/' ),
		'target' => isset( $link['target'] ) ? $link['target'] : '',
	),
	'items'    => isset( $theme_404['items'] ) ? $theme_404['items'] : array(),
);

Timber::render( $templates, $data );
