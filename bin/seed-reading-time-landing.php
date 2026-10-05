<?php
/**
 * Seed the CINQ Reading Time product landing page.
 *
 * Usage: wp eval-file bin/seed-reading-time-landing.php
 *
 * @package AgenceCinq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$github_url = 'https://github.com/agencecinq/cinq-wp-reading-time';
$slug       = 'cinq-wp-reading-time';

$existing = get_page_by_path( $slug );
if ( $existing instanceof WP_Post ) {
	$page_id = (int) $existing->ID;
	wp_update_post(
		array(
			'ID'          => $page_id,
			'post_title'  => 'CINQ Reading Time',
			'post_status' => 'publish',
		)
	);
} else {
	$page_id = wp_insert_post(
		array(
			'post_title'  => 'CINQ Reading Time',
			'post_name'   => $slug,
			'post_status' => 'publish',
			'post_type'   => 'page',
		),
		true
	);

	if ( is_wp_error( $page_id ) ) {
		WP_CLI::error( $page_id->get_error_message() );
	}
}

update_post_meta( $page_id, '_wp_page_template', 'page-templates/blocks-page.php' );
update_post_meta( $page_id, 'lock_content', '0' );

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

/**
 * Sideload (or refresh) a theme image, keyed by filename in _cinq_seed_source.
 *
 * @param string $filename Relative to src/img/product/.
 * @param int    $page_id  Parent page ID.
 * @param string $title    Attachment title.
 * @return int Attachment ID or 0.
 */
$seed_image = static function ( string $filename, int $page_id, string $title ): int {
	$path = get_stylesheet_directory() . '/src/img/product/' . $filename;

	if ( ! file_exists( $path ) ) {
		WP_CLI::warning( sprintf( 'Missing product image: %s', $filename ) );
		return 0;
	}

	$existing_attachment = get_posts(
		array(
			'post_type'      => 'attachment',
			'posts_per_page' => 1,
			'meta_key'       => '_cinq_seed_source',
			'meta_value'     => $filename,
			'fields'         => 'ids',
		)
	);

	if ( $existing_attachment ) {
		$attachment_id = (int) $existing_attachment[0];
		$attached_file = get_attached_file( $attachment_id );

		if ( $attached_file && copy( $path, $attached_file ) ) {
			wp_update_attachment_metadata(
				$attachment_id,
				wp_generate_attachment_metadata( $attachment_id, $attached_file )
			);
		}

		return $attachment_id;
	}

	$tmp = wp_tempnam( $filename );
	copy( $path, $tmp );

	$file_array = array(
		'name'     => $filename,
		'tmp_name' => $tmp,
	);

	$attachment_id = media_handle_sideload( $file_array, $page_id, $title );

	if ( is_wp_error( $attachment_id ) ) {
		WP_CLI::warning( $attachment_id->get_error_message() );
		return 0;
	}

	update_post_meta( $attachment_id, '_cinq_seed_source', $filename );

	return (int) $attachment_id;
};

$hero_image_id = $seed_image( 'hero-preview.png', $page_id, 'Aperçu CINQ Reading Time' );
$gallery_ids   = array_values(
	array_filter(
		array(
			$seed_image( 'format-editorial.png', $page_id, 'Exemple format carte éditoriale' ),
			$seed_image( 'format-header.png', $page_id, 'Exemple format en-tête d’article' ),
			$seed_image( 'format-list.png', $page_id, 'Exemple format liste de ressources' ),
		)
	)
);

