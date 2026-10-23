<?php
/**
 * Catalogue
 *
 * Read model and pricing rules of the public catalogue (catalogue.v2).
 *
 * @see https://github.com/agencecinq/central-v3/blob/main/docs/api-catalogue-public.md
 *
 * @package WordPress
 * @subpackage AgenceCinq/Catalogue
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Catalogue;

/**
 * Catalogue.
 *
 * Amounts are in euros excluding VAT. A null price is never shown as 0 €.
 * Labels and amounts follow the language of the site.
 */
class Catalogue {

	/**
	 * Price modes.
	 */
	public const FIRM  = 'ferme';
	public const FROM  = 'a_partir_de';
	public const QUOTE = 'sur_devis';

	/**
	 * Memoized instance for the request.
	 *
	 * @var self|null|false False until the first call.
	 */
	private static $instance = false;

	/**
	 * Raw payload.
	 *
	 * @var array<string, mixed>
	 */
	private array $data;

	/**
	 * Constructor.
	 *
	 * @param array<string, mixed> $data Payload of the root route.
	 */
	public function __construct( array $data ) {
		$this->data = $data;
	}

	/**
	 * Returns the catalogue for this request, or null when it is unavailable.
	 *
	 * @return self|null
	 */
	public static function instance(): ?self {
		if ( false === self::$instance ) {
			$data           = Client::get();
			self::$instance = null !== $data ? new self( $data ) : null;
		}

		return self::$instance;
	}

	/**
	 * Platforms with at least one published offer.
	 *
	 * @return array<int, array{id: string, label: string}>
	 */
	public function platforms(): array {
		return $this->list( 'platforms' );
	}

	/**
	 * Label of a platform, the id itself when unknown.
	 *
	 * @param string $id Platform id.
	 * @return string
	 */
	public function platform_label( string $id ): string {
		foreach ( $this->platforms() as $platform ) {
			if ( $platform['id'] === $id ) {
				return $platform['label'];
			}
		}

		return $id;
	}

	/**
	 * Packages (socles), in the order of the API.
	 *
	 * @param string|null $platform Platform id, null for all.
	 * @return array<int, array<string, mixed>>
	 */
	public function packages( ?string $platform = null ): array {
		return $this->on_platform( $this->list( 'packages' ), $platform );
	}

	/**
	 * A package by platform and code (codes are unique per platform only).
	 *
	 * @param string $platform Platform id.
	 * @param string $code     Package code.
	 * @return array<string, mixed>|null
	 */
	public function package( string $platform, string $code ): ?array {
		foreach ( $this->packages( $platform ) as $package ) {
			if ( ( $package['code'] ?? '' ) === $code ) {
				return $package;
			}
		}

		return null;
	}

	/**
	 * Modules, in the order of the API.
	 *
	 * @param string|null $platform Platform id, null for all.
	 * @return array<int, array<string, mixed>>
	 */
	public function modules( ?string $platform = null ): array {
		return $this->on_platform( $this->list( 'modules' ), $platform );
	}

	/**
	 * Modules a package accepts. The package decides, through its moduleIds.
	 * An empty list means « not filled in yet », not « accepts nothing ».
	 *
	 * @param array<string, mixed> $package Package.
	 * @return array<int, array<string, mixed>>
	 */
	public function modules_for( array $package ): array {
		$ids = (array) ( $package['moduleIds'] ?? array() );

		return array_values(
			array_filter(
				$this->modules(),
				static fn( array $module ): bool => in_array( $module['id'] ?? '', $ids, true )
			)
		);
	}

	/**
	 * Retainers (accompagnement), in the order of the API.
	 *
	 * @param string|null $platform Platform id, null for all.
	 * @return array<int, array<string, mixed>>
	 */
	public function retainers( ?string $platform = null ): array {
		return $this->on_platform( $this->list( 'retainers' ), $platform );
	}

