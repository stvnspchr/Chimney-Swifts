<?php
/*
 * Template Name: Registration
 *
 * This is the template that displays the account regisration page for new users.
 *
 */

get_header(); ?>


	<?php if ( have_posts('order=DESC') ) : ?>
	<?php
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		if ( 1 == $paged ) {
	?>
	<?php } ?>
	<?php /* Start the Loop */ ?>
	<?php while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?> registration" <?php post_class(); ?>>
			<div class="content-wrapper">
				<h1 class="entry-title"><?php the_title(); ?></h1>

				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
			</div>
		</article><!-- #post-## -->

	<?php endwhile; ?>

	<?php else : ?>

		<?php get_template_part( 'no-results', 'archive' ); ?>

	<?php endif; ?>

<?php get_footer(); ?>
