<?php

/*
Plugin Name: Krown Portfolio
Plugin URI: http://demo.krownthemes.com/plugins/krown-portfolio
Description: A simple portfolio post type manager (used in most Krown Themes)
Version: 0.2
Author: Ruben Bristian
Author URI: http://rubenbristian.com
License: GPL
License URI: http://www.gnu.org/copyleft/gpl.html
*/

class KrownPortfolio {

    function __construct() {	

    	$current_theme = wp_get_theme();

    	// if ( $current_theme->name == 'Skybox' ) {
    		require_once( plugin_dir_path( __FILE__ ) . 'includes/gallery.php' );
    		require_once( plugin_dir_path( __FILE__ ) . 'includes/portfolio.php' );
    	// }
		
        add_action( 'init', array( &$this, 'init' ) );

	}
	
	function init() {
		
	}
    
}

new KrownPortfolio();

?>