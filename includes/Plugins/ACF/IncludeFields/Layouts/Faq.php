<?php
/**
 * ACF layout: FAQ
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * FAQ block layout.
 */
class Faq {

	/**
	 * Returns the layout array for the FAQ block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_faq',
			'name'       => 'faq',
			'label'      => __( 'FAQ', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_faq' ),
				array(
					'key'        => 'field_' . $key . '_faq_content_tab',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_faq_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'          => 'field_' . $key . '_faq_content_overline',
							'label'        => __( 'Overline', 'agencecinq' ),
							'name'         => 'overline',
							'aria-label'   => __( 'Overline', 'agencecinq' ),
							'type'         => 'text',
							'placeholder'  => __( 'Enter the overline of the block', 'agencecinq' ),
							'instructions' => __( 'Eyebrow label shown above the title.', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_faq_content_title',
							'label'       => __( 'Title', 'agencecinq' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'Enter the title of the block', 'agencecinq' ),
						),
						array(
							'key'        => 'field_' . $key . '_faq_content_heading',
							'label'      => __( 'Heading', 'agencecinq' ),
							'name'       => 'heading',
							'aria-label' => __( 'Heading', 'agencecinq' ),
							'type'       => 'clone',
							'clone'      => array( 'field_clones_heading' ),
							'display'    => 'seamless',
							'layout'     => 'block',
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_faq_tab_items',
					'label'      => __( 'Questions', 'agencecinq' ),
					'aria-label' => __( 'Questions', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_faq_items',
					'label'        => __( 'Questions', 'agencecinq' ),
					'name'         => 'items',
					'aria-label'   => __( 'Questions', 'agencecinq' ),
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'Add Question', 'agencecinq' ),
					'min'          => 1,
					'instructions' => __( 'Each row is a question. Keep answers short. Link to a dedicated page when the topic has one. The first item opens by default.', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'             => 'field_' . $key . '_faq_items_question',
							'label'           => __( 'Question', 'agencecinq' ),
							'name'            => 'question',
							'aria-label'      => __( 'Question', 'agencecinq' ),
							'type'            => 'text',
							'placeholder'     => __( 'Enter the question', 'agencecinq' ),
							'parent_repeater' => 'field_' . $key . '_faq_items',
						),
						array(
							'key'             => 'field_' . $key . '_faq_items_answer',
							'label'           => __( 'Answer', 'agencecinq' ),
							'name'            => 'answer',
							'aria-label'      => __( 'Answer', 'agencecinq' ),
							'type'            => 'wysiwyg',
							'tabs'            => 'visual',
							'toolbar'         => 'basic',
							'media_upload'    => 0,
							'instructions'    => __( 'Keep the answer short and direct (featured snippet).', 'agencecinq' ),
							'parent_repeater' => 'field_' . $key . '_faq_items',
						),
					),
				),
			),
		);
	}
}
