import { Piece } from "piecesjs";
import Splide from "@splidejs/splide";

class Slideshow extends Piece {
	$slider: HTMLElement | null = null;
	$controls: HTMLElement | null = null;
	buttons: HTMLButtonElement[] | null = null;

	private splide: Splide | null = null;

	private handlePageClick = (event: Event) => {
		event.preventDefault();
		if (!this.splide || !this.buttons) return;
		const target = event.currentTarget as HTMLButtonElement | null;
		if (!target) return;
		const i = this.buttons.indexOf(target);
		if (i >= 0) this.splide.go(i);
	};

	private updateControls = () => {
		if (!this.splide || !this.$slider) return;
		const index = this.splide.index;

		if (this.buttons?.length) {
			this.buttons.forEach(($button) => $button.removeAttribute("aria-current"));
			if (this.buttons[index]) {
				this.buttons[index].setAttribute("aria-current", "true");
			}
		}

		const $current = this.domAttr("current") as HTMLElement | null;
		if ($current) $current.textContent = (index + 1).toString();
	};

	constructor() {
		super("Slideshow");
	}

	mount() {
		this.$slider = this.domAttr(`slider`) as HTMLElement;
		if (!this.$slider) throw new Error("Slider element is required");

		this.$controls = this.domAttr(`controls`) as HTMLElement;

		if (this.$controls) {
			this.buttons = Array.from(this.$controls.querySelectorAll("button"));
		}

		const focus: number | "center" = this.$slider.dataset.focus === "center" ? "center" : 0;
		const gap = JSON.parse(this.$slider.dataset.gap ?? '["0.625rem", "1.25rem"]');

		const options = {
			type: "slide",
			gap: gap[1],
			autoWidth: true,
			breakpoints: {
				1024: {
					gap: gap[0],
					padding: gap[0],
				},
			},
			padding: 0,
			pagination: false,
			focus,
			omitEnd: true,
			arrows: !!this.$slider.querySelector(".splide__arrows"),
		};

		this.splide = new Splide(this.$slider, options);

		if (this.buttons?.length) {
			this.buttons.forEach(($b) => this.on("click", $b, this.handlePageClick));
		}
		this.splide.on("mounted move updated", this.updateControls);

		this.splide.mount();
	}

	unmount() {
		if (this.buttons?.length) {
			this.buttons.forEach(($b) => this.off("click", $b, this.handlePageClick));
		}
		this.splide?.off("mounted move updated");
		if (this.splide) {
			this.splide.destroy(true);
			this.splide = null;
		}
	}
}

customElements.define("cinq-slideshow", Slideshow);
