<?php
/**
 * The main template file.
 *
 * @package ReMag
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">


			<article id="masthead" class="site-header" role="banner" <?php rm_header_image(); ?>>
				<div id="site-head">
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

							<?php wp_nav_menu( array( 'theme_location' => 'enter', 'depth' => 1 ) ); ?>
						</nav><!-- #site-navigation -->
					</footer><!-- #colophon -->
				</div>
			</article><!-- #masthead -->


		</div><!-- #content -->

		<?php rm_content_custom_nav( 'nav-below' ); ?>
	</div><!-- #primary -->

<?php get_footer(); ?>