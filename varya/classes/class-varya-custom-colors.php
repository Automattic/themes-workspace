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
	 * @param str $fg_hex Colour as hexadecimal (with or without hash);
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
			$dec = floor(($fg_dec + $bg_dec) * 0.667);
			// Convert back to hex
			$new_hex .= str_pad( dechex( $dec ) , 2, 0, STR_PAD_LEFT );
		}

		return $new_hex;
	}

	/**
	 * Find the resulting colour by blending 2 colours
	 * and setting an opacity level for the foreground colour.
	 *
	 * @author J de Silva
	 * @link http://www.gidnetwork.com/b-135.html
	 * @param string $foreground Hexadecimal colour value of the foreground colour.
	 * @param integer $opacity Opacity percentage (of foreground colour). A number between 0 and 100.
	 * @param string $background Optional. Hexadecimal colour value of the background colour. Default is: <code>FFFFFF</code> aka white.
	 * @return string Hexadecimal colour value. <code>false</code> on errors.
	 */
	function varya_color_blend_by_opacity( $foreground, $opacity, $background=null ) {
		static $colors_rgb = array(); // stores colour values already passed through the hexdec() functions below.

		$foreground = preg_replace( '/[^0-9a-f]/i', '', $foreground ); //str_replace( '#', '', $foreground );

		if ( ! is_null( $background ) ) {
			$background = 'FFFFFF'; // default background.
		} else {
			$background = preg_replace( '/[^0-9a-f]/i', '', $background );
		}

		$pattern = '~^[a-f0-9]{6,6}$~i'; // accept only valid hexadecimal colour values.


		if ( !@preg_match($pattern, $foreground) or !@preg_match($pattern, $background) ) {
			echo $foreground;
			trigger_error( "Invalid hexadecimal color value(s) found", E_USER_WARNING );
			return false;
		}

		$opacity = intval( $opacity ); // validate opacity data/number.

		if ( $opacity > 100  || $opacity < 0 ) {
			trigger_error( "Opacity percentage error, valid numbers are between 0 - 100", E_USER_WARNING );
			return false;
		}

		if ( $opacity == 100 )    // $transparency == 0
			return strtoupper( $foreground );
		if ( $opacity == 0 )    // $transparency == 100
			return strtoupper( $background );

		// calculate $transparency value.
		$transparency = 100-$opacity;

		if ( !isset($colors_rgb[$foreground]) ) { // do this only ONCE per script, for each unique colour.
			$f = array(
				'r'=>hexdec($foreground[0].$foreground[1]),
				'g'=>hexdec($foreground[2].$foreground[3]),
				'b'=>hexdec($foreground[4].$foreground[5])
			);
			$colors_rgb[$foreground] = $f;
		} else { // if this function is used 100 times in a script, this block is run 99 times.  Efficient.
			$f = $colors_rgb[$foreground];
		}

		if ( !isset($colors_rgb[$background]) ) { // do this only ONCE per script, for each unique colour.
			$b = array(
				'r'=>hexdec($background[0].$background[1]),
				'g'=>hexdec($background[2].$background[3]),
				'b'=>hexdec($background[4].$background[5])
			);
			$colors_rgb[$background] = $b;
		} else { // if this FUNCTION is used 100 times in a SCRIPT, this block will run 99 times.  Efficient.
			$b = $colors_rgb[$background];
		}

		$add = array(
			'r'=>( $b['r']-$f['r'] ) / 100,
			'g'=>( $b['g']-$f['g'] ) / 100,
			'b'=>( $b['b']-$f['b'] ) / 100
		);

		$f['r'] += intval( $add['r'] * $transparency );
		$f['g'] += intval( $add['g'] * $transparency );
		$f['b'] += intval( $add['b'] * $transparency );

		return sprintf( '#%02X%02X%02X', $f['r'], $f['g'], $f['b'] );
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

				if ( '--global--color-primary' === $variable[0] && $variable[1] !== get_theme_mod( "varya_$variable[0]" ) ) {
					$theme_css .= "--global--color-primary-hover: " . $this->varya_color_blend_by_opacity( get_theme_mod( "varya_$variable[0]" ), 70, get_theme_mod( "varya_--global--color-background" ) ) . ";";
				}

				if ( '--global--color-secondary' === $variable[0] && $variable[1] !== get_theme_mod( "varya_$variable[0]" ) ) {
					$theme_css .= "--global--color-secondary-hover: " . $this->varya_color_blend_by_opacity( get_theme_mod( "varya_$variable[0]" ), 70, get_theme_mod( "varya_--global--color-background" ) ) . ";";
				}

				if ( '--global--color-foreground' === $variable[0] && $variable[1] !== get_theme_mod( "varya_$variable[0]" ) ) {
					$theme_css .= "--global--color-foreground-light: " . $this->varya_color_blend_by_opacity( get_theme_mod( "varya_$variable[0]" ), 70, get_theme_mod( "varya_--global--color-background" ) ) . ";";
				}

				if ( '--global--color-background' === $variable[0] && $variable[1] !== get_theme_mod( "varya_$variable[0]" ) ) {
					$theme_css .= "--global--color-background-light: " . $this->varya_color_blend_by_opacity( get_theme_mod( "varya_$variable[0]" ), 70, get_theme_mod( "varya_--global--color-foreground" ) ) . ";";
				}
			}
		}

		$theme_css .= "}";

		// Selection colors
		$selection_background = $this->varya_color_blend_by_opacity( get_theme_mod( "varya_--global--color-primary" ), 5, get_theme_mod( "varya_--global--color-background" ) ) . ";";
		$theme_css .= "::selection { background-color: " . $selection_background . "}";
		$theme_css .= "::-moz-selection { background-color: ". $selection_background . "}";

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
