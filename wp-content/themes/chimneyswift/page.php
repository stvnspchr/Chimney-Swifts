<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package ReMag
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

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="content-wrapper">
				<h1 class="entry-title"><?php the_title(); ?></h1>

				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->

				<?php edit_post_link( __( 'Edit', 'remag' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>

			</div>
		</article><!-- #post-## -->

	<?php endwhile; ?>

	<?php else : ?>

		<?php get_template_part( 'no-results', 'archive' ); ?>

	<?php endif; ?>

<?php get_footer(); ?>
