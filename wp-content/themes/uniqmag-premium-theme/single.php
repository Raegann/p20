<?php 
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	get_header();

	$post_type = get_post_type();
	$sidebarPosition = Different_Themes()->options->get ( THEME_NAME."_sidebar_position" ); 
	$sidebarPositionCustom = get_post_meta ( $post->ID, THEME_NAME."_sidebar_position", true ); 


	if($post_type == UNIQMAG_DIFFERENT_THEME_POST_GALLERY) {
		get_template_part(UNIQMAG_DIFFERENT_THEME_INCLUDES.'gallery-single','style-1');
	} else if($post_type == UNIQMAG_DIFFERENT_THEME_POST_PORTFOLIO) {
		get_template_part(UNIQMAG_DIFFERENT_THEME_INCLUDES.'portfolio-single');
		get_footer();
	} else {
		get_template_part(UNIQMAG_DIFFERENT_THEME_INCLUDES.'news','single');
		get_footer();
	}
	
	
?>