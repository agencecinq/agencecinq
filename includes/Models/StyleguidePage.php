<?php
/**
 * Styleguide page model
 *
 * @package AgenceCinq
 * @subpackage AgenceCinq/Models
 * @author CINQ <contact@agencecinq.com> (https://agencecinq.com)
 */

namespace AgenceCinq\Models;

use Timber\Post;

/**
 * StyleguidePage
 *
 * Page model for the Styleguide page template (timber/post/classmap).
 */
class StyleguidePage extends Post {

	/**
	 * In-page anchors for the catalog nav.
	 *
	 * @return array<int, array<string, mixed>>
	 */
	public function toc(): array {
		return array(
			array(
				'title' => 'Foundations',
				'items' => array(
					array(
						'title' => 'Colour',
						'href'  => '#styleguide-colors',
					),
					array(
						'title' => 'Type',
						'href'  => '#styleguide-type',
					),
					array(
						'title' => 'Space',
						'href'  => '#styleguide-space',
					),
					array(
						'title' => 'Grid',
						'href'  => '#styleguide-grid',
					),
				),
			),
			array(
				'title' => 'Components',
				'items' => array(
					array(
						'title' => 'Fundamentals',
						'href'  => '#styleguide-fundamentals',
					),
					array(
						'title' => 'Actions & navigation',
						'href'  => '#styleguide-actions',
					),
					array(
						'title' => 'Forms',
						'href'  => '#styleguide-forms',
					),
					array(
						'title' => 'Content',
						'href'  => '#styleguide-content',
					),
					array(
						'title' => 'Cards',
						'href'  => '#styleguide-cards',
					),
				),
			),
		);
	}

	/**
	 * Icons of the Figma Components page, by sprite id (src/icons/).
	 *
	 * @return array<string, string>
	 */
	public function icons(): array {
		return array(
			'Icon/Asterisk'      => 'asterisk',
			'Icon/Arrow'         => 'arrow',
			'Icon/Close'         => 'close',
			'Icon/Menu'          => 'menu',
			'Icon/Chevron down'  => 'chevron-down',
			'Icon/Chevron up'    => 'chevron-up',
			'Icon/Chevron left'  => 'chevron-left',
			'Icon/Chevron right' => 'chevron-right',
			'Icon/Check'         => 'check',
			'Icon/Plus'          => 'plus',
			'Icon/Minus'         => 'minus',
			'Icon/External'      => 'external',
			'Icon/Check box'     => 'check-box',
			'Icon/Box'           => 'box',
		);
	}

	/**
	 * Color roles, grouped as in the Figma Colors collection, with their class, their use and their value
	 * in each scheme. Names, primitives and values come from includes/schemes.php.
	 *
	 * @return array<int, array<string, mixed>>
	 */
	public function colors(): array {
		$groups = array(
			'Background' => array(
				'background-color-default'       => array( 'bg-default', 'Base of the page and of each section.' ),
				'background-color-elevated'      => array( 'bg-elevated', 'Band raised from the base: footer, banner, modal.' ),
				'background-color-surface'       => array( 'bg-surface', 'Object on the background: card, field, button, code block.' ),
				'background-color-surface-hover' => array( 'bg-surface-hover', 'Surface under the pointer.' ),
				'background-color-media'         => array( 'bg-media', 'Slot behind an image or a video.' ),
			),
			'Text'       => array(
				'text-color-primary'   => array( 'text-primary', 'Titles and default text.' ),
				'text-color-body'      => array( 'text-body', 'Running text.' ),
				'text-color-muted'     => array( 'text-muted', 'Secondary text, eyebrows, captions.' ),
				'text-color-subtle'    => array( 'text-subtle', 'Mentions on bg/default only: below 4.5:1 on bg/media.' ),
				'text-color-on-accent' => array( 'text-on-accent', 'Text on accent/default.' ),
			),
			'Border'     => array(
				'border-color-default' => array( 'border-default', 'Decorative separators (1.3:1), never a control outline.' ),
				'border-color-subtle'  => array( 'border-subtle', 'Separators inside a surface.' ),
				'border-color-accent'  => array( 'border-accent', 'Highlighted or hovered outline.' ),
				'border-color-control' => array( 'border-control', 'Outline of a control (field, checkbox, switch, filter), 3:1.' ),
			),
			'Accent'     => array(
				'color-accent-default' => array( 'bg-accent-default', 'Primary action. As text, large text only.' ),
				'color-accent-hover'   => array( 'bg-accent-hover', 'Primary action under the pointer.' ),
				'color-accent-soft'    => array( 'bg-accent-soft', 'Tinted background behind an accent.' ),
			),
			'State'      => array(
				'color-focus-ring'    => array( 'outline-focus-ring', 'Keyboard focus outline, 3:1 on every background.' ),
				'color-status-error'  => array( 'text-status-error', 'Error message and outline of an invalid field.' ),
				'color-overlay-scrim' => array( 'bg-overlay-scrim', 'Backdrop of a modal or a drawer.' ),
			),
			'Diff'       => array(
				'color-diff-minus'      => array( 'text-diff-minus', 'Sign and text of a removed line.' ),
				'color-diff-minus-soft' => array( 'bg-diff-minus-soft', 'Background of a removed line.' ),
				'color-diff-plus'       => array( 'text-diff-plus', 'Sign of an added line.' ),
				'color-diff-plus-soft'  => array( 'bg-diff-plus-soft', 'Background of an added line.' ),
			),
		);

		$names   = cinq_scheme_roles();
		$schemes = cinq_schemes();
		$colors  = array();

		foreach ( $groups as $title => $roles ) {
			$items = array();

			foreach ( $roles as $role => list( $class, $usage ) ) {
				$values = array();

				foreach ( $schemes as $slug => $scheme ) {
					$values[] = array(
						'scheme'    => $slug,
						'label'     => $scheme['label'],
						'primitive' => $scheme['colors'][ $role ] ?? '',
						'value'     => cinq_scheme_color( $slug, $role ),
					);
				}

				$items[] = array(
					'name'     => $names[ $role ],
					'class'    => $class,
					'variable' => '--' . $role,
					'usage'    => $usage,
					'values'   => $values,
				);
			}

			$colors[] = array(
				'title' => $title,
				'roles' => $items,
			);
		}

		return $colors;
	}

