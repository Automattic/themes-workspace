<?php
/**
 * Child Theme Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Dalston
 * @since 1.0.0
 */

if ( ! function_exists( 'nwaneri_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function nwaneri_setup() {

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Add child theme editor font sizes to match Sass-map variables in `_config-child-theme-deep.scss`.
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => __( 'Small', 'nwaneri' ),
					'shortName' => __( 'S', 'nwaneri' ),
					'size'      => 15,
					'slug'      => 'small',
				),
				array(
					'name'      => __( 'Normal', 'nwaneri' ),
					'shortName' => __( 'M', 'nwaneri' ),
					'size'      => 18,
					'slug'      => 'normal',
				),
				array(
					'name'      => __( 'Large', 'nwaneri' ),
					'shortName' => __( 'L', 'nwaneri' ),
					'size'      => 25,
					'slug'      => 'large',
				),
				array(
					'name'      => __( 'Huge', 'nwaneri' ),
					'shortName' => __( 'XL', 'nwaneri' ),
					'size'      => 37,
					'slug'      => 'huge',
				),
			)
		);

		// Add child theme editor color pallete to match Sass-map variables in `_config-child-theme-deep.scss`.
		add_theme_support( 'editor-color-palette', array(
			array(
				'name'  => __( 'White', 'nwaneri' ),
				'slug'  => 'white',
				'color' => '#fff',
			),
			array(
				'name'  => __( 'Nwaneri Blue', 'nwaneri' ),
				'slug'  => 'nwaneri-blue',
				'color' => '#333366',
			),
			array(
				'name'  => __( 'Burning Red', 'nwaneri' ),
				'slug'  => 'burning-red',
				'color' => '#EB4D55',
			),
			array(
				'name'  => __( 'Cream Orange', 'nwaneri' ),
				'slug'  => 'cream-orange',
				'color' => '#FF9D76',
			)
		 ) );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 96,
				'width'       => 100,
				'flex-width'  => true,
				'flex-height' => true,
				'header-text' => array( 'site-title' ),
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'nwaneri_setup', 12 );

/**
 * Filter the content_width in pixels, based on the child-theme's design and stylesheet.
 */
function nwaneri_content_width() {
	return 750;
}
add_filter( 'nwaneri_content_width', 'nwaneri_content_width' );

/**
 * Add Google webfonts, if necessary
 *
 * - See: http://themeshaper.com/2014/08/13/how-to-add-google-fonts-to-wordpress-themes/
 */
function nwaneri_fonts_url() {

	$fonts_url = '';

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Open Sans, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$crimson_text = esc_html_x( 'on', 'Crimson Text font: on or off', 'nwaneri' );

	if ( 'off' !== $crimson_text ) {
		$font_families = array();

		if ( 'off' !== $crimson_text ) {
			$font_families[] = 'Crimson Text:400,600,700,400italic,600italic';
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
 * Enqueue scripts and styles.
 */
function nwaneri_scripts() {

	// enqueue Google fonts, if necessary
	wp_enqueue_style( 'nwaneri-fonts', nwaneri_fonts_url(), array(), null );

	// Child theme variables
	wp_enqueue_style( 'nwaneri-variables-style', get_stylesheet_directory_uri() . '/variables.css', array(), wp_get_theme()->get( 'Version' ) );

	// dequeue parent styles
	// wp_dequeue_style( 'varya-variables-style' );

	// enqueue child styles
	wp_enqueue_style('nwaneri-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ));

	// enqueue child RTL styles
	wp_style_add_data( 'nwaneri-style', 'rtl', 'replace' );

	wp_enqueue_style( 'nwaneri-styles', get_stylesheet_directory_uri() . '/css/style.css' );
	wp_enqueue_script( 'nwaneri-nav-script', get_stylesheet_directory_uri() . '/assets/scripts/navigation.js', [], false, true);

}
add_action( 'wp_enqueue_scripts', 'nwaneri_scripts', 99 );

/**
 * Enqueue theme styles for the block editor.
 */
function nwaneri_editor_styles() {

	// Enqueue Google fonts in the editor, if necessary
	wp_enqueue_style( 'nwaneri-editor-fonts', nwaneri_fonts_url(), array(), null );

	// Load the child theme styles within Gutenberg.
	wp_enqueue_style( 'nwaneri-editor-variables', get_theme_file_uri( 'variables-editor.css' ), false, wp_get_theme()->get( 'Version' ), 'all' );

	// Load the parent theme styles within Gutenberg.
	wp_enqueue_style( 'nwaneri-editor-styles', get_template_directory_uri() . '/style-editor.css', false, wp_get_theme()->get( 'Version' ), 'all' );

	// Load the child theme editor styles within Gutenberg.
	wp_enqueue_style( 'nwaneri-editor-styles', get_stylesheet_directory_uri() . '/style-editor.css', false, wp_get_theme()->get( 'Version' ), 'all' );
}
add_action( 'enqueue_block_editor_assets', 'nwaneri_editor_styles', 99 );

/**
 * Register and Enqueue Styles.
 */
if ( function_exists( 'register_block_style' ) ) {
	function nwaneri_register_block_styles() {
		
		/**
		** Register stylesheet
		**/
		wp_register_style(
			'block-styles-stylesheet',
			get_stylesheet_directory_uri() . '/css/block-styles.css',
			array(),
			'1.1'
		);

		register_block_style(
			'core/separator',
				array(
					'name'					=> 'separator-blobs',
					'label'					=> 'Blobs',
					'style_handle'	=> 'block-styles-stylesheet',
			)
		);

		register_block_style(
			'core/media-text',
				array(
					'name'					=> 'media-text-hero',
					'label'					=> 'Hero',
					'style_handle'	=> 'block-styles-stylesheet',
				)
		);

		register_block_style(
			'core/cover',
				array(
					'name'					=> 'cover-hero',
					'label'					=> 'Hero',
					'style_handle'	=> 'block-styles-stylesheet',
				)
		);

		register_block_style(
			'core/quote',
				array(
					'name'					=> 'quote-blobs',
					'label'					=> 'Blobs',
					'style_handle'	=> 'block-styles-stylesheet',
				)
		);

		register_block_style(
			'core/latest-posts',
				array(
					'name'					=> 'latest-posts-stacked',
					'label'					=> 'Stacked',
					'style_handle'	=> 'block-styles-stylesheet',
				)
		);
	}

	add_action( 'init', 'nwaneri_register_block_styles' );
}
