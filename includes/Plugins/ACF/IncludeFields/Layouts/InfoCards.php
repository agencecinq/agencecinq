<?php
/**
 * ACF layout: Info Cards
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Info Cards block layout.
 */
class InfoCards {

	/**
	 * Returns the layout array for the Info Cards block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_info_cards',
			'name'       => 'info_cards',
			'label'      => __( 'Info Cards', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_info_cards_content_tab',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_info_cards_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'   => 'field_' . $key . '_info_cards_content_overline',
							'label' => __( 'Overline', 'agencecinq' ),
							'name'  => 'overline',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_' . $key . '_info_cards_content_title',
							'label' => __( 'Title', 'agencecinq' ),
							'name'  => 'title',
							'type'  => 'text',
						),
						array(
							'key'     => 'field_' . $key . '_info_cards_content_heading',
							'label'   => __( 'Heading', 'agencecinq' ),
							'name'    => 'heading',
							'type'    => 'clone',
							'clone'   => array( 'field_clones_heading' ),
							'display' => 'seamless',
							'layout'  => 'block',
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_info_cards_items_tab',
					'label'      => __( 'Cards', 'agencecinq' ),
					'aria-label' => __( 'Cards', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_info_cards_items',
					'label'        => __( 'Cards', 'agencecinq' ),
					'name'         => 'items',
					'type'         => 'repeater',
					'layout'       => 'block',
					'min'          => 1,
					'max'          => 4,
					'button_label' => __( 'Add Card', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'             => 'field_' . $key . '_info_cards_items_icon',
							'label'           => __( 'Icon', 'agencecinq' ),
							'name'            => 'icon',
							'type'            => 'text',
							'instructions'    => __( 'Sprite icon name, e.g. database.', 'agencecinq' ),
							'parent_repeater' => 'field_' . $key . '_info_cards_items',
						),
						array(
							'key'             => 'field_' . $key . '_info_cards_items_title',
							'label'           => __( 'Title', 'agencecinq' ),
							'name'            => 'title',
							'type'            => 'text',
							'parent_repeater' => 'field_' . $key . '_info_cards_items',
						),
						array(
							'key'             => 'field_' . $key . '_info_cards_items_text',
							'label'           => __( 'Text', 'agencecinq' ),
							'name'            => 'text',
							'type'            => 'textarea',
							'rows'            => 3,
							'new_lines'       => 'br',
							'parent_repeater' => 'field_' . $key . '_info_cards_items',
						),
					),
				),
				array(
					'key'        => 'field_' . $key . '_info_cards_footer_tab',
					'label'      => __( 'Footer', 'agencecinq' ),
					'aria-label' => __( 'Footer', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_info_cards_footer',
					'label'      => __( 'Footer', 'agencecinq' ),
					'name'       => 'footer',
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'   => 'field_' . $key . '_info_cards_footer_left',
							'label' => __( 'Left', 'agencecinq' ),
							'name'  => 'left',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_' . $key . '_info_cards_footer_right',
							'label' => __( 'Right', 'agencecinq' ),
							'name'  => 'right',
							'type'  => 'text',
						),
					),
				),
				...AcfFieldHelpers::settings( $key . '_info_cards' ),
			),
		);
	}
}
