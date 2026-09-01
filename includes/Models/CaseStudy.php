<?php
/**
 * Case Study model
 *
 * @package WordPress
 * @subpackage AgenceCinq/Models
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Models;

use AgenceCinq\Taxonomy\CaseStudyCategory;
use Timber\Post;

/**
 * CaseStudy
 *
 * Custom Timber model for the case-study post type.
 */
class CaseStudy extends Post {

	/**
	 * Returns the case study categories assigned to this post.
	 *
	 * @return mixed Term collection.
	 */
	public function categories() {
		return $this->terms(
			array(
				'taxonomy' => CaseStudyCategory::TAXONOMY,
			)
		);
	}
}
