<?php
/*
Plugin Name: Simple Slider
Plugin URI: http://MyWebsiteAdvisor.com/tools/wordpress-plugins/simple-slider/
Description: Simple Slider plugin creates and manages simple image slideshows
Version: 1.2.4
Author: MyWebsiteAdvisor, ChrisHurst
Author URI: http://MyWebsiteAdvisor.com
*/

register_activation_hook(__FILE__, 'simple_slider_activate');



function simple_slider_activate() {

	// display error message to users
	if ($_GET['action'] == 'error_scrape') {                                                                                                   
		die("Sorry, Simple Slider Plugin requires PHP 5.0 or higher. Please deactivate Simple Slider Plugin.");                                 
	}

	if ( version_compare( phpversion(), '5.0', '<' ) ) {
		trigger_error('', E_USER_ERROR);
	}
}

// require simple slider Plugin if PHP 5 installed
if ( version_compare( phpversion(), '5.0', '>=') ) {
	define('SS_LOADER', __FILE__);

	require_once(dirname(__FILE__) . '/simple-slider.php');
	require_once(dirname(__FILE__) . '/plugin-admin.php');
	
	$simple_slider = new Simple_Slider_Admin();
	
	add_shortcode( 'simple_slider', array('Simple_Slider_Admin', 'build_slider') );


}
?>