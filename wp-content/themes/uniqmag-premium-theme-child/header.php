<?php
	$favicon = Different_Themes()->options->get(THEME_NAME."_favicon");
?>
<!DOCTYPE html>
<!-- BEGIN html -->
<html <?php language_attributes(); ?>>
	<!-- BEGIN head -->
	<head>
                <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">-->
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
                <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
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