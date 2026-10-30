<?php
/**
 * Case Study Fields
 *
 * Registers ACF field group for the case study hero.
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields;

use AgenceCinq\Service;

/**
 * Case Study Fields
 *
 * Loads advanced custom fields for the case study hero.
 */
class CaseStudyFields implements Service {

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
		$key = 'case_study';

		$location = array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'case-study',
				),
			),
		);

		$fields = array(
			array(
				'key'          => 'field_' . $key . '_hero',
				'label'        => __( 'Hero', 'agencecinq' ),
				'name'         => 'hero',
				'aria-label'   => __( 'Hero', 'agencecinq' ),
				'type'         => 'group',
				'instructions' => __( 'Case study opening, as a Page header: « Client case », the title, the lead, the client line, the buttons, then the site before and after.', 'agencecinq' ),
				'layout'       => 'block',
				'sub_fields'   => array(
					array(
						'key'        => 'field_' . $key . '_hero_content_tab',
						'label'      => __( 'Content', 'agencecinq' ),
						'aria-label' => __( 'Content', 'agencecinq' ),
						'type'       => 'tab',
					),
					array(
						'key'        => 'field_' . $key . '_hero_content',
						'label'      => __( 'Content', 'agencecinq' ),
						'name'       => 'content',
						'aria-label' => __( 'Content', 'agencecinq' ),
						'type'       => 'group',
						'layout'     => 'block',
						'sub_fields' => array(
							array(
								'key'         => 'field_' . $key . '_hero_content_client',
								'label'       => __( 'Client', 'agencecinq' ),
								'name'        => 'client',
								'aria-label'  => __( 'Client', 'agencecinq' ),
								'type'        => 'text',
								'placeholder' => __( 'Client name', 'agencecinq' ),
								'wrapper'     => array(
									'width' => 4 * 100 / 12,
								),
							),
							array(
								'key'         => 'field_' . $key . '_hero_content_platform',
								'label'       => __( 'Platform', 'agencecinq' ),
								'name'        => 'platform',
								'aria-label'  => __( 'Platform', 'agencecinq' ),
								'type'        => 'text',
								'placeholder' => __( 'WordPress', 'agencecinq' ),
								'wrapper'     => array(
									'width' => 4 * 100 / 12,
								),
							),
							array(
								'key'         => 'field_' . $key . '_hero_content_year',
								'label'       => __( 'Year', 'agencecinq' ),
								'name'        => 'year',
								'aria-label'  => __( 'Year', 'agencecinq' ),
								'type'        => 'text',
								'placeholder' => __( '2026', 'agencecinq' ),
								'wrapper'     => array(
									'width' => 4 * 100 / 12,
								),
							),
							array(
								'key'          => 'field_' . $key . '_hero_content_title',
								'label'        => __( 'Title', 'agencecinq' ),
								'name'         => 'title',
								'aria-label'   => __( 'Title', 'agencecinq' ),
								'type'         => 'textarea',
								'rows'         => 2,
								'new_lines'    => 'br',
								'placeholder'  => __( 'A public site and a distributors intranet, built at once.', 'agencecinq' ),
								'instructions' => __( 'Main heading of the case study (H1). Falls back to the post title.', 'agencecinq' ),
							),
							array(
								'key'         => 'field_' . $key . '_hero_content_text',
								'label'       => __( 'Text', 'agencecinq' ),
								'name'        => 'text',
								'aria-label'  => __( 'Text', 'agencecinq' ),
								'type'        => 'textarea',
								'rows'        => 3,
								'new_lines'   => 'br',
								'placeholder' => __( 'Enter the lead of the case study', 'agencecinq' ),
							),
							array(
								'key'        => 'field_' . $key . '_hero_content_links',
								'label'      => __( 'Links', 'agencecinq' ),
								'name'       => 'links',
								'aria-label' => __( 'Links', 'agencecinq' ),
								'type'       => 'group',
								'layout'     => 'block',
								'sub_fields' => array(
									array(
										'key'           => 'field_' . $key . '_hero_content_links_0',
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
										'key'           => 'field_' . $key . '_hero_content_links_1',
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
						'key'        => 'field_' . $key . '_hero_media_tab',
						'label'      => __( 'Media', 'agencecinq' ),
						'aria-label' => __( 'Media', 'agencecinq' ),
						'type'       => 'tab',
					),
					array(
						'key'           => 'field_' . $key . '_hero_before',
						'label'         => __( 'Before', 'agencecinq' ),
						'name'          => 'before',
						'aria-label'    => __( 'Before', 'agencecinq' ),
						'type'          => 'image',
						'instructions'  => __( 'The site before, same framing as the after, shown in greys above it. Its alternative text, in the media library, describes the page before.', 'agencecinq' ),
						'return_format' => 'id',
						'preview_size'  => 'medium',
						'library'       => 'all',
						'wrapper'       => array(
							'width' => 6 * 100 / 12,
						),
					),
					array(
						'key'           => 'field_' . $key . '_hero_image',
						'label'         => __( 'After', 'agencecinq' ),
						'name'          => 'image',
						'aria-label'    => __( 'After', 'agencecinq' ),
						'type'          => 'image',
						'instructions'  => __( 'The delivered site, 16:10 (1600×1000 recommended), without browser chrome nor cookie banner: the after of the Page header and the image of the Image card. Its alternative text, in the media library, names the client and says what the image shows.', 'agencecinq' ),
						'return_format' => 'id',
						'preview_size'  => 'medium',
						'library'       => 'all',
						'wrapper'       => array(
							'width' => 6 * 100 / 12,
						),
					),
				),
			),
			array(
				'key'          => 'field_' . $key . '_card',
				'label'        => __( 'Card', 'agencecinq' ),
				'name'         => 'card',
				'aria-label'   => __( 'Card', 'agencecinq' ),
				'type'         => 'group',
				'layout'       => 'block',
				'instructions' => __( 'The case in an Image card, after the screenshot of the hero and the client.', 'agencecinq' ),
				'sub_fields'   => array(
					array(
						'key'          => 'field_' . $key . '_card_situation',
						'label'        => __( 'Situation', 'agencecinq' ),
						'name'         => 'situation',
						'aria-label'   => __( 'Situation', 'agencecinq' ),
						'type'         => 'text',
						'placeholder'  => __( 'e.g. B2B service · site left on Elementor', 'agencecinq' ),
						'instructions' => __( 'The situation the client started from, in the badge: not the technology nor the year.', 'agencecinq' ),
					),
					array(
						'key'          => 'field_' . $key . '_card_summary',
						'label'        => __( 'Summary', 'agencecinq' ),
						'name'         => 'summary',
						'aria-label'   => __( 'Summary', 'agencecinq' ),
						'type'         => 'textarea',
						'rows'         => 2,
						'new_lines'    => '',
						'placeholder'  => __( 'e.g. A site organised by sector and company size, with a savings calculator.', 'agencecinq' ),
						'instructions' => __( 'One sentence on what the site does now.', 'agencecinq' ),
					),
				),
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group(
				array(
					'key'        => 'group_' . $key,
					'title'      => __( 'Case Study', 'agencecinq' ),
					'fields'     => $fields,
					'location'   => $location,
					'menu_order' => 0,
				)
			);
		}
	}
}
