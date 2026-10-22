import { Piece } from 'piecesjs';
import { EVENTS } from '@agencecinq/utils';

type Mode = 'ferme' | 'a_partir_de' | 'sur_devis';

interface Labels {
	package: string;
	from: string;
	quote: string;
	error: string;
}

/** Answer of POST /wp-json/cinq/v1/quote (Catalogue/QuoteRequest.php). */
interface QuoteSent {
	email: string;
	total: string;
	booking: string;
}

interface QuoteError {
	code?: string;
	message?: string;
}

/** cinq-modal from @agencecinq/modal. */
interface ModalElement extends HTMLElement {
	show(): boolean;
}

/** Localized by Setup/Enqueue.php. */
declare const cinq: { api_url: string; rest_nonce: string };

/** Asks for a dot in the domain: « nom@entreprise » is refused. */
const EMAIL = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

/**
 * The estimator. The server renders every platform, package and module with its price;
 * this only shows the modules the chosen package accepts (its data-modules) and sums the total.
 *
 * Total: the sum of the prices, nothing else. One « from » line makes it a floor,
 * one « on quote » line makes it a quote. A missing price is never shown as 0 €.
 *
 * « Receive my estimate » posts the e-mail and the choice, never a price: the server prices it
 * again. On success the confirmation opens, its booking link carrying the choice.
 */
class Configurator extends Piece {
	#form: HTMLFormElement | null = null;
	#platforms: HTMLInputElement[] = [];
	#packages: HTMLInputElement[] = [];
	#modules: HTMLInputElement[] = [];
	#modulesList: HTMLElement | null = null;
	#modulesText: HTMLElement | null = null;
	#modulesEmpty: HTMLElement | null = null;
	#lines: HTMLElement | null = null;
	#line: HTMLTemplateElement | null = null;
	#total: HTMLElement | null = null;
	#firm: HTMLElement | null = null;
	#open: HTMLElement | null = null;
	#email: HTMLInputElement | null = null;
	#emailError: HTMLElement | null = null;
	#website: HTMLInputElement | null = null;
	#submit: HTMLButtonElement | null = null;
	#status: HTMLElement | null = null;
	#modal: ModalElement | null = null;
	#sending = false;
	#labels: Labels = { package: '', from: '', quote: '', error: '' };
	#format!: Intl.NumberFormat;

	constructor() {
		super( 'Configurator' );
	}

	#onChange = ( event: Event ): void => {
		if ( this.#platforms.includes( event.target as HTMLInputElement ) ) {
			this.#selectPlatform();
		}

