<?php

/*==================================== THEME SETUP ====================================*/

// Load default style.css and Javascripts
add_action('wp_enqueue_scripts', 'leeway_enqueue_scripts');

if ( ! function_exists( 'leeway_enqueue_scripts' ) ):
function leeway_enqueue_scripts() {

	// Get Theme Options from Database
	$theme_options = leeway_theme_options();
	
	// Register and Enqueue Stylesheet
	wp_enqueue_style('leeway-stylesheet', get_stylesheet_uri());
	
	// Register Genericons
	wp_enqueue_style('leeway-genericons', get_template_directory_uri() . '/css/genericons/genericons.css');

	// Register and enqueue navigation.js
	wp_enqueue_script('leeway-jquery-navigation', get_template_directory_uri() .'/js/navigation.js', array('jquery'));
		
	// Register and Enqueue FlexSlider JS and CSS if necessary
	if ( ( isset($theme_options['slider_active_blog']) and $theme_options['slider_active_blog'] == true )
		|| ( isset($theme_options['slider_active_magazine']) and $theme_options['slider_active_magazine'] == true ) ) :

		// FlexSlider CSS
		wp_enqueue_style('leeway-flexslider', get_template_directory_uri() . '/css/flexslider.css');

		// FlexSlider JS
		wp_enqueue_script('leeway-flexslider', get_template_directory_uri() .'/js/jquery.flexslider-min.js', array('jquery'));

		// Register and enqueue slider.js
		wp_enqueue_script('leeway-post-slider', get_template_directory_uri() .'/js/slider.js', array('leeway-flexslider'));

	endif;

	// Register and Enqueue Fonts
	wp_enqueue_style('leeway-default-fonts', leeway_google_fonts_url(), array(), null );

}
endif;

// Load comment-reply.js if comment form is loaded and threaded comments activated
add_action( 'comment_form_before', 'leeway_enqueue_comment_reply' );

