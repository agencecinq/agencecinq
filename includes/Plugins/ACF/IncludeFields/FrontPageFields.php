<?php
/**
 * Front Page Fields
 *
 * Registers ACF field group for the homepage hero (page_type front_page).
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields;

use AgenceCinq\Service;

/**
 * Front Page Fields
 *
 * Loads advanced custom fields for the static front page hero.
 */
class FrontPageFields implements Service {

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
		$key = 'front_page';

		$location = array(
			array(
				array(
					'param'    => 'page_type',
					'operator' => '==',
					'value'    => 'front_page',
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
				'instructions' => __( 'Homepage hero. The title is always an H1 and stays a single colour. Do not highlight a word in the title.', 'agencecinq' ),
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
								'key'          => 'field_' . $key . '_hero_content_overline',
								'label'        => __( 'Overline', 'agencecinq' ),
								'name'         => 'overline',
								'aria-label'   => __( 'Overline', 'agencecinq' ),
								'type'         => 'text',
								'placeholder'  => __( 'Agency Shopify and WordPress', 'agencecinq' ),
								'instructions' => __( 'Small label above the title.', 'agencecinq' ),
							),
							array(
								'key'           => 'field_' . $key . '_hero_content_title',
								'label'         => __( 'Title', 'agencecinq' ),
								'name'          => 'title',
								'aria-label'    => __( 'Title', 'agencecinq' ),
								'type'          => 'textarea',
								'rows'          => 2,
								'new_lines'     => 'br',
								'placeholder'   => __( 'Your site should be an asset.', 'agencecinq' ),
								'instructions'  => __( 'Main heading of the page (H1). Plain text only, no pistachio colour on a word.', 'agencecinq' ),
								'default_value' => '',
							),
						),
					),
					array(
						'key'        => 'field_' . $key . '_hero_specs_tab',
						'label'      => __( 'Specs', 'agencecinq' ),
						'aria-label' => __( 'Specs', 'agencecinq' ),
						'type'       => 'tab',
					),
					array(
						'key'          => 'field_' . $key . '_hero_specs',
						'label'        => __( 'Specs', 'agencecinq' ),
						'name'         => 'specs',
						'aria-label'   => __( 'Specs', 'agencecinq' ),
						'type'         => 'repeater',
						'instructions' => __( 'Up to 4 items. Each line is a taupe prefix plus an optional pistachio highlight.', 'agencecinq' ),
						'layout'       => 'block',
						'max'          => 4,
						'button_label' => __( 'Add Spec', 'agencecinq' ),
						'sub_fields'   => array(
							array(
								'key'             => 'field_' . $key . '_hero_specs_text',
								'label'           => __( 'Text', 'agencecinq' ),
								'name'            => 'text',
								'aria-label'      => __( 'Text', 'agencecinq' ),
								'type'            => 'text',
								'placeholder'     => __( 'Foundations from', 'agencecinq' ),
								'wrapper'         => array(
									'width' => 6 * 100 / 12,
								),
								'parent_repeater' => 'field_' . $key . '_hero_specs',
							),
							array(
								'key'             => 'field_' . $key . '_hero_specs_highlight',
								'label'           => __( 'Highlight', 'agencecinq' ),
								'name'            => 'highlight',
								'aria-label'      => __( 'Highlight', 'agencecinq' ),
								'type'            => 'text',
								'placeholder'     => __( '12,900 to 36,900 €', 'agencecinq' ),
								'instructions'    => '<em>' . __( 'Optional. Rendered in pistachio.', 'agencecinq' ) . '</em>',
								'wrapper'         => array(
									'width' => 6 * 100 / 12,
								),
								'parent_repeater' => 'field_' . $key . '_hero_specs',
							),
						),
					),
					array(
						'key'        => 'field_' . $key . '_hero_quote_tab',
						'label'      => __( 'Quote', 'agencecinq' ),
						'aria-label' => __( 'Quote', 'agencecinq' ),
						'type'       => 'tab',
					),
					array(
						'key'        => 'field_' . $key . '_hero_quote',
						'label'      => __( 'Quote', 'agencecinq' ),
						'name'       => 'quote',
						'aria-label' => __( 'Quote', 'agencecinq' ),
						'type'       => 'group',
						'layout'     => 'block',
						'sub_fields' => array(
							array(
								'key'           => 'field_' . $key . '_hero_quote_image',
								'label'         => __( 'Portrait', 'agencecinq' ),
								'name'          => 'image',
								'aria-label'    => __( 'Portrait', 'agencecinq' ),
								'type'          => 'image',
								'instructions'  => __( 'Client portrait, 400×400.', 'agencecinq' ),
								'return_format' => 'id',
								'preview_size'  => 'thumbnail',
								'library'       => 'all',
								'wrapper'       => array(
									'width' => 4 * 100 / 12,
								),
							),
							array(
								'key'         => 'field_' . $key . '_hero_quote_text',
								'label'       => __( 'Quote', 'agencecinq' ),
								'name'        => 'text',
								'aria-label'  => __( 'Quote', 'agencecinq' ),
								'type'        => 'textarea',
								'rows'        => 3,
								'new_lines'   => 'br',
								'placeholder' => __( 'We knew what we were paying from the start.', 'agencecinq' ),
								'wrapper'     => array(
									'width' => 8 * 100 / 12,
								),
							),
							array(
								'key'         => 'field_' . $key . '_hero_quote_attribution',
								'label'       => __( 'Attribution', 'agencecinq' ),
								'name'        => 'attribution',
								'aria-label'  => __( 'Attribution', 'agencecinq' ),
								'type'        => 'text',
								'placeholder' => __( 'First Last · Role, client company', 'agencecinq' ),
							),
							array(
								'key'          => 'field_' . $key . '_hero_quote_link',
								'label'        => __( 'Link', 'agencecinq' ),
								'name'         => 'link',
								'aria-label'   => __( 'Link', 'agencecinq' ),
								'type'         => 'link',
								'placeholder'  => __( 'Enter the URL of the link', 'agencecinq' ),
								'instructions' => __( 'Primary call to action next to the quote.', 'agencecinq' ),
							),
						),
					),
					array(
						'key'        => 'field_' . $key . '_hero_services_tab',
						'label'      => __( 'Services', 'agencecinq' ),
						'aria-label' => __( 'Services', 'agencecinq' ),
						'type'       => 'tab',
					),
					array(
						'key'          => 'field_' . $key . '_hero_services',
						'label'        => __( 'Services', 'agencecinq' ),
						'name'         => 'services',
						'aria-label'   => __( 'Services', 'agencecinq' ),
						'type'         => 'repeater',
						'instructions' => __( 'Up to 3 service cards. The index (01/03) is generated automatically.', 'agencecinq' ),
						'layout'       => 'block',
						'max'          => 3,
						'button_label' => __( 'Add Service', 'agencecinq' ),
						'sub_fields'   => array(
							array(
								'key'             => 'field_' . $key . '_hero_services_title',
								'label'           => __( 'Title', 'agencecinq' ),
								'name'            => 'title',
								'aria-label'      => __( 'Title', 'agencecinq' ),
								'type'            => 'text',
								'placeholder'     => __( 'Shopify foundation', 'agencecinq' ),
								'parent_repeater' => 'field_' . $key . '_hero_services',
							),
							array(
								'key'             => 'field_' . $key . '_hero_services_text',
								'label'           => __( 'Text', 'agencecinq' ),
								'name'            => 'text',
								'aria-label'      => __( 'Text', 'agencecinq' ),
								'type'            => 'textarea',
								'rows'            => 3,
								'new_lines'       => 'br',
								'placeholder'     => __( 'Enter the service description', 'agencecinq' ),
								'parent_repeater' => 'field_' . $key . '_hero_services',
							),
							array(
								'key'             => 'field_' . $key . '_hero_services_link',
								'label'           => __( 'Link', 'agencecinq' ),
								'name'            => 'link',
								'aria-label'      => __( 'Link', 'agencecinq' ),
								'type'            => 'link',
								'placeholder'     => __( 'Enter the URL of the link', 'agencecinq' ),
								'parent_repeater' => 'field_' . $key . '_hero_services',
							),
						),
					),
				),
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group(
				array(
					'key'        => 'group_' . $key,
					'title'      => __( 'Front Page', 'agencecinq' ),
					'fields'     => $fields,
					'location'   => $location,
					'menu_order' => 0,
				)
			);
		}
	}
}
