<?php
/**
 * ACF layout: Team
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Team block layout.
 */
class Team {

	/**
	 * Returns the layout array for the Team block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_team',
			'name'       => 'team',
			'label'      => __( 'Team', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_team' ),
				array(
					'key'        => 'field_' . $key . '_team_content_tab',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_team_content',
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'        => 'field_' . $key . '_team_content_members',
							'label'      => __( 'Members', 'agencecinq' ),
							'name'       => 'members',
							'aria-label' => __( 'Members', 'agencecinq' ),
							'type'       => 'repeater',
							'layout'     => 'block',
							'sub_fields' => array(
								array(
									'key'             => 'field_' . $key . '_team_content_members_name',
									'label'           => __( 'Name', 'agencecinq' ),
									'name'            => 'name',
									'aria-label'      => __( 'Name', 'agencecinq' ),
									'type'            => 'text',
									'placeholder'     => __( 'Enter the name of the member', 'agencecinq' ),
									'parent_repeater' => 'field_' . $key . '_team_content_members',
								),
								array(
									'key'             => 'field_' . $key . '_team_content_members_position',
									'label'           => __( 'Position', 'agencecinq' ),
									'name'            => 'position',
									'aria-label'      => __( 'Position', 'agencecinq' ),
									'type'            => 'text',
									'placeholder'     => __( 'Enter the position of the member', 'agencecinq' ),
									'parent_repeater' => 'field_' . $key . '_team_content_members',
								),
								array(
									'key'               => 'field_' . $key . '_team_content_members_image',
									'label'             => __( 'Image', 'agencecinq' ),
									'name'              => 'image',
									'aria-label'        => __( 'Image', 'agencecinq' ),
									'type'              => 'image',
									'return_format'     => 'id',
									'library'           => 'all',
									'allow_in_bindings' => 0,
									'preview_size'      => 'medium',
									'parent_repeater'   => 'field_' . $key . '_team_content_members',
								),
								array(
									'key'             => 'field_' . $key . '_team_content_members_linkedin',
									'label'           => __( 'LinkedIn', 'agencecinq' ),
									'name'            => 'linkedin',
									'aria-label'      => __( 'LinkedIn', 'agencecinq' ),
									'type'            => 'url',
									'placeholder'     => __( 'Enter the LinkedIn URL of the member', 'agencecinq' ),
									'parent_repeater' => 'field_' . $key . '_team_content_members',
								),
							),
						),
					),
				),
			),
		);
	}
}
