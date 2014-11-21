<?php

/* PLEASE READ! This is the first area which needs your attention! If you duplicate this file into a new one (for a different custom post type) you need to add into the conditional statements below (your new custom post type) */

if ( ! function_exists( 'krown_enqueue_extend_scripts' ) ) {

    function krown_enqueue_extend_scripts() {

        global $pagenow, $typenow;
        $template_file = '';

        if ( empty( $typenow ) && !empty( $_GET['post'] ) ) {
            $post = get_post( $_GET['post'] );
            $typenow = $post->post_type;
            $template_file = $post->ID != 'no' ? get_post_meta($post->ID,'_wp_page_template',TRUE) : 'no';
        }

        // Simply add "$typenow == 'threefolio' || " (without quotes) before the first $typenow variable, if your cpt is called "threefolio"

        if ( is_admin() && ( $typenow == 'twofolio' || $typenow == 'portfolio' || $typenow == 'gallery' || ( $typenow == 'page' && $template_file == 'template-single-gallery.php' ) ) ) {
            if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' ) {

                wp_enqueue_style( 'extend-ot-css', get_template_directory_uri() . '/css/extend-ot.css' );
                wp_enqueue_script( 'extend-ot-js', get_template_directory_uri() . '/js/extend-ot.js' );
                
            }
        }

    }

}

/* PLEASE READ! This is the second area which needs editing! If you duplicate this, make sure that you add the new page template in the if statement, along with the new custom post type..

Let's say that your custom post type is called "threefolio" and the page template which you've prepared is called "template-threefolio". The if statement below should look like this:

    if ( is_page_template( 'template-three.php') || is_page_template( 'template-twofolio.php') || is_page_template( 'template-portfolio.php' ) || is_page_template( 'template-gallery.php' ) || is_singular( array( 'threefolio', 'twofolio', 'portfolio', 'gallery' ) ) ) {

The idea is to make sure that the theme will know when it is dealing with your custom post types.

*/

if ( ! function_exists( 'krown_check_portfolio' ) ) {

    function krown_check_portfolio() {

        global $post;

        if ( is_page_template( 'template-twofolio.php') || is_page_template( 'template-portfolio.php' ) || is_page_template( 'template-gallery.php' ) || is_singular( array( 'twofolio', 'portfolio', 'gallery' ) ) ) { 
            return 'is-portfolio thumbs-loading';
        } else {
            return 'isnt-portfolio';
        }

    }

}

/* PLEASE READ! This is the third area which needs editing! 

You need to add your new custom post type in the array below.

*/

if ( ! function_exists( 'krown_cpt_cat_list' ) ) {

    function krown_cpt_cat_list() {
        return array( 'portfolio_category', 'gallery_category', 'twofolio_category' );
    }

}

/* PLEASE READ! This is the last area which needs editing! 

    1. You need to rename the three strings below "twofolio_page" with your new custom post type name, let's say "threefolio_page".

    2. You need to come at a later point and update the "999" id into something else, because that will be the id of the page template which will display the new custom post type.

*/

if ( ! get_option( 'twofolio_page' ) ) {
    add_option( 'twofolio_page', '9999' );
}

update_option( 'twofolio_page', '999' );

?>