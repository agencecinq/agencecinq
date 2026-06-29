import { Piece } from "piecesjs";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

type Config = {
	prototype: number;
	width: number;
	height: number;
	/** Scroll progress (0–1) after which the rectangle starts growing. */
	start: number;
};

const DESKTOP: Config = { prototype: 1440, width: 408, height: 248, start: 0.5 };
const MOBILE: Config = { prototype: 402, width: 142, height: 224, start: 0.2 };

class MediaTextReveal extends Piece {
	private $mask!: HTMLElement;
	private config: Config = DESKTOP;
	private inset: { top: number; right: number; bottom: number; left: number } | null = null;
	private scrollTrigger: ScrollTrigger | null = null;
	private mm: ReturnType<typeof gsap.matchMedia> | null = null;
	private resizeObserver: ResizeObserver | null = null;
	private layoutRaf: number | null = null;

	constructor() {
		super("MediaTextReveal");
	}

	private getSize(): { width: number; height: number } {
		const { prototype, width, height } = this.config;
		const scale = window.innerWidth / prototype;
		return { width: width * scale, height: height * scale };
	}

	private getPercentages($mask: HTMLElement): {
		top: number;
		right: number;
		bottom: number;
		left: number;
	} {
		const { width: rectW, height: rectH } = this.getSize();
		const width = $mask.offsetWidth;
		const height = $mask.offsetHeight;
		const top = Math.max(0, (height - rectH) / 2 / height) * 100;
		const left = Math.max(0, (width - rectW) / 2 / width) * 100;

		return { top, right: left, bottom: top, left };
	}

	private reveal(progress: number) {
		if (!this.inset) {
			return;
		}

		const start = this.config.start;
		const reveal = progress <= start ? 0 : (progress - start) / (1 - start);
		const factor = 1 - reveal;
		const { top, right, bottom, left } = this.inset;

		gsap.set(this.$mask, {
			clipPath: `inset(${top * factor}% ${right * factor}% ${bottom * factor}% ${left * factor}%)`,
		});
	}

	private handleResize() {
		if (!this.scrollTrigger) {
			return;
		}

		this.inset = this.getPercentages(this.$mask);
		this.reveal(this.scrollTrigger.progress);
		ScrollTrigger.refresh();
	}

	/** Recalc when page height changes (accordion, dynamic content) without window resize. */
	private handleLayoutChange() {
		if (!this.scrollTrigger) return;
		if (this.layoutRaf != null) cancelAnimationFrame(this.layoutRaf);
		this.layoutRaf = requestAnimationFrame(() => {
			this.layoutRaf = null;
			this.handleResize();
		});
	}

	mount() {
		const $mask = this.domAttr("mask") as HTMLElement;

		if (!$mask) {
			console.warn("MediaTextReveal: mask element not found");
			return;
		}

		this.$mask = $mask;

		this.mm = gsap.matchMedia();

		this.mm.add(
			{
				desktop: "(min-width: 1024px)",
				mobile: "(max-width: 1023px)",
			},
			(context) => {
				this.config = context.conditions?.desktop ? DESKTOP : MOBILE;
				this.inset = this.getPercentages(this.$mask!);
				this.reveal(0);

				this.scrollTrigger = ScrollTrigger.create({
					trigger: this,
					start: "top bottom",
					end: "top top",
					scrub: true,
					onUpdate: ({ progress }) => this.reveal(progress),
				});

				this.on("resize", window, this.handleResize);

				this.resizeObserver = new ResizeObserver(() => this.handleLayoutChange());
				this.resizeObserver.observe(document.body);

				return () => {
					this.off("resize", window, this.handleResize);
					if (this.resizeObserver) {
						this.resizeObserver.disconnect();
						this.resizeObserver = null;
					}
					if (this.layoutRaf != null) cancelAnimationFrame(this.layoutRaf);
					if (this.scrollTrigger) {
						this.scrollTrigger.kill();
						this.scrollTrigger = null;
					}
				};
			},
		);
	}

	unmount() {
		if (this.mm) {
			this.mm.revert();
			this.mm = null;
		}

		this.inset = null;
	}
}

customElements.define("cinq-media-text-reveal", MediaTextReveal);
