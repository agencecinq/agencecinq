<?php
/**
 * Catalogue Choices
 *
 * Select choices built from the public catalogue, for the layouts that read it.
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields;

use AgenceCinq\Catalogue\Catalogue;

/**
 * Catalogue Choices
 *
 * Only built in the admin: the front only reads the saved values,
 * and a page without catalogue block must not wait for Central.
 */
class CatalogueChoices {

	/**
	 * Platforms, with the two known ones as a fallback when Central is unreachable.
	 *
	 * @return array<string, string>
	 */
	public static function platforms(): array {
		$choices = array(
			'shopify'   => 'Shopify',
			'wordpress' => 'WordPress',
		);

		foreach ( self::catalogue()?->platforms() ?? array() as $platform ) {
			$choices[ $platform['id'] ] = $platform['label'];
		}

		return $choices;
	}

	/**
	 * Package codes, labelled with their platform.
	 *
	 * @return array<string, string>
	 */
	public static function packages(): array {
		$choices = array();

		foreach ( self::catalogue()?->packages() ?? array() as $package ) {
			$choices[ $package['code'] ] = sprintf( '%s · %s', $package['category']['label'] ?? '', $package['name'] ?? '' );
		}

		return $choices;
	}

	/**
	 * Package ids, labelled with their platform, name and price, for a choice across platforms.
	 *
	 * @return array<string, string>
	 */
	public static function package_ids(): array {
		$choices = array();

		foreach ( self::catalogue()?->packages() ?? array() as $package ) {
			$choices[ $package['id'] ] = sprintf( '%s · %s · %s', $package['category']['label'] ?? '', $package['name'] ?? '', Catalogue::price( $package, true ) );
		}

		return $choices;
	}

	/**
	 * Retainer ids, labelled with their range and tier.
	 *
	 * @return array<string, string>
	 */
	public static function retainers(): array {
		$choices = array();

		foreach ( self::catalogue()?->retainers() ?? array() as $retainer ) {
			$choices[ $retainer['id'] ] = (string) ( $retainer['name'] ?? '' );
		}

		return $choices;
	}

	/**
	 * Module ids, labelled with their platform and price.
	 *
	 * @return array<string, string>
	 */
	public static function modules(): array {
		$choices = array();

		foreach ( self::catalogue()?->modules() ?? array() as $module ) {
			$choices[ $module['id'] ] = sprintf( '%s · %s · %s', $module['category']['label'] ?? '', $module['name'] ?? '', Catalogue::price( $module, true ) );
		}

		return $choices;
	}

	/**
	 * Packages (by code), retainers and modules (by id), grouped, for the featured card of a block.
	 *
	 * @return array<string, array<string, string>>
	 */
	public static function lines(): array {
		return array_filter(
			array(
				__( 'Packages', 'agencecinq' )  => self::packages(),
				__( 'Retainers', 'agencecinq' ) => self::retainers(),
				__( 'Modules', 'agencecinq' )   => self::modules(),
			)
		);
	}

	/**
	 * Price modes, for the prices typed in a block.
	 *
	 * @return array<string, string>
	 */
	public static function price_modes(): array {
		return array(
			Catalogue::FIRM  => __( 'Fixed price', 'agencecinq' ),
			Catalogue::FROM  => __( 'Starting price', 'agencecinq' ),
			Catalogue::QUOTE => __( 'On quote', 'agencecinq' ),
		);
	}

	/**
	 * The catalogue, in the admin only.
	 *
	 * @return Catalogue|null
	 */
	private static function catalogue(): ?Catalogue {
		return is_admin() ? Catalogue::instance() : null;
	}
}
