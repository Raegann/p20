<?php

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	wp_reset_postdata();
	
        $blogStyle = get_post_meta ( Different_Themes()->page_id(), "_".THEME_NAME."_blogStyle", true ); 	
        $sidebar = get_post_meta( Different_Themes()->page_id(), "_".THEME_NAME.'_sidebar_select', true );


	if(!$blogStyle) {
		$blogStyle = 1;
	}

?>
<?php get_template_part(UNIQMAG_DIFFERENT_THEME_LOOP."loop-start"); ?>
	<?php get_template_part(UNIQMAG_DIFFERENT_THEME_SINGLE."page-title"); ?>

		<?php get_template_part(UNIQMAG_DIFFERENT_THEME_LOOP."post-foogallery"); ?>

	<?php uniqmag_different_themes_customized_nav_btns($paged, $wp_query->max_num_pages); ?>
<?php get_template_part(UNIQMAG_DIFFERENT_THEME_LOOP."loop-end"); ?>
