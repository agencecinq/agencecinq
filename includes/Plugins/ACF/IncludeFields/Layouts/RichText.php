<?php
/**
 * ACF layout: Rich text
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Rich text block layout.
 */
class RichText {

	/**
	 * Returns the layout array for the Rich text block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_rich_text',
			'name'       => 'rich_text',
			'label'      => __( 'Rich text', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_rich_text_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => 'field_' . $key . '_rich_text_text',
					'label'        => __( 'Text', 'agencecinq' ),
					'name'         => 'text',
					'aria-label'   => __( 'Text', 'agencecinq' ),
					'type'         => 'wysiwyg',
					'tabs'         => 'all',
					'toolbar'      => 'full',
					'media_upload' => 0,
					'instructions' => __( 'Reading column of 720 px. Subtitles in Heading 2, then Heading 3, without skipping a level. A quote in Blockquote, code in Preformatted.', 'agencecinq' ),
				),
				...AcfFieldHelpers::settings( $key . '_rich_text' ),
			),
		);
	}
}
