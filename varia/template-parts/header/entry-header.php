<?php
/**
 * Displays the post header
 *
 * @package WordPress
 * @subpackage variatheme
 * @since 1.0.0
 */
?>

<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

<?php if ( ! is_page() ) : ?>
<div class="entry-meta">
	<?php variatheme_entry_footer(); ?>
</div><!-- .meta-info -->
<?php endif; ?>
