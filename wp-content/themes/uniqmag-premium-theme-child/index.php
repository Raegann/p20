<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
	$post_type = get_post_type();


	if($post_type == UNIQMAG_DIFFERENT_THEME_POST_GALLERY) {
		get_template_part("template","gallery-1");
	} else if($post_type == UNIQMAG_DIFFERENT_THEME_POST_PORTFOLIO) {
		get_template_part("template","portfolio");
	} else if($post_type == 'action') {
		get_header();
		get_template_part("archive-action");
		get_footer();
	} else if($post_type == 'workingplaces') {
		get_header();
		get_template_part("archive-workingplaces");
		get_footer();
	} else {
		get_header();
		get_template_part("archive");
		get_footer();
	}		
	
?>