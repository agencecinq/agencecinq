<?php
/**
 * ArchivePost Trait
 *
 * Provides methods to retrieve featured and recent posts for archive pages.
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn/Traits
 */

namespace WPCinquanteEtUn\Traits;

use Timber\{Timber, PostQuery};

/**
 * Trait ArchivePost
 *
 * This trait provides methods to retrieve featured and recent posts for archive pages.
 *
 * @package WPCinquanteEtUn\Traits
 */
trait ArchivePost {
	/**
	 * Retrieves the list of categories for the home model.
	 *
	 * @return array List of categories.
	 */
	public function categories() {
		return Timber::get_terms(
			array(
				'taxonomy'   => 'category',
				'hide_empty' => true,
			)
		);
	}


	/**
	 * Retrieves the category associated with the current archive.
	 *
	 * @return Category The category object for the current archive.
	 */
	public function category() {
		return get_queried_object();
	}


	/**
	 * Retrieves the hero for the home and category archive models.
	 *
	 * @return array Hero.
	 */
	public function hero() {
		return get_field( 'archive_posts', 'option' )['hero'] ?? null;
	}
}
