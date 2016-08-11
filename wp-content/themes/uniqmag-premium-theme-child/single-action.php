<?php 
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    get_header();

    $post_type = get_post_type();
    $sidebarPosition = Different_Themes()->options->get ( THEME_NAME."_sidebar_position" ); 
    $sidebarPositionCustom = get_post_meta ( $post->ID, THEME_NAME."_sidebar_position", true ); 
    
   
    
    
   
    get_template_part(UNIQMAG_DIFFERENT_THEME_INCLUDES.'news','single');
    
     
    
    get_footer();