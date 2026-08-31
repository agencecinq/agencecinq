<?php
/**
 * ACF layout: LatestPosts
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

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
			'label'      => __( 'Latest Posts', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_latest_posts' ),
				array(
					'key'        => 'field_' . $key . '_latest_posts_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_latest_posts_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'          => 'field_' . $key . '_latest_posts_content_overline',
							'label'        => __( 'Overline', 'agencecinq' ),
							'name'         => 'overline',
							'aria-label'   => __( 'Overline', 'agencecinq' ),
							'type'         => 'text',
							'placeholder'  => __( 'Enter the overline of the block', 'agencecinq' ),
							'instructions' => __( 'Small label above the title.', 'agencecinq' ) . ' <em>(' . __( 'Optional', 'agencecinq' ) . ')</em>.',
						),
						array(
							'key'           => 'field_' . $key . '_latest_posts_content_title',
							'label'         => __( 'Title', 'agencecinq' ),
							'name'          => 'title',
							'aria-label'    => __( 'Title', 'agencecinq' ),
							'type'          => 'text',
							'placeholder'   => __( 'Enter the title of the block', 'agencecinq' ),
							'instructions'  => __( 'Section heading displayed above the posts list.', 'agencecinq' ),
							'default_value' => '',
						),
						array(
							'key'          => 'field_' . $key . '_latest_posts_content_category',
							'label'        => __( 'Category', 'agencecinq' ),
							'name'         => 'category',
							'aria-label'   => __( 'Category', 'agencecinq' ),
							'type'         => 'taxonomy',
							'taxonomy'     => 'category',
							'multiple'     => 1,
							'instructions' => __( 'Leave empty to show latest posts from all categories.', 'agencecinq' ),
						),
					),
				),
			),
		);
	}
}
