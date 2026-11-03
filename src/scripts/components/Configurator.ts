import { Piece } from "piecesjs";
import type { Modal } from "@agencecinq/modal";
import type { Toast } from "@agencecinq/toast";

type Mode = "ferme" | "a_partir_de" | "sur_devis";

/** Answer of POST /wp-json/cinq/v1/estimate (Catalogue/EstimateRequest.php). */
interface Answer {
	email?: string;
	total?: string;
	code?: string;
	message?: string;
}

/**
 * The estimator (Figma Section/Configurator). CSS shows the packages of the checked platform and the modules
 * its package accepts; this sums the estimate of what is checked and shown, then sends the form. The answer
 * opens the confirmation dialog, any error shows in the error toast of the page.
 *
 * The total is the sum of the prices, nothing else: one « from » line makes it a floor, one « on quote » line
 * makes it a quote. The browser never sends a price: the server prices the estimate again.
 */
class Configurator extends Piece {
	#form: HTMLFormElement | null = null;
	#lines: HTMLElement | null = null;
	#line: HTMLTemplateElement | null = null;
	#total: HTMLElement | null = null;
	#firm: HTMLElement | null = null;
	#open: HTMLElement | null = null;
	#email: HTMLInputElement | null = null;
	#submit: HTMLButtonElement | null = null;
	#dialog: Modal | null = null;
	#format = new Intl.NumberFormat(document.documentElement.lang || undefined, {
		style: "currency",
		currency: "EUR",
		minimumFractionDigits: 0,
		maximumFractionDigits: 2,
	});

	constructor() {
		super("Configurator");
	}

	mount(): void {
		this.#form = this.querySelector("form");
		this.#lines = this.querySelector("[data-dom=lines]");
		this.#line = this.querySelector("template[data-dom=line]");
		this.#total = this.querySelector("[data-dom=total] dd");
		this.#firm = this.querySelector("[data-dom=firm]");
		this.#open = this.querySelector("[data-dom=open]");
		this.#email = this.querySelector("[data-dom=email]");
		this.#submit = this.querySelector("[data-dom=submit]");
		this.#dialog = this.querySelector<Modal>("cinq-modal");

		if (this.#form) {
			this.#form.noValidate = true;
		}

		this.#form?.addEventListener("change", this.#onChange);
		this.#form?.addEventListener("submit", this.#onSubmit);
		this.#email?.addEventListener("input", this.#onInput);

		this.#update();
	}

	unmount(): void {
		this.#form?.removeEventListener("change", this.#onChange);
		this.#form?.removeEventListener("submit", this.#onSubmit);
		this.#email?.removeEventListener("input", this.#onInput);
	}

	#onChange = (): void => {
		this.#update();
	};

	/** An error clears as soon as the address is valid, but never shows while typing. */
	#onInput = (): void => {
		if (this.#email?.hasAttribute("aria-invalid")) {
			this.#validate(false);
		}
	};

	#onSubmit = async (event: SubmitEvent): Promise<void> => {
		event.preventDefault();

		if (!this.#form || this.#submit?.disabled || !this.#validate(true)) {
			return;
		}

		this.#busy(true);

		try {
			const response = await fetch(this.#form.action, {
				method: "POST",
				body: new FormData(this.#form),
				headers: { Accept: "application/json" },
			});
			const answer: Answer = await response.json();

			this.#busy(false);
			this.#submit?.focus();

			if (response.ok) {
				await this.#confirm(answer);
			} else if (answer.code === "cinq_estimate_email") {
				this.#invalid(true);
				this.#email?.focus();
			} else {
				this.#toast(answer.message);
			}
		} catch {
			this.#busy(false);
			this.#submit?.focus();
			this.#toast();
		}
	};

	#update(): void {
		const platform = this.#checked('[name="platform"]')?.value;
		const pkg = this.#checked(`[name="package[${platform}]"]`);

		if (!pkg) {
			return;
		}

		const token = `${platform}:${pkg.value}`;
		const modules = [
			...this.querySelectorAll<HTMLInputElement>('[name="modules[]"]:checked'),
		].filter((input) =>
			input.closest<HTMLElement>("[data-packages]")?.dataset.packages?.split(" ").includes(token),
		);

		this.#render(pkg, modules);
		this.#sum([pkg, ...modules]);
	}

	#render(pkg: HTMLInputElement, modules: HTMLInputElement[]): void {
		if (!this.#lines || !this.#line) {
			return;
		}

		const rows = [pkg, ...modules].map((input) => {
			const row = this.#line!.content.cloneNode(true) as DocumentFragment;
			const name = input.dataset.name ?? "";

			row.querySelector("dt")!.textContent =
				input === pkg ? (this.dataset.package ?? "%s").replace("%s", name) : name;
			row.querySelector("dd")!.textContent = input.dataset.label ?? "";

			return row;
		});

		this.#lines.replaceChildren(...rows);
	}

	#sum(lines: HTMLInputElement[]): void {
		let amount = 0;
		let mode: Mode = "ferme";

		for (const input of lines) {
			const price = input.dataset.price ? Number(input.dataset.price) : null;

			if (input.dataset.mode === "sur_devis" || price === null) {
				mode = "sur_devis";
				continue;
			}

			amount += price;

			if (input.dataset.mode === "a_partir_de" && mode === "ferme") {
				mode = "a_partir_de";
			}
		}

		if (this.#total) {
			this.#total.textContent = {
				ferme: this.#format.format(amount),
				a_partir_de: (this.dataset.from ?? "%s").replace("%s", this.#format.format(amount)),
				sur_devis: this.dataset.quote ?? "",
			}[mode];
		}

		this.#firm?.toggleAttribute("hidden", mode !== "ferme");
		this.#open?.toggleAttribute("hidden", mode === "ferme");
	}

	#validate(focus: boolean): boolean {
		const valid = this.#email?.checkValidity() ?? false;

		this.#invalid(!valid);

		if (!valid && focus) {
			this.#email?.focus();
		}

		return valid;
	}

	#invalid(invalid: boolean): void {
		if (!this.#email) {
			return;
		}

		const error = document.getElementById(`${this.#email.id}-error`);

		error?.toggleAttribute("hidden", !invalid);

		if (invalid) {
			this.#email.setAttribute("aria-invalid", "true");
			this.#email.setAttribute("aria-describedby", `${this.#email.id}-error`);
		} else {
			this.#email.removeAttribute("aria-invalid");
			this.#email.removeAttribute("aria-describedby");
		}
	}

	#busy(busy: boolean): void {
		if (this.#submit) {
			this.#submit.disabled = busy;
			this.#submit.toggleAttribute("aria-busy", busy);
		}
	}

	/** The message is written once the dialog is open, so that its status region announces it. */
	async #confirm(answer: Answer): Promise<void> {
		if (!this.#dialog) {
			return;
		}

		const message = this.#dialog.querySelector<HTMLElement>("[data-template]");

		await this.#dialog.show();

		if (message) {
			message.textContent = (message.dataset.template ?? "")
				.replace("{total}", answer.total ?? "")
				.replace("{email}", answer.email ?? "");
		}
	}

	#toast(message?: string): void {
		document.querySelector<Toast>("#toast-error")?.show(message || this.dataset.error || "");
	}

	#checked(selector: string): HTMLInputElement | null {
		return this.querySelector<HTMLInputElement>(`${selector}:checked`);
	}
}

customElements.define("cinq-configurator", Configurator);
