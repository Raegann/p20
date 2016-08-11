<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	wp_reset_postdata();
	if(is_category()) {
		$blogStyle = uniqmag_different_themes_get_custom_option( get_cat_id( single_cat_title("",false) ), 'blogStyle', false );
		$sidebar = uniqmag_different_themes_get_custom_option( get_cat_id( single_cat_title("",false) ), 'sidebar_select', false );
	} else if( is_tax() || is_tag() ) {
		$blogStyle = uniqmag_different_themes_get_custom_option( get_queried_object()->term_id, 'blogStyle', false );
		$sidebar = uniqmag_different_themes_get_custom_option( get_queried_object()->term_id, 'sidebar_select', false );
	} else {
		$blogStyle = get_post_meta ( Different_Themes()->page_id(), "_".THEME_NAME."_blogStyle", true ); 	
		$sidebar = get_post_meta( Different_Themes()->page_id(), "_".THEME_NAME.'_sidebar_select', true );
	}

	if(!$blogStyle) {
		$blogStyle = 1;
	}

?>
<?php get_template_part(UNIQMAG_DIFFERENT_THEME_LOOP."loop-start"); ?>
	<?php get_template_part(UNIQMAG_DIFFERENT_THEME_SINGLE."page-title"); ?>

		<?php get_template_part(UNIQMAG_DIFFERENT_THEME_LOOP."post"); ?>

	<?php uniqmag_different_themes_customized_nav_btns($paged, $wp_query->max_num_pages); ?>
<?php get_template_part(UNIQMAG_DIFFERENT_THEME_LOOP."loop-end"); ?>
