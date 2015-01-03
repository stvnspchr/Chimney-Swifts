<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ReMag
 */

if ( ! function_exists( 'rm_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function rm_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'navigation-post' : 'navigation-paging';

	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'remag' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'remag' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'remag' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'remag' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'remag' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif; // rm_content_nav

if ( ! function_exists( 'rm_content_custom_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function rm_content_custom_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	// if ( is_single() ) {
	// 	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	// 	$next = get_adjacent_post( false, '', false );

	// 	if ( ! $next && ! $previous )
	// 		return;
	// }

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'navigation-post' : 'navigation-paging';

	?>
	<?php if(is_attachment()): //if attachment ?>
		<?php previous_image_link( false, '&nbsp;' ); ?>
		<?php next_image_link( false, '&nbsp;' ); ?>
	<?php elseif ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '%link', '' ); ?>
		<?php next_post_link( '%link', '' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<?php next_posts_link( __( '', 'remag' ) ); echo "<span class='nextblock'>Next Page</span>"; ?>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<?php previous_posts_link( __( '', 'remag' ) ); echo "<span class='prevblock'>Prev Page</span>"; ?>
		<?php endif; ?>

	<?php endif; ?>

	<?php
}
endif; // rm_content_custom_nav




if ( ! function_exists( 'rm_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function rm_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'remag' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'remag' ), '<span class="edit-link">', '<span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer>
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 80 ); ?>
					<?php printf( __( '%s <span class="says">says:</span>', 'remag' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'remag' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time datetime="<?php comment_time( 'c' ); ?>">
					<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'remag' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<?php edit_comment_link( __( 'Edit', 'remag' ), '<span class="edit-link">', '<span>' ); ?>
				</div><!-- .comment-meta .commentmetadata -->
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for rm_comment()

if ( ! function_exists( 'rm_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function rm_posted_on() {
	printf( __( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="byline"> by <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'remag' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'remag' ), get_the_author() ) ),
		get_the_author()
	);
}
endif;
/**
 * Returns true if a blog has more than 1 category
 */
function rm_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so rm_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so rm_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in rm_categorized_blog
 */
function rm_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'rm_category_transient_flusher' );
add_action( 'save_post', 'rm_category_transient_flusher' );

/**
 * Header image styling
 *
 * @since ReMag 1.0
 */
function rm_header_image() {
	$header_image = get_header_image();

	if ( ! empty( $header_image ) ) {
		echo 'style="background-image:url(' . $header_image . ');"';
	}
}

/**
 * Sets and tweaks the background image for the post
 *
 * @since ReMag 1.0
 */
function rm_featured_background( $post = NULL ) {
	$bgimg = "";
	//$meta = get_post_format_meta( $post );
	//$attchid = img_html_to_post_id( $meta['image'] );
	//$imgdetail = wp_get_attachment_image_src( $attchid, "large" );
	$attchid = get_post_thumbnail_id( $post );
	$imgdetail = wp_get_attachment_image_src( $attchid, "large" );
	//print_r($imgdetail);
	// first, check for featured image and set to background for post
	if( "" != $imgdetail[0] ) {
		$bgimg = $imgdetail[0];
	} elseif ( has_post_thumbnail( $post ) ) {
		// get the featured image source
		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post ), 'large' );
		$bgimg = $featured_image[0];
	}
	if ( "" != $bgimg ) {
		echo 'style="background-image: url(' . esc_url( $bgimg ) . '); background-repeat: no-repeat; background-attachment: scroll; background-position: center center; background-size: cover;' . '"';
	}

}

/**
 * Get theme version number from WP_Theme object (cached)
 *
 * @since ReMag 1.0
*/
function rm_get_theme_version() {
	$rm_theme_file = get_template_directory() . '/style.css';
	$rm_theme = new WP_Theme( basename( dirname( $rm_theme_file ) ), dirname( dirname( $rm_theme_file ) ) );
	return $rm_theme->get( 'Version' );
}