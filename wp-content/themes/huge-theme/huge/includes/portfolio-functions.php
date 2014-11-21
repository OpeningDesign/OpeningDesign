<?php

// This file contains functions for the custom portfolios available with this theme.

/*---------------------------------
	Modal Gallery
------------------------------------*/

function krown_modal_gallery( $post_id, $width, $height, $background_style = '', $align = 'middle', $style = 'full' ){

	$slides = explode( ',', get_post_meta( $post_id, 'pp_gallery_slider', true ) );

	$w_width = $width;
	$w_height = $height;

	$retina = krown_retina();

	if ( $retina === 'true' ) {
		$width *= 2;
		$height *= 2;
	}

	if( ! empty( $slides ) && sizeof( $slides ) == 1 ) {

		$html = '<div class="modal single" style="' . $background_style . ';width:' . $w_width . 'px; height:' . $w_height . 'px">' . slide_content( $slides[0], true, $width, $height ) . '</div>';

	} else if ( ! empty( $slides ) ) {

		$html = '<div class="modal swiper-container align-' . $align . ' ' . $style . '" style="' . $background_style . ';width:' . $w_width . 'px; height:' . $w_height . 'px"><div class="swiper-wrapper">';

		foreach ( $slides as $slide ) {

			$html .= '<div class="swiper-slide">' . slide_content( $slide, true, $width, $height ) . '</div>';

		}
	
		$html .= '</div></div>';

	}

	echo $html;

}

/*---------------------------------
	Vertical Gallery
------------------------------------*/

function krown_vertical_gallery( $post_id, $background_style = '' ){

	$html = '<div class="vertical-gallery" style="' . $background_style . '"><ul class="slides">';

	$slides = explode( ',', get_post_meta( $post_id, 'pp_gallery_slider', true ) );

	if ( ! empty( $slides ) ) {

		foreach ( $slides as $slide ) {

			$html .= slide_content( $slide, false, null, null, '<li style="max-width:%width%">', '</li>' );

		}

	}

	$html .= '</ul></div>';

	echo $html;

}

/*---------------------------------
	Horizontal Gallery
------------------------------------*/

function krown_horizontal_gallery( $post_id, $background_style = '', $align = 'middle', $style = 'full', $captions = 'hide' ){

	$html = '<div class="horizontal-gallery swiper-container align-' . $align . ' ' . $style . '" style="' . $background_style . '"><div class="swiper-wrapper">';

	$slides = explode( ',', get_post_meta( $post_id, 'pp_gallery_slider', true ) );

	if ( ! empty( $slides ) ) {

		foreach ( $slides as $slide ) {

			if ( $captions == 'show' ) {
				$html .= '<div class="swiper-slide" data-title="' . get_post( $slide )->post_title . '">' . slide_content( $slide ) . '</div>';
			} else {
				$html .= '<div class="swiper-slide">' . slide_content( $slide ) . '</div>';
			}

		}

	}

	$html .= '</div></div>';

	echo $html;

}

/*---------------------------------
	Get Slide Content
------------------------------------*/

function slide_content( $slide_id, $crop = false, $width = null, $height = null, $before_slide = '', $after_slide = '', $return_array = false ) {

	$video_code = get_post_meta( $slide_id, 'video_code', true);
	$video_file = get_post_meta( $slide_id, 'video_file', true);

	$img = wp_get_attachment_image_src( $slide_id, 'full' );

	if ( $crop ) {

		$img_url = $img[0];
		$image = aq_resize( $img_url, $width, $height, true, false );

	} else {

		$image = wp_get_attachment_image_src( $slide_id, 'full' );

	}

	$before_slide = str_replace( '%width%', $image[1] . 'px', $before_slide );

	if ( $video_code != '' ) {

		$html = $before_slide . '<div class="video-embedded" data-id="' . rand(1, 9999) . '" data-href="' . $video_code . '"><img src="' . $image[0] . '" width="' . $image[1] . '" height="' . $image[2] . '" alt="" /></div>' . $after_slide;

	} else if ( $video_file != '' ) {

		$html = $before_slide . '<video class="video-hosted" width="' . $image[1] . '" height="' . $image[2] . '" style="width:100%;height:100%" poster="' . $image[0] . '"><source type="video/mp4" src="' . $video_file . '" /></video>' . $after_slide;

	} else {

		$html = $before_slide . '<img src="' . $image[0] . '" width="' . $image[1] . '" height="' . $image[2] . '" alt="" />' . $after_slide;

	}

	if ( $return_array == true ) {

		return array( $html, $image[2] );

	} else {

		return $html;

	}

}

