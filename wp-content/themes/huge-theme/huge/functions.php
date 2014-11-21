<?php

/*---------------------------------
	Setup OptionTree
------------------------------------*/

add_filter( 'ot_show_pages', '__return_false' );
add_filter( 'ot_theme_mode', '__return_true' );
require_once( 'option-tree/ot-loader.php' );

function filter_ot_upload_text(){
	return __( 'Insert', 'krown' );
}
function filter_ot_header_list(){
	echo '<li id="option-tree-version"><span>' . __( 'Huge Options', 'krown' ) . '</span></li>';
}
function filter_ot_header_version_text(){
	return '1.5.8';
}
function filter_ot_header_logo_link(){
	return '';
}

add_filter( 'ot_header_list', 'filter_ot_header_list' );
add_filter( 'ot_upload_text', 'filter_ot_upload_text' );
add_filter( 'ot_header_logo_link', 'filter_ot_header_logo_link' );
add_filter( 'ot_header_version_text', 'filter_ot_header_version_text');

/*---------------------------------
	Include other files
------------------------------------*/

function add_krown_customizer() {
    do_action( 'add_krown_customizer' );
}

include( 'includes/extend-ot.php' );
include( 'includes/theme-options.php' );
include( 'includes/customizer-options.php' );
include( 'includes/custom-styles.php' );
include( 'includes/metaboxes.php' );
include( 'includes/plugins.php' );
include( 'includes/portfolio-functions.php' );

if ( ! function_exists( 'aq_resize' ) ) {
	include( 'includes/aq_resizer.php' );
}

/*---------------------------------
	Enable SVG upload
------------------------------------*/

function krown_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'krown_mime_types' );

/*---------------------------------
	Retina info (by js cookie)
------------------------------------*/

if ( ! function_exists( 'krown_retina' ) ) {

	function krown_retina() {

		if ( isset( $_COOKIE['dpi'] ) ) {
			$retina = $_COOKIE['dpi'];
		} else { 
			$retina = false;
		}

		return $retina;

	}

}

/*---------------------------------
	Get sidebar info (by js cookie)
------------------------------------*/

if ( ! function_exists( 'krown_sidebar_status' ) ) {

	function krown_sidebar_status() {

		// Get sidebar status

		if ( isset( $_COOKIE['sidebar_status'] ) ) {
			if ( $_COOKIE['sidebar_status'] == 's-opened' ) {
				return 's-opened rooipn-opened';
			} else if ( $_COOKIE['sidebar_status'] == 's-opened-portfolio' ) {
				return 's-opened-portfolio rooipn-opened';
			}
		} else { 
			return 'sidebar-unset';
		}

		// Reset it

		$_COOKIE['sidebar_status'] = 'sidebar_unset';

	}

}

/*---------------------------------
	A custom pagination function
------------------------------------*/

if ( ! function_exists( 'krown_pagination' ) ) {

	function krown_pagination( $query = null, $paginated = false, $range = 2 ) {  

		if ( $query == null ) {
			global $wp_query;
			$query = $wp_query;
		}

		$page = $query->query_vars['paged'];
		$pages = $query->max_num_pages;

		if ( $page == 0 ) {
			$page = 1;
		}

		if( $pages > 1 ) {

			echo '<nav class="blog-grid-nav me-buttons-alt">';

			if ( ! $paginated ) {

				if ( $page + 1 <= $pages ) {
					echo '<a class="prev" href="' . get_pagenum_link( $page + 1 ) . '">' . '<i class="krown-icon-arrow_left"></i>' . __( 'Older Post' ,'krown' ) . '</a>';
				}

				if ( $page - 1 >= 1 ) {
					echo '<a class="next" href="' . get_pagenum_link( $page - 1 ) . '">' . __( 'Newer Post' ,'krown' ) . '<i class="krown-icon-arrow_right"></i></a>';
				}

			} else {

				for ( $i = 1; $i <= $pages; $i++ ) {

					if ( $i == 1 || $i == $pages || $i == $page || ( $i >= $page - $range && $i <= $page + $range ) ) {
						echo '<a href="' . get_pagenum_link( $i ) . '"' . ( $page == $i ? ' class="active"' : '' ) . '>' . $i . '</a>';
					} else if ( ( $i != 1 && $i == $page - $range - 1 ) || ( $i != $page && $i == $page + $range + 1 ) ) {
						echo '<a class="none">...</a>';
					}

				}

			}
				
			echo '</nav>';

		}
		 
	}

}

