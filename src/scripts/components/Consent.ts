import { Piece } from "piecesjs";
import type { Modal } from "@agencecinq/modal";

/** The choice, « analytics:1 » or « analytics:0 », kept 6 months as the CNIL recommends. */
const COOKIE = "cinq_consent";
const MAX_AGE = 60 * 60 * 24 * 182;

/**
 * Cookie consent (Figma Overlay/Banner and the cookie choices of Overlay/Dialog). The banner shows until a
 * choice is kept; « Accept all », « Reject all » and « Save my choices » keep it, close the choices and
 * dispatch a consent event on the document ({ analytics }). While the banner shows, the page keeps a scroll
 * padding of its height, so it never hides the element that has the focus.
 */
class Consent extends Piece {
	#banner: HTMLElement | null = null;
	#modal: Modal | null = null;
	#analytics: HTMLElement | null = null;
	#observer = new ResizeObserver(() => this.#pad());

	constructor() {
		super("Consent");
	}

	mount(): void {
		this.#banner = this.querySelector("[data-dom=banner]");
		this.#modal = this.querySelector<Modal>("cinq-modal");
		this.#analytics = this.querySelector('cinq-switch[name="analytics"]');

		this.addEventListener("click", this.#onClick);
		this.#modal?.querySelector("dialog")?.addEventListener("toggle", this.#onToggle);

		if (this.#read() === null) {
			this.#show();
		}
	}

	unmount(): void {
		this.removeEventListener("click", this.#onClick);
		this.#modal?.querySelector("dialog")?.removeEventListener("toggle", this.#onToggle);
		this.#hide();
	}

	#read(): boolean | null {
		const match = document.cookie.match(new RegExp(`(?:^|; )${COOKIE}=analytics:([01])`));

		return match ? match[1] === "1" : null;
	}

	#keep(analytics: boolean): void {
		const secure = location.protocol === "https:" ? "; Secure" : "";

		document.cookie = `${COOKIE}=analytics:${Number(analytics)}; Max-Age=${MAX_AGE}; Path=/; SameSite=Lax${secure}`;
		document.dispatchEvent(new CustomEvent("consent", { detail: { analytics } }));

		this.#hide();
		this.#modal?.close();
	}

	#onClick = (event: MouseEvent): void => {
		const choice = (event.target as Element).closest<HTMLElement>("[data-consent]")?.dataset
			.consent;

		if (!choice) {
			return;
		}

		const analytics = this.#analytics?.getAttribute("aria-checked") === "true";

		this.#keep(choice === "accept" || (choice === "save" && analytics));
	};

	/** The choices open on the kept choice. */
	#onToggle = (event: Event): void => {
		if ((event as ToggleEvent).newState === "open") {
			this.#analytics?.setAttribute("aria-checked", String(this.#read() === true));
		}
	};

	#show(): void {
		if (!this.#banner) {
			return;
		}

		this.#banner.hidden = false;
		this.#observer.observe(this.#banner);
	}

	#hide(): void {
		if (this.#banner) {
			this.#banner.hidden = true;
		}

		this.#observer.disconnect();
		document.documentElement.style.removeProperty("scroll-padding-bottom");
	}

	#pad(): void {
		const top = this.#banner?.getBoundingClientRect().top;

		if (top !== undefined) {
			document.documentElement.style.scrollPaddingBottom = `${innerHeight - top}px`;
		}
	}
}

customElements.define("cinq-consent", Consent);
