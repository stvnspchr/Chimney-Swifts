<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package ReMag
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title>
	<?php 
		/*
		 * Print the <title> tag based on what is being viewed.
		 */
		global  $theme_options;
		wp_title( '|', true, 'right' ); 
	?>
</title>
<?php if ( isset( $theme_options['favicon'] ) && '' != $theme_options['favicon'] ) : ?>
	<link rel="shortcut icon" href="<?php echo esc_url( $theme_options['favicon'] ); ?>" />
<?php endif; ?>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<div id="topmenu">
		<span id="togtopmenu" class="showmenu"></span>
		<div class="menuwrapper">
			<h1 class="site-title">
				<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			    	<?php if ( isset( $theme_options['logo'] ) && '' != $theme_options['logo'] ) : ?>
			    	<img class="sitetitle" src="<?php echo esc_url( $theme_options['logo'] ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
			    	<?php else : ?>
			    		<?php bloginfo( 'name' ); ?>
			    	<?php endif; ?>
		    	</a>
		    </h1>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'depth' => 1, 'menu_class' => 'topmenu-wrapper menu', 'fallback_cb' => 'wp_page_menu' ) ); ?>

			<?php if ( is_active_sidebar( 'below-menu' ) ) : ?>
	            <aside id="widget-1" class="widget-1">
	                <?php dynamic_sidebar( 'below-menu' ); ?>
	            </aside>
	        <?php endif; ?>
	    </div>
	</div>
	<?php do_action( 'before' ); ?>