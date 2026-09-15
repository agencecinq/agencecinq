<?php
/**
 * Error 404 Model
 *
 * Builds the context payload for the branded 404 page from theme options.
 *
 * @package AgenceCinq
 * @subpackage AgenceCinq/Models
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Models;

/**
 * Class Error404
 *
 * @package AgenceCinq\Models
 */
class Error404 {

	/**
	 * Build the 404 page context from theme options, with fallbacks.
	 *
	 * @param array|null $theme_404 Theme 404 group from ACF options.
	 *
	 * @return array{
	 *     overline: string,
	 *     title: string,
	 *     text: string,
	 *     link: array{title: string, url: string, target: string},
	 *     items: array
	 * }
	 */
	public static function context( ?array $theme_404 = null ): array {
		$theme_404 = $theme_404 ?? array();
		$link      = ! empty( $theme_404['link'] ) && is_array( $theme_404['link'] ) ? $theme_404['link'] : array();

		return array(
			'overline' => ! empty( $theme_404['overline'] ) ? $theme_404['overline'] : __( 'Erreur 404', 'agencecinq' ),
			'title'    => isset( $theme_404['title'] ) ? $theme_404['title'] : __( 'This page does not exist.', 'agencecinq' ),
			'text'     => isset( $theme_404['text'] ) ? $theme_404['text'] : __( 'It may have been moved, or the link that brought you here was already broken. Here is where to pick up.', 'agencecinq' ),
			'link'     => array(
				'title'  => ! empty( $link['title'] ) ? $link['title'] : __( 'Retour à l\'accueil', 'agencecinq' ),
				'url'    => ! empty( $link['url'] ) ? $link['url'] : home_url( '/' ),
				'target' => isset( $link['target'] ) ? $link['target'] : '',
			),
			'items'    => isset( $theme_404['items'] ) && is_array( $theme_404['items'] ) ? $theme_404['items'] : array(),
		);
	}
}
