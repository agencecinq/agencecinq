<?php
/**
 * Color configuration
 *
 * Single source of the theme colors, as in Figma: the primitives of the palette, the roles a section
 * paints with, and the color schemes, the Figma modes, mapping roles to primitives. Feeds the front
 * (`cinq_colors_css()`, printed in the head), the ACF scheme swatches and the styleguide. Tailwind only
 * knows the role names (`@theme reference` in theme.css), never their values.
 * Auto-loaded via composer.json "files" directive.
 *
 * @package AgenceCinq
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

/**
 * Palette, the Figma Primitives (slug => label + value). Variables: `--color-{slug}`.
 *
 * @return array<string, array{label: string, value: string}>
 */
function cinq_palette(): array {
	$values = array(
		'black-900'          => '#08090a',
		'black-800'          => '#0d0f0e',
		'black-700'          => '#141614',
		'black-600'          => '#1c201c',
		'black-scrim'        => '#050505b8',
		'cream-100'          => '#f1f0ea',
		'cream-150'          => '#e6e4dc',
		'cream-200'          => '#d3d1c7',
		'cream-300'          => '#9a988d',
		'cream-400'          => '#7e7c71',
		'cream-line'         => '#f1f0ea1c',
		'cream-line-subtle'  => '#f1f0ea0f',
		'ink-700'            => '#2b2a26',
		'ink-600'            => '#55544c',
		'ink-500'            => '#6b6a61',
		'ink-line'           => '#08090a24',
		'ink-line-subtle'    => '#08090a12',
		'grey-600'           => '#74726b',
		'grey-500'           => '#7d7a72',
		'pistachio-300'      => '#c7ffbb',
		'pistachio-400'      => '#b3fca4',
		'pistachio-950'      => '#0a0c0a',
		'pistachio-soft'     => '#b3fca424',
		'pistachio-glow'     => '#b3fca46b',
		'pistachio-400-tint' => '#b3fca417',
		'green-700'          => '#1f6b2a',
		'green-700-tint'     => '#1f6b2a14',
		'coral-400'          => '#ff8f7a',
		'coral-700'          => '#b3381f',
		'red-300'            => '#ff8a7a',
		'red-300-tint'       => '#ff8a7a14',
		'red-700'            => '#b42318',
		'red-700-tint'       => '#b4231812',
	);

	$palette = array();

	foreach ( $values as $slug => $value ) {
		$palette[ $slug ] = array(
			'label' => preg_replace( '/-/', '/', $slug, 1 ),
			'value' => $value,
		);
	}

	return $palette;
}

/**
 * Roles a scheme sets, the Figma Colors (CSS variable => Figma name). Utilities: `bg-default`,
 * `text-primary`, `border-default`, `bg-accent-default`…
 *
 * @return array<string, string>
 */
function cinq_scheme_roles(): array {
	return array(
		'background-color-default'       => 'bg/default',
		'background-color-elevated'      => 'bg/elevated',
		'background-color-surface'       => 'bg/surface',
		'background-color-surface-hover' => 'bg/surface-hover',
		'background-color-media'         => 'bg/media',
		'text-color-primary'             => 'text/primary',
		'text-color-body'                => 'text/body',
		'text-color-muted'               => 'text/muted',
		'text-color-subtle'              => 'text/subtle',
		'text-color-on-accent'           => 'text/on-accent',
		'color-accent-default'           => 'accent/default',
		'color-accent-hover'             => 'accent/hover',
		'color-accent-soft'              => 'accent/soft',
		'border-color-default'           => 'border/default',
		'border-color-subtle'            => 'border/subtle',
		'border-color-accent'            => 'border/accent',
		'border-color-control'           => 'border/control',
		'color-focus-ring'               => 'focus/ring',
		'color-status-error'             => 'status/error',
		'color-overlay-scrim'            => 'overlay/scrim',
		'color-diff-minus'               => 'diff/minus',
		'color-diff-minus-soft'          => 'diff/minus-soft',
		'color-diff-plus'                => 'diff/plus',
		'color-diff-plus-soft'           => 'diff/plus-soft',
	);
}

/**
 * Color schemes, the Figma modes (slug => label + native color scheme + role colors), applied with
 * `data-scheme`.
 *
 * A role color is a palette slug, another role of the same scheme, or `transparent`. The empty slug
 * is the default, set on `:root`.
 *
 * @return array<string, array{label: string, mode: string, colors: array<string, string>}>
 */
