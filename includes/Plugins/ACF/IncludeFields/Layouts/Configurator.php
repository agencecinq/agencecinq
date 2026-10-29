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
						self::text( $prefix . '_steps', 'platform_title', __( 'Platform title', 'agencecinq' ), __( 'Your platform', 'agencecinq' ) ),
						self::text( $prefix . '_steps', 'package_title', __( 'Package title', 'agencecinq' ), __( 'Your package', 'agencecinq' ) ),
						self::text( $prefix . '_steps', 'package_text', __( 'Package help', 'agencecinq' ), __( 'The package sets the base price and the scope.', 'agencecinq' ) ),
						self::text( $prefix . '_steps', 'modules_title', __( 'Modules title', 'agencecinq' ), __( 'Your modules', 'agencecinq' ) ),
						self::text(
							$prefix . '_steps',
							'modules_text',
							__( 'Modules help', 'agencecinq' ),
							__( 'The modules the {package} package accepts. Each price is added as is, with no markup and no cap.', 'agencecinq' ),
							__( '{package} is replaced by the name of the chosen package.', 'agencecinq' )
						),
						self::text(
							$prefix . '_steps',
							'modules_empty',
							__( 'No modules', 'agencecinq' ),
							__( 'The modules of this package are chosen with us, during the call.', 'agencecinq' ),
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
						self::text( $prefix . '_result', 'title', __( 'Title', 'agencecinq' ), __( 'Your estimate', 'agencecinq' ) ),
						self::text( $prefix . '_result', 'total_label', __( 'Total label', 'agencecinq' ), __( 'Estimated total, excl. VAT', 'agencecinq' ) ),
						self::text(
							$prefix . '_result',
							'firm_text',
							__( 'Firm price mention', 'agencecinq' ),
							__( 'Firm price, written scope', 'agencecinq' ),
							__( 'Shown while every line has a firm price.', 'agencecinq' )
						),
						self::text(
							$prefix . '_result',
							'open_text',
							__( 'Open price mention', 'agencecinq' ),
							__( 'Some items are priced in a meeting', 'agencecinq' ),
							__( 'Shown when a line is “from” or “on request”: the total is then a floor or a quote.', 'agencecinq' )
						),
						array(
							'key'           => $prefix . '_result_notice',
							'label'         => __( 'Notice', 'agencecinq' ),
							'name'          => 'notice',
							'aria-label'    => __( 'Notice', 'agencecinq' ),
							'type'          => 'textarea',
							'rows'          => 3,
							'new_lines'     => 'br',
							'default_value' => __( 'This is an estimate, not a quote. The firm price is set after the diagnostic, on a written scope.', 'agencecinq' ),
						),
						self::text( $prefix . '_result', 'email_label', __( 'E-mail label', 'agencecinq' ), __( 'Your e-mail', 'agencecinq' ) ),
						self::text( $prefix . '_result', 'email_placeholder', __( 'E-mail example', 'agencecinq' ), __( 'name@company.com', 'agencecinq' ) ),
						self::text(
							$prefix . '_result',
							'email_error',
							__( 'E-mail error', 'agencecinq' ),
							__( 'This e-mail address looks incomplete. Example: name@company.com', 'agencecinq' ),
							__( 'Name the field and say how to fix it, with an example (RGAA 11.11).', 'agencecinq' )
						),
						self::text( $prefix . '_result', 'button_label', __( 'Button label', 'agencecinq' ), __( 'Get my estimate', 'agencecinq' ) ),
						array(
							'key'           => $prefix . '_result_privacy',
							'label'         => __( 'Privacy notice', 'agencecinq' ),
							'name'          => 'privacy',
							'aria-label'    => __( 'Privacy notice', 'agencecinq' ),
							'type'          => 'textarea',
							'rows'          => 3,
							'new_lines'     => '',
							'default_value' => __( 'Your e-mail is used to send you this estimate and to get back to you about your project. No newsletter, no resale. Kept for 3 years, deleted on request.', 'agencecinq' ),
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
						self::text( $prefix . '_modal', 'title', __( 'Title', 'agencecinq' ), __( 'It is in your inbox.', 'agencecinq' ) ),
						array(
							'key'           => $prefix . '_modal_message',
							'label'         => __( 'Message', 'agencecinq' ),
							'name'          => 'message',
							'aria-label'    => __( 'Message', 'agencecinq' ),
							'type'          => 'textarea',
							'rows'          => 3,
							'new_lines'     => '',
							'default_value' => __( 'Your estimate of {total} has just been sent to {email}. Keep it: it lists every line of your configuration and is the basis of our discussion.', 'agencecinq' ),
						),
						self::text( $prefix . '_modal', 'help', __( 'Help', 'agencecinq' ), __( 'Nothing within 5 minutes? Check your spam folder.', 'agencecinq' ) ),
						self::text( $prefix . '_modal', 'next_eyebrow', __( 'Next step eyebrow', 'agencecinq' ), __( 'What comes next, if you like', 'agencecinq' ) ),
						self::text( $prefix . '_modal', 'next_title', __( 'Next step title', 'agencecinq' ), __( '30 minutes, on the clock.', 'agencecinq' ) ),
						array(
							'key'           => $prefix . '_modal_next_text',
							'label'         => __( 'Next step text', 'agencecinq' ),
							'name'          => 'next_text',
							'aria-label'    => __( 'Next step text', 'agencecinq' ),
							'type'          => 'textarea',
							'rows'          => 3,
							'new_lines'     => '',
							'default_value' => __( 'We look at your site live, tell you whether we are the right people for it, and start from your estimate: nothing to explain twice.', 'agencecinq' ),
						),
						self::text( $prefix . '_modal', 'button_label', __( 'Button label', 'agencecinq' ), __( 'Book 30 minutes', 'agencecinq' ) ),
						self::text( $prefix . '_modal', 'note', __( 'Note', 'agencecinq' ), __( 'No agency pitch: we talk about your project.', 'agencecinq' ) ),
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
