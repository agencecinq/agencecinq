<?php
/**
 * ACF layout: Page Introduction
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn/Plugins/ACF/IncludeFields/Layouts
 */

namespace WPCinquanteEtUn\Plugins\ACF\IncludeFields\Layouts;

use WPCinquanteEtUn\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Page Introduction block layout (intro section with text + media).
 */
class PageIntroduction {

	/**
	 * Returns the layout array for the Page Introduction block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_page_introduction',
			'name'       => 'page_introduction',
			'label'      => __( 'Page Introduction', 'wp-cinquante-et-un' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_page_introduction' ),
				AcfFieldHelpers::radius( $key . '_page_introduction' ),
				...AcfFieldHelpers::media( $key . '_page_introduction' ),
				array(
					'key'        => 'field_' . $key . '_page_introduction_content_tab',
					'label'      => __( 'Content', 'wp-cinquante-et-un' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_page_introduction_content',
					'name'       => 'content',
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'           => 'field_' . $key . '_page_introduction_content_breadcrumb',
							'label'         => __( 'Breadcrumb', 'wp-cinquante-et-un' ),
							'name'          => 'breadcrumb',
							'aria-label'    => __( 'Breadcrumb', 'wp-cinquante-et-un' ),
							'type'          => 'true_false',
							'default_value' => false,
							'instructions'  => __( 'Show the breadcrumb of the page.', 'wp-cinquante-et-un' ),
						),
						array(
							'key'         => 'field_' . $key . '_page_introduction_content_title',
							'label'       => __( 'Title', 'wp-cinquante-et-un' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'wp-cinquante-et-un' ),
							'type'        => 'text',
							'placeholder' => __( 'Enter the title of the block', 'wp-cinquante-et-un' ),
						),
						array(
							'key'         => 'field_' . $key . '_page_introduction_content_text',
							'label'       => __( 'Text', 'wp-cinquante-et-un' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'wp-cinquante-et-un' ),
							'type'        => 'textarea',
							'rows'        => 4,
							'new_lines'   => 'br',
							'placeholder' => __( 'Enter the text of the block', 'wp-cinquante-et-un' ),
						),
					),
				),
			),
		);
	}
}
