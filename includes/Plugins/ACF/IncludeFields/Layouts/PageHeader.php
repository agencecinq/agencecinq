<?php
/**
 * ACF layout: Page header
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Page header block layout.
 */
class PageHeader {

	/**
	 * Returns the layout array for the Page header block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_page_header',
			'name'       => 'page_header',
			'label'      => __( 'Page header', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_page_header_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_page_header_content',
					'label'        => __( 'Content', 'agencecinq' ),
					'name'         => 'content',
					'aria-label'   => __( 'Content', 'agencecinq' ),
					'type'         => 'group',
					'layout'       => 'block',
					'instructions' => __( 'Top of a situation, an offer or a case study, its title in H1. Recommended paddings: 136px top, 80px bottom.', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'         => 'field_' . $key . '_page_header_content_eyebrow',
							'label'       => __( 'Eyebrow', 'agencecinq' ),
							'name'        => 'eyebrow',
							'aria-label'  => __( 'Eyebrow', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'Your situation', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_page_header_content_title',
							'label'       => __( 'Title', 'agencecinq' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'agencecinq' ),
							'type'        => 'text',
							'required'    => 1,
							'placeholder' => __( 'Your showcase site has stayed old-fashioned.', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_page_header_content_text',
							'label'       => __( 'Text', 'agencecinq' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'agencecinq' ),
							'type'        => 'textarea',
							'rows'        => 3,
							'new_lines'   => '',
							'placeholder' => __( 'Enter the lead text of the block', 'agencecinq' ),
						),
						array(
							'key'          => 'field_' . $key . '_page_header_content_meta',
							'label'        => __( 'Meta', 'agencecinq' ),
							'name'         => 'meta',
							'aria-label'   => __( 'Meta', 'agencecinq' ),
							'type'         => 'text',
							'placeholder'  => __( 'Client: Eigrene · Platform: WordPress · Live: November 2026', 'agencecinq' ),
							'instructions' => __( 'Optional line under the text, on case studies.', 'agencecinq' ),
						),
						array(
							'key'        => 'field_' . $key . '_page_header_content_links',
							'label'      => __( 'Links', 'agencecinq' ),
							'name'       => 'links',
							'aria-label' => __( 'Links', 'agencecinq' ),
							'type'       => 'group',
							'layout'     => 'block',
							'sub_fields' => array(
								array(
									'key'           => 'field_' . $key . '_page_header_content_links_0',
									'label'         => __( 'Link', 'agencecinq' ),
									'name'          => '0',
									'aria-label'    => __( 'Link', 'agencecinq' ),
									'type'          => 'link',
									'return_format' => 'array',
									'default_value' => array(
										'title'  => __( 'Book 30 minutes', 'agencecinq' ),
										'url'    => '',
										'target' => '',
									),
									'instructions'  => __( 'Primary CTA. Default label: Book 30 minutes. The diagnostic is never a first click.', 'agencecinq' ),
									'wrapper'       => array(
										'width' => 6 * 100 / 12,
									),
								),
								array(
									'key'           => 'field_' . $key . '_page_header_content_links_1',
									'label'         => __( 'Secondary link', 'agencecinq' ),
									'name'          => '1',
									'aria-label'    => __( 'Secondary link', 'agencecinq' ),
									'type'          => 'link',
									'return_format' => 'array',
									'instructions'  => __( 'Optional outlined button next to the primary CTA.', 'agencecinq' ),
									'wrapper'       => array(
										'width' => 6 * 100 / 12,
									),
								),
							),
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_page_header_tab_captures',
					'label'      => __( 'Captures', 'agencecinq' ),
					'aria-label' => __( 'Captures', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_page_header_before',
					'label'        => __( 'Before', 'agencecinq' ),
					'name'         => 'before',
					'aria-label'   => __( 'Before', 'agencecinq' ),
					'type'         => 'group',
					'layout'       => 'block',
					'instructions' => __( 'Optional reduced before and after, on the right: the site before, in greys, above the site after, same framing. Each alternative, in the media library, describes its page.', 'agencecinq' ),
					'wrapper'      => array(
						'width' => 6 * 100 / 12,
					),
					'sub_fields'   => array(
						array(
							'key'           => 'field_' . $key . '_page_header_before_image',
							'label'         => __( 'Image', 'agencecinq' ),
							'name'          => 'image',
							'aria-label'    => __( 'Image', 'agencecinq' ),
							'type'          => 'image',
							'return_format' => 'id',
							'preview_size'  => 'medium',
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_page_header_after',
					'label'      => __( 'After', 'agencecinq' ),
					'name'       => 'after',
					'aria-label' => __( 'After', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'wrapper'    => array(
						'width' => 6 * 100 / 12,
					),
					'sub_fields' => array(
						array(
							'key'           => 'field_' . $key . '_page_header_after_image',
							'label'         => __( 'Image', 'agencecinq' ),
							'name'          => 'image',
							'aria-label'    => __( 'Image', 'agencecinq' ),
							'type'          => 'image',
							'return_format' => 'id',
							'preview_size'  => 'medium',
						),
					),
				),
				...AcfFieldHelpers::settings( $key . '_page_header' ),
			),
		);
	}
}
