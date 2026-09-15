import { Piece } from 'piecesjs';

const STORAGE_KEY = 'cinq-grid';

class Grid extends Piece {
	constructor() {
		super('Grid');
	}

	mount(): void {
		const stored = sessionStorage.getItem(STORAGE_KEY);

		// @ts-expect-error Vite injects import.meta.env (not on default ImportMeta).
		if (stored === 'on' || (stored === null && import.meta.env.DEV)) {
			this.hidden = false;
		}

		document.addEventListener('keydown', this.#onKeydown);
	}

	unmount(): void {
		document.removeEventListener('keydown', this.#onKeydown);
	}

	#onKeydown = (event: KeyboardEvent): void => {
		const { key, metaKey, ctrlKey, altKey, target } = event;

		if (key !== 'g' && key !== 'G') {
			return;
		}

		if (metaKey || ctrlKey || altKey) {
			return;
		}

		if (target instanceof HTMLElement && target.closest('input, textarea, select, [contenteditable="true"]')) {
			return;
		}

		event.preventDefault();
		this.hidden = !this.hidden;
		sessionStorage.setItem(STORAGE_KEY, this.hidden ? 'off' : 'on');
	};
}

customElements.define('cinq-grid', Grid);