/*---------------------------------
	Navigation Buttons
------------------------------------*/

function krown_nav_buttons( $taxonomy = 'portfolio_category', $page_option = 'krown_folio_page', $project_type = 'default', $class = 'transparent' ){

	// In a future release (not sure about it though) - add option to navigation only between the same categories?!

	/*

	$cats_excluded = array();
	$cats_included = array();

	$cats_all = get_categories( array( 'taxonomy' => $taxonomy ) );

	if( ! empty( $cats_included ) )
		foreach ( $cats_all as $cat ) {
			if ( ! in_array( $cat->slug, $cats_included ) ){
				array_push( $cats_excluded, $cat->cat_ID );
			}
		}

	$cats_excluded = implode( ', ', $cats_excluded );

	*/

	$next_post = krown_get_adjacent_post( false, '', false, $taxonomy );
	$prev_post = krown_get_adjacent_post( false, '', true, $taxonomy );

	$btns_html = '<a class="btn-close" href="' . get_permalink( get_option( $page_option ) ) . '"><span class="front"></span><span class="back close-btn-special"></span></a>';
	$btns_no = 1;

	if ( ! empty( $next_post ) ) {
		$btns_html .= '<a class="btn-prev" href="' . get_permalink( $next_post->ID ) . '" data-slug="' . $next_post->post_name . '" data-title="' . get_the_title( $next_post->ID ) . ' | ' . get_bloginfo( 'name' ) . '" data-type="' . ( $project_type == 'default' ? get_post_meta( $next_post->ID, 'krown_project_type', true ) : $project_type ) . '"></a>';
		$btns_no++;
	}

	if ( ! empty( $prev_post ) ) {
		$btns_html .= '<a class="btn-next" href="' . get_permalink( $prev_post->ID ) . '" data-slug="' . $prev_post->post_name . '" data-title="' . get_the_title( $prev_post->ID ) . ' | ' . get_bloginfo( 'name' ) . '" data-type="' . ( $project_type == 'default' ? get_post_meta( $prev_post->ID, 'krown_project_type', true ) : $project_type ) . '"></a>';
		$btns_no++;
	}

	$html = '<nav class="nav me-buttons btns-' . $btns_no . ' clearfix ' . $class . '"><div class="holder">'. $btns_html . '</div></nav>';

	echo $html;

}

/*---------------------------------
	Share Buttons
------------------------------------*/

function krown_share_buttons( $post_id ){

	$html = '<aside class="share white me-buttons clearfix"><div class="holder">';

	$url = urlencode( get_permalink( $post_id ) );
	$title = urlencode( get_the_title( $post_id ) );
	$media = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'large' );

	$html .= '<a target="_blank" class="btn-twitter" href="https://twitter.com/home?status=' . $title . '+' . $url . '"><span class="front"></span><span class="back"></span></a>';

	$html .= '<a target="_blank" class="btn-facebook" href="https://www.facebook.com/share.php?u=' . $url . '&title=' . $title . '"></a>';

	$html .= '<a target="_blank" class="btn-pinterest" href="http://pinterest.com/pin/create/bookmarklet/?media=' . $media[0] . '&url=' . $url . '&is_video=false&description=' . $title . '"></a>';

	$html .= '<a target="_blank" class="btn-gplus" href="https://plus.google.com/share?url=' . $url . '"></a>';

	$html .= '</div></aside>';

	echo $html;

}

