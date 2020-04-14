<?php
/**
 * Varya Theme: Customizer
 *
 * @package WordPress
 * @subpackage Varya
 * @since 1.0.0
 */

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
