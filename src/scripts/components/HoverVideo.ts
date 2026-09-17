import { Piece } from 'piecesjs';

/**
 * Plays an inner muted video while the host is hovered or focused.
 * On coarse pointers (no hover), plays while the host is in view.
 */
class HoverVideo extends Piece {
	#$video: HTMLVideoElement | null = null;
	#observer: IntersectionObserver | null = null;

	constructor() {
		super('HoverVideo');
	}

	mount(): void {
		this.#$video = this.querySelector('video');

		if (!this.#$video) {
			return;
		}

		if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
			return;
		}

		this.on('focusin', this, this.#play);
		this.on('focusout', this, this.#onFocusOut);

		if (window.matchMedia('(hover: hover)').matches) {
			this.on('pointerenter', this, this.#play);
			this.on('pointerleave', this, this.#pause);
			return;
		}

		this.#observer = new IntersectionObserver(
			([entry]) => {
				if (entry?.isIntersecting) {
					this.#play();
				} else {
					this.#pause();
				}
			},
			{ threshold: 0.6 },
		);
		this.#observer.observe(this);
	}

	unmount(): void {
		this.off('focusin', this, this.#play);
		this.off('focusout', this, this.#onFocusOut);
		this.off('pointerenter', this, this.#play);
		this.off('pointerleave', this, this.#pause);

		this.#observer?.disconnect();
		this.#observer = null;

		this.#pause();
		this.#$video = null;
	}

	#play = (): void => {
		void this.#$video?.play().catch(() => {
			// Ignore AbortError when pause interrupts a pending play().
		});
	};

	#pause = (): void => {
		if (!this.#$video) {
			return;
		}

		this.#$video.pause();
		this.#$video.currentTime = 0;
	};

	#onFocusOut = (event: FocusEvent): void => {
		const next = event.relatedTarget;

		if (next instanceof Node && this.contains(next)) {
			return;
		}

		this.#pause();
	};
}

customElements.define('cinq-hover-video', HoverVideo);