/*---------------------------------
	Additional Functions
------------------------------------*/

function krown_portfolio_the_permalink( $url, $id, $return = false ) {
	if ( ! $return )
		echo $url . ( strpos( $url, '?' ) ? '&' : '?' ) . 'id=' . $id;
	else
		return $url . ( strpos( $url, '?' ) ? '&' : '?' ) . 'id=' . $id;
}

function krown_get_adjacent_post( $in_same_term = false, $excluded_terms = '', $previous = true, $taxonomy = 'category' ) {

	global $post, $wpdb;

	if ( ( ! $post = get_post() ) || ! taxonomy_exists( $taxonomy ) ) 
		return null; 

	$current_post_date = $post->post_date;

	$join = '';
	$posts_in_ex_terms_sql = ''; 
	if ( $in_same_term || ! empty( $excluded_terms ) ) { 
		$join = " INNER JOIN $wpdb->term_relationships AS tr ON p.ID = tr.object_id INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id"; 

		if ( $in_same_term ) {
			if ( ! is_object_in_taxonomy( $post->post_type, $taxonomy ) ) 
				return '';
			$term_array = wp_get_object_terms( $post->ID, $taxonomy, array( 'fields' => 'ids' ) ); 
			$join .= $wpdb->prepare( " AND tt.taxonomy = %s AND tt.term_id IN (" . implode( ',', array_map( 'intval', $term_array ) ) . ")", $taxonomy ); 
		}

		$posts_in_ex_terms_sql = $wpdb->prepare( "AND tt.taxonomy = %s", $taxonomy ); 
		if ( ! empty( $excluded_terms ) ) { 
			if ( ! is_array( $excluded_terms ) ) { 
				if ( false !== strpos( $excluded_terms, ' and ' ) ) { 
					_deprecated_argument( __FUNCTION__, '3.3', sprintf( __( 'Use commas instead of %s to separate excluded terms.' ), "'and'" ), 'krown' ); 
					$excluded_terms = explode( ' and ', $excluded_terms ); 
				} else {
					$excluded_terms = explode( ',', $excluded_terms );
				}
			}

			$excluded_terms = array_map( 'intval', $excluded_terms ); 
				
			if ( ! empty( $term_array ) ) { 
				$excluded_terms = array_diff( $excluded_terms, $term_array );
				$posts_in_ex_terms_sql = ''; 
			}

			if ( ! empty( $excluded_terms ) ) { 
				$posts_in_ex_terms_sql = $wpdb->prepare( " AND tt.taxonomy = %s AND tt.term_id NOT IN (" . implode( $excluded_terms, ',' ) . ')', $taxonomy ); 
			}
		}
	}

	$adjacent = $previous ? 'previous' : 'next';
	$op = $previous ? '<' : '>';
	$order = $previous ? 'DESC' : 'ASC';

	$join  = apply_filters( "get_{$adjacent}_post_join", $join, $in_same_term, $excluded_terms ); 
	$where = apply_filters( "get_{$adjacent}_post_where", $wpdb->prepare( "WHERE p.post_date $op %s AND p.post_type = %s AND p.post_excerpt NOT like 'link' AND p.post_status = 'publish' $posts_in_ex_terms_sql", $current_post_date, $post->post_type), $in_same_term, $excluded_terms ); 
	$sort  = apply_filters( "get_{$adjacent}_post_sort", "ORDER BY p.post_date $order LIMIT 1" );

	$query = "SELECT p.ID FROM $wpdb->posts AS p $join $where $sort"; 
	
	$query_key = 'adjacent_post_' . md5( $query ); 
	$result = wp_cache_get( $query_key, 'counts' ); 
	if ( false !== $result ) {
		if( $result )
			$result = get_post( $result );
		return $result;
	}

	$result = $wpdb->get_var( $query );
	if (null === $result )
		$result = '';

	wp_cache_set( $query_key, $result, 'counts');

	if ( $result ) 
		$result = get_post( $result );

	return $result;

}

?>