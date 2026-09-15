# Agence Cinq

WordPress theme for [agencecinq.com](https://agencecinq.com) (Timber/Twig, Vite, Tailwind CSS v4, TypeScript).

## Stack

- **Templating**: Timber 2 + Twig. Root `*.php` files are WordPress routers that load a Timber context and render `views/pages/`.
- **Build**: Vite (`pnpm dev` / `pnpm build`), `laravel-vite-plugin`. Entries: `src/stylesheets/styles.css`, `src/scripts/app.js`. Output in `dist/` (gitignored).
- **CSS**: Tailwind CSS v4 in pure CSS. Design tokens live in `@theme` (`src/stylesheets/theme.css`).
- **JS**: TypeScript components in `src/scripts/components/`, mounted via `piecesjs`. Global `cinq` object injected from PHP (`includes/Setup/Enqueue.php`).
- **Packages**: `@agencecinq/accordion`, `@agencecinq/drawer`, `@agencecinq/modal`, `@agencecinq/utils`, plus GSAP.
- **PHP**: OOP, PSR-4 (`AgenceCinq\` → `includes/`), WordPress Coding Standards (`phpcs.xml`).
- **Fields**: ACF groups in PHP under `includes/Plugins/ACF/IncludeFields/` (layouts in `Layouts/`).
- **i18n**: text domain `agencecinq`, files in `languages/`.
- **Deploy**: `deploy.sh` on GitHub release tags `v`* (`.github/workflows/release.yml`).



## Content architecture



### Homepage hero

The front page hero is **not** a flexible block. It is defined by `FrontPageFields` and rendered in `views/pages/front-page.html.twig` (title, quote, client logos, GitHub repositories marquee).

Repositories are fetched from the GitHub org API (`includes/GitHub/Repositories.php`), cached in a transient, and exclude forks/archived repos. Optional token: `CINQ_GITHUB_TOKEN` in `wp-config.php`. Marquee duration scales with the number of repos (5s per item).

### Flexible blocks

Layouts are registered in `BlocksFields` and rendered via `views/blocks/blocks.html.twig` (name `snake_case` → template `kebab-case.html.twig`).


| Layout             | Twig                           |
| ------------------ | ------------------------------ |
| Accordion Group    | `accordion-group.html.twig`    |
| Call To Action     | `call-to-action.html.twig`     |
| Client Quote       | `client-quote.html.twig`       |
| Credibility Banner | `credibility-banner.html.twig` |
| Crosslinks         | `crosslinks.html.twig`         |
| Editorial Prose    | `editorial-prose.html.twig`    |
| Entry Points       | `entry-points.html.twig`       |
| Form + Info        | `form-info.html.twig`          |
| Latest Posts       | `latest-posts.html.twig`       |
| Page Hero          | `page-hero.html.twig`          |
| Positioning Banner | `positioning-banner.html.twig` |
| Pricing Rules      | `pricing-rules.html.twig`      |
| Pricing Tiers      | `pricing-tiers.html.twig`      |
| References         | `references.html.twig`         |
| Related Cases      | `related-cases.html.twig`      |
| Services           | `services.html.twig`           |
| Stats              | `stats.html.twig`              |
| Styleguide         | `styleguide.html.twig`         |
| Subscriptions      | `subscriptions.html.twig`      |
| Team               | `team.html.twig`               |
| Vertical Pipeline  | `vertical-pipeline.html.twig`  |


**Page Hero** (`page_hero` / `components/page-hero.html.twig`): inner-page hero (overline, title, lead, CTAs). Shared by the flexible block and the default page layout. On default pages, the lead is the WordPress excerpt; heading level for the block lives under **Settings** (default `h1`).

### Other page types

- **Case studies**: CPT + dedicated hero fields (`CaseStudyFields`), template `views/pages/single-case-study.html.twig`.
- **Default pages**: `components/page-hero.html.twig` (overline + title + excerpt + CTAs via `PageFields`), WordPress editor for the body, optional flexible blocks. Richer layouts use the **Blocks** page template (same Page Hero component as a flexible block).
- **Blog archive**: options in `ArchivePostsFields`.



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

Activate required plugins (ACF, etc.) in WordPress.

### SVG sprite

Icons in `src/icons/` are compiled to `public/sprite.svg` on build. Use `views/svg/use.html.twig`:

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



### Responsive images

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

`image` (ID or Timber image) is required. SVG/GIF skip WebP conversion. See the component docblock for options.

### Static images

```twig
<img src="{{ assets('src/img/logo.png') }}" alt="Logo" width="200" height="100" />
```



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
│   ├── img/
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