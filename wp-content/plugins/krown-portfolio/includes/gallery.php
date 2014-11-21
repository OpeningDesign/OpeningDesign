<?php

add_action( 'init', 'gallery_init', 0 );

add_theme_support( 'post-thumbnails', array( 'gallery', 'portfolio' ) );

add_filter( 'manage_edit-gallery_columns', 'gallery_add_thumbnail_column', 10, 1 );
add_action( 'manage_gallery_posts_custom_column', 'gallery_display_thumbnail', 10, 1 );

add_action( 'restrict_manage_posts', 'gallery_add_taxonomy_filters' );

add_action( 'right_now_content_table_end', 'gallery_add_gallery_counts' );

add_action( 'admin_head', 'gallery_icon' );

function gallery_init() {

	/**
	 * Enable the Gallery custom post type
	 * http://codex.wordpress.org/Function_Reference/register_post_type
	 */

	$labels = array(
		'name' => __( 'Gallery', 'galleryposttype' ),
		'singular_name' => __( 'Gallery Item', 'galleryposttype' ),
		'add_new' => __( 'Add New Item', 'galleryposttype' ),
		'add_new_item' => __( 'Add New Gallery Item', 'galleryposttype' ),
		'edit_item' => __( 'Edit Gallery Item', 'galleryposttype' ),
		'new_item' => __( 'Add New Gallery Item', 'galleryposttype' ),
		'view_item' => __( 'View Item', 'galleryposttype' ),
		'search_items' => __( 'Search Gallery', 'galleryposttype' ),
		'not_found' => __( 'No gallery items found', 'galleryposttype' ),
		'not_found_in_trash' => __( 'No gallery items found in trash', 'galleryposttype' )
	);
	
	$args = array(
    	'labels' => $labels,
    	'public' => true,
		'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'author', 'custom-fields', 'revisions' ),
		'capability_type' => 'post',
		'rewrite' => array("slug" => "gallery"), // Permalinks format
		'menu_position' => 5,
		'has_archive' => false
	);
	
	$args = apply_filters('galleryposttype_args', $args);

	register_post_type( 'gallery', $args );
	
	/**
	 * Register a taxonomy for Gallery Tags
	 * http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	
	/*$taxonomy_gallery_tag_labels = array(
		'name' => _x( 'Gallery Tags', 'galleryposttype' ),
		'singular_name' => _x( 'Gallery Tag', 'galleryposttype' ),
		'search_items' => _x( 'Search Gallery Tags', 'galleryposttype' ),
		'popular_items' => _x( 'Popular Gallery Tags', 'galleryposttype' ),
		'all_items' => _x( 'All Gallery Tags', 'galleryposttype' ),
		'parent_item' => _x( 'Parent Gallery Tag', 'galleryposttype' ),
		'parent_item_colon' => _x( 'Parent Gallery Tag:', 'galleryposttype' ),
		'edit_item' => _x( 'Edit Gallery Tag', 'galleryposttype' ),
		'update_item' => _x( 'Update Gallery Tag', 'galleryposttype' ),
		'add_new_item' => _x( 'Add New Gallery Tag', 'galleryposttype' ),
		'new_item_name' => _x( 'New Gallery Tag Name', 'galleryposttype' ),
		'separate_items_with_commas' => _x( 'Separate gallery tags with commas', 'galleryposttype' ),
		'add_or_remove_items' => _x( 'Add or remove gallery tags', 'galleryposttype' ),
		'choose_from_most_used' => _x( 'Choose from the most used gallery tags', 'galleryposttype' ),
		'menu_name' => _x( 'Gallery Tags', 'galleryposttype' )
	);
	
	$taxonomy_gallery_tag_args = array(
		'labels' => $taxonomy_gallery_tag_labels,
		'public' => true,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_tagcloud' => true,
		'hierarchical' => false,
		'rewrite' => array( 'slug' => 'gallery_tag' ),
		'show_admin_column' => true,
		'query_var' => true
	);
	
	register_taxonomy( 'gallery_tag', array( 'gallery' ), $taxonomy_gallery_tag_args );*/
	
	/**
	 * Register a taxonomy for Gallery Categories
	 * http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */

    $taxonomy_gallery_category_labels = array(
		'name' => _x( 'Gallery Categories', 'galleryposttype' ),
		'singular_name' => _x( 'Gallery Category', 'galleryposttype' ),
		'search_items' => _x( 'Search Gallery Categories', 'galleryposttype' ),
		'popular_items' => _x( 'Popular Gallery Categories', 'galleryposttype' ),
		'all_items' => _x( 'All Gallery Categories', 'galleryposttype' ),
		'parent_item' => _x( 'Parent Gallery Category', 'galleryposttype' ),
		'parent_item_colon' => _x( 'Parent Gallery Category:', 'galleryposttype' ),
		'edit_item' => _x( 'Edit Gallery Category', 'galleryposttype' ),
		'update_item' => _x( 'Update Gallery Category', 'galleryposttype' ),
		'add_new_item' => _x( 'Add New Gallery Category', 'galleryposttype' ),
		'new_item_name' => _x( 'New Gallery Category Name', 'galleryposttype' ),
		'separate_items_with_commas' => _x( 'Separate gallery categories with commas', 'galleryposttype' ),
		'add_or_remove_items' => _x( 'Add or remove gallery categories', 'galleryposttype' ),
		'choose_from_most_used' => _x( 'Choose from the most used gallery categories', 'galleryposttype' ),
		'menu_name' => _x( 'Gallery Categories', 'galleryposttype' ),
    );
	
    $taxonomy_gallery_category_args = array(
		'labels' => $taxonomy_gallery_category_labels,
		'public' => true,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_tagcloud' => true,
		'hierarchical' => true,
		'rewrite' => array( 'slug' => 'gallery_category' ),
		'query_var' => true
    );
	
    register_taxonomy( 'gallery_category', array( 'gallery' ), $taxonomy_gallery_category_args );
	
}
 
