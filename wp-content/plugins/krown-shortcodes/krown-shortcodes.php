<?php

/*
Plugin Name: Krown Shortcodes
Plugin URI: http://demo.krownthemes.com/plugins/krown-shortcodes
Description: A simple shortcode generator. Add buttons, columns, tabs, toggles and alerts to your theme.
Version: 0.7
Author: Ruben Bristian
Author URI: http://rubenbristian.com
License: GPL
License URI: http://www.gnu.org/copyleft/gpl.html

This plugin was forked from "Zilla Shortcodes" (plugin under GPL license) http://www.themezilla.com/plugins/zillashortcodes/

*/

class KrownShortcodes {

    function __construct() {	

		if ( ! function_exists( 'aq_resize' ) ) {
			require_once( plugin_dir_path( __FILE__ ) . '/assets/aq_resize.php' );
		}

    	$current_theme = wp_get_theme();

    	if ( file_exists( $current_theme->get_template_directory() . '/includes/krown-shortcodes.php' ) ) {
    		include_once( $current_theme->get_template_directory() . '/includes/krown-shortcodes.php' );
    	}

    	require_once( plugin_dir_path( __FILE__ ) . 'shortcodes.php' );

    	define( 'KROWN_TINYMCE_URI', plugin_dir_url( __FILE__ ) . 'tinymce' );
		define( 'KROWN_TINYMCE_DIR', plugin_dir_path( __FILE__ ) . 'tinymce' );
		
        add_action( 'init', array( &$this, 'init' ) );
        add_action( 'admin_init', array( &$this, 'admin_init' ) );

	}
	
	/**
	 * Registers TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function init() {

    	$current_theme = wp_get_theme();

		if( ! is_admin() && ! file_exists( $current_theme->get_template_directory() . '/includes/krown-shortcodes.php' ) ) {

			wp_enqueue_style( 'krown-shortcodes-style', plugin_dir_url( __FILE__ ) . 'assets/shortcodes.css' );
			wp_enqueue_script( 'krown-shortcodes-script', plugin_dir_url( __FILE__ ) . 'assets/shortcodes.js', array( 'jquery' ) );

		}
		
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
			return;
		}
	
		if ( get_user_option( 'rich_editing' ) == 'true' ) {
			add_filter( 'mce_external_plugins', array( &$this, 'add_rich_plugins' ) );
			add_filter( 'mce_buttons', array( &$this, 'register_rich_buttons' ) );

		}

	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Defins TinyMCE rich editor js plugin
	 *
	 * @return	void
	 */
	function add_rich_plugins( $plugin_array ) {
		global $wp_version;

		if ( version_compare( $wp_version, '3.9', '<' ) ) {
			$plugin_array['krownShortcodes'] = KROWN_TINYMCE_URI . '/plugin-old.js';
		} else {
			$plugin_array['krownShortcodes'] = KROWN_TINYMCE_URI . '/plugin.js';
		}
		return $plugin_array;
	}

	function ubl_add_tinymce_button( $buttons ) {
	 
	    array_push( $buttons, shortcodes );
	    return $buttons;
	     
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Adds TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function register_rich_buttons( $buttons ) {
		array_push( $buttons, "|", 'krown_button' );
		return $buttons;
	}
	
	/**
	 * Enqueue Scripts and Styles
	 *
	 * @return	void
	 */
	function admin_init() {

		global $wp_version;

		// css
		wp_enqueue_style( 'krown-popup', KROWN_TINYMCE_URI . '/css/popup.css', false, '1.0', 'all' );
		
		// js
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-livequery', KROWN_TINYMCE_URI . '/js/jquery.livequery.js', false, '1.1.1', false );
		wp_enqueue_script( 'jquery-appendo', KROWN_TINYMCE_URI . '/js/jquery.appendo.js', false, '1.0', false );
		wp_enqueue_script( 'base64', KROWN_TINYMCE_URI . '/js/base64.js', false, '1.0', false );
		wp_enqueue_script( 'krown-popup', KROWN_TINYMCE_URI . '/js/popup.js', false, '1.0', false );
		
		// vars

    	$current_theme = wp_get_theme();
    	
		$shortcodesList = array(
			array( 'Accordion', 'accordion' ),
			array( 'Alert', 'alert' ),
			array( 'Button', 'button' ),
			array( 'Columns', 'columns' ),
			array( 'Contact Form', 'form' ),
			array( 'Flickr Feed', 'flickr' ),
			array( 'Icons', 'icon' ),
			array( 'Promo Box', 'box' ),
			array( 'Social Icons', 'social' ),
			array( 'Tabs', 'tabs' ),
			array( 'Team Member', 'team' ),
			array( 'Testimonial', 'testimonial' ),
			array( 'Twitter Feed', 'twitter' )
		);

		wp_localize_script( 
			'jquery', 
			'krownShortcodes', 
			array( 
				'pluginFolder' => WP_PLUGIN_URL . '/krown-shortcodes/',
				'shortcodesList' => $shortcodesList
			) 
		);

	}
    
}

$krown_shortcodes = new KrownShortcodes();

?>