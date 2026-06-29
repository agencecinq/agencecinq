<?php
/**
 * ACF layout: Presentation
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn/Plugins/ACF/IncludeFields/Layouts
 */

namespace WPCinquanteEtUn\Plugins\ACF\IncludeFields\Layouts;

use WPCinquanteEtUn\Plugins\ACF\IncludeFields\AcfFieldHelpers;

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
			'label'      => __( 'Presentation', 'wp-cinquante-et-un' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_presentation' ),
				AcfFieldHelpers::radius( $key . '_presentation' ),
				array(
					'key'        => 'field_' . $key . '_presentation_tab_content',
					'label'      => __( 'Content', 'wp-cinquante-et-un' ),
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_presentation_content',
					'label'      => __( 'Content', 'wp-cinquante-et-un' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'           => 'field_' . $key . '_presentation_content_breadcrumb',
							'label'         => __( 'Breadcrumb', 'wp-cinquante-et-un' ),
							'name'          => 'breadcrumb',
							'aria-label'    => __( 'Breadcrumb', 'wp-cinquante-et-un' ),
							'type'          => 'true_false',
							'default_value' => false,
							'instructions'  => __( 'Show the breadcrumb of the page.', 'wp-cinquante-et-un' ),
						),
						array(
							'key'          => 'field_' . $key . '_presentation_content_title',
							'label'        => __( 'Title', 'wp-cinquante-et-un' ),
							'name'         => 'title',
							'aria-label'   => __( 'Title', 'wp-cinquante-et-un' ),
							'type'         => 'text',
							'placeholder'  => __( 'Enter the title of the content', 'wp-cinquante-et-un' ),
							'instructions' => __( 'Will use the page title if not set.', 'wp-cinquante-et-un' ),
						),
						array(
							'key'        => 'field_' . $key . '_presentation_content_heading',
							'label'      => __( 'Heading', 'wp-cinquante-et-un' ),
							'name'       => 'heading',
							'aria-label' => __( 'Heading', 'wp-cinquante-et-un' ),
							'type'       => 'clone',
							'clone'      => array( 'field_clones_heading' ),
							'layout'     => 'block',
							'display'    => 'seamless',
						),
						array(
							'key'         => 'field_' . $key . '_presentation_content_subtitle',
							'label'       => __( 'Subtitle', 'wp-cinquante-et-un' ),
							'name'        => 'subtitle',
							'aria-label'  => __( 'Subtitle', 'wp-cinquante-et-un' ),
							'type'        => 'text',
							'placeholder' => __( 'Enter the subtitle of the content', 'wp-cinquante-et-un' ),
						),
						array(
							'key'         => 'field_' . $key . '_presentation_content_text',
							'label'       => __( 'Text', 'wp-cinquante-et-un' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'wp-cinquante-et-un' ),
							'type'        => 'textarea',
							'rows'        => 4,
							'new_lines'   => 'br',
							'placeholder' => __( 'Enter the text of the content', 'wp-cinquante-et-un' ),
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_presentation_tab_links',
					'label'      => __( 'Links', 'wp-cinquante-et-un' ),
					'aria-label' => __( 'Links', 'wp-cinquante-et-un' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_presentation_links',
					'label'        => __( 'Links', 'wp-cinquante-et-un' ),
					'name'         => 'links',
					'aria-label'   => __( 'Links', 'wp-cinquante-et-un' ),
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'Add Link', 'wp-cinquante-et-un' ),
					'sub_fields'   => array(
						array(
							'key'        => 'field_' . $key . '_presentation_links_link',
							'label'      => __( 'Link', 'wp-cinquante-et-un' ),
							'name'       => 'link',
							'aria-label' => __( 'Link', 'wp-cinquante-et-un' ),
							'type'       => 'link',
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_presentation_tab_items',
					'label'      => __( 'Items', 'wp-cinquante-et-un' ),
					'aria-label' => __( 'Items', 'wp-cinquante-et-un' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_presentation_items',
					'label'        => __( 'Items', 'wp-cinquante-et-un' ),
					'name'         => 'items',
					'aria-label'   => __( 'Items', 'wp-cinquante-et-un' ),
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'Add Item', 'wp-cinquante-et-un' ),
					'sub_fields'   => array(
						array(
							'key'             => 'field_' . $key . '_presentation_items_title',
							'label'           => __( 'Title', 'wp-cinquante-et-un' ),
							'name'            => 'title',
							'aria-label'      => __( 'Title', 'wp-cinquante-et-un' ),
							'type'            => 'text',
							'placeholder'     => __( 'Enter the title of the item', 'wp-cinquante-et-un' ),
							'parent_repeater' => 'field_' . $key . '_presentation_items',
						),
						array(
							'key'             => 'field_' . $key . '_presentation_items_text',
							'label'           => __( 'Text', 'wp-cinquante-et-un' ),
							'name'            => 'text',
							'aria-label'      => __( 'Text', 'wp-cinquante-et-un' ),
							'type'            => 'textarea',
							'rows'            => 4,
							'new_lines'       => 'br',
							'placeholder'     => __( 'Enter the text of the item', 'wp-cinquante-et-un' ),
							'parent_repeater' => 'field_' . $key . '_presentation_items',
						),
					),
				),
			),
		);
	}
}
