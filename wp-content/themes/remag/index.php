<?php
/**
 * The main template file.
 *
 * @package ReMag
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php
				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				if ( 1 == $paged ) {
			?>

			<article id="masthead" class="site-header" role="banner" <?php rm_header_image(); ?>>
				<div>
					<hgroup>
						<h1 class="site-title">
							<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
						    	<?php if ( isset( $theme_options['logo'] ) && '' != $theme_options['logo'] ) : ?>
						    	<img class="sitetitle" src="<?php echo esc_url( $theme_options['logo'] ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
						    	<?php else : ?>
						    		<?php bloginfo( 'name' ); ?>
						    	<?php endif; ?>
					    	</a>
					    </h1>
						<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
					</hgroup>
					<footer id="colophon" class="site-footer" role="contentinfo">
						<nav id="site-navigation" class="navigation-main" role="navigation">
							<h1 class="menu-toggle"><?php _e( 'Menu', 'remag' ); ?></h1>
							<div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'remag' ); ?>"><?php _e( 'Skip to content', 'remag' ); ?></a></div>

							<?php wp_nav_menu( array( 'theme_location' => 'primary', 'depth' => 1 ) ); ?>
						</nav><!-- #site-navigation -->

						<div class="site-info">
							<?php do_action( 'rm_credits' ); ?>
							<?php _e( 'Proudly powered by', 'remag' ); ?> <a href="http://wordpress.org/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'remag' ); ?>" rel="generator"><?php _e( 'WordPress', 'remag' ); ?></a>.
							<?php printf( __( 'Theme: %1$s by %2$s.', 'remag' ), '<a href="http://graphpaperpress.com/themes/remag/" rel="theme">ReMag</a>', '<a href="http://graphpaperpress.com" rel="designer">Graph Paper Press</a>' ); ?>
						</div><!-- .site-info -->
					</footer><!-- #colophon -->
				</div>
			</article><!-- #masthead -->
		<?php } ?>

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to overload this in a child theme then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				?>

			<?php endwhile; ?>

		<?php else : ?>

			<?php get_template_part( 'no-results', 'index' ); ?>

		<?php endif; ?>

		<a class="slidesjs-previous slidesjs-navigation left-move" href="#"></a>
		<a class="slidesjs-next slidesjs-navigation right-move" href="#"></a>

		</div><!-- #content -->

		<?php rm_content_custom_nav( 'nav-below' ); ?>
	</div><!-- #primary -->

<?php get_footer(); ?>