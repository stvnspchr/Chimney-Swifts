<?php
/*
 * Template Name: Notes
 *
 */

get_header(); ?>

	<?php /* Start the Loop for Page */ ?>
	<?php while ( have_posts() ) : the_post(); ?>

		<article id="note-container" <?php post_class(); ?>>

			<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<div class="content-wrapper">
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<?php the_content(); ?>
				</div>
			</section>
	<?php
    	endwhile; //resetting the page loop
    	wp_reset_query(); //resetting the page query
    ?>	

	<?php /* Start the Loop for Note Post Types */ ?>
	<?php
	  	query_posts( array( 'post_type' => 'note' ) );
	  	if ( have_posts() ) : while ( have_posts() ) : the_post();
	?>
				<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="note-title-wrapper">
						<h1 class="note-title"><?php the_title(); ?></h1>
					</div>
					
					<div class="content-wrapper">
						

						<div class="note-content">
							<?php the_content(); ?>
						</div><!-- .note-content -->

						<div class="note-meta">
							<h5>Posted by <?php the_author_meta('first_name'); ?></h5>
							<h5><?php the_author_meta('last_name'); ?></h5>
							<h5>in <?php the_author_meta('city'); ?>,</h5>
							<h5><?php the_author_meta('state'); ?></h5>
							<h5>on <?php the_time('F j, Y'); ?></h5>
						</div>

						<?php edit_post_link( __( 'Edit Note', 'remag' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>
					</div>
				</section><!-- #post-## -->
			
	<?php endwhile; endif; ?>
		</article>

		

<?php get_footer(); ?>