	/**
	 * Price of an ad hoc day, outside any contract.
	 *
	 * @return float|null
	 */
	public function ad_hoc_day_rate(): ?float {
		$rate = $this->data['adHocDayRateExclVat'] ?? null;

		return is_numeric( $rate ) ? (float) $rate : null;
	}

	/**
	 * Checks a composition against the catalogue and prices it.
	 * Modules the package does not accept are dropped: the browser is never trusted.
	 *
	 * @param string            $platform   Platform id.
	 * @param string            $code       Package code.
	 * @param array<int, mixed> $module_ids Module ids.
	 * @return array{package: array<string, mixed>, modules: array<int, array<string, mixed>>, total: array{amount: float, mode: string}}|null
	 */
	public function compose( string $platform, string $code, array $module_ids ): ?array {
		$package = $this->package( $platform, $code );

		if ( null === $package ) {
			return null;
		}

		$module_ids = array_map( 'strval', $module_ids );
		$modules    = array_values(
			array_filter(
				$this->modules_for( $package ),
				static fn( array $module ): bool => in_array( $module['id'], $module_ids, true )
			)
		);

		return array(
			'package' => $package,
			'modules' => $modules,
			'total'   => self::total( array( $package, ...$modules ) ),
		);
	}

	/**
	 * Total of a composition: the sum of the prices, nothing else.
	 * No project management line, no percentage, no cap on the number of modules.
	 * One line « from » makes the total a floor; one line « on quote » makes it a quote.
	 *
	 * @param array<int, array<string, mixed>> $lines Packages and modules.
	 * @return array{amount: float, mode: string}
	 */
	public static function total( array $lines ): array {
		$amount = 0.0;
		$mode   = self::FIRM;

		foreach ( $lines as $line ) {
			$price     = $line['priceExclVat'] ?? null;
			$line_mode = self::mode( $line );

			if ( self::QUOTE === $line_mode || null === $price ) {
				$mode = self::QUOTE;
				continue;
			}

			$amount += (float) $price;

			if ( self::FROM === $line_mode && self::FIRM === $mode ) {
				$mode = self::FROM;
			}
		}

		return array(
			'amount' => $amount,
			'mode'   => $mode,
		);
	}

	/**
	 * Price mode of a line.
	 *
	 * @param array<string, mixed> $line Package, module or retainer.
	 * @return string
	 */
	public static function mode( array $line ): string {
		return (string) ( $line['priceMode']['id'] ?? self::QUOTE );
	}

	/**
	 * Formats an amount in the language of the site: « €24,900 ».
	 *
	 * @param float $amount Amount in euros.
	 * @return string
	 */
	public static function amount( float $amount ): string {
		$decimals = floor( $amount ) === $amount ? 0 : 2;

		return sprintf(
			/* translators: %s: amount with the separators of the language, e.g. « 24,900 ». */
			_x( '€%s', 'amount in euros', 'agencecinq' ),
			number_format_i18n( $amount, $decimals )
		);
	}

	/**
	 * Formats an amount excluding VAT: « €24,900 excl. VAT ».
	 *
	 * @param float $amount Amount in euros.
	 * @return string
	 */
	public static function amount_excl_vat( float $amount ): string {
		return sprintf(
			/* translators: %s: amount, e.g. « €14,900 ». */
			_x( '%s excl. VAT', 'price long label', 'agencecinq' ),
			self::amount( $amount )
		);
	}

	/**
	 * Displayed price of a line.
	 * Long: fixed price « €14,900 excl. VAT », starting price « From €6,000 excl. VAT », on quote « On quote ».
	 * Short: fixed price « €14,900 », starting price « From €6,000 », on quote « On quote ».
	 *
	 * @param array<string, mixed> $line  Package or module.
	 * @param bool                 $short Short form, for chips and lists.
	 * @return string
	 */
	public static function price( array $line, bool $short = false ): string {
		$price = $line['priceExclVat'] ?? null;

		return self::label( is_numeric( $price ) ? (float) $price : null, self::mode( $line ), $short );
	}

