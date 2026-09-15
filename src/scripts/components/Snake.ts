import type { Detail, Snake } from "@agencecinq/snake";

/** Target cell size in CSS px. Keeps tiles square as the viewport changes. */
const CELL = 46;

/**
 * Fit `cols` / `rows` to the canvas box, then re-measure the bitmap.
 * Attribute writes reset the board, so they run only when the grid changes.
 */
const fitGrid = (host: Snake, width: number, height: number): void => {
	if (width < 1 || height < 1) {
		return;
	}

	const cols = Math.max(8, Math.round(width / CELL));
	const rows = Math.max(6, Math.round(height / CELL));

	if (host.cols !== cols) {
		host.setAttribute("cols", String(cols));
	}

	if (host.rows !== rows) {
		host.setAttribute("rows", String(rows));
	}

	host.sync();
};

/**
 * Re-measure <cinq-snake> bitmaps when the canvas box changes,
 * and bind consumer score / replay markup.
 */
const bind = (host: Snake): void => {
	const canvas = host.querySelector("canvas");
	const score = host.querySelector("[data-score]");
	const replay = host.querySelector<HTMLButtonElement>("[data-replay]");

	if (canvas) {
		const observer = new ResizeObserver((entries) => {
			const { width, height } = entries[0]?.contentRect ?? canvas.getBoundingClientRect();

			fitGrid(host, width, height);
		});

		observer.observe(canvas);
	}

	if (score) {
		host.addEventListener("snake:eat", (event) => {
			score.textContent = String((event as CustomEvent<Detail>).detail.score);
		});
	}

	if (replay) {
		host.addEventListener("snake:over", () => {
			replay.hidden = false;
		});

		host.addEventListener("snake:replay", (event) => {
			replay.hidden = true;

			if (score) {
				score.textContent = String((event as CustomEvent<Detail>).detail.score);
			}
		});

		replay.addEventListener("click", () => {
			host.replay();
		});
	}
};

document.querySelectorAll("cinq-snake").forEach((host) => {
	bind(host as Snake);
});
