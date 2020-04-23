<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package WordPress
 * @subpackage Varia
 * @since 1.0.0
 */

/**
 * Remove Gutenberg `Theme` Block Styles
 */
function varya_deregister_styles() {
	wp_dequeue_style( 'wp-block-library-theme' );
}
add_action( 'wp_print_styles', 'varya_deregister_styles', 100 );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function varya_body_classes( $classes ) {

	if ( is_singular() ) {
		// Adds `singular` to singular pages.
		$classes[] = 'singular';
	} else {
		// Adds `hfeed` to non singular pages.
		$classes[] = 'hfeed';
	}

	// Add a body class if main navigation is active.
	if ( has_nav_menu( 'primary' ) ) {
		$classes[] = 'has-main-navigation';
	}

	return $classes;
}
add_filter( 'body_class', 'varya_body_classes' );

/**
 * Adds custom class to the array of posts classes.
 */
function varya_post_classes( $classes, $class, $post_id ) {
	$classes[] = 'entry';

	return $classes;
}
add_filter( 'post_class', 'varya_post_classes', 10, 3 );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function varya_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'varya_pingback_header' );

/**
 * Changes comment form default fields.
 */
function varya_comment_form_defaults( $defaults ) {
	$comment_field = $defaults['comment_field'];

	// Adjust height of comment form.
	$defaults['comment_field'] = preg_replace( '/rows="\d+"/', 'rows="5"', $comment_field );

	return $defaults;
}
add_filter( 'comment_form_defaults', 'varya_comment_form_defaults' );

/**
 * Filters the default archive titles.
 */
function varya_get_the_archive_title() {
	if ( is_category() ) {
		$title = __( 'Category Archives: ', 'varya' ) . '<span class="page-description">' . single_term_title( '', false ) . '</span>';
	} elseif ( is_tag() ) {
		$title = __( 'Tag Archives: ', 'varya' ) . '<span class="page-description">' . single_term_title( '', false ) . '</span>';
	} elseif ( is_author() ) {
		$title = __( 'Author Archives: ', 'varya' ) . '<span class="page-description">' . get_the_author_meta( 'display_name' ) . '</span>';
	} elseif ( is_year() ) {
		$title = __( 'Yearly Archives: ', 'varya' ) . '<span class="page-description">' . get_the_date( _x( 'Y', 'yearly archives date format', 'varya' ) ) . '</span>';
	} elseif ( is_month() ) {
		$title = __( 'Monthly Archives: ', 'varya' ) . '<span class="page-description">' . get_the_date( _x( 'F Y', 'monthly archives date format', 'varya' ) ) . '</span>';
	} elseif ( is_day() ) {
		$title = __( 'Daily Archives: ', 'varya' ) . '<span class="page-description">' . get_the_date() . '</span>';
	} elseif ( is_post_type_archive() ) {
		$cpt = get_post_type_object( get_queried_object()->name );
		/* translators: %s: Post type singular name */
		$title = sprintf( esc_html__( '%s Archives', 'varya' ),
			$cpt->labels->singular_name
		);
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: %s: Taxonomy singular name */
		$title = sprintf( esc_html__( '%s Archives', 'varya' ),
			$tax->labels->singular_name
		);
	} else {
		$title = __( 'Archives:', 'varya' );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'varya_get_the_archive_title' );

/**
 * Determines if post thumbnail can be displayed.
 */
function varya_can_show_post_thumbnail() {
	return apply_filters( 'varya_can_show_post_thumbnail', ! post_password_required() && ! is_attachment() && has_post_thumbnail() );
}

/**
 * Returns the size for avatars used in the theme.
 */
function varya_get_avatar_size() {
	return 60;
}

/**
 * Returns true if comment is by author of the post.
 *
 * @see get_comment_class()
 */
function varya_is_comment_by_post_author( $comment = null ) {
	if ( is_object( $comment ) && $comment->user_id > 0 ) {
		$user = get_userdata( $comment->user_id );
		$post = get_post( $comment->comment_post_ID );
		if ( ! empty( $user ) && ! empty( $post ) ) {
			return $comment->user_id === $post->post_author;
		}
	}
	return false;
}

/**
 * WCAG 2.0 Attributes for Dropdown Menus
 *
 * Adjustments to menu attributes tot support WCAG 2.0 recommendations
 * for flyout and dropdown menus.
 *
 * @ref https://www.w3.org/WAI/tutorials/menus/flyout/
 */
function varya_nav_menu_link_attributes( $atts, $item, $args, $depth ) {

	// Add [aria-haspopup] and [aria-expanded] to menu items that have children
	$item_has_children = in_array( 'menu-item-has-children', $item->classes );
	if ( $item_has_children ) {
		$atts['aria-haspopup'] = 'true';
		$atts['aria-expanded'] = 'false';
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'varya_nav_menu_link_attributes', 10, 4 );

/*
 * Create the continue reading link
 */
function varya_continue_reading_link() {

	if ( ! is_admin() ) {
		$continue_reading = sprintf(
			/* translators: %s: Name of current post. */
			wp_kses( __( 'Continue reading %s', 'varya' ), array( 'span' => array( 'class' => array() ) ) ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		);

		return '<a class="more-link" href="' . esc_url( get_permalink() ) . '">' . $continue_reading . '</a>';
	}
}

// Filter the excerpt more link
add_filter( 'excerpt_more', 'varya_continue_reading_link' );

// Filter the content more link
add_filter( 'the_content_more_link', 'varya_continue_reading_link' );

/**
 * Add a dropdown icon to top-level menu items.
 *
 * @param string $output Nav menu item start element.
 * @param object $item   Nav menu item.
 * @param int    $depth  Depth.
 * @param object $args   Nav menu args.
 * @return string Nav menu item start element.
 * Add a dropdown icon to top-level menu items
 */
function varya_add_dropdown_icons( $output, $item, $depth, $args ) {

	// Only add class to 'top level' items on the 'primary' menu.
	if ( ! isset( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $output;
	}

	if ( 'primary' == $args->theme_location && $depth === 0 ) {
		if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {

			// Add SVG icon to parent items.
			$output .= varya_get_icon_svg( 'keyboard_arrow_down', 24 );
		}
	}

	return $output;
}
add_filter( 'walker_nav_menu_start_el', 'varya_add_dropdown_icons', 10, 4 );
