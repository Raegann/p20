<?php
/**
 * Plugin Name: Different Themes Shortcodes
 * Plugin URI: http://www.different-themes.com
 * Description: This plugin adds different themes shortcodes.
 * Version: 1.0.0
 * Author: Different Themes
 * Author http://www.different-themes.com
 * License: GPL2
 */

function different_themes_shortcodes_active() {
	return true;
}



require_once( plugin_dir_path(__FILE__).'shortcodes/init.php' );

add_action( 'wp_enqueue_scripts', 'different_themes_shortcodes_js' );

function different_themes_shortcodes_js() {
	wp_enqueue_script("jquery-ui-tabs");
	wp_enqueue_script("jquery-ui-accordion");
	wp_enqueue_script("df-shortcodes" , plugins_url('js/main.js', __FILE__), Array('jquery'), "1.0", true);
	wp_enqueue_script("df-lightbox" , plugins_url('js/jquery-lightbox.js', __FILE__), Array('jquery'), "1.0", true);
}

add_action('wp_enqueue_scripts', 'different_themes_shortcodes_css');

function different_themes_shortcodes_css() {
	wp_enqueue_style("df-shortcodes", plugins_url('css/style.css', __FILE__));
	wp_enqueue_style("fontawesome", plugins_url('css/fontawesome.css', __FILE__));

}

