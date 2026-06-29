<?php
/**
 * ACF layout: ChildPagesByParent
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn/Plugins/ACF/IncludeFields/Layouts
 */

namespace WPCinquanteEtUn\Plugins\ACF\IncludeFields\Layouts;

use WPCinquanteEtUn\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * ChildPagesByParent block layout.
 */
class ChildPagesByParent {

	/**
	 * Returns the layout array for the ChildPagesByParent block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(

			'key'        => 'layout_' . $key . '_child_pages_by_parent',
			'name'       => 'child_pages_by_parent',
			'label'      => __( 'Child Pages by Parent', 'wp-cinquante-et-un' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_child_pages_by_parent_message',
					'label'      => __( 'Message', 'wp-cinquante-et-un' ),
					'name'       => 'message',
					'aria-label' => __( 'Message', 'wp-cinquante-et-un' ),
					'type'       => 'message',
					'message'    => __( 'Displays the child pages of the selected parent page. Hidden when the parent has no child pages.', 'wp-cinquante-et-un' ),
				),
				...AcfFieldHelpers::settings( $key . '_child_pages_by_parent' ),
				array(
					'key'        => 'field_' . $key . '_child_pages_by_parent_content_tab',
					'label'      => __( 'Content', 'wp-cinquante-et-un' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_child_pages_by_parent_content',
					'name'       => 'content',
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'           => 'field_' . $key . '_child_pages_by_parent_content_parent_page',
							'label'         => __( 'Parent Page', 'wp-cinquante-et-un' ),
							'name'          => 'parent_page',
							'aria-label'    => __( 'Parent Page', 'wp-cinquante-et-un' ),
							'type'          => 'post_object',
							'post_type'     => 'page',
							'placeholder'   => __( 'Select the parent page', 'wp-cinquante-et-un' ),
							'return_format' => 'id',
						),
						array(
							'key'           => 'field_' . $key . '_child_pages_by_parent_content_text',
							'label'         => __( 'Text', 'wp-cinquante-et-un' ),
							'name'          => 'text',
							'aria-label'    => __( 'Text', 'wp-cinquante-et-un' ),
							'instructions'  => __( 'Optional text shown below the parent page chips.', 'wp-cinquante-et-un' ),
							'type'          => 'textarea',
							'rows'          => 4,
							'new_lines'     => 'br',
							'placeholder'   => __( 'Enter the text of the block', 'wp-cinquante-et-un' ),
							'default_value' => '',
						),
					),
				),
			),
		);
	}
}