/*---------------------------------
	Make some adjustments on theme setup
------------------------------------*/

if ( ! function_exists( 'krown_setup' ) ) {

	function krown_setup() {

		/* The two code blocks below are commented out because they are not ready for the 1.0 release. Leave code here for TBA 

		// Add more widget areas based on user settings

		$sidebars = ot_get_option( 'krown_sidebars' );
		if ( ! empty( $sidebars ) ) {
			foreach ( $sidebars as $sidebar ) {
				register_sidebar( array(
					'name' => $sidebar['title'],
					'id' => $sidebar['id'],
					'description' => '',
					'before_widget' => '<section id="%1$s" class="widget sidebox %2$s clearfix">',
					'after_widget' => '</section>',
					'before_title' => '<div class="widget_title"><h4>',
					'after_title' => '</h4></div>',
				) );
			}
		}

		// Setup radio images for metaboxes (action)

		add_filter( 'ot_radio_images', 'filter_radio_images', 10, 2 );

		*/

		// Setup theme update with PIXELENTITY's class
			
		if( ot_get_option( 'krown_updates_user' ) != '' && ot_get_option( 'krown_updates_api' ) != '' ){

			require_once( 'pixelentity-theme-update/class-pixelentity-theme-update.php' );
			PixelentityThemeUpdate::init( ot_get_option( 'krown_updates_user' ) ,ot_get_option( 'krown_updates_api' ), 'KrownThemes' );

		}

		// Make theme available for translation

		load_theme_textdomain( 'krown', get_template_directory() . '/lang' );

		$locale = get_locale();
		$locale_file = get_template_directory() . "/lang/$locale.php";

		if ( is_readable( $locale_file ) ) {
			require_once( $locale_file );
		}
	
		// Define content width (stupid feature, this theme has no width)

		if( ! isset( $content_width ) ) {
			$content_width = 940;
		}
		
		// Add RSS feed links to head

		add_theme_support( 'automatic-feed-links' );

		// Add post formats support

		add_theme_support( 'post-formats', array( 'link', 'image', 'quote', 'gallery', 'video', 'audio' ) );

		// Enable excerpts for pages

		add_post_type_support( 'page', 'excerpt' );

		// Enable shortcodes inside text widgets

		add_filter('widget_text', 'do_shortcode');
			
		// Add primary navigation 

		register_nav_menus( array(
			'primary' => __( 'Primary Navigation', 'krown' ),
		) );

		// Fix something

		if ( get_option( 'krown_sidebar_hide' ) == 'sidebar-default' ) {
			update_option( 'krown_sidebar_hide', 'sidebar-hide' );
		} else if ( ! get_option( 'krown_sidebar_hide' ) ) {
			add_option( 'krown_sidebar_hide', 'sidebar-hide' );
		}

		// Fix something else :)

		if ( ! get_option( 'krown_blog_style' ) ) {
			add_option( 'krown_blog_style', 'blog-style-fixed' );
		}
		
	}

}

add_action( 'after_setup_theme', 'krown_setup' );

/*---------------------------------
	Setup radio images for metaboxes (function)
------------------------------------*/

function filter_radio_images( $array, $field_id ) {

	if ( $field_id == 'krown_sidebar_layout' ) {
		$array = array(
			array(
				'value'   => 'full-width',
				'label'   => __( 'Full Width', 'option-tree' ),
				'src'     => OT_URL . '/assets/images/layout/full-width.png'
			),
			array(
				'value'   => 'right-sidebar',
				'label'   => __( 'Right Sidebar', 'option-tree' ),
				'src'     => OT_URL . '/assets/images/layout/right-sidebar.png'
			),
			array(
				'value'   => 'left-sidebar',
				'label'   => __( 'Left Sidebar', 'option-tree' ),
				'src'     => OT_URL . '/assets/images/layout/left-sidebar.png'
			)
		);
	}

	return $array;
  
}

/*---------------------------------
	Insert analytics code into the footer
------------------------------------*/

if ( ! function_exists( 'krown_analytics' ) ) {

	function krown_analytics() {
		echo ot_get_option( 'krown_tracking' );
	}

}

add_filter( 'wp_footer', 'krown_analytics' );

/*---------------------------------
	Make some changes to the wp_title function
------------------------------------*/

