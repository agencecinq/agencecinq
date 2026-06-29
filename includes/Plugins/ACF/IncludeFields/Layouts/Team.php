<?php
/**
 * ACF layout: Team
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn/Plugins/ACF/IncludeFields/Layouts
 */

namespace WPCinquanteEtUn\Plugins\ACF\IncludeFields\Layouts;

use WPCinquanteEtUn\Plugins\ACF\IncludeFields\AcfFieldHelpers;

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
			'label'      => __( 'Team', 'wp-cinquante-et-un' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_team' ),
				array(
					'key'        => 'field_' . $key . '_team_content_tab',
					'label'      => __( 'Content', 'wp-cinquante-et-un' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_team_content',
					'name'       => 'content',
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'        => 'field_' . $key . '_team_content_members',
							'label'      => __( 'Members', 'wp-cinquante-et-un' ),
							'name'       => 'members',
							'aria-label' => __( 'Members', 'wp-cinquante-et-un' ),
							'type'       => 'repeater',
							'layout'     => 'block',
							'sub_fields' => array(
								array(
									'key'             => 'field_' . $key . '_team_content_members_name',
									'label'           => __( 'Name', 'wp-cinquante-et-un' ),
									'name'            => 'name',
									'aria-label'      => __( 'Name', 'wp-cinquante-et-un' ),
									'type'            => 'text',
									'placeholder'     => __( 'Enter the name of the member', 'wp-cinquante-et-un' ),
									'parent_repeater' => 'field_' . $key . '_team_content_members',
								),
								array(
									'key'             => 'field_' . $key . '_team_content_members_position',
									'label'           => __( 'Position', 'wp-cinquante-et-un' ),
									'name'            => 'position',
									'aria-label'      => __( 'Position', 'wp-cinquante-et-un' ),
									'type'            => 'text',
									'placeholder'     => __( 'Enter the position of the member', 'wp-cinquante-et-un' ),
									'parent_repeater' => 'field_' . $key . '_team_content_members',
								),
								array(
									'key'               => 'field_' . $key . '_team_content_members_image',
									'label'             => __( 'Image', 'wp-cinquante-et-un' ),
									'name'              => 'image',
									'aria-label'        => __( 'Image', 'wp-cinquante-et-un' ),
									'type'              => 'image',
									'return_format'     => 'id',
									'library'           => 'all',
									'allow_in_bindings' => 0,
									'preview_size'      => 'medium',
									'parent_repeater'   => 'field_' . $key . '_team_content_members',
								),
								array(
									'key'             => 'field_' . $key . '_team_content_members_linkedin',
									'label'           => __( 'LinkedIn', 'wp-cinquante-et-un' ),
									'name'            => 'linkedin',
									'aria-label'      => __( 'LinkedIn', 'wp-cinquante-et-un' ),
									'type'            => 'url',
									'placeholder'     => __( 'Enter the LinkedIn URL of the member', 'wp-cinquante-et-un' ),
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
