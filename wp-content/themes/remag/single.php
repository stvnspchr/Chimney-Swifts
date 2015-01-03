<?php
/**
 * The Template for displaying all single posts.
 *
 * @package ReMag
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

		<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->

		<?php rm_content_custom_nav( 'nav-below' ); ?>
	</div><!-- #primary -->
	<?php
		// If comments are open or we have at least one comment, load up the comment template
		if ( comments_open() || '0' != get_comments_number() )
			comments_template();
	?>
<?php get_footer(); ?>