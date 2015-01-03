<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package ReMag
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="content-wrapper">
		<h1 class="entry-title"><?php the_title(); ?></h1>

		<!-- <div class="scroll-pane"> -->
			<div class="entry-content">
				<?php the_content(); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'remag' ), 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->
			<?php edit_post_link( __( 'Edit', 'remag' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>

		<!-- </div> -->
	</div>
	
	<div id="hover-topmenu">
		<div class="menuwrapper">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'depth' => 1, 'menu_class' => 'topmenu-wrapper menu', 'fallback_cb' => 'wp_page_menu' ) ); ?>

			<?php if ( is_active_sidebar( 'below-menu' ) ) : ?>
	            <aside id="widget-1" class="widget-1">
	                <?php dynamic_sidebar( 'below-menu' ); ?>
	            </aside>
	        <?php endif; ?>
	    </div>
	</div>
</article><!-- #post-## -->
