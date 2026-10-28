<?php
/**
 * Case Study model
 *
 * @package WordPress
 * @subpackage AgenceCinq/Models
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Models;

use Timber\Post;

/**
 * CaseStudy
 *
 * Custom Timber model for the case-study post type.
 */
class CaseStudy extends Post {

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
	 * Returns the situation the client started from, the badge of its Image card.
	 *
	 * @return string
	 */
	public function situation(): string {
		return (string) ( $this->card()['situation'] ?? '' );
	}

	/**
	 * Returns the sentence of its Image card on what the site does now.
	 *
	 * @return string
	 */
	public function summary(): string {
		return (string) ( $this->card()['summary'] ?? '' );
	}

	/**
	 * Returns the screenshot of the delivered site, the after of the hero.
	 *
	 * @return int Attachment ID, 0 without one.
	 */
	public function screenshot(): int {
		return (int) ( $this->hero()['image'] ?? 0 );
	}

	/**
	 * Returns the screenshot of the site before, the before of the hero.
	 *
	 * @return int Attachment ID, 0 without one.
	 */
	public function before(): int {
		return (int) ( $this->hero()['before'] ?? 0 );
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
	 * Returns the card field group.
	 *
	 * @return array<string, mixed>
	 */
	private function card(): array {
		$card = $this->meta( 'card' );

		return is_array( $card ) ? $card : array();
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
