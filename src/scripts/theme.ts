/** Data of Setup/Enqueue.php, printed by WordPress as JSON next to the agencecinq-main module. */
interface Theme {
	api_url: string;
	rest_nonce: string;
}

const container = document.querySelector( 'script[id="wp-script-module-data-agencecinq-main"]' );

let theme = {} as Theme;

if ( container instanceof HTMLScriptElement ) {
	try {
		theme = JSON.parse( container.text );
	} catch {}
}

export default theme;
