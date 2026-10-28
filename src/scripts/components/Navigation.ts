import { Piece } from 'piecesjs';
import { EVENTS } from '@agencecinq/utils';

type Disclosure = HTMLElement & {
	$button: HTMLButtonElement | null;
	expanded: boolean;
	open(): void;
	close(): void;
};

/**
 * Main navigation around the <cinq-disclosure-button> of each Nav link: a submenu also opens on hover
 * with a mouse, closes with Escape, the focus going back to its Nav link, and when the focus leaves it.
 * One submenu is open at a time.
 */
class Navigation extends Piece {
	#items: HTMLElement[] = [];
	#hover = window.matchMedia( '(hover: hover)' );
	/** Opened by the pointer: a click on its Nav link keeps it open instead of closing it. */
	#hovered: Disclosure | null = null;

	constructor() {
		super( 'Navigation' );
	}

	#disclosure( item: Element ): Disclosure | null {
		return item.querySelector<Disclosure>( 'cinq-disclosure-button' );
	}

	#onEnter = ( event: PointerEvent ): void => {
		const disclosure = this.#disclosure( event.currentTarget as Element );

		if ( ! disclosure || 'mouse' !== event.pointerType || ! this.#hover.matches || disclosure.expanded ) {
			return;
		}

		disclosure.open();
		this.#hovered = disclosure;
	};

	#onLeave = ( event: PointerEvent ): void => {
		if ( 'mouse' !== event.pointerType ) {
			return;
		}

		this.#disclosure( event.currentTarget as Element )?.close();
		this.#hovered = null;
	};

	#onClick = ( event: MouseEvent ): void => {
		const disclosure = this.#disclosure( event.currentTarget as Element );

		if ( disclosure && disclosure === this.#hovered && disclosure.$button?.contains( event.target as Node ) ) {
			event.stopPropagation();
		}

		this.#hovered = null;
	};

	#onFocusout = ( event: FocusEvent ): void => {
		const item = event.currentTarget as HTMLElement;

		if ( ! item.contains( event.relatedTarget as Node | null ) ) {
			this.#disclosure( item )?.close();
		}
	};

	#onKeydown = ( event: KeyboardEvent ): void => {
		if ( 'Escape' !== event.key ) {
			return;
		}

		const item = ( event.target as Element ).closest( '[data-dom="item"]' );
		const disclosure = item ? this.#disclosure( item ) : null;

		if ( disclosure?.expanded ) {
			disclosure.close();
			disclosure.$button?.focus();
		}
	};

	#onOpen = ( event: Event ): void => {
		for ( const item of this.#items ) {
			const disclosure = this.#disclosure( item );

			if ( disclosure && ! disclosure.contains( event.target as Node ) ) {
				disclosure.close();
			}
		}
	};

	mount(): void {
		this.#items = Array.from( this.domAttrAll<HTMLElement>( 'item' ) );

		for ( const item of this.#items ) {
			item.addEventListener( 'pointerenter', this.#onEnter );
			item.addEventListener( 'pointerleave', this.#onLeave );
			item.addEventListener( 'click', this.#onClick, { capture: true } );
			item.addEventListener( 'focusout', this.#onFocusout );
		}

		this.addEventListener( 'keydown', this.#onKeydown );
		this.addEventListener( EVENTS.DISCLOSURE_BUTTON_OPEN, this.#onOpen );
	}

	unmount(): void {
		for ( const item of this.#items ) {
			item.removeEventListener( 'pointerenter', this.#onEnter );
			item.removeEventListener( 'pointerleave', this.#onLeave );
			item.removeEventListener( 'click', this.#onClick, { capture: true } );
			item.removeEventListener( 'focusout', this.#onFocusout );
		}

		this.removeEventListener( 'keydown', this.#onKeydown );
		this.removeEventListener( EVENTS.DISCLOSURE_BUTTON_OPEN, this.#onOpen );
		this.#items = [];
		this.#hovered = null;
	}
}

customElements.define( 'cinq-navigation', Navigation );
