<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Varya
 */
/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function varya_woocommerce_setup() {
	add_theme_support( 'woocommerce', apply_filters( 'varya_woocommerce_args', array(
		'single_image_width'    => 750,
		'thumbnail_image_width' => 350,
		'product_grid'          => array(
			'default_columns' => 3,
			'default_rows'    => 6,
			'min_columns'     => 1,
			'max_columns'     => 6,
			'min_rows'        => 1
		)
	) ) );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'varya_woocommerce_setup' );

/**
 * Add a custom wrapper for woocomerce content
 */
function varya_content_wrapper_start() {
	echo '<article id="woocommerce-wrapper" class="wide-max-width">';
}
add_action('woocommerce_before_main_content', 'varya_content_wrapper_start', 10);

function varya_content_wrapper_end() {
	echo '</article>';
}
add_action('woocommerce_after_main_content', 'varya_content_wrapper_end', 10);

/**
 * Add a custom wrapper for woocomerce cart
 */
function varya_cart_wrapper_start() {
	echo '<div id="woocommerce-cart-wrapper" class="wide-max-width">';
}
add_action('woocommerce_before_cart', 'varya_cart_wrapper_start', 10);
add_action('woocommerce_before_checkout_form', 'varya_cart_wrapper_start', 10);

function varya_cart_wrapper_end() {
	echo '</div>';
}
add_action('woocommerce_after_cart', 'varya_cart_wrapper_end', 10);
add_action('woocommerce_after_checkout_form', 'varya_cart_wrapper_end', 10);

/**
 * Add a custom wrapper for woocomerce my-account
 */
function varya_my_account_wrapper_start() {
	echo '<div id="woocommerce-my-account-wrapper" class="wide-max-width">';
}
add_action('woocommerce_before_account_navigation', 'varya_my_account_wrapper_start', 10);
add_action('woocommerce_before_customer_login_form', 'varya_my_account_wrapper_start', 10);

function varya_my_account_wrapper_end() {
	echo '</div>';
}
add_action('woocommerce_account_dashboard', 'varya_my_account_wrapper_end', 10);
add_action('woocommerce_after_customer_login_form', 'varya_my_account_wrapper_end', 10);

/**
 * Display category image on category archive
 */
function varya_category_image() {
    if ( is_product_category() ){
		global $wp_query;
		$cat = $wp_query->get_queried_object();
		$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
		$image = wp_get_attachment_url( $thumbnail_id );
		if ( $image ) {
			echo '<img src="' . $image . '" alt="' . $cat->name . '" />';
		}
	}
}
add_action( 'woocommerce_archive_description', 'varya_category_image', 2 );

/**
 * Remove WooCommerce Sidebar
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Enqueue scripts and styles.
 */
function varya_woocommerce_scripts() {

	// WooCommerce styles
	wp_enqueue_style( 'varya-woocommerce-style', get_stylesheet_directory_uri() . '/assets/css/style-woocommerce.css', array(), wp_get_theme()->get( 'Version' ) );

	// WooCommerce RTL styles
	wp_style_add_data( 'varya-woocommerce-style', 'rtl', 'replace' );

}
add_action( 'wp_enqueue_scripts', 'varya_woocommerce_scripts' );

/**
 * Setup cart link for main menu
 */
if ( ! function_exists( 'varya_cart_link' ) ) {
	/**
	 * Cart Link
	 * Display a link to the cart including the number of items present and the cart total
	 *
	 * @return void
	 * @since  1.0.0
	 */
	function varya_cart_link() {

		$link_output = sprintf(
			'<a class="woocommerce-cart-link" href="%1$s" title="%2$s">
				%3$s
				<span class="woocommerce-cart-subtotal">%4$s</span>
				<small class="woocommerce-cart-count">%5$s</small>
			</a>',
			esc_url( wc_get_cart_url() ),
			esc_attr__( 'View your shopping cart', 'varya' ),
			varya_get_icon_svg( 'shopping_cart', 16 ),
			wp_kses_post( WC()->cart->get_cart_subtotal() ),
			wp_kses_data( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'varya' ), WC()->cart->get_cart_contents_count() ) )
		);

		return $link_output;
	}
}

/**
 * Setup cart fragments
 */
if ( ! function_exists( 'varya_cart_subtotal_fragment' ) ) {
	/**
	 * Cart Subtotal Fragments
	 * Ensure cart subtotal amount update when products are added to the cart via AJAX
	 *
	 * @param  array $fragments Fragments to refresh via AJAX.
	 * @return array            Fragments to refresh via AJAX
	 */
	function varya_cart_subtotal_fragment( $fragments ) {
		ob_start();
		echo '<span class="woocommerce-cart-subtotal">' . wp_kses_post( WC()->cart->get_cart_subtotal() ) . '</span>';
		$fragments['.woocommerce-cart-subtotal'] = ob_get_clean();
		return $fragments;
	}
}

if ( ! function_exists( 'varya_cart_count_fragment' ) ) {
	/**
	 * Cart Count Fragments
	 * Ensure cart item count update when products are added to the cart via AJAX
	 *
	 * @param  array $fragments Fragments to refresh via AJAX.
	 * @return array            Fragments to refresh via AJAX
	 */
	function varya_cart_count_fragment( $fragments ) {
		ob_start();
		echo '<small class="woocommerce-cart-count">' . wp_kses_data( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'varya' ), WC()->cart->get_cart_contents_count() ) ) . '</small>';
		$fragments['.woocommerce-cart-count'] = ob_get_clean();
		return $fragments;
	}
}

/**
 * Setup cart widget for mini-cart dropdown
 */
if ( ! function_exists( 'varya_cart_widget' ) ) {
	/**
	 * Cart Items List
	 * Ensure cart contents update when products are added to the cart via AJAX
	 *
	 * @param  array $fragments Fragments to refresh via AJAX.
	 * @return array            Fragments to refresh via AJAX
	 */
	function varya_cart_widget() {
		ob_start();
		the_widget( 'WC_Widget_Cart', 'title=' );
		$widget_output = ob_get_contents();
		ob_end_clean();
		return $widget_output;
	}
}

/**
 * Add cart fragment filters
 *
 * @see varya_cart_subtotal_fragment() and varya_cart_count_fragment()
 */
if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.3', '>=' ) ) {
	add_filter( 'woocommerce_add_to_cart_fragments', 'varya_cart_subtotal_fragment', 10, 1 );
	add_filter( 'woocommerce_add_to_cart_fragments', 'varya_cart_count_fragment', 10, 1 );
} else {
	add_filter( 'add_to_cart_fragments', 'varya_cart_subtotal_fragment' );
	add_filter( 'add_to_cart_fragments', 'varya_cart_count_fragment' );
}

/**
 * Add WooCommerce mini-cart link to primary menu
 */
function varya_add_cart_menu( $nav, $args ) {
	if ( $args->theme_location == 'menu-1' ) {
		return sprintf(
			'%1$s
			</ul></div>
			<input type="checkbox" role="button" aria-haspopup="true" id="woocommerce-toggle" class="hide-visually">
			<label for="woocommerce-toggle" id="toggle-cart" class="button">%2$s %3$s
				<span class="dropdown-icon open">+</span>
				<span class="dropdown-icon close">×</span>
				<span class="hide-visually expanded-text">%4$s</span>
				<span class="hide-visually collapsed-text">%5$s</span>
			</label>
			<div class="woocommerce-menu-container">
			<ul id="woocommerce-menu" class="main-menu" aria-label="submenu">
			<li class="menu-item woocommerce-menu-item %10$s" title="%6$s">
				%8$s
				<ul class="sub-menu">
					<li class="woocommerce-cart-widget" title="%7$s">
						%9$s
					</li>
				</ul>
			</li>',
			$nav,
			varya_get_icon_svg( 'shopping_cart', 16 ),
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

	// Our primary menu isn't set, return the regular nav
	return $nav;
}
add_filter( 'wp_nav_menu_items', 'varya_add_cart_menu', 10, 2 );
