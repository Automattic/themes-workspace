<?php
/**
 * Varya Theme: Custom Colors Class
 *
 * This class is in charge of color customization via the Customizer.
 *
 * Each variable that needs to be updated is defined in the $varya_custom_color_variables array below.
 * A customizer setting is created for each color, and custom CSS-variables are enqueued in the front and back end.
 *
 * @package WordPress
 * @subpackage Varya
 * @since 1.0.0
 */

class Varya_Custom_Colors {

private $varya_custom_color_variables = array();

	function __construct() {

		/**
		 * Define color variables
		 */
		$this->$varya_custom_color_variables = array(
			array( '--global--color-primary', '#000000', 'Primary Color' ),
			array( '--global--color-secondary', '#A36265', 'Secondary Color' ),
			array( '--global--color-foreground', '#333333', 'Foreground Color' ),
			array( '--global--color-background', '#FFFFFF', 'Background Color' ),
			array( '--global--color-border', '#EFEFEF', 'Borders Color' )
		);

		/**
		 * Register Customizer actions
		 */
		add_action( 'customize_register', array( $this, 'varya_customize_custom_colors_register' ) );

		/**
		 * Enqueue color variables for customizer & frontend.
		 */
		add_action( 'wp_enqueue_scripts', array( $this, 'varya_custom_color_variables' ) );

		/**
		 * Enqueue color variables for editor.
		 */
		add_action( 'enqueue_block_editor_assets', array( $this, 'varya_editor_custom_color_variables' ) );
	}

	/**
	 * Auto-set color luminance for hover and selection colors
	 *
	 * Lightens/darkens a given colour (hex format), returning the altered colour in hex format.7
	 *
	 * @param str $hexcolor Colour as hexadecimal (with or without hash);
	 * @percent float $percent Decimal ( 0.2 = lighten by 20%(), -0.4 = darken by 40%() )
	 * @return str Lightened/Darkend colour as hexadecimal (with hash);
	 */
	function varya_color_midpoint( $fg_hex, $bg_hex ) {

		// Validate hex color string
		$fg_hex = preg_replace( '/[^0-9a-f]/i', '', $fg_hex );
		$bg_hex = preg_replace( '/[^0-9a-f]/i', '', $bg_hex );
		$new_hex = '#';

		// Foreground color
		if ( strlen( $fg_hex ) < 6 ) {
			$fg_hex = $fg_hex[0] + $fg_hex[0] + $fg_hex[1] + $fg_hex[1] + $fg_hex[2] + $fg_hex[2];
		}

		// Background color
		if ( strlen( $bg_hex ) < 6 ) {
			$bg_hex = $bg_hex[0] + $bg_hex[0] + $bg_hex[1] + $bg_hex[1] + $bg_hex[2] + $bg_hex[2];
		}

		// Convert to decimal and find midpoint between two colors
		for ($i = 0; $i < 3; $i++) {
			$fg_dec = hexdec( substr( $fg_hex, $i*2, 2 ) );
			$bg_dec = hexdec( substr( $bg_hex, $i*2, 2 ) );
			$dec = floor(($fg_dec + $bg_dec) / 2);
			// Convert back to hex
			$new_hex .= str_pad( dechex( $dec ) , 2, 0, STR_PAD_LEFT );
		}

		return $new_hex;
	}

	/**
	 * Add Theme Options for the Customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	function varya_customize_custom_colors_register( $wp_customize ) {

		/**
		 * Create color options panel.
		 */
		$wp_customize->add_section( 'varya_options', array(
			'capability' => 'edit_theme_options',
			'title'      => esc_html__( 'Colors', 'varya' ),
		) );

		/**
		 * Create toggle between default and custom colors.
		 */
		$wp_customize->add_setting(
			'custom_colors_active',
			array(
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => array( $this, 'sanitize_select' ),
				'transport'         => 'refresh',
				'default'           => 'default',
			)
		);

		$wp_customize->add_control(
			'custom_colors_active',
			array(
				'type'    => 'radio',
				'section' => 'varya_options',
				'label'   => __( 'Colors', 'varya' ),
				'choices' => array(
					'default' => __( 'Theme Default', 'varya' ),
					'custom'  => __( 'Custom', 'varya' ),
				),
			)
		);

