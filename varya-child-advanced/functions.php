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

if ( ! function_exists( 'varya_nwaneri_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function varya_nwaneri_setup() {

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Add child theme editor font sizes to match Sass-map variables in `_config-child-theme-deep.scss`.
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => __( 'Small', 'varya-nwaneri' ),
					'shortName' => __( 'S', 'varya-nwaneri' ),
					'size'      => 15,
					'slug'      => 'small',
				),
				array(
					'name'      => __( 'Normal', 'varya-nwaneri' ),
					'shortName' => __( 'M', 'varya-nwaneri' ),
					'size'      => 18,
					'slug'      => 'normal',
				),
				array(
					'name'      => __( 'Large', 'varya-nwaneri' ),
					'shortName' => __( 'L', 'varya-nwaneri' ),
					'size'      => 24,
					'slug'      => 'large',
				),
				array(
					'name'      => __( 'Huge', 'varya-nwaneri' ),
					'shortName' => __( 'XL', 'varya-nwaneri' ),
					'size'      => 32,
					'slug'      => 'huge',
				),
			)
		);

		// Add child theme editor color pallete to match Sass-map variables in `_config-child-theme-deep.scss`.
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'Primary', 'varya-nwaneri' ),
					'slug'  => 'primary',
					'color' => '#333366',
				),
				array(
					'name'  => __( 'Secondary', 'varya-nwaneri' ),
					'slug'  => 'secondary',
					'color' => '#EB4D55',
				),
				array(
					'name'  => __( 'Background Dark', 'varya-nwaneri' ),
					'slug'  => 'background-dark',
					'color' => '#CB643A',
				),
				array(
					'name'  => __( 'Background', 'varya-nwaneri' ),
					'slug'  => 'background',
					'color' => '#FF9D76',
				),
				array(
					'name'  => __( 'Foreground Light', 'varya-nwaneri' ),
					'slug'  => 'foreground-light',
					'color' => '#FFCBB7',
				),
				array(
					'name'  => __( 'White', 'varya-nwaneri' ),
					'slug'  => 'white',
					'color' => '#FFFFFF',
				),
			)
		);

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
add_action( 'after_setup_theme', 'varya_nwaneri_setup', 12 );

/**
 * Filter the content_width in pixels, based on the child-theme's design and stylesheet.
 */
function varya_nwaneri_content_width() {
	return 750;
}
add_filter( 'varya_content_width', 'varya_nwaneri_content_width' );

/**
 * Add Google webfonts, if necessary
 *
 * - See: http://themeshaper.com/2014/08/13/how-to-add-google-fonts-to-wordpress-themes/
 */
function varya_nwaneri_fonts_url() {

	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	* supported by Playfair Display, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$novacut = esc_html_x( 'on', 'Nova Cut font: on or off', 'varya-nwaneri' );

	/* Translators: If there are characters in your language that are not
	* supported by Roboto Sans, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$overpass = esc_html_x( 'on', 'Overpass font: on or off', 'varya-nwaneri' );

	if ( 'off' !== $novacut || 'off' !== $overpass ) {
		$font_families = array();

		if ( 'off' !== $novacut ) {
			$font_families[] = 'Nova Cut';
		}

		if ( 'off' !== $overpass ) {
			$font_families[] = 'Overpass:300,300i,700';
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
function varya_nwaneri_scripts() {

	// enqueue Google fonts, if necessary
	wp_enqueue_style( 'varya-nwaneri-fonts', varya_nwaneri_fonts_url(), array(), null );

	// Child theme variables
	wp_enqueue_style( 'varya-nwaneri-variables-style', get_stylesheet_directory_uri() . '/variables.css', array(), wp_get_theme()->get( 'Version' ) );

	// dequeue parent styles
	// wp_dequeue_style( 'varya-variables-style' );

	// enqueue child styles
	wp_enqueue_style('varya-nwaneri-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ));

	// Override responsive width styles
	wp_enqueue_style( 'varya-nwaneri-responsive-style', get_stylesheet_directory_uri() . '/responsive.css', array(), wp_get_theme()->get( 'Version' ) );

	// enqueue child RTL styles
	wp_style_add_data( 'varya-nwaneri-style', 'rtl', 'replace' );

	// enqueue navigation dropdown script
	wp_enqueue_script( 'varya-nwaneri-navigation-script', get_stylesheet_directory_uri() . '/assets/scripts/navigation.js', [], false, true );
}
add_action( 'wp_enqueue_scripts', 'varya_nwaneri_scripts', 99 );

/**
 * Enqueue theme styles for the block editor.
 */
function varya_nwaneri_editor_styles() {

	// Enqueue Google fonts in the editor, if necessary
	wp_enqueue_style( 'varya-nwaneri-editor-fonts', varya_nwaneri_fonts_url(), array(), null );

	// Load the child theme styles within Gutenberg.
	wp_enqueue_style( 'varya-nwaneri-editor-variables', get_theme_file_uri( 'variables-editor.css' ), false, wp_get_theme()->get( 'Version' ), 'all' );

	// Load the parent theme styles within Gutenberg.
	wp_enqueue_style( 'varya-editor-advanced-styles', get_template_directory_uri() . '/style-editor.css', false, wp_get_theme()->get( 'Version' ), 'all' );
}
add_action( 'enqueue_block_editor_assets', 'varya_nwaneri_editor_styles', 99 );

/**
 * Enqueue Custom Cover Block Styles and Scripts
 */
function varya_nwaneri_block_extends() {

	// Button Block
	wp_enqueue_script( 'varya-nwaneri-extend-button-block',
		get_stylesheet_directory_uri() . '/block-extends/extend-button-block.js',
		array( 'wp-blocks' )
	);

	wp_enqueue_style( 'varya-nwaneri-extend-button-block',
		get_stylesheet_directory_uri() . '/block-extends/extend-button-block.css'
	);

	// Columns Block Tweaks
	wp_enqueue_script( 'varya-nwaneri-extend-columns-block',
		get_stylesheet_directory_uri() . '/block-extends/extend-columns-block.js',
		array( 'wp-blocks' )
	);

	wp_enqueue_style( 'varya-nwaneri-extend-columns-block',
		get_stylesheet_directory_uri() . '/block-extends/extend-columns-block.css'
	);

	// Cover Block Tweaks
	wp_enqueue_script( 'varya-nwaneri-extend-cover-block',
		get_stylesheet_directory_uri() . '/block-extends/extend-cover-block.js',
		array( 'wp-blocks' )
	);

	wp_enqueue_style( 'varya-nwaneri-extend-cover-block',
		get_stylesheet_directory_uri() . '/block-extends/extend-cover-block.css'
	);

	// Media & Text Block Tweaks
	wp_enqueue_script( 'varya-nwaneri-extend-media-text-block',
		get_stylesheet_directory_uri() . '/block-extends/extend-media-text-block.js',
		array( 'wp-blocks' )
	);

	wp_enqueue_style( 'varya-nwaneri-extend-media-text-block',
		get_stylesheet_directory_uri() . '/block-extends/extend-media-text-block.css'
	);

	// Quote Blobs
	wp_enqueue_script( 'varya-nwaneri-extend-quote-block',
		get_stylesheet_directory_uri() . '/block-extends/extend-quote-block.js',
		array( 'wp-blocks' )
	);

	wp_enqueue_style( 'varya-nwaneri-extend-quote-block',
		get_stylesheet_directory_uri() . '/block-extends/extend-quote-block.css'
	);

	// Separator Blobs
	wp_enqueue_script( 'varya-nwaneri-extend-separator-block',
		get_stylesheet_directory_uri() . '/block-extends/extend-separator-block.js',
		array( 'wp-blocks' )
	);

	wp_enqueue_style( 'varya-nwaneri-extend-separator-block',
		get_stylesheet_directory_uri() . '/block-extends/extend-separator-block.css'
	);

}
add_action( 'enqueue_block_assets', 'varya_nwaneri_block_extends' );

/**
 * Load extras
 */
require get_stylesheet_directory() . '/inc/custom-header.php';

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {

	require get_stylesheet_directory() . '/inc/woocommerce.php';

	// Remove parnet theme menu, see `woocommerce.php`
	function varya_nwaneri_remove_parent_cart_menu() {
		remove_filter( 'wp_nav_menu_items', 'varya_add_cart_menu', 10, 2 );
	}
	add_action( 'wp_loaded', 'varya_nwaneri_remove_parent_cart_menu' );
}