function leeway_enqueue_comment_reply() {
	if( get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

// Retrieve Font URL to register default Google Fonts
function leeway_google_fonts_url() {
    $fonts_url = '';
	
	// Get Theme Options from Database
	$theme_options = leeway_theme_options();
	
	// Only embed Google Fonts if not deactivated
	if ( ! ( isset($theme_options['deactivate_google_fonts']) and $theme_options['deactivate_google_fonts'] == true ) ) :
		
		// Define Default Fonts
		$font_families = array('Muli:400,700', 'Oswald');
		
		// Set Google Font Query Args
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		
		// Create Fonts URL
		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
		
	endif;

    return apply_filters( 'leeway_google_fonts_url', $fonts_url );
}


// Setup Function: Registers support for various WordPress features
add_action( 'after_setup_theme', 'leeway_setup' );

if ( ! function_exists( 'leeway_setup' ) ):
function leeway_setup() {

	// Set Content Width
	global $content_width;
	if ( ! isset( $content_width ) )
		$content_width = 860;
	
	// init Localization
	load_theme_textdomain('leeway', get_template_directory() . '/languages' );

	// Add Theme Support
	add_theme_support('automatic-feed-links');
	add_theme_support('title-tag');
	add_editor_style();
	
	// Add Post Thumbnails
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size( 400, 280, true );
	
	// Add Custom Background
	add_theme_support('custom-background', array('default-color' => 'e5e5e5'));

	// Add Custom Header
	add_theme_support('custom-header', array(
		'header-text' => false,
		'width'	=> 1320,
		'height' => 250,
		'flex-height' => true));
		
	// Add Theme Support for Leeway Pro Plugin
	add_theme_support( 'leeway-pro' );

	// Register Navigation Menus
	register_nav_menu( 'primary', __('Main Navigation', 'leeway') );
	register_nav_menu( 'secondary', __('Top Navigation', 'leeway') );
	register_nav_menu( 'footer', __('Footer Navigation', 'leeway') );
	
	// Register Social Icons Menu
	register_nav_menu( 'social', __('Social Icons', 'leeway') );

}
endif;


// Add custom Image Sizes
add_action( 'after_setup_theme', 'leeway_add_image_sizes' );

if ( ! function_exists( 'leeway_add_image_sizes' ) ):
function leeway_add_image_sizes() {
	
	// Add Custom Header Image Size
	add_image_size( 'leeway-header-image', 1320, 250, true);
	
	// Add Slider Image Size
	add_image_size( 'leeway-slider-image', 1320, 380, true);
	
	// Add Category Post Widget image sizes
	add_image_size( 'leeway-category-posts-widget-small', 140, 90, true);
	add_image_size( 'leeway-category-posts-widget-medium', 300, 175, true);
	add_image_size( 'leeway-category-posts-widget-large', 600, 280, true);
	add_image_size( 'leeway-category-posts-widget-extra-large', 600, 350, true);
	
}
endif;


// Register Sidebars
add_action( 'widgets_init', 'leeway_register_sidebars' );

if ( ! function_exists( 'leeway_register_sidebars' ) ):
function leeway_register_sidebars() {

	// Register Sidebars
	register_sidebar( array(
		'name' => __( 'Sidebar', 'leeway' ),
		'id' => 'sidebar',
		'description' => __( 'Appears on posts and pages except Magazine Homepage and Fullwidth template.', 'leeway' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widgettitle"><span>',
		'after_title' => '</span></h3>',
	));
	register_sidebar( array(
		'name' => __( 'Magazine Homepage', 'leeway' ),
		'id' => 'magazine-homepage',
		'description' => __( 'Appears on Magazine Homepage template only. You can use the Category Posts widgets here.', 'leeway' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widgettitle"><span>',
		'after_title' => '</span></h3>',
	));

}
endif;


// Add title tag for older WordPress versions
if ( ! function_exists( '_wp_render_title_tag' ) ) :

	add_action( 'wp_head', 'leeway_wp_title' );
	function leeway_wp_title() { ?>
		
		<title><?php wp_title( '|', true, 'right' ); ?></title>

<?php
    }
    
endif;


// Add Default Menu Fallback Function
function leeway_default_menu() {
	echo '<ul id="mainnav-menu" class="menu">'. wp_list_pages('title_li=&echo=0') .'</ul>';
}


// Get Featured Posts
function leeway_get_featured_content() {
	return apply_filters( 'leeway_get_featured_content', false );
}


// Change Excerpt Length
add_filter('excerpt_length', 'leeway_excerpt_length');
function leeway_excerpt_length($length) {
    return 60;
}


// Slideshow Excerpt Length
function leeway_slideshow_excerpt_length($length) {
    return 32;
}

// Category Posts Large Excerpt Length
function leeway_category_posts_large_excerpt($length) {
    return 32;
}

// Category Posts Medium Excerpt Length
function leeway_category_posts_medium_excerpt($length) {
    return 20;
}

// Category Posts Small Excerpt Length
function leeway_category_posts_small_excerpt($length) {
    return 8;
}


// Custom Template for comments and pingbacks.
if ( ! function_exists( 'leeway_list_comments' ) ):
function leeway_list_comments($comment, $args, $depth) {

	$GLOBALS['comment'] = $comment;

	if( $comment->comment_type == 'pingback' or $comment->comment_type == 'trackback' ) : ?>

		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
			<p><?php _e( 'Pingback:', 'leeway' ); ?> <?php comment_author_link(); ?>
			<?php edit_comment_link( __( '(Edit)', 'leeway' ), '<span class="edit-link">', '</span>' ); ?>
			</p>

	<?php else : ?>

		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">

			<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">

				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 56 ); ?>
					<?php printf( '<span class="fn">%s</span>', get_comment_author_link() ); ?>
				</div>

		<?php if ($comment->comment_approved == '0') : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'leeway' ); ?></p>
		<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><?php printf(__('%1$s at %2$s', 'leeway'), get_comment_date(),  get_comment_time()) ?></a>
					<?php edit_comment_link(__('(Edit)', 'leeway'),'  ','') ?>
				</div>

				<div class="comment-content"><?php comment_text(); ?></div>

				<div class="reply">
					<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</div>

			</div>
<?php
	endif;

}
endif;


/*==================================== INCLUDE FILES ====================================*/

// include Theme Info page
require( get_template_directory() . '/inc/theme-info.php' );

// include Theme Customizer Options
require( get_template_directory() . '/inc/customizer/customizer.php' );
require( get_template_directory() . '/inc/customizer/default-options.php' );

// include Customization Files
require( get_template_directory() . '/inc/customizer/frontend/custom-layout.php' );
require( get_template_directory() . '/inc/customizer/frontend/custom-slider.php' );

// include Template Functions
require( get_template_directory() . '/inc/template-tags.php' );

// include Widget Files
require( get_template_directory() . '/inc/widgets/widget-category-posts-boxed.php' );
require( get_template_directory() . '/inc/widgets/widget-category-posts-columns.php' );
require( get_template_directory() . '/inc/widgets/widget-category-posts-grid.php' );

// Include Featured Content class
require( get_template_directory() . '/inc/featured-content.php' );

?>