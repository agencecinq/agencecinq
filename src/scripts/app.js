import { load } from 'piecesjs';

import '@agencecinq/drawer';
import '@agencecinq/modal';

load('cinq-accordion-group', () => import('./components/AccordionGroup.ts'));
load('cinq-marquee', () => import('./components/Marquee.ts'));
load('cinq-media-text-reveal', () => import('./components/MediaTextReveal.ts'));
load('cinq-child-pages-by-parent', () => import('./components/ChildPagesByParent.ts'));
load('cinq-slideshow', () => import('./components/Slideshow.ts'));
load('cinq-mobile-menu', () => import('./components/MobileMenu.ts'));

// The object cinq is defined in includes/Setup/Enqueue.php and localized to app.js
// It provideds useful information such as the text domain, template_directory_uri, base_url, etc.
// It's usefull when you have to pass PHP variables to JavaScript.
console.log(`Hello ${cinq.text_domain}!`);
