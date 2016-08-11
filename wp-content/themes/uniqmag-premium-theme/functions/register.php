<?php

	
function uniqmag_different_themes_register_my_menus() {
	if ( function_exists( 'register_nav_menus' ) ) {
		register_nav_menus(
			array( 
				'top-menu' => esc_html__('Top Menu','uniqmag'),
				'main-menu' => esc_html__('Main Menu','uniqmag'),
				'footer-menu' => esc_html__('Footer Menu','uniqmag'),
			)
		);
	}	
}


add_theme_support( 'post-formats', array( 'video', 'audio', 'gallery' ) );
add_action('init', 'uniqmag_different_themes_register_my_menus' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'title-tag' );
add_theme_support( 'custom-header' ) ;
add_theme_support( 'custom-background' ) ;



?>