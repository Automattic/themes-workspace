# Varya

Varya is a parent-theme with a built-in styling system for quickly creating Gutenberg-ready child-themes for WordPress. 

## What does it do?

When you reduce a theme design down to a set of systematic design decisions, you end up with something called a _Style Guide_. The Varya system works by taking the rules of a Style Guide and expressing them through carefully placed variables or _design tokens_ that influence the appearance of a WordPress site. This unifies the design decisions needed to style the aesthetic appearance of Gutenberg Blocks, the theme Header + Footer areas, WooCommerce, Jetpack and more. It also syncs styles between the editor and the frontend so that you don’t need to hand-write CSS for both. This greatly speeds up the Gutenberg theme development process and reduces the amount of manual styling that typically goes into developing a theme. 

### What controls does the system come with?

- **Fonts** - Font-family, size, weight, and line-height rules. 
- **Colors** - Primary, secondary, background, foreground and border colors. 
- **Spacing** - A default 8px vertical rhythm between all blocks and major components. It also includes utility spacing classes for negative margins.
- **Responsive Logic** - Built-in responsive behavior across Blocks and Components.

## How does it work?

The system itself lives in the `/varya/sass` directory as a collection of Sass partials broken up by scope and hierarchy. The partials get compiled down to singular CSS files that live in the main Varya directory and cascade downward like so:

**Frontend** 
- `/varya/variables.css`
- `/varya/style.css`

**Editor** 
- `/varya/variables-editor.css`
- `/varya/style-editor.css`

In each view, the variables are loaded first and then the stylesheet is loaded which applies the variables.

## Quick start guide

