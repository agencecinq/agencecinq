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
	 * Returns the hero media payload for the browser frame (image or video).
	 *
	 * @return array{type: string, image?: int, video?: array<string, mixed>, poster?: array<string, mixed>}|null
	 */
	public function media(): ?array {
		$hero = $this->hero();
		$type = isset( $hero['media_type'] ) ? (string) $hero['media_type'] : 'image';

		if ( ! in_array( $type, array( 'image', 'video' ), true ) ) {
			$type = 'image';
		}

		if ( 'video' === $type ) {
			$video = $this->normalize_media_array( $hero['video'] ?? null );

			if ( null === $video ) {
				return null;
			}

			$media = array(
				'type'  => 'video',
				'video' => $video,
			);

			$poster = $this->normalize_media_array( $hero['poster'] ?? null );

			if ( null !== $poster ) {
				$media['poster'] = $poster;
			}

			return $media;
		}

		$id = isset( $hero['image'] ) ? (int) $hero['image'] : 0;

		if ( $id <= 0 ) {
			return null;
		}

		return array(
			'type'  => 'image',
			'image' => $id,
		);
	}

	/**
	 * Normalizes an ACF file/image value to an array with a url key.
	 *
	 * @param mixed $value ACF array, attachment ID, or URL string.
	 * @return array<string, mixed>|null
	 */
	private function normalize_media_array( $value ): ?array {
		if ( is_array( $value ) && ! empty( $value['url'] ) ) {
			return $value;
		}

		if ( is_numeric( $value ) ) {
			$url = wp_get_attachment_url( (int) $value );

			return $url ? array(
				'ID'  => (int) $value,
				'url' => $url,
			) : null;
		}

		if ( is_string( $value ) && '' !== $value ) {
			return array(
				'url' => $value,
			);
		}

		return null;
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
