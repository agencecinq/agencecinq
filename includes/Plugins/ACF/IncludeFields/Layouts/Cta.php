<?php
/**
 * ACF layout: CTA
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * CTA block layout.
 */
class Cta {

	/**
	 * Returns the layout array for the CTA block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_cta',
			'name'       => 'cta',
			'label'      => __( 'CTA', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_cta_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_cta_content',
					'label'        => __( 'Content', 'agencecinq' ),
					'name'         => 'content',
					'aria-label'   => __( 'Content', 'agencecinq' ),
					'type'         => 'group',
					'layout'       => 'block',
					'instructions' => __( 'Write the title and the text for the page: the same call everywhere reads as if the page had not changed. Recommended paddings: 136px top and bottom.', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'         => 'field_' . $key . '_cta_content_title',
							'label'       => __( 'Title', 'agencecinq' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'agencecinq' ),
							'type'        => 'text',
							'required'    => 1,
							'placeholder' => __( 'Let\'s start with 30 minutes.', 'agencecinq' ),
						),
						array(
							'key'         => 'field_' . $key . '_cta_content_text',
							'label'       => __( 'Text', 'agencecinq' ),
							'name'        => 'text',
							'aria-label'  => __( 'Text', 'agencecinq' ),
							'type'        => 'textarea',
							'rows'        => 3,
							'new_lines'   => '',
							'placeholder' => __( 'We look at your site live, tell you whether we are the right people for it, and give you an order of magnitude.', 'agencecinq' ),
						),
						array(
							'key'        => 'field_' . $key . '_cta_content_heading',
							'label'      => __( 'Heading', 'agencecinq' ),
							'name'       => 'heading',
							'aria-label' => __( 'Heading', 'agencecinq' ),
							'type'       => 'clone',
							'clone'      => array( 'field_clones_heading' ),
							'display'    => 'seamless',
							'layout'     => 'block',
						),
						array(
							'key'           => 'field_' . $key . '_cta_content_link',
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
							'key'           => 'field_' . $key . '_cta_content_detail',
							'label'         => __( 'Detail', 'agencecinq' ),
							'name'          => 'detail',
							'aria-label'    => __( 'Detail', 'agencecinq' ),
							'type'          => 'text',
							'default_value' => __( '30-minute video call · daytime slots, until 5 p.m.', 'agencecinq' ),
							'instructions'  => __( 'What the click leads to, under the button.', 'agencecinq' ),
							'wrapper'       => array(
								'width' => 6 * 100 / 12,
							),
						),
					),
				),
				...AcfFieldHelpers::settings( $key . '_cta' ),
			),
		);
	}
}
