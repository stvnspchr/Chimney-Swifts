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

<?php get_footer(); ?>