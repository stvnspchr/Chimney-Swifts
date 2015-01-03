<?php
/**
 * @package ReMag
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="video-wrapper">

		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-media">
			<?php //the_post_format_video(); ?>

			<?php
				$post_meta = get_post_custom( $post->ID );
				$i = 0;
				$ovideo = "";
				foreach( $post_meta as $meta=>$value ) {
					if( '_oembed' != substr( trim( $meta ) , 0 , 7 ) ) {
						continue;
					}
					if( $i == 0 ) {
						$ovideo = $value[0];
						$i++;
					}
				}
				if( '' != $ovideo ) {
					echo '<div class="video-container">' . $ovideo . '</div>';
				} else {
					the_post_thumbnail( "large" );
				}
			?>
		</div><!-- .entry-media -->
		<div class="entry-content">

			<div class="entry-header">
				<h1 class="entry-title">
					<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'remag' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
					
					</a>
				</h1>
			</div><!-- .entry-header -->
		</div><!-- .entry-content -->
		<?php endif; ?>

	</div>

</article><!-- #post-## -->
