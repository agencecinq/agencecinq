<?php
/**
 * ACF layout: Post grid
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Post grid block layout.
 */
class PostGrid {

	/**
	 * Returns the layout array for the Post grid block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_post_grid',
			'name'       => 'post_grid',
			'label'      => __( 'Post grid', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_post_grid_message',
					'label'      => __( 'Posts', 'agencecinq' ),
					'aria-label' => __( 'Posts', 'agencecinq' ),
					'type'       => 'message',
					'message'    => __( 'On the page for posts: the posts of the blog or of the category, as many per page as set in Settings › Reading, then the pagination. Elsewhere, the block shows nothing. Recommended paddings: 24px top, 104px bottom.', 'agencecinq' ),
				),
				...AcfFieldHelpers::settings( $key . '_post_grid' ),
			),
		);
	}
}
