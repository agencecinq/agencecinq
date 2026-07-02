# WP CINQ – WordPress Starter Theme

**WP CINQ** is the agency's WordPress starter theme, built on Timber/Twig, Vite, Tailwind CSS v4 and TypeScript. It is the single source of truth for new client projects: every new project starts from this starter, never from a copy of the previous project.

It ships a generic, reusable foundation (block library, components, helpers, tooling) free of any client-specific content, so each project begins clean.

## Key features

- **Timber & Twig**: clean, reusable template components.
- **Modern tooling**: Composer, pnpm, Vite, TypeScript, PHP CodeSniffer (WPCS) and a GitHub release workflow.
- **Tailwind CSS v4**: design tokens declared in `@theme` (`src/stylesheets/theme.css`), no `tailwind.config.js`.
- **Accessibility**: semantic HTML, clear structure, ARIA best practices where relevant.
- **Performance**: optimized images (WebP, lazy‑loading), SVG sprite, minified assets in production.
- **Extensibility**: class‑based PHP in `includes/`, Twig components in `views/`, front‑end sources in `src/`.

## Workflows (AI-assisted)

This repository carries Cursor rules in `.cursor/rules/` that document conventions and automate the two key flows. They are the operational reference for the team:

- **`starter-cinq`** (always on): stack, conventions, coding standards (WPCS), language rules, and the living DO/DONT list. This is the base of truth and is meant to evolve over time.
- **`init-nouveau-projet`**: step-by-step procedure to turn this starter into a new client project (detect and replace identifiers, reset tokens, fonts, icons and assets). Use it when starting a new project.
- **`remontee-vers-starter`**: the reverse flow. When something built on a project is reusable, this procedure brings it back into the starter (re-neutralize identifiers, strip client content, version bump).

To add a new DO/DONT or a task-specific rule, follow the "Faire évoluer ces règles" section of `starter-cinq`.

## Getting started from the starter

When creating a new project from this starter, follow the `init-nouveau-projet` rule, then:

```bash
composer install
pnpm install
pnpm build      # also generates public/sprite.svg from src/icons/
pnpm dev        # local dev server
```

Replace the placeholder assets (`screenshot.png`, `src/img/svg/logo.svg`) and the example palette in `src/stylesheets/theme.css` with the project's own.

### SVG sprite support

Includes built-in support for SVG sprites, allowing you to easily manage and use SVG icons throughout your theme. SVG will be pickup from the `src/icons/` folder and compiled into a single sprite file during the build process. This file can then be referenced in your Twig templates for efficient icon usage. This file is located in `public/sprite.svg` after build. It is located in the public folder to allow easy access and avoid Vite processing.

The theme provide a Twig component located at `views/svg/use.html.twig` to facilitate the use of SVG icons from the sprite. You can include an icon in your templates like this:

```twig
{{
	include(
		'svg/use.html.twig',
		{
			icon: 'icon-name',
			title: 'Icon Title',
			classes: ['custom-class']
		}
	)
}}
```

The sprite itself is included in the theme's `index.html.twig` file to ensure it's available throughout the site:

```twig
<div style="display: none;">
	{{ include 'svg/sprite.html.twig' }}
</div>
```

### Responsive Images with WebP Support

The theme includes a custom Twig component for rendering responsive images with WebP support. This component automatically generates the necessary `srcset` and `sizes` attributes for optimal image loading across different devices and screen sizes.

You can use the image component in your Twig templates like this:

```twig
{{
	include(
		'components/image.html.twig',
		{
			image: post.thumbnail,
			alt: post.title,
			sizes: '(max-width: 600px) 100vw, 600px',
			classes: ['custom-image-class']
		}
	)
}}
```

It will be rendered as:

```html
<picture>
	<source
		type="image/webp"
		srcset="image-300.webp 300w, image-600.webp 600w, image-900.webp 900w"
		sizes="(max-width: 600px) 100vw, 600px"
	/>
	<img
		class="custom-image-class"
		width="600"
		height="400"
		loading="lazy"
		src="image-600.jpg"
		alt="Post Title"
		srcset="image-300.jpg 300w, image-600.jpg 600w, image-900.jpg 900w"
		sizes="(max-width: 600px) 100vw, 600px"
	/>
</picture>
```

> The only required parameter is `image`, which is an image ID or TimberImage object. Other parameters like `alt`, `sizes`, and `classes` are optional and can be customized as needed. See the comments in the `image.html.twig` file for more details on available parameters.

> The component also handle .svg images by rendering a simple `<img>` tag without `srcset` or `sizes` attributes. It will also skip WebP conversion for SVG images. Gif images are also handled as normal images without WebP conversion and compression.

### Static images support

