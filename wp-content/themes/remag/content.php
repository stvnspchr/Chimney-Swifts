<?php
/**
 * @package ReMag
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="content-wrapper">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'remag' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">
				<?php rm_posted_on(); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
		<div class="scroll-pane">
			<div class="entry-content">
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'remag' ) ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'remag' ), 'after' => '</div>' ) ); ?>
			</div>
		</div>
	</div><!-- .entry-content -->

</article><!-- #post-## -->