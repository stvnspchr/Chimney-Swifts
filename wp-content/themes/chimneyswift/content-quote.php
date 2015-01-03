<?php
/**
 * @package ReMag
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<div class="scroll-pane">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'remag' ) ); ?>
		</div><!-- .entry-content -->
	</div>
</article><!-- #post-## -->
