<?php

/* ------------------------
-----   Accordion    -----
------------------------------*/

if ( ! function_exists( 'krown_accordion_function' ) ) {

	function krown_accordion_function( $atts, $content ){

	    extract( shortcode_atts( array(
	        'el_class'  => '',
	        'type'		=> 'accordion',
	        'opened' 	=> '0'
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
-----   Alert Messages    -----
------------------------------*/

if ( ! function_exists( 'krown_alert_function' ) ) {

	function krown_alert_function( $atts, $content ) { 

	    extract( shortcode_atts( array(
	        'el_class'  => '',
	        'type' 		=> 'info'
	    ), $atts ) );

	    $html = '<div class="krown-alert ' . $type . ( $el_class != '' ? ' ' . $el_class : '' ) . '">';
	    $html .= do_shortcode( $content );

	    $html .= '</div>';
	   
	   return $html;

	}

	add_shortcode( 'krown_alert', 'krown_alert_function' );

}

/* ------------------------
-----   Basic Column  -----
------------------------------*/

if ( ! function_exists( 'krown_column_function' ) ) {

	function krown_column_function($atts, $content){
		
		extract( shortcode_atts( array(
			'el_class'  => '',
			'width' 	=> '1/1'
		), $atts ) );

		$html = '';
		
		if( isset( $atts['el_position'] ) && strpos( $atts['el_position'], 'first') !== false ) {
			$html .= '<div class="krown-column-row clearfix">';
		}

		$html .= '<div class="krown-column-container clearfix ' . ( isset( $atts['el_position'] ) ? $atts['el_position'] . ' ' : '' );

		switch( $width ) {
			case '1/1':
				$html .= 'span12';
				break;
			case '1/2':
				$html .= 'span6';
				break;
			case '1/4':
				$html .= 'span3';
				break;
			case '3/4':
				$html .= 'span9';
				break;
			case '1/3':
				$html .= 'span4';
				break;
			case '2/3':
				$html .= 'span8';
				break;
			default:
				$html .= 'span12';
		}

		$html .= ( $el_class != '' ? ' ' . $el_class : '' ) . ' clearfix">';
		$html .= do_shortcode( $content );
		$html .= '</div>';

		if( isset( $atts['el_position'] ) && strpos( $atts['el_position'], 'last') !== false ) {
			$html .= '</div>';
		}

		return $html;

	}

	add_shortcode( 'krown_column', 'krown_column_function' );

}

/* ------------------------
-----   Buttons    -----
------------------------------*/

if ( ! function_exists( 'krown_button_function' ) ) {

	function krown_button_function( $atts, $content ) { 

	    extract( shortcode_atts( array(
	        'el_class'  => '',
	        'label' 	=> 'Button',
	        'target' 	=> '_blank',
	        'size'		=> 'medium',
	        'url' 		=> '#'
	    ), $atts ) );

	    $html = '<a class="krown-button ' . $size . ($el_class != '' ? ' ' . $el_class : '') . '" href="' . $url . '" target="' . $target . '">' . $label . '</a>';
	   
	   return $html;

	}

	add_shortcode( 'krown_button', 'krown_button_function' );

}

/* ------------------------
-----   Contact Form    -----
------------------------------*/

if ( ! function_exists( 'krown_form_function' ) ) {

	function krown_form_function($atts, $content) { 

	    extract( shortcode_atts( array(
	        'el_class' 		 => '',
	        'label_name'	 => 'Name',
	        'label_email' 	 => 'Email',
	        'label_subject'  => 'Subject',
	        'label_message'  => 'Message',
	        'label_send' 	 => 'Send',
	        'email' 		 => '',
	        'success' 		 => 'Your message was sent!',
	        'error' 		 => 'Complete all the fields'
	    ), $atts ) );

	    $html = '<section class="krown-form' . ( $el_class != '' ? ' ' . $el_class : '' ) . ' clearfix">
	    	<form method="POST" action="' . plugin_dir_url( __FILE__ ) . 'assets/contact-form.php">';

	    	$html .= '
	    		<div class="krown-column-container span4 first">
	    			<label for="name">' . $label_name . '</label>
	    			<input id="name" type="text" name="name" class="name" />
	    		</div>
	    		<div class="krown-column-container span4">
	    			<label for="email">' . $label_email . '</label>
	    			<input id="email" type="email" name="email" class="email" novalidate="" />
	    		</div>
	    		<div class="krown-column-container span4 last">
	    			<label for="subject">' . $label_subject . '</label>
	    			<input id="subject" type="text" name="subject" class="subject" />
	    		</div>
	    		<div class="krown-column-container span12 first last">
	    			<label for="message">' . $label_message . '</label>
	    			<textarea id="message" name="message" class="message"></textarea>
	    		</div>
	    		<input type="text" name="fred" class="fred hidden" value="" />
	        	<input type="submit" class="submit" value="'. $label_send . '" />
	    		<input type="hidden" name="dlo128" class="hidden dlo128" value="' . $email . '" />';

	    $html .= '</form>
	    	<p class="hidden success-message">' . str_replace( "\n", "<br />", $success ) . '</p>
	    	<p class="hidden error-message">' . str_replace( "\n", "<br />", $error ) . '</p>
	    </section>';
	   
	   return $html;

	}

	add_shortcode( 'krown_form', 'krown_form_function' );

}

/* ------------------------
-----   Flickr Feed   -----
------------------------------*/

if ( ! function_exists( 'krown_flickr_function' ) ) {

	function krown_flickr_function( $atts, $content ){

	    extract( shortcode_atts(array(
	        'el_class'  => '',
	        'id' 		=> '52617155@N08',
	        'no' 		=> '15'
	    ), $atts ) );

		$html = '<section class="krown-flickr' . ( $el_class != '' ? ' ' . $el_class : '' ) . '"><ul class="clearfix">';
		$html .= krown_parse_flickr_feed( $id, $no );

		$html .= '</ul></section>';

		return $html;

	}

	add_shortcode( 'krown_flickr', 'krown_flickr_function' );

}

function krown_parse_flickr_feed( $id, $no ) {

	$url = "http://api.flickr.com/services/feeds/photos_public.gne?id={$id}&lang=en-en&format=rss_200";
	$s = file_get_contents( $url );

	preg_match_all('#<item>(.*)</item>#Us', $s, $items);

	$output = "";

	for ( $i = 0; $i < count( $items[1] ); $i++ ) {

		if( $i >= $no ) {
			return $output;
		} 		

		$item = $items[1][$i];
		preg_match_all( '#<link>(.*)</link>#Us', $item, $temp );

		$link = $temp[1][0];
		preg_match_all( '#<title>(.*)</title>#Us', $item, $temp );

		$title = $temp[1][0];
		preg_match_all( '#<media:thumbnail([^>]*)>#Us', $item, $temp );

		$thumb = krown_parse_flickr_attr( $temp[0][0], "url" );

		$output .= "<li><a href='$link' target='_blank' title=\"" . str_replace( '"', '', $title ) . "\"><img alt='$title' src='$thumb'/></a></li>";

	}

	return $output;

}

function krown_parse_flickr_attr( $s, $attrname ) { 

	preg_match_all( '#\s*(' . $attrname . ')\s*=\s*["|\']([^"\']*)["|\']\s*#i', $s, $x );

	if ( count( $x ) >= 3 ) {
		return $x[2][0]; 
	} else { 
		return "";
	}

}

/* ------------------------
-----   Icons    -----
------------------------------*/

if ( ! function_exists( 'krown_icon_function' ) ) {

	function krown_icon_function( $atts, $content ) { 

	    extract( shortcode_atts( array(
	        'size' => 'medium',
	        'type' => 'ok',
	        'color' => 'grey',
	        'break' => 'float',
	        'el_class' => ''
	    ), $atts ) ) ;

	    $html = '<i class="krown-icon-' . $type . ' i-' . $size . ' b-' . $break . ( $el_class != '' ? ' ' . $el_class : '' ) . '" style="color:' . $color . '"></i>';
	   
	   return $html;

	}

	add_shortcode( 'krown_icon', 'krown_icon_function' );

}

/* ------------------------
-----   Promo Box    -----
------------------------------*/

if ( ! function_exists( 'krown_box_function' ) ) {

	function krown_box_function( $atts, $content ) { 

	    extract( shortcode_atts( array(
	        'el_class' => ''
	    ), $atts ) ) ;

	    $html = '<section class="krown-box' . ( $el_class != '' ? ' ' . $el_class : '' ) . ' clearfix">';
	    $html .= do_shortcode( $content );
	    $html .= '</section>';
	   
	   return $html;

	}

	add_shortcode( 'krown_box', 'krown_box_function' );

}

/* ------------------------
-----   Section Title    -----
------------------------------*/

if ( ! function_exists( 'krown_section_title_function' ) ) {

	function krown_section_title_function( $atts ){

	    extract( shortcode_atts( array(
	        'el_class'  => '',
	        'icon' 		=> 'con-none',
	        'title'		=> 'Title',
	        'margin' 	=> '35',
	        'border' 	=> 'true'
	    ), $atts ) );

		$html = '<h3 class="krown-section-title' . ( $el_class != '' ? ' ' . $el_class : '' ) . '">' . $title . '</h3>';

		return $html;

	}

	add_shortcode( 'krown_section_title', 'krown_section_title_function' );

}

/* ------------------------
-----   Social Icons   -----
------------------------------*/

if ( ! function_exists( 'krown_social_function' ) ) {

	function krown_social_function( $atts, $content ){

	    extract(shortcode_atts(array(
	        'el_class'  => '',
	        'target' 	=> '_self'
	    ), $atts ) );

		$html = '<div class="krown-social clearfix' . ( $el_class != '' ? ' ' . $el_class : '' ) . '"><ul>';

		if(isset($atts['twitter']))
			$html .= '<li class="krown-icon-twitter"><a target="' . $target . '" href="' . $atts['twitter'] . '">' . $atts['twitter'] . '</a></li>';
	  
	  	if(isset($atts['facebook']))
	    	$html .= '<li class="krown-icon-facebook-squared"><a target="' . $target . '" href="' . $atts['facebook'] . '">' . $atts['facebook'] . '</a></li>';
	  
		if(isset($atts['dribbble']))
			$html .= '<li class="krown-icon-dribbble"><a target="' . $target . '" href="' . $atts['dribbble'] . '">' . $atts['dribbble'] . '</a></li>';
	  
		if(isset($atts['vimeo']))
			$html .= '<li class="krown-icon-vimeo"><a target="' . $target . '" href="' . $atts['vimeo'] . '">' . $atts['vimeo'] . '</a></li>';
	  
		if(isset($atts['linkedin']))
			$html .= '<li class="krown-icon-linkedin"><a target="' . $target . '" href="' . $atts['linkedin'] . '">' . $atts['linkedin'] . '</a></li>';
	  
		if(isset($atts['behance']))
			$html .= '<li class="krown-icon-behance"><a target="' . $target . '" href="' . $atts['behance'] . '">' . $atts['behance'] . '</a></li>';
	  
		if(isset($atts['pinterest']))
			$html .= '<li class="krown-icon-pinterest"><a target="' . $target . '" href="' . $atts['pinterest'] . '">' . $atts['pinterest'] . '</a></li>';

		if(isset($atts['delicious']))
			$html .= '<li class="krown-icon-delicious"><a target="' . $target . '" href="' . $atts['delicious'] . '">' . $atts['delicious'] . '</a></li>';

		if(isset($atts['digg']))
			$html .= '<li class="krown-icon-digg"><a target="' . $target . '" href="' . $atts['digg'] . '">' . $atts['digg'] . '</a></li>';

		if(isset($atts['youtube']))
			$html .= '<li class="krown-icon-youtube"><a target="' . $target . '" href="' . $atts['youtube'] . '">' . $atts['youtube'] . '</a></li>';

		if(isset($atts['cloud']))
			$html .= '<li class="krown-icon-cloud"><a target="' . $target . '" href="' . $atts['cloud'] . '">' . $atts['cloud'] . '</a></li>';

		if(isset($atts['github']))
			$html .= '<li class="krown-icon-github"><a target="' . $target . '" href="' . $atts['github'] . '">' . $atts['github'] . '</a></li>';

		if(isset($atts['flickr']))
			$html .= '<li class="krown-icon-flickr"><a target="' . $target . '" href="' . $atts['flickr'] . '">' . $atts['flickr'] . '</a></li>';

		if(isset($atts['gplus']))
			$html .= '<li class="krown-icon-gplus"><a target="' . $target . '" href="' . $atts['gplus'] . '">' . $atts['gplus'] . '</a></li>';

		if(isset($atts['tumblr']))
			$html .= '<li class="krown-icon-tumblr"><a target="' . $target . '" href="' . $atts['tumblr'] . '">' . $atts['tumblr'] . '</a></li>';

		if(isset($atts['stumbleupon']))
			$html .= '<li class="krown-icon-stumbleupon"><a target="' . $target . '" href="' . $atts['stumbleupon'] . '">' . $atts['stumbleupon'] . '</a></li>';

		if(isset($atts['lastfm']))
			$html .= '<li class="krown-icon-lastfm"><a target="' . $target . '" href="' . $atts['lastfm'] . '">' . $atts['lastfm'] . '</a></li>';

		if(isset($atts['evernote']))
			$html .= '<li class="krown-icon-evernote"><a target="' . $target . '" href="' . $atts['evernote'] . '">' . $atts['evernote'] . '</a></li>';

		if(isset($atts['picasa']))
			$html .= '<li class="krown-icon-picasa"><a target="' . $target . '" href="' . $atts['picasa'] . '">' . $atts['picasa'] . '</a></li>';

		if(isset($atts['googlecircles']))
			$html .= '<li class="krown-icon-google-circles"><a target="' . $target . '" href="' . $atts['googlecircles'] . '">' . $atts['googlecircles'] . '</a></li>';

		if(isset($atts['skype']))
			$html .= '<li class="krown-icon-skype"><a target="' . $target . '" href="' . $atts['skype'] . '">' . $atts['skype'] .'</a></li>';

		if(isset($atts['mail']))
			$html .= '<li class="krown-icon-mail"><a target="' . $target . '" href="' . $atts['mail'] . '">' .  $atts['mail'] . '</a></li>';

		if(isset($atts['rss']))
			$html .= '<li class="krown-icon-rss"><a target="' . $target . '" href="' . $atts['rss'] . '">' . $atts['rss'] . '</a></li>';

		$html .= '</ul></div>';

		return $html;

	}

	add_shortcode( 'krown_social', 'krown_social_function' );

}

/* ------------------------
-----   Text Block with Icon   -----
------------------------------*/

if ( ! function_exists( 'krown_text_icon_function' ) ) {

	function krown_text_icon_function( $atts, $content ) {

	    extract( shortcode_atts( array(
	        'el_class'  => '',
	        'title' 	=> 'Title',
	        'icon' 		=> ''
	    ), $atts ) );

	    $html = '<div class="krown-text-icon' . ( $el_class != '' ? ' ' . $el_class : '' ) . '">
	        <span class="krown-icon-' . $icon . '"></span>
	        <h3>' . $title . '</h3>
	        <div class="content">' . do_shortcode( $content ) . '</div>
	    </div>';

	    return $html;

	}

	add_shortcode( 'krown_text_icon', 'krown_text_icon_function' );

}

/* ------------------------
-----   Tabs   -----
------------------------------*/

if ( ! function_exists( 'krown_tabs_function' ) ) {

	function krown_tabs_function( $atts, $content ){

	    extract( shortcode_atts( array(
	        'el_class'  => ''
	    ), $atts ) );

	    $html = '<div class="krown-tabs' . ( $el_class != '' ? ' ' . $el_class : '' ) . ' clearfix">';

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
	        'title'  => 'Section'
	    ), $atts ) );

		$html = '<li><h5>' . $title . '</h5></li><!-- cut out --><div>' . do_shortcode( $content ) . '</div><!-- cut out -->';

	    return $html;

	}

	add_shortcode( 'krown_tabs_section', 'krown_tabs_section_function' );

}

/* ------------------------
-----   Tagline   -----
------------------------------*/

if ( ! function_exists( 'krown_tagline_function' ) ) {

	function krown_tagline_function( $atts, $content ){

		extract( shortcode_atts( array(
			'el_class'  => '',
			'title' 	=> '',
			'subtitle'  => ''
		), $atts ) );

		$html = '<div class="krown-tagline clearfix ' . ( empty( $subtitle ) ? 'simple' : 'double' ) . ( $el_class != '' ? ' ' . $el_class : '' ) . '">';

		if ( !empty( $title ) ) {
			$html .= '<h3>' . $title . '</h3>';
		}
		if ( ! empty( $subtitle ) ) {
			$html .= '<h5>' . $subtitle . '</h5>';
		}
		$html .= '</div>';

		return $html;

	}

	add_shortcode( 'krown_tagline', 'krown_tagline_function' );

}

/* ------------------------
-----   Team Member    -----
------------------------------*/

if ( ! function_exists( 'krown_team_function' ) ) {

	function krown_team_function( $atts, $content ) { 

	    extract( shortcode_atts( array(
	        'el_class'  => '',
	        'image' 	=> '',
	        'title'  => '',
	        'subtitle'  => ''
	    ), $atts ) );

	    $html = '<div class="krown-team' . ( $el_class != '' ? ' ' . $el_class : '' ) . ' clearfix">
	    	<img src="' . aq_resize( $image, '400' ) . '" alt="' . $title . '" />
	    	<h4>' . $title . '</h4>
	    	<h5>' . $subtitle . '</h5>
	    	<div class="content">' . do_shortcode( $content ) . '</div>
	    </div>';
	   
	   return $html;

	}

	add_shortcode( 'krown_team', 'krown_team_function' );

}

/* ------------------------
-----   Testimonial    -----
------------------------------*/

if ( ! function_exists( 'krown_testimonial_function' ) ) {

	function krown_testimonial_function( $atts, $content ) { 

	    extract( shortcode_atts( array(
	        'el_class'  => '',
	        'client' 	=> '',
	        'position'  => ''
	    ), $atts ) );

		$html = '<figure class="krown-testimonial' . ( $el_class != '' ? ' ' . $el_class : '' ) . '">
			<blockquote>' . $content . '</blockquote>
			<figcaption><p>' . $client . '</p>
				<span>' . $position . '</span></figcaption>
			</figure>';
	   
	   return $html;

	}

	add_shortcode( 'krown_testimonial', 'krown_testimonial_function' );

}

/* ------------------------
-----   Twitter Feed   -----
------------------------------*/

if ( ! function_exists( 'krown_twitter_function' ) ) {

	function krown_twitter_function( $atts, $content ) {

	    extract( shortcode_atts( array(
	        'el_class' 		 => '',
	        'user' 			 => 'rubenbristian',
	        'no' 			 => '1',
	        'name' 		 	 => 'Ruben Bristian',
	        'avatar' 		 => '',
	        'text_reply' 	 => 'Reply',
	        'text_retweet' 	 => 'Retweet',
	        'text_favorite'  => 'Favorite',
	        'rotate' 		 => 'enabled'
	    ), $atts ) );

	    $html = '';

		if ( function_exists( 'getTweets' ) ) {

			$tweets = getTweets( $user, $no );

		    if ( ! empty ( $tweets['error'] ) ) {

				$html .= '<p>Error (go to Settings > Twitter Feed Auth to resolve this): <span style="color:red; ">' . $tweets['error'] . '</span></p>';

		    } else {

				$html = '<section class="krown-twitter clearfix rot' . $rotate . ( $el_class != '' ? ' ' . $el_class : '' ) . '">
				<a href="https://twitter.com/' . $user . '"><img src="' . $avatar . '" alt="' . $name . '" /></a>
				<a href="https://twitter.com/' . $user . '"><h5>' . $name . '</h5></a>
				<a href="https://twitter.com/' . $user . '"><span>@' . $user . '</span></a>
				  <iframe src="//platform.twitter.com/widgets/follow_button.html?show_screen_name=false&lang=en&show_count=false&screen_name=' . $user . '" style="width:100px; height:24px;"></iframe>
				<ul>';

		    	foreach ( $tweets as $tweet ) {

		    		$html .= '<li>
		    			<p class="body">' . krown_parse_tweet( $tweet['text'] ) . '</p>
		    			<a class="time" href="https://twitter.com/' . $user . '/status/' . $tweet['id_str'] . '">' . date( 'j F o \a\t g:i A', strtotime( $tweet['created_at'] ) ) . '</a>
		    			<div class="intents">
		    				<a class="popup reply" data-name="' . $text_reply . '" data-width="400" data-height="200" href="https://twitter.com/intent/tweet?in_reply_to=' . $tweet['id_str'] . '">' . $text_reply . '</a>
		    				<a class="popup retweet" data-name="' . $text_retweet . '" data-width="400" data-height="200" href="https://twitter.com/intent/retweet?tweet_id=' . $tweet['id_str'] . '">' . $text_retweet . '</a>
		    				<a class="popup favorite" data-name="' . $text_favorite . '" data-width="400" data-height="200" href="https://twitter.com/intent/favorite?tweet_id=' . $tweet['id_str'] . '">' . $text_favorite . '</a>
		    			</div>
		    		</li>';

		    	}

		    }

		} else {

			$html = '<p style="font-weight:bold;">Please install the <a href="http://wordpress.org/plugins/oauth-twitter-feed-for-developers/">oAuth Twitter Feed Plugin</a> and configure it properly for the twitter widget to run. Read more about this in the manual.</p>';

		}

		$html .= '</ul></section>';

		return $html;

	}

	add_shortcode( 'krown_twitter', 'krown_twitter_function' );

}

function krown_parse_tweet( $string ) {

	$content_array = explode( " ", $string );
	$output = '';

	foreach ( $content_array as $content ) {

		if ( substr( $content, 0, 7 ) == "http://" ) {
			$content = '<a href="' . $content . '">' . $content . '</a>';
		}

		//starts with www.
		if ( substr( $content, 0, 4 ) == "www." ) {
			$content = '<a href="http://' . $content . '">' . $content . '</a>';
		}

		if ( substr( $content, 0, 8 ) == "https://" ) {
			$content = '<a href="' . $content . '">' . $content . '</a>';
		}

		if ( substr( $content, 0, 1 ) == "#" ) {
			$content = '<a href="https://twitter.com/search?src=hash&q=' . $content . '">' . $content . '</a>';
		}

		if ( substr( $content, 0, 1 ) == "@" ) {
			$content = '<a href="https://twitter.com/' . $content . '">' . $content . '</a>';
		}

		$output .= " " . $content;

	}

	$output = trim( $output );

	return $output;

}

?>