/**
 * Add Columns to Gallery Edit Screen
 * http://wptheming.com/2010/07/column-edit-pages/
 */

function gallery_add_thumbnail_column( $columns ) {

	$column_thumbnail = array( 'thumbnail' => __('Thumbnail','galleryposttype' ) );
	$columns = array_slice( $columns, 0, 2, true ) + $column_thumbnail + array_slice( $columns, 1, NULL, true );
	return $columns;
}
function gallery_display_thumbnail( $column ) {
	global $post;
	switch ( $column ) {
		case 'thumbnail':
			echo get_the_post_thumbnail( $post->ID, array(50, 50) );
			break;
	}
}

/**
 * Adds taxonomy filters to the gallery admin page
 * Code artfully lifed from http://pippinsplugins.com
 */
 
function gallery_add_taxonomy_filters() {
	global $typenow;
	
	// An array of all the taxonomyies you want to display. Use the taxonomy name or slug
	$taxonomies = array( 'gallery_category' );
 
	// must set this to the post type you want the filter(s) displayed on
	if ( $typenow == 'gallery' ) {
 
		foreach ( $taxonomies as $tax_slug ) {
			$current_tax_slug = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;
			$tax_obj = get_taxonomy( $tax_slug );
			$tax_name = $tax_obj->labels->name;
			$terms = get_terms($tax_slug);
			if ( count( $terms ) > 0) {
				echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
				echo "<option value=''>$tax_name</option>";
				foreach ( $terms as $term ) {
					echo '<option value=' . $term->slug, $current_tax_slug == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
				}
				echo "</select>";
			}
		}
	}
}

/**
 * Add Gallery count to "Right Now" Dashboard Widget
 */

function gallery_add_gallery_counts() {
        if ( ! post_type_exists( 'gallery' ) ) {
             return;
        }

        $num_posts = wp_count_posts( 'gallery' );
        $num = number_format_i18n( $num_posts->publish );
        $text = _n( 'Gallery Item', 'Gallery Items', intval($num_posts->publish) );
        if ( current_user_can( 'edit_posts' ) ) {
            $num = "<a href='edit.php?post_type=gallery'>$num</a>";
            $text = "<a href='edit.php?post_type=gallery'>$text</a>";
        }
        echo '<td class="first b b-gallery">' . $num . '</td>';
        echo '<td class="t gallery">' . $text . '</td>';
        echo '</tr>';

        if ($num_posts->pending > 0) {
            $num = number_format_i18n( $num_posts->pending );
            $text = _n( 'Gallery Item Pending', 'Gallery Items Pending', intval($num_posts->pending) );
            if ( current_user_can( 'edit_posts' ) ) {
                $num = "<a href='edit.php?post_status=pending&post_type=gallery'>$num</a>";
                $text = "<a href='edit.php?post_status=pending&post_type=gallery'>$text</a>";
            }
            echo '<td class="first b b-gallery">' . $num . '</td>';
            echo '<td class="t gallery">' . $text . '</td>';

            echo '</tr>';
        }
}

/**
 * Displays the custom post type icon in the dashboard
 */
 
function gallery_icon() { ?>
    <style type="text/css" media="screen">
        #menu-posts-gallery .wp-menu-image {
            background: url(<?php echo plugin_dir_url( __FILE__ ); ?>../images/gallery.png) no-repeat 6px 8px !important;
        }
		#menu-posts-gallery:hover .wp-menu-image {
            background-position: -27px 8px !important;
        }
        #menu-posts-gallery.wp-has-current-submenu .wp-menu-image {
            background-position: -59px 8px !important;
        }
    </style>

<?php } ?>