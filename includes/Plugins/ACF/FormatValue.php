<?php
/**
 * ACF Format Value
 *
 * @package AgenceCinq
 * @subpackage AgenceCinq/Plugins/ACF
 */

namespace AgenceCinq\Plugins\ACF;

use AgenceCinq\Service;

/**
 * FormatValue
 */
class FormatValue implements Service {

	/**
	 * Runs the service: registers the ACF format_value filter.
	 *
	 * @return void
	 */
	public function run(): void {
		add_filter( 'acf/format_value/name=blocks', array( $this, 'format_value_blocks' ), 10, 3 );
		add_filter( 'acf/format_value/key=field_blocks_pricing_tiers_items_included', array( $this, 'format_value_included' ) );
		add_filter( 'acf/format_value/key=field_blocks_pricing_tiers_items_priceMode', array( $this, 'format_value_price_mode' ) );
		add_filter( 'acf/format_value/key=field_blocks_subscriptions_items_retainers_priceMode', array( $this, 'format_value_price_mode' ) );
	}

	/**
	 * Formats the included lines typed in a block as the API serves them: a list of strings.
	 *
	 * @param mixed $value Repeater rows with a `text` key.
	 * @return array<int, string>
	 */
	public function format_value_included( $value ): array {
		return is_array( $value ) ? array_values( array_filter( array_column( $value, 'text' ) ) ) : array();
	}

	/**
	 * Formats the price mode typed in a block as the API serves it: { id }.
	 *
	 * @param mixed $value Price mode id.
	 * @return array{id: string}|null
	 */
	public function format_value_price_mode( $value ): ?array {
		return $value ? array( 'id' => (string) $value ) : null;
	}

	/**
	 * Formats the blocks value
	 *
	 * @param array<int, array<string, mixed>> $value   The flexible content value (array of layouts).
	 * @param int|string                       $post_id The post ID (or 'option' for options).
	 * @param array<string, mixed>             $field   The ACF field array.
	 * @return array<int, array<string, mixed>>
	 */
	public function format_value_blocks( $value, $post_id, $field ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed -- Filter signature.
		if ( ! is_array( $value ) ) {
			return $value;
		}

		foreach ( $value as &$layout ) {
			if ( empty( $layout['acf_fc_layout'] ) ) {
				continue;
			}

			$layout['id'] = 'block-' . str_replace( '_', '-', $layout['acf_fc_layout'] ) . '-' . uniqid();
		}


		

		return $value;
	}
}
