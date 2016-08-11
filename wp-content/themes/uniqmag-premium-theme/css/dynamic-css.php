<?php
	if(Different_Themes()->options->get(THEME_NAME."_scriptLoad") != "on") {
		header('Content-type: text/css');	
	} 
	function uniqmag_different_themes_custom_style() {
		//banner settings
		$banner_type = Different_Themes()->options->get ( THEME_NAME."_banner_type" );

		//bg type
		$bg_type = Different_Themes()->options->get ( THEME_NAME."_body_bg_type" );
		$bg_color = Different_Themes()->options->get ( THEME_NAME."_body_color" );
		$bg_image = Different_Themes()->options->get ( THEME_NAME."_body_image" );
		$bg_image_repeat = Different_Themes()->options->get ( THEME_NAME."_body_image_repeat" );
		$bg_texture = Different_Themes()->options->get ( THEME_NAME."_body_pattern" );
		if(!$bg_texture) $bg_texture = "texture-1";
		

		//colors
		$color_1 = Different_Themes()->options->get(THEME_NAME."_color_1");
		$color_2 = Different_Themes()->options->get(THEME_NAME."_color_2");
		$color_3 = Different_Themes()->options->get(THEME_NAME."_color_3");


		if(Different_Themes()->options->get(THEME_NAME."_scriptLoad") == "on") {
			echo "<style>";	
		} 

	
?>
/*------------------------------------------------------------------

[Table of contents]

1.	Text color
	Links
	Main navigation hover
	Logo text
	Copyright hover
	Pullquotes
	BLockquotes
	Counter numbers
2.	Background color
	Category link
	Widget tags hover
	Review line
	Post share button
3.	Border color
	Main navigation underline
	Category outline
	Left border for block titles
	Triangle for category icon
	Thumnbnail slider underline
	Blockquiote
	404 Back link
4.	Rating stars color

-------------------------------------------------------------------*/

/*------------------------------------------------------------------
    1. Text color
-------------------------------------------------------------------*/
a,
#cs-top-navigation .cs-top-navigation > li > a:hover,
#cs-logo-brand h1#cs-site-title span,
#cs-copyright a:hover,
.cs-post-category-empty a,
.cs-post-item .cs-post-inner h3 a:hover,
.pullquotes,
blockquote.alt i,
blockquote footer strong,
.cs-countdown-number {
	color: #<?php echo esc_attr($color_1);?>
}

/*------------------------------------------------------------------
    2. Background color
-------------------------------------------------------------------*/
.cs-post-category-solid a,
.widget_tag_cloud .tagcloud a:hover,
#cs-footer .widget_tag_cloud .tagcloud a:hover,
.cs-review-score-line-active,
.cs-single-post-share a,
.author_box .posts,
.cs-reply:hover {
	background-color: #<?php echo esc_attr($color_1);?>
}

/*------------------------------------------------------------------
    3. Border color
-------------------------------------------------------------------*/
#cs-main-navigation .cs-main-navigation > li.current-menu-item > a,
#cs-main-navigation .cs-main-navigation > li:hover > a,
.cs-post-category-border a,
.cs-post-block-title,
.cs-post-item .cs-post-category-icon,
.cs-thumbnail-slider .cs-gallery-thumbs .swiper-slide-active,
blockquote,
.cs-404-page-back-link {
	border-color: #<?php echo esc_attr($color_1);?>
}

/*------------------------------------------------------------------
    4. Rating stars color
-------------------------------------------------------------------*/
.cs-post-meta-rating span:before {
	color: #<?php echo esc_attr($color_1);?>
}

		/* Background Color/Texture/Image */
		body {
			<?php if($bg_type == "color") { ?>
				background: #<?php echo esc_html($bg_color);?>;
			<?php } else if ($bg_type == "pattern") { ?> 
				background: url(<?php echo esc_url(UNIQMAG_DIFFERENT_THEME_IMAGE_URL.$bg_texture.'.png');?>);
			<?php } else if ($bg_type == "image") { ?>
				background-image: url(<?php echo esc_url($bg_image);?>);
				<?php if(!$bg_image_repeat || $bg_image_repeat=="no-repeat") { ?>
					background-attachment: fixed;
					background-size: 100%; 
				<?php } elseif($bg_image_repeat) { ?>
					background-repeat: <?php echo esc_html($bg_image_repeat);?>;
				<?php } ?>
			<?php } else { ?>
				background: #<?php echo esc_html($bg_color);?>;
			<?php } ?>

		}

		<?php
			if ( $banner_type == "image" ) {
			//Image Banner
		?>
				#overlay { width:100%; height:100%; position:fixed;  _position:absolute; top:0; left:0; z-index:1001; background-color:#000000; overflow: hidden;  }
				#popup { display: none; position:absolute; width:auto; height:auto; z-index:1002; color: #000; font-family: Tahoma,sans-serif;font-size: 14px; }
				#baner_close { width: 22px; height: 25px; background: url(<?php echo esc_url(get_template_directory_uri().'/images/close.png');?>) 0 0 repeat; text-indent: -5000px; position: absolute; right: -10px; top: -10px; }
		<?php
			} else if ( $banner_type == "text" ) {
			//Text Banner
		?>
				#overlay { width:100%; height:100%; position:fixed;  _position:absolute; top:0; left:0; z-index:1001; background-color:#000000; overflow: hidden;  }
				#popup { display: none; position:absolute; width:auto; height:auto; max-width:700px; z-index:1002; border: 1px solid #000; background: #e5e5e5 url(<?php echo esc_url(get_template_directory_uri().'/images/dotted-bg-6.png');?>) 0 0 repeat; color: #000; font-family: Tahoma,sans-serif;font-size: 14px; line-height: 24px; border: 1px solid #cccccc; -moz-border-radius: 4px; -webkit-border-radius: 4px; border-radius: 4px; text-shadow: #fff 0 1px 0; }
				#popup center { display: block; padding: 20px 20px 20px 20px; }
				#baner_close { width: 22px; height: 25px; background: url(<?php echo esc_url(get_template_directory_uri().'/images/close.png');?>) 0 0 repeat; text-indent: -5000px; position: absolute; right: -12px; top: -12px; }
		<?php 
			} else if ( $banner_type == "text_image" ) {
			//Image And Text Banner
		?>
				#overlay { width:100%; height:100%; position:fixed;  _position:absolute; top:0; left:0; z-index:1001; background-color:#000000; overflow: hidden;  }
				#popup { display: none; position:absolute; width:auto; z-index:1002; color: #000; font-size: 11px; font-weight: bold; }
				#popup center { padding: 15px 0 0 0; }
				#baner_close { width: 22px; height: 25px; background: url(<?php echo esc_url(get_template_directory_uri().'/images/close.png');?>) 0 0 repeat; text-indent: -5000px; position: absolute; right: -10px; top: -10px; }
		<?php } ?>
	<?php
		if(Different_Themes()->options->get(THEME_NAME."_scriptLoad") == "on") {
			echo "</style>";	
		} 
	?>
<?php } ?>
<?php

	if(Different_Themes()->options->get(THEME_NAME."_scriptLoad") != "on") {
		uniqmag_different_themes_custom_style();	
	} 

?>