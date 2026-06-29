import { Piece } from "piecesjs";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

class Marquee extends Piece {
	private items: HTMLElement[] = [];
	private scrollTrigger: ScrollTrigger | null = null;
	private mm: ReturnType<typeof gsap.matchMedia> | null = null;

	constructor() {
		super("Marquee");
	}

	private setAnimationPlayState(state: "running" | "paused") {
		this.items.forEach(($el) => {
			$el.style.animationPlayState = state;
		});
	}

	mount() {
		this.items = this.$All<HTMLElement>(".animate-marquee");

		if (!this.items.length) {
			return;
		}

		this.setAnimationPlayState("paused");

		this.mm = gsap.matchMedia();

		this.mm.add(
			{
				reduce: "(prefers-reduced-motion: reduce)",
				noReduce: "(prefers-reduced-motion: no-preference)",
			},
			(context) => {
				if (context.conditions?.reduce) {
					this.setAnimationPlayState("paused");
					return;
				}

				const st = ScrollTrigger.create({
					trigger: this,
					start: "top center",
					onEnter: () => {
						this.setAnimationPlayState("running");
						st.kill();
						this.scrollTrigger = null;
					},
				});

				this.scrollTrigger = st;

				return () => {
					if (this.scrollTrigger) {
						this.scrollTrigger.kill();
						this.scrollTrigger = null;
					}
					this.setAnimationPlayState("paused");
				};
			},
		);
	}

	unmount() {
		if (this.mm) {
			this.mm.revert();
			this.mm = null;
		}

		if (this.scrollTrigger) {
			this.scrollTrigger.kill();
			this.scrollTrigger = null;
		}

		this.items = [];
	}
}

customElements.define("cinq-marquee", Marquee);
