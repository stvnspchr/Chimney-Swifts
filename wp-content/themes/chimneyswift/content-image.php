<?php
/**
 * @package ReMag
 */
?>
<?php
	global $post;
	//$meta = get_post_format_meta( $post->ID );
	//$attchid = img_html_to_post_id( $meta['image'] );
	$attchid = get_post_thumbnail_id( $post->ID );
	$imgdetail = wp_get_attachment_image_src( $attchid, "large" );
	//print_r($imgdetail);
	if( $imgdetail[2] > $imgdetail[1] ) {
		$imglayout = "portrait-image";
	} else {
		$imglayout = "landscape-image";

	}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $imglayout ); ?>>

	<?php if ( in_category( 'portfolio' ) ) { ?>
	
		
		<?php if( $imglayout == "landscape-image" ) { ?>
			<div class="wrapdiv">
		<?php } ?>
			<div class="entry-media" <?php rm_featured_background( get_the_ID() ); ?>></div><!-- .entry-media -->
		
			<div class="caption-box">	
				<div class="entry-caption">
					<?php the_content(); ?>
				</div><!-- .entry-caption -->
			</div><!-- .caption-box -->	
		
		<?php if( $imglayout == "landscape-image" ) { ?>
			</div>
		<?php } ?>		
		

	<?php } else { ?>

		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
		<?php else : ?>
			<?php if( $imglayout == "landscape-image" ) { ?>
				<div class="wrapdiv">
			<?php } ?>
				<div class="entry-media" <?php rm_featured_background( get_the_ID() ); ?>></div><!-- .entry-media -->
				<div class="entry-content">
					<div class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
						<span class="show-more movedown"></span>
					</div><!-- .entry-header -->
					<div class="entry-main-content">

						<div class="scroll-pane">
							<div class="entry-remaining-content">
								<?php if ( 'post' == get_post_type() ) : ?>
								<?php endif; ?>
								<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'remag' ) ); ?>
								<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'remag' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
							</div>
						</div>
					</div>
				</div><!-- .entry-content -->
			<?php if( $imglayout == "landscape-image" ) { ?>
				</div>
			<?php } ?>
		<?php endif; ?>

	<?php } ?>


</article><!-- #post-## -->
