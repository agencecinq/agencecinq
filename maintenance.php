<?php
/**
 * Maintenance
 *
 * Loaded by the cinq-wp-maintenance plugin, which sends the 503.
 *
 * @link https://github.com/agencecinq/cinq-wp-maintenance
 *
 * @package AgenceCinq
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

use Timber\{ Timber };

$templates = array( 'pages/maintenance.html.twig' );
$data      = Timber::context();

$data['title'] = __( 'The site is under construction.', 'agencecinq' );

// After Yoast (15), whose title would name the requested page.
add_filter(
	'pre_get_document_title',
	fn () => $data['title'] . ' – ' . get_bloginfo( 'name' ),
	20
);

Timber::render( $templates, $data );
