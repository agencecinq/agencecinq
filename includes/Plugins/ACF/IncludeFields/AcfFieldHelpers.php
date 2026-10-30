<?php
/**
 * ACF Field Helpers
 *
 * Static helpers that return reusable ACF field arrays (settings)
 * and build layouts for flexible content. Use these inside field groups, not as field groups.
 *
 * @package AgenceCinq
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields;

/**
 * AcfFieldHelpers
 *
 * Helper methods that return ACF field definitions for use in acf_add_local_field_group().
 */
class AcfFieldHelpers {

	/**
	 * Returns the settings fields for a block (tab + layout clone).
	 *
	 * Append at the end of the layout sub_fields so Settings is the last tab:
	 * ```php
	 * 'sub_fields' => array(
	 *     array( ... ),
	 *     ...AcfFieldHelpers::settings( 'block_name' ),
	 * ),
	 * ```
	 *
	 * @param string $key The block key (e.g. 'hero', 'link_grid', or 'blocks_hero' for unique keys).
	 * @return array<int, array<string, mixed>>
	 */
	public static function settings( string $key = '' ): array {
		$tab = array(
			'key'        => 'field_settings_' . $key . '_tab_settings',
			'label'      => __( 'Settings', 'agencecinq' ),
			'aria-label' => __( 'Settings', 'agencecinq' ),
			'type'       => 'tab',
		);

		$field = array(
			'key'        => 'field_settings_' . $key . '_layout',
			'label'      => __( 'Layout', 'agencecinq' ),
			'name'       => 'layout',
			'aria-label' => __( 'Layout', 'agencecinq' ),
			'type'       => 'clone',
			'clone'      => array( 'field_clones_layout' ),
			'display'    => 'seamless',
			'layout'     => 'block',
		);

		return array( $tab, $field );
	}

	/**
	 * Builds the layouts array for a flexible content from layout classes.
	 * Each class must have a static get_layout( string $key ): array returning keys 'key', 'name', 'label', 'display', 'sub_fields'.
	 *
	 * @param string $key           The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @param array  $layout_classes Array of layout class names (class-string).
	 * @return array<string, array<string, mixed>>
	 */
	public static function get_layouts_from( string $key, array $layout_classes ): array {
		$layouts = array();

		foreach ( $layout_classes as $class ) {
			if ( is_callable( array( $class, 'get_layout' ) ) ) {
				$layout                                    = $class::get_layout( $key );
				$name                                      = $layout['name'] ?? '';
				$layouts[ 'layout_' . $key . '_' . $name ] = $layout;
			}
		}
		return $layouts;
	}
}