function cinq_schemes(): array {
	return array(
		''      => array(
			'label'  => __( 'Dark', 'agencecinq' ),
			'mode'   => 'dark',
			'colors' => array(
				'background-color-default'       => 'black-900',
				'background-color-elevated'      => 'black-800',
				'background-color-surface'       => 'black-700',
				'background-color-surface-hover' => 'black-600',
				'background-color-media'         => 'black-600',
				'text-color-primary'             => 'cream-100',
				'text-color-body'                => 'cream-200',
				'text-color-muted'               => 'cream-300',
				'text-color-subtle'              => 'cream-400',
				'text-color-on-accent'           => 'pistachio-950',
				'color-accent-default'           => 'pistachio-400',
				'color-accent-hover'             => 'pistachio-300',
				'color-accent-soft'              => 'pistachio-soft',
				'border-color-default'           => 'cream-line',
				'border-color-subtle'            => 'cream-line-subtle',
				'border-color-accent'            => 'pistachio-400',
				'border-color-control'           => 'grey-600',
				'color-focus-ring'               => 'pistachio-400',
				'color-status-error'             => 'coral-400',
				'color-overlay-scrim'            => 'black-scrim',
				'color-diff-minus'               => 'red-300',
				'color-diff-minus-soft'          => 'red-300-tint',
				'color-diff-plus'                => 'pistachio-400',
				'color-diff-plus-soft'           => 'pistachio-400-tint',
			),
		),
		'light' => array(
			'label'  => __( 'Light', 'agencecinq' ),
			'mode'   => 'light',
			'colors' => array(
				'background-color-default'       => 'cream-100',
				'background-color-elevated'      => 'cream-150',
				'background-color-surface'       => 'cream-150',
				'background-color-surface-hover' => 'cream-200',
				'background-color-media'         => 'cream-200',
				'text-color-primary'             => 'black-900',
				'text-color-body'                => 'ink-700',
				'text-color-muted'               => 'ink-600',
				'text-color-subtle'              => 'ink-500',
				'text-color-on-accent'           => 'cream-100',
				'color-accent-default'           => 'black-900',
				'color-accent-hover'             => 'black-700',
				'color-accent-soft'              => 'ink-line-subtle',
				'border-color-default'           => 'ink-line',
				'border-color-subtle'            => 'ink-line-subtle',
				'border-color-accent'            => 'black-900',
				'border-color-control'           => 'grey-500',
				'color-focus-ring'               => 'black-900',
				'color-status-error'             => 'coral-700',
				'color-overlay-scrim'            => 'black-scrim',
				'color-diff-minus'               => 'red-700',
				'color-diff-minus-soft'          => 'red-700-tint',
				'color-diff-plus'                => 'green-700',
				'color-diff-plus-soft'           => 'green-700-tint',
			),
		),
	);
}

/**
 * Resolved value of a scheme role (follows role references to the palette).
 *
 * @param string $scheme Scheme slug.
 * @param string $role   Role slug.
 * @return string Hex color or `transparent`.
 */
function cinq_scheme_color( string $scheme, string $role ): string {
	$color = cinq_schemes()[ $scheme ]['colors'][ $role ] ?? 'transparent';

	if ( isset( cinq_scheme_roles()[ $color ] ) ) {
		return cinq_scheme_color( $scheme, $color );
	}

	return cinq_palette()[ $color ]['value'] ?? 'transparent';
}

/**
 * Front color variables: the palette on `:root`, then one rule per scheme with its roles and its native
 * color scheme. The default scheme also answers `[data-scheme=""]`, for a Dark section inside a Light one.
 *
 * @return string CSS.
 */
function cinq_colors_css(): string {
	$declarations = static function ( array $colors ): string {
		$css = '';

		foreach ( $colors as $name => $value ) {
			$css .= '--' . $name . ':' . $value . ';';
		}

		return $css;
	};

	$roles = static function ( array $colors ): array {
		return array_map(
			static fn( string $color ): string => match ( true ) {
				'transparent' === $color => $color,
				isset( cinq_scheme_roles()[ $color ] ) => 'var(--' . $color . ')',
				default => 'var(--color-' . $color . ')',
			},
			$colors
		);
	};

	$palette = array();

	foreach ( cinq_palette() as $slug => $color ) {
		$palette[ 'color-' . $slug ] = $color['value'];
	}

	$css = ':root{' . $declarations( $palette ) . '}';

	foreach ( cinq_schemes() as $slug => $scheme ) {
		$selector = '' === $slug ? ':root,[data-scheme=""]' : '[data-scheme="' . $slug . '"]';
		$css     .= $selector . '{color-scheme:' . $scheme['mode'] . ';' . $declarations( $roles( $scheme['colors'] ) ) . '}';
	}

	return $css;
}
