<?php
/**
 * Default Style functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Varya
 * @since 1.0.0
 */

/**
 * Enqueue scripts and styles for the frontend.
 */
function varya_default_variables() {

	// Default variables
	wp_enqueue_style( 'varya-default-variables-style', get_template_directory_uri() . '/default-style/variables.css', array(), wp_get_theme()->get( 'Version' ) );

	// Default extra styles
	wp_enqueue_style( 'varya-default-extra-style', get_template_directory_uri() . '/default-style/extra.css', array(), wp_get_theme()->get( 'Version' ) );

}
add_action( 'wp_enqueue_scripts', 'varya_default_variables' );

/**
 * Enqueue scripts and styles for the editor.
 */
function varya_editor_default_variables() {

	// Default variables
	wp_enqueue_style( 'varya-default-variables-style', get_template_directory_uri() . '/default-style/variables-editor.css', array(), wp_get_theme()->get( 'Version' ) );

}
add_action( 'enqueue_block_editor_assets', 'varya_editor_default_variables' );

