---
name: figma-section
description: Implements a Figma selection as a CINQ WordPress theme section (Timber/Twig block, ACF PHP layout, Tailwind tokens, optional CPT/taxonomy/TS). Use when the user pastes a Figma "Copy link to selection" URL, asks to implement a section or flexible block from Figma, or requests ACF fields plus Twig plus styles for a design frame.
---

# Figma → section thème CINQ

Transforme une sélection Figma en brique du thème (Timber 2 + Twig, ACF PHP, Tailwind v4). Le code Figma MCP est une **référence**, jamais du code à coller.

## Prompt attendu

L'utilisateur fournit un lien Figma de sélection (`figma.com/design/:fileKey/:name?node-id=:nodeId`). Extraire `fileKey` et convertir `node-id` (`1-2` → `1:2`). Si l'URL n'a pas de `node-id`, demander le lien de sélection — ne pas inventer le nœud.

## Workflow

Copier et cocher :

```
- [ ] 0. Lire Figma (design-to-code + get_design_context)
- [ ] 1. CPT / taxonomie (seulement si le design l'exige)
- [ ] 2. Template Twig de la section
- [ ] 3. Tokens + Tailwind dans le Twig
- [ ] 4. Layout / groupe ACF en PHP
- [ ] 5. Composant TS (seulement si interaction)
- [ ] 6. Enregistrement (Init, BlocksFields, classmap)
```

Ne pas écrire de code avant l'étape 0.

### 0. Lire Figma

1. Charger le skill **figma-design-to-code** (obligatoire avant tout appel `get_design_context`).
2. Appeler `get_design_context` avec `fileKey`, `nodeId`, et `skillNames: "figma-design-to-code"`.
3. Adapter la référence React/Tailwind à ce thème. Réutiliser composants, tokens et layouts existants.

Images / icônes Figma MCP : URLs expirables. Ne pas committer ces URLs.

- Média éditorial → champ ACF `image` / clone `media`, rendu via `components/image.html.twig` ou `components/media.html.twig`.
- Icône UI absente du sprite → SVG dans `src/icons/`, `pnpm build`, usage via `views/svg/use.html.twig`. Ne dessiner aucun SVG à la main.

### Décider le type de livrable

