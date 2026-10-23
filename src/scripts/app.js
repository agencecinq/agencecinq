import { load } from "piecesjs";

import "@agencecinq/drawer";

load("cinq-modal", () => import("@agencecinq/modal"));
load("cinq-accordion", () => import("@agencecinq/accordion"));
load("cinq-grid", () => import("./components/Grid.ts"));
load("cinq-hover-video", () => import("./components/HoverVideo.ts"));
load("cinq-snake", async () => {
	await import("@agencecinq/snake");
	await import("./components/Snake.ts");
});
load("cinq-vertical-pipeline", () => import("./components/VerticalPipeline.ts"));
load("cinq-copy", () => import("./components/Copy.ts"));
load("cinq-configurator", () => import("./components/Configurator.ts"));
load("cinq-mobile-menu", () => import("./components/MobileMenu.ts"));
