<?php
/**
 * ACF layout: KeyFigures
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn/Plugins/ACF/IncludeFields/Layouts
 */

namespace WPCinquanteEtUn\Plugins\ACF\IncludeFields\Layouts;

use WPCinquanteEtUn\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * KeyFigures block layout.
 */
class KeyFigures {

	/**
	 * Returns the layout array for the KeyFigures block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_key_figures',
			'name'       => 'key_figures',
			'label'      => __( 'Key Figures', 'wp-cinquante-et-un' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_key_figures' ),
				...AcfFieldHelpers::media( $key . '_key_figures' ),
				array(
					'key'        => 'field_' . $key . '_key_figures_tab_content',
					'label'      => __( 'Content', 'wp-cinquante-et-un' ),
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_key_figures_content',
					'label'      => __( 'Content', 'wp-cinquante-et-un' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'wp-cinquante-et-un' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'           => 'field_' . $key . '_key_figures_content_layout',
							'label'         => __( 'Layout', 'wp-cinquante-et-un' ),
							'name'          => 'layout',
							'aria-label'    => __( 'Layout', 'wp-cinquante-et-un' ),
							'type'          => 'select',
							'choices'       => array(
								'full'   => __( 'Full', 'wp-cinquante-et-un' ),
								'column' => __( 'Column', 'wp-cinquante-et-un' ),
							),
							'default_value' => 'full',
							'return_format' => 'value',
						),
						array(
							'key'         => 'field_' . $key . '_key_figures_content_overline',
							'label'       => __( 'Overline', 'wp-cinquante-et-un' ),
							'name'        => 'overline',
							'aria-label'  => __( 'Overline', 'wp-cinquante-et-un' ),
							'type'        => 'text',
							'placeholder' => __( 'Enter the overline of the block', 'wp-cinquante-et-un' ),
						),
						array(
							'key'         => 'field_' . $key . '_key_figures_content_title',
							'label'       => __( 'Title', 'wp-cinquante-et-un' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'wp-cinquante-et-un' ),
							'type'        => 'text',
							'placeholder' => __( 'Enter the title of the block', 'wp-cinquante-et-un' ),
						),
						array(
							'key'         => 'field_' . $key . '_key_figures_content_text',
							'label'       => __( 'Text', 'wp-cinquante-et-un' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'wp-cinquante-et-un' ),
							'new_lines'   => 'br',
							'type'        => 'textarea',
							'rows'        => 4,
							'placeholder' => __( 'Enter the text of the block', 'wp-cinquante-et-un' ),
						),
						array(
							'key'         => 'field_' . $key . '_key_figures_content_link',
							'label'       => __( 'Link', 'wp-cinquante-et-un' ),
							'name'        => 'link',
							'aria-label'  => __( 'Link', 'wp-cinquante-et-un' ),
							'type'        => 'link',
							'placeholder' => __( 'Enter the URL of the link', 'wp-cinquante-et-un' ),
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_key_figures_tab_figures',
					'label'      => __( 'Figures', 'wp-cinquante-et-un' ),
					'aria-label' => __( 'Figures', 'wp-cinquante-et-un' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_key_figures_items',
					'label'      => __( 'Items', 'wp-cinquante-et-un' ),
					'name'       => 'items',
					'aria-label' => __( 'Items', 'wp-cinquante-et-un' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'         => 'field_' . $key . '_key_figures_items_label',
							'label'       => __( 'Label', 'wp-cinquante-et-un' ),
							'name'        => 'label',
							'aria-label'  => __( 'Label', 'wp-cinquante-et-un' ),
							'type'        => 'text',
							'placeholder' => __( 'Enter the label of the figures', 'wp-cinquante-et-un' ),
						),
						array(
							'key'          => 'field_' . $key . '_key_figures_items_figures',
							'label'        => __( 'Figures', 'wp-cinquante-et-un' ),
							'name'         => 'figures',
							'aria-label'   => __( 'Figures', 'wp-cinquante-et-un' ),
							'type'         => 'repeater',
							'max'          => 4,
							'button_label' => __( 'Add Figure', 'wp-cinquante-et-un' ),
							'layout'       => 'block',
							'instructions' => __( 'Add up to 4 figures.', 'wp-cinquante-et-un' ),
							'sub_fields'   => array(
								array(
									'key'             => 'field_' . $key . '_key_figures_items_figures_overline',
									'label'           => __( 'Overline', 'wp-cinquante-et-un' ),
									'name'            => 'overline',
									'aria-label'      => __( 'Overline', 'wp-cinquante-et-un' ),
									'type'            => 'text',
									'placeholder'     => __( 'Enter the overline of the figure', 'wp-cinquante-et-un' ),
									'parent_repeater' => 'field_' . $key . '_key_figures_items_figures',
								),
								array(
									'key'             => 'field_' . $key . '_key_figures_items_figures_content',
									'label'           => __( 'Content', 'wp-cinquante-et-un' ),
									'name'            => 'content',
									'aria-label'      => __( 'Content', 'wp-cinquante-et-un' ),
									'type'            => 'group',
									'layout'          => 'block',
									'parent_repeater' => 'field_' . $key . '_key_figures_items_figures',
									'sub_fields'      => array(
										array(
											'key'         => 'field_' . $key . '_key_figures_items_figures_content_overline',
											'label'       => __( 'Overline', 'wp-cinquante-et-un' ),
											'name'        => 'overline',
											'aria-label'  => __( 'Overline', 'wp-cinquante-et-un' ),
											'type'        => 'text',
											'placeholder' => __( 'Enter the overline of the figure', 'wp-cinquante-et-un' ),
										),
										array(
											'key'         => 'field_' . $key . '_key_figures_items_figures_content_value',
											'label'       => __( 'Value', 'wp-cinquante-et-un' ),
											'name'        => 'value',
											'aria-label'  => __( 'Value', 'wp-cinquante-et-un' ),
											'type'        => 'number',
											'placeholder' => __( 'Enter the value of the figure', 'wp-cinquante-et-un' ),
											'wrapper'     => array(
												'width' => 8 * 100 / 12,
											),
										),
										array(
											'key'         => 'field_' . $key . '_key_figures_items_figures_content_unit',
											'label'       => __( 'Unit', 'wp-cinquante-et-un' ),
											'name'        => 'unit',
											'aria-label'  => __( 'Unit', 'wp-cinquante-et-un' ),
											'type'        => 'text',
											'placeholder' => __( 'Enter the unit of the figure', 'wp-cinquante-et-un' ),
											'default_value' => __( '%', 'wp-cinquante-et-un' ),
											'wrapper'     => array(
												'width' => 4 * 100 / 12,
											),
										),
										array(
											'key'         => 'field_' . $key . '_key_figures_items_figures_content_description',
											'label'       => __( 'Description', 'wp-cinquante-et-un' ),
											'name'        => 'description',
											'aria-label'  => __( 'Description', 'wp-cinquante-et-un' ),
											'type'        => 'textarea',
											'rows'        => 2,
											'new_lines'   => 'br',
											'placeholder' => __( 'Enter the description of the figure', 'wp-cinquante-et-un' ),
										),
									),
								),
								array(
									'key'             => 'field_' . $key . '_key_figures_items_figures_text',
									'label'           => __( 'Text', 'wp-cinquante-et-un' ),
									'name'            => 'text',
									'aria-label'      => __( 'Text', 'wp-cinquante-et-un' ),
									'type'            => 'text',
									'placeholder'     => __( 'Enter the text of the figure', 'wp-cinquante-et-un' ),
									'parent_repeater' => 'field_' . $key . '_key_figures_items_figures',
								),
							),
						),
					),
				),
			),
		);
	}
}
