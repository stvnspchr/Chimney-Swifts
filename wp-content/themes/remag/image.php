<?php
/**
 * The template for displaying image attachments.
 *
 * @package ReMag
 */

get_header();
?>

	<div id="primary" class="content-area image-attachment">
		<div id="content" class="site-content" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="wrapdiv">
					<div class="entry-media" <?php rm_featured_background( get_the_ID() ); ?>></div><!-- .entry-media -->
					<div class="entry-content">
							<h1 class="entry-title"><?php the_title(); ?></h1>

						<?php the_content(); ?>
						<?php //wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'remag' ), 'after' => '</div>' ) ); ?>

					</div><!-- .entry-content -->
				</div>
			</article><!-- #post-<?php the_ID(); ?> -->

		<?php endwhile; // end of the loop. ?>
		</div><!-- #content -->
		<?php rm_content_custom_nav( 'nav-below' ); ?>
	</div><!-- #primary -->

<?php get_footer(); ?>