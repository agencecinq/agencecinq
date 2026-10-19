<?php
/**
 * ACF layout: Configurator
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;
use AgenceCinq\Plugins\ACF\IncludeFields\CatalogueChoices;

/**
 * Configurator block layout.
 *
 * The estimator: platform, package, modules, and the total. Offers and prices come
 * from Central; only the wording lives here.
 */
class Configurator {

	/**
	 * Returns the layout array for the Configurator block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		$prefix = 'field_' . $key . '_configurator';

		return array(
			'key'        => 'layout_' . $key . '_configurator',
			'name'       => 'configurator',
			'label'      => __( 'Configurator', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => $prefix . '_steps_tab',
					'label'      => __( 'Steps', 'agencecinq' ),
					'aria-label' => __( 'Steps', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => $prefix . '_steps',
					'label'      => __( 'Steps', 'agencecinq' ),
					'name'       => 'steps',
					'aria-label' => __( 'Steps', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						self::text( $prefix . '_steps', 'platform_title', __( 'Platform title', 'agencecinq' ), 'Votre plateforme' ),
						self::text( $prefix . '_steps', 'package_title', __( 'Package title', 'agencecinq' ), 'Votre socle' ),
						self::text( $prefix . '_steps', 'package_text', __( 'Package help', 'agencecinq' ), 'Le socle fixe le prix de base et le périmètre.' ),
						self::text( $prefix . '_steps', 'modules_title', __( 'Modules title', 'agencecinq' ), 'Vos modules' ),
						self::text(
							$prefix . '_steps',
							'modules_text',
							__( 'Modules help', 'agencecinq' ),
							'Les modules que le socle {package} accepte. Chaque prix s’ajoute tel quel, sans majoration ni plafond.',
							__( '{package} is replaced by the name of the chosen package.', 'agencecinq' )
						),
						self::text(
							$prefix . '_steps',
							'modules_empty',
							__( 'No modules', 'agencecinq' ),
							'Les modules de ce socle se choisissent avec nous, pendant l’appel.',
							__( 'Shown instead of the modules when Central lists none for the package yet.', 'agencecinq' )
						),
					),
				),
				array(
					'key'        => $prefix . '_result_tab',
					'label'      => __( 'Estimate', 'agencecinq' ),
					'aria-label' => __( 'Estimate', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => $prefix . '_result',
					'label'      => __( 'Estimate', 'agencecinq' ),
					'name'       => 'result',
					'aria-label' => __( 'Estimate', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						self::text( $prefix . '_result', 'title', __( 'Title', 'agencecinq' ), 'Votre estimation' ),
						self::text( $prefix . '_result', 'total_label', __( 'Total label', 'agencecinq' ), 'Total estimé, HT' ),
						self::text(
							$prefix . '_result',
							'firm_text',
							__( 'Firm price mention', 'agencecinq' ),
							'Prix ferme, périmètre écrit',
							__( 'Shown while every line has a firm price.', 'agencecinq' )
						),
						self::text(
							$prefix . '_result',
							'open_text',
							__( 'Open price mention', 'agencecinq' ),
							'Une partie se chiffre en rendez-vous',
							__( 'Shown when a line is « from » or « on quote »: the total is then a floor or a quote.', 'agencecinq' )
						),
						array(
							'key'           => $prefix . '_result_notice',
							'label'         => __( 'Notice', 'agencecinq' ),
							'name'          => 'notice',
							'aria-label'    => __( 'Notice', 'agencecinq' ),
							'type'          => 'textarea',
							'rows'          => 3,
							'new_lines'     => 'br',
							'default_value' => 'Ceci est une estimation, pas un devis. Le prix ferme est établi après le diagnostic, sur un périmètre écrit.',
						),
						self::text( $prefix . '_result', 'email_label', __( 'E-mail label', 'agencecinq' ), 'Votre e-mail' ),
						self::text( $prefix . '_result', 'email_placeholder', __( 'E-mail example', 'agencecinq' ), 'nom@entreprise.fr' ),
						self::text(
							$prefix . '_result',
							'email_error',
							__( 'E-mail error', 'agencecinq' ),
							'Cette adresse e-mail semble incomplète. Exemple : nom@entreprise.fr',
							__( 'Name the field and say how to fix it, with an example (RGAA 11.11).', 'agencecinq' )
						),
						self::text( $prefix . '_result', 'button_label', __( 'Button label', 'agencecinq' ), 'Recevoir mon estimation' ),
						array(
							'key'           => $prefix . '_result_privacy',
							'label'         => __( 'Privacy notice', 'agencecinq' ),
							'name'          => 'privacy',
							'aria-label'    => __( 'Privacy notice', 'agencecinq' ),
							'type'          => 'textarea',
							'rows'          => 3,
							'new_lines'     => '',
							'default_value' => 'Votre e-mail sert à vous envoyer cette estimation et à revenir vers vous au sujet de votre projet. Pas de newsletter, pas de revente. Conservé 3 ans, effacé sur simple demande.',
							'instructions'  => __( 'Followed by a link to the privacy policy page (Settings › Privacy). Say every use of the address: no checkbox is needed while it only serves this estimate and the follow-up on the project.', 'agencecinq' ),
						),
						array(
							'key'          => $prefix . '_result_page',
							'label'        => __( 'Booking page', 'agencecinq' ),
							'name'         => 'page',
							'aria-label'   => __( 'Booking page', 'agencecinq' ),
							'type'         => 'page_link',
							'post_type'    => array( 'page' ),
							'allow_null'   => 0,
							'instructions' => __( 'The page of the contact form, linked from the confirmation and the estimate mail. The composition is sent with it and appended, checked against the catalogue, to the mail the site receives.', 'agencecinq' ),
						),
					),
				),
				array(
					'key'        => $prefix . '_modal_tab',
					'label'      => __( 'Confirmation', 'agencecinq' ),
					'aria-label' => __( 'Confirmation', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'          => $prefix . '_modal',
					'label'        => __( 'Confirmation', 'agencecinq' ),
					'name'         => 'modal',
					'aria-label'   => __( 'Confirmation', 'agencecinq' ),
					'type'         => 'group',
					'layout'       => 'block',
					'instructions' => __( 'The dialog shown once the estimate is sent. In the message, {total} is the total and {email} the address typed.', 'agencecinq' ),
					'sub_fields'   => array(
						self::text( $prefix . '_modal', 'eyebrow', __( 'Eyebrow', 'agencecinq' ), 'Estimation envoyée' ),
						self::text( $prefix . '_modal', 'title', __( 'Title', 'agencecinq' ), 'C’est dans votre boîte mail.' ),
						array(
							'key'           => $prefix . '_modal_message',
							'label'         => __( 'Message', 'agencecinq' ),
							'name'          => 'message',
							'aria-label'    => __( 'Message', 'agencecinq' ),
							'type'          => 'textarea',
							'rows'          => 3,
							'new_lines'     => '',
							'default_value' => 'Votre estimation de {total} vient de partir à {email}. Gardez-la : elle reprend chaque ligne de votre configuration, c’est votre base de discussion.',
						),
						self::text( $prefix . '_modal', 'help', __( 'Help', 'agencecinq' ), 'Rien reçu d’ici 5 minutes ? Regardez dans les indésirables.' ),
						self::text( $prefix . '_modal', 'next_eyebrow', __( 'Next step eyebrow', 'agencecinq' ), 'La suite, si vous voulez' ),
						self::text( $prefix . '_modal', 'next_title', __( 'Next step title', 'agencecinq' ), '30 minutes, montre en main.' ),
						array(
							'key'           => $prefix . '_modal_next_text',
							'label'         => __( 'Next step text', 'agencecinq' ),
							'name'          => 'next_text',
							'aria-label'    => __( 'Next step text', 'agencecinq' ),
							'type'          => 'textarea',
							'rows'          => 3,
							'new_lines'     => '',
							'default_value' => 'On regarde votre site en direct, on vous dit si on est le bon interlocuteur, et on part de votre estimation : rien à réexpliquer.',
						),
						self::text( $prefix . '_modal', 'button_label', __( 'Button label', 'agencecinq' ), 'Réserver 30 minutes' ),
						self::text( $prefix . '_modal', 'note', __( 'Note', 'agencecinq' ), 'Pas de présentation d’agence : on parle de votre projet.' ),
					),
				),
				array(
					'key'        => $prefix . '_catalogue_tab',
					'label'      => __( 'Catalogue', 'agencecinq' ),
					'aria-label' => __( 'Catalogue', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => $prefix . '_catalogue',
					'label'      => __( 'Catalogue', 'agencecinq' ),
					'name'       => 'catalogue',
					'aria-label' => __( 'Catalogue', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'           => $prefix . '_catalogue_platform',
							'label'         => __( 'Platform selected on load', 'agencecinq' ),
							'name'          => 'platform',
							'aria-label'    => __( 'Platform selected on load', 'agencecinq' ),
							'type'          => 'select',
							'choices'       => CatalogueChoices::platforms(),
							'allow_null'    => 1,
							'return_format' => 'value',
							'wrapper'       => array( 'width' => 50 ),
						),
						array(
							'key'           => $prefix . '_catalogue_package',
							'label'         => __( 'Package selected on load', 'agencecinq' ),
							'name'          => 'package',
							'aria-label'    => __( 'Package selected on load', 'agencecinq' ),
							'type'          => 'select',
							'choices'       => CatalogueChoices::packages(),
							'allow_null'    => 1,
							'return_format' => 'value',
							'instructions'  => __( 'Defaults to the first package of the platform.', 'agencecinq' ),
							'wrapper'       => array( 'width' => 50 ),
						),
					),
				),
				...AcfFieldHelpers::settings( $key . '_configurator' ),
			),
		);
	}

	/**
	 * Text sub field with a default value.
	 *
	 * @param string $prefix        Parent field key.
	 * @param string $name          Field name.
	 * @param string $label         Field label.
	 * @param string $default_value Default text, the wording of the mockup.
	 * @param string $instructions  Optional instructions.
	 * @return array<string, mixed>
	 */
	private static function text( string $prefix, string $name, string $label, string $default_value, string $instructions = '' ): array {
		return array(
			'key'           => $prefix . '_' . $name,
			'label'         => $label,
			'name'          => $name,
			'aria-label'    => $label,
			'type'          => 'text',
			'default_value' => $default_value,
			'instructions'  => $instructions,
		);
	}
}
