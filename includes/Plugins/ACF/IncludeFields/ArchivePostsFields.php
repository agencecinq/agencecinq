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
 * The text of the blog and of its categories, under their title. Their blocks, after the posts, are
 * the Blocks field of the same options page.
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
				'key'          => 'field_' . $key . '_text',
				'label'        => __( 'Text', 'agencecinq' ),
				'name'         => 'text',
				'aria-label'   => __( 'Text', 'agencecinq' ),
				'type'         => 'textarea',
				'rows'         => 3,
				'new_lines'    => '',
				'instructions' => __( 'Under the title of the blog and of its categories. An author has their biography instead.', 'agencecinq' ),
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group(
				array(
					'key'        => 'group_' . $key,
					'title'      => __( 'Posts archive', 'agencecinq' ),
					'fields'     => $fields,
					'location'   => $location,
					'menu_order' => 0,
				)
			);
		}
	}
}
