import { load } from "piecesjs";

import "@agencecinq/drawer";

load("cinq-modal", async () => {
	// Invoker commands open and close the modal: Safari 26.2, Chrome 139 for request-close.
	if (!("command" in HTMLButtonElement.prototype)) {
		await import("invokers-polyfill");
	}

	await import("@agencecinq/modal");
});
load("cinq-accordion", () => import("@agencecinq/accordion"));
load("cinq-disclosure-button", () => import("@agencecinq/disclosure-button"));
load("cinq-disclosure-navigation", () => import("@agencecinq/disclosure-navigation"));
load("cinq-switch", () => import("@agencecinq/switch"));
load("cinq-windowsplitter", () => import("@agencecinq/windowsplitter"));
load("cinq-grid", () => import("./components/Grid.ts"));
load("cinq-snake", async () => {
	await import("@agencecinq/snake");
	await import("./components/Snake.ts");
});
load("cinq-toast", async () => {
	await import("@agencecinq/toast");
	await import("./components/FormToast.ts");
});
load("cinq-consent", () => import("./components/Consent.ts"));
load("cinq-scheme", () => import("./components/Scheme.ts"));
