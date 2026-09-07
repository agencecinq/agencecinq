<?php
/**
 * Page template file
 *
 * @package AgenceCinq
 * @subpackage AgenceCinq/Page
 */

use Timber\{ Timber };

$data      = Timber::context();
$templates = array( 'index.html.twig' );

Timber::render( $templates, $data );
