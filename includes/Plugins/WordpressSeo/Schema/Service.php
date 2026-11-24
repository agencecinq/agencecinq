<?php
/**
 * Service
 *
 * Schema piece of a service page: the service it sells, provided by the
 * organization of the site, with the prices of its pricing tables.
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/WordpressSeo/Schema
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\WordpressSeo\Schema;

use AgenceCinq\Catalogue\Catalogue;
use Yoast\WP\SEO\Generators\Schema\Abstract_Schema_Piece;

/**
 * Service
 *
 * Needed on a page with a service type. Its offers are the lines its pricing tables show, so the
 * structured data never says another price than the page. A line on quote has no offer.
 */
class Service extends Abstract_Schema_Piece {

	/**
	 * Identifier of the piece, for the `wpseo_schema_service` and `wpseo_schema_needs_service` filters.
	 *
	 * @var string
	 */
	public $identifier = 'service';

	/**
	 * Determines whether the piece is needed: a page with a service type.
	 *
	 * @return bool
	 */
	public function is_needed() {
		return 'post' === $this->context->indexable->object_type
			&& 'page' === $this->context->indexable->object_sub_type
			&& '' !== $this->service_type();
	}

	/**
	 * Returns the Service node.
	 *
	 * @return array<string, mixed>
	 */
	public function generate() {
		$url  = $this->context->canonical;
		$data = array(
			'@type'            => 'Service',
			'@id'              => $url . '#service',
			'name'             => wp_strip_all_tags( $this->context->post->post_title ),
			'serviceType'      => $this->service_type(),
			'url'              => $url,
			'mainEntityOfPage' => array( '@id' => $this->context->main_schema_id ),
			'areaServed'       => array(
				'@type' => 'Country',
				'name'  => 'France',
			),
		);

		$description = (string) $this->context->description;
		$provider    = $this->context->site_represents_reference;
		$offers      = $this->offers( $url );

		if ( '' !== $description ) {
			$data['description'] = $description;
		}

		if ( $provider ) {
			$data['provider'] = $provider;
		}

		if ( $offers ) {
			$data['offers'] = $offers;
		}

		return $data;
	}

	/**
	 * Service type of the page.
	 *
	 * @return string
	 */
	private function service_type(): string {
		return trim( (string) get_post_meta( $this->context->id, 'service_type', true ) );
	}

	/**
	 * Offers of the lines the pricing tables of the page show, each line once.
	 *
	 * @param string $url URL of the page.
	 * @return array<int, array<string, mixed>>
	 */
	private function offers( string $url ): array {
		$catalogue = Catalogue::instance();
		$blocks    = function_exists( 'get_field' ) ? get_field( 'blocks', $this->context->id ) : array();

		if ( ! $catalogue || ! is_array( $blocks ) ) {
			return array();
		}

		$offers = array();

		foreach ( $blocks as $block ) {
			if ( 'pricing_table' !== ( $block['acf_fc_layout'] ?? '' ) ) {
				continue;
			}

			$settings = (array) ( $block['catalogue'] ?? array() );
			$source   = (string) ( $settings['source'] ?? 'catalogue' );

			foreach ( $catalogue->lines( $source, $settings ) as $line ) {
				$id    = (string) ( $line['id'] ?? '' );
				$offer = $this->offer( $line, 'retainers' === $source, $url );

				if ( $offer && ! isset( $offers[ $id ] ) ) {
					$offers[ $id ] = $offer;
				}
			}
		}

		return array_values( $offers );
	}

	/**
	 * Offer of a catalogue line, excluding VAT: a fixed price, a starting price, or a price per month for a
	 * retainer. Null on quote.
	 *
	 * @param array<string, mixed> $line     Package or retainer.
	 * @param bool                 $retainer Whether the line is a retainer, priced per month.
	 * @param string               $url      URL of the page.
	 * @return array<string, mixed>|null
	 */
	private function offer( array $line, bool $retainer, string $url ): ?array {
		$amount = $line[ $retainer ? 'monthlyPriceExclVat' : 'priceExclVat' ] ?? null;
		$mode   = Catalogue::mode( $line );

		if ( ! is_numeric( $amount ) || Catalogue::QUOTE === $mode ) {
			return null;
		}

		$amount    = 0 + $amount;
		$from      = Catalogue::FROM === $mode;
		$price_key = $from ? 'minPrice' : 'price';

		$specification = array(
			'@type'                 => $retainer ? 'UnitPriceSpecification' : 'PriceSpecification',
			$price_key              => $amount,
			'priceCurrency'         => 'EUR',
			'valueAddedTaxIncluded' => false,
		);

		if ( $retainer ) {
			// UN/CEFACT common code for a month.
			$specification['unitCode'] = 'MON';
		}

		$offer = array(
			'@type'              => 'Offer',
			'name'               => (string) ( $line['name'] ?? '' ),
			'description'        => $retainer ? Catalogue::retainer_price( $line ) : Catalogue::price( $line ),
			'priceCurrency'      => 'EUR',
			'priceSpecification' => $specification,
			'url'                => $url,
		);

		if ( ! $from ) {
			$offer['price'] = $amount;
		}

		return $offer;
	}
}
