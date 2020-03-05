<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Varya
 */

/**
 * Enqueue scripts and styles.
 */
function varya_nwaneri_woocommerce_scripts() {

	// WooCommerce styles
	wp_enqueue_style( 'varya-nwaneri-woocommerce-style', get_stylesheet_directory_uri() . '/style-woocommerce.css', array(), wp_get_theme()->get( 'Version' ) );

	// WooCommerce scripts
	wp_enqueue_script( 'varya-nwaneri-wc-navigation-script', get_stylesheet_directory_uri() . '/assets/scripts/wc-navigation.js', [], false, true );

}
add_action( 'wp_enqueue_scripts', 'varya_nwaneri_woocommerce_scripts' );

/**
 * Remove default mini cart
 */
remove_filter( 'wp_nav_menu_items', 'varya_add_cart_menu', 10, 2 );

/**
 * Add WooCommerce mini-cart link to primary menu
 */
function varya_nwaneri_show_mini_cart() {
	echo sprintf(
		'<button id="nwaneri-toggle-minicart" class="minicart-toggle" data-open="false">%1$s <span class="screen-reader-text">%2$s</span></button>
		<nav id="nwaneri-minicart" class="minicart-navigation" aria-label="%2$s">
			<div class="woocommerce-menu-container wide-max-width">
				<ul id="woocommerce-menu" class="main-menu" aria-label="submenu">
					<li class="menu-item woocommerce-menu-item %9$s" title="%5$s">
						%7$s
						<ul class="sub-menu">
							<li class="woocommerce-cart-widget" title="%6$s">
								%8$s
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>',
		varya_get_icon_svg( 'shopping_cart', 24 ),
		esc_html__( 'Cart', 'varya' ),
		esc_html__( 'expanded', 'varya' ),
		esc_html__( 'collapsed', 'varya' ),
		esc_attr__( 'View your shopping cart', 'varya' ),
		esc_attr__( 'View your shopping list', 'varya' ),
		varya_cart_link(),
		varya_cart_widget(),
		is_cart() ? 'current-menu-item' : ''
	);
}