The theme supports static images located in the `src/img/` directory. You can reference these images directly in your Twig templates thanks to the assets function provided by the Vite class PHP located in `includes/Vite.php`.

It's useful for images that don't require responsive handling or WebP conversion, such as logos or decorative images without losing dev and build mode benefits provided by Vite.

Example of usage in a Twig template:

```twig
<img src="{{ assets('src/img/logo.png') }}" alt="Logo" width="200" height="100" />
```

## Structure

The project structure is organized as follows:

```
wp-cinquante-et-un/
├── .cursor/rules/       # Cursor rules (conventions + init/back-port workflows)
├── .github/workflows/   # CI: release on tag v*
├── includes/            # PHP classes (PSR-4, namespace WPCinquanteEtUn)
├── languages/           # i18n (.pot template; translations generated per project)
├── src/                 # Source files for assets
│   ├── stylesheets/     # CSS (theme.css = @theme tokens, styles.css = imports)
│   ├── scripts/         # TypeScript components (mounted via piecesjs)
│   ├── icons/           # SVG icons compiled into public/sprite.svg
│   ├── img/             # Static images
|   └── fonts/           # Font files
├── views/               # Twig templates (pages/, blocks/, components/, svg/)
├── public/              # Compiled assets (sprite.svg, etc.)
├── deploy.sh            # Production build + dev-files purge (used by CI)
├── .env.sample          # Sample environment variables file
├── composer.json        # PHP dependencies
├── package.json         # JavaScript dependencies
├── phpcs.xml            # PHP CodeSniffer configuration (WPCS)
└── vite.config.js       # Vite configuration
```

### PHP CodeSniffer (phpcs.xml)

The `phpcs.xml` file configures **PHP CodeSniffer** (PHPCS) for the theme. It defines the coding style and quality rules applied to the PHP code.

In this theme, the configuration is based on the **WordPress Coding Standards**: indentation, naming, internationalization (text domain `wp-cinquante-et-un`), and more. The `node_modules/`, `vendor/`, and `dist/` directories are excluded from the analysis.

To run the code analysis (after installing PHPCS, e.g. via Composer or globally):

```bash
./vendor/bin/phpcs
```

Or if PHPCS is installed globally:

```bash
phpcs
```

This keeps the theme's PHP code aligned with WordPress standards and project conventions.

### PHP Classes

The PHP classes follow WordPress coding standards and are organized like WordPress core files. For example, the `after_setup_theme` hook is located in `includes/WPSettings.php` because this hook is located in wp-settings.php in WordPress core.

## Installation

Copy the environment template and set your local WordPress URL (used by the Vite dev server for full-page refresh):

```bash
cp .env.sample .env
```

Then edit `.env` and set `APP_URL` to your local site URL, derived from the project slug: `APP_URL = https://<slug>.local` (e.g. `https://wp-cinquante-et-un.local`), without a trailing slash. The Laravel Vite plugin loads these variables automatically.

### PHP Dependencies

Use Composer to install the required PHP dependencies:

```bash
composer install
```

Don't forget to install and activate the required WordPress plugins, such as ACF, to ensure full functionality of the theme.

### JavaScript Dependencies

Use pnpm to install the required JavaScript dependencies:

```bash
pnpm install
```

### Development Server

To start the development server with Vite, run:

```bash
pnpm dev
```

It will start a local development server and provide a URL to access your site.

### Building for Production

To build the assets for production, run:

```bash
pnpm build
```

### Twig Cache

When the WP_DEBUG constant is set to false (which is the default in production environments), Twig files are cached for performance. If you modify any Twig files, you need to clear the cache to see the changes. The cache folder is located at `vendor/timber/timber/cache`.

To clear the cache, simply delete the contents of the `cache` folder or run the following command:

```bash
rm -rf vendor/timber/timber/cache/*
```

### Troubleshooting

- If you encounter issues with Twig templates not updating, ensure you have cleared the cache as described above.
- Make sure all dependencies are installed correctly by running `composer install` and `pnpm install`.
- Check your local environment variables in the `.env` file to ensure they are set up correctly.

## Resources

- Twig documentation: [https://twig.symfony.com/doc/](https://twig.symfony.com/doc/)
- Timber documentation: [https://timber.github.io/docs/](https://timber.github.io/docs/)
- Tailwind CSS documentation: [https://tailwindcss.com/docs](https://tailwindcss.com/docs)
- WordPress Theme Development: [https://developer.wordpress.org/themes/](https://developer.wordpress.org/themes/)
- Vite documentation: [https://vitejs.dev/](https://vitejs.dev/)
- ACF documentation: [https://www.advancedcustomfields.com/resources/](https://www.advancedcustomfields.com/resources/)

## Contributing

Contributions are welcome! If you find a bug or have a feature request, please open an issue or submit a pull request.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