	/**
	 * Text styles of the Figma Typography board, by public utility.
	 *
	 * Each variant maps a Figma style to the class that renders it at a fixed size. No measures here: the
	 * styleguide reads them from the rendered samples, so theme.css stays their only source.
	 *
	 * @return array<int, array<string, mixed>>
	 */
	public function type_scale(): array {
		$title = 'Votre site devrait être un actif.';

		return array(
			array(
				'title'  => 'Titles',
				'sample' => $title,
				'styles' => array(
					array(
						'class'    => 'text-title-3xl',
						'variants' => array(
							'Desktop/title-3xl' => 'text-title-3xl-desktop',
							'Mobile/title-3xl'  => 'text-title-3xl-mobile',
						),
					),
					array(
						'class'    => 'text-title-xxl',
						'variants' => array(
							'Desktop/title-xxl' => 'text-title-xxl-desktop',
							'Mobile/title-xxl'  => 'text-title-xxl-mobile',
						),
					),
					array(
						'class'    => 'text-title-xl',
						'variants' => array(
							'Desktop/title-xl' => 'text-title-xl-desktop',
							'Mobile/title-xl'  => 'text-title-xl-mobile',
						),
					),
					array(
						'class'    => 'text-title-lg',
						'variants' => array(
							'Desktop/title-lg' => 'text-title-lg-desktop',
							'Mobile/title-lg'  => 'text-title-lg-mobile',
						),
					),
					array(
						'class'    => 'text-title-md',
						'variants' => array(
							'Desktop/title-md · Mobile/title-md' => 'text-title-md',
						),
					),
				),
			),
			array(
				'title'  => 'Quote',
				'sample' => $title,
				'styles' => array(
					array(
						'class'    => 'text-quote',
						'variants' => array(
							'Desktop/quote' => 'text-quote-desktop',
							'Mobile/quote'  => 'text-quote-mobile',
						),
					),
				),
			),
			array(
				'title'  => 'Text',
				'sample' => $title,
				'styles' => array(
					array(
						'class'    => 'text-xl',
						'variants' => array(
							'Desktop/text-xl' => 'text-xl-desktop',
							'Mobile/text-xl'  => 'text-xl-mobile',
						),
					),
					array(
						'class'    => 'text-lg',
						'variants' => array(
							'Desktop/text-lg' => 'text-lg-desktop',
							'Mobile/text-lg'  => 'text-lg-mobile',
						),
					),
					array(
						'class'    => 'text-base',
						'variants' => array(
							'Desktop/text-base' => 'text-base-desktop',
							'Mobile/text-base'  => 'text-base-mobile',
						),
					),
					array(
						'class'    => 'text-sm',
						'variants' => array(
							'Desktop/text-sm' => 'text-sm-desktop',
							'Mobile/text-sm'  => 'text-sm-mobile',
						),
					),
					array(
						'class'    => 'text-base line-through',
						'variants' => array(
							'Desktop/text-base-strikethrough' => 'text-base-desktop line-through',
						),
					),
				),
			),
			array(
				'title'  => 'Labels',
				'sample' => 'Réserver 30 minutes',
				'styles' => array(
					array(
						'class'    => 'text-eyebrow',
						'variants' => array(
							'Label/eyebrow' => 'text-eyebrow',
						),
					),
					array(
						'class'    => 'text-nav',
						'variants' => array(
							'Label/nav' => 'text-nav',
						),
					),
					array(
						'class'    => 'text-button',
						'variants' => array(
							'Label/button' => 'text-button',
						),
					),
					array(
						'class'    => 'text-button underline',
						'variants' => array(
							'Label/link' => 'text-button underline',
						),
					),
				),
			),
			array(
				'title'  => 'Data',
				'sample' => '750 €',
				'styles' => array(
					array(
						'class'    => 'text-mono',
						'sample'   => '- WordPress 3 versions en retard',
						'variants' => array(
							'Data/mono' => 'text-mono',
						),
					),
					array(
						'class'    => 'text-number-xl',
						'variants' => array(
							'Data/number-xl' => 'text-number-xl',
						),
					),
					array(
						'class'    => 'text-number-lg',
						'variants' => array(
							'Data/number-lg' => 'text-number-lg',
						),
					),
				),
			),
		);
	}

