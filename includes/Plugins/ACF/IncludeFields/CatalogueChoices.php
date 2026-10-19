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
	 * The catalogue, in the admin only.
	 *
	 * @return Catalogue|null
	 */
	private static function catalogue(): ?Catalogue {
		return is_admin() ? Catalogue::instance() : null;
	}
}
