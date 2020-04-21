<?php
/**
 * Varya Theme: Customizer
 *
 * @package WordPress
 * @subpackage Varya
 * @since 1.0.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function varya_customize_register( $wp_customize ) {
	$wp_customize->remove_setting( 'blogname' );
	$wp_customize->remove_control( 'blogname' );
	$wp_customize->remove_setting( 'blogdescription' );
	$wp_customize->remove_control( 'blogdescription' );

}
//add_action( 'customize_register', 'varya_customize_register', 11 );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function varya_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function varya_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Load custom color functions
 */
require get_template_directory() . '/classes/class-varya-custom-colors.php';