$blocks = array(
	array(
		'acf_fc_layout' => 'page_hero',
		'content'       => array(
			'overline' => 'PLUGIN WORDPRESS · v1.1.0',
			'title'    => 'Le « petit article » qui dure 27 minutes ? Non merci.',
			'text'     => 'CINQ Reading Time annonce la couleur avant la première ligne. Une estimation simple, stockée avec le post, rendue comme vous voulez.',
			'links'    => array(
				'0' => array(
					'title'  => 'Installer le plugin',
					'url'    => $github_url,
					'target' => '_blank',
				),
				'1' => array(
					'title'  => 'Voir le dépôt',
					'url'    => $github_url,
					'target' => '_blank',
				),
			),
			'meta'     => array(
				array( 'text' => 'WordPress 6.0+' ),
				array( 'text' => 'PHP 8.1+' ),
				array( 'text' => 'MU-plugin ou classique' ),
				array( 'text' => 'Open source' ),
			),
		),
		'image'         => $hero_image_id ? $hero_image_id : '',
		'heading'       => 'h1',
		'layout'        => array(
			'paddings' => array(
				'top'    => 104,
				'bottom' => 80,
			),
		),
	),
	array(
		'acf_fc_layout' => 'editorial_cards',
		'content'       => array(
			'overline' => 'Avant / après',
			'title'    => 'Savoir combien de temps ça prend, avant de commencer.',
			'heading'  => 'h2',
			'text'     => 'Sans indication, le lecteur improvise. Avec CINQ Reading Time, il sait à quoi s’en tenir dès le titre.',
		),
		'cards'         => array(
			array(
				'overline'    => 'Avant',
				'title'       => 'On ouvre. On espère. On s’éternise.',
				'figure'      => '27 min',
				'flow_input'  => '',
				'flow_output' => '',
				'text'        => 'Aucune durée affichée. Le « petit article » révèle sa vraie longueur au troisième café.',
			),
			array(
				'overline'    => 'Après',
				'title'       => 'On lit le chiffre. Puis on lit l’article.',
				'figure'      => '4 min',
				'flow_input'  => '',
				'flow_output' => '',
				'text'        => 'La durée est là, avant la première ligne. Grâce à CINQ Reading Time, plus de surprise à mi-parcours.',
			),
		),
		'layout'        => array(
			'paddings' => array(
				'top'    => 120,
				'bottom' => 120,
			),
		),
	),
	array(
		'acf_fc_layout' => 'services',
		'content'       => array(
			'overline' => 'Trois temps',
			'title'    => 'Un calcul court, une donnée durable.',
			'heading'  => 'h2',
			'text'     => 'À chaque sauvegarde, l’estimation est recalculée. Si la méta manque, le plugin repart du contenu et ne vous laisse pas sans réponse.',
		),
		'items'         => array(
			array(
				'title' => 'Compter les mots',
				'text'  => 'Le contenu du post est nettoyé puis compté. Pas de détour, pas de dépendance.',
				'link'  => array(
					'title'  => 'Depuis post_content →',
					'url'    => $github_url . '#api',
					'target' => '_blank',
				),
			),
			array(
				'title' => 'Estimer à 200 mots/min',
				'text'  => 'La durée est arrondie au-dessus. Le rythme par défaut reste filtrable.',
				'link'  => array(
					'title'  => 'Valeur par défaut : 200 →',
					'url'    => $github_url . '#optional-filters',
					'target' => '_blank',
				),
			),
			array(
				'title' => 'Stocker le résultat',
				'text'  => 'La minute calculée rejoint une méta privée, prête à être relue partout.',
				'link'  => array(
					'title'  => '_cinq_reading_time →',
					'url'    => $github_url . '#api',
					'target' => '_blank',
				),
			),
		),
		'note'          => array(
			'icon'       => 'save',
			'label'      => 'save_post',
			'text'       => 'Recalcul automatique à chaque sauvegarde',
			'aside_icon' => 'refresh',
			'aside'      => 'Fallback sur',
			'aside_code' => 'post_content',
		),
		'layout'        => array(
			'paddings' => array(
				'top'    => 120,
				'bottom' => 120,
			),
		),
	),
	array(
		'acf_fc_layout' => 'gallery',
		'content'       => array(
			'overline' => 'Le thème garde la main',
			'title'    => 'Trois façons de dire « ça se lit vite ».',
			'heading'  => 'h2',
			'text'     => 'Carte éditoriale, en-tête d’article ou liste de ressources : la fonction livre la minute brute, votre design choisit le ton.',
		),
		'gallery'       => $gallery_ids,
		'layout'        => array(
			'paddings' => array(
				'top'    => 120,
				'bottom' => 120,
			),
		),
	),
	array(
		'acf_fc_layout' => 'stats',
		'content'       => array(
			'overline'    => 'Volontairement peu de choses',
			'title'       => 'Pas de cabine de pilotage pour afficher un nombre.',
			'heading'     => 'h2',
			'aside_label' => 'Périmètre par défaut',
			'aside_title' => 'post type: post',
			'aside_text'  => 'Élargissable proprement avec un filtre.',
			'items'       => array(
				array(
					'title' => '0 interface',
					'text'  => 'aucune page admin à maintenir',
				),
				array(
					'title' => '0 asset',
					'text'  => 'aucun CSS ni JavaScript envoyé sur le front-end',
				),
				array(
					'title' => 'PHP direct',
					'text'  => 'utilisation native sans shortcode',
				),
				array(
					'title' => '6.0+ / 8.1+',
					'text'  => 'WordPress et PHP, sans regarder dans le rétro',
				),
			),
		),
		'layout'        => array(
			'paddings' => array(
				'top'    => 120,
				'bottom' => 72,
			),
		),
	),
	array(
		'acf_fc_layout' => 'code_guide',
		'content'       => array(
			'badge'    => 'Par les dev, pour les dev',
			'overline' => 'API minuscule, effet utile',
			'title'    => 'Copier. Appeler. Formater.',
			'heading'  => 'h2',
			'text'     => 'Une fonction retourne un entier brut en minutes. Passez un ID, ou laissez WordPress utiliser le post courant.',
		),
		'aside'         => array(
			'label' => 'Contrat de sortie',
			'title' => 'integer',
			'text'  => '0 si vide · minimum 1 sinon',
		),
		'columns'       => array(
			array(
				'style'     => 'open',
				'index'     => '01',
				'overline'  => '',
				'title'     => 'Installer et appeler',
				'meta'      => '',
				'snippets'  => array(
					array(
						'language' => 'Terminal',
						'code'     => 'cp cinq-wp-reading-time.php /path/to/wp-content/mu-plugins/',
					),
					array(
						'language' => 'PHP',
						'code'     => "\$minutes = cinq_reading_time();\n\n\$minutes = cinq_reading_time( 42 );",
					),
				),
				'note'      => 'Fonctionne aussi comme plugin classique dans <span class="font-mono text-cream">wp-content/plugins/</span>.',
				'note_icon' => 'folder-git',
			),
			array(
				'style'     => 'open',
				'index'     => '02',
				'overline'  => '',
				'title'     => 'Rendre sans casser',
				'meta'      => '',
				'snippets'  => array(
					array(
						'language' => 'PHP',
						'code'     => "if ( function_exists( 'cinq_reading_time' ) ) {\n    \$minutes = cinq_reading_time();\n\n    if ( \$minutes > 0 ) {\n        printf( esc_html__( '%d min read', 'cinq-wp-reading-time' ), \$minutes );\n    }\n}",
					),
				),
				'note'      => 'Le thème vérifie la disponibilité de la fonction, récupère la minute, puis applique sa propre traduction et son propre balisage.',
				'note_icon' => '',
			),
		),
		'layout'        => array(
			'paddings' => array(
				'top'    => 120,
				'bottom' => 120,
			),
		),
	),
	array(
		'acf_fc_layout' => 'code_guide',
		'content'       => array(
			'badge'    => '',
			'overline' => 'Deux filtres, pas une usine',
			'title'    => 'Adapter le périmètre. Ajuster le rythme.',
			'heading'  => 'h2',
			'text'     => 'Le défaut reste raisonnable. Les projets qui en demandent plus disposent de deux crochets WordPress explicites.',
		),
		'aside'         => array(
			'label' => '',
			'title' => '',
			'text'  => '',
		),
		'columns'       => array(
			array(
				'style'     => 'framed',
				'index'     => '',
				'overline'  => 'Périmètre',
				'title'     => 'Ajouter les guides',
				'meta'      => 'défaut: post',
				'snippets'  => array(
					array(
						'language' => 'PHP',
						'code'     => "add_filter( 'cinq_reading_time_post_types', function () {\n    return array( 'post', 'guide' );\n} );",
					),
				),
				'note'      => 'Le calcul et la sauvegarde s’appliquent alors aux articles et au type personnalisé <span class="font-mono text-cream">guide</span>.',
				'note_icon' => '',
			),
			array(
				'style'     => 'framed',
				'index'     => '',
				'overline'  => 'Rythme',
				'title'     => 'Passer à 180 mots/min',
				'meta'      => 'défaut: 200',
				'snippets'  => array(
					array(
						'language' => 'PHP',
						'code'     => "add_filter( 'cinq_reading_time_wpm', function () {\n    return 180;\n} );",
					),
				),
				'note'      => 'Une cadence plus posée pour les contenus denses, sans modifier le plugin ni ajouter d’option en base.',
				'note_icon' => '',
			),
		),
		'layout'        => array(
			'paddings' => array(
				'top'    => 120,
				'bottom' => 120,
			),
		),
	),
	array(
		'acf_fc_layout' => 'info_cards',
		'content'       => array(
			'overline' => 'Les détails utiles',
			'title'    => 'Prévisible jusque dans les coins.',
			'heading'  => 'h2',
		),
		'items'         => array(
			array(
				'icon'  => 'database',
				'title' => 'Où vit la valeur ?',
				'text'  => 'Dans la méta privée _cinq_reading_time, attachée au post.',
			),
			array(
				'icon'  => 'rotate',
				'title' => 'Et si elle manque ?',
				'text'  => 'Le plugin recalcule depuis post_content au moment de la lecture.',
			),
			array(
				'icon'  => 'package-open',
				'title' => 'Comment l’installer ?',
				'text'  => 'En must-use plugin pour l’activer partout, ou comme plugin classique.',
			),
			array(
				'icon'  => 'panel-top-close',
				'title' => 'Où sont les options ?',
				'text'  => 'Nulle part. Pas d’UI admin, pas d’options, pas de shortcode.',
			),
		),
		'footer'        => array(
			'left'  => 'agencecinq/cinq-wp-reading-time',
			'right' => 'Current  -  v1.1.0',
		),
		'layout'        => array(
			'paddings' => array(
				'top'    => 96,
				'bottom' => 96,
			),
		),
	),
	array(
		'acf_fc_layout' => 'call_to_action',
		'content'       => array(
			'title'   => 'Oui, on a fait huit sections pour une fonction qui retourne un entier.',
			'heading' => 'h2',
			'text'    => 'Parce que la simplicité côté code ne dispense pas d’expliquer pourquoi elle existe. Si vous voulez le même soin sur un site entier, CINQ est là.',
			'link'    => array(
				'title'  => 'Réserver 20 minutes',
				'url'    => 'mailto:contact@agencecinq.com',
				'target' => '',
			),
		),
		'layout'        => array(
			'paddings' => array(
				'top'    => 168,
				'bottom' => 208,
			),
		),
	),
);

update_field( 'blocks', $blocks, $page_id );

WP_CLI::success(
	sprintf(
		'Landing ready: %s (ID %d) — hero #%d, gallery %s',
		get_permalink( $page_id ),
		$page_id,
		$hero_image_id,
		$gallery_ids ? implode( ',', $gallery_ids ) : 'none'
	)
);
