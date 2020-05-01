<?php
/**
 * Root Blocks functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage root_blocks
 * @since 1.0.0
 */

/**
 * Enqueue scripts and styles.
 */
function root_blocks_enqueue() {
	wp_enqueue_style( 'root-blocks-styles', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'root_blocks_enqueue' );