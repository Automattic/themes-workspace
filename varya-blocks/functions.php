<?php
/**
 * Varya Blocks functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage varya_blocks
 * @since 1.0.0
 */

/**
 * Enqueue scripts and styles.
 */
function varya_blocks_enqueue() {
	wp_enqueue_style( 'varya-blocks-styles', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'varya_blocks_enqueue' );