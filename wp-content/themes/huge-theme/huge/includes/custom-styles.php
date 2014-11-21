<?php 
/**
 * This file contains the output of the WordPress Theme Customizer (frontend)
 */

if( ! function_exists( 'krown_custom_css' ) ) {

	function krown_custom_css() {

		// Get Options

		$f_head = is_serialized( get_option('krown_type_heading' ) ) ? unserialize( get_option('krown_type_heading' ) ) : array( 'default' => true, 'font-family' => '"Helvetica Neue", Helvetica, Arial, sans-serif' );
		$f_body = is_serialized( get_option( 'krown_type_body' ) ) ? unserialize( get_option( 'krown_type_body' ) ) : array( 'default' => true, 'font-family' => '"Helvetica Neue", Helvetica, Arial, sans-serif' );
		
		$colors = get_option( 'krown_colors' );

		$protocol = is_ssl() ? 'https' : 'http';

		// Enequeue Google Fonts

		if ( ! isset( $f_head['default'] ) ) {
			wp_enqueue_style( 'krown-font-head', "$protocol://fonts.googleapis.com/css?family=" . $f_head['css-name'] . ":300,300italic,400,400italic,600,700,700italic" );
		}

		if ( $f_body != $f_head && !isset( $f_body['default'] ) ) {
			wp_enqueue_style( 'krown-font-body', "$protocol://fonts.googleapis.com/css?family=" . $f_body['css-name'] . ":300,300italic,400,400italic,600,700,700italic" );
		}

		// Create Custom CSS

		$custom_css = '

			/* CUSTOM FONTS */

			h1, h2, h3, h4, h5, h6, #menu li a, .dropcap, .post-format-link a, .post-format-quote {
			  font-family: ' . $f_head['font-family'] . '
			}

			body, input, textarea {
			  font-family: ' . $f_body['font-family'] . '
			}

			/* CUSTOM COLORS */

			#sidebar .button, #sidebar .button:active, .mCS-me-2 .mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar, .mCS-me-2 .mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar, .blog-grid-nav .active {
				background-color: ' . $colors['main2'] . ';
			}
			a:hover, h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover, .post-meta a:hover, .krown-social li:before {
				color: ' . $colors['main2'] . ';
			}
  			.post-format-link a:hover, .me-buttons-alt > a, .krown-accordion h5:hover, .krown-tabs .titles li:hover h5, input[type="submit"], .widget a:hover, .krown-button, .krown-tabs.vertical .titles li:hover h5:before, .krown-twitter li a:hover, .krown-twitter .time:hover, .krown-twitter > a:hover span {
  				color: ' . $colors['main1'] . ';
  			}
  			.me-buttons a, .me-buttons-alt > a, .krown-accordion, .krown-accordion h5, .krown-accordion .opened h5, .krown-tabs .titles li.opened, .krown-tabs .contents, input, textarea, input[type="submit"], .krown-button, .krown-box, .krown-testimonial blockquote:before, .krown-testimonial blockquote, pre, code, tt, .krown-tabs.vertical .titles, .krown-tabs.vertical .titles li, .krown-team .content {
			   border-color: ' . $colors['main3'] . ';
  			}
  			.krown-team h5:before {
  				color: ' . $colors['main3'] . ';
  			}
			.post-format-link a:hover, .widget a:hover {
			   border-color: ' . $colors['main1'] . ';
			}
  			.no-touch .me-buttons a:hover, .no-touch .swiper-nav a:not(.swiper-no):hover, .no-touch .project-horizontal .nav a:hover, .no-touch .me-buttons-alt > a:hover, .mCS-me-2 .mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar, input[type="submit"]:hover, #sidebar .content, .open-close, #sidebar .button:active .open-close, .folio-cube .bottom, .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current, .mejs-controls .mejs-time-rail .mejs-time-current, .mejs-controls .mejs-volume-button .mejs-volume-slider .mejs-volume-current, .gallery-meta .me-buttons a:hover, .krown-button:hover, .video-embedded .mejs-overlay-button:hover, .video-embedded .close-iframe:hover {
			   background-color: ' . $colors['main1'] . ';
			}
			.swiper-nav a, .project-horizontal .nav a, .mCS-me-2 .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, .mejs-overlay:hover .mejs-overlay-button, .fancybox-nav span:hover, .fancybox-close:hover, .gallery-meta .me-buttons a, .gallery-caption, .video-embedded .close-iframe {
			   background-color: ' . $colors['main1'] . ';
			   background-color: ' . krown_hex_to_rgba( $colors['main1'], '.5' ) .';
			}
			.me-buttons.white a:before, .me-buttons.white span:before, .me-buttons.white span:after {
			   color: ' . krown_hex_to_rgba( $colors['main1'], '.6' ) .';
			}
			.no-touch .me-buttons-alt > a:before, .comment-reply-link:hover:before, .krown-accordion h5:hover:before, .krown-tabs.vertical .titles li:hover:before {
				color: ' . $colors['main1'] . ';
			}
			.no-3deffects .folio-item .bottom {
			   background-color: ' . $colors['main2'] . ' !important;
			   background-color: ' . krown_hex_to_rgba( $colors['main2'], '.9' ) . ' !important;
			}

			/* CUSTOM CURSORS */

			.swiper-container {	
			   cursor: -webkit-grab !important;
			   cursor: -moz-grab !important;
			   cursor: url(' . get_template_directory_uri() . '/images/grab.cur), move !important;
			}
			.swiper-container.grabbing {
			   cursor: -webkit-grabbing !important;
			   cursor: -moz-grabbing !important;
			   cursor: url(' . get_template_directory_uri() . '/images/grabbing.cur), move !important;
			}

			/* CUSTOM CSS */

		';

		$custom_css .= ot_get_option( 'krown_custom_css', '' );

		// Embed Custom CSS

		wp_add_inline_style( 'krown-style', $custom_css );

	}

}

add_action( 'wp_enqueue_scripts', 'krown_custom_css', 11 );

// Because of the way the admin bar works, it really breaks the layout of the theme into pieces (it adds bad margin at the top, thus making everything smaller). So we need a bulletproof solution to make sure that the admin bar will not interfer with the user editing (we keep it, but we minimalize it)

if ( ! function_exists( 'krown_custom_admin_bar_hard' ) ) {

	function krown_custom_admin_bar_hard() {

		echo '<style type="text/css">
			html, * html body {
				margin-top: 0 !important;
			}
			#wpadminbar .quicklinks > ul > li, #wpadminbar .quicklinks .ab-top-secondary > li > a, #wpadminbar .quicklinks .ab-top-secondary > li > .ab-empty-item {
				border: none;
			}
			#wpadminbar * {
				color: #fff;
				text-shadow: 0 -1px 0 rgba(0,0,0,.2);
			}	
			#wpadminbar .quicklinks > ul > li > a, #wpadminbar .quicklinks > ul > li > .ab-empty-item, #wpadminbar .quicklinks .ab-top-secondary > li {
				border-color: transparent;
			}
			#wpadminbar {
				background: transparent;
				width: auto;
				min-width: 0;
			}
			#wpadminbar .ab-top-secondary {
				background: none;
			}
			#wp-admin-bar-wp-logo, #wp-admin-bar-top-secondary {
				display: none;
			}
			#wp-admin-bar-site-name {
				margin-left: 0 !important;
			}
			#wpadminbar .menupop .ab-sub-wrapper, #wpadminbar .shortlink-input {
				margin: 0;
				box-shadow: none;
				border-color: transparent;
			}
			#wpadminbar .ab-icon {
				opacity: .5;
			}
		</style>';

	}

}

if ( ! function_exists( 'krown_custom_admin_bar_soft' ) ) {

	function krown_custom_admin_bar_soft() {

		echo '<style type="text/css">
			html, * html body {
				margin-top: 0 !important;
			}';

		if ( get_bloginfo( 'version' ) >= 3.8 ) {
			echo '#wpadminbar {
				background: rgba(0, 0, 0, .5) !important;
				opacity: .8 !important;
				-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=80)" !important;
				filter: alpha(opacity=80) !important;
			}';
		}

		echo '</style>';

	}

}

function krown_handle_admin_bar() {

	if ( is_user_logged_in() && ot_get_option( 'krown_disable_admin_bar', 'disabled' ) == 'enabled' ) {
		add_action( 'wp_head', 'krown_custom_admin_bar_hard', 99 );
	} else if ( is_user_logged_in() ) {
		add_action( 'wp_head', 'krown_custom_admin_bar_soft', 99 );
	}

}

add_action( 'after_setup_theme', 'krown_handle_admin_bar' );

?>