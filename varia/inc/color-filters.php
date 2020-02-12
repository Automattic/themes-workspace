<?php
/**
 * variatheme: Color Filter for overriding the colors schemes in a child theme
 *
 * @package WordPress
 * @subpackage variatheme
 * @since 1.0
 */

/**
 * Define default color filters.
 */

define( 'VARIATHEME_DEFAULT_HUE', 199 );        // H
define( 'VARIATHEME_DEFAULT_SATURATION', 100 ); // S
define( 'VARIATHEME_DEFAULT_LIGHTNESS', 33 );   // L

define( 'VARIATHEME_DEFAULT_SATURATION_SELECTION', 50 );
define( 'VARIATHEME_DEFAULT_LIGHTNESS_SELECTION', 90 );
define( 'VARIATHEME_DEFAULT_LIGHTNESS_HOVER', 23 );

/**
 * The default hue (as in hsl) used for the primary color throughout this theme
 *
 * @return number the default hue
 */
function variatheme_get_default_hue() {
	return apply_filters( 'variatheme_default_hue', VARIATHEME_DEFAULT_HUE );
}

/**
 * The default saturation (as in hsl) used for the primary color throughout this theme
 *
 * @return number the default saturation
 */
function variatheme_get_default_saturation() {
	return apply_filters( 'variatheme_default_saturation', VARIATHEME_DEFAULT_SATURATION );
}

/**
 * The default lightness (as in hsl) used for the primary color throughout this theme
 *
 * @return number the default lightness
 */
function variatheme_get_default_lightness() {
	return apply_filters( 'variatheme_default_lightness', VARIATHEME_DEFAULT_LIGHTNESS );
}

/**
 * The default saturation (as in hsl) used when selecting text throughout this theme
 *
 * @return number the default saturation selection
 */
function variatheme_get_default_saturation_selection() {
	return apply_filters( 'variatheme_default_saturation_selection', VARIATHEME_DEFAULT_SATURATION_SELECTION );
}

/**
 * The default lightness (as in hsl) used when selecting text throughout this theme
 *
 * @return number the default lightness selection
 */
function variatheme_get_default_lightness_selection() {
	return apply_filters( 'variatheme_default_lightness_selection', VARIATHEME_DEFAULT_LIGHTNESS_SELECTION );
}

/**
 * The default lightness hover (as in hsl) used when hovering over links throughout this theme
 *
 * @return number the default lightness hover
 */
function variatheme_get_default_lightness_hover() {
	return apply_filters( 'variatheme_default_lightness_hover', VARIATHEME_DEFAULT_LIGHTNESS_HOVER );
}

function variatheme_has_custom_default_hue() {
	return variatheme_get_default_hue() !== VARIATHEME_DEFAULT_HUE;
}
