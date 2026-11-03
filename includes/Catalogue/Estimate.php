<?php
/**
 * Estimate
 *
 * What a visitor chose in the configurator, checked and priced against the catalogue.
 *
 * @package WordPress
 * @subpackage AgenceCinq/Catalogue
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Catalogue;

/**
 * Estimate.
 *
 * The browser only says what was chosen, never what it costs: the package and its modules are read again
 * from the catalogue, and the modules the package does not accept are dropped.
 *
 * Always an estimate, never a quote: the firm price is set after the diagnosis, on a written scope.
 */
final class Estimate {

	/**
	 * Constructor.
	 *
	 * @param array<string, mixed>             $package Package.
	 * @param array<int, array<string, mixed>> $modules Modules the package accepts.
	 */
	private function __construct(
		public readonly array $package,
		public readonly array $modules,
	) {}

	/**
	 * Checks a choice against the catalogue.
	 *
	 * @param string            $platform   Platform id.
	 * @param string            $code       Package code.
	 * @param array<int, mixed> $module_ids Module ids.
	 * @return self|null Null when the catalogue or the package is unavailable.
	 */
	public static function from_choice( string $platform, string $code, array $module_ids ): ?self {
		$catalogue = Catalogue::instance();
		$package   = $catalogue?->package( $platform, $code );

		if ( null === $catalogue || null === $package ) {
			return null;
		}

		$module_ids = array_map( 'strval', $module_ids );

		return new self(
			$package,
			array_values(
				array_filter(
					$catalogue->modules( $package ),
					static fn( array $module ): bool => in_array( (string) ( $module['id'] ?? '' ), $module_ids, true )
				)
			)
		);
	}

	/**
	 * Total, shaped as a catalogue line for Catalogue::price(): the sum of the prices, nothing else.
	 * One « from » line makes it a floor, one « on quote » line makes it a quote.
	 *
	 * @return array{priceExclVat: float, priceMode: array{id: string}}
	 */
	public function total(): array {
		$amount = 0.0;
		$mode   = Catalogue::FIRM;

		foreach ( array( $this->package, ...$this->modules ) as $line ) {
			$price = $line['priceExclVat'] ?? null;

			if ( Catalogue::QUOTE === Catalogue::mode( $line ) || ! is_numeric( $price ) ) {
				$mode = Catalogue::QUOTE;
				continue;
			}

			$amount += (float) $price;

			if ( Catalogue::FROM === Catalogue::mode( $line ) && Catalogue::FIRM === $mode ) {
				$mode = Catalogue::FROM;
			}
		}

		return array(
			'priceExclVat' => $amount,
			'priceMode'    => array( 'id' => $mode ),
		);
	}

	/**
	 * Whether every line has a firm price, so the total is one too.
	 *
	 * @return bool
	 */
	public function is_firm(): bool {
		return Catalogue::FIRM === $this->total()['priceMode']['id'];
	}

	/**
	 * One line per offer, then the total, for the e-mails.
	 *
	 * @return array<int, string>
	 */
	public function lines(): array {
		$lines = array(
			sprintf(
				/* translators: 1: platform, 2: package name, 3: price. */
				_x( '%1$s · Package %2$s: %3$s', 'estimate package line', 'agencecinq' ),
				$this->package['category']['label'] ?? '',
				$this->package['name'] ?? '',
				Catalogue::price( $this->package )
			),
		);

		foreach ( $this->modules as $module ) {
			$lines[] = sprintf(
				/* translators: 1: module name, 2: price. */
				_x( '%1$s: %2$s', 'estimate module line', 'agencecinq' ),
				$module['name'] ?? '',
				Catalogue::price( $module )
			);
		}

		$lines[] = sprintf(
			/* translators: %s: total price. */
			_x( 'Total: %s', 'estimate total line', 'agencecinq' ),
			Catalogue::price( $this->total() )
		);

		return $lines;
	}
}