	/**
	 * Spacing, radius and dimensions of the Figma Spacing board.
	 *
	 * Each item renders a sample whose CSS property the styleguide reads, so theme.css and the Tailwind
	 * multiplier stay the only source of the values.
	 *
	 * @return array<int, array<string, mixed>>
	 */
	public function spacing(): array {
		return array(
			array(
				'title'    => 'Spacing',
				'property' => 'width',
				'sample'   => 'h-4',
				'items'    => array(
					array(
						'name'   => 'spacing/1',
						'sample' => 'w-1',
						'code'   => 'gap-1 · p-1',
					),
					array(
						'name'   => 'spacing/2',
						'sample' => 'w-2',
						'code'   => 'gap-2 · p-2',
					),
					array(
						'name'   => 'spacing/3',
						'sample' => 'w-3',
						'code'   => 'gap-3 · p-3',
					),
					array(
						'name'   => 'spacing/4',
						'sample' => 'w-4',
						'code'   => 'gap-4 · p-4',
					),
					array(
						'name'   => 'spacing/6',
						'sample' => 'w-6',
						'code'   => 'gap-6 · p-6',
					),
					array(
						'name'   => 'spacing/8',
						'sample' => 'w-8',
						'code'   => 'gap-8 · p-8',
					),
					array(
						'name'   => 'spacing/14',
						'sample' => 'w-14',
						'code'   => 'gap-14 · p-14',
					),
					array(
						'name'   => 'spacing/20',
						'sample' => 'w-20',
						'code'   => 'gap-20 · p-20',
					),
					array(
						'name'   => 'spacing/26',
						'sample' => 'w-26',
						'code'   => 'gap-26 · p-26',
					),
					array(
						'name'   => 'spacing/34',
						'sample' => 'w-34',
						'code'   => 'gap-34 · p-34',
					),
					array(
						'name'   => 'rhythm/gutter-mobile',
						'sample' => 'w-5',
						'code'   => 'px-5 · container',
					),
					array(
						'name'   => 'rhythm/gutter-desktop',
						'sample' => 'w-25',
						'code'   => 'lg:px-25 · container',
					),
				),
			),
			array(
				'title'    => 'Radius',
				'property' => 'border-top-left-radius',
				'sample'   => 'size-16',
				'items'    => array(
					array(
						'name'   => 'radius/xs',
						'sample' => 'rounded-xs',
						'code'   => 'rounded-xs',
					),
					array(
						'name'   => 'radius/sm',
						'sample' => 'rounded-sm',
						'code'   => 'rounded-sm',
					),
					array(
						'name'   => 'radius/md',
						'sample' => 'rounded-md',
						'code'   => 'rounded-md',
					),
					array(
						'name'   => 'radius/lg',
						'sample' => 'rounded-lg',
						'code'   => 'rounded-lg',
					),
					array(
						'name'   => 'radius/full',
						'sample' => 'rounded-full',
						'code'   => 'rounded-full',
					),
				),
			),
			array(
				'title' => 'Dimensions',
				'items' => array(
					array(
						'name'     => 'dimension/container',
						'property' => 'max-width',
						'sample'   => 'h-4 w-full max-w-310',
						'code'     => 'container (max-w-360 · lg:px-25)',
					),
					array(
						'name'     => 'dimension/nav-height',
						'property' => 'height',
						'sample'   => 'h-18 w-4',
						'code'     => 'h-18',
					),
					array(
						'name'     => 'dimension/text-measure',
						'property' => 'max-width',
						'sample'   => 'h-4 w-full max-w-180',
						'code'     => 'max-w-180',
					),
				),
			),
		);
	}
}
