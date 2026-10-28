<?php
/**
 * ACF layout: Link row
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Link row block layout.
 */
class LinkRow {

	/**
	 * Returns the layout array for the Link row block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_link_row',
			'name'       => 'link_row',
			'label'      => __( 'Link row', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_link_row_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_link_row_content',
					'label'        => __( 'Content', 'agencecinq' ),
					'name'         => 'content',
					'aria-label'   => __( 'Content', 'agencecinq' ),
					'type'         => 'group',
					'layout'       => 'block',
					'instructions' => __( 'End of page links to sibling pages. Recommended paddings: 80px top and bottom.', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'           => 'field_' . $key . '_link_row_content_title',
							'label'         => __( 'Title', 'agencecinq' ),
							'name'          => 'title',
							'aria-label'    => __( 'Title', 'agencecinq' ),
							'type'          => 'text',
							'default_value' => __( 'See also', 'agencecinq' ),
						),
						array(
							'key'        => 'field_' . $key . '_link_row_content_heading',
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
					'key'          => 'field_' . $key . '_link_row_items',
					'label'        => __( 'Links', 'agencecinq' ),
					'name'         => 'items',
					'aria-label'   => __( 'Links', 'agencecinq' ),
					'type'         => 'repeater',
					'layout'       => 'table',
					'max'          => 4,
					'button_label' => __( 'Add Link', 'agencecinq' ),
					'instructions' => __( 'Up to four links, in a row on desktop. Each label reads on its own.', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'             => 'field_' . $key . '_link_row_items_link',
							'label'           => __( 'Link', 'agencecinq' ),
							'name'            => 'link',
							'aria-label'      => __( 'Link', 'agencecinq' ),
							'type'            => 'link',
							'return_format'   => 'array',
							'required'        => 1,
							'parent_repeater' => 'field_' . $key . '_link_row_items',
						),
						array(
							'key'             => 'field_' . $key . '_link_row_items_text',
							'label'           => __( 'Text', 'agencecinq' ),
							'name'            => 'text',
							'aria-label'      => __( 'Text', 'agencecinq' ),
							'type'            => 'text',
							'parent_repeater' => 'field_' . $key . '_link_row_items',
						),
					),
				),
				...AcfFieldHelpers::settings( $key . '_link_row' ),
			),
		);
	}
}
