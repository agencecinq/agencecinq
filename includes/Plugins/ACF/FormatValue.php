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