if ( ! function_exists( 'krown_filter_wp_title' ) ) {

	function krown_filter_wp_title( $title, $separator ) {

		if ( is_feed() ) return $title;
			
		global $paged, $page;

		if ( is_search() ) {
		
			$title = sprintf( __( 'Search results for %s', 'krown' ), '"' . get_search_query() . '"' );

			if ( $paged >= 2 ) {
				$title .= " $separator " . sprintf( __( 'Page %s', 'krown' ), $paged );
			}

			$title .= " $separator " . get_bloginfo( 'name', 'display' );

			return $title;

		}

		$title .= get_bloginfo( 'name', 'display' );

		$site_description = get_bloginfo( 'description', 'display' );

		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $separator " . $site_description;
		}

		if ( $paged >= 2 || $page >= 2 ) {
			$title .= " $separator " . sprintf( __( 'Page %s', 'krown' ), max( $paged, $page ) );
		}

		return $title;

	}

}

add_filter( 'wp_title', 'krown_filter_wp_title', 10, 2 );

/*---------------------------------
	Create a wp_nav_menu fallback, to show a home link
------------------------------------*/

function krown_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'krown_page_menu_args' );

/*---------------------------------
	Comments template
------------------------------------*/

if ( ! function_exists( 'krown_comment' ) ) {

	function krown_comment( $comment, $args, $depth ) {

		$retina = krown_retina();
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '' :
		?>

		<li id="comment-<?php comment_ID(); ?>" class="comment clearfix">
			
			<?php echo get_avatar( $comment, ( isset( $retina ) && $retina === 'true' ? 160 : 80 ), $default='' ); ?>

			<div class="comment-content">

				<div class="comment-meta clearfix">

					<h6 class="comment-title"><?php echo (get_comment_author_url() != '' ? comment_author_link() : comment_author()); ?></h6>
					<span class="comment-date"><?php echo comment_date( __( 'jS F Y', 'krown' ) ); ?></span>
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => 3, 'reply_text' => '<i class="krown-icon-cw"></i>' ) ) ); ?>

				</div>

				<div class="comment-text">

					<?php comment_text(); ?>
					
					<?php if ( $comment->comment_approved == '0' ) : ?>
						<em class="await"><?php _e( 'Your comment is awaiting moderation.', 'krown' ); ?></em>
					<?php endif; ?>

				</div>

			</div>

		</li>

		<?php
			break;
			case 'pingback'  :
			case 'trackback' :
		?>
		
		<li class="post pingback">
			<p><?php _e( 'Pingback:', 'krown' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'krown'), ' ' ); ?></p></li>
		<?php
				break;
		endswitch;
	}

}

/*---------------------------------
	Register widget areas
------------------------------------*/

