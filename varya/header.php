<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Varya
 * @since 1.0.0
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'varya' ); ?></a>

		<header id="masthead" class="site-header default-max-width">

			<?php get_template_part( 'template-parts/header/site-branding' ); ?>

			<?php if ( has_nav_menu( 'primary' ) ) : ?>
				<nav id="site-navigation" class="primary-navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'varya' ); ?>">
					<button id="toggle-menu" class="button">
						<span class="dropdown-icon open"><?php _e( 'Menu', 'varya' ); ?> <?php echo varya_get_icon_svg( 'menu' ) ?></span>
						<span class="dropdown-icon close"><?php _e( 'Close', 'varya' ); ?> <?php echo varya_get_icon_svg( 'close' ) ?></span>
						<span class="hide-visually expanded-text"><?php _e( 'expanded', 'varya' ); ?></span>
						<span class="hide-visually collapsed-text"><?php _e( 'collapsed', 'varya' ); ?></span>
					</button>
					<?php
					// Get menu slug
					$location_name = 'primary';
					$locations = get_nav_menu_locations();
					$menu_id = $locations[ $location_name ];
					$menu = wp_get_nav_menu_object( $menu_id );

					wp_nav_menu(
						array(
							'theme_location'  => 'primary',
							'menu_class'      => 'menu-wrapper',
							'container_class' => 'primary-menu-container menu-'. $menu->slug .'-container',
							'items_wrap'      => '<ul id="%1$s" class="%2$s" aria-label="submenu">%3$s</ul>',
						)
					);
					?>
				</nav><!-- #site-navigation -->
			<?php endif; ?>

			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<nav class="woo-navigation" aria-label="<?php esc_attr_e( 'Woo Minicart', 'varya' ); ?>">
					<?php echo( sprintf(
						'<button id="toggle-cart" class="button">
							<span class="dropdown-icon open">%1$s %2$s</span>
							<span class="dropdown-icon close">%3$s %4$s</span>
							<span class="hide-visually expanded-text">%5$s</span>
							<span class="hide-visually collapsed-text">%6$s</span>
						</button>
						<div class="woocommerce-menu-container">
						<ul id="woocommerce-menu" class="menu-wrapper" aria-label="submenu">
						<li class="menu-item woocommerce-menu-item %7$s" title="%8$s">
							%9$s
							<ul class="sub-menu">
								<li class="woocommerce-cart-widget" title="%10$s">
									%11$s
								</li>
							</ul>
						</li>',
						varya_get_icon_svg( 'shopping_cart' ),
						esc_html__( 'Cart', 'varya' ),
						esc_html__( 'Close', 'varya' ),
						varya_get_icon_svg( 'close' ),
						esc_html__( 'expanded', 'varya' ),
						esc_html__( 'collapsed', 'varya' ),
						is_cart() ? 'current-menu-item' : '',
						esc_attr__( 'View your shopping cart', 'varya' ),
						varya_cart_link(),
						esc_attr__( 'View your shopping list', 'varya' ),
						varya_cart_widget()
					) ); ?>
				</nav><!-- .woo-navigation -->
			<?php endif; ?>

			<?php if ( has_nav_menu( 'social' ) ) : ?>
				<nav class="social-navigation" aria-label="<?php esc_attr_e( 'Social Links Menu', 'varya' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'social',
							'link_before'    => '<span class="screen-reader-text">',
							'link_after'     => '</span>' . varya_get_icon_svg( 'link' ),
							'depth'          => 1,
						)
					);
					?>
				</nav><!-- .social-navigation -->
			<?php endif; ?>

		</header><!-- #masthead -->

	<div id="content" class="site-content">
