# Agence Cinq

WordPress theme for [agencecinq.com](https://agencecinq.com) (Timber/Twig, Vite, Tailwind CSS v4, TypeScript).

## Stack

- **Templating**: Timber 2 + Twig. Root `*.php` files are WordPress routers that load a Timber context and render `views/pages/`.
- **Build**: Vite (`pnpm dev` / `pnpm build`), `laravel-vite-plugin`. Entries: `src/stylesheets/styles.css`, `src/scripts/app.js`. Output in `dist/` (gitignored).
- **CSS**: Tailwind CSS v4 in pure CSS. Design tokens live in `@theme` (`src/stylesheets/theme.css`), with the code syntax of the variables on the Fondations page of the Figma file « CINQ · Site · Conception 2027 ».
- **Fonts**: Inter and JetBrains Mono are self-hosted (latin woff2 in `src/fonts/`, `@font-face` in `src/stylesheets/base/font-face.css`), preloaded from `Enqueue::preload_resources()`. No request to Google Fonts.
- **JS**: TypeScript components in `src/scripts/components/`, loaded by `piecesjs` when their element is in the page.
- **Packages**: `@agencecinq/accordion`, `@agencecinq/disclosure-button`, `@agencecinq/disclosure-navigation`, `@agencecinq/drawer`, `@agencecinq/modal`, `@agencecinq/snake`, `@agencecinq/switch`, `@agencecinq/toast`, `@agencecinq/utils`, `@agencecinq/windowsplitter`; `invokers-polyfill` loads only where the browser lacks invoker commands.
- **PHP**: OOP, PSR-4 (`AgenceCinq\` → `includes/`), WordPress Coding Standards (`phpcs.xml`).
- **Fields**: ACF groups in PHP under `includes/Plugins/ACF/IncludeFields/` (layouts in `Layouts/`).
- **i18n**: text domain `agencecinq`, files in `languages/`.
- **Deploy**: `deploy.sh` on GitHub release tags `v`* (`.github/workflows/release.yml`).

## Content architecture

Every section of the Figma file is built either as a flexible block or in a template. The description of each Figma section ends with a « Code » note on how the theme builds it.

### Homepage hero

The front page hero is **not** a flexible block. It is defined by `FrontPageFields` (eyebrow, title, text, links, and the diff of the site in a Diff tab) and rendered in `views/pages/front-page.html.twig`.

The Activity log block reads the repositories of the GitHub organization (`includes/GitHub/Activity.php`), cached in a transient and refreshed by a cron event. Optional token: `CINQ_GITHUB_TOKEN` in `wp-config.php`.

### Flexible blocks

Layouts are registered in `BlocksFields` and rendered via `views/blocks/blocks.html.twig` (name `snake_case` → template `kebab-case.html.twig`). Each one is a Figma section of the same name.

| Layout          | Twig                        |
| --------------- | --------------------------- |
| Accordion       | `accordion.html.twig`       |
| Action cards    | `action-cards.html.twig`    |
| Activity log    | `activity-log.html.twig`    |
| Breadcrumb      | `breadcrumb.html.twig`      |
| Bullet list     | `bullet-list.html.twig`     |
| Checklist       | `checklist.html.twig`       |
| Comparison      | `comparison.html.twig`      |
| Contact details | `contact-details.html.twig` |
| CTA             | `cta.html.twig`             |
| Diff columns    | `diff-columns.html.twig`    |
| Feature cards   | `feature-cards.html.twig`   |
| Image cards     | `image-cards.html.twig`     |
| Link columns    | `link-columns.html.twig`    |
| Link grid       | `link-grid.html.twig`       |
| Link row        | `link-row.html.twig`        |
| Listing header  | `listing-header.html.twig`  |
| Logo wall       | `logo-wall.html.twig`       |
| Numbered list   | `numbered-list.html.twig`   |
| Page header     | `page-header.html.twig`     |
| Portrait grid   | `portrait-grid.html.twig`   |
| Post grid       | `post-grid.html.twig`       |
| Price breakdown | `price-breakdown.html.twig` |
| Pricing table   | `pricing-table.html.twig`   |
| Quote           | `quote.html.twig`           |
| Rich text       | `rich-text.html.twig`       |
| Signup form     | `signup-form.html.twig`     |
| Steps           | `steps.html.twig`           |

Paddings default to 104 px top and bottom, ×0.75 on mobile; the color scheme of a block is set under **Settings**. The Pricing table and the Action cards read their prices from the public catalogue served by Central (`includes/Catalogue/`).

### Other page types

- **Default pages** (legal pages): `components/page-header.html.twig` (eyebrow, title, excerpt and links via `PageFields`), then the WordPress editor as Rich text, then optional flexible blocks. Richer layouts use the **Blocks** page template.
- **Case studies**: the archive shows the blocks of the page set in **Settings › Reading › Case studies page**; a case study opens with the Page header from its hero fields (`CaseStudyFields`), then its blocks. Case study categories only sort them in the admin.
- **Blog**: the blog, its categories and its authors show the blocks of the page for posts (Listing header, Post grid, Signup form). A post (`views/pages/single-post.html.twig`) ends with its author, the posts to read next and the Signup form of the page for posts. Authors have a Job and a Portrait (`UserFields`).
- **404**: the Status message over the snake, its texts in the theme options.
- **Sitemap**: the Link columns block shows the Sitemap Menu location.
- **Overlays**: the cookie banner and its choices (`components/consent.html.twig`), the toasts that show the result of the Contact Form 7 forms (`components/toast.html.twig`), and the Modal (`components/modal.html.twig`). The Cookies item of the legal menu links to `#cookies`.
- **Styleguide**: page template `page-templates/styleguide-page.php` (`noindex`, no ACF fields), a live catalog of the Figma foundations and components, each component in a Dark then a Light panel, rendered by `views/pages/styleguide-page.html.twig` from `includes/Models/StyleguidePage.php`. Inline scripts print the rendered values of the samples (colour, type, space, grid), so `theme.css` stays their only source.

## Workflows (AI-assisted)

Cursor rules in `.cursor/rules/`:

- `theme-cinq` (always on): stack, conventions, WPCS, living DO/DONT list.
- `design-tokens`: colors, typography, rem/em — no hardcoded values.
- `twig-components`: guards and param naming in reusable Twig components.
- `twig-wpcs`: Twig filter spacing compatible with Prettier.
- `schema-org`: schema.org microdata in Twig.
- `typescript-components`: native `#` private fields (not `private`).
- `git-commits`: English commit messages with gitmoji.

## Getting started

Prerequisites: PHP 8.4, Composer, pnpm, Node 22.

```bash
cp .env.sample .env   # set APP_URL=https://agencecinq.local (no trailing slash)
composer install
pnpm install
pnpm build            # also generates public/sprite.svg from src/icons/
pnpm dev              # Vite HMR
```

Activate the required plugins in WordPress: ACF Pro, Contact Form 7, Yoast SEO and CINQ SVG (SVG uploads, for the logos).

The single post reads its reading time from the [`cinq-wp-reading-time`](https://github.com/agencecinq/cinq-wp-reading-time) mu-plugin: copy (or symlink) `cinq-wp-reading-time.php` into `wp-content/mu-plugins/`. Without it the post renders without reading time.

The block editor and the block styles are turned off by the [`cinq-wp-classic-editor`](https://github.com/agencecinq/cinq-wp-classic-editor) mu-plugin: copy (or symlink) `cinq-wp-classic-editor.php` into `wp-content/mu-plugins/` on every environment, and remove the Classic Editor plugin it replaces. Without it the front end loads `wp-block-library`, the global styles and the classic theme styles: the theme does not remove them itself.

In Yoast SEO, enable **Settings → Advanced → Crawl optimization → Remove emoji scripts** on every environment: the theme does not remove them itself.

### Asset caching

`.htaccess` serves `dist/` with `Cache-Control: public, max-age=31536000, immutable`: Vite puts a content hash in every file name there. Apache only (`mod_headers` + `AllowOverride`); on Nginx, set the header in the server config.

### Color modes

The site is dark (`<meta name="color-scheme" content="dark">`). The color schemes live in `includes/schemes.php`: a section switches with `data-scheme` (`data-scheme="light"`, or empty for the scheme of the page) and keeps its color classes, the colors of the scheme being printed as CSS variables. The color scheme of a block is set under **Settings**.

### Page navigation

Pages cross-fade with the browser's view transition (`src/stylesheets/utilities/view-transition.css`, skipped under `prefers-reduced-motion`). `Enqueue::speculation_rules_configuration()` prefetches a linked page after a short hover (`prefetch`, `moderate`) instead of on click as in core; add `no-prefetch` to an internal link whose visit changes something. No View Transitions or Speculative Loading plugin needed.

### SVG sprite

Icons in `src/icons/` are compiled to `public/sprite.svg` on build. They are the icons of the Figma Components page, under their Figma name (`arrow`, `asterisk`, `box`, `check`, `check-box`, `chevron-*`, `close`, `external`, `menu`, `minus`, `plus`), and the `logo`: shapes without color, filled with the text color. Use `views/svg/use.html.twig`:

```twig
{{
	include(
		'svg/use.html.twig',
		{
			icon: 'icon-name',
			title: 'Icon Title',
			classes: [ 'custom-class' ],
		}
	)
}}
```

### Responsive images

```twig
{{
	include(
		'components/image.html.twig',
		{
			image: post.thumbnail,
			alt: post.title,
			sizes: '(max-width: 600px) 100vw, 600px',
			classes: [ 'custom-image-class' ],
		}
	)
}}
```

`image` (ID or Timber image) is required. SVG/GIF skip WebP conversion. See the component docblock for options.

### PHP CodeSniffer

```bash
./vendor/bin/phpcs
```

### Twig cache

When `WP_DEBUG` is false, clear Twig cache after template changes:

```bash
rm -rf vendor/timber/timber/cache/*
```

## Structure

```
agencecinq/
├── .cursor/             # Rules + skills
├── .github/workflows/   # Release on tag v*
├── includes/            # PHP (Setup/, GitHub/, Models/, Plugins/ACF/, Post/, …)
├── languages/           # i18n
├── src/
│   ├── stylesheets/     # theme.css = @theme tokens
│   ├── scripts/         # TypeScript (piecesjs components)
│   ├── icons/           # → public/sprite.svg
│   └── fonts/
├── views/               # pages/, blocks/, components/, svg/
├── public/
├── deploy.sh
├── .env.sample
├── composer.json
├── package.json
├── phpcs.xml
└── vite.config.js
```

## Resources

- [Twig](https://twig.symfony.com/doc/)
- [Timber](https://timber.github.io/docs/)
- [Tailwind CSS](https://tailwindcss.com/docs)
- [WordPress themes](https://developer.wordpress.org/themes/)
- [Vite](https://vitejs.dev/)
- [ACF](https://www.advancedcustomfields.com/resources/)

## License

MIT. See [LICENSE](LICENSE).
