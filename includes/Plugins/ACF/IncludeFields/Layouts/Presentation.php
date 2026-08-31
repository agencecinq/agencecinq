<?php
/**
 * ACF layout: Presentation
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Presentation block layout.
 */
class Presentation {

	/**
	 * Returns the layout array for the Presentation block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_presentation',
			'name'       => 'presentation',
			'label'      => __( 'Presentation', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_presentation' ),
				AcfFieldHelpers::radius( $key . '_presentation' ),
				array(
					'key'        => 'field_' . $key . '_presentation_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_presentation_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'           => 'field_' . $key . '_presentation_content_breadcrumb',
							'label'         => __( 'Breadcrumb', 'agencecinq' ),
							'name'          => 'breadcrumb',
							'aria-label'    => __( 'Breadcrumb', 'agencecinq' ),
							'type'          => 'true_false',
							'default_value' => false,
							'instructions'  => __( 'Show the breadcrumb of the page.', 'agencecinq' ),
						),
						array(
							'key'          => 'field_' . $key . '_presentation_content_title',
							'label'        => __( 'Title', 'agencecinq' ),
							'name'         => 'title',
							'aria-label'   => __( 'Title', 'agencecinq' ),
							'type'         => 'text',
							'placeholder'  => __( 'Enter the title of the content', 'agencecinq' ),
							'instructions' => __( 'Will use the page title if not set.', 'agencecinq' ),
						),
						array(
							'key'        => 'field_' . $key . '_presentation_content_heading',
							'label'      => __( 'Heading', 'agencecinq' ),
							'name'       => 'heading',
							'aria-label' => __( 'Heading', 'agencecinq' ),
							'type'       => 'clone',
							'clone'      => array( 'field_clones_heading' ),
							'layout'     => 'block',
							'display'    => 'seamless',
						),
						array(
							'key'         => 'field_' . $key . '_presentation_content_subtitle',
							'label'       => __( 'Subtitle', 'agencecinq' ),
							'name'        => 'subtitle',
							'aria-label'  => __( 'Subtitle', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'Enter the subtitle of the content', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_presentation_content_text',
							'label'       => __( 'Text', 'agencecinq' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'agencecinq' ),
							'type'        => 'textarea',
							'rows'        => 4,
							'new_lines'   => 'br',
							'placeholder' => __( 'Enter the text of the content', 'agencecinq' ),
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_presentation_tab_links',
					'label'      => __( 'Links', 'agencecinq' ),
					'aria-label' => __( 'Links', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_presentation_links',
					'label'        => __( 'Links', 'agencecinq' ),
					'name'         => 'links',
					'aria-label'   => __( 'Links', 'agencecinq' ),
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'Add Link', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'        => 'field_' . $key . '_presentation_links_link',
							'label'      => __( 'Link', 'agencecinq' ),
							'name'       => 'link',
							'aria-label' => __( 'Link', 'agencecinq' ),
							'type'       => 'link',
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_presentation_tab_items',
					'label'      => __( 'Items', 'agencecinq' ),
					'aria-label' => __( 'Items', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_presentation_items',
					'label'        => __( 'Items', 'agencecinq' ),
					'name'         => 'items',
					'aria-label'   => __( 'Items', 'agencecinq' ),
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'Add Item', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'             => 'field_' . $key . '_presentation_items_title',
							'label'           => __( 'Title', 'agencecinq' ),
							'name'            => 'title',
							'aria-label'      => __( 'Title', 'agencecinq' ),
							'type'            => 'text',
							'placeholder'     => __( 'Enter the title of the item', 'agencecinq' ),
							'parent_repeater' => 'field_' . $key . '_presentation_items',
						),
						array(
							'key'             => 'field_' . $key . '_presentation_items_text',
							'label'           => __( 'Text', 'agencecinq' ),
							'name'            => 'text',
							'aria-label'      => __( 'Text', 'agencecinq' ),
							'type'            => 'textarea',
							'rows'            => 4,
							'new_lines'       => 'br',
							'placeholder'     => __( 'Enter the text of the item', 'agencecinq' ),
							'parent_repeater' => 'field_' . $key . '_presentation_items',
						),
					),
				),
			),
		);
	}
}
