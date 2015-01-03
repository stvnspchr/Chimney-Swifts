<?php
/**
 * The template for displaying Story Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package ReMag
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<?php if ( have_posts('order=DESC') ) : ?>
			<?php
				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				if ( 1 == $paged ) {
			?>
			<?php } ?>
			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to overload this in a child theme then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				?>

			<?php endwhile; ?>

			

		<?php else : ?>

			<?php get_template_part( 'no-results', 'archive' ); ?>

		<?php endif; ?>
		<a class="slidesjs-previous slidesjs-navigation left-move" href="#"></a>
		<a class="slidesjs-next slidesjs-navigation right-move" href="#"></a>

		</div><!-- #content -->
		<?php rm_content_custom_nav( 'nav-below' ); ?>
	</section><!-- #primary -->
<?php get_footer(); ?>