import { load, Piece } from "piecesjs";

const { cinq: { ajax_url, nonce } } = window;

const LOCKED_CLASSES = ["pointer-events-none", "opacity-50", "cursor-not-allowed"];

interface Data {
	success: boolean;
	data: {
		message: string;
		html: string;
	};
}

class ChildPagesByParent extends Piece {
	action = "child_pages_slideshow";
	$slideshow!: HTMLElement;
	chips: HTMLElement[] = [];

	constructor() {
		super("ChildPagesByParent");
	}

	mount(): void {
		this.action = this.getAttribute("data-action") || this.action;
		this.chips = Array.from(this.domAttrAll("chip"));

		const $slideshow = this.domAttr("slideshow");

		if (!$slideshow) {
			console.warn("ChildPagesByParent: slideshow element not found");
			return;
		}

		this.$slideshow = $slideshow as HTMLElement;

		this.chips.forEach(($chip) => {
			this.on("click", $chip, this.handleClick);
			this.on("keydown", $chip, this.handleKeydown);
		});
	}


	/**
	 * Handle the keydown event for the chips.
	 * 
	 * @param event The keyboard event.
	 * @returns void
	 * @private
	 */
	private handleKeydown = (event: KeyboardEvent) => {
		const { key, currentTarget } = event;
		const index = this.chips.indexOf(currentTarget as HTMLElement);

		if (index === -1 || this.chips.length === 0) {
			return;
		}

		const previous = (index: number) => index - 1 < 0 ? this.chips.length - 1 : index - 1;
		const next = (index: number) => index + 1 > this.chips.length - 1 ? 0 : index + 1;
		const first = () => 0;
		const last = () => this.chips.length - 1;

		const codes = {
			ArrowUp: previous,
			ArrowRight: next,
			ArrowDown: next,
			ArrowLeft: previous,
			Home: first,
			End: last,
			default: (index: number) => index,
		};

		const $chip = this.chips[(codes[key as keyof typeof codes] || codes.default)(index)];

		if ($chip && $chip !== currentTarget) {
			event.preventDefault();
			$chip.focus();
			this.activate($chip);
		}
	};


	/**
	 * Activate the given chip element.
	 * 
	 * @param $active The active chip element.
	 * @returns void
	 * @private
	 */
	private activate($active: HTMLElement): void {
		this.chips.forEach(($chip) => {
			$chip.classList.toggle("is-active", $chip === $active);
			$chip.setAttribute("aria-selected", $chip === $active ? "true" : "false");
		});

		this.$slideshow.setAttribute("aria-labelledby", $active.id);

		this.load($active.getAttribute("data-id") as string);
	}

	private handleClick = (event: Event) => {
		this.activate(event.currentTarget as HTMLElement);
	};

	async load(id: string): Promise<void> {
		this.locked();

		try {
			const response = await this.fetch(id);
			const data = await response.json();

			await this.insert(data);
		} finally {
			this.unlocked();
		}
	}

	fetch(id: string) {
		const url = new URL(ajax_url);

		url.searchParams.set("action", this.action);
		url.searchParams.set("id", id);
		url.searchParams.set("nonce", nonce);

		return fetch(url.toString());
	}

	async insert(data: Data) {
		if (!data.success) {
			this.showError(data.data.message);
			return;
		}

		this.$slideshow.innerHTML = data.data.html;

		await load("cinq-slideshow", () => import("./Slideshow"));
	}

	showError(message: string): void {
		this.$slideshow.innerHTML = `<p class="h-on-title uppercase text-rouge" role="alert">${message}</p>`;
	}

	locked(): void {
		this.chips.forEach(($chip) => $chip.classList.add(...LOCKED_CLASSES));
		this.$slideshow.classList.add(...LOCKED_CLASSES);
	}

	unlocked(): void {
		this.chips.forEach(($chip) => $chip.classList.remove(...LOCKED_CLASSES));
		this.$slideshow.classList.remove(...LOCKED_CLASSES);
	}

	unmount(): void {
		this.chips.forEach((chip) => {
			this.off("click", chip, this.handleClick);
			this.off("keydown", chip, this.handleKeydown);
		});
	}
}

customElements.define("cinq-child-pages-by-parent", ChildPagesByParent);
