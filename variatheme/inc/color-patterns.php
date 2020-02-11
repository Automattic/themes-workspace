<?php
/**
 * varya: Color Patterns
 *
 * @package WordPress
 * @subpackage TwentyNineteen
 * @since 1.0
 */

/**
 * Generate the CSS for the current primary color.
 */
function varya_custom_colors_css() {

	$primary_color = varya_get_default_hue();
	if ( 'default' !== get_theme_mod( 'primary_color', 'default' ) ) {
		$primary_color = absint( get_theme_mod( 'primary_color_hue', $primary_color ) );
	}

	/**
	 * Filter varya default saturation level.
	 *
	 * @since varya 1.0
	 *
	 * @param int $saturation Color saturation level.
	 */
	$saturation = varya_get_default_saturation();
	$saturation = absint( $saturation ) . '%';

	/**
	 * Filter varya default selection saturation level.
	 *
	 * @since varya 1.0
	 *
	 * @param int $saturation_selection Selection color saturation level.
	 */
	$saturation_selection = varya_get_default_saturation_selection();
	$saturation_selection = absint( $saturation_selection ) . '%';

	/**
	 * Filter varya default lightness level.
	 *
	 * @since varya 1.0
	 *
	 * @param int $lightness Color lightness level.
	 */
	$lightness = varya_get_default_lightness();
	$lightness = absint( $lightness ) . '%';

	/**
	 * Filter varya default hover lightness level.
	 *
	 * @since varya 1.0
	 *
	 * @param int $lightness_hover Hover color lightness level.
	 */
	$lightness_hover = varya_get_default_lightness_hover();
	$lightness_hover = absint( $lightness_hover ) . '%';

	/**
	 * Filter varya default selection lightness level.
	 *
	 * @since varya 1.0
	 *
	 * @param int $lightness_selection Selection color lightness level.
	 */
	$lightness_selection = varya_get_default_lightness_selection();
	$lightness_selection = absint( $lightness_selection ) . '%';

	$theme_css = '	/* Reset color variables */
	:root {
		--global--color-primary: hsl( ' . $primary_color . ', ' . $saturation . ', ' . $lightness . ' );
		--global--color-primary-hover: hsl( ' . $primary_color . ', ' . $saturation . ', ' . $lightness_hover . ' );
		--global--color-secondary: var(--global--color-primary);
		--global--color-secondary-hover: var(--global--color-primary-hover);
		--global--color-text-selection: hsl( ' . $primary_color . ', ' . $saturation_selection . ', ' . $lightness_selection . ' );
	}';

	$editor_css = '	/* Reset color variables */
	.editor-styles-wrapper {
		--global--color-primary: hsl( ' . $primary_color . ', ' . $saturation . ', ' . $lightness . ' );
		--global--color-primary-hover: var(--global--color-primary);
		--global--color-secondary: hsl( ' . $primary_color . ', ' . $saturation . ', ' . $lightness_hover . ' );
		--global--color-secondary-hover: var(--global--color-primary-hover);
		--global--color-text-selection: hsl( ' . $primary_color . ', ' . $saturation_selection . ', ' . $lightness_selection . ' );
	}';

	if ( function_exists( 'register_block_type' ) && is_admin() ) {
		$theme_css = $editor_css;
	}

	/**
	 * Filters varya custom colors CSS.
	 *
	 * @since varya 1.0
	 *
	 * @param string $theme_css     Base theme colors CSS.
	 * @param int    $primary_color The user's selected color hue.
	 * @param string $saturation    Filtered theme color saturation level.
	 */
	return apply_filters( 'varya_custom_colors_css', $theme_css, $primary_color, $saturation );
}
