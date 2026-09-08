import { Piece } from "piecesjs";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

class VerticalPipeline extends Piece {
	private items: HTMLLIElement[] = [];
	private scrollTrigger: ScrollTrigger | null = null;

	constructor() {
		super("VerticalPipeline");
	}

	private setProgress(progress: number) {
		this.style.setProperty("--progress", String(progress));
		this.updateItems(progress);
	}

	private updateItems(progress: number) {
		const total = this.items.length;

		if (!total) {
			return;
		}

		this.items.forEach((item, index) => {
			item.classList.toggle("is-active", progress >= (index + 0.5) / total);
		});
	}

	mount() {
		this.items = this.domAttrAll<HTMLLIElement>("item");

		this.scrollTrigger = ScrollTrigger.create({
			trigger: this,
			start: "top center",
			end: "bottom center",
			scrub: true,
			onUpdate: ({ progress }) => this.setProgress(progress),
		});
	}

	unmount() {
		if (this.scrollTrigger) {
			this.scrollTrigger.kill();
			this.scrollTrigger = null;
		}

		this.items.forEach((item) => item.classList.remove("is-active"));
		this.items = [];
		this.style.removeProperty("--progress");
	}
}

customElements.define("cinq-vertical-pipeline", VerticalPipeline);
