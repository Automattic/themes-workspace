<?php
/**
 * The only template for our theme
 *
 * This will be ignored for block-based themes, 
 * but it exists just in case that gets turned off by accident.
 *
 * @package blockbase
 */
?>
<!doctype html>
<html>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<main id="primary" class="site-main">

	<?php
	if ( have_posts() ) :

		/* Start the Loop */
		while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content">

					<?php the_content(); ?>

				</div><!-- .entry-content -->
			</article><!-- #post-<?php the_ID(); ?> -->

		<?php endwhile;

	endif; ?>

	</main><!-- #primary -->
</div><!-- #page -->
</body>
</html>