	/**
	 * Displayed total of a composition, same forms as price().
	 *
	 * @param array{amount: float, mode: string} $total Total from total().
	 * @param bool                               $short Short form.
	 * @return string
	 */
	public static function total_label( array $total, bool $short = false ): string {
		return self::label( $total['amount'], $total['mode'], $short );
	}

	/**
	 * Tier of a retainer: « Essentiel » out of « Accompagnement Shopify · Essentiel ».
	 *
	 * @param array<string, mixed> $retainer Retainer.
	 * @return string
	 */
	public static function retainer_tier( array $retainer ): string {
		$name  = (string) ( $retainer['name'] ?? '' );
		$range = (string) ( $retainer['range'] ?? '' );

		if ( '' !== $range && str_starts_with( $name, $range ) ) {
			return trim( ltrim( substr( $name, strlen( $range ) ), " ·\u{00B7}" ) );
		}

		return $name;
	}

	/**
	 * Monthly price of a retainer: « €390 excl. VAT per month », « from €1,200 excl. VAT per month », « On quote ».
	 *
	 * @param array<string, mixed> $retainer Retainer.
	 * @return string
	 */
	public static function retainer_price( array $retainer ): string {
		$price = $retainer['monthlyPriceExclVat'] ?? null;

		if ( ! is_numeric( $price ) || self::QUOTE === self::mode( $retainer ) ) {
			return __( 'On quote', 'agencecinq' );
		}

		$amount = self::amount( (float) $price );

		if ( self::FROM === self::mode( $retainer ) ) {
			/* translators: %s: monthly amount, e.g. « €1,200 ». */
			return sprintf( _x( 'from %s excl. VAT per month', 'retainer price', 'agencecinq' ), $amount );
		}

		/* translators: %s: monthly amount, e.g. « €390 ». */
		return sprintf( _x( '%s excl. VAT per month', 'retainer price', 'agencecinq' ), $amount );
	}

	/**
	 * Builds a price label.
	 *
	 * @param float|null $amount Amount, null on quote.
	 * @param string     $mode   Price mode.
	 * @param bool       $short  Short form.
	 * @return string
	 */
	private static function label( ?float $amount, string $mode, bool $short ): string {
		if ( null === $amount || self::QUOTE === $mode ) {
			return __( 'On quote', 'agencecinq' );
		}

		$text = $short ? self::amount( $amount ) : self::amount_excl_vat( $amount );

		if ( self::FROM === $mode ) {
			$from = $short
				/* translators: %s: amount, e.g. « €6,000 ». */
				? _x( 'From %s', 'price short label', 'agencecinq' )
				/* translators: %s: amount excluding VAT, e.g. « €6,000 excl. VAT ». */
				: _x( 'From %s', 'price long label', 'agencecinq' );

			return sprintf( $from, $text );
		}

		return $text;
	}

	/**
	 * A list from the payload, never anything else than an array of arrays.
	 *
	 * @param string $key Payload key.
	 * @return array<int, array<string, mixed>>
	 */
	private function list( string $key ): array {
		$items = $this->data[ $key ] ?? array();

		return is_array( $items ) ? array_values( array_filter( $items, 'is_array' ) ) : array();
	}

	/**
	 * Keeps the lines of a platform.
	 *
	 * @param array<int, array<string, mixed>> $items    Lines with a category.
	 * @param string|null                      $platform Platform id, null for all.
	 * @return array<int, array<string, mixed>>
	 */
	private function on_platform( array $items, ?string $platform ): array {
		if ( null === $platform || '' === $platform ) {
			return $items;
		}

		return array_values(
			array_filter(
				$items,
				static fn( array $item ): bool => ( $item['category']['id'] ?? '' ) === $platform
			)
		);
	}
}
