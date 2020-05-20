<?php
/**
 * Custom template tags for this theme
 *
 * @package WordPress
 * @subpackage Varya
 * @since 1.0.0
 */

if ( ! function_exists( 'varya_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function varya_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		printf(
			'<span class="posted-on">%1$s<a href="%2$s" rel="bookmark">%3$s</a></span>',
			varya_get_icon_svg( 'calendar', 16 ),
			esc_url( get_permalink() ),
			$time_string
		);
	}
endif;

if ( ! function_exists( 'varya_posted_by' ) ) :
	/**
	 * Prints HTML with meta information about theme author.
	 */
	function varya_posted_by() {
		printf(
			/* translators: 1: SVG icon. 2: post author, only visible to screen readers. 3: author link. */
			'<span class="byline">%1$s<span class="screen-reader-text">%2$s</span><span class="author vcard"><a class="url fn n" href="%3$s">%4$s</a></span></span>',
			varya_get_icon_svg( 'person', 16 ),
			__( 'Posted by', 'varya' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);
	}
endif;

if ( ! function_exists( 'varya_comment_count' ) ) :
	/**
	 * Prints HTML with the comment count for the current post.
	 */
	function varya_comment_count() {
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			echo varya_get_icon_svg( 'comment', 16 );

			/* translators: %s: Name of current post. Only visible to screen readers. */
			comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'varya' ), get_the_title() ) );

			echo '</span>';
		}
	}
endif;

if ( ! function_exists( 'varya_entry_meta_header' ) ) :
	/**
	 * Allow child themes to include meta in the header of the post
	 * by overwriting this function.
	 */
	function varya_entry_meta_header() {
		/* Leaving this empty so child themes can optionally add entry-meta to the header */
	}
endif;

if ( ! function_exists( 'varya_entry_meta_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function varya_entry_meta_footer() {

		// Hide author, post date, category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			// Posted by
			varya_posted_by();

			// Posted on
			varya_posted_on();

			/* translators: used between list items, there is a space after the comma. */
			$categories_list = get_the_category_list( __( ', ', 'varya' ) );
			if ( $categories_list ) {
				printf(
					/* translators: 1: SVG icon. 2: posted in label, only visible to screen readers. 3: list of categories. */
					'<span class="cat-links">%1$s<span class="screen-reader-text">%2$s</span>%3$s</span>',
					varya_get_icon_svg( 'category', 16 ),
					__( 'Posted in', 'varya' ),
					$categories_list
				); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma. */
			$tags_list = get_the_tag_list( '', __( ', ', 'varya' ) );
			if ( $tags_list ) {
				printf(
					/* translators: 1: SVG icon. 2: posted in label, only visible to screen readers. 3: list of tags. */
					'<span class="tags-links">%1$s<span class="screen-reader-text">%2$s</span>%3$s</span>',
					varya_get_icon_svg( 'tag', 16 ),
					__( 'Tags:', 'varya' ),
					$tags_list
				); // WPCS: XSS OK.
			}
		}

		// Comment count.
		if ( ! is_singular() ) {
			varya_comment_count();
		}

		// Edit post link.
		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers. */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'varya' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">' . varya_get_icon_svg( 'edit', 16 ),
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'varya_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function varya_post_thumbnail() {
		if ( ! varya_can_show_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
		?>

			<figure class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</figure><!-- .post-thumbnail -->

		<?php
		else :
		?>

			<figure class="post-thumbnail">
				<a class="post-thumbnail-inner alignwide" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php the_post_thumbnail( 'post-thumbnail' ); ?>
				</a>
			</figure>

		<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'varya_comment_avatar' ) ) :
	/**
	 * Returns the HTML markup to generate a user avatar.
	 */
	function varya_get_user_avatar_markup( $id_or_email = null ) {

		if ( ! isset( $id_or_email ) ) {
			$id_or_email = get_current_user_id();
		}

		return sprintf( '<div class="comment-user-avatar comment-author vcard">%s</div>', get_avatar( $id_or_email, varya_get_avatar_size() ) );
	}
endif;

if ( ! function_exists( 'varya_the_posts_navigation' ) ) :
	/**
	 * Documentation for function.
	 */
	function varya_the_posts_navigation() {
		the_posts_pagination(
			array(
				'mid_size'  => 2,
				'prev_text' => sprintf(
					'%s <span class="nav-prev-text">%s</span>',
					varya_get_icon_svg( 'chevron_left', 22 ),
					__( 'Newer posts', 'varya' )
				),
				'next_text' => sprintf(
					'<span class="nav-next-text">%s</span> %s',
					__( 'Older posts', 'varya' ),
					varya_get_icon_svg( 'chevron_right', 22 )
				),
			)
		);
	}
endif;
