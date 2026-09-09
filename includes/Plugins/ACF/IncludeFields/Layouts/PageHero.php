<?php
/**
 * ACF layout: Page Hero
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Page Hero block layout.
 */
class PageHero {

	/**
	 * Returns the layout array for the Page Hero block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_page_hero',
			'name'       => 'page_hero',
			'label'      => __( 'Page Hero', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_page_hero_content_tab',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_page_hero_content',
					'label'        => __( 'Content', 'agencecinq' ),
					'name'         => 'content',
					'aria-label'   => __( 'Content', 'agencecinq' ),
					'type'         => 'group',
					'layout'       => 'block',
					'instructions' => __( 'Left-aligned hero for inner pages. Recommended paddings: 104px top, 80px bottom.', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'          => 'field_' . $key . '_page_hero_content_overline',
							'label'        => __( 'Overline', 'agencecinq' ),
							'name'         => 'overline',
							'aria-label'   => __( 'Overline', 'agencecinq' ),
							'type'         => 'text',
							'placeholder'  => __( 'Enter the overline of the block', 'agencecinq' ),
							'instructions' => __( 'Uppercase mono label above the title.', 'agencecinq' ),
						),
						array(
							'key'          => 'field_' . $key . '_page_hero_content_title',
							'label'        => __( 'Title', 'agencecinq' ),
							'name'         => 'title',
							'aria-label'   => __( 'Title', 'agencecinq' ),
							'type'         => 'text',
							'placeholder'  => __( 'Enter the title of the block', 'agencecinq' ),
							'instructions' => __( 'Main heading of the page. Always rendered as an H1.', 'agencecinq' ),
						),
						array(
							'key'          => 'field_' . $key . '_page_hero_content_text',
							'label'        => __( 'Text', 'agencecinq' ),
							'name'         => 'text',
							'aria-label'   => __( 'Text', 'agencecinq' ),
							'type'         => 'textarea',
							'rows'         => 4,
							'new_lines'    => 'br',
							'placeholder'  => __( 'Enter the lead text of the block', 'agencecinq' ),
							'instructions' => __( 'Lead paragraph, about 60 characters wide.', 'agencecinq' ),
						),
						array(
							'key'           => 'field_' . $key . '_page_hero_content_link',
							'label'         => __( 'Link', 'agencecinq' ),
							'name'          => 'link',
							'aria-label'    => __( 'Link', 'agencecinq' ),
							'type'          => 'link',
							'return_format' => 'array',
							'default_value' => array(
								'title'  => __( 'Réserver 20 minutes', 'agencecinq' ),
								'url'    => '',
								'target' => '',
							),
							'instructions'  => __( 'Primary CTA. Default label: Reserve 20 minutes. The diagnostic is never a first click.', 'agencecinq' ),
							'wrapper'       => array(
								'width' => 6 * 100 / 12,
							),
						),
						array(
							'key'           => 'field_' . $key . '_page_hero_content_secondary_link',
							'label'         => __( 'Secondary link', 'agencecinq' ),
							'name'          => 'secondary_link',
							'aria-label'    => __( 'Secondary link', 'agencecinq' ),
							'type'          => 'link',
							'return_format' => 'array',
							'instructions'  => __( 'Optional underlined link next to the primary CTA.', 'agencecinq' ),
							'wrapper'       => array(
								'width' => 6 * 100 / 12,
							),
						),
					),
				),
				...AcfFieldHelpers::settings( $key . '_page_hero' ),
			),
		);
	}
}
