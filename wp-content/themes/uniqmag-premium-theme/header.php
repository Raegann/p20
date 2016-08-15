<?php
	$favicon = Different_Themes()->options->get(THEME_NAME."_favicon");
?>
<!DOCTYPE html>
<!-- BEGIN html -->
<html <?php language_attributes(); ?>>
	<!-- BEGIN head -->
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
                
                
                
		<?php wp_head(); ?>
                  
	<!-- END head -->
	</head>
	
	<!-- BEGIN body -->
	<body <?php body_class();?>>

		<?php 
			//background banner
			if(Different_Themes()->options->get(THEME_NAME."_body_image_url") && Different_Themes()->options->get ( THEME_NAME."_body_bg_type" ) == "image") { 
		?>
				<a href="<?php echo esc_url(Different_Themes()->options->get(THEME_NAME."_body_image_url"));?>" target="_blank" id="df_bglink">link</a>
		<?php } ?>
		<?php get_template_part(UNIQMAG_DIFFERENT_THEME_INCLUDES."banners");?>
			<?php get_template_part(UNIQMAG_DIFFERENT_THEME_INCLUDES."top"); ?>