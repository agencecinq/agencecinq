<?php
/**
 * ACF layout: Price breakdown
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Price breakdown block layout.
 */
class PriceBreakdown {

	/**
	 * Returns the layout array for the Price breakdown block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_price_breakdown',
			'name'       => 'price_breakdown',
			'label'      => __( 'Price breakdown', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_price_breakdown_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_price_breakdown_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'        => 'field_' . $key . '_price_breakdown_content_eyebrow',
							'label'      => __( 'Eyebrow', 'agencecinq' ),
							'name'       => 'eyebrow',
							'aria-label' => __( 'Eyebrow', 'agencecinq' ),
							'type'       => 'text',
						),
						array(
							'key'         => 'field_' . $key . '_price_breakdown_content_title',
							'label'       => __( 'Title', 'agencecinq' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'agencecinq' ),
							'type'        => 'text',
							'required'    => 1,
							'placeholder' => __( 'WordPress redesign', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_price_breakdown_content_text',
							'label'       => __( 'Text', 'agencecinq' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'agencecinq' ),
							'type'        => 'textarea',
							'rows'        => 3,
							'new_lines'   => '',
							'placeholder' => __( 'Enter the lead text of the block', 'agencecinq' ),
						),
						array(
							'key'        => 'field_' . $key . '_price_breakdown_content_heading',
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
					'key'          => 'field_' . $key . '_price_breakdown_included',
					'label'        => __( 'Included', 'agencecinq' ),
					'name'         => 'included',
					'aria-label'   => __( 'Included', 'agencecinq' ),
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => __( 'Add Item', 'agencecinq' ),
					'instructions' => __( 'What the price includes, one point per row, with a decorative check.', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'             => 'field_' . $key . '_price_breakdown_included_text',
							'label'           => __( 'Text', 'agencecinq' ),
							'name'            => 'text',
							'aria-label'      => __( 'Text', 'agencecinq' ),
							'type'            => 'text',
							'parent_repeater' => 'field_' . $key . '_price_breakdown_included',
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_price_breakdown_tab_price',
					'label'      => __( 'Price', 'agencecinq' ),
					'aria-label' => __( 'Price', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'           => 'field_' . $key . '_price_breakdown_badge',
					'label'         => __( 'Badge', 'agencecinq' ),
					'name'          => 'badge',
					'aria-label'    => __( 'Badge', 'agencecinq' ),
					'type'          => 'text',
					'default_value' => __( 'Public prices', 'agencecinq' ),
				),
				array(
					'key'          => 'field_' . $key . '_price_breakdown_lines',
					'label'        => __( 'Lines', 'agencecinq' ),
					'name'         => 'lines',
					'aria-label'   => __( 'Lines', 'agencecinq' ),
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => __( 'Add Line', 'agencecinq' ),
					'min'          => 1,
					'instructions' => __( 'One price per row: what it covers, then the amount and the duration.', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'             => 'field_' . $key . '_price_breakdown_lines_label',
							'label'           => __( 'Label', 'agencecinq' ),
							'name'            => 'label',
							'aria-label'      => __( 'Label', 'agencecinq' ),
							'type'            => 'text',
							'required'        => 1,
							'parent_repeater' => 'field_' . $key . '_price_breakdown_lines',
						),
						array(
							'key'             => 'field_' . $key . '_price_breakdown_lines_value',
							'label'           => __( 'Value', 'agencecinq' ),
							'name'            => 'value',
							'aria-label'      => __( 'Value', 'agencecinq' ),
							'type'            => 'text',
							'required'        => 1,
							'parent_repeater' => 'field_' . $key . '_price_breakdown_lines',
						),
					),
				),
				array(
					'key'           => 'field_' . $key . '_price_breakdown_link',
					'label'         => __( 'Link', 'agencecinq' ),
					'name'          => 'link',
					'aria-label'    => __( 'Link', 'agencecinq' ),
					'type'          => 'link',
					'return_format' => 'array',
					'default_value' => array(
						'title'  => __( 'Book 30 minutes', 'agencecinq' ),
						'url'    => '',
						'target' => '',
					),
					'instructions'  => __( 'Primary CTA. Default label: Book 30 minutes. The diagnostic is never a first click.', 'agencecinq' ),
					'wrapper'       => array(
						'width' => 6 * 100 / 12,
					),
				),
				array(
					'key'         => 'field_' . $key . '_price_breakdown_detail',
					'label'       => __( 'Detail', 'agencecinq' ),
					'name'        => 'detail',
					'aria-label'  => __( 'Detail', 'agencecinq' ),
					'type'        => 'text',
					'placeholder' => __( 'The scope is negotiable, the price follows from it.', 'agencecinq' ),
					'wrapper'     => array(
						'width' => 6 * 100 / 12,
					),
				),
				...AcfFieldHelpers::settings( $key . '_price_breakdown' ),
			),
		);
	}
}
