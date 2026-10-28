<?php
/**
 * ACF layout: Image cards
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Image cards block layout.
 */
class ImageCards {

	/**
	 * Returns the layout array for the Image cards block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_image_cards',
			'name'       => 'image_cards',
			'label'      => __( 'Image cards', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_image_cards_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_image_cards_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'         => 'field_' . $key . '_image_cards_content_eyebrow',
							'label'       => __( 'Eyebrow', 'agencecinq' ),
							'name'        => 'eyebrow',
							'aria-label'  => __( 'Eyebrow', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'Case studies', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_image_cards_content_title',
							'label'       => __( 'Title', 'agencecinq' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'They started from the same situation as you.', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_image_cards_content_text',
							'label'       => __( 'Text', 'agencecinq' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'agencecinq' ),
							'type'        => 'textarea',
							'rows'        => 3,
							'new_lines'   => '',
							'placeholder' => __( 'Enter the lead text of the block', 'agencecinq' ),
						),
						array(
							'key'        => 'field_' . $key . '_image_cards_content_heading',
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
					'key'           => 'field_' . $key . '_image_cards_cases',
					'label'         => __( 'Case studies', 'agencecinq' ),
					'name'          => 'cases',
					'aria-label'    => __( 'Case studies', 'agencecinq' ),
					'type'          => 'relationship',
					'post_type'     => array( 'case-study' ),
					'filters'       => array( 'search' ),
					'return_format' => 'id',
					'instructions'  => __( 'Three per row on desktop. None chosen: the three latest case studies, other than the current page. Only clients who gave their written consent. Each card shows the screenshot, the client, the situation and the summary of the case study.', 'agencecinq' ),
				),
				...AcfFieldHelpers::settings( $key . '_image_cards' ),
			),
		);
	}
}
