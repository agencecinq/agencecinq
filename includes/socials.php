<?php
/**
 * Socials configuration
 *
 * Useful to define social media links and sharing options.
 *
 * @package AgenceCinq
 */

return array(
	array(
		'id'          => 'facebook',
		'title'       => __( 'Facebook', 'agencecinq' ),
		'placeholder' => 'https://facebook.com/artvandelay',
		'description' => __( 'Enter the Facebook URL here.', 'agencecinq' ),
		'url'         => get_option( 'socials' )['facebook'] ?? '',
		'name'        => __( 'Share on Facebook', 'agencecinq' ),
		'color'       => '#1877f2',
		'link'        => 'https://www.facebook.com/sharer.php?u=',
	),
	array(
		'id'          => 'instagram',
		'title'       => __( 'Instagram', 'agencecinq' ),
		'placeholder' => 'https://instagram.com/artvandelay',
		'description' => __( 'Enter the Instagram URL here.', 'agencecinq' ),
		'url'         => get_option( 'socials' )['instagram'] ?? '',
		'color'       => '#405de6',
	),
	array(
		'id'          => 'linkedin',
		'title'       => __( 'LinkedIn', 'agencecinq' ),
		'placeholder' => 'https://linkedin.com/artvandelay',
		'description' => __( 'Enter the LinkedIn URL here.', 'agencecinq' ),
		'url'         => get_option( 'socials' )['linkedin'] ?? '',
		'name'        => __( 'Share on LinkedIn', 'agencecinq' ),
		'color'       => '#0a66c2',
		'link'        => 'https://www.linkedin.com/sharing/share-offsite/?url=',
	),
	array(
		'id'          => 'vimeo',
		'title'       => __( 'Vimeo', 'agencecinq' ),
		'placeholder' => 'https://vimeo.com/artvandelay',
		'description' => __( 'Enter the Vimeo URL here.', 'agencecinq' ),
		'url'         => get_option( 'socials' )['vimeo'] ?? '',
	),
	array(
		'id'          => 'x',
		'title'       => __( 'X (Twitter)', 'agencecinq' ),
		'placeholder' => 'https://x.com/artvandelay',
		'description' => __( 'Enter the X URL here.', 'agencecinq' ),
		'url'         => get_option( 'socials' )['x'] ?? '',
		'link'        => 'http://twitter.com/share?url=',
		'name'        => __( 'Share on X', 'agencecinq' ),
	),
	array(
		'id'          => 'youtube',
		'title'       => __( 'YouTube', 'agencecinq' ),
		'placeholder' => 'https://youtube.com/artvandelay',
		'description' => __( 'Enter the YouTube URL here.', 'agencecinq' ),
		'url'         => get_option( 'socials' )['youtube'] ?? '',
		'color'       => '#ff0000',
	),
);
