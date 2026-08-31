<?php
/**
 * ACF layout: MultiColumn
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

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
			'label'      => __( 'Multi Column', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_multi_column' ),
				AcfFieldHelpers::radius( $key . '_multi_column' ),
				array(
					'key'        => 'field_' . $key . '_multi_column_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_multi_column_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'           => 'field_' . $key . '_multi_column_content_title',
							'label'         => __( 'Title', 'agencecinq' ),
							'name'          => 'title',
							'aria-label'    => __( 'Title', 'agencecinq' ),
							'type'          => 'textarea',
							'rows'          => 2,
							'new_lines'     => 'br',
							'placeholder'   => __( 'Enter the title of the block', 'agencecinq' ),
							'default_value' => '',
						),
						array(
							'key'          => 'field_' . $key . '_multi_column_content_title_style',
							'label'        => __( 'Title Style', 'agencecinq' ),
							'name'         => 'title_style',
							'aria-label'   => __( 'Title Style', 'agencecinq' ),
							'instructions' => __( 'Visual style only; does not change the heading level.', 'agencecinq' ),
							'type'         => 'clone',
							'clone'        => array( 'field_clones_style' ),
							'layout'       => 'block',
							'display'      => 'seamless',
						),
						array(
							'key'        => 'field_' . $key . '_multi_column_content_text_alignment',
							'label'      => __( 'Text Alignment', 'agencecinq' ),
							'name'       => 'text_alignment',
							'aria-label' => __( 'Text Alignment', 'agencecinq' ),
							'type'       => 'clone',
							'clone'      => array( 'field_clones_text_alignment' ),
							'layout'     => 'block',
							'display'    => 'seamless',
						),
						array(
							'key'        => 'field_' . $key . '_multi_column_content_texts',
							'label'      => __( 'Texts', 'agencecinq' ),
							'name'       => 'texts',
							'aria-label' => __( 'Texts', 'agencecinq' ),
							'type'       => 'group',
							'layout'     => 'block',
							'sub_fields' => array(
								array(
									'key'         => 'field_' . $key . '_multi_column_content_texts_0',
									'label'       => __( 'First text', 'agencecinq' ),
									'name'        => 0,
									'aria-label'  => __( 'First text', 'agencecinq' ),
									'type'        => 'textarea',
									'rows'        => 4,
									'new_lines'   => 'br',
									'placeholder' => __( 'Enter the first text of the block', 'agencecinq' ),
									'wrapper'     => array(
										'width' => 6 * 100 / 12,
									),
								),
								array(
									'key'         => 'field_' . $key . '_multi_column_content_texts_1',
									'label'       => __( 'Second text', 'agencecinq' ),
									'name'        => 1,
									'aria-label'  => __( 'Second text', 'agencecinq' ),
									'type'        => 'textarea',
									'rows'        => 4,
									'new_lines'   => 'br',
									'placeholder' => __( 'Enter the second text of the block', 'agencecinq' ),
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
					'label'      => __( 'First Row', 'agencecinq' ),
					'name'       => 'first_row',
					'aria-label' => __( 'First Row', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_multi_column_first_row',
					'label'      => __( 'First Row', 'agencecinq' ),
					'name'       => 'first_row',
					'aria-label' => __( 'First Row', 'agencecinq' ),
					'type'       => 'group',
					'sub_fields' => array(
						array(
							'key'          => 'field_' . $key . '_multi_column_first_row_columns',
							'label'        => __( 'Columns', 'agencecinq' ),
							'name'         => 'columns',
							'aria-label'   => __( 'Columns', 'agencecinq' ),
							'type'         => 'repeater',
							'layout'       => 'block',
							'button_label' => __( 'Add Column', 'agencecinq' ),
							'max'          => 3,
							'sub_fields'   => array(
								array(
									'key'        => 'field_' . $key . '_multi_column_first_row_columns_image',
									'label'      => __( 'Image', 'agencecinq' ),
									'name'       => 'image',
									'aria-label' => __( 'Image', 'agencecinq' ),
									'type'       => 'image',
								),
								array(
									'key'          => 'field_' . $key . '_multi_column_first_row_columns_pins',
									'label'        => __( 'Pins', 'agencecinq' ),
									'name'         => 'pins',
									'aria-label'   => __( 'Pins', 'agencecinq' ),
									'type'         => 'repeater',
									'layout'       => 'block',
									'button_label' => __( 'Add Pin', 'agencecinq' ),
									'sub_fields'   => array(
										array(
											'key'         => 'field_' . $key . '_multi_column_first_row_columns_pins_title',
											'label'       => __( 'Title', 'agencecinq' ),
											'name'        => 'title',
											'aria-label'  => __( 'Title', 'agencecinq' ),
											'type'        => 'text',
											'placeholder' => __( 'Enter the title of the pin', 'agencecinq' ),
											'parent_repeater' => 'field_' . $key . '_multi_column_first_row_columns_pins',
										),
										array(
											'key'         => 'field_' . $key . '_multi_column_first_row_columns_pins_text',
											'label'       => __( 'Text', 'agencecinq' ),
											'name'        => 'text',
											'aria-label'  => __( 'Text', 'agencecinq' ),
											'type'        => 'textarea',
											'rows'        => 2,
											'new_lines'   => 'br',
											'placeholder' => __( 'Enter the text of the pin', 'agencecinq' ),
											'parent_repeater' => 'field_' . $key . '_multi_column_first_row_columns_pins',
										),
										array(
											'key'         => 'field_' . $key . '_multi_column_first_row_columns_pins_subtitle',
											'label'       => __( 'Subtitle', 'agencecinq' ),
											'name'        => 'subtitle',
											'aria-label'  => __( 'Subtitle', 'agencecinq' ),
											'type'        => 'text',
											'placeholder' => __( 'Enter the subtitle of the pin', 'agencecinq' ),
											'parent_repeater' => 'field_' . $key . '_multi_column_first_row_columns_pins',
										),
										array(
											'key'          => 'field_' . $key . '_multi_column_first_row_columns_pins_images',
											'label'        => __( 'Images', 'agencecinq' ),
											'name'         => 'images',
											'aria-label'   => __( 'Images', 'agencecinq' ),
											'type'         => 'gallery',
											'instructions' => __( 'Select or upload images.', 'agencecinq' ),
											'parent_repeater' => 'field_' . $key . '_multi_column_first_row_columns_pins',
										),
										array(
											'key'        => 'field_' . $key . '_multi_column_first_row_columns_pins_coordinates',
											'label'      => __( 'Coordinates', 'agencecinq' ),
											'name'       => 'coordinates',
											'aria-label' => __( 'Coordinates', 'agencecinq' ),
											'parent_repeater' => 'field_' . $key . '_multi_column_first_row_columns_pins',
											'type'       => 'group',
											'sub_fields' => array(
												array(
													'key'  => 'field_' . $key . '_multi_column_first_row_columns_pins_coordinates_top',
													'label' => __( 'Top', 'agencecinq' ),
													'name' => 'top',
													'aria-label' => __( 'Top', 'agencecinq' ),
													'type' => 'number',
													'min'  => 0,
													'max'  => 100,
													'step' => 0.01,
													'default_value' => 0,
													'append' => __( '%', 'agencecinq' ),
													'wrapper' => array(
														'width' => 6 * 100 / 12,
													),
												),
												array(
													'key'  => 'field_' . $key . '_multi_column_first_row_columns_pins_coordinates_left',
													'label' => __( 'Left', 'agencecinq' ),
													'name' => 'left',
													'aria-label' => __( 'Left', 'agencecinq' ),
													'type' => 'number',
													'min'  => 0,
													'step' => 0.01,
													'max'  => 100,
													'default_value' => 0,
													'append' => __( '%', 'agencecinq' ),
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
					'label'      => __( 'Second Row', 'agencecinq' ),
					'name'       => 'second_row',
					'aria-label' => __( 'Second Row', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_multi_column_second_row',
					'label'      => __( 'Second Row', 'agencecinq' ),
					'name'       => 'second_row',
					'aria-label' => __( 'Second Row', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'          => 'field_' . $key . '_multi_column_second_row_columns',
							'label'        => __( 'Columns', 'agencecinq' ),
							'name'         => 'columns',
							'aria-label'   => __( 'Columns', 'agencecinq' ),
							'type'         => 'repeater',
							'layout'       => 'block',
							'button_label' => __( 'Add Column', 'agencecinq' ),
							'max'          => 3,
							'sub_fields'   => array(
								array(
									'key'             => 'field_' . $key . '_multi_column_second_row_columns_image',
									'label'           => __( 'Image', 'agencecinq' ),
									'name'            => 'image',
									'aria-label'      => __( 'Image', 'agencecinq' ),
									'type'            => 'image',
									'parent_repeater' => 'field_' . $key . '_multi_column_second_row_columns',
								),
								array(
									'key'             => 'field_' . $key . '_multi_column_second_row_columns_title',
									'label'           => __( 'Title', 'agencecinq' ),
									'name'            => 'title',
									'aria-label'      => __( 'Title', 'agencecinq' ),
									'type'            => 'text',
									'placeholder'     => __( 'Enter the title of the column', 'agencecinq' ),
									'parent_repeater' => 'field_' . $key . '_multi_column_second_row_columns',
								),
								array(
									'key'             => 'field_' . $key . '_multi_column_second_row_columns_heading',
									'label'           => __( 'Heading', 'agencecinq' ),
									'name'            => 'heading',
									'aria-label'      => __( 'Heading', 'agencecinq' ),
									'type'            => 'clone',
									'clone'           => array( 'field_clones_heading' ),
									'layout'          => 'block',
									'display'         => 'seamless',
									'parent_repeater' => 'field_' . $key . '_multi_column_second_row_columns',
								),
								array(
									'key'             => 'field_' . $key . '_multi_column_second_row_columns_subtitle',
									'label'           => __( 'Subtitle', 'agencecinq' ),
									'name'            => 'subtitle',
									'aria-label'      => __( 'Subtitle', 'agencecinq' ),
									'type'            => 'text',
									'placeholder'     => __( 'Enter the subtitle of the column', 'agencecinq' ),
									'parent_repeater' => 'field_' . $key . '_multi_column_second_row_columns',
								),
								array(
									'key'             => 'field_' . $key . '_multi_column_second_row_columns_text',
									'label'           => __( 'Text', 'agencecinq' ),
									'name'            => 'text',
									'aria-label'      => __( 'Text', 'agencecinq' ),
									'type'            => 'textarea',
									'rows'            => 4,
									'new_lines'       => 'br',
									'placeholder'     => __( 'Enter the text of the column', 'agencecinq' ),
									'parent_repeater' => 'field_' . $key . '_multi_column_second_row_columns',
								),
								array(
									'key'             => 'field_' . $key . '_multi_column_second_row_columns_link',
									'label'           => __( 'Link', 'agencecinq' ),
									'name'            => 'link',
									'aria-label'      => __( 'Link', 'agencecinq' ),
									'type'            => 'link',
									'placeholder'     => __( 'Enter the link URL.', 'agencecinq' ),
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
