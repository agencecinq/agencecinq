import { Piece } from 'piecesjs';

const STORAGE_KEY = 'cinq-grid';

class Grid extends Piece {
	constructor() {
		super('Grid');
	}

	mount(): void {
		const stored = sessionStorage.getItem(STORAGE_KEY);

		if (stored === 'on' || (stored === null && import.meta.env.DEV)) {
			this.hidden = false;
		}

		document.addEventListener('keydown', this.onKeydown);
	}

	unmount(): void {
		document.removeEventListener('keydown', this.onKeydown);
	}

	private onKeydown = (event: KeyboardEvent): void => {
		if (event.key !== 'g' && event.key !== 'G') {
			return;
		}

		if (event.metaKey || event.ctrlKey || event.altKey) {
			return;
		}

		const target = event.target as HTMLElement | null;

		if (target?.closest('input, textarea, select, [contenteditable="true"]')) {
			return;
		}

		event.preventDefault();
		this.hidden = !this.hidden;
		sessionStorage.setItem(STORAGE_KEY, this.hidden ? 'off' : 'on');
	};
}

customElements.define('cinq-grid', Grid);
