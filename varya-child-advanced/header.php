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

		<header id="masthead" class="site-header wide-max-width">

			<?php if ( has_nav_menu( 'menu-1' ) ) : ?>
			<button id="nwaneri-toggle-navigation" class="menu-toggle" data-open="false"><?php _e( 'Menu', 'varya' ); ?></button>
			<nav id="nwaneri-site-navigation" class="site-navigation" aria-label="<?php esc_attr_e( 'Main Navigation', 'varya' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'menu-1',
						'menu_class'      => 'main-menu',
						'container_class' => 'menu-{menu slug}-container wide-max-width',
						'items_wrap'      => '<ul id="%1$s" class="%2$s" aria-label="submenu">%3$s</ul>',
					)
				);
				?>
			</nav><!-- #site-navigation -->
			<?php endif; ?>

			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<?php varya_nwaneri_show_mini_cart(); ?>
			<?php endif; ?>

			<?php if ( is_front_page() || is_home() ) : ?>
				<?php get_template_part( 'template-parts/header/custom-header' ); ?>
			<?php else : ?>
				<?php get_template_part( 'template-parts/header/site-branding' ); ?>
			<?php endif; ?>

		</header><!-- #masthead -->

	<div id="content" class="site-content">
