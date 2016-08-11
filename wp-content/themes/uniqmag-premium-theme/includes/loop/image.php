<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	//get post settings
    $df_post = Different_Themes()->posts;

	//blog style
	if(is_category()) {
		$blogStyle = uniqmag_different_themes_get_custom_option( get_cat_id( single_cat_title("",false) ), 'blogStyle', false );
	} else if( is_tax() || is_tag() ) {
		$blogStyle = uniqmag_different_themes_get_custom_option( get_queried_object()->term_id, 'blogStyle', false );
	} else {
		$blogStyle = get_post_meta ( Different_Themes()->page_id(), "_".THEME_NAME."_blogStyle", true ); 	
	}
	if(!$blogStyle) {
		$blogStyle = 1;
	}

	if($blogStyle=="1") {
		$width = 440;
		$height = 275;
		$force = false;
	} else if($blogStyle=="2") {
		$width = 440;
		$height = 275;
		$force = false;
	} else if($blogStyle=="3") {
		$width = 417;
		$height = 300;
		$force = false;
	}  else if($blogStyle=="4") {
		$width = 100;
		$height = 75;
		$force = false;
	}  else if($blogStyle=="5") {
		$width = 450;
		$height = 275;
		$force = true;
	}  else if($blogStyle=="6") {
		$width = 417;
		$height = 300;
		$force = true;
	}



	$audio = get_post_meta( $post->ID, "_".THEME_NAME."_audio", true );
	$slider = get_post_meta ( $post->ID, THEME_NAME."_gallery_images", true ); 	


	if( Different_Themes()->options->get(THEME_NAME."_show_first_thumb") == "on" && $df_post->get_image_html( get_the_ID(), $width, $height, null, null, $force ) ) {
?>
	<a href="<?php the_permalink();?>">
		<?php $df_post->image_html( get_the_ID(), $width, $height, null, null, $force );?>
	</a>

<?php } ?>