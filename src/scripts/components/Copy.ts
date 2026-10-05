import { Piece } from 'piecesjs';

class Copy extends Piece {
	#button: HTMLButtonElement | null = null;
	#label: HTMLElement | null = null;
	#source: HTMLElement | null = null;
	#idleLabel = '';
	#resetTimer: ReturnType<typeof setTimeout> | null = null;

	constructor() {
		super( 'Copy' );
	}

	#onCopy = async (): Promise<void> => {
		if ( ! this.#source || ! this.#button ) {
			return;
		}

		const text = this.#source.textContent?.replace( /\u00a0/g, ' ' ).trim() ?? '';

		if ( ! text ) {
			return;
		}

		try {
			await navigator.clipboard.writeText( text );
			this.#setCopied( true );
		} catch {
			this.#setCopied( false );
		}
	};

	#setCopied( success: boolean ): void {
		if ( ! this.#label || ! this.#button ) {
			return;
		}

		if ( this.#resetTimer ) {
			clearTimeout( this.#resetTimer );
		}

		this.#label.textContent = success
			? this.getAttribute( 'data-copied' ) || 'Copied'
			: this.#idleLabel;

		this.#button.setAttribute( 'aria-live', 'polite' );

		this.#resetTimer = setTimeout( () => {
			if ( this.#label ) {
				this.#label.textContent = this.#idleLabel;
			}
		}, 2000 );
	}

	mount() {
		this.#button = this.domAttr<HTMLButtonElement>( 'copy' );
		this.#label = this.domAttr<HTMLElement>( 'label' );
		this.#source = this.domAttr<HTMLElement>( 'source' );
		this.#idleLabel = this.#label?.textContent?.trim() || 'Copy';

		this.#button?.addEventListener( 'click', this.#onCopy );
	}

	unmount() {
		this.#button?.removeEventListener( 'click', this.#onCopy );

		if ( this.#resetTimer ) {
			clearTimeout( this.#resetTimer );
			this.#resetTimer = null;
		}

		this.#button = null;
		this.#label = null;
		this.#source = null;
	}
}

customElements.define( 'cinq-copy', Copy );
