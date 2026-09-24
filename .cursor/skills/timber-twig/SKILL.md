---
name: timber-twig
description: Timber 2 Twig conventions for CINQ WordPress themes (excerpts, PostExcerpt API). Use when writing or editing Twig that shows post excerpts, teasers, or chapôs, or when fixing Timber deprecation notices about post.preview.
---

# Timber 2 Twig (CINQ)

Always follow the official [Timber v2 documentation](https://timber.github.io/docs/v2/) and the project rule `timber-twig`.

## Excerpts

`{{ post.preview }}` is **removed in practice** (deprecated since Timber 2.0). Use `{{ post.excerpt }}`.

```twig
{# Preferred: hash options — https://timber.github.io/docs/v2/reference/timber-postexcerpt/ #}
{{ post.excerpt({ words: 40, read_more: false }) }}

{# Chainable #}
{{ post.excerpt.length(40).read_more(false) }}

{# Manual WP excerpt with generated fallback #}
{{ post.post_excerpt | default(post.excerpt({ words: 40, read_more: false }) | striptags) | trim }}
```

- `read_more: false` disables the link (do not use `''`).
- If a deprecation for `post.preview` appears after a Twig change with `WP_DEBUG` false, clear `vendor/timber/timber/cache/*`.
