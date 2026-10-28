<?php
/**
 * ACF layout: Portrait grid
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Portrait grid block layout.
 */
class PortraitGrid {

	/**
	 * Returns the layout array for the Portrait grid block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_portrait_grid',
			'name'       => 'portrait_grid',
			'label'      => __( 'Portrait grid', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_portrait_grid_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_portrait_grid_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'         => 'field_' . $key . '_portrait_grid_content_eyebrow',
							'label'       => __( 'Eyebrow', 'agencecinq' ),
							'name'        => 'eyebrow',
							'aria-label'  => __( 'Eyebrow', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'Who does the work', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_portrait_grid_content_title',
							'label'       => __( 'Title', 'agencecinq' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'A tight team, not a floor.', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_portrait_grid_content_text',
							'label'       => __( 'Text', 'agencecinq' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'agencecinq' ),
							'type'        => 'textarea',
							'rows'        => 3,
							'new_lines'   => '',
							'placeholder' => __( 'Enter the lead text of the block', 'agencecinq' ),
						),
						array(
							'key'        => 'field_' . $key . '_portrait_grid_content_heading',
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
					'key'        => 'field_' . $key . '_portrait_grid_tab_people',
					'label'      => __( 'People', 'agencecinq' ),
					'aria-label' => __( 'People', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_portrait_grid_people',
					'label'        => __( 'People', 'agencecinq' ),
					'name'         => 'people',
					'aria-label'   => __( 'People', 'agencecinq' ),
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => __( 'Add Person', 'agencecinq' ),
					'instructions' => __( 'Four per row on desktop, two on mobile, over the CINQ band. Black and white portraits, square: the first name follows, so the portrait needs no alternative.', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'             => 'field_' . $key . '_portrait_grid_people_image',
							'label'           => __( 'Portrait', 'agencecinq' ),
							'name'            => 'image',
							'aria-label'      => __( 'Portrait', 'agencecinq' ),
							'type'            => 'image',
							'return_format'   => 'id',
							'preview_size'    => 'thumbnail',
							'parent_repeater' => 'field_' . $key . '_portrait_grid_people',
						),
						array(
							'key'             => 'field_' . $key . '_portrait_grid_people_name',
							'label'           => __( 'First name', 'agencecinq' ),
							'name'            => 'name',
							'aria-label'      => __( 'First name', 'agencecinq' ),
							'type'            => 'text',
							'required'        => 1,
							'parent_repeater' => 'field_' . $key . '_portrait_grid_people',
						),
						array(
							'key'             => 'field_' . $key . '_portrait_grid_people_role',
							'label'           => __( 'Role', 'agencecinq' ),
							'name'            => 'role',
							'aria-label'      => __( 'Role', 'agencecinq' ),
							'type'            => 'text',
							'parent_repeater' => 'field_' . $key . '_portrait_grid_people',
						),
					),
				),
				...AcfFieldHelpers::settings( $key . '_portrait_grid' ),
			),
		);
	}
}