function krown_widgets_init() {

	register_sidebar( array(
		'name' => __('Blog sidebar', 'krown'),
		'id' => 'krown_blog_widget_area',
		'description' => __('The blog/post default sidebar', 'krown'),
		'before_widget' => '<section id="%1$s" class="widget sidebox %2$s clearfix">',
		'after_widget' => '</section>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => __('Footer widget area', 'krown'),
		'id' => 'krown_footer_widget_area',
		'description' => __('The footer\'s widget area', 'krown'),
		'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
	
}  

add_action( 'widgets_init', 'krown_widgets_init' );


/*---------------------------------
	Remove "Recent Comments Widget" Styling
------------------------------------*/

function krown_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'krown_remove_recent_comments_style' );

/*---------------------------------
	Function that replaces the default the_excerpt function
------------------------------------*/

if ( ! function_exists( 'krown_excerptlength_post' ) ) {

	// Length (words no)
	 
	function krown_excerptlength_post($length) {
	    return 15;
	}

}

if ( ! function_exists( 'krown_excerptlength_post_big' ) ) {

	// Length (words no)
	 
	function krown_excerptlength_post_big($length) {
	    return 60;
	}

}

if ( ! function_exists( 'krown_excerptmore' ) ) {

	// More text

	function krown_excerptmore($more) {
	    return ' ...';
	}

}

if ( ! function_exists( 'krown_excerpt' ) ) {

	// The actual function
	
	function krown_excerpt( $length_callback = '', $more_callback = 'krown_excerptmore' ) {

	    global $post;
		
	    if ( function_exists( $length_callback ) ) {
			add_filter( 'excerpt_length', $length_callback );
	    }
		
	    if ( function_exists( $more_callback ) ){
			add_filter( 'excerpt_more', $more_callback );
	    }
		
	    $output = get_the_excerpt();
	    $output = apply_filters( 'wptexturize', $output );
	    $output = apply_filters( 'convert_chars', $output );
	    $output = $output;
		
	    return $output;
		
	}   

}

/*--------------------------------
	Function that returns all categories of a custom post
------------------------------------*/

function krown_categories( $post_id, $taxonomy, $delimiter = ', ', $get = 'name', $echo = true, $link = false ){

	$tags = wp_get_post_terms( $post_id, $taxonomy );
	$list = '';
	foreach( $tags as $tag ){
		if ( $link ) {
			$list .= '<a href="' . get_category_link( $tag->term_id ) . '"> ' . $tag->$get . '</a>' . $delimiter;
		} else {
			$list .= $tag->$get . $delimiter;
		}
	}

	if ( $echo ) {
		echo substr( $list, 0, strlen($delimiter)*(-1) );
	} else { 
		return substr( $list, 0, strlen($delimiter)*(-1) );
	}

}

/*---------------------------------
	Redefine the search form structure
------------------------------------*/

if ( ! function_exists( 'krown_search_form' ) ) {

	function krown_search_form( $form ) {

	    $form = '
		<form role="search" method="get" id="searchform" class="hover-show" action="' . home_url( '/' ) . '" >
			<label class="screen-reader-text hidden" for="s">' . __( 'Search for:', 'krown' ) . '</label>
			<input type="search" data-value="Type and hit Enter" value="' . __( 'Type and hit Enter', 'krown' ) . '" name="s" id="s" />
	    </form>';
	    return $form;
		
	}

}

add_filter( 'get_search_form', 'krown_search_form' );

/*---------------------------------
	Custom login logo
------------------------------------*/

function krown_custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image: url(' . ot_get_option( 'krown_custom_login_logo_uri', get_template_directory_uri() . '/images/krown-login-logo.png' ) . ') !important; background-size: 273px 63px !important; width: 273px !important; height: 63px !important; }
    </style>';
}

add_action( 'login_head', 'krown_custom_login_logo' );

/*---------------------------------
	Custom gravatar
------------------------------------*/

if ( ! function_exists( 'krown_gravatar' ) ) {

	function krown_gravatar( $avatar_defaults ) {
		$myavatar = get_template_directory_uri() . '/images/krown-gravatar.png';
		$avatar_defaults[$myavatar] = 'Krown Gravatar';
		return $avatar_defaults;
	}

	add_filter( 'avatar_defaults', 'krown_gravatar' );

}

/*---------------------------------
	Custom sidebars for pages (output)
------------------------------------*/

// Feature not yet released!

function krown_page_sidebar( $post_id ) {

	$layout = get_post_meta( $post_id, 'krown_sidebar_layout', true );
	$widget = get_post_meta( $post_id, 'krown_sidebar_set', true );

	if ( $layout != 'full-width' && is_active_sidebar( $widget ) ) {
		echo '<aside class="page-sidebar"> ';
		dynamic_sidebar( $widget );
		echo '</aside>';
	}

}

/*---------------------------------
	Blog sidebar (output)
------------------------------------*/

if ( ! function_exists( 'krown_blog_sidebar' ) ) {

	function krown_blog_sidebar() {

		$layout = get_option( 'krown_blog_layout', 'full-width' );
		$widget = 'krown_blog_widget_area';

		if ( $layout != 'full-width' && is_active_sidebar( $widget ) ) {
			echo '<aside class="page-sidebar"> ';
			dynamic_sidebar( $widget );
			echo '</aside>';
		}

	}

}

/*---------------------------------
	Add sidebar class (useful for styling)
------------------------------------*/

function krown_sidebar_class() {

	global $post;

	if ( ( is_archive() || is_search() || is_page_template( 'template-blog.php' ) ) && get_option(' krown_blog_style', 'blog-style-fixed' ) == 'blog-style-fixed alt' ) {

		echo get_option( 'krown_blog_layout', 'full-width' );

	} else if ( isset( $post ) ) {

		if ( $post->post_type == 'page' ) {
			echo get_post_meta( $post->ID, 'krown_sidebar_layout', true );
		} else if ( $post->post_type == 'post' ) {
			echo get_option( 'krown_blog_layout', 'full-width' );
		}

	}

}

