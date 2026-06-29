<?php
/**
 * Socials configuration
 *
 * Useful to define social media links and sharing options.
 *
 * @package WPCinquanteEtUn
 */

return array(
	array(
		'id'          => 'facebook',
		'title'       => __( 'Facebook', 'wp-cinquante-et-un' ),
		'placeholder' => 'https://facebook.com/artvandelay',
		'description' => __( 'Enter the Facebook URL here.', 'wp-cinquante-et-un' ),
		'url'         => get_option( 'socials' )['facebook'] ?? '',
		'name'        => __( 'Share on Facebook', 'wp-cinquante-et-un' ),
		'color'       => '#1877f2',
		'link'        => 'https://www.facebook.com/sharer.php?u=',
	),
	array(
		'id'          => 'instagram',
		'title'       => __( 'Instagram', 'wp-cinquante-et-un' ),
		'placeholder' => 'https://instagram.com/artvandelay',
		'description' => __( 'Enter the Instagram URL here.', 'wp-cinquante-et-un' ),
		'url'         => get_option( 'socials' )['instagram'] ?? '',
		'color'       => '#405de6',
	),
	array(
		'id'          => 'linkedin',
		'title'       => __( 'LinkedIn', 'wp-cinquante-et-un' ),
		'placeholder' => 'https://linkedin.com/artvandelay',
		'description' => __( 'Enter the LinkedIn URL here.', 'wp-cinquante-et-un' ),
		'url'         => get_option( 'socials' )['linkedin'] ?? '',
		'name'        => __( 'Share on LinkedIn', 'wp-cinquante-et-un' ),
		'color'       => '#0a66c2',
		'link'        => 'https://www.linkedin.com/sharing/share-offsite/?url=',
	),
	array(
		'id'          => 'vimeo',
		'title'       => __( 'Vimeo', 'wp-cinquante-et-un' ),
		'placeholder' => 'https://vimeo.com/artvandelay',
		'description' => __( 'Enter the Vimeo URL here.', 'wp-cinquante-et-un' ),
		'url'         => get_option( 'socials' )['vimeo'] ?? '',
	),
	array(
		'id'          => 'x',
		'title'       => __( 'X (Twitter)', 'wp-cinquante-et-un' ),
		'placeholder' => 'https://x.com/artvandelay',
		'description' => __( 'Enter the X URL here.', 'wp-cinquante-et-un' ),
		'url'         => get_option( 'socials' )['x'] ?? '',
		'link'        => 'http://twitter.com/share?url=',
		'name'        => __( 'Share on X', 'wp-cinquante-et-un' ),
	),
	array(
		'id'          => 'youtube',
		'title'       => __( 'YouTube', 'wp-cinquante-et-un' ),
		'placeholder' => 'https://youtube.com/artvandelay',
		'description' => __( 'Enter the YouTube URL here.', 'wp-cinquante-et-un' ),
		'url'         => get_option( 'socials' )['youtube'] ?? '',
		'color'       => '#ff0000',
	),
);
