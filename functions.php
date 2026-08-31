<?php
/**
 * Agence Cinq functions and definitions
 *
 * @package AgenceCinq
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

// Autoloader.
require_once get_template_directory() . '/vendor/autoload.php';

use Timber\{ Timber };

Timber::init();
// Set Timber template locations
Timber::$locations = array( 'views', 'public' );

// Run the setup.
AgenceCinq\Init::run_services();
