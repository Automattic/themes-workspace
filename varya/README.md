# Varya

Varya is a styling system for quickly creating Gutenberg-ready themes for WordPress.

## What does it do?

When you reduce a theme design down to a set of systematic design decisions, you end up with something called a _Style Guide_. The Varya system works by taking the rules of a Style Guide and expressing them through carefully placed variables or _design tokens_ that influence the appearance of a WordPress site. It currently unifyies the overall of Gutenberg Blocks, the theme Header + Footer areas, WooCommerce, Jetpack and more. It also syncs styles between the editor and the frontend so that you don’t need to hand-write styles for both. This greatly speeds up the Gutenberg theme development process and reduces the amount of manual styling that typically goes into developing a theme. 

### What controls does the system come with?

  - **Fonts** - Font-family, size, weight, and line-height rules. 
  - **Colors** - Primary, secondary, background, foreground and border colors. 
  - **Spacing** - Sets an 8px vertical rhythm between all blocks and major components. Adds general spacing rules for blocks and components. Adds utility spacing classes for negative margins.
  - **Responsive Logic** - Unifies the responsive behavior across various Blocks and Components to simplify behaviors.

## How does it work?

The system itself lives in the `/varya/sass` directory as a collection of Sass partials broken up by scope and hierarchy. The partials get compiled down to singular CSS files that live in the main Varya directory and cascade downward like so:

**Frontend** 
- `/varya/variables.css`
- `/varya/style.css`

**Editor** 
- `/varya/variables-editor.css`
- `/varya/style-editor.css`

**Customizer**
- `/varya/variables.css`
- `/varya/style.css`

In each view, the variables are loaded first and then the stylesheet is loaded which applies the variables.

## How to use it

To use the system, simply duplicate the `vayra-child` theme directory and rename it `my-theme-name`. You’ll also want to do a search for `varia-child` strings and replace them with `my-theme-name` as follows:

  - Search for: `'varya-child'` and replace with: `'my-theme-name'` (with quotes).
  - Search for: `varya_child_` and replace with: `my_theme_name_`.
  - Search for: `Text Domain: varia-child` and replace with: `Text Domain: my-theme-name` in _style.css_.
  - Search for:  `varia-child` and replace with: `my_theme_name`.
  - Search for: `varia-child-` and replace with: `my-theme-name-`.

Soon this process will be replaced by a `theme-dev-util` (similar to [this](https://github.com/Automattic/theme-dev-utils)) that allows you to run a command and automatically produce a child theme with all the strings already replaced.

### Simple Child Theme Structure (See: `/varya-child`)

When working with a Varya child theme, only the variables need to be overwritten so the stylesheet structure for a child-theme cascades downward like this:

**Frontend**
- `/varya/variables.css`
  - `../varya-child-theme/variables.css` (system overrides)
- `/varya/style.css`
  - `../varya-child-theme/style.css` (extra CSS)

 **Editor**
- `/varya/variables-editor.css`
  - `../varya-child-theme/variables-editor.css` (system overrides)
- `/varya/style-editor.css`
  - `../varya-child-theme/style-editor.css` (extra CSS)

**System Overrides**: A list of CSS-variables that override the variables in the child theme. This is where you tell the system to use the _Futura_ font-family instead of the _sans-serif_ default, for example. There’s no need to replace all of the variables here, only the ones you wish to actually change.

**Extra CSS**: These should be supplemental styles that give the theme a unique appearance beyond what’s possible with the Varya system. Need to add a fixed header or add a box-shadow to your theme’s buttons? This is where those styles would go. When possible and appropriate, try to use Varya variables here so that the system retains its usefulness across the theme. 

### Advanced Child Theme Structure (See: `/varya-child-adnvanced`)

- TBD

### Todos

 - Explore responsive-logic overrides in the child theme.
 - Integrate with build tool
 - Introduce an advanced child theme example that uses block styles
 - Audit Varya system for excessive overridden rules
 - Integrate with the child-theme build tool.
 - Add Jetpack support?
 - Optimize responsive font-size styles.
 - Audit how variables appear in the editor, the customizer, and the frontend.
 - Consider adding defaults fallbacks to top-level css-variables.
 - Create a demo.
 - Add a CSS-Variables polyfill or other fallback solution for older browsers.
 - Create a ReadMe that describes how to use it.

### License

- GPL
