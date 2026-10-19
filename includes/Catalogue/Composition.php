<?php
/**
 * Composition
 *
 * What a visitor chose in the configurator, as it travels between the browser and the server.
 *
 * @package WordPress
 * @subpackage AgenceCinq/Catalogue
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Catalogue;

/**
 * Composition.
 *
 * The browser only says what was chosen: « platform:code » for the package and module ids.
 * Everything else, prices first, is read again from the catalogue.
 */
class Composition {

	/**
	 * Checks a choice against the catalogue and prices it.
	 *
	 * @param string            $package « platform:code ».
	 * @param array<int, mixed> $modules Module ids.
	 * @return array{package: array<string, mixed>, modules: array<int, array<string, mixed>>, total: array{amount: float, mode: string}}|null
	 */
	public static function from_choice( string $package, array $modules ): ?array {
		$catalogue = Catalogue::instance();

		if ( null === $catalogue ) {
			return null;
		}

		[ $platform, $code ] = array_pad( explode( ':', $package, 2 ), 2, '' );

		return $catalogue->compose( $platform, $code, array_values( array_filter( array_map( 'strval', $modules ) ) ) );
	}

	/**
	 * Reads « platform:code;id,id ».
	 *
	 * @param string $value Encoded composition.
	 * @return array<string, mixed>|null
	 */
	public static function decode( string $value ): ?array {
		[ $package, $modules ] = array_pad( explode( ';', $value, 2 ), 2, '' );

		return self::from_choice( $package, explode( ',', $modules ) );
	}

	/**
	 * Writes a checked composition as « platform:code;id,id ».
	 *
	 * @param array<string, mixed> $composition Composition from Catalogue::compose().
	 * @return string
	 */
	public static function encode( array $composition ): string {
		return self::package_value( $composition ) . ';' . implode( ',', self::module_ids( $composition ) );
	}

	/**
	 * The package as the configurator form sends it: « platform:code ».
	 *
	 * @param array<string, mixed> $composition Composition from Catalogue::compose().
	 * @return string
	 */
	public static function package_value( array $composition ): string {
		$package = $composition['package'];

		return ( $package['category']['id'] ?? '' ) . ':' . ( $package['code'] ?? '' );
	}

	/**
	 * Ids of the modules kept.
	 *
	 * @param array<string, mixed> $composition Composition from Catalogue::compose().
	 * @return array<int, string>
	 */
	public static function module_ids( array $composition ): array {
		return array_column( $composition['modules'], 'id' );
	}

	/**
	 * Whether every line has a firm price, so the total is one too.
	 *
	 * @param array<string, mixed> $composition Composition from Catalogue::compose().
	 * @return bool
	 */
	public static function is_firm( array $composition ): bool {
		return Catalogue::FIRM === $composition['total']['mode'];
	}

	/**
	 * One line per offer, then the total.
	 *
	 * @param array<string, mixed> $composition Composition from Catalogue::compose().
	 * @return array<int, string>
	 */
	public static function lines( array $composition ): array {
		$package = $composition['package'];
		$lines   = array(
			sprintf( '%s · Socle %s : %s', $package['category']['label'] ?? '', $package['name'] ?? '', Catalogue::price( $package ) ),
		);

		foreach ( $composition['modules'] as $module ) {
			$lines[] = sprintf( '%s : %s', $module['name'] ?? '', Catalogue::price( $module ) );
		}

		$lines[] = sprintf( 'Total : %s', Catalogue::total_label( $composition['total'] ) );

		return $lines;
	}
}
