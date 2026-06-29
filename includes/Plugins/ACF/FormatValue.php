<?php
/**
 * ACF Format Value
 *
 * @package WPCinquanteEtUn
 * @subpackage WPCinquanteEtUn/Plugins/ACF
 */

namespace WPCinquanteEtUn\Plugins\ACF;

use WPCinquanteEtUn\Service;
use Timber\Timber;

/**
 * FormatValue
 */
class FormatValue implements Service {

	/**
	 * Runs the service: registers the ACF format_value filter.
	 *
	 * @return void
	 */
	public function run(): void {
		add_filter( 'acf/format_value/name=blocks', array( $this, 'format_value_blocks' ), 10, 3 );
	}

	/**
	 * Formats the blocks value
	 *
	 * @param array<int, array<string, mixed>> $value   The flexible content value (array of layouts).
	 * @param int|string                       $post_id The post ID (or 'option' for options).
	 * @param array<string, mixed>             $field   The ACF field array.
	 * @return array<int, array<string, mixed>>
	 */
	public function format_value_blocks( $value, $post_id, $field ) {
		if ( ! is_array( $value ) ) {
			return $value;
		}

		$is_page = 'page' === get_post_type( $post_id );

		foreach ( $value as &$layout ) {
			if ( empty( $layout['acf_fc_layout'] ) ) {
				continue;
			}

			// Unique id for every layout (all block types).
			$layout['id'] = 'block-' . str_replace( '_', '-', $layout['acf_fc_layout'] ) . '-' . uniqid();

			// Child pages by parent: enrich with parent, children, active, index (only on page context).
			if ( ! $is_page || 'child_pages_by_parent' !== $layout['acf_fc_layout'] ) {
				continue;
			}

			$parent_page_id = isset( $layout['content']['parent_page'] ) ? (int) $layout['content']['parent_page'] : 0;

			if ( ! $parent_page_id ) {
				continue;
			}

			$parent = Timber::get_post( $parent_page_id );

			if ( ! $parent ) {
				continue;
			}

			$children = Timber::get_posts(
				array(
					'post_type'      => 'page',
					'post_parent'    => $parent->ID,
					'posts_per_page' => -1,
					'orderby'        => array(
						'menu_order' => 'ASC',
						'title'      => 'ASC',
					),
				)
			);

			// By default the first child is current. If current page is a direct child or a descendant, set current to the direct child that is self or an ancestor.
			$current = ! empty( $children ) ? $children[0] : null;

			if ( $children ) {
				if ( in_array( $parent->ID, get_post_ancestors( $post_id ), true ) ) {
					$post = Timber::get_post( $post_id );

					if ( $post->parent->ID === $parent->ID ) {
						$current = $post;
					} else {
						$current = $post->parent;
					}
				}
			}

			$layout['parent']   = $parent;
			$layout['children'] = $children;
			$layout['current']  = $current;
		}

		return $value;
	}
}