		/**
		 * Create customizer color controls.
		 */
		foreach ( $this->$varya_custom_color_variables as $variable ) {
			$wp_customize->add_setting(
				"varya_$variable[0]",
				array(
					'default'	=> esc_html( $variable[1] )
				)
			);
			$wp_customize->add_control( new WP_Customize_Color_Control(
				$wp_customize,
				"varya_$variable[0]",
				array(
					'section'   => 'varya_options',
					'label'     => __( $variable[2], 'varya' ),
					'active_callback' => function() use ( $wp_customize ) {
						return ( 'custom' === $wp_customize->get_setting( 'custom_colors_active' )->value() );
					},
				)
			) );
		}
	}

	/**
	 * Generate color variables.
	 */
	function varya_generate_custom_color_variables( $context = null ) {

		if ( $context === 'editor' ) {
			$theme_css = ':root .editor-styles-wrapper {';
		} else {
			$theme_css = ':root {';
		}

		foreach ( $this->$varya_custom_color_variables as $variable ) {
			if ( '' !== get_theme_mod( "varya_$variable" ) ) {
				$theme_css .= $variable[0] . ":" . get_theme_mod( "varya_$variable[0]" ) . ";";

				if ( '--global--color-primary' === $variable[0] ) {
					$theme_css .= "--global--color-primary-hover: " . $this->varya_color_midpoint( get_theme_mod( "varya_$variable[0]" ), get_theme_mod( "varya_--global--color-background" ) ) . ";";
				}

				if ( '--global--color-secondary' === $variable[0] ) {
					$theme_css .= "--global--color-secondary-hover: " . $this->varya_color_midpoint( get_theme_mod( "varya_$variable[0]" ), get_theme_mod( "varya_--global--color-background" ) ) . ";";
				}

				if ( '--global--color-foreground' === $variable[0] ) {
					$theme_css .= "--global--color-foreground-light: " . $this->varya_color_midpoint( get_theme_mod( "varya_$variable[0]" ), get_theme_mod( "varya_--global--color-background" ) ) . ";";
				}

				if ( '--global--color-background' === $variable[0] ) {
					$theme_css .= "--global--color-background-light: " . $this->varya_color_midpoint( get_theme_mod( "varya_$variable[0]" ), get_theme_mod( "varya_--global--color-foreground" ) ) . ";";
				}
			}
		}

		//$theme_css .= "--global--color-secondary-hover: " . $this->varya_color_midpoint( '', '' ) . ";";
		$theme_css .= "}";
		$theme_css .= "::selection { background-color: var(--global--color-foreground); color: var(--global--color-background); }";
		$theme_css .= "::-moz-selection { background-color: var(--global--color-foreground); color: var(--global--color-background); }";

		return $theme_css;
	}

	/**
	 * Customizer & frontend custom color variables.
	 */
	function varya_custom_color_variables() {
		if ( 'default' !== get_theme_mod( 'custom_colors_active' ) ) {
			wp_add_inline_style( 'varya-style', $this->varya_generate_custom_color_variables() );
		}
	}

	/**
	 * Editor custom color variables.
	 */
	function varya_editor_custom_color_variables() {
		wp_enqueue_style( 'varya-editor-variables', get_template_directory_uri() . '/assets/css/variables-editor.css', array(), wp_get_theme()->get( 'Version' ) );
		if ( 'default' !== get_theme_mod( 'custom_colors_active' ) ) {
			wp_add_inline_style( 'varya-editor-variables', $this->varya_generate_custom_color_variables( 'editor' ) );
		}
	}

	/**
	 * Sanitize select.
	 *
	 * @param string $input The input from the setting.
	 * @param object $setting The selected setting.
	 *
	 * @return string $input|$setting->default The input from the setting or the default setting.
	 */
	public static function sanitize_select( $input, $setting ) {
		$input   = sanitize_key( $input );
		$choices = $setting->manager->get_control( $setting->id )->choices;
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}

}

new Varya_Custom_Colors;
