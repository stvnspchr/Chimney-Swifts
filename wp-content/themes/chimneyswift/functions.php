<?php
/**
 * ReMag functions and definitions
 *
 * @package ReMag
 * @since ReMag 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since ReMag 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 1100; /* pixels */

/**
 * Theme options
 */
if ( file_exists( get_template_directory() . '/options/options.php' ) )
	require( get_template_directory() . '/options/options.php' );
if ( file_exists( get_template_directory() . '/options/options.php' ) && file_exists( get_template_directory() . '/theme-options.php' ) )
	require( get_template_directory() . '/theme-options.php' );

/**
 * Set the theme option variable for use throughout theme.
 *
 * @since albedo 1.0
 */
if ( ! isset( $theme_options ) )
	$theme_options = get_option( gpp_get_current_theme_id() . '_options' );
global $theme_options;

/*
 * Load Jetpack compatibility file.
 */
require( get_template_directory() . '/inc/jetpack.php' );

if ( ! function_exists( 'remag_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since ReMag 1.0
 */
function remag_setup() {

	// updating thumbnail and image sizes 
	update_option( 'thumbnail_size_w', 300, true );
	update_option( 'thumbnail_size_h', 300, true );
	update_option( 'medium_size_w', 500, true );
	update_option( 'medium_size_h', 500, true );
	update_option( 'large_size_w', 1100, true );
	update_option( 'large_size_h', 1100, true ); 

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/extras.php' );

	/**
	 * WordPress.com-specific functions and definitions
	 */
	//require( get_template_directory() . '/inc/wpcom.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 */
	load_theme_textdomain( 'remag', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'remag' ),
		'enter' => 'Entry Menu',
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'image', 'video', 'quote', 'gallery' ) );
}
endif; // remag_setup
add_action( 'after_setup_theme', 'remag_setup' );

/**
 * Setup the WordPress core custom background feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for WordPress 3.3
 * using feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @todo Remove the 3.3 support when WordPress 3.6 is released.
 *
 * Hooks into the after_setup_theme action.
 */
function remag_register_custom_background() {
	$args = array(
		'default-color' => '000000',
		'default-image' => '',
	);

	$args = apply_filters( 'remag_custom_background_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-background', $args );
	} else {
		define( 'BACKGROUND_COLOR', $args['default-color'] );
		if ( ! empty( $args['default-image'] ) )
			define( 'BACKGROUND_IMAGE', $args['default-image'] );
		add_custom_background();
	}
}
add_action( 'after_setup_theme', 'remag_register_custom_background' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since ReMag 1.0
 */
function remag_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'remag' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );

	register_sidebar(array(
		'name' => __( 'Below Menu', 'gpp' ),
		'id' => 'below-menu',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>'
	) );

}
add_action( 'widgets_init', 'remag_widgets_init' );



/**
 * Enqueue scripts and styles
 */
function remag_scripts() {
	wp_enqueue_style( 'style', get_stylesheet_uri(), '', rm_get_theme_version() );

	wp_enqueue_style( 'css', get_template_directory_uri() . '/js/jquery.mCustomScrollbar.css', '', rm_get_theme_version() );

	wp_enqueue_script( 'colors', get_template_directory_uri() . '/js/jquery.color-2.1.2.js', array( 'jquery' ), rm_get_theme_version() );

	wp_enqueue_script( 'mousewheel', get_template_directory_uri() . '/js/jquery.mousewheel.min.js', array( 'jquery' ), rm_get_theme_version() );
	wp_enqueue_script( 'scrollpane', get_template_directory_uri() . '/js/jquery.mCustomScrollbar.min.js', array( 'jquery' ), rm_get_theme_version() );
	wp_enqueue_script( 'jpanelmenu', get_template_directory_uri() . '/js/jquery.jpanelmenu.min.js', array( 'jquery' ), rm_get_theme_version() );
	wp_enqueue_script( 'lightbox', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), rm_get_theme_version() );
	wp_enqueue_script( 'main', get_template_directory_uri() . '/js/jquery.main.js', array( 'jquery' ), rm_get_theme_version() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), rm_get_theme_version() );
	}
}
add_action( 'wp_enqueue_scripts', 'remag_scripts' );

/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );


/**
 * Add custom class to next and previous posts links
 */
add_filter( 'next_posts_link_attributes', 'posts_link_attributes_next' );
add_filter( 'previous_posts_link_attributes', 'posts_link_attributes_prev' );

function posts_link_attributes_next() {
    return 'class="right-move next-page"';
}
function posts_link_attributes_prev() {
    return 'class="left-move prev-page"';
}

function add_class_next_post_link($html){
    $html = str_replace( '<a', '<a class="right-move next-page"', $html );
    return $html;
}
add_filter( 'next_post_link', 'add_class_next_post_link', 10, 1 );
add_filter( 'next_image_link', 'add_class_next_post_link', 10, 1 );

