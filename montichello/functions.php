<?php

if ( ! function_exists( 'montichello_blocks_support' ) ) :
    function montichello_blocks_support()  {

		// Make theme available for translation.
		load_theme_textdomain( 'montichello', get_template_directory() . '/languages' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Alignwide and alignfull classes in the block editor
		add_theme_support( 'align-wide' );

		// Adding support for core block visual styles.
		add_theme_support( 'wp-block-styles' );

		// Adding support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( './style-editor.css' );
    }
    add_action( 'after_setup_theme', 'montichello_blocks_support' );
endif;

if ( function_exists( 'register_block_style' ) ) {
	function montichello_register_block_styles() {
		/**
		 * Register block style
		 */
		register_block_style(
			'core/separator',
			array(
				'name'         => 'gap',
				'label'        => 'Gap'
			)
		);

		register_block_style(
			'core/media-text',
			array(
				'name'         => 'boxed',
				'label'        => 'Boxed'
			)
		);

		register_block_style(
			'core/media-text',
			array(
				'name'         => 'overlap',
				'label'        => 'Overlap'
			)
		);

		register_block_style(
			'core/pullquote',
			array(
				'name'         => 'stylish',
				'label'        => 'Stylish'
			)
		);
		
		register_block_style(
			'core/quote',
			array(
				'name'         => 'stylish',
				'label'        => 'Stylish'
			)
		);

		register_block_style(
			'core/navigation',
			array(
				'name'         => 'vertical',
				'label'        => 'Vertical'
			)
		);
	}

	add_action( 'init', 'montichello_register_block_styles' );
}

/**
 * Enqueue scripts and styles.
 */
function montichello_blocks_enqueue() {
	wp_enqueue_style( 'montichello-styles', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'montichello_blocks_enqueue' );

/**
 * Load base styles in edit-site.
 * (This does not use the standard add_theme_support('editor-styles') method.)
 */
function montichello_register_FSE_styles() {
	wp_register_style( 'montichello-style-variables', get_template_directory_uri() . '/css/variables.css' );
	wp_enqueue_style( 'montichello-style-variables' );

	wp_register_style( 'montichello-styles-editor', get_template_directory_uri() . '/style-editor.css' );
	wp_enqueue_style( 'montichello-styles-editor' );
}

add_action( 'admin_enqueue_scripts', 'montichello_register_FSE_styles' );
