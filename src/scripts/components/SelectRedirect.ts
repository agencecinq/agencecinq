import { Piece } from 'piecesjs';

/**
 * Generic component: when the inner <select> value changes, redirect to that URL.
 * Use for language switchers or any select whose option values are URLs.
 */
class SelectRedirect extends Piece {
	private $select: HTMLSelectElement | null = null;

	constructor() {
		super('SelectRedirect');
	}

	mount() {
		this.$select = (this.domAttr('select') || this.querySelector('select')) as HTMLSelectElement | null;

		if (!this.$select) {
			return;
		}

		this.on('change', this.$select, () => {
			if (this.$select?.value) {
				window.location.href = this.$select.value;
			}
		});
	}
}

customElements.define('cinq-select-redirect', SelectRedirect);