| Le design est… | Livrable |
| --- | --- |
| Une section réutilisable sur page / case study | Layout flexible + Twig `views/blocks/` |
| Un type de contenu (archive, fiche, listing) | CPT (`includes/Post/`) ± taxonomie ± modèle Timber ± champs ACF dédiés |
| Les deux (ex. listing d'études de cas) | CPT **et** bloc qui le requête |

La plupart des sélections Figma = un **bloc flexible**. Ne créer un CPT que si le contenu doit être géré hors de la page (plusieurs fiches, archive, relation).

---

## 1. CPT (si nécessaire)

Pas de `register_post_type()` isolé. Classe PSR-4 qui implémente `Service`, calquée sur `includes/Post/CaseStudy.php`.

Fichiers :

- `includes/Post/{Name}.php` — `run()` → `add_action( 'init', … )` → `register_post_type()`.
- `includes/Taxonomy/{Name}.php` — seulement si le design a des filtres / catégories propres. Référence : `includes/Taxonomy/CaseStudyCategory.php`.
- `includes/Models/{Name}.php` — modèle Timber (`extends Timber\Post`) si la fiche a de la logique. Référence : `includes/Models/CaseStudy.php`.
- Enregistrer la classe dans `includes/Init.php` (`get_services()`).
- Si modèle Timber : ajouter le slug dans `includes/Setup/Context.php` (`add_post_classmap`).

Conventions :

- Namespace et text domain **lus** dans `composer.json` (`autoload.psr-4`) et `style.css` (`Text Domain`). Ne pas hardcoder un ancien projet.
- Labels i18n (`__()`, `_x()`) avec le text domain du thème.
- Code et commentaires en anglais. Docblock d'en-tête : `@package`, `@author CINQ <contact@agencecinq.com> (https://agencecinq.com)`.
- Identité agence (`CINQ`, email, URL) : ne jamais la remplacer.

## 2. Structure du template

Pas de `template-parts/sections/*.php` ni de `get_field()`. La présentation vit dans Twig.

**Bloc flexible** — `views/blocks/{name}.html.twig` :

- Nom de fichier = `acf_fc_layout` en kebab-case (`latest_posts` → `latest-posts.html.twig`). Résolu par `views/blocks/blocks.html.twig`.
- Données : objet `block` (meta ACF), pas `get_field()`.
- Toujours inclure `blocks/_layout.html.twig` avec `paddings: block.layout.paddings` et `id: block.id`.
- Wrapper : `<div id="{{ block.id }}">`.
- Réutiliser `views/components/` (`button`, `image`, `media`, `tag`, teases…). Gardes d'affichage **dans** le composant inclus (règle `twig-components`).
- Filtres Twig espacés : `foo | bar` (règle `twig-wpcs`).
- Schema.org microdata si un type correspond (règle `schema-org`).

**Page / single CPT** — routeur PHP à la racine (contexte Timber uniquement) + `views/pages/`. Pas de HTML dans le PHP.

Exemple d'ouverture de bloc :

```twig
{#
 # Blocks: {Name}
 #}

{{- include( 'blocks/_layout.html.twig', { paddings: block.layout.paddings, id: block.id } ) -}}

<div id="{{ block.id }}" class="text-cream">
	<div class="container">
		{%- if block.content.title -%}
			<{{ block.content.heading | default('h2') }} class="text-title-xl">
				{{- block.content.title -}}
			</{{ block.content.heading | default('h2') }}>
		{%- endif -%}
	</div>
</div>
```

Références : `views/blocks/page-hero.html.twig`, `views/blocks/services.html.twig`.

## 3. Styles

Pas de feuille `src/stylesheets/components/{name}.css`. Styler en **Tailwind v4 dans le Twig**, avec la syntaxe Tailwind (pas du CSS custom, pas de BEM).

1. Lire `src/stylesheets/theme.css` (`@theme`) et mapper les couleurs Figma sur les tokens de teinte (`black`, `pistachio`, `cream`) ; typo et radius gardent le suffixe Figma.
2. Token manquant → le déclarer dans `@theme` (couleur = teinte en anglais), puis l'utiliser (`bg-black`, `text-title-xxl`). Jamais `bg-[#…]`, `text-[22px]`, `tracking-[0.5px]`.
3. Tailles : rem ou échelle spacing (`w-11.5`, `gap-6.5`). Letter-spacing : em. Détail : règle `design-tokens`.
4. Typo responsive déjà exposée : classe publique (`text-title-xxl`), pas `-mobile` / `-desktop`.
5. Grille de page : `container` + `layout-grid` (`grid-cols-12 gap-x-4 lg:gap-x-6`), identique à l’overlay `views/components/grid.html.twig`. Gutters des sous-grilles (2 / 3 / 4 / 6 cols) : `gap-x-4 lg:gap-x-6` pour rester sur les mêmes lignes.
6. Espacement entre siblings : `space-y-*` / `space-x-*` sur le parent, pas `mt-*` / `ml-*` sur les enfants.
7. Décoration sans contenu (ligne, nœud, overlay) : `before:` / `after:`, pas un élément vide.
8. Syntaxe Tailwind native : utiliser l'utilitaire officiel, pas une valeur arbitraire équivalente. Le linter Tailwind le signale. Ex. `aspect-4/5` (pas `aspect-[4/5]`), `w-11.5` (pas `w-[2.875rem]` si l'échelle le permet).

## 4. Champs ACF

Source de vérité = PHP. Pas de JSON ACF à importer. Les `name` des champs = les clés Twig (`content.title` → `block.content.title`). Définir les noms ACF **avant** d'écrire le Twig.

**Bloc flexible** — `includes/Plugins/ACF/IncludeFields/Layouts/{Name}.php`, calqué sur ceci (remplacer `Example` / `example`, namespace et text domain lus dans le dépôt) :

