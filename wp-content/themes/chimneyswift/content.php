<?php
/**
 * @package ReMag
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="content-wrapper">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<div class="scroll-pane">
			<div class="entry-content">
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'remag' ) ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'remag' ), 'after' => '</div>' ) ); ?>
			</div>
		</div>
	</div><!-- .entry-content -->

</article><!-- #post-## -->