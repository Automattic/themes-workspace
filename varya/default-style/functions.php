<?php
/**
 * Varya Default functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Varya_Default
 * @since 1.0.0
 */

if ( ! function_exists( 'varya_default_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function varya_default_setup() {

		// Enqueue editor styles.
		add_editor_style( array(
			varya_default_fonts_url(),
			'./default-style/variables.css',
			'./default-style/variables-editor.css'
		) );

		add_theme_support(
			'editor-font-sizes',
			array(
				array(
				'name'      => __( 'Tiny', 'varya-default' ),
					'shortName' => __( 'XS', 'varya-default' ),
					'size'      => 14,
					'slug'      => 'tiny',
				),
				array(
					'name'      => __( 'Small', 'varya-default' ),
					'shortName' => __( 'S', 'varya-default' ),
					'size'      => 16,
					'slug'      => 'small',
				),
				array(
					'name'      => __( 'Normal', 'varya-default' ),
					'shortName' => __( 'M', 'varya-default' ),
					'size'      => 18,
					'slug'      => 'normal',
				),
				array(
					'name'      => __( 'Large', 'varya-default' ),
					'shortName' => __( 'L', 'varya-default' ),
					'size'      => 20,
					'slug'      => 'large',
				),
				array(
					'name'      => __( 'Huge', 'varya-default' ),
					'shortName' => __( 'XL', 'varya-default' ),
					'size'      => 24,
					'slug'      => 'huge',
				),
			)
		);

		// Add child theme editor color pallete to match Sass-map variables in `_config-child-theme-deep.scss`.
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'Primary', 'varya-default' ),
					'slug'  => 'primary',
					'color' => '#000000',
				),
				array(
					'name'  => __( 'Secondary', 'varya-default' ),
					'slug'  => 'secondary',
					'color' => '#A36265',
				),
				array(
					'name'  => __( 'Foreground', 'varya-default' ),
					'slug'  => 'foreground',
					'color' => '#333333',
				),
				array(
					'name'  => __( 'Background Light', 'varya-default' ),
					'slug'  => 'background-light',
					'color' => '#FAFBF6',
				),
				array(
					'name'  => __( 'Background', 'varya-default' ),
					'slug'  => 'background',
					'color' => '#FFFFFF',
				),
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'varya_default_setup', 12 );

/**
 * Filter the content_width in pixels, based on the child-theme's design and stylesheet.
 */
function varya_default_content_width() {
	return 750;
}
add_filter( 'varya_content_width', 'varya_default_content_width' );

/**
 * Add Google webfonts, if necessary
 *
 * - See: http://themeshaper.com/2014/08/13/how-to-add-google-fonts-to-wordpress-themes/
 */
function varya_default_fonts_url() {

	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	* supported by Playfair Display, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$fira_sans = esc_html_x( 'on', 'Fira Sans: on or off', 'varya-default' );

	/* Translators: If there are characters in your language that are not
	* supported by Roboto Sans, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$playfair_display = esc_html_x( 'on', 'Playfair Display: on or off', 'varya-default' );

	if ( 'off' !== $fira_sans || 'off' !== $playfair_display ) {
		$font_families = array();

		if ( 'off' !== $fira_sans ) {
			$font_families[] = 'Fira Sans:ital,wght@0,400;0,500;1,400';
		}

		if ( 'off' !== $playfair_display ) {
			$font_families[] = 'Playfair Display:ital,wght@0,400;0,700;1,400';
		}

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Enqueue scripts and styles for the frontend.
 */
function varya_default_variables() {

	// Enqueue Google fonts
	wp_enqueue_style( 'varya-default-fonts', varya_default_fonts_url(), array(), null );

	// Default variables
	wp_enqueue_style( 'varya-default-variables-style', get_template_directory_uri() . '/default-style/variables.css', array(), wp_get_theme()->get( 'Version' ) );

	// Default extra styles
	wp_enqueue_style( 'varya-default-extra-style', get_template_directory_uri() . '/default-style/style.css', array(), wp_get_theme()->get( 'Version' ) );

}
add_action( 'wp_enqueue_scripts', 'varya_default_variables' );