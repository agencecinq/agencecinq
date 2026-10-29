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
	 * A package or a retainer by id.
	 *
	 * @param string $id Line id.
	 * @return array<string, mixed>|null
	 */
	public function line( string $id ): ?array {
		foreach ( array( ...$this->packages(), ...$this->retainers() ) as $line ) {
			if ( ( $line['id'] ?? '' ) === $id ) {
				return $line;
			}
		}

		return null;
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
	 * Pricing cards of a platform: its packages or its retainers.
	 * Name, price, badge and the first four included lines come from the catalogue.
	 * The featured card shows the badge of the block instead of its own, when there is one.
	 *
	 * @param string               $source   'catalogue' (packages) or 'retainers'.
	 * @param array<string, mixed> $settings Platform, packages, featured and badge of the block.
	 * @return array<int, array<string, mixed>>
	 */
	public function tiers( string $source, array $settings ): array {
		$platform = (string) ( $settings['platform'] ?? '' );
		$lines    = match ( $source ) {
			'retainers' => $this->retainers( $platform ),
			default     => self::pick( $this->packages( $platform ), 'code', (array) ( $settings['packages'] ?? array() ) ),
		};

		return array_map(
			static function ( array $line ) use ( $source, $settings ): array {
				$included = (array) ( $line['included'] ?? array() );
				$featured = ( $line['code'] ?? $line['id'] ?? '' ) === ( $settings['featured'] ?? '' );
				$badge    = $featured ? (string) ( $settings['badge'] ?? '' ) : '';

				if ( 'retainers' === $source ) {
					$line['name'] = self::retainer_tier( $line );
					$badge        = $badge ? $badge : self::response_time( $line );
				} else {
					$badge = $badge ? $badge : self::lead_time( $line );
				}

				return array_merge(
					$line,
					array(
						'included' => array_slice( array_values( array_filter( $included ) ), 0, 4 ),
						'featured' => $featured,
						'badge'    => $badge,
					)
				);
			},
			$lines
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
	 * Price of an offer that starts at a package: « From €14,900 excl. VAT », or with the retainer that follows
	 * it « €4,900 excl. VAT, then €1,200 excl. VAT per month ».
	 *
	 * @param array<string, mixed>      $package  Package the offer starts at.
	 * @param array<string, mixed>|null $retainer Optional. Retainer after the package.
	 * @return string
	 */
	public static function offer_price( array $package, ?array $retainer = null ): string {
		if ( $retainer ) {
			return sprintf(
				/* translators: 1: price of the package, 2: monthly price of the retainer. */
				_x( '%1$s, then %2$s', 'offer price', 'agencecinq' ),
				self::price( $package ),
				self::retainer_price( $retainer )
			);
		}

		$price = $package['priceExclVat'] ?? null;
		$mode  = self::QUOTE === self::mode( $package ) ? self::QUOTE : self::FROM;

		return self::label( is_numeric( $price ) ? (float) $price : null, $mode, false );
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
	 * Lead time of a package: « 6 weeks », « After scoping » without one.
	 *
	 * @param array<string, mixed> $package Package.
	 * @return string
	 */
	public static function lead_time( array $package ): string {
		$weeks = $package['leadTimeWeeks'] ?? null;

		if ( ! is_numeric( $weeks ) ) {
			return __( 'After scoping', 'agencecinq' );
		}

		/* translators: %s: number of weeks. */
		return sprintf( _n( '%s week', '%s weeks', (int) $weeks, 'agencecinq' ), number_format_i18n( (int) $weeks ) );
	}

	/**
	 * Response time of a retainer: « Response: 3 working days », nothing without one.
	 *
	 * @param array<string, mixed> $retainer Retainer.
	 * @return string
	 */
	public static function response_time( array $retainer ): string {
		$time = trim( (string) ( $retainer['responseTime'] ?? '' ) );

		if ( '' === $time ) {
			return '';
		}

		/* translators: %s: response time, e.g. « 3 working days ». */
		return sprintf( _x( 'Response: %s', 'retainer badge', 'agencecinq' ), mb_strtolower( mb_substr( $time, 0, 1 ) ) . mb_substr( $time, 1 ) );
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
	 * Keeps the lines whose key is in a selection, in the order of the catalogue. No selection keeps them all.
	 *
	 * @param array<int, array<string, mixed>> $items     Lines.
	 * @param string                           $key       Key the selection holds: 'code' or 'id'.
	 * @param array<int, mixed>                $selection Selected values.
	 * @return array<int, array<string, mixed>>
	 */
	private static function pick( array $items, string $key, array $selection ): array {
		$selection = array_filter( array_map( 'strval', $selection ) );

		if ( ! $selection ) {
			return $items;
		}

		return array_values(
			array_filter(
				$items,
				static fn( array $item ): bool => in_array( (string) ( $item[ $key ] ?? '' ), $selection, true )
			)
		);
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