```php
<?php
/**
 * ACF layout: Example
 *
 * @package WordPress
 * @subpackage AgenceCinq/Plugins/ACF/IncludeFields/Layouts
 */

namespace AgenceCinq\Plugins\ACF\IncludeFields\Layouts;

use AgenceCinq\Plugins\ACF\IncludeFields\AcfFieldHelpers;

/**
 * Example block layout.
 */
class Example {

	/**
	 * Returns the layout array for the Example block.
	 *
	 * @param string $key The field key prefix (e.g. 'blocks' or 'archive_posts').
	 * @return array<string, mixed>
	 */
	public static function get_layout( string $key ): array {
		return array(
			'key'        => 'layout_' . $key . '_example',
			'name'       => 'example',
			'label'      => __( 'Example', 'agencecinq' ),
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $key . '_example_content_tab',
					'label'      => __( 'Content', 'agencecinq' ),
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'tab',
				),
				array(
					'key'        => 'field_' . $key . '_example_content',
					'label'      => __( 'Content', 'agencecinq' ),
					'name'       => 'content',
					'aria-label' => __( 'Content', 'agencecinq' ),
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'         => 'field_' . $key . '_example_content_title',
							'label'       => __( 'Title', 'agencecinq' ),
							'name'        => 'title',
							'aria-label'  => __( 'Title', 'agencecinq' ),
							'type'        => 'text',
							'placeholder' => __( 'Enter the title of the block', 'agencecinq' ),
						),
						array(
							'key'        => 'field_' . $key . '_example_content_heading',
							'label'      => __( 'Heading', 'agencecinq' ),
							'name'       => 'heading',
							'aria-label' => __( 'Heading', 'agencecinq' ),
							'type'       => 'clone',
							'clone'      => array( 'field_clones_heading' ),
							'display'    => 'seamless',
							'layout'     => 'block',
						),
					),
				),
				...AcfFieldHelpers::settings( $key . '_example' ),
			),
		);
	}
}
```

- `name` : snake_case ; Twig = kebab (`latest_posts` → `latest-posts.html.twig`).
- Onglets ACF : Content en premier, puis les autres onglets de contenu, puis `media()` s'il y a un média de section, puis `…AcfFieldHelpers::settings( $key . '_{name}' )` en dernier.
- Cloner `field_clones_heading` / `field_clones_media` / `field_clones_layout` plutôt que les redéfinir (`ClonesFields.php`).
- Dans `BlocksFields.php` : `use` + entrée dans `$layouts` (ordre alpha, = ordre admin).

Références plus riches : `Layouts/Services.php`, `Layouts/PageHero.php`.

**Champs de CPT** (meta hors flexible) — `IncludeFields/{Name}Fields.php` + `Init.php`. Référence : `CaseStudyFields.php`.

## 5. Composant TypeScript (si besoin)

Uniquement si le design a une interaction (slider, accordion, marquee, reveal).

- `src/scripts/components/{Name}.ts` — classe `piecesjs` (`Piece`), `customElements.define( 'cinq-{kebab}', … )`.
- Lazy-load dans `src/scripts/app.js` : `load('cinq-{kebab}', () => import('./components/{Name}.ts'));`
- Markup Twig : balise `<cinq-{kebab}>` + `data-dom` comme les composants existants.
- Libs déjà là : GSAP, Splide, `@agencecinq/drawer`, `@agencecinq/modal`, `@agencecinq/accordion`.

Références : `Marquee.ts`, `Slideshow.ts`, `@agencecinq/accordion`.

## Contrôles finaux

- [ ] Aucun `get_field()`, aucun `template-parts/`, aucune feuille CSS de composant.
- [ ] Tokens dans `@theme`, utilitaires Tailwind v4 dans le Twig (syntaxe native, pas de `-[…]` quand un utilitaire existe), pas de px / hex arbitraires.
- [ ] PHP : WPCS, phpcs propre, i18n, docblock CINQ.
- [ ] Bloc branché dans `BlocksFields::$layouts` ; CPT / Fields / Taxonomy branchés dans `Init.php`.
- [ ] Composants Twig existants réutilisés ; gardes dans les includes.
- [ ] Text domain et namespace lus dans le dépôt, pas inventés.
