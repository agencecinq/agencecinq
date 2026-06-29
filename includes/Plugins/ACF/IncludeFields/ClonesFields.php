<?php // phpcs:ignore
/**
 * Blocks Fields
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn
 */

namespace WPCinquanteEtUn\Plugins\ACF\IncludeFields;

use WPCinquanteEtUn\Service;

/**
 * Clones Fields
 */
class ClonesFields implements Service {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run(): void {
		add_action( 'acf/include_fields', array( $this, 'fields' ) );
	}

	/**
	 * Registers the field group.
	 *
	 * @return void
	 */
	public function fields() {
		$key            = 'clones';
		$hide_on_screen = array();
		$location       = array();

		$fields = array(
			array(
				'key'          => 'field_' . $key . '_layout',
				'label'        => __( 'Layout', 'wp-cinquante-et-un' ),
				'name'         => 'layout',
				'aria-label'   => __( 'Layout', 'wp-cinquante-et-un' ),
				'type'         => 'group',
				'instructions' => __( 'Layout settings for the block.', 'wp-cinquante-et-un' ),
				'layout'       => 'block',
				'sub_fields'   => array(
					array(
						'key'          => 'field_' . $key . '_layout_paddings',
						'label'        => __( 'Paddings', 'wp-cinquante-et-un' ),
						'name'         => 'paddings',
						'aria-label'   => __( 'Paddings', 'wp-cinquante-et-un' ),
						'type'         => 'group',
						'instructions' => __( 'Padding settings for the block on desktop. On mobile paddings are multiplied by 0.75.', 'wp-cinquante-et-un' ) . '<br>' . __( "Don't forget to add extra padding on blocks that precede or follow by a rounded block.", 'wp-cinquante-et-un' ),
						'layout'       => 'block',
						'sub_fields'   => array(
							array(
								'key'           => 'field_' . $key . '_layout_paddings_top',
								'label'         => __( 'Top', 'wp-cinquante-et-un' ),
								'name'          => 'top',
								'aria-label'    => __( 'Top', 'wp-cinquante-et-un' ),
								'type'          => 'number',
								'instructions'  => __( 'Top padding in pixels', 'wp-cinquante-et-un' ),
								'default_value' => 80,
								'min'           => 0,
								'step'          => 1,
								'append'        => __( 'px', 'wp-cinquante-et-un' ),
								'wrapper'       => array(
									'width' => 6 * 100 / 12,
								),
							),
							array(
								'key'           => 'field_' . $key . '_layout_paddings_bottom',
								'label'         => __( 'Bottom', 'wp-cinquante-et-un' ),
								'name'          => 'bottom',
								'aria-label'    => __( 'Bottom', 'wp-cinquante-et-un' ),
								'type'          => 'number',
								'instructions'  => __( 'Bottom padding in pixels', 'wp-cinquante-et-un' ),
								'default_value' => 80,
								'min'           => 0,
								'step'          => 1,
								'append'        => __( 'px', 'wp-cinquante-et-un' ),
								'wrapper'       => array(
									'width' => 6 * 100 / 12,
								),
							),
						),
					),
				),
			),
			array(
				'key'          => 'field_' . $key . '_media',
				'label'        => __( 'Media', 'wp-cinquante-et-un' ),
				'name'         => 'media',
				'aria-label'   => __( 'Media', 'wp-cinquante-et-un' ),
				'type'         => 'group',
				'instructions' => __( 'The video will take precedence over the image if both are filled.', 'wp-cinquante-et-un' ),
				'layout'       => 'block',
				'sub_fields'   => array(
					array(
						'key'          => 'field_' . $key . '_media_video',
						'label'        => __( 'Video', 'wp-cinquante-et-un' ),
						'name'         => 'video',
						'aria-label'   => __( 'Video', 'wp-cinquante-et-un' ),
						'type'         => 'group',
						'instructions' => '',
						'layout'       => 'block',
						'wrapper'      => array(
							'width' => 6 * 100 / 12,
						),
						'sub_fields'   => array(
							array(
								'key'           => 'field_' . $key . '_media_video_file',
								'label'         => __( 'File', 'wp-cinquante-et-un' ),
								'name'          => 'file',
								'aria-label'    => __( 'File', 'wp-cinquante-et-un' ),
								'type'          => 'file',
								'instructions'  => __( 'Supported formats: mp4, mpeg, avi, ogv, webm, and 3gp.', 'wp-cinquante-et-un' ),
								'return_format' => 'array',
								'library'       => 'all',
								'mime_types'    => 'mp4,mpeg,avi,ogv,webm,3gp',
							),
							array(
								'key'           => 'field_' . $key . '_media_video_poster',
								'label'         => __( 'Poster', 'wp-cinquante-et-un' ),
								'name'          => 'poster',
								'aria-label'    => __( 'Poster', 'wp-cinquante-et-un' ),
								'type'          => 'image',
								'instructions'  => __( 'Poster image for the video.', 'wp-cinquante-et-un' ),
								'return_format' => 'array',
								'library'       => 'all',
								'preview_size'  => 'medium',
							),
						),
					),
					array(
						'key'          => 'field_' . $key . '_media_images',
						'label'        => __( 'Image', 'wp-cinquante-et-un' ),
						'name'         => 'images',
						'aria-label'   => __( 'Image', 'wp-cinquante-et-un' ),
						'type'         => 'group',
						'instructions' => __( 'If only one image is provided, it will be used for both desktop and mobile whatever the screen size. If both desktop and mobile images are provided, the desktop image will be used for screens larger than 1024px and the mobile image for screens smaller than 1024px.', 'wp-cinquante-et-un' ),
						'layout'       => 'block',
						'wrapper'      => array(
							'width' => 6 * 100 / 12,
						),
						'sub_fields'   => array(
							array(
								'key'           => 'field_' . $key . '_media_images_0',
								'label'         => __( 'Mobile', 'wp-cinquante-et-un' ),
								'name'          => 0,
								'aria-label'    => __( 'Mobile', 'wp-cinquante-et-un' ),
								'type'          => 'image',
								'instructions'  => __( 'Mobile image for the block.', 'wp-cinquante-et-un' ),
								'return_format' => 'id',
								'library'       => 'all',
								'preview_size'  => 'medium',
							),
							array(
								'key'           => 'field_' . $key . '_media_images_1',
								'label'         => __( 'Desktop', 'wp-cinquante-et-un' ),
								'name'          => 1,
								'aria-label'    => __( 'Desktop', 'wp-cinquante-et-un' ),
								'type'          => 'image',
								'instructions'  => __( 'Desktop image for the block.', 'wp-cinquante-et-un' ),
								'return_format' => 'id',
								'library'       => 'all',
								'preview_size'  => 'medium',
							),
						),
					),
				),
			),
			array(
				'key'           => 'field_' . $key . '_heading',
				'label'         => __( 'Heading', 'wp-cinquante-et-un' ),
				'name'          => 'heading',
				'aria-label'    => __( 'Heading', 'wp-cinquante-et-un' ),
				'type'          => 'select',
				'instructions'  => __( 'Choose the heading level for the title of the block. It is important to use heading levels in a hierarchical way for accessibility and SEO reasons.', 'wp-cinquante-et-un' ),
				'choices'       => array(
					'h1' => __( 'H1', 'wp-cinquante-et-un' ),
					'h2' => __( 'H2', 'wp-cinquante-et-un' ),
					'h3' => __( 'H3', 'wp-cinquante-et-un' ),
				),
				'default_value' => 'h2',
				'return_format' => 'value',
			),
			array(
				'key'           => 'field_' . $key . '_style',
				'label'         => __( 'Title Style', 'wp-cinquante-et-un' ),
				'name'          => 'title_style',
				'aria-label'    => __( 'Title Style', 'wp-cinquante-et-un' ),
				'instructions'  => __( 'Visual style only; does not change the heading level.', 'wp-cinquante-et-un' ),
				'type'          => 'select',
				'choices'       => array(
					'h1' => __( 'H1', 'wp-cinquante-et-un' ),
					'h2' => __( 'H2', 'wp-cinquante-et-un' ),
					'h3' => __( 'H3', 'wp-cinquante-et-un' ),
					'h4' => __( 'H4', 'wp-cinquante-et-un' ),
					'h5' => __( 'H5', 'wp-cinquante-et-un' ),
				),
				'default_value' => 'h2',
				'return_format' => 'value',
			),
			array(
				'key'           => 'field_' . $key . '_text_alignment',
				'label'         => __( 'Text Alignment', 'wp-cinquante-et-un' ),
				'name'          => 'text_alignment',
				'aria-label'    => __( 'Text Alignment', 'wp-cinquante-et-un' ),
				'type'          => 'select',
				'instructions'  => __( 'Choose the text alignment for the block.', 'wp-cinquante-et-un' ),
				'choices'       => array(
					'text-left'   => __( 'Left', 'wp-cinquante-et-un' ),
					'text-center' => __( 'Center', 'wp-cinquante-et-un' ),
					'text-right'  => __( 'Right', 'wp-cinquante-et-un' ),
				),
				'default_value' => 'text-left',
				'return_format' => 'value',
			),
		);

		if ( function_exists( 'acf_add_local_field_group' ) ) {

			acf_add_local_field_group(
				array(
					'key'      => 'group_' . $key,
					'title'    => __( 'Clones Fields', 'wp-cinquante-et-un' ),
					'fields'   => $fields,
					'location' => $location,
					'active'   => false,
				)
			);

		}
	}
}
