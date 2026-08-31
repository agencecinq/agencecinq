<?php
/**
 * ACF layout: KeyFigures
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

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
			'label'      => __( 'Key Figures', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_key_figures' ),
				...AcfFieldHelpers::media( $key . '_key_figures' ),
				array(
					'key'        => 'field_' . $key . '_key_figures_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_key_figures_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'           => 'field_' . $key . '_key_figures_content_layout',
							'label'         => __( 'Layout', 'agencecinq' ),
							'name'          => 'layout',
							'aria-label'    => __( 'Layout', 'agencecinq' ),
							'type'          => 'select',
							'choices'       => array(
								'full'   => __( 'Full', 'agencecinq' ),
								'column' => __( 'Column', 'agencecinq' ),
							),
							'default_value' => 'full',
							'return_format' => 'value',
						),
						array(
							'key'         => 'field_' . $key . '_key_figures_content_overline',
							'label'       => __( 'Overline', 'agencecinq' ),
							'name'        => 'overline',
							'aria-label'  => __( 'Overline', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'Enter the overline of the block', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_key_figures_content_title',
							'label'       => __( 'Title', 'agencecinq' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'Enter the title of the block', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_key_figures_content_text',
							'label'       => __( 'Text', 'agencecinq' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'agencecinq' ),
							'new_lines'   => 'br',
							'type'        => 'textarea',
							'rows'        => 4,
							'placeholder' => __( 'Enter the text of the block', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_key_figures_content_link',
							'label'       => __( 'Link', 'agencecinq' ),
							'name'        => 'link',
							'aria-label'  => __( 'Link', 'agencecinq' ),
							'type'        => 'link',
							'placeholder' => __( 'Enter the URL of the link', 'agencecinq' ),
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_key_figures_tab_figures',
					'label'      => __( 'Figures', 'agencecinq' ),
					'aria-label' => __( 'Figures', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_key_figures_items',
					'label'      => __( 'Items', 'agencecinq' ),
					'name'       => 'items',
					'aria-label' => __( 'Items', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'         => 'field_' . $key . '_key_figures_items_label',
							'label'       => __( 'Label', 'agencecinq' ),
							'name'        => 'label',
							'aria-label'  => __( 'Label', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'Enter the label of the figures', 'agencecinq' ),
						),
						array(
							'key'          => 'field_' . $key . '_key_figures_items_figures',
							'label'        => __( 'Figures', 'agencecinq' ),
							'name'         => 'figures',
							'aria-label'   => __( 'Figures', 'agencecinq' ),
							'type'         => 'repeater',
							'max'          => 4,
							'button_label' => __( 'Add Figure', 'agencecinq' ),
							'layout'       => 'block',
							'instructions' => __( 'Add up to 4 figures.', 'agencecinq' ),
							'sub_fields'   => array(
								array(
									'key'             => 'field_' . $key . '_key_figures_items_figures_overline',
									'label'           => __( 'Overline', 'agencecinq' ),
									'name'            => 'overline',
									'aria-label'      => __( 'Overline', 'agencecinq' ),
									'type'            => 'text',
									'placeholder'     => __( 'Enter the overline of the figure', 'agencecinq' ),
									'parent_repeater' => 'field_' . $key . '_key_figures_items_figures',
								),
								array(
									'key'             => 'field_' . $key . '_key_figures_items_figures_content',
									'label'           => __( 'Content', 'agencecinq' ),
									'name'            => 'content',
									'aria-label'      => __( 'Content', 'agencecinq' ),
									'type'            => 'group',
									'layout'          => 'block',
									'parent_repeater' => 'field_' . $key . '_key_figures_items_figures',
									'sub_fields'      => array(
										array(
											'key'         => 'field_' . $key . '_key_figures_items_figures_content_overline',
											'label'       => __( 'Overline', 'agencecinq' ),
											'name'        => 'overline',
											'aria-label'  => __( 'Overline', 'agencecinq' ),
											'type'        => 'text',
											'placeholder' => __( 'Enter the overline of the figure', 'agencecinq' ),
										),
										array(
											'key'         => 'field_' . $key . '_key_figures_items_figures_content_value',
											'label'       => __( 'Value', 'agencecinq' ),
											'name'        => 'value',
											'aria-label'  => __( 'Value', 'agencecinq' ),
											'type'        => 'number',
											'placeholder' => __( 'Enter the value of the figure', 'agencecinq' ),
											'wrapper'     => array(
												'width' => 8 * 100 / 12,
											),
										),
										array(
											'key'         => 'field_' . $key . '_key_figures_items_figures_content_unit',
											'label'       => __( 'Unit', 'agencecinq' ),
											'name'        => 'unit',
											'aria-label'  => __( 'Unit', 'agencecinq' ),
											'type'        => 'text',
											'placeholder' => __( 'Enter the unit of the figure', 'agencecinq' ),
											'default_value' => __( '%', 'agencecinq' ),
											'wrapper'     => array(
												'width' => 4 * 100 / 12,
											),
										),
										array(
											'key'         => 'field_' . $key . '_key_figures_items_figures_content_description',
											'label'       => __( 'Description', 'agencecinq' ),
											'name'        => 'description',
											'aria-label'  => __( 'Description', 'agencecinq' ),
											'type'        => 'textarea',
											'rows'        => 2,
											'new_lines'   => 'br',
											'placeholder' => __( 'Enter the description of the figure', 'agencecinq' ),
										),
									),
								),
								array(
									'key'             => 'field_' . $key . '_key_figures_items_figures_text',
									'label'           => __( 'Text', 'agencecinq' ),
									'name'            => 'text',
									'aria-label'      => __( 'Text', 'agencecinq' ),
									'type'            => 'text',
									'placeholder'     => __( 'Enter the text of the figure', 'agencecinq' ),
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
