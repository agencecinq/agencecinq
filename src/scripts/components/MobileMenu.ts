import { Piece } from 'piecesjs';
import { addTrapFocus, getFocusableElements, removeTrapFocus } from '@agencecinq/utils';

/**
 * Mobile menu: toggles between main panel and sub panels (open sub / back to main).
 * Uses focus trap so Tab cycles only within the visible panel.
 */
class MobileMenu extends Piece {
	private $main: HTMLElement | null = null;
	private $subPanels: HTMLElement[] = [];
	/** Button that opened the current sub panel (for focus return on back). */
	private $lastOpenSub: HTMLButtonElement | null = null;

	constructor() {
		super('MobileMenu');
	}

	mount(): void {
		this.$main = this.domAttr('main') as HTMLElement | null;
		this.$subPanels = Array.from(this.domAttrAll('sub'));

		this.on('click', this, this.handleClick);
	}

	private handleClick = (e: Event): void => {
		const target = e.target as HTMLElement;
		const openSub = target.closest<HTMLButtonElement>('[data-dom="open-sub"]');
		const backBtn = target.closest<HTMLButtonElement>('[data-dom="back-to-main"]');

		if (openSub) {
			const id = openSub.getAttribute('data-open-sub');
			if (id) {
				this.$lastOpenSub = openSub;
				this.showSub(id);
			}
		} else if (backBtn) {
			this.showMain();
		}
	};

	private showMain(): void {
		if (this.$main) {
			this.$main.style.removeProperty('display');
			this.$main.removeAttribute('aria-hidden');
		}
		this.$subPanels.forEach((panel) => {
			panel.style.setProperty('display', 'none');
			panel.setAttribute('aria-hidden', 'true');
		});
		Array.from(this.domAttrAll('open-sub')).forEach((btn) => {
			(btn as HTMLButtonElement).setAttribute('aria-expanded', 'false');
		});
		// Remove trap from sub panel and return focus to the button that opened it.
		const returnFocusTo = this.$lastOpenSub;
		this.$lastOpenSub = null;
		removeTrapFocus(returnFocusTo ?? null);
		// Trap focus in the main panel (keep focus on the button we returned to if any).
		if (this.$main) {
			const focusables = getFocusableElements(this.$main);
			if (focusables.length) addTrapFocus(this.$main, returnFocusTo ?? focusables[0]);
		}
	}

	private showSub(id: string): void {
		if (this.$main) {
			this.$main.style.setProperty('display', 'none');
			this.$main.setAttribute('aria-hidden', 'true');
		}
		const activePanel = this.$subPanels.find((panel) => panel.getAttribute('data-sub-id') === id);
		this.$subPanels.forEach((panel) => {
			const isActive = panel === activePanel;
			panel.style.setProperty('display', isActive ? 'flex' : 'none');
			panel.setAttribute('aria-hidden', String(!isActive));
		});
		Array.from(this.domAttrAll('open-sub')).forEach((btn) => {
			(btn as HTMLButtonElement).setAttribute(
				'aria-expanded',
				btn.getAttribute('data-open-sub') === id ? 'true' : 'false',
			);
		});
		// Trap focus in the sub panel and focus first focusable.
		if (activePanel) {
			const focusables = getFocusableElements(activePanel);
			if (focusables.length) addTrapFocus(activePanel, focusables[0]);
		}
	}

	unmount(): void {
		this.off('click', this, this.handleClick);
		removeTrapFocus();
	}
}

customElements.define('cinq-mobile-menu', MobileMenu);
