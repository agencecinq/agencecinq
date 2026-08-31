<?php
/**
 * ACF layout: AccordionGroup
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * AccordionGroup block layout.
 */
class AccordionGroup {

	/**
	 * Returns the layout array for the AccordionGroup block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_accordion_group',
			'name'       => 'accordion_group',
			'label'      => __( 'Accordion Group', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				...AcfFieldHelpers::settings( $key . '_accordion_group' ),
				AcfFieldHelpers::radius( $key . '_accordion_group' ),
				array(
					'key'        => 'field_' . $key . '_accordion_group_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_accordion_group_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'           => 'field_' . $key . '_accordion_group_content_overline',
							'label'         => __( 'Overline', 'agencecinq' ),
							'name'          => 'overline',
							'aria-label'    => __( 'Overline', 'agencecinq' ),
							'type'          => 'text',
							'placeholder'   => __( 'Overline of the block', 'agencecinq' ),
							'instructions'  => __( 'Optional text shown above the main title.', 'agencecinq' ),
							'default_value' => '',
						),
						array(
							'key'           => 'field_' . $key . '_accordion_group_content_title',
							'label'         => __( 'Title', 'agencecinq' ),
							'name'          => 'title',
							'aria-label'    => __( 'Title', 'agencecinq' ),
							'type'          => 'text',
							'placeholder'   => __( 'Title of the block', 'agencecinq' ),
							'default_value' => '',
						),
						array(
							'key'        => 'field_' . $key . '_accordion_group_content_contact',
							'label'      => __( 'Contact', 'agencecinq' ),
							'name'       => 'contact',
							'aria-label' => __( 'Contact', 'agencecinq' ),
							'type'       => 'group',
							'layout'     => 'block',
							'sub_fields' => array(

								array(
									'key'           => 'field_' . $key . '_accordion_group_content_contact_image',
									'label'         => __( 'Image', 'agencecinq' ),
									'name'          => 'image',
									'aria-label'    => __( 'Image', 'agencecinq' ),
									'instructions'  => __( 'Select or upload an image.', 'agencecinq' ),
									'type'          => 'image',
									'return_format' => 'id',
								),
								array(
									'key'           => 'field_' . $key . '_accordion_group_content_contact_title',
									'label'         => __( 'Title', 'agencecinq' ),
									'name'          => 'title',
									'aria-label'    => __( 'Title', 'agencecinq' ),
									'type'          => 'text',
									'placeholder'   => __( 'Title of the contact', 'agencecinq' ),
									'instructions'  => __( 'Contact name or title.', 'agencecinq' ),
									'default_value' => '',
								),
								array(
									'key'           => 'field_' . $key . '_accordion_group_content_contact_text',
									'label'         => __( 'Text', 'agencecinq' ),
									'name'          => 'text',
									'aria-label'    => __( 'Text', 'agencecinq' ),
									'instructions'  => __( 'Short description or bio.', 'agencecinq' ),
									'default_value' => '',
									'placeholder'   => __( 'Text of the contact', 'agencecinq' ),
									'type'          => 'textarea',
									'rows'          => 2,
								),
								array(
									'key'          => 'field_' . $key . '_accordion_group_content_contact_link',
									'label'        => __( 'Link', 'agencecinq' ),
									'name'         => 'link',
									'aria-label'   => __( 'Link', 'agencecinq' ),
									'type'         => 'link',
									'instructions' => __( 'Enter the link URL.', 'agencecinq' ),
								),
							),
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_accordion_group_tab_accordions',
					'label'      => __( 'Accordions', 'agencecinq' ),
					'aria-label' => __( 'Accordions', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_accordion_group_accordions',
					'label'        => __( 'Accordions', 'agencecinq' ),
					'name'         => 'accordions',
					'aria-label'   => __( 'Accordions', 'agencecinq' ),
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'Add Accordion', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'           => 'field_' . $key . '_accordion_group_accordions_header',
							'label'         => __( 'Header', 'agencecinq' ),
							'name'          => 'header',
							'aria-label'    => __( 'Header', 'agencecinq' ),
							'type'          => 'text',
							'placeholder'   => __( 'Enter the title of the accordion', 'agencecinq' ),
							'default_value' => '',
						),
						array(
							'key'           => 'field_' . $key . '_accordion_group_accordions_content',
							'label'         => __( 'Content', 'agencecinq' ),
							'name'          => 'content',
							'aria-label'    => __( 'Content', 'agencecinq' ),
							'type'          => 'textarea',
							'new_lines'     => 'br',
							'rows'          => 4,
							'placeholder'   => __( 'Enter the content of the accordion', 'agencecinq' ),
							'default_value' => '',
						),
					),
				),
			),
		);
	}
}
