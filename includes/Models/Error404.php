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
	 *     title: string,
	 *     text: string,
	 *     link: array{title: string, url: string, target: string},
	 *     host: string,
	 *     removed: string,
	 *     added: string
	 * }
	 */
	public static function context( ?array $theme_404 = null ): array {
		global $wp;

		$theme_404 = $theme_404 ?? array();
		$link      = ! empty( $theme_404['link'] ) && is_array( $theme_404['link'] ) ? $theme_404['link'] : array();
		$url       = ! empty( $link['url'] ) ? (string) $link['url'] : '';

		return array(
			'title'   => ! empty( $theme_404['title'] ) ? $theme_404['title'] : __( 'This page does not exist, or no longer does.', 'agencecinq' ),
			'text'    => ! empty( $theme_404['text'] ) ? $theme_404['text'] : __( 'If you come from an old link, the page has most likely changed address. The sitemap lists them all.', 'agencecinq' ),
			'link'    => array(
				'title'  => ! empty( $link['title'] ) ? $link['title'] : __( 'See the sitemap', 'agencecinq' ),
				'url'    => $url,
				'target' => isset( $link['target'] ) ? $link['target'] : '',
			),
			'host'    => (string) wp_parse_url( home_url(), PHP_URL_HOST ),
			'removed' => esc_html( user_trailingslashit( '/' . $wp->request ) ),
			'added'   => $url ? esc_html( wp_make_link_relative( $url ) ) : '',
		);
	}
}
