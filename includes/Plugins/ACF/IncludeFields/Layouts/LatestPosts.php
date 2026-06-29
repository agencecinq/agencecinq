<?php
/**
 * ACF layout: LatestPosts
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn/Plugins/ACF/IncludeFields/Layouts
 */

namespace WPCinquanteEtUn\Plugins\ACF\IncludeFields\Layouts;

use WPCinquanteEtUn\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * LatestPosts block layout.
 */
class LatestPosts {

	/**
	 * Returns the layout array for the LatestPosts block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_latest_posts',
			'name'       => 'latest_posts',
			'label'      => __( 'Latest Posts', 'wp-cinquante-et-un' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_latest_posts' ),
				array(
					'key'        => 'field_' . $key . '_latest_posts_tab_content',
					'label'      => __( 'Content', 'wp-cinquante-et-un' ),
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_latest_posts_content',
					'label'      => __( 'Content', 'wp-cinquante-et-un' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'          => 'field_' . $key . '_latest_posts_content_overline',
							'label'        => __( 'Overline', 'wp-cinquante-et-un' ),
							'name'         => 'overline',
							'aria-label'   => __( 'Overline', 'wp-cinquante-et-un' ),
							'type'         => 'text',
							'placeholder'  => __( 'Enter the overline of the block', 'wp-cinquante-et-un' ),
							'instructions' => __( 'Small label above the title.', 'wp-cinquante-et-un' ) . ' <em>(' . __( 'Optional', 'wp-cinquante-et-un' ) . ')</em>.',
						),
						array(
							'key'           => 'field_' . $key . '_latest_posts_content_title',
							'label'         => __( 'Title', 'wp-cinquante-et-un' ),
							'name'          => 'title',
							'aria-label'    => __( 'Title', 'wp-cinquante-et-un' ),
							'type'          => 'text',
							'placeholder'   => __( 'Enter the title of the block', 'wp-cinquante-et-un' ),
							'instructions'  => __( 'Section heading displayed above the posts list.', 'wp-cinquante-et-un' ),
							'default_value' => '',
						),
						array(
							'key'          => 'field_' . $key . '_latest_posts_content_category',
							'label'        => __( 'Category', 'wp-cinquante-et-un' ),
							'name'         => 'category',
							'aria-label'   => __( 'Category', 'wp-cinquante-et-un' ),
							'type'         => 'taxonomy',
							'taxonomy'     => 'category',
							'multiple'     => 1,
							'instructions' => __( 'Leave empty to show latest posts from all categories.', 'wp-cinquante-et-un' ),
						),
					),
				),
			),
		);
	}
}