		this.#update();
	};

	#onSubmit = async ( event: SubmitEvent ): Promise<void> => {
		event.preventDefault();

		if ( this.#sending || ! this.#validateEmail( true ) ) {
			return;
		}

		const pkg = this.#checked( this.#packages );

		if ( ! pkg || ! this.#email ) {
			return;
		}

		this.#setSending( true );
		this.#setStatus( '' );

		try {
			const response = await fetch( `${ cinq.api_url }/cinq/v1/quote`, {
				method: 'POST',
				headers: { 'Content-Type': 'application/json', 'X-WP-Nonce': cinq.rest_nonce },
				body: JSON.stringify( {
					email: this.#email.value.trim(),
					socle: pkg.value,
					modules: this.#modules.filter( ( input ) => input.checked ).map( ( input ) => input.value ),
					booking: this.dataset.booking ?? '',
					source: window.location.href,
					website: this.#website?.value ?? '',
				} ),
			} );
			const data = ( await response.json() ) as QuoteSent & QuoteError;

			if ( ! response.ok ) {
				if ( 'cinq_quote_email' === data.code ) {
					this.#setEmailError( true, true );
				} else {
					this.#setStatus( data.message || this.#labels.error );
				}

				return;
			}

			this.#setSending( false );
			await this.#openModal( data );
		} catch {
			this.#setStatus( this.#labels.error );
		} finally {
			this.#setSending( false );
		}
	};

	#onEmailInput = (): void => {
		// Clear the error as soon as the address becomes valid, never add one while typing.
		if ( this.#email?.getAttribute( 'aria-invalid' ) === 'true' ) {
			this.#validateEmail( false );
		}
	};

	#onModalClose = ( event: Event ): void => {
		if ( ( event as CustomEvent<{ modal: string }> ).detail?.modal === this.#modal?.id ) {
			this.#submit?.focus();
		}
	};

	#validateEmail( focus: boolean ): boolean {
		const valid = EMAIL.test( this.#email?.value.trim() ?? '' );

		this.#setEmailError( ! valid, focus );

		return valid;
	}

	#setEmailError( error: boolean, focus: boolean ): void {
		if ( ! this.#email ) {
			return;
		}

		this.#emailError?.toggleAttribute( 'hidden', ! error );

		if ( error ) {
			this.#email.setAttribute( 'aria-invalid', 'true' );

			if ( this.#emailError ) {
				this.#email.setAttribute( 'aria-describedby', this.#emailError.id );
			}

			if ( focus ) {
				this.#email.focus();
			}
		} else {
			this.#email.removeAttribute( 'aria-invalid' );
			this.#email.removeAttribute( 'aria-describedby' );
		}
	}

	#setSending( sending: boolean ): void {
		this.#sending = sending;

		if ( this.#submit ) {
			this.#submit.disabled = sending;
			this.#submit.toggleAttribute( 'aria-busy', sending );
		}
	}

	#setStatus( message: string ): void {
		if ( this.#status ) {
			this.#status.textContent = message;
			this.#status.hidden = ! message;
		}
	}

	async #openModal( data: QuoteSent ): Promise<void> {
		if ( ! this.#modal ) {
			return;
		}

		await customElements.whenDefined( 'cinq-modal' );

		const message = this.#modal.querySelector<HTMLElement>( '[data-dom="message"]' );
		const booking = this.#modal.querySelector<HTMLAnchorElement>( '[data-dom="booking"]' );
		const title = this.#modal.querySelector<HTMLElement>( '[data-dom="title"]' );

		if ( booking ) {
			booking.href = data.booking || this.dataset.booking || '#';
		}

		this.#modal.show();

		// Written once open, so the status region announces it; focus starts on the title.
		if ( message ) {
			message.textContent = ( message.dataset.template ?? '' )
				.replace( '{total}', data.total )
				.replace( '{email}', data.email );
		}

		title?.focus();
	}

	/**
	 * Shows the packages of the chosen platform, and keeps one of them checked.
	 */
	#selectPlatform(): void {
		const platform = this.#checked( this.#platforms )?.value;
		const packages = this.#packages.filter( ( input ) => input.dataset.platform === platform );

		this.#packages.forEach( ( input ) => this.#toggle( input, packages.includes( input ) ) );

		if ( ! packages.some( ( input ) => input.checked ) && packages[ 0 ] ) {
			packages[ 0 ].checked = true;
		}
	}

	#update(): void {
		const pkg = this.#checked( this.#packages );

		if ( ! pkg ) {
			return;
		}

		const accepted = ( pkg.dataset.modules ?? '' ).split( ',' ).filter( Boolean );

		this.#modules.forEach( ( input ) => {
			const eligible = accepted.includes( input.value );

			this.#toggle( input, eligible );
			input.disabled = ! eligible;

			if ( ! eligible ) {
				input.checked = false;
			}
		} );

		this.#modulesList?.toggleAttribute( 'hidden', ! accepted.length );
		this.#modulesText?.toggleAttribute( 'hidden', ! accepted.length );
		this.#modulesEmpty?.toggleAttribute( 'hidden', !! accepted.length );

		if ( this.#modulesText ) {
			this.#modulesText.textContent = ( this.#modulesText.dataset.template ?? '' ).replace(
				'{package}',
				pkg.dataset.name ?? ''
			);
		}

		const modules = this.#modules.filter( ( input ) => input.checked );

		this.#renderLines( [ pkg, ...modules ], pkg );
		this.#renderTotal( [ pkg, ...modules ] );
	}

	#renderLines( lines: HTMLInputElement[], pkg: HTMLInputElement ): void {
		if ( ! this.#lines || ! this.#line ) {
			return;
		}

		const rows = lines.map( ( input ) => {
			const row = this.#line!.content.cloneNode( true ) as DocumentFragment;
			const name = input === pkg ? `${ this.#labels.package } ${ input.dataset.name }` : input.dataset.name;

			row.querySelector( 'dt' )!.textContent = name ?? '';
			row.querySelector( 'dd' )!.textContent = input.dataset.label ?? '';

			return row;
		} );

		this.#lines.replaceChildren( ...rows );
	}

	#renderTotal( lines: HTMLInputElement[] ): void {
		let amount = 0;
		let mode: Mode = 'ferme';

		for ( const input of lines ) {
			const lineMode = ( input.dataset.mode ?? 'sur_devis' ) as Mode;
			const price = input.dataset.price ? Number( input.dataset.price ) : null;

			if ( 'sur_devis' === lineMode || null === price ) {
				mode = 'sur_devis';
				continue;
			}

			amount += price;

			if ( 'a_partir_de' === lineMode && 'ferme' === mode ) {
				mode = 'a_partir_de';
			}
		}

		if ( this.#total ) {
			this.#total.textContent = {
				ferme: this.#format.format( amount ),
				a_partir_de: `${ this.#labels.from } ${ this.#format.format( amount ) }`,
				sur_devis: this.#labels.quote,
			}[ mode ];
		}

		this.#firm?.toggleAttribute( 'hidden', 'ferme' !== mode );
		this.#open?.toggleAttribute( 'hidden', 'ferme' === mode );
	}

	/**
	 * One element by data-dom slug: domAttr answers a NodeList when the slug repeats.
	 */
	#one<T extends HTMLElement>( slug: string ): T | null {
		const found = this.domAttr<T>( slug );

		return found instanceof HTMLElement ? ( found as T ) : null;
	}

	#checked( inputs: HTMLInputElement[] ): HTMLInputElement | undefined {
		return inputs.find( ( input ) => input.checked );
	}

	#toggle( input: HTMLInputElement, visible: boolean ): void {
		input.closest( 'label' )?.toggleAttribute( 'hidden', ! visible );
	}

	mount() {
		this.#form = this.querySelector( 'form' );
		this.#platforms = this.domAttrAll<HTMLInputElement>( 'platform' );
		this.#packages = this.domAttrAll<HTMLInputElement>( 'package' );
		this.#modules = this.domAttrAll<HTMLInputElement>( 'module' );
		this.#modulesList = this.#one<HTMLElement>( 'modules' );
		this.#modulesText = this.#one<HTMLElement>( 'modules-text' );
		this.#modulesEmpty = this.#one<HTMLElement>( 'modules-empty' );
		this.#lines = this.#one<HTMLElement>( 'lines' );
		this.#line = this.#one<HTMLTemplateElement>( 'line' );
		this.#total = this.#one<HTMLElement>( 'total' );
		this.#firm = this.#one<HTMLElement>( 'firm' );
		this.#open = this.#one<HTMLElement>( 'open' );
		this.#email = this.#one<HTMLInputElement>( 'email' );
		this.#emailError = this.#one<HTMLElement>( 'email-error' );
		this.#website = this.#one<HTMLInputElement>( 'website' );
		this.#submit = this.#one<HTMLButtonElement>( 'submit' );
		this.#status = this.#one<HTMLElement>( 'status' );
		this.#modal = this.dataset.modal ? document.getElementById( this.dataset.modal ) as ModalElement | null : null;
		this.#format = new Intl.NumberFormat( this.lang || document.documentElement.lang || undefined, {
			style: 'currency',
			currency: 'EUR',
			minimumFractionDigits: 0,
			maximumFractionDigits: 2,
		} );

		try {
			this.#labels = { ...this.#labels, ...JSON.parse( this.dataset.labels ?? '{}' ) };
		} catch {
			// Keep the empty labels: the amounts still show.
		}

		this.#form?.addEventListener( 'change', this.#onChange );
		this.#form?.addEventListener( 'submit', this.#onSubmit );
		this.#email?.addEventListener( 'input', this.#onEmailInput );
		document.documentElement.addEventListener( EVENTS.MODAL_CLOSE, this.#onModalClose );

		// The browser may restore checked inputs on back navigation.
		this.#selectPlatform();
		this.#update();
	}

	unmount() {
		this.#form?.removeEventListener( 'change', this.#onChange );
		this.#form?.removeEventListener( 'submit', this.#onSubmit );
		this.#email?.removeEventListener( 'input', this.#onEmailInput );
		document.documentElement.removeEventListener( EVENTS.MODAL_CLOSE, this.#onModalClose );

		this.#form = null;
		this.#platforms = [];
		this.#packages = [];
		this.#modules = [];
		this.#modulesList = null;
		this.#modulesText = null;
		this.#modulesEmpty = null;
		this.#lines = null;
		this.#line = null;
		this.#total = null;
		this.#firm = null;
		this.#open = null;
		this.#email = null;
		this.#emailError = null;
		this.#website = null;
		this.#submit = null;
		this.#status = null;
		this.#modal = null;
	}
}

customElements.define( 'cinq-configurator', Configurator );
