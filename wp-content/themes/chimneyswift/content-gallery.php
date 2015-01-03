<?php
/**
 * @package ReMag
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php rm_featured_background( get_the_ID() ); ?>>

	<div class="entry-content">
		<header class="entry-header">
			<div class="header-wrap">
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php if ( 'post' == get_post_type() ) : ?>
				<div class="entry-meta">
					<?php //rm_posted_on(); ?>
				</div><!-- .entry-meta -->
				<?php endif; ?>
				<div class="gallery-excerpt">
					<?php the_excerpt(); ?>
				</div>
			</div>
		</header>

	</div><!-- .entry-content -->
	<div class="entry-media">
		<?php 
			$post_subtitrare = get_post( $post->ID );
            $content = $post_subtitrare->post_content;
            $pattern = get_shortcode_regex();
            preg_match( "/$pattern/s", $content, $match );


			if ( is_array( $match ) && $match[2] == 'gallery' ) {
			$atts = shortcode_parse_atts( $match[3] );

			if ( is_array( $atts ) && $atts['ids'] ) {
				$photos = explode( ',', $atts['ids'] );
			} else {
				$photos = get_children( array( 'post_parent' => $post->ID, 'post_type'   => 'image' ) );
			}
				$imgcnt =  count( $photos );
			}
		?>
		<?php if( $imgcnt > 9 ) { ?>
		<div class="scroll-pane">
		<?php } ?>
			<?php
	            if( isset( $match[2] ) && ( 'gallery' == $match[2] ) ) {
	                $gallery_shortcode = '[gallery ' . $match[3] . ' size="thumbnail"]';
	                echo apply_filters( 'get_the_content', do_shortcode( $gallery_shortcode ) );
	            }
	        ?>
	    <?php if( $imgcnt > 9 ) { ?>
		</div>
		<?php } ?>
	</div>
</article><!-- #post-## -->