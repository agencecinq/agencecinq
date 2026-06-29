<?php
/**
 * Query Vars
 *
 * @package WPCinquanteEtUn
 * @subpackage WPCinquanteEtUn/Setup
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace WPCinquanteEtUn\Setup;

use WPCinquanteEtUn\Taxonomy\PageCat;
use WPCinquanteEtUn\Service;
use WP_Post;

/**
 * QueryVars
 *
 * Add custom query vars and rewrite rules for page_cat in page URLs.
 *
 * @package WordPress
 * @subpackage WPCinquanteEtUn/Setup
 */
class QueryVars implements Service {

	/**
	 * Query var for the page category slug in the URL.
	 *
	 * @var string
	 */
	public const PAGE_CAT_QUERY_VAR = 'page_cat';

	/**
	 * Query var for the selected domain (used to pre-fill forms, etc.).
	 *
	 * @var string
	 */
	public const DOMAINE_QUERY_VAR = 'domaine';

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run(): void {
		add_filter( 'query_vars', array( $this, 'query_vars' ) );
		add_action( 'init', array( $this, 'add_rewrite_tags' ), 11 );
		add_action( 'init', array( $this, 'add_rewrite_rules' ), 11 );
	}

	/**
	 * Add query vars.
	 *
	 * @param string[] $public_query_vars The array of allowed query variable names.
	 *
	 * @see https://developer.wordpress.org/reference/hooks/query_vars/
	 *
	 * @return string[]
	 */
	public function query_vars( array $public_query_vars ): array {
		$public_query_vars[] = self::DOMAINE_QUERY_VAR;

		return array_values( array_unique( $public_query_vars ) );
	}

	/**
	 * Add rewrite tags.
	 *
	 * @link https://codex.wordpress.org/Rewrite_API/add_rewrite_tag
	 *
	 * @return void
	 */
	public function add_rewrite_tags(): void {
	}

	/**
	 * Add rewrite rules so that /{page_cat_slug}/{pagename}/ loads the page with that page_cat.
	 *
	 * @link https://codex.wordpress.org/Rewrite_API/add_rewrite_rule
	 *
	 * @return void
	 */
	public function add_rewrite_rules(): void {
	}
}
