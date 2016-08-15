<?php 
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    get_header();

    $post_type = get_post_type();
    $sidebarPosition = Different_Themes()->options->get ( THEME_NAME."_sidebar_position" ); 
    $sidebarPositionCustom = get_post_meta ( $post->ID, THEME_NAME."_sidebar_position", true ); 
?>
<?php echo do_shortcode('[foogallery id="'.$post->ID.'"]'); ?>
<?php    
    get_footer();  