<?php
/**
 * The template for displaying Author info
 *
 * @package WordPress
 * @subpackage Varya
 * @since 1.0.0
 */

if ( (bool) get_the_author_meta( 'description' ) ) : ?>
<div class="author-bio">
	<?php
	printf(__( 'Published by', 'varya' ));
	?>
	<h2 class="author-title">
		<span class="author-heading">
			<?php
			printf(
				/* post author */
				esc_html( get_the_author() )
			);
			?>
		</span>
	</h2>
	<p class="author-description">
		<?php the_author_meta( 'description' ); ?></br>
		<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
			<?php _e( 'View more posts', 'varya' ); ?>
		</a>
	</p><!-- .author-description -->
</div><!-- .author-bio -->
<?php endif; ?>