function add_class_previous_post_link( $html ) {
    $html = str_replace( '<a', '<a class="left-move prev-page"', $html );
    return $html;
}
add_filter( 'previous_post_link', 'add_class_previous_post_link', 10, 1 );
add_filter( 'previous_image_link', 'add_class_previous_post_link', 10, 1 );

/**
 * Post Format CSS
 */
function gpp_post_format_css() {

    $theme_options = get_option( gpp_get_current_theme_id() . '_options' );
        echo '<!-- BeginHeader --><style type="text/css">';
        echo '.format-standard { background: '. $theme_options['standard'] . '}';
        echo '.format-image { background: '. $theme_options['image'] . '}';
        echo '.format-video { background: '. $theme_options['video'] . '}';
        echo '.format-quote, blockquote { background: '. $theme_options['quote'] . '}';
        echo '.format-gallery { background: '. $theme_options['gallery'] . '}';
        echo '</style><!-- EndHeader -->';

}

add_action( 'wp_head', 'gpp_post_format_css', 12);

/**
 * Content toggle
 */

function gpp_content_toggle_script() {
	global $theme_options;
	$bg = hex2rgb( $theme_options['image'] );
	$doc_ready_script = '
		<script type="text/javascript">
			jQuery(document).ready(function(){
				/**
			     * toggle content effect
			     */
			    jQuery(document).on("click", ".movedown", function(){
			        jQuery(this).addClass("moveup").removeClass("movedown");
			        var _entryheader = jQuery(this).parents("article").find(".entry-header");
			        var headerpos = _entryheader.position();
			        var headerheight = _entryheader.outerHeight();

			        _entryheader.animate({
			            bottom: headerpos.top
			        }, 400);
			        jQuery(this).parents("article").find(".entry-main-content").animate({
			            top: (headerheight + 40)
			        }, 550);
			        if ( !jQuery(this).parents("article").hasClass("portrait-image")) {
			            jQuery(this).parents("article").find(".entry-content").animate({
			                backgroundColor: "rgba(' . $bg[0] . ',' . $bg[1] .',' . $bg[2] .', .8)"
			            }, 500);
			        }

			    });

			    jQuery(document).on("click", ".moveup", function(){
			        $this = jQuery(this);
			        $posttype = $this.parents("article");

			        jQuery(this).addClass("movedown").removeClass("moveup");
			        var headerpos = jQuery(this).parents("article").find(".entry-header").position();
			        jQuery(this).parents("article").find(".entry-header").animate({
			            bottom: headerpos.top
			        }, 550);
			        jQuery(this).parents("article").find(".entry-main-content").animate({
			            top: "100%"
			        }, 400);
			        jQuery(this).parents(".entry-content").animate({
			            backgroundColor: "rgba(' . $bg[0] . ',' . $bg[1] .',' . $bg[2] .', 0)"
			        }, 500);
			    });';


				$doc_ready_script .= '
					});
				</script>';
			echo $doc_ready_script;

}
add_action( 'wp_head', 'gpp_content_toggle_script', 12 );

/**
 * convert hex to rgb
 * @param  $hex
 * @return array
 */
function hex2rgb($hex) {
   $hex = str_replace( "#", "", $hex );

   if( strlen( $hex ) == 3 ) {
      $r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
      $g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
      $b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
   } else {
      $r = hexdec( substr( $hex, 0, 2 ) );
      $g = hexdec( substr( $hex, 2, 2 ) );
      $b = hexdec( substr( $hex, 4, 2 ) );
   }
   $rgb = array( $r, $g, $b );
   return $rgb; // returns an array with the rgb values
}


/**
 * Change 'Posts' post type to 'Slides'
 */
function revcon_change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Slides';
    $submenu['edit.php'][5][0] = 'Slides';
    $submenu['edit.php'][10][0] = 'Add Slide';
    $submenu['edit.php'][16][0] = 'Slide Tags';
    echo '';
}
function revcon_change_post_object() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Slide';
    $labels->singular_name = 'Slide';
    $labels->add_new = 'Add Slide';
    $labels->add_new_item = 'Add Slide';
    $labels->edit_item = 'Edit Slide';
    $labels->new_item = 'Slide';
    $labels->view_item = 'View Slide';
    $labels->search_items = 'Search Slide';
    $labels->not_found = 'No Slides found';
    $labels->not_found_in_trash = 'No Slides found in Trash';
    $labels->all_items = 'All Slides';
    $labels->menu_name = 'Slides';
    $labels->name_admin_bar = 'Slide';
}
 
add_action( 'admin_menu', 'revcon_change_post_label' );
add_action( 'init', 'revcon_change_post_object' );
