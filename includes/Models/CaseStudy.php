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

	/**
	 * Returns the client name, falling back to the post title.
	 *
	 * @return string
	 */
	public function client(): string {
		$content = $this->hero_content();
		$client  = isset( $content['client'] ) ? (string) $content['client'] : '';

		return '' !== $client ? $client : (string) $this->title();
	}

	/**
	 * Returns the platform (e.g. WordPress, Shopify).
	 *
	 * @return string
	 */
	public function platform(): string {
		$content = $this->hero_content();

		return isset( $content['platform'] ) ? (string) $content['platform'] : '';
	}

	/**
	 * Returns the delivery year.
	 *
	 * @return string
	 */
	public function year(): string {
		$content = $this->hero_content();

		return isset( $content['year'] ) ? (string) $content['year'] : '';
	}

	/**
	 * Returns the delivered-site screenshot attachment ID.
	 *
	 * @return int|null
	 */
	public function screenshot(): ?int {
		$hero = $this->hero();
		$id   = isset( $hero['image'] ) ? (int) $hero['image'] : 0;

		return $id > 0 ? $id : null;
	}

	/**
	 * Returns the hero field group.
	 *
	 * @return array<string, mixed>
	 */
	private function hero(): array {
		$hero = $this->meta( 'hero' );

		return is_array( $hero ) ? $hero : array();
	}

	/**
	 * Returns the hero content sub group.
	 *
	 * @return array<string, mixed>
	 */
	private function hero_content(): array {
		$hero    = $this->hero();
		$content = $hero['content'] ?? array();

		return is_array( $content ) ? $content : array();
	}
}
