import { Piece } from 'piecesjs';

/**
 * Easter egg: press C to advance every `[data-scheme]` to the next scheme from `data-schemes` (cinq_schemes
 * keys). Skips `[data-scheme-ignore]` (element or ancestor). Ignored in form fields. No visible UI.
 */
class Scheme extends Piece {
	#schemes: string[] = [];

	constructor() {
		super( 'Scheme' );
	}

	mount(): void {
		try {
			const parsed: unknown = JSON.parse( this.getAttribute( 'data-schemes' ) ?? '[]' );

			this.#schemes = Array.isArray( parsed )
				? parsed.filter( ( value ): value is string => typeof value === 'string' )
				: [];
		} catch {
			this.#schemes = [];
		}

		if ( ! this.#schemes.length ) {
			return;
		}

		document.addEventListener( 'keydown', this.#onKeydown );
	}

	unmount(): void {
		document.removeEventListener( 'keydown', this.#onKeydown );
	}

	#onKeydown = ( event: KeyboardEvent ): void => {
		const { key, metaKey, ctrlKey, altKey, target } = event;

		if ( 'c' !== key && 'C' !== key ) {
			return;
		}

		if ( metaKey || ctrlKey || altKey ) {
			return;
		}

		if ( target instanceof HTMLElement && target.closest( 'input, textarea, select, [contenteditable="true"]' ) ) {
			return;
		}

		event.preventDefault();
		this.#advance();
	};

	#advance = (): void => {
		const { length } = this.#schemes;

		document.querySelectorAll( '[data-scheme]' ).forEach( ( element ) => {
			if ( element.closest( '[data-scheme-ignore]' ) ) {
				return;
			}

			const current = element.getAttribute( 'data-scheme' ) ?? '';
			const index = this.#schemes.indexOf( current );
			const next = this.#schemes[ ( index + 1 ) % length ] ?? '';

			element.setAttribute( 'data-scheme', next );
		} );
	};
}

customElements.define( 'cinq-scheme', Scheme );