1. Clone / download this repository into the `wp-content/themes` directory of your WordPress site.
2. `cd` into the `wp-content/themes/varya` directory and run `npm install`.
3. Next, run `npm build child-theme` and go through the prompts. This will create a fresh Varya-based child-theme using the name you chose in the prompts (* the build tool is still in the works. Do this step manually using the steps below).
4. Visit the WordPress admin, access the Themes page and activate the new child-theme. 
5. Then, visit the frontend of your site and to see how it looks by default.
6. Next, open `child-theme/variables.css` in a text editor, change one or more of the variables, save the file and then refresh the front end of your site to see how it affects the design. 
7. Continue to add and/or remove variables based on the [full list of available variables in Varya](https://github.com/Automattic/themes-workspace/blob/add/variatheme/varya/variables.css).
8. Once you’re variables are all set you can continue development like you would with any child-theme using `child-theme/style.css` to add any extra CSS you might need to accomplish a design. 

#### Create a child-theme manually (*optional)

To use the system, simply duplicate the `varya-child` theme directory and rename it `my-theme-name`. You’ll also want to do a search for `varia-child` strings and replace them with `my-theme-name` as follows:

- Search for: `'varya-child'` and replace with: `'my-theme-name'` (with quotes).
- Search for: `varya_child_` and replace with: `my_theme_name_`.
- Search for: `Text Domain: varia-child` and replace with: `Text Domain: my-theme-name` in _style.css_.
- Search for:  `varia-child` and replace with: `my_theme_name`.
- Search for: `varia-child-` and replace with: `my-theme-name-`.

(Soon this process will be replaced by a `theme-dev-util` (similar to [this](https://github.com/Automattic/theme-dev-utils)) that allows you to run a command and automatically produce a child theme with all the strings already replaced.)

## Simple child-theme structure
(See: `/varya-child`)

Use this simple Varya child-theme example to familiarize yourself with the CSS-variables and to see how they influence the theme design when you change them. To start, open up the `/varya-child-simple/variables.css` file. Change any of the values, save the file, and refresh the frontend of your site to see the changes. To add more variables, view the [full list of available variables](https://github.com/Automattic/themes-workspace/blob/add/variatheme/varya/variables.css) from the Varya parent them and copy any variables you want in to your child theme. 
The stylesheet structure for a child-theme cascades downward like this:

### Frontend
- `/varya/variables.css`
- `/varya-child-simple/variables.css` (System overrides)
- `/varya/style.css`
- `/varya-child-simple/style.css` (Extra CSS)

### Editor
- `/varya/variables-editor.css`
- `/varya-child-simple/variables-editor.css` (System overrides)
- `/varya/style-editor.css`
- `/varya-child-simple/style-editor.css` (Extra CSS)

### System overrides

A list of CSS-variables that override the variables in the child theme. This is where you tell the system to use the _Futura_ font-family instead of the _sans-serif_ default, for example. There’s no need to replace all of the variables here, only the ones you wish to actually change based on your theme design.

**Varya parent theme font style** (`/varya/variables.css`)

`:root { --global--font-family: sans-serif; }`

**Varya child-theme font-style overrides** (`/varya-child/variables.css`)

`:root { --global--font-family: "Futura", "Helvetica", sans-serif; }`

### Extra CSS

These should be supplemental styles that give the theme a unique appearance beyond what’s included with the Varya system defaults. Need to add a fixed header or add a box-shadow to your theme’s buttons? This is where those styles would go. When possible and appropriate, try to use Varya CSS-variables in this stylesheet so that the system retains its usefulness across the theme.

## Advanced child-theme structure 
(See: `/varya-child-advanced`)

The Varya Child Advanced theme is an example of what a theme in production might look like using the Varya system. It primarily relies on CSS-variables like the simple version but it also takes advantage of other child theming techniques. 

- A custom header and footer design by replacing the `header.php` and `footer.php` template parts.
- Some examples of custom block styles which will likely be common in many Varya-based child-themes.
- A customizer option that allows customers to choose a `header-image`.
- Some example _Extra CSS_ in the `style.scss` file.
- Introduces an example for how to change the responsive content widths (more on this in the next section).

## Responsive content widths

Usually, breakpoints are set based on common viewport sizes like mobile (320px), tablet (1024px), etc, but Varya takes a different approach. To understand how this approach effects the structure of the site, it’s best to think of the content-width variables as both breakpoints _and_ content-widths. When you choose a content-width based on your design, the related breakpoint will also change to make that layout possible and responsive. Responsive styles work around the specs of the design which is both less fragile and more flexible. 

Check out this Codepen for a lo-fi example: [https://codepen.io/allancole/pen/zYGNWBJ](https://codepen.io/allancole/pen/zYGNWBJ) (make sure to resize the screen to see the effect in action).

Customizing the responsive content-width of a Varya Child Theme is also just as simple as changing a few variables. However, we can’t use CSS-variables directly in `@media` queries ([see here](https://www.w3.org/TR/css-variables-1/#using-variables)). Instead, Varya child-themes come with a `responsive.scss` file that overwrites _only_ the responsive styles of the Varya parent theme when compiled. 

Here are the available variables for changing content widths in `responsive.scss`. 

| Screensize        | Breakpoint Variable | Default Size | Description                                                                                                       |
|-------------------|---------------------|--------------|-------------------------------------------------------------------------------------------------------------------|
| **Mobile & down** | `$flexwidth`        | 100%         |                                                                                                                   |
| **Mobile & up**   | `$breakpoint_sm`    | 560px        |                                                                                                                   |
| **Tablet & up**   | `$breakpoint_md`    | 640px        | This variables matters the most. It should always match the `$content_width` PHP variable set in `functions.php`. |
| **Laptop & up**   | `$breakpoint_lg`    | 750px        |                                                                                                                   |
| **Desktop & up**  | `$breakpoint_xl`    | 1024px       |                                                                                                                   |
| **Wide & up**     | `$breakpoint_xxl`   | 1280px       |                                                                                                                   |

Once you’ve set these variables to your liking in `/varya-child-advanced/responsive.scss`, run `npm run build` on the child-theme which will recompile `responsive.scss` and reset the content width CSS-variables in `responsive.css`.

## To-Dos
- [DONE] Explore responsive-logic overrides in the child theme.
- [DONE] Introduce an advanced child theme example that uses block styles
- [DONE] Audit how variables appear in the editor, the customizer, and the frontend.
- Audit Varya system for excessive overridden rules
- Integrate with the child-theme build tool.
- Add Jetpack support?
- Optimize responsive font-size styles.
- Consider adding default fallbacks to top-level css-variables.
- Create a demo.
- Add a CSS-Variables polyfill or other fallback solution for older browsers.
- [WIP] Create a ReadMe that describes how to use it.

### License

GNU General Public License v2 or later

URI: LICENSE
