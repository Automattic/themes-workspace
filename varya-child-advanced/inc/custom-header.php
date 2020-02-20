<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...
 *
 * @package Karuna
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses varya_nwaneri_header_style()
 */
function varya_nwaneri_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'varya_nwaneri_custom_header_args', array(
		'default-image'          => get_stylesheet_directory_uri() . '/assets/images/header.jpg',
		'default-text-color'     => '333333',
		'width'                  => 2000,
		'height'                 => 800,
		'flex-height'            => true,
		'wp-head-callback'       => 'varya_nwaneri_header_style',
	) ) );

	register_default_headers( array(
		'yoga' => array(
			'thumbnail_url' => get_stylesheet_directory_uri() . '/assets/images/header-thumb.jpg',
			'url'           => get_stylesheet_directory_uri() . '/assets/images/header.jpg',
			'description'   => esc_html__( 'Yoga', 'varya-nwaneri' ),
		),
		'rocks' => array(
			'thumbnail_url' => get_stylesheet_directory_uri() . '/assets/images/header2-thumb.jpg',
			'url'           => get_stylesheet_directory_uri() . '/assets/images/header2.jpg',
			'description'   => esc_html__( 'Rocks', 'varya-nwaneri' ),
		),
		'zen' => array(
			'thumbnail_url' => get_stylesheet_directory_uri() . '/assets/images/header3-thumb.jpg',
			'url'           => get_stylesheet_directory_uri() . '/assets/images/header3.jpg',
			'description'   => esc_html__( 'Zen', 'varya-nwaneri' ),
		),
	) );
}
add_action( 'after_setup_theme', 'varya_nwaneri_custom_header_setup' );

if ( ! function_exists( 'varya_nwaneri_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see varya_nwaneri_custom_header_setup().
 */
function varya_nwaneri_header_style() {
	$header_text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail.
	// get_header_textcolor() options: add_theme_support( 'custom-header' ) is default, hide text (returns 'blank') or any hex value.
	if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $header_text_color ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that.
		else :
	?>
		.site-title a {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // varya_nwaneri_header_style

/**
 * Custom function to check for a post thumbnail;
 * If Jetpack is not available, fall back to has_post_thumbnail()
 */
function varya_nwaneri_has_post_thumbnail( $post = null ) {
	if ( function_exists( 'jetpack_has_featured_image' ) ) {
		return jetpack_has_featured_image( $post );
	} else {
		return has_post_thumbnail( $post );
	}
}
