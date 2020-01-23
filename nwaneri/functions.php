<?php

if ( ! function_exists( 'nwaneri_support' ) ) :
    function nwaneri_support()  {

		// Make theme available for translation.
		load_theme_textdomain( 'nwaneri', get_template_directory() . '/languages' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Alignwide and alignfull classes in the block editor
		add_theme_support( 'align-wide' );

		// Adding support for core block visual styles.
		add_theme_support( 'wp-block-styles' );

		// Adding support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Support a custom color palette.
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

		/* // Starter content */
		/* add_theme_support('starter-content', [ */
		/* 	// Static front page set to Home, posts page set to Blog */
		/* 	'options' => [ */
		/* 		'show_on_front' => 'page', */
		/* 		'page_on_front' => '{{home}}', */
		/* 	], */
		/* 	// Starter pages to include */
		/* 	'posts' => [ */
		/* 		'home', */
		/* 		'blog' => [ */
		/* 			'post_title' => _x( 'Blog', 'nwaneri' ), */
		/* 			'post_content' => '<!-- wp:template-part {"slug":"blog","theme":"nwaneri"} -->' */
		/* 		], */
		/* 	] */
		/* ]); */
    }
    add_action( 'after_setup_theme', 'nwaneri_support' );
endif;

/**
 * Register Google Fonts
 */
function nwaneri_fonts_url() {
	$fonts_url = '';

	/*
	 *Translators: If there are characters in your language that are not
	 * supported by Noto Serif, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$notoserif = esc_html_x( 'on', 'Noto Serif font: on or off', 'nwaneri' );

	if ( 'off' !== $notoserif ) {
		$font_families = array();
		$font_families[] = 'Noto Serif:400,400italic,700,700italic';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}

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
			get_template_directory_uri() . '/css/block-styles.css',
			array(),
			'1.1'
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
			'core/media-text',
				array(
					'name'					=> 'media-text-hero',
					'label'					=> 'Hero',
					'style_handle'	=> 'block-styles-stylesheet',
				)
		);
	}

	add_action( 'init', 'nwaneri_register_block_styles' );
}


/**
 * Enqueue scripts and styles.
 */
function nwaneri_scripts() {
	wp_enqueue_style( 'nwaneri-styles', get_template_directory_uri() . '/css/style.css' );
	wp_enqueue_style( 'nwaneri-editor-styles', get_template_directory_uri() . '/css/editor-styles.css' );
	/* wp_enqueue_style( 'nwaneri-fonts', nwaneri_fonts_url() ); */
}
add_action( 'wp_enqueue_scripts', 'nwaneri_scripts' );
