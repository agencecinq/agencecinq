<?php
/**
 * Schema Graph
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/WordpressSeo
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Plugins\WordpressSeo;

use AgenceCinq\Service;

/**
 * Schema Graph
 *
 * Adds the pieces of the theme to the Yoast schema graph.
 */
class SchemaGraph implements Service {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run(): void {
		add_filter( 'wpseo_schema_graph_pieces', array( $this, 'pieces' ) );
	}

	/**
	 * Adds the Service piece.
	 *
	 * @param array<int, object> $pieces Schema pieces.
	 * @return array<int, object>
	 */
	public function pieces( array $pieces ): array {
		$pieces[] = new Schema\Service();

		return $pieces;
	}
}