/*---------------------------------
	Add blog class (useful for styling)
------------------------------------*/

function krown_blog_style() {

	global $post;

	if ( ! ( is_archive() || is_search() ) && ( isset( $post ) && $post->post_type == 'post' ) ) {
		return 'blog-style-fixed alt';
	} else {
		return get_option( 'krown_blog_style', 'blog-style-fixed' );
	}

}

/*---------------------------------
	Check if the current page is a portfolio
------------------------------------*/

if ( ! function_exists( 'krown_check_portfolio' ) ) {

	function krown_check_portfolio() {

		global $post;

		if ( is_page_template( 'template-portfolio.php' ) || is_page_template( 'template-gallery.php' ) || is_singular( array( 'portfolio', 'gallery' ) ) ) { 
			return 'is-portfolio thumbs-loading';
		} else {
			return 'isnt-portfolio';
		}

	}

}

/*---------------------------------
	Disable indexing for "link" projects
------------------------------------*/

function krown_indexing_meta() {

	global $post;

	if ( isset( $post ) && get_post_meta( $post->ID, 'krown_project_custom_url', true ) != '' ) {
		echo '<meta name="robots" content="noindex">';
	}

}

/*---------------------------------
	Fix empty search issue
------------------------------------*/

function krown_request_filter( $query_vars ) {

    if( isset( $_GET['s'] ) && empty( $_GET['s'] ) ) {
        $query_vars['s'] = " ";
    }

    return $query_vars;
}

add_filter('request', 'krown_request_filter');

/*---------------------------------
	Determine the dominant color of an image
------------------------------------*/

function krown_get_dominant_color( $image_src ) {

	if ( ! extension_loaded( 'gd' ) ) {
		return;
	}

	if ( strpos( strtolower( $image_src ), '.jpeg' ) > 0 || strpos( strtolower( $image_src ), '.jpg' ) > 0 ) {
		$img = imagecreatefromjpeg( $image_src );
	} elseif ( strpos( strtolower( $image_src ), '.png' ) > 0 ) {
		$img = imagecreatefrompng( $image_src );
	} elseif ( strpos( strtolower( $image_src ), '.gif' ) > 0 ) {
		$img = imagecreatefromgif( $image_src );
	} elseif ( strpos( strtolower( $image_src ), '.bmp' ) > 0 ) {
		$img = imagecreatefromwbmp( $image_src );
	} else {
		return;
	}

	$r_total = $g_total = $b_total = $total = 0;

	for ( $x = 0; $x < imagesx( $img ); $x++ ) {
	    for ($y = 0; $y < imagesy( $img ); $y++) {

	        $rgb = imagecolorat( $img, $x, $y );
	        $r   = ($rgb >> 16) & 0xFF;
	        $g   = ($rgb >> 8) & 0xFF;
	        $b   = $rgb & 0xFF;

	        $r_total += $r;
	        $g_total += $g;
	        $b_total += $b;
	        $total++;

	    }
	}

	$r_average = round( $r_total / $total );
	$g_average = round( $g_total / $total );
	$b_average = round( $b_total / $total );

	$hsl = rgb_to_hsl( $r_average, $g_average, $b_average );

	if ( $hsl[2] > 0.5 ) {
		$rgb = hsl_to_rgb( $hsl[0], $hsl[1], 0.5 );
		$r_average = $rgb[0];
		$g_average = $rgb[1];
		$b_average = $rgb[2];
	}

	$hex = "#";
	$hex .= str_pad( dechex( $r_average ), 2, "0", STR_PAD_LEFT );
	$hex .= str_pad( dechex( $g_average ), 2, "0", STR_PAD_LEFT );
	$hex .= str_pad( dechex( $b_average ), 2, "0", STR_PAD_LEFT );

	return $hex;

}

/*---------------------------------
	Set the color determined above
------------------------------------*/

if ( ! function_exists( 'krown_set_dominant_color' ) ) {

	function krown_set_dominant_color( $post_id ) {

		$img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );

		if ( $img_src[0] != null && $img_src[0] != '' && ini_get( 'allow_url_fopen' ) ) {

			$thumb_color = get_post_meta( $post_id, '_thumb_color', true );
			$dom_color = krown_get_dominant_color( $img_src[0] );

			if ( $thumb_color == '' ) {
		        add_post_meta( $post_id, '_thumb_color', $dom_color );
			} else if ( $thumb_color != krown_get_dominant_color( $img_src[0] ) ) {
				update_post_meta( $post_id, '_thumb_color', $dom_color );
			}

		}

	}

}

