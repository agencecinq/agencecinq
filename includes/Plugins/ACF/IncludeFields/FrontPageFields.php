<?php
/**
 * Front Page Fields
 *
 * Registers ACF field group for the homepage hero (page_type front_page).
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
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
				'instructions' => __( 'Homepage hero: the text and its two buttons on the left, the diff of a site on the right. The title is always an H1 and stays a single colour. Do not highlight a word, do not center the title, and do not add a row of keywords.', 'agencecinq' ),
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
								'key'          => 'field_' . $key . '_hero_content_eyebrow',
								'label'        => __( 'Eyebrow', 'agencecinq' ),
								'name'         => 'eyebrow',
								'aria-label'   => __( 'Eyebrow', 'agencecinq' ),
								'type'         => 'text',
								'placeholder'  => __( 'For companies whose site has stayed old-fashioned', 'agencecinq' ),
								'instructions' => __( 'Who the page speaks to, above the title.', 'agencecinq' ),
							),
							array(
								'key'          => 'field_' . $key . '_hero_content_title',
								'label'        => __( 'Title', 'agencecinq' ),
								'name'         => 'title',
								'aria-label'   => __( 'Title', 'agencecinq' ),
								'type'         => 'textarea',
								'rows'         => 2,
								'new_lines'    => 'br',
								'placeholder'  => __( 'Your site should be an asset.', 'agencecinq' ),
								'instructions' => __( 'Main heading of the page (H1). Plain text only, no pistachio colour on a word.', 'agencecinq' ),
							),
							array(
								'key'          => 'field_' . $key . '_hero_content_text',
								'label'        => __( 'Text', 'agencecinq' ),
								'name'         => 'text',
								'aria-label'   => __( 'Text', 'agencecinq' ),
								'type'         => 'textarea',
								'rows'         => 4,
								'new_lines'    => '',
								'placeholder'  => __( 'Enter the lead text of the block', 'agencecinq' ),
								'instructions' => __( 'One paragraph under the title, four lines at most on desktop.', 'agencecinq' ),
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
						'key'        => 'field_' . $key . '_hero_diff_tab',
						'label'      => __( 'Diff', 'agencecinq' ),
						'aria-label' => __( 'Diff', 'agencecinq' ),
						'type'       => 'tab',
					),
					array(
						'key'          => 'field_' . $key . '_hero_diff',
						'label'        => __( 'Diff', 'agencecinq' ),
						'name'         => 'diff',
						'aria-label'   => __( 'Diff', 'agencecinq' ),
						'type'         => 'group',
						'layout'       => 'block',
						'instructions' => __( 'The diff of a site: what goes, then what comes in. The figures of a real client show only with their consent, otherwise keep the note « example ».', 'agencecinq' ),
						'sub_fields'   => array(
							array(
								'key'           => 'field_' . $key . '_hero_diff_address',
								'label'         => __( 'Address', 'agencecinq' ),
								'name'          => 'address',
								'aria-label'    => __( 'Address', 'agencecinq' ),
								'type'          => 'text',
								'default_value' => 'votre-site.fr',
								'wrapper'       => array(
									'width' => 6 * 100 / 12,
								),
							),
							array(
								'key'           => 'field_' . $key . '_hero_diff_note',
								'label'         => __( 'Note', 'agencecinq' ),
								'name'          => 'note',
								'aria-label'    => __( 'Note', 'agencecinq' ),
								'type'          => 'text',
								'default_value' => __( 'example', 'agencecinq' ),
								'wrapper'       => array(
									'width' => 6 * 100 / 12,
								),
							),
							array(
								'key'          => 'field_' . $key . '_hero_diff_removed',
								'label'        => __( 'Lines that go', 'agencecinq' ),
								'name'         => 'removed',
								'aria-label'   => __( 'Lines that go', 'agencecinq' ),
								'type'         => 'repeater',
								'layout'       => 'table',
								'button_label' => __( 'Add Line', 'agencecinq' ),
								'wrapper'      => array(
									'width' => 6 * 100 / 12,
								),
								'sub_fields'   => array(
									array(
										'key'             => 'field_' . $key . '_hero_diff_removed_text',
										'label'           => __( 'Text', 'agencecinq' ),
										'name'            => 'text',
										'aria-label'      => __( 'Text', 'agencecinq' ),
										'type'            => 'text',
										'placeholder'     => __( 'e.g. WordPress 3 versions behind', 'agencecinq' ),
										'parent_repeater' => 'field_' . $key . '_hero_diff_removed',
									),
								),
							),
							array(
								'key'          => 'field_' . $key . '_hero_diff_added',
								'label'        => __( 'Lines that come in', 'agencecinq' ),
								'name'         => 'added',
								'aria-label'   => __( 'Lines that come in', 'agencecinq' ),
								'type'         => 'repeater',
								'layout'       => 'table',
								'button_label' => __( 'Add Line', 'agencecinq' ),
								'wrapper'      => array(
									'width' => 6 * 100 / 12,
								),
								'sub_fields'   => array(
									array(
										'key'             => 'field_' . $key . '_hero_diff_added_text',
										'label'           => __( 'Text', 'agencecinq' ),
										'name'            => 'text',
										'aria-label'      => __( 'Text', 'agencecinq' ),
										'type'            => 'text',
										'placeholder'     => __( 'e.g. WordPress up to date, checked every month', 'agencecinq' ),
										'parent_repeater' => 'field_' . $key . '_hero_diff_added',
									),
								),
							),
							array(
								'key'           => 'field_' . $key . '_hero_diff_link',
								'label'         => __( 'Link', 'agencecinq' ),
								'name'          => 'link',
								'aria-label'    => __( 'Link', 'agencecinq' ),
								'type'          => 'link',
								'return_format' => 'array',
								'instructions'  => __( 'Optional link under the lines, e.g. to the diagnostic.', 'agencecinq' ),
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
