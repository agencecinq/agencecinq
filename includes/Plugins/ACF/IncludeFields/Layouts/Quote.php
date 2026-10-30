<?php
/**
 * ACF layout: Quote
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Quote block layout.
 */
class Quote {

	/**
	 * Returns the layout array for the Quote block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_quote',
			'name'       => 'quote',
			'label'      => __( 'Quote', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_quote_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_quote_content',
					'label'        => __( 'Content', 'agencecinq' ),
					'name'         => 'content',
					'aria-label'   => __( 'Content', 'agencecinq' ),
					'type'         => 'group',
					'layout'       => 'block',
					'instructions' => __( 'Usually in the Light scheme, to set the section apart.', 'agencecinq' ),
					'sub_fields'   => array(
						array(
							'key'          => 'field_' . $key . '_quote_content_quote',
							'label'        => __( 'Quote', 'agencecinq' ),
							'name'         => 'quote',
							'aria-label'   => __( 'Quote', 'agencecinq' ),
							'type'         => 'textarea',
							'rows'         => 2,
							'new_lines'    => '',
							'placeholder'  => __( 'It was not only the delivery of a new site, but a real understanding of our business.', 'agencecinq' ),
							'instructions' => __( 'Real client verbatim, one sentence, the most concrete. Do not add quotation marks: guillemets are rendered automatically.', 'agencecinq' ),
						),
						array(
							'key'          => 'field_' . $key . '_quote_content_name',
							'label'        => __( 'Name', 'agencecinq' ),
							'name'         => 'name',
							'aria-label'   => __( 'Name', 'agencecinq' ),
							'type'         => 'text',
							'required'     => 1,
							'placeholder'  => __( 'Camille Bertrand', 'agencecinq' ),
							'instructions' => __( 'First and last name. No anonymous quotes.', 'agencecinq' ),
							'wrapper'      => array(
								'width' => 4 * 100 / 12,
							),
						),
						array(
							'key'          => 'field_' . $key . '_quote_content_role',
							'label'        => __( 'Role', 'agencecinq' ),
							'name'         => 'role',
							'aria-label'   => __( 'Role', 'agencecinq' ),
							'type'         => 'text',
							'placeholder'  => __( 'E-commerce director', 'agencecinq' ),
							'instructions' => __( 'Optional. Check it with the client: a role changes.', 'agencecinq' ),
							'wrapper'      => array(
								'width' => 4 * 100 / 12,
							),
						),
						array(
							'key'         => 'field_' . $key . '_quote_content_company',
							'label'       => __( 'Company', 'agencecinq' ),
							'name'        => 'company',
							'aria-label'  => __( 'Company', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'L\'Arbre Vert', 'agencecinq' ),
							'wrapper'     => array(
								'width' => 4 * 100 / 12,
							),
						),
					),
				),
				...AcfFieldHelpers::settings( $key . '_quote' ),
			),
		);
	}
}
