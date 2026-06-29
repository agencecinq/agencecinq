type ThemeData = {
	template_directory_uri: string;
	base_url: string;
	home_url: string;
	ajax_url: string;
	api_url: string;
	current_url: string;
	nonce: string;
	text_domain: string;
	strings?: {
		error_default?: string;
	};
};

declare const cinq: ThemeData;

declare global {
	interface Window {
		cinq: ThemeData;
	}
}

export {};
