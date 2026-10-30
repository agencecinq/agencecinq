<?php
/**
 * ACF layout: Logo wall
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Logo wall block layout.
 */
class LogoWall {

	/**
	 * Returns the layout array for the Logo wall block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_logo_wall',
			'name'       => 'logo_wall',
			'label'      => __( 'Logo wall', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_logo_wall_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_logo_wall_content',
					'label'        => __( 'Content', 'agencecinq' ),
					'name'         => 'content',
					'aria-label'   => __( 'Content', 'agencecinq' ),
					'type'         => 'group',
					'layout'       => 'block',
					'instructions' => __( 'One tile per client, all the same size: two per row on mobile, eight on desktop. Recommended paddings: 56px top and bottom.', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'         => 'field_' . $key . '_logo_wall_content_eyebrow',
							'label'       => __( 'Eyebrow', 'agencecinq' ),
							'name'        => 'eyebrow',
							'aria-label'  => __( 'Eyebrow', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'They trust us with their site', 'agencecinq' ),
						),
					),
				),
				array(
					'key'          => 'field_' . $key . '_logo_wall_logos',
					'label'        => __( 'Logos', 'agencecinq' ),
					'name'         => 'logos',
					'aria-label'   => __( 'Logos', 'agencecinq' ),
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => __( 'Add Logo', 'agencecinq' ),
					'instructions' => __( 'Only with the written consent of each client. The logo takes the muted text colour: one colour on a transparent background, SVG, PNG or WebP. Without a logo, the tile shows the name.', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'             => 'field_' . $key . '_logo_wall_logos_name',
							'label'           => __( 'Name', 'agencecinq' ),
							'name'            => 'name',
							'aria-label'      => __( 'Name', 'agencecinq' ),
							'type'            => 'text',
							'required'        => 1,
							'instructions'    => __( 'Client name, also the alternative of the logo.', 'agencecinq' ),
							'parent_repeater' => 'field_' . $key . '_logo_wall_logos',
						),
						array(
							'key'             => 'field_' . $key . '_logo_wall_logos_image',
							'label'           => __( 'Logo', 'agencecinq' ),
							'name'            => 'image',
							'aria-label'      => __( 'Logo', 'agencecinq' ),
							'type'            => 'image',
							'return_format'   => 'id',
							'preview_size'    => 'thumbnail',
							'mime_types'      => 'svg, png, webp',
							'parent_repeater' => 'field_' . $key . '_logo_wall_logos',
						),
					),
				),
				...AcfFieldHelpers::settings( $key . '_logo_wall' ),
			),
		);
	}
}
