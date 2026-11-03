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
 * Platforms, packages, modules and prices come from the catalogue: the block only holds its texts and the
 * choice checked on load.
 */
class Configurator {

	/**
	 * Returns the layout array for the Configurator block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks').
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
					'key'        => $prefix . '_tab_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				self::group(
					$prefix,
					'steps',
					__( 'Steps', 'agencecinq' ),
					array(
						self::text( $prefix . '_steps', 'platform_title', __( 'Platform title', 'agencecinq' ), __( 'Your platform', 'agencecinq' ) ),
						self::text( $prefix . '_steps', 'package_title', __( 'Package title', 'agencecinq' ), __( 'Your package', 'agencecinq' ) ),
						self::text( $prefix . '_steps', 'package_text', __( 'Package help', 'agencecinq' ), __( 'The package sets the base price and the scope.', 'agencecinq' ) ),
						self::text( $prefix . '_steps', 'modules_title', __( 'Modules title', 'agencecinq' ), __( 'Your modules', 'agencecinq' ) ),
						self::text( $prefix . '_steps', 'modules_text', __( 'Modules help', 'agencecinq' ), __( 'The modules your package accepts. Each price is added as is, with no markup and no cap.', 'agencecinq' ) ),
						self::text(
							$prefix . '_steps',
							'modules_empty',
							__( 'No modules', 'agencecinq' ),
							__( 'The modules of this package are chosen with us, during the call.', 'agencecinq' ),
							__( 'Shown instead of the modules when the catalogue lists none for the package.', 'agencecinq' )
						),
					)
				),
				array(
					'key'        => $prefix . '_tab_estimate',
					'label'      => __( 'Estimate', 'agencecinq' ),
					'aria-label' => __( 'Estimate', 'agencecinq' ),
					'type'       => 'tab',
				),
				self::group(
					$prefix,
					'estimate',
					__( 'Estimate', 'agencecinq' ),
					array(
						self::text( $prefix . '_estimate', 'title', __( 'Title', 'agencecinq' ), __( 'Your estimate', 'agencecinq' ) ),
						self::text( $prefix . '_estimate', 'total', __( 'Total label', 'agencecinq' ), __( 'Estimated total, excl. VAT', 'agencecinq' ) ),
						self::text(
							$prefix . '_estimate',
							'firm',
							__( 'Firm price mention', 'agencecinq' ),
							__( 'Firm price, written scope', 'agencecinq' ),
							__( 'Shown while every line has a firm price.', 'agencecinq' )
						),
						self::text(
							$prefix . '_estimate',
							'open',
							__( 'Open price mention', 'agencecinq' ),
							__( 'Some items are priced in a meeting', 'agencecinq' ),
							__( 'Shown when a line is « from » or « on quote »: the total is then a floor or a quote.', 'agencecinq' )
						),
						self::text( $prefix . '_estimate', 'email_label', __( 'E-mail label', 'agencecinq' ), __( 'Your e-mail', 'agencecinq' ) ),
						self::text( $prefix . '_estimate', 'email_placeholder', __( 'E-mail example', 'agencecinq' ), __( 'name@company.com', 'agencecinq' ) ),
						self::text(
							$prefix . '_estimate',
							'email_error',
							__( 'E-mail error', 'agencecinq' ),
							__( 'This e-mail address looks incomplete. Example: name@company.com', 'agencecinq' ),
							__( 'Name the field and say how to fix it, with an example (RGAA 11.11).', 'agencecinq' )
						),
						self::text( $prefix . '_estimate', 'button', __( 'Button label', 'agencecinq' ), __( 'Get my estimate', 'agencecinq' ) ),
						self::textarea(
							$prefix . '_estimate',
							'privacy',
							__( 'Privacy notice', 'agencecinq' ),
							__( 'Your e-mail is used to send you this estimate and to get back to you about your project. No newsletter, no resale. Kept for 3 years, deleted on request.', 'agencecinq' ),
							__( 'Followed by a link to the privacy policy page (Settings › Privacy). Say every use of the address: no checkbox is needed while it only serves this estimate and the follow-up on the project.', 'agencecinq' )
						),
						self::textarea(
							$prefix . '_estimate',
							'notice',
							__( 'Notice', 'agencecinq' ),
							__( 'This is an estimate, not a quote. The firm price is set after the diagnosis, on a written scope.', 'agencecinq' )
						),
					)
				),
				array(
					'key'        => $prefix . '_tab_confirmation',
					'label'      => __( 'Confirmation', 'agencecinq' ),
					'aria-label' => __( 'Confirmation', 'agencecinq' ),
					'type'       => 'tab',
				),
				self::group(
					$prefix,
					'confirmation',
					__( 'Confirmation', 'agencecinq' ),
					array(
						self::text( $prefix . '_confirmation', 'title', __( 'Title', 'agencecinq' ), __( 'It is in your inbox.', 'agencecinq' ) ),
						self::textarea(
							$prefix . '_confirmation',
							'message',
							__( 'Message', 'agencecinq' ),
							__( 'Your estimate of {total} has just been sent to {email}. Keep it: it lists every line of your configuration and is the basis of our discussion.', 'agencecinq' ),
							__( '{total} is replaced by the total, {email} by the address typed.', 'agencecinq' )
						),
						self::text( $prefix . '_confirmation', 'help', __( 'Help', 'agencecinq' ), __( 'Nothing within 5 minutes? Check your spam folder.', 'agencecinq' ) ),
						self::text( $prefix . '_confirmation', 'eyebrow', __( 'Next step eyebrow', 'agencecinq' ), __( 'What comes next, if you like', 'agencecinq' ) ),
						self::text( $prefix . '_confirmation', 'next_title', __( 'Next step title', 'agencecinq' ), __( '30 minutes, on the clock.', 'agencecinq' ) ),
						self::textarea(
							$prefix . '_confirmation',
							'next_text',
							__( 'Next step text', 'agencecinq' ),
							__( 'We look at your site live, tell you whether we are the right people for it, and start from your estimate: nothing to explain twice.', 'agencecinq' ),
							__( 'Followed by the booking link of the theme options (Contact).', 'agencecinq' )
						),
						self::text( $prefix . '_confirmation', 'note', __( 'Note', 'agencecinq' ), __( 'No agency pitch: we talk about your project.', 'agencecinq' ) ),
					)
				),
				array(
					'key'        => $prefix . '_tab_catalogue',
					'label'      => __( 'Catalogue', 'agencecinq' ),
					'aria-label' => __( 'Catalogue', 'agencecinq' ),
					'type'       => 'tab',
				),
				self::group(
					$prefix,
					'catalogue',
					__( 'Catalogue', 'agencecinq' ),
					array(
						array(
							'key'           => $prefix . '_catalogue_platform',
							'label'         => __( 'Platform checked on load', 'agencecinq' ),
							'name'          => 'platform',
							'aria-label'    => __( 'Platform checked on load', 'agencecinq' ),
							'type'          => 'select',
							'choices'       => CatalogueChoices::platforms(),
							'allow_null'    => 1,
							'return_format' => 'value',
							'instructions'  => __( 'Defaults to the first platform of the catalogue.', 'agencecinq' ),
							'wrapper'       => array( 'width' => 50 ),
						),
						array(
							'key'           => $prefix . '_catalogue_package',
							'label'         => __( 'Package checked on load', 'agencecinq' ),
							'name'          => 'package',
							'aria-label'    => __( 'Package checked on load', 'agencecinq' ),
							'type'          => 'select',
							'choices'       => CatalogueChoices::packages(),
							'allow_null'    => 1,
							'return_format' => 'value',
							'instructions'  => __( 'Defaults to the first package of the platform.', 'agencecinq' ),
							'wrapper'       => array( 'width' => 50 ),
						),
					)
				),
				...AcfFieldHelpers::settings( $key . '_configurator' ),
			),
		);
	}

	/**
	 * Group of sub fields.
	 *
	 * @param string                           $prefix     Layout field key.
	 * @param string                           $name       Group name.
	 * @param string                           $label      Group label.
	 * @param array<int, array<string, mixed>> $sub_fields Sub fields.
	 * @return array<string, mixed>
	 */
	private static function group( string $prefix, string $name, string $label, array $sub_fields ): array {
		return array(
			'key'        => $prefix . '_' . $name,
			'label'      => $label,
			'name'       => $name,
			'aria-label' => $label,
			'type'       => 'group',
			'layout'     => 'block',
			'sub_fields' => $sub_fields,
		);
	}

	/**
	 * Text sub field, its default value the wording of the mockup.
	 *
	 * @param string $prefix        Parent field key.
	 * @param string $name          Field name.
	 * @param string $label         Field label.
	 * @param string $default_value Default text.
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

	/**
	 * Textarea sub field without line breaks, its default value the wording of the mockup.
	 *
	 * @param string $prefix        Parent field key.
	 * @param string $name          Field name.
	 * @param string $label         Field label.
	 * @param string $default_value Default text.
	 * @param string $instructions  Optional instructions.
	 * @return array<string, mixed>
	 */
	private static function textarea( string $prefix, string $name, string $label, string $default_value, string $instructions = '' ): array {
		return array_merge(
			self::text( $prefix, $name, $label, $default_value, $instructions ),
			array(
				'type'      => 'textarea',
				'rows'      => 3,
				'new_lines' => '',
			)
		);
	}
}
