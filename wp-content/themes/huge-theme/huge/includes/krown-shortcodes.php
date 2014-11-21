<?php

// This file contains an overwrite for the shortcodes availalble in the Krown Themes Shortcodes. These could easily be overwritten in a child theme.

/* ------------------------
-----   Accordion    -----
------------------------------*/

if ( ! function_exists( 'krown_accordion_function' ) ) {

    function krown_accordion_function( $atts, $content ){

        extract( shortcode_atts( array(
            'el_class'  => '',
            'type'      => 'accordion',
            'opened'    => '0'
        ), $atts ) );

        $html = '<div data-opened="' . $opened . '" class="krown-accordion ' . $type . ' ' . ( $el_class != '' ? ' ' . $el_class : '' ) . ' clearfix">';

        $html .= do_shortcode( $content );

        $html .= '</div>';

        return $html;

    }

    add_shortcode( 'krown_accordion', 'krown_accordion_function' );

}

if ( ! function_exists( 'krown_accordion_section_function' ) ) {

    function krown_accordion_section_function( $atts, $content ){

        extract( shortcode_atts( array(
            'title' => 'Section',
        ), $atts ) );

        $html = '<section>
            <h5>' . $title . '</h5>
            <div>' . do_shortcode( $content ) . '</div>
        </section>';

        return $html;

    }   

    add_shortcode( 'krown_accordion_section', 'krown_accordion_section_function' );

}

/* ------------------------
-----   Gallery   -----
------------------------------*/

if ( ! function_exists( 'krown_gallery_function' ) ) {

    function krown_gallery_function( $attr ) {

        global $post;

        $post = get_post();

        static $instance = 0;
        $instance++;

        if ( ! empty( $attr['ids'] ) ) {
            if ( empty( $attr['orderby'] ) ) {
                $attr['orderby'] = 'post__in';
            }
            $attr['include'] = $attr['ids'];
        }

        $html = apply_filters( 'post_gallery', '', $attr );
        if ( $html != '' ) {
            return $html;
        }

        if ( isset( $attr['orderby'] ) ) {
            $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
            if ( !$attr['orderby'] ) {
                unset( $attr['orderby'] );
            }
        }

        extract( shortcode_atts( array(
            'order'          => 'ASC',
            'orderby'        => 'menu_order ID',
            'id'             => $post->ID,
            'include'        => '',
            'exclude'        => '',
            'type'           => 'thumbs',
            'thumbs_width'   => '300',
            'thumbs_height'  => '200',
            'columns'        => '3',
            'aspect'         => 'square',
            'width'          => 'null'
        ), $attr ) );

        $id = intval( $id );
        if ( 'RAND' == $order ) {
            $orderby = 'none';
        }

        if ( ! empty( $include ) ) {

            $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

            $attachments = array();

            foreach ( $_attachments as $key => $val ) {
                $attachments[$val->ID] = $_attachments[$key];
            }

        } else if ( ! empty( $exclude ) ) {
            $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
        } else {
            $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
        }

        if ( empty( $attachments ) ) {
            return '';
        }

        if ( is_feed() ) {
            $html = "\n";
            foreach ( $attachments as $att_id => $attachment ) {
                $html .= wp_get_attachment_link($att_id, $size, true) . "\n";
            }
            return $html;
        }

        $slides = '';

        $thumbs_col = 100 / $columns;
        $thumbs_width = floor(1500 / $columns);

        $i = 0;

        foreach ( $attachments as $id => $attachment ) {

            $link = isset( $attr['link'] ) && 'file' == $attr['link'] ? wp_get_attachment_image_src( $id, 'full', false, false ) : wp_get_attachment_image_src( $id, 'full', true, false );

            $caption = get_post( $id )->post_excerpt;
            $title = get_post( $id )->post_title;

            if ( $type == 'slider' ) {

                if ( $width == 'null' ) {
                    $slides .= slide_content( $id, false, null, null, '<div class="swiper-slide">', '</div>' );
                } else {
                    $slides .= slide_content( $id, true, $width, null, '<div class="swiper-slide">', '</div>' );
                }

            } else {

                if ( $i % $columns == 0 ) {
                    $extra_class = ' first';
                }
                if ( ++$i % $columns == 0 ) {
                    $extra_class = ' last';
                } 

                $rimg = $aspect == 'square' ? aq_resize( $link[0], $thumbs_width, $thumbs_width, true ) : aq_resize( $link[0], $thumbs_width, null );

                $slides .= '<a class="fancybox fancybox-thumb' . $extra_class . '" data-fancybox-group="gallery-' . $instance . '" href="' . $link[0] . '" style="width:' . $thumbs_col . '%"><img src="' . $rimg . '" /></a>';

            }

        }

        if ( $type == 'slider' ) {

            $html = '<div class="krown-gallery swiper-container full' . '" style="width:1454px;">
            <div class="swiper-wrapper">' . $slides . '</div></div>';

        } else {

            $html = '<div class="krown-thumbnail-gallery clearfix">' . $slides . '</div>';

        }

        return $html;

    }

    remove_shortcode( 'gallery', 'gallery_shortcode' );
    add_shortcode( 'gallery', 'krown_gallery_function' );

}

/* ------------------------
-----   Tabs   -----
------------------------------*/

if ( ! function_exists( 'krown_tabs_function' ) ) {

    function krown_tabs_function( $atts, $content ){

        extract( shortcode_atts( array(
            'el_class'  => '',
            'type'      => 'horizontal'
        ), $atts ) );

        $html = '<div class="krown-tabs' . ( $el_class != '' ? ' ' . $el_class : '' ) . ' ' . $type . ' clearfix">';

        $tabs = explode('<!-- cut out -->', do_shortcode( $content ) );
        $i = 0; $top = ''; $bottom = '';

        foreach ( $tabs as $item ) {

            if( $i++%2 == 0 ) {
                $top .= $item;
            } else { 
                $bottom .= $item;
            }

        }

        $html .= '<ul class="titles clearfix autop">' . preg_replace( '/<li>/' , '<li class="opened">', $top, 1 ) . '</ul>';
        $html .= '<div class="contents clearfix autop">' . $bottom . '</div>';
        $html .= '</div>';

        return $html;

    }

    add_shortcode( 'krown_tabs', 'krown_tabs_function' );

}

if ( ! function_exists( 'krown_tabs_section_function' ) ) {

    function krown_tabs_section_function( $atts, $content ){

        extract( shortcode_atts( array(
            'title'  => 'Section',
            'icon'   => ''
        ), $atts ) );

        $html = '<li><h5' . ( $icon != '' ? ' class="krown-icon-' . $icon . '"' : '' ) . '>' . $title . '</h5></li><!-- cut out --><div>' . do_shortcode( $content ) . '</div><!-- cut out -->';

        return $html;

    }

    add_shortcode( 'krown_tabs_section', 'krown_tabs_section_function' );

}

?>