<?php
/**
 * ACF Field Type: Menu Item Select
 *
 * Allows selecting a single entry from a WordPress navigation menu.
 * Behaves like a native ACF Select / Relational field.
 *
 * @package WPCinquanteEtUn
 * @subpackage WPCinquanteEtUn/Plugins/ACF/FieldTypes
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace WPCinquanteEtUn\Plugins\ACF\FieldTypes;

// phpcs:ignore Generic.Files.OneObjectStructurePerFile.MultipleFound
if ( ! class_exists( 'acf_field' ) ) {
	return;
}

/**
 * Class MenuItemSelect
 *
 * Custom ACF field type to select one item from a WordPress menu.
 * Stored value: nav menu item post ID.
 * Return format: 'value' (ID), 'object' (WP_Post), or 'array' (id, title, url).
 */
class MenuItemSelect extends \acf_field {

	/**
	 * Initializes the field type.
	 *
	 * @return void
	 */
	public function initialize(): void {
		$this->name        = 'menu_item_select';
		$this->label       = __( 'Menu Item Select', 'wp-cinquante-et-un' );
		$this->category    = 'relational';
		$this->description = __( 'Select a single entry from a WordPress navigation menu.', 'wp-cinquante-et-un' );
		$this->defaults    = array(
			'menu'          => '',
			'allow_null'    => 1,
			'return_format' => 'object',
			'placeholder'   => '',
			'ui'            => 1,
		);
	}

	/**
	 * Enqueues admin scripts so the field uses the same Select2 UI as ACF Select.
	 *
	 * @return void
	 */
	public function input_admin_enqueue_scripts(): void {
		if ( ! acf_get_setting( 'enqueue_select2' ) ) {
			return;
		}

		global $wp_scripts;

		$min   = defined( 'ACF_DEVELOPMENT_MODE' ) && ACF_DEVELOPMENT_MODE ? '' : '.min';
		$major = acf_get_setting( 'select2_version' );

		if ( isset( $wp_scripts->registered['select2'] ) ) {
			$major = (int) $wp_scripts->registered['select2']->ver;
		}

		if ( $major === 3 ) {
			$version = '3.5.2';
			$script  = acf_get_url( "assets/inc/select2/3/select2{$min}.js" );
			$style   = acf_get_url( 'assets/inc/select2/3/select2.css' );
		} else {
			$version = '4.0.13';
			$script  = acf_get_url( "assets/inc/select2/4/select2.full{$min}.js" );
			$style   = acf_get_url( "assets/inc/select2/4/select2{$min}.css" );
		}

		wp_enqueue_script( 'select2', $script, array( 'jquery' ), $version );
		wp_enqueue_style( 'select2', $style, '', $version );

		acf_localize_data(
			array(
				'select2L10n' => array(
					'matches_1'            => _x( 'One result is available, press enter to select it.', 'Select2 JS matches_1', 'acf' ),
					'matches_n'            => _x( '%d results are available, use up and down arrow keys to navigate.', 'Select2 JS matches_n', 'acf' ),
					'matches_0'            => _x( 'No matches found', 'Select2 JS matches_0', 'acf' ),
					'input_too_short_1'    => _x( 'Please enter 1 or more characters', 'Select2 JS input_too_short_1', 'acf' ),
					'input_too_short_n'    => _x( 'Please enter %d or more characters', 'Select2 JS input_too_short_n', 'acf' ),
					'input_too_long_1'     => _x( 'Please delete 1 character', 'Select2 JS input_too_long_1', 'acf' ),
					'input_too_long_n'     => _x( 'Please delete %d characters', 'Select2 JS input_too_long_n', 'acf' ),
					'selection_too_long_1' => _x( 'You can only select 1 item', 'Select2 JS selection_too_long_1', 'acf' ),
					'selection_too_long_n' => _x( 'You can only select %d items', 'Select2 JS selection_too_long_n', 'acf' ),
					'load_more'            => _x( 'Loading more results&hellip;', 'Select2 JS load_more', 'acf' ),
					'searching'            => _x( 'Searching&hellip;', 'Select2 JS searching', 'acf' ),
					'load_fail'            => _x( 'Loading failed', 'Select2 JS load_fail', 'acf' ),
				),
			)
		);
	}

	/**
	 * Renders the field settings in the General tab.
	 *
	 * @param array $field The field array.
	 * @return void
	 */
	public function render_field_settings( $field ): void {
		$menus   = wp_get_nav_menus();
		$choices = array( '' => '— ' . __( 'Select a menu', 'wp-cinquante-et-un' ) . ' —' );

		foreach ( $menus as $menu ) {
			$choices[ (string) $menu->term_id ] = $menu->name;
		}

		acf_render_field_setting(
			$field,
			array(
				'label'        => __( 'Menu', 'wp-cinquante-et-un' ),
				'instructions' => __( 'Choose the menu from which to list items.', 'wp-cinquante-et-un' ),
				'name'         => 'menu',
				'type'         => 'select',
				'choices'      => $choices,
			)
		);

		acf_render_field_setting(
			$field,
			array(
				'label'        => __( 'Return Format', 'acf' ),
				'instructions' => __( 'Specify the value returned', 'acf' ),
				'type'         => 'radio',
				'name'         => 'return_format',
				'layout'       => 'horizontal',
				'choices'      => array(
					'value'  => __( 'Value', 'acf' ),
					'object' => __( 'Menu Item Object', 'wp-cinquante-et-un' ),
					'array'  => __( 'Both (Array)', 'acf' ),
				),
			)
		);
	}

	/**
	 * Renders the field settings in the Validation tab.
	 *
	 * @param array $field The field array.
	 * @return void
	 */
	public function render_field_validation_settings( $field ): void {
		acf_render_field_setting(
			$field,
			array(
				'label'        => __( 'Allow Null', 'acf' ),
				'instructions' => '',
				'name'         => 'allow_null',
				'type'         => 'true_false',
				'ui'           => 1,
			)
		);
	}

	/**
	 * Renders the field settings in the Presentation tab.
	 *
	 * @param array $field The field array.
	 * @return void
	 */
	public function render_field_presentation_settings( $field ): void {
		acf_render_field_setting(
			$field,
			array(
				'label'        => __( 'Stylized UI', 'acf' ),
				'instructions' => __( 'Use a stylized checkbox using select2', 'acf' ),
				'name'         => 'ui',
				'type'         => 'true_false',
				'ui'           => 1,
			)
		);

		acf_render_field_setting(
			$field,
			array(
				'label'        => __( 'Placeholder', 'acf' ),
				'instructions' => __( 'Appears within the input', 'acf' ),
				'type'         => 'text',
				'name'         => 'placeholder',
				'placeholder'  => _x( 'Select', 'verb', 'acf' ),
			)
		);
	}

	/**
	 * Prepares the field for display (default placeholder).
	 *
	 * @param array $field The field array.
	 * @return array
	 */
	public function prepare_field( $field ): array {
		if ( empty( $field['placeholder'] ) ) {
			$field['placeholder'] = _x( 'Select', 'verb', 'acf' );
		}
		return $field;
	}

	/**
	 * Loads the field: populates choices from the selected menu.
	 *
	 * @param array $field The field array.
	 * @return array
	 */
	public function load_field( $field ): array {
		$field['choices'] = array();

		if ( empty( $field['menu'] ) || ! is_numeric( $field['menu'] ) ) {
			return $field;
		}

		$items = wp_get_nav_menu_items( (int) $field['menu'] );

		if ( ! is_array( $items ) ) {
			return $field;
		}

		foreach ( $items as $item ) {
			if ( (int) $item->menu_item_parent !== 0 ) {
				continue;
			}
			$field['choices'][ (string) $item->ID ] = $item->title;
		}

		return $field;
	}

	/**
	 * Renders the field input using ACF's select input (same markup as native Select field).
	 *
	 * @param array $field The field array.
	 * @return void
	 */
	public function render_field( $field ): void {
		$value   = acf_get_array( $field['value'] );
		$choices = acf_get_array( $field['choices'] );

		if ( empty( $field['placeholder'] ) ) {
			$field['placeholder'] = _x( 'Select', 'verb', 'acf' );
		}

		if ( empty( $value ) ) {
			$value = array( '' );
		}

		if ( $field['allow_null'] ) {
			$choices = array( '' => "- {$field['placeholder']} -" ) + $choices;
		}

		$select = array(
			'id'               => $field['id'],
			'class'            => $field['class'],
			'name'             => $field['name'],
			'data-ui'          => $field['ui'],
			'data-multiple'    => 0,
			'data-placeholder' => $field['placeholder'],
			'data-allow_null'  => $field['allow_null'],
		);

		if ( ! empty( $field['aria-label'] ) ) {
			$select['aria-label'] = $field['aria-label'];
		}

		if ( ! empty( $field['readonly'] ) ) {
			$select['readonly'] = 'readonly';
		}
		if ( ! empty( $field['disabled'] ) ) {
			$select['disabled'] = 'disabled';
		}

		if ( $field['ui'] ) {
			acf_hidden_input(
				array(
					'id'   => $field['id'] . '-input',
					'name' => $field['name'],
				)
			);
		}

		$select['value']   = $value;
		$select['choices'] = $choices;

		acf_select_input( $select );
	}

	/**
	 * Load value: return scalar for single select (same as ACF Select).
	 *
	 * @param mixed $value   The value from the database.
	 * @param int   $post_id The post ID.
	 * @param array $field   The field array.
	 * @return mixed
	 */
	public function load_value( $value, $post_id, $field ) {
		return acf_unarray( $value );
	}

	/**
	 * Formats the value for use in templates.
	 *
	 * @param mixed $value   The value from the database.
	 * @param int   $post_id The post ID.
	 * @param array $field   The field array.
	 * @return mixed ID, WP_Post, array(id, title, url), or null.
	 */
	public function format_value( $value, $post_id, $field ) {
		if ( acf_is_empty( $value ) ) {
			return $field['allow_null'] ? null : $value;
		}

		$item_id = (int) $value;
		$item    = get_post( $item_id );

		if ( ! $item || 'nav_menu_item' !== $item->post_type ) {
			return $field['allow_null'] ? null : $value;
		}

		$url   = get_post_meta( $item_id, '_menu_item_url', true );
		$title = $item->post_title;

		if ( $field['return_format'] === 'value' ) {
			return $item_id;
		}

		if ( $field['return_format'] === 'array' ) {
			return array(
				'id'    => $item_id,
				'title' => $title,
				'url'   => $url,
			);
		}

		$item->url = $url;
		if ( empty( $item->post_title ) && $url ) {
			$item->post_title = $url;
		}
		return $item;
	}
}
