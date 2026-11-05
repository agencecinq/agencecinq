<?php
/**
 * Archive Posts Fields
 *
 * Registers ACF field group for the posts archive options page (Posts > Archive).
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields;

use AgenceCinq\Service;

/**
 * Archive Posts Fields
 *
 * One group, archive_posts: the description of the blog and of its categories, under their title, and the
 * blocks after the posts.
 */
class ArchivePostsFields implements Service {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run(): void {
		add_action( 'acf/include_fields', array( $this, 'fields' ) );
	}

	/**
	 * Registers the field group.
	 *
	 * @return void
	 */
	public function fields(): void {
		$key = 'archive_posts';

		$location = array(
			array(
				array(
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => 'archive-posts',
				),
			),
		);

		$fields = array(
			array(
				'key'        => 'field_' . $key,
				'label'      => __( 'Posts archive', 'agencecinq' ),
				'name'       => 'archive_posts',
				'aria-label' => __( 'Posts archive', 'agencecinq' ),
				'type'       => 'group',
				'layout'     => 'block',
				'sub_fields' => array(
					array(
						'key'          => 'field_' . $key . '_description',
						'label'        => __( 'Description', 'agencecinq' ),
						'name'         => 'description',
						'aria-label'   => __( 'Description', 'agencecinq' ),
						'type'         => 'textarea',
						'rows'         => 3,
						'new_lines'    => '',
						'instructions' => __( 'Under the title of the blog, and of the categories without a description. An author has their biography instead.', 'agencecinq' ),
					),
					array(
						'key'          => 'field_' . $key . '_blocks',
						'label'        => __( 'Blocks', 'agencecinq' ),
						'name'         => 'blocks',
						'aria-label'   => __( 'Blocks', 'agencecinq' ),
						'type'         => 'flexible_content',
						'instructions' => __( 'After the posts of the blog, of its categories and of its authors. The Signup form also closes every post.', 'agencecinq' ),
						'layouts'      => AcfFieldHelpers::get_layouts_from( $key, BlocksFields::get_layout_classes() ),
						'button_label' => __( 'Add Block', 'agencecinq' ),
					),
				),
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group(
				array(
					'key'      => 'group_' . $key,
					'title'    => __( 'Posts archive', 'agencecinq' ),
					'fields'   => $fields,
					'location' => $location,
				)
			);
		}
	}
}
