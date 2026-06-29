<?php
/**
 * Home Model
 *
 * Custom model for home archive page.
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn/Models
 */

namespace WPCinquanteEtUn\Models;

use Timber\{ Post, Timber };
use WPCinquanteEtUn\Traits\ArchivePost;

/**
 * Class Home
 *
 * Represents the custom model for the home archive page.
 * Extends Timber\Post and uses ArchivePostTrait for additional archive functionality.
 *
 * In order to use the post/classmap and because Timber is waiting for a Timber\Post, we extract logic for featured posts and recent posts in a trait.
 *
 * @package WPCinquanteEtUn\Models
 */
class Home extends Post {
	use ArchivePost;
}
