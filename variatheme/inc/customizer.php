<?php
/**
 * Varia Theme: Customizer
 *
 * @package WordPress
 * @subpackage variatheme
 * @since 1.0.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function variatheme_customize_register( $wp_customize ) {
	$wp_customize->remove_setting( 'blogname' );
	$wp_customize->remove_setting( 'blogdescription' );
	$wp_customize->remove_control( 'blogname' );
	$wp_customize->remove_control( 'blogdescription' );

	/**
	 * Primary color.
	 */
	$wp_customize->add_setting(
		'primary_color',
		array(
			'default'           => 'default',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'variatheme_sanitize_color_option',
		)
	);

	$wp_customize->add_control(
		'primary_color',
		array(
			'type'     => 'radio',
			'label'    => __( 'Primary Color', 'variatheme' ),
			'choices'  => array(
				'default' => _x( 'Default', 'primary color', 'variatheme' ),
				'custom'  => _x( 'Custom', 'primary color', 'variatheme' ),
			),
			'section'  => 'colors',
			'priority' => 5,
		)
	);

	// Add primary color hue setting and control.
	$wp_customize->add_setting(
		'primary_color_hue',
		array(
			'default'           => variatheme_get_default_hue(),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'primary_color_hue',
			array(
				'description' => __( 'Apply a custom color for buttons, links, featured images, etc.', 'variatheme' ),
				'section'     => 'colors',
				'mode'        => 'hue',
			)
		)
	);

	// Add image filter setting and control.
	$wp_customize->add_setting(
		'image_filter',
		array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'image_filter',
		array(
			'label'   => __( 'Apply a filter to featured images using the primary color', 'variatheme' ),
			'section' => 'colors',
			'type'    => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'variatheme_customize_register', 11 );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function variatheme_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function variatheme_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Bind JS handlers to instantly live-preview changes.
 */
function variatheme_customize_preview_js() {
	wp_enqueue_script( 'variatheme-customize-preview', get_theme_file_uri( '/js/customize-preview.js' ), array( 'customize-preview' ), '20181231', true );
	wp_localize_script( 'variatheme-customize-preview', 'variaThemePreviewData', array(
		'default_hue' => variatheme_get_default_hue()
	));
}
add_action( 'customize_preview_init', 'variatheme_customize_preview_js' );

/**
 * Load dynamic logic for the customizer controls area.
 */
function variatheme_panels_js() {
	wp_enqueue_script( 'variatheme-customize-controls', get_theme_file_uri( '/js/customize-controls.js' ), array(), '20181231', true );
}
add_action( 'customize_controls_enqueue_scripts', 'variatheme_panels_js' );

/**
 * Sanitize custom color choice.
 *
 * @param string $choice Whether image filter is active.
 *
 * @return string
 */
function variatheme_sanitize_color_option( $choice ) {
	$valid = array(
		'default',
		'custom',
	);

	if ( in_array( $choice, $valid, true ) ) {
		return $choice;
	}

	return 'default';
}