add_action( 'save_post', 'krown_set_dominant_color', 1, 2 );

/*---------------------------------
	Color conversion functions
------------------------------------*/

function rgb_to_hsl( $r, $g, $b ) {

	$oldR = $r;
	$oldG = $g;
	$oldB = $b;

	$r /= 255;
	$g /= 255;
	$b /= 255;

    $max = max( $r, $g, $b );
	$min = min( $r, $g, $b );

	$h;
	$s;
	$l = ( $max + $min ) / 2;
	$d = $max - $min;

    	if( $d == 0 ){
        	$h = $s = 0; 
    	} else {
        	$s = $d / ( 1 - abs( 2 * $l - 1 ) );

		switch( $max ){
	            case $r:
	            	$h = 60 * fmod( ( ( $g - $b ) / $d ), 6 ); 
                        if ($b > $g) {
	                    $h += 360;
	                }
	                break;

	            case $g: 
	            	$h = 60 * ( ( $b - $r ) / $d + 2 ); 
	            	break;

	            case $b: 
	            	$h = 60 * ( ( $r - $g ) / $d + 4 ); 
	            	break;
	        }			        	        
	}

	return array( round( $h, 2 ), round( $s, 2 ), round( $l, 2 ) );

}

function hsl_to_rgb( $h, $s, $l ) {

    $r; 
    $g; 
    $b;

	$c = ( 1 - abs( 2 * $l - 1 ) ) * $s;
	$x = $c * ( 1 - abs( fmod( ( $h / 60 ), 2 ) - 1 ) );
	$m = $l - ( $c / 2 );

	if ( $h < 60 ) {
		$r = $c;
		$g = $x;
		$b = 0;
	} else if ( $h < 120 ) {
		$r = $x;
		$g = $c;
		$b = 0;			
	} else if ( $h < 180 ) {
		$r = 0;
		$g = $c;
		$b = $x;					
	} else if ( $h < 240 ) {
		$r = 0;
		$g = $x;
		$b = $c;
	} else if ( $h < 300 ) {
		$r = $x;
		$g = 0;
		$b = $c;
	} else {
		$r = $c;
		$g = 0;
		$b = $x;
	}

	$r = ( $r + $m ) * 255;
	$g = ( $g + $m ) * 255;
	$b = ( $b + $m  ) * 255;

    return array( floor( $r ), floor( $g ), floor( $b ) );

}

function krown_hex_to_rgba($hex, $a) {

   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }

   return 'rgba(' . $r . ',' . $g . ',' . $b . ',' . $a . ')';
   
}

/*---------------------------------
	Enqueue front scripts
------------------------------------*/

