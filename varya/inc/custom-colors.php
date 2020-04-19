<?php
/**
 * Varya Theme: Custom Colors
 *
 * @package WordPress
 * @subpackage Varya
 * @since 1.0.0
 */

/**
 * Define Varia Color Variables
 */
$varya_color_variables = array(
	array( '--global--color-primary', '#000000', 'Primary Color' ),
	array( '--global--color-secondary', '#A36265', 'Secondary Color' ),
	array( '--global--color-foreground', '#333333', 'Foreground Color' ),
	array( '--global--color-background', '#FFFFFF', 'Background Color' ),
	array( '--global--color-border', '#EFEFEF', 'Borders Color' )
);

/**
 * Add Theme Options for the Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function varya_customize_colors_register( $wp_customize ) {
	global $varya_color_variables;

	/**
	 * Create color options panel
	 */
	$wp_customize->add_section( 'varya_options', array(
		'capability' => 'edit_theme_options',
		'title'      => esc_html__( 'Colors', 'varya' ),
	) );

	/**
	 * Create customizer color controls
	 */
	foreach ( $varya_color_variables as $variable ) {
		$wp_customize->add_setting( "varya_$variable[0]", array(
			'default'        => esc_html( $variable[1] )
		 ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "varya_$variable[0]", array(
			'section'   => 'varya_options',
			'label'     => __( $variable[2], 'varya' )
		) ) );
	}

}
add_action( 'customize_register', 'varya_customize_colors_register' );

/**
 * Generate Stylesheet Adjustments
 */
function varya_generate_styles() {
	global $varya_color_variables;

	$theme_css = ':root {';

	foreach ( $varya_color_variables as $variable ) {
		if ( '' !== get_theme_mod( "varya_$variable" ) ) {
			$theme_css .= $variable[0] . ":" . get_theme_mod( "varya_$variable[0]" ) . ";";
		}
	}

	$theme_css .= "}";
	return $theme_css;
}

/**
 * Display custom color CSS in customizer and on frontend.
 */
function varya_css_wrap() {

	// Only include custom colors in frontend.
	if ( is_admin() ) {
		return;
	} ?>

	<style type="text/css" id="varia-adjstments">
		<?php echo varya_generate_styles(); ?>
	</style>
	<?php
}
add_action( 'wp_head', 'varya_css_wrap' );