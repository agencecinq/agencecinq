<?php
/**
 * Page Model
 *
 * Custom model for home archive page.
 *
 * @package WPCinquanteEtUn
 * @subpackage WPCinquanteEtUn/Models
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace WPCinquanteEtUn\Models;

use Timber\{ Post, Timber, PostCollectionInterface };

/**
 * Class Page
 *
 * Represents a page with helpers such as siblings.
 *
 * @package WPCinquanteEtUn\Models
 */
class Page extends Post {

	/**
	 * Returns sibling pages (same parent), excluding the current page.
	 *
	 * @return PostCollectionInterface|null Collection of sibling pages, or null if no parent.
	 */
	public function siblings(): ?PostCollectionInterface {
		$parent_id = (int) $this->post_parent;

		if ( 0 === $parent_id ) {
			return null;
		}

		return Timber::get_posts(
			array(
				'post_type'      => 'page',
				'post_parent'    => $parent_id,
				'posts_per_page' => -1,
				'orderby'        => array(
					'menu_order' => 'ASC',
					'title'      => 'ASC',
				),
			)
		);
	}
}