function krown_enqueue_scripts() {

	// Enqueue the greensock plugins for js animations:

	wp_enqueue_script( 'tween_max', get_template_directory_uri() . '/js/TweenMax.min.js', array('jquery'), NULL, true);
	wp_enqueue_script( 'gsap', get_template_directory_uri() . '/js/jquery.gsap.min.js', array('tween_max'), NULL, true);

	// Enqueue other used js libraries:

	wp_enqueue_script( 'fancybox', get_template_directory_uri().'/js/jquery.fancybox.pack.js', array('gsap'), NULL, true );
	wp_enqueue_script( 'swiper', get_template_directory_uri().'/js/idangerous.swiper.min.js', array('gsap'), NULL, true );
	wp_enqueue_script( 'isotope', get_template_directory_uri().'/js/jquery.isotope.min.js', array('gsap'), NULL, true );
	wp_enqueue_script( 'mCustomScrollbar', get_template_directory_uri().'/js/jquery.mCustomScrollbar.min.js', array('gsap'), NULL, true );
	wp_enqueue_script( 'history', get_template_directory_uri().'/js/jquery.history.min.js', array('gsap'), NULL, true );
	wp_enqueue_script( 'mediaelement', get_template_directory_uri().'/js/mediaelement-and-player.min.js', array('gsap'), NULL, true );

	// Enqueue theme scripts

	wp_enqueue_script( 'theme_plugins', get_template_directory_uri().'/js/plugins.min.js', array('gsap'), NULL, true );
	wp_enqueue_script( 'theme_scripts', get_template_directory_uri().'/js/scripts.min.js', array('theme_plugins'), NULL, true );

	//////////////////////

	wp_enqueue_style( 'krown-style', get_stylesheet_uri() );

	if ( is_single() || is_page() ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	// We need to pass some useful variables to the theme scripts through the following function

	wp_localize_script(
		'theme_scripts', 
		'themeObjects',
		array(
			'base' 					=> get_template_directory_uri(),
			'folioOpacity' 			=> is_page_template( 'template-portfolio.php' ) ? get_option( 'krown_thumbs_opacity', '.7' ) : get_option( 'krown_gal_thumbs_opacity', '.7' ),
			'folioWidth' 			=> is_page_template( 'template-portfolio.php' ) ? get_option( 'krown_thumbs_width', '340' ) : get_option( 'krown_gal_thumbs_width', '340' ),
			'gAnalytics' 			=> ot_get_option( 'krown_tracking_enable', 'disabled' ),
			'gAnalyticsCode' 		=> ot_get_option( 'krown_tracking' ),
			'modalDummyBackground' 	=> get_option( 'krown_folio_dummy_background' ),
			'modalCloseClick'		=> get_option( 'krown_folio_modal_close_click', 'false' ),
			'disableParallax' 		=> get_option( 'krown_parallax', 'parallax-enabled' )
		)
	);

}

add_action( 'wp_enqueue_scripts', 'krown_enqueue_scripts', 10 );

/*---------------------------------
	Enqueue admin styles
------------------------------------*/

function krown_admin_scripts() {
	wp_enqueue_style( 'krown-admin', get_template_directory_uri() . '/css/admin-style.css' );
}

add_action( 'admin_enqueue_scripts', 'krown_admin_scripts' );

/*---------------------------------
	Add theme customizer link into the menu
------------------------------------*/

function krown_add_customizer_to_menu() {
    add_theme_page( 'Customize', 'Customize', 'edit_theme_options', 'customize.php' );
}

/*---------------------------------
	Post format content
------------------------------------*/

if ( ! function_exists( 'krown_post_format_content' ) ) {

	function krown_post_format_content( $post_id, $post_format, $blog_grid = false ) {

		// This function tests the format of a post and returns the proper content (images, videos, quotes, etc.)

		switch( $post_format ) {

			case 'quote':
				echo '<blockquote class="post-format-quote">
					<p>' . get_post_meta( $post_id, 'krown_post_quote_1', true ) . '</p>
					<span>' . get_post_meta( $post_id, 'krown_post_quote_2', true) . '</span>
					</blockquote>';
				break;

			case 'image':
				if ( $blog_grid ) {
					$retina = krown_retina();
					$image = $retina === 'true' ? aq_resize( get_post_meta( $post_id, 'krown_post_image', true ), '340', null, true, false ) : aq_resize( get_post_meta( $post_id, 'krown_post_image', true ), '680', null, true, false );
					echo '<div class="post-format-image"><a class="fancybox fancybox-thumb" href="' . get_post_meta( $post_id, 'krown_post_image', true ) . '"><img src="' . $image[0] . '" width="' . $image[1] . '" height="' . $image[2] . '" alt="" /></a></div>';
				} else {
					echo '<div class="post-format-image"><img src="' . get_post_meta( $post_id, 'krown_post_image', true ) . '" alt="" /></div>';
				}
				break;

			case 'video':
				if( get_post_meta( $post_id, 'krown_post_video_1', true ) != '' ) {
					echo '<div class="post-format-iframe">' . get_post_meta( $post_id, 'krown_post_video_1', true ) . '</div>';
				} else {
					echo '<div class="post-format-video"><video id="video-' . $post_id . '" class="video-js vjs-default-skin" controls preload="auto" width="100%" height="100%" style="width:100%; height:100%" poster="' . get_post_meta( $post_id, 'krown_post_video_3', true ) .'" data-setup="{}">
					  <source src="' . get_post_meta( $post_id, 'krown_post_video_2', true ) . '" type="video/mp4">
					</video></div>';
				}
				break;

			case 'audio':
				echo '<div class="post-format-audio">
					<audio style="width:100%; height:30px;" class="audio-js" controls preload src="' . get_post_meta( $post_id, 'krown_post_audio', true ) . '" />
				</div>';
				break;

			case 'gallery':
				$shortcode_text = get_post_meta( $post_id, 'krown_post_gallery', true );
				if ( $blog_grid ) {
					echo '<div class="post-format-gallery">' . do_shortcode( str_replace( '[gallery', '[gallery type="slider" width="340"', $shortcode_text ) ) . '</div>';
				} else {
					echo '<div class="post-format-gallery">' . do_shortcode( str_replace( '[gallery', '[gallery type="slider"', $shortcode_text ) ) . '</div>';
				}
				break;

			case 'link':
				echo '<div class="post-format-link">
					<a href="' . get_post_meta( $post_id, 'krown_post_link', true ) . '" target="_blank">' . get_the_title( $post_id ) . '</a>
				</div>';
				break;

		} 

	}

}

/*---------------------------------
    Navigation Walker
------------------------------------*/

class Krown_Nav_Walker extends Walker_Nav_Menu {

    function start_lvl( &$output, $depth=0, $args=array() ) {
        $output .= '<ul class="sub-menu clearfix">';
    }

    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ){

        $id_field = $this->db_fields['id'];

        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
        }

        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );

    }

    function start_el( &$output, $object, $depth=0, $args=array(), $current_object_id=0 ) {

        global $wp_query;
        global $rb_submenus;

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $new_output = '';
        $depth_class = ( $args->has_children ? 'parent ' : '' );

        $class_names = $value = $selected_class = '';
        $classes = empty( $object->classes ) ? array() : ( array ) $object->classes;

        $current_indicators = array('current-menu-item', 'current-menu-parent', 'current_page_item', 'current_page_parent', 'current-menu-ancestor');

        foreach ( $classes as $el ) {
            if ( in_array( $el, $current_indicators ) ) {
                $selected_class = 'selected ';
            }
        }

        $class_names = ' class="' . $selected_class . $depth_class . 'menu-item' . ( ! empty( $classes[0] ) ? ' ' . $classes[0] : '' ) . ' clearfix"';

        if ( ! get_post_meta( $object->object_id , '_members_only' , true ) || is_user_logged_in() ) {
            $output .= $indent . '<li id="menu-item-'. $object->ID . '"' . $class_names . '>';
        }

        $attributes  = ! empty( $object->attr_title ) ? ' title="'  . esc_attr( $object->attr_title ) .'"' : '';
        $attributes .= ! empty( $object->target )     ? ' target="' . esc_attr( $object->target     ) .'"' : '';
        $attributes .= ! empty( $object->xfn )        ? ' rel="'    . esc_attr( $object->xfn        ) .'"' : '';

        if ( ! in_array( $object->object, krown_cpt_cat_list() ) && $object->attr_title != 'all' ) {

            $attributes .= ! empty( $object->url )        ? ' href="'   . esc_attr( $object->url        ) .'"' : '';

        } else {

            if ( $object->attr_title == 'all' ) {

                $attributes .= ' href="#" class="filter all-filter" data-filter="*"';

            } else {
            	
                $terms = get_terms( $object->object, array( 'include' => $object->object_id ) );
                $attributes .= ' href="#" class="filter" data-filter="' . ( isset( $terms[0] ) ? $terms[0]->slug : '' ) .'"';

            }

        }

        $object_output = $args->before;
        $object_output .= '<a' . $attributes . '>';
        $object_output .= $args->link_before . apply_filters( 'the_title', $object->title, $object->ID ) . $args->link_after;
        $object_output .= '</a>';
        $object_output .= $args->after;

        if ( !get_post_meta( $object->object_id, '_members_only' , true ) || is_user_logged_in() ) {

            $output .= apply_filters( 'walker_nav_menu_start_el', $object_output, $object, $depth, $args );

        }

        $output .= $new_output;

    }

    function end_el(&$output, $object, $depth=0, $args=array()) {

        if ( !get_post_meta( $object->object_id, '_members_only' , true ) || is_user_logged_in() ) {
            $output .= "</li>\n";
        }

    }
    
    function end_lvl(&$output, $depth=0, $args=array()) {

        $output .= "</ul>\n";

    }

}

/*---------------------------------
    Helper function for navigation
------------------------------------*/

if ( ! function_exists( 'krown_cpt_cat_list' ) ) {

	function krown_cpt_cat_list() {
		return array( 'portfolio_category', 'gallery_category' );
	}

}

?>