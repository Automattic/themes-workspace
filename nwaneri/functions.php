<?php

if ( ! function_exists( 'nwaneri_blocks_support' ) ) :
    function nwaneri_blocks_support()  {

		// Make theme available for translation.
		load_theme_textdomain( 'nwaneri-blocks', get_template_directory() . '/languages' );

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
				'name'  => __( 'White', 'nwaneri-blocks' ),
				'slug'  => 'white',
				'color' => '#fff',
			),
			array(
				'name'  => __( 'Nwaneri Blue', 'nwaneri-blocks' ),
				'slug'  => 'nwaneri-blue',
				'color' => '#333366',
			),
			array(
				'name'  => __( 'Burning Red', 'nwaneri-blocks' ),
				'slug'  => 'burning-red',
				'color' => '#EB4D55',
			),
			array(
				'name'  => __( 'Cream Orange', 'nwaneri-blocks' ),
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
		/* 			'post_title' => _x( 'Blog', 'nwaneri-blocks' ), */
		/* 			'post_content' => '<!-- wp:template-part {"slug":"blog","theme":"nwaneri-blocks"} -->' */
		/* 		], */
		/* 	] */
		/* ]); */
    }
    add_action( 'after_setup_theme', 'nwaneri_blocks_support' );
endif;

/**
 * Register Google Fonts
 */
function nwaneri_blocks_fonts_url() {
	$fonts_url = '';

	/*
	 *Translators: If there are characters in your language that are not
	 * supported by Noto Serif, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$notoserif = esc_html_x( 'on', 'Noto Serif font: on or off', 'nwaneri-blocks' );

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
 * Enqueue scripts and styles.
 */
function nwaneri_blocks_scripts() {
	wp_enqueue_style( 'nwaneri-blocks-styles', get_stylesheet_uri() );
	wp_enqueue_style( 'nwaneri-blocks-block-styles', get_template_directory_uri() . '/css/blocks.css' );
	wp_enqueue_style( 'nwaneri-blocks-fonts', nwaneri_blocks_fonts_url() );
}
add_action( 'wp_enqueue_scripts', 'nwaneri_blocks_scripts' );
