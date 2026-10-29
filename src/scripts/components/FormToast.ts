import type { Toast } from "@agencecinq/toast";

/**
 * Show the result of a Contact Form 7 form in the toasts of the page (Figma Overlay/Toast): a sent form as a
 * status, any other result as an alert. The toasts become the only announcement, so the response output of
 * Contact Form 7 and its live region are hidden, where Contact Form 7 still writes, once this script runs:
 * without JavaScript, the form keeps them.
 */
const success = document.querySelector<Toast>("#toast-success");
const error = document.querySelector<Toast>("#toast-error");

if (success && error) {
	for (const output of document.querySelectorAll(
		".wpcf7 :is(.wpcf7-response-output, .screen-reader-response)",
	)) {
		output.setAttribute("hidden", "");
	}

	document.addEventListener("wpcf7submit", (event) => {
		const { status, message } = (event as CustomEvent).detail.apiResponse;
		const toast = status === "mail_sent" ? success : error;

		success.close();
		error.close();
		toast.show(message);
	});
}
