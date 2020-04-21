<?php
/**
 * Varya Theme: Custom Colors Class
 *
 * @package WordPress
 * @subpackage Varya
 * @since 1.0.0
 */

/**
 * This class is in charge of color customization via the Customizer.
 *
 * Each variable that needs to be updated is defined in the $varya_color_variables array below. 
 * A customizer setting is created for each color, and custom CSS is enqueued in the front and back end.
 *
 * @since 1.0.0
 */
class Varya_Custom_Colors {

	private $varya_color_variables = array();

	function __construct() {

		/**
		 * Define Varia Color Variables
		 */
		$this->$varya_color_variables = array(
			array( '--global--color-primary', '#000000', 'Primary Color' ),
			array( '--global--color-secondary', '#A36265', 'Secondary Color' ),
			array( '--global--color-foreground', '#333333', 'Foreground Color' ),
			array( '--global--color-background', '#FFFFFF', 'Background Color' ),
			array( '--global--color-border', '#EFEFEF', 'Borders Color' )
		);

		/**
		 * Register Customizer Actions
		 */
		add_action( 'customize_register', array( $this, 'varya_customize_colors_register' ) );

		/**
		 * Render custom colors in the Customizer and front end.
		 */
		add_action( 'wp_head', array( $this, 'varya_css_wrap' ) );
	}

	/**
	 * Add Theme Options for the Customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	function varya_customize_colors_register( $wp_customize ) {

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
		foreach ( $this->$varya_color_variables as $variable ) {
			$wp_customize->add_setting( "varya_$variable[0]", array(
				'default'        => esc_html( $variable[1] )
			 ) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "varya_$variable[0]", array(
				'section'   => 'varya_options',
				'label'     => __( $variable[2], 'varya' )
			) ) );
		}
	}

	/**
	 * Generate stylesheet adjustments
	 */
	function varya_generate_styles() {

		$theme_css = ':root {';

		foreach ( $this->$varya_color_variables as $variable ) {
			if ( '' !== get_theme_mod( "varya_$variable" ) ) {
				$theme_css .= $variable[0] . ":" . get_theme_mod( "varya_$variable[0]" ) . ";";
			}
		}

		$theme_css .= "}";
		return $theme_css;
	}

	/**
	 * Render custom color CSS in customizer and front end.
	 */
	function varya_css_wrap() {

		// Only include custom colors in frontend.
		if ( is_admin() ) {
			return;
		} ?>

		<style type="text/css" id="varia-adjstments">
			<?php echo $this->varya_generate_styles(); ?>
		</style>
		<?php
	}

}

new Varya_Custom_Colors;