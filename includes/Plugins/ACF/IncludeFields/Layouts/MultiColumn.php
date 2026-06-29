<?php
/**
 * ACF layout: MultiColumn
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn/Plugins/ACF/IncludeFields/Layouts
 */

namespace WPCinquanteEtUn\Plugins\ACF\IncludeFields\Layouts;

use WPCinquanteEtUn\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * MultiColumn block layout.
 */
class MultiColumn {

	/**
	 * Returns the layout array for the MultiColumn block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_multi_column',
			'name'       => 'multi_column',
			'label'      => __( 'Multi Column', 'wp-cinquante-et-un' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_multi_column' ),
				AcfFieldHelpers::radius( $key . '_multi_column' ),
				array(
					'key'        => 'field_' . $key . '_multi_column_tab_content',
					'label'      => __( 'Content', 'wp-cinquante-et-un' ),
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_multi_column_content',
					'label'      => __( 'Content', 'wp-cinquante-et-un' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'           => 'field_' . $key . '_multi_column_content_title',
							'label'         => __( 'Title', 'wp-cinquante-et-un' ),
							'name'          => 'title',
							'aria-label'    => __( 'Title', 'wp-cinquante-et-un' ),
							'type'          => 'textarea',
							'rows'          => 2,
							'new_lines'     => 'br',
							'placeholder'   => __( 'Enter the title of the block', 'wp-cinquante-et-un' ),
							'default_value' => '',
						),
						array(
							'key'          => 'field_' . $key . '_multi_column_content_title_style',
							'label'        => __( 'Title Style', 'wp-cinquante-et-un' ),
							'name'         => 'title_style',
							'aria-label'   => __( 'Title Style', 'wp-cinquante-et-un' ),
							'instructions' => __( 'Visual style only; does not change the heading level.', 'wp-cinquante-et-un' ),
							'type'         => 'clone',
							'clone'        => array( 'field_clones_style' ),
							'layout'       => 'block',
							'display'      => 'seamless',
						),
						array(
							'key'        => 'field_' . $key . '_multi_column_content_text_alignment',
							'label'      => __( 'Text Alignment', 'wp-cinquante-et-un' ),
							'name'       => 'text_alignment',
							'aria-label' => __( 'Text Alignment', 'wp-cinquante-et-un' ),
							'type'       => 'clone',
							'clone'      => array( 'field_clones_text_alignment' ),
							'layout'     => 'block',
							'display'    => 'seamless',
						),
						array(
							'key'        => 'field_' . $key . '_multi_column_content_texts',
							'label'      => __( 'Texts', 'wp-cinquante-et-un' ),
							'name'       => 'texts',
							'aria-label' => __( 'Texts', 'wp-cinquante-et-un' ),
							'type'       => 'group',
							'layout'     => 'block',
							'sub_fields' => array(
								array(
									'key'         => 'field_' . $key . '_multi_column_content_texts_0',
									'label'       => __( 'First text', 'wp-cinquante-et-un' ),
									'name'        => 0,
									'aria-label'  => __( 'First text', 'wp-cinquante-et-un' ),
									'type'        => 'textarea',
									'rows'        => 4,
									'new_lines'   => 'br',
									'placeholder' => __( 'Enter the first text of the block', 'wp-cinquante-et-un' ),
									'wrapper'     => array(
										'width' => 6 * 100 / 12,
									),
								),
								array(
									'key'         => 'field_' . $key . '_multi_column_content_texts_1',
									'label'       => __( 'Second text', 'wp-cinquante-et-un' ),
									'name'        => 1,
									'aria-label'  => __( 'Second text', 'wp-cinquante-et-un' ),
									'type'        => 'textarea',
									'rows'        => 4,
									'new_lines'   => 'br',
									'placeholder' => __( 'Enter the second text of the block', 'wp-cinquante-et-un' ),
									'wrapper'     => array(
										'width' => 6 * 100 / 12,
									),
								),
							),
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_multi_column_first_row_tab',
					'label'      => __( 'First Row', 'wp-cinquante-et-un' ),
					'name'       => 'first_row',
					'aria-label' => __( 'First Row', 'wp-cinquante-et-un' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_multi_column_first_row',
					'label'      => __( 'First Row', 'wp-cinquante-et-un' ),
					'name'       => 'first_row',
					'aria-label' => __( 'First Row', 'wp-cinquante-et-un' ),
					'type'       => 'group',
					'sub_fields' => array(
						array(
							'key'          => 'field_' . $key . '_multi_column_first_row_columns',
							'label'        => __( 'Columns', 'wp-cinquante-et-un' ),
							'name'         => 'columns',
							'aria-label'   => __( 'Columns', 'wp-cinquante-et-un' ),
							'type'         => 'repeater',
							'layout'       => 'block',
							'button_label' => __( 'Add Column', 'wp-cinquante-et-un' ),
							'max'          => 3,
							'sub_fields'   => array(
								array(
									'key'        => 'field_' . $key . '_multi_column_first_row_columns_image',
									'label'      => __( 'Image', 'wp-cinquante-et-un' ),
									'name'       => 'image',
									'aria-label' => __( 'Image', 'wp-cinquante-et-un' ),
									'type'       => 'image',
								),
								array(
									'key'          => 'field_' . $key . '_multi_column_first_row_columns_pins',
									'label'        => __( 'Pins', 'wp-cinquante-et-un' ),
									'name'         => 'pins',
									'aria-label'   => __( 'Pins', 'wp-cinquante-et-un' ),
									'type'         => 'repeater',
									'layout'       => 'block',
									'button_label' => __( 'Add Pin', 'wp-cinquante-et-un' ),
									'sub_fields'   => array(
										array(
											'key'         => 'field_' . $key . '_multi_column_first_row_columns_pins_title',
											'label'       => __( 'Title', 'wp-cinquante-et-un' ),
											'name'        => 'title',
											'aria-label'  => __( 'Title', 'wp-cinquante-et-un' ),
											'type'        => 'text',
											'placeholder' => __( 'Enter the title of the pin', 'wp-cinquante-et-un' ),
											'parent_repeater' => 'field_' . $key . '_multi_column_first_row_columns_pins',
										),
										array(
											'key'         => 'field_' . $key . '_multi_column_first_row_columns_pins_text',
											'label'       => __( 'Text', 'wp-cinquante-et-un' ),
											'name'        => 'text',
											'aria-label'  => __( 'Text', 'wp-cinquante-et-un' ),
											'type'        => 'textarea',
											'rows'        => 2,
											'new_lines'   => 'br',
											'placeholder' => __( 'Enter the text of the pin', 'wp-cinquante-et-un' ),
											'parent_repeater' => 'field_' . $key . '_multi_column_first_row_columns_pins',
										),
										array(
											'key'         => 'field_' . $key . '_multi_column_first_row_columns_pins_subtitle',
											'label'       => __( 'Subtitle', 'wp-cinquante-et-un' ),
											'name'        => 'subtitle',
											'aria-label'  => __( 'Subtitle', 'wp-cinquante-et-un' ),
											'type'        => 'text',
											'placeholder' => __( 'Enter the subtitle of the pin', 'wp-cinquante-et-un' ),
											'parent_repeater' => 'field_' . $key . '_multi_column_first_row_columns_pins',
										),
										array(
											'key'          => 'field_' . $key . '_multi_column_first_row_columns_pins_images',
											'label'        => __( 'Images', 'wp-cinquante-et-un' ),
											'name'         => 'images',
											'aria-label'   => __( 'Images', 'wp-cinquante-et-un' ),
											'type'         => 'gallery',
											'instructions' => __( 'Select or upload images.', 'wp-cinquante-et-un' ),
											'parent_repeater' => 'field_' . $key . '_multi_column_first_row_columns_pins',
										),
										array(
											'key'        => 'field_' . $key . '_multi_column_first_row_columns_pins_coordinates',
											'label'      => __( 'Coordinates', 'wp-cinquante-et-un' ),
											'name'       => 'coordinates',
											'aria-label' => __( 'Coordinates', 'wp-cinquante-et-un' ),
											'parent_repeater' => 'field_' . $key . '_multi_column_first_row_columns_pins',
											'type'       => 'group',
											'sub_fields' => array(
												array(
													'key'  => 'field_' . $key . '_multi_column_first_row_columns_pins_coordinates_top',
													'label' => __( 'Top', 'wp-cinquante-et-un' ),
													'name' => 'top',
													'aria-label' => __( 'Top', 'wp-cinquante-et-un' ),
													'type' => 'number',
													'min'  => 0,
													'max'  => 100,
													'step' => 0.01,
													'default_value' => 0,
													'append' => __( '%', 'wp-cinquante-et-un' ),
													'wrapper' => array(
														'width' => 6 * 100 / 12,
													),
												),
												array(
													'key'  => 'field_' . $key . '_multi_column_first_row_columns_pins_coordinates_left',
													'label' => __( 'Left', 'wp-cinquante-et-un' ),
													'name' => 'left',
													'aria-label' => __( 'Left', 'wp-cinquante-et-un' ),
													'type' => 'number',
													'min'  => 0,
													'step' => 0.01,
													'max'  => 100,
													'default_value' => 0,
													'append' => __( '%', 'wp-cinquante-et-un' ),
													'wrapper' => array(
														'width' => 6 * 100 / 12,
													),
												),
											),
										),
									),
								),
							),
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_multi_column_second_row_tab',
					'label'      => __( 'Second Row', 'wp-cinquante-et-un' ),
					'name'       => 'second_row',
					'aria-label' => __( 'Second Row', 'wp-cinquante-et-un' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_multi_column_second_row',
					'label'      => __( 'Second Row', 'wp-cinquante-et-un' ),
					'name'       => 'second_row',
					'aria-label' => __( 'Second Row', 'wp-cinquante-et-un' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'          => 'field_' . $key . '_multi_column_second_row_columns',
							'label'        => __( 'Columns', 'wp-cinquante-et-un' ),
							'name'         => 'columns',
							'aria-label'   => __( 'Columns', 'wp-cinquante-et-un' ),
							'type'         => 'repeater',
							'layout'       => 'block',
							'button_label' => __( 'Add Column', 'wp-cinquante-et-un' ),
							'max'          => 3,
							'sub_fields'   => array(
								array(
									'key'             => 'field_' . $key . '_multi_column_second_row_columns_image',
									'label'           => __( 'Image', 'wp-cinquante-et-un' ),
									'name'            => 'image',
									'aria-label'      => __( 'Image', 'wp-cinquante-et-un' ),
									'type'            => 'image',
									'parent_repeater' => 'field_' . $key . '_multi_column_second_row_columns',
								),
								array(
									'key'             => 'field_' . $key . '_multi_column_second_row_columns_title',
									'label'           => __( 'Title', 'wp-cinquante-et-un' ),
									'name'            => 'title',
									'aria-label'      => __( 'Title', 'wp-cinquante-et-un' ),
									'type'            => 'text',
									'placeholder'     => __( 'Enter the title of the column', 'wp-cinquante-et-un' ),
									'parent_repeater' => 'field_' . $key . '_multi_column_second_row_columns',
								),
								array(
									'key'             => 'field_' . $key . '_multi_column_second_row_columns_heading',
									'label'           => __( 'Heading', 'wp-cinquante-et-un' ),
									'name'            => 'heading',
									'aria-label'      => __( 'Heading', 'wp-cinquante-et-un' ),
									'type'            => 'clone',
									'clone'           => array( 'field_clones_heading' ),
									'layout'          => 'block',
									'display'         => 'seamless',
									'parent_repeater' => 'field_' . $key . '_multi_column_second_row_columns',
								),
								array(
									'key'             => 'field_' . $key . '_multi_column_second_row_columns_subtitle',
									'label'           => __( 'Subtitle', 'wp-cinquante-et-un' ),
									'name'            => 'subtitle',
									'aria-label'      => __( 'Subtitle', 'wp-cinquante-et-un' ),
									'type'            => 'text',
									'placeholder'     => __( 'Enter the subtitle of the column', 'wp-cinquante-et-un' ),
									'parent_repeater' => 'field_' . $key . '_multi_column_second_row_columns',
								),
								array(
									'key'             => 'field_' . $key . '_multi_column_second_row_columns_text',
									'label'           => __( 'Text', 'wp-cinquante-et-un' ),
									'name'            => 'text',
									'aria-label'      => __( 'Text', 'wp-cinquante-et-un' ),
									'type'            => 'textarea',
									'rows'            => 4,
									'new_lines'       => 'br',
									'placeholder'     => __( 'Enter the text of the column', 'wp-cinquante-et-un' ),
									'parent_repeater' => 'field_' . $key . '_multi_column_second_row_columns',
								),
								array(
									'key'             => 'field_' . $key . '_multi_column_second_row_columns_link',
									'label'           => __( 'Link', 'wp-cinquante-et-un' ),
									'name'            => 'link',
									'aria-label'      => __( 'Link', 'wp-cinquante-et-un' ),
									'type'            => 'link',
									'placeholder'     => __( 'Enter the link URL.', 'wp-cinquante-et-un' ),
									'parent_repeater' => 'field_' . $key . '_multi_column_second_row_columns',
								),
							),
						),
					),
				),
			),
		);
	}
}
