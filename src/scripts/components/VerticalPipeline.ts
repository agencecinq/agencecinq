import { Piece } from "piecesjs";
import { clamp } from "@agencecinq/utils";

/**
 * Fills the spine as the list crosses the middle of the viewport: progress
 * goes from 0 when its top reaches the center to 1 when its bottom does.
 * Updates are batched to one per frame.
 */
class VerticalPipeline extends Piece {
	#items: HTMLLIElement[] = [];
	#frame = 0;

	constructor() {
		super("VerticalPipeline");
	}

	#setProgress(progress: number) {
		this.style.setProperty("--progress", String(progress));
	}

	#updateItems(progress: number) {
		const total = this.#items.length;

		if (!total) {
			return;
		}

		this.#items.forEach((item, index) => {
			item.classList.toggle("is-active", progress >= (index + 0.5) / total);
		});
	}

	#update = () => {
		this.#frame = 0;

		const { top, height } = this.getBoundingClientRect();
		const progress = height ? clamp((window.innerHeight / 2 - top) / height, 0, 1) : 0;

		this.#setProgress(progress);
		this.#updateItems(progress);
	};

	#requestUpdate = () => {
		if (!this.#frame) {
			this.#frame = requestAnimationFrame(this.#update);
		}
	};

	#listen(listening: boolean) {
		const method = listening ? "addEventListener" : "removeEventListener";

		window[method]("scroll", this.#requestUpdate, { passive: true } as AddEventListenerOptions);
		window[method]("resize", this.#requestUpdate);
	}

	mount() {
		this.#items = this.domAttrAll<HTMLLIElement>("item");

		this.#listen(true);
		this.#requestUpdate();
	}

	unmount() {
		this.#listen(false);
		cancelAnimationFrame(this.#frame);
		this.#frame = 0;

		this.#items.forEach((item) => item.classList.remove("is-active"));
		this.#items = [];
		this.style.removeProperty("--progress");
	}
}

customElements.define("cinq-vertical-pipeline", VerticalPipeline);
