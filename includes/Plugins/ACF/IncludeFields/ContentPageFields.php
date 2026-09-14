<?php
/**
 * Content Page Fields
 *
 * Registers ACF field group for the Content page template (no flexible blocks).
 * Layout mirrors Section · Page Hero + Section · Editorial Prose.
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields;

use AgenceCinq\Service;

/**
 * Content Page Fields
 *
 * Loads advanced custom fields for the Content page template.
 */
class ContentPageFields implements Service {

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
		$key = 'content_page';

		$location = array(
			array(
				array(
					'param'    => 'page_template',
					'operator' => '==',
					'value'    => 'page-templates/content-page.php',
				),
			),
		);

		$fields = array(
			array(
				'key'        => 'field_' . $key . '_content',
				'label'      => __( 'Content', 'agencecinq' ),
				'name'       => 'content',
				'aria-label' => __( 'Content', 'agencecinq' ),
				'type'       => 'group',
				'layout'     => 'block',
				'sub_fields' => array(
					array(
						'key'          => 'field_' . $key . '_content_overline',
						'label'        => __( 'Overline', 'agencecinq' ),
						'name'         => 'overline',
						'aria-label'   => __( 'Overline', 'agencecinq' ),
						'type'         => 'text',
						'placeholder'  => __( 'Enter the overline of the page', 'agencecinq' ),
						'instructions' => __( 'Uppercase mono label above the title.', 'agencecinq' ) . ' <em>(' . __( 'Optional.', 'agencecinq' ) . ')</em>',
					),
					array(
						'key'          => 'field_' . $key . '_content_title',
						'label'        => __( 'Title', 'agencecinq' ),
						'name'         => 'title',
						'aria-label'   => __( 'Title', 'agencecinq' ),
						'type'         => 'text',
						'placeholder'  => __( 'Enter the title of the page', 'agencecinq' ),
						'instructions' => __( 'Main heading (H1). Falls back to the WordPress page title if empty.', 'agencecinq' ),
					),
					array(
						'key'          => 'field_' . $key . '_content_text',
						'label'        => __( 'Text', 'agencecinq' ),
						'name'         => 'text',
						'aria-label'   => __( 'Text', 'agencecinq' ),
						'type'         => 'textarea',
						'rows'         => 4,
						'new_lines'    => 'br',
						'placeholder'  => __( 'Enter the lead text of the page', 'agencecinq' ),
						'instructions' => __( 'Lead paragraph under the title, about 60 characters wide.', 'agencecinq' ) . ' <em>(' . __( 'Optional.', 'agencecinq' ) . ')</em>',
					),
					array(
						'key'          => 'field_' . $key . '_content_links',
						'label'        => __( 'Links', 'agencecinq' ),
						'name'         => 'links',
						'aria-label'   => __( 'Links', 'agencecinq' ),
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => __( 'Add Link', 'agencecinq' ),
						'instructions' => __( 'The first link is rendered as a primary button; the following links as secondary underlined links.', 'agencecinq' ),
						'sub_fields'   => array(
							array(
								'key'             => 'field_' . $key . '_content_links_link',
								'label'           => __( 'Link', 'agencecinq' ),
								'name'            => 'link',
								'aria-label'      => __( 'Link', 'agencecinq' ),
								'type'            => 'link',
								'return_format'   => 'array',
								'parent_repeater' => 'field_' . $key . '_content_links',
							),
						),
					),
					array(
						'key'          => 'field_' . $key . '_content_body',
						'label'        => __( 'Body', 'agencecinq' ),
						'name'         => 'body',
						'aria-label'   => __( 'Body', 'agencecinq' ),
						'type'         => 'wysiwyg',
						'tabs'         => 'all',
						'toolbar'      => 'full',
						'media_upload' => 1,
						'delay'        => 0,
						'instructions' => __( 'Reading column (720px). Use Heading 2 for section titles and Heading 3 for subtitles. This is the main SEO depth of the page.', 'agencecinq' ),
					),
				),
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group(
				array(
					'key'                   => 'group_' . $key,
					'title'                 => __( 'Content Page Fields', 'agencecinq' ),
					'fields'                => $fields,
					'location'              => $location,
					'menu_order'            => 0,
					'hide_on_screen'        => array( 'the_content' ),
					'label_placement'       => 'top',
					'instruction_placement' => 'label',
					'active'                => true,
				)
			);
		}
	}
}
