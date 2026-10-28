<?php
/**
 * ACF layout: Activity log
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Activity log block layout.
 */
class ActivityLog {

	/**
	 * Returns the layout array for the Activity log block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_activity_log',
			'name'       => 'activity_log',
			'label'      => __( 'Activity log', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_activity_log_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_activity_log_content',
					'label'        => __( 'Content', 'agencecinq' ),
					'name'         => 'content',
					'aria-label'   => __( 'Content', 'agencecinq' ),
					'type'         => 'group',
					'layout'       => 'block',
					'instructions' => __( 'The three repositories of the agency pushed last, then the commits of their main branch per day over six months, read from GitHub every hour. Recommended paddings: 56px top and bottom.', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'         => 'field_' . $key . '_activity_log_content_title',
							'label'       => __( 'Title', 'agencecinq' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'The team’s log', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_activity_log_content_text',
							'label'       => __( 'Text', 'agencecinq' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'What we shipped these last days, live from our repositories.', 'agencecinq' ),
						),
						array(
							'key'        => 'field_' . $key . '_activity_log_content_heading',
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
					'key'        => 'field_' . $key . '_activity_log_tab_projects',
					'label'      => __( 'Projects', 'agencecinq' ),
					'aria-label' => __( 'Projects', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_activity_log_projects',
					'label'        => __( 'Named projects', 'agencecinq' ),
					'name'         => 'projects',
					'aria-label'   => __( 'Named projects', 'agencecinq' ),
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => __( 'Add Project', 'agencecinq' ),
					'instructions' => __( 'Name a private repository only with the written consent of its client. Without a name, a private repository shows as « Private client », a public one under its GitHub name.', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'             => 'field_' . $key . '_activity_log_projects_repository',
							'label'           => __( 'Repository', 'agencecinq' ),
							'name'            => 'repository',
							'aria-label'      => __( 'Repository', 'agencecinq' ),
							'type'            => 'text',
							'placeholder'     => __( 'e.g. milia-matcha', 'agencecinq' ),
							'parent_repeater' => 'field_' . $key . '_activity_log_projects',
						),
						array(
							'key'             => 'field_' . $key . '_activity_log_projects_name',
							'label'           => __( 'Name', 'agencecinq' ),
							'name'            => 'name',
							'aria-label'      => __( 'Name', 'agencecinq' ),
							'type'            => 'text',
							'placeholder'     => __( 'e.g. Milia Matcha', 'agencecinq' ),
							'parent_repeater' => 'field_' . $key . '_activity_log_projects',
						),
					),
				),
				...AcfFieldHelpers::settings( $key . '_activity_log' ),
			),
		);
	}
}
