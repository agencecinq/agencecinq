<?php
/**
 * Maintenance
 *
 * Loaded by the cinq-wp-maintenance plugin, which sends the 503 first.
 *
 * @link https://github.com/agencecinq/cinq-wp-maintenance
 *
 * @package AgenceCinq
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

use Timber\{ Timber };

$templates = array( 'pages/maintenance.html.twig' );
$data      = Timber::context();

$data['host'] = (string) wp_parse_url( home_url(), PHP_URL_HOST );

/*
 * After Yoast SEO, which titles the requested page, at 15.
 */
add_filter(
	'pre_get_document_title',
	static fn (): string => sprintf(
		/* translators: %s: Site name. */
		__( 'Site under construction – %s', 'agencecinq' ),
		get_bloginfo( 'name' )
	),
	20
);

Timber::render( $templates, $data );
