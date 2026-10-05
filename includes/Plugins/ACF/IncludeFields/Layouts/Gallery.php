<?php
/**
 * ACF layout: Gallery
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Gallery block layout.
 */
class Gallery {

	/**
	 * Returns the layout array for the Gallery block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_gallery',
			'name'       => 'gallery',
			'label'      => __( 'Gallery', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_gallery_content_tab',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_gallery_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'   => 'field_' . $key . '_gallery_content_overline',
							'label' => __( 'Overline', 'agencecinq' ),
							'name'  => 'overline',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_' . $key . '_gallery_content_title',
							'label' => __( 'Title', 'agencecinq' ),
							'name'  => 'title',
							'type'  => 'text',
						),
						array(
							'key'     => 'field_' . $key . '_gallery_content_heading',
							'label'   => __( 'Heading', 'agencecinq' ),
							'name'    => 'heading',
							'type'    => 'clone',
							'clone'   => array( 'field_clones_heading' ),
							'display' => 'seamless',
							'layout'  => 'block',
						),
						array(
							'key'       => 'field_' . $key . '_gallery_content_text',
							'label'     => __( 'Text', 'agencecinq' ),
							'name'      => 'text',
							'type'      => 'textarea',
							'rows'      => 3,
							'new_lines' => 'br',
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_gallery_images_tab',
					'label'      => __( 'Images', 'agencecinq' ),
					'aria-label' => __( 'Images', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'           => 'field_' . $key . '_gallery_images',
					'label'         => __( 'Images', 'agencecinq' ),
					'name'          => 'gallery',
					'aria-label'    => __( 'Images', 'agencecinq' ),
					'type'          => 'gallery',
					'return_format' => 'array',
					'preview_size'  => 'medium',
					'insert'        => 'append',
					'instructions'  => __( 'Shown in three columns on large screens.', 'agencecinq' ),
				),
				...AcfFieldHelpers::settings( $key . '_gallery' ),
			),
		);
	}
}
