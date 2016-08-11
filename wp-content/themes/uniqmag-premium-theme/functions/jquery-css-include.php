<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	add_action( 'wp_enqueue_scripts', 'uniqmag_different_themes_scripts');


	function uniqmag_different_themes_fonts_url() { 
		$fonts_url = '';
		$fonts_subset = '';


		//font settings	
		$_font_cyrillic_ex = Different_Themes()->options->get(THEME_NAME.'_font_cyrillic_ex');	
		$_font_cyrillic = Different_Themes()->options->get(THEME_NAME.'_font_cyrillic');	
		$_font_greek_ex = Different_Themes()->options->get(THEME_NAME.'_font_greek_ex');	
		$_font_greek = Different_Themes()->options->get(THEME_NAME.'_font_greek');	
		$_font_vietnamese = Different_Themes()->options->get(THEME_NAME.'_font_vietnamese');	
		$_font_latin_ex = Different_Themes()->options->get(THEME_NAME.'_font_latin_ex');	

		if($_font_cyrillic_ex=="on") {
			$fonts_subset.= ",cyrillic-ext";	
		}
		if($_font_cyrillic=="on") {
			$fonts_subset.= ",cyrillic";	
		}
		if($_font_greek_ex=="on") {
			$fonts_subset.= ",greek-ext";	
		}
		if($_font_greek=="on") {
			$fonts_subset.= ",greek";	
		}
		if($_font_vietnamese=="on") {
			$fonts_subset.= ",vietnamese";	
		}
		if($_font_latin_ex=="on") {
			$fonts_subset.= ",latin-ext";	
		}

		//Add all fonts in array
		$font_families = array();
		$font_settings = ':400,700';
		for($i=1; $i<=5; $i++) {
			if(Different_Themes()->options->get(THEME_NAME."_google_font_".$i)) {
				if(Different_Themes()->options->get(THEME_NAME."_google_font_".$i)!="Arial") {
					$font_families[] = Different_Themes()->options->get(THEME_NAME."_google_font_".$i).$font_settings;		
				}
			}
		}
		//remove duplicate fonts
		$font_families = array_unique($font_families);

		//include fonts
		$googleFontUrl = '//fonts.googleapis.com/css';
		$newGoogleFontUrl = add_query_arg( array(
			'family' => urlencode( implode( '|', $font_families ) ),
		    'subset' => urlencode("latin".$fonts_subset),
		), $googleFontUrl );


		return esc_url_raw( $newGoogleFontUrl );	

	}

	function uniqmag_different_themes_scripts() { 
		global $wp_styles,$wp_scripts;
		$slider_enable = Different_Themes()->options->get(THEME_NAME."_slider_enable");
		$responsive = Different_Themes()->options->get(THEME_NAME."_responsive");
		$banner_type = Different_Themes()->options->get ( THEME_NAME."_banner_type" );
		$maintenance_mode_date = Different_Themes()->options->get(THEME_NAME.'_maintenance_mode');  

		wp_enqueue_style( 'different-themes-fonts', uniqmag_different_themes_fonts_url(), array(), null );

		wp_enqueue_style("normalize", UNIQMAG_DIFFERENT_THEME_CSS_URL."normalize.css", Array());
		wp_enqueue_style("fontawesome", UNIQMAG_DIFFERENT_THEME_CSS_URL."fontawesome.css", Array());
		wp_enqueue_style("main-style", UNIQMAG_DIFFERENT_THEME_CSS_URL."style.css", Array());

		wp_enqueue_style("0-responsive", UNIQMAG_DIFFERENT_THEME_CSS_URL."0-responsive.css", Array(),'1.0', '(max-width:767px)');
		wp_enqueue_style("768-responsive", UNIQMAG_DIFFERENT_THEME_CSS_URL."768-responsive.css", Array(),'1.0', '(min-width:768px) and (max-width:1024px)');
		wp_enqueue_style("1025-responsive", UNIQMAG_DIFFERENT_THEME_CSS_URL."1025-responsive.css", Array(),'1.0', '(min-width:1025px) and (max-width:1199px)');
		wp_enqueue_style("1200-responsive", UNIQMAG_DIFFERENT_THEME_CSS_URL."1200-responsive.css", Array(),'1.0', '(min-width:1200px)');
		

		
		
		if($responsive!="on") {
			wp_enqueue_style("no-responsive", UNIQMAG_DIFFERENT_THEME_CSS_URL."no-responsive.css", Array(),'1.0');
		}
		//wp_enqueue_style('ie-only-styles', UNIQMAG_DIFFERENT_THEME_CSS_URL.'ie-ancient.css');
		//$wp_styles->add_data('ie-only-styles', 'conditional', 'lt IE 8');


		if(Different_Themes()->options->get(THEME_NAME."_scriptLoad") != "on") {
			wp_enqueue_style('dynamic-css', admin_url('admin-ajax.php').'?action=different_themes_dynamic_css');
		}

 		wp_enqueue_style("style", get_stylesheet_uri(), Array());

 		// js files
		wp_enqueue_script("jquery-effects-slide");
		wp_enqueue_script("jquery-ui-slider");
		wp_enqueue_script("jquery-ui-accordion");
		wp_enqueue_script("jquery-ui-tabs");
		wp_enqueue_script("jquery-ui-spinner");
		wp_enqueue_script("cookies" , UNIQMAG_DIFFERENT_THEME_JS_URL."admin/jquery.c00kie.js", Array('jquery'), "1.0", true);
		
		if ($banner_type && $banner_type != "off" ) {
			wp_enqueue_script("banner" , UNIQMAG_DIFFERENT_THEME_JS_URL."jquery.floating_popup.1.3.min.js", Array('jquery'), "1.0", true);
		}

		wp_enqueue_script("sticky" , UNIQMAG_DIFFERENT_THEME_JS_URL."jquery-sticky.js", Array('jquery'), '', false);
		wp_enqueue_script("df-lightbox" , UNIQMAG_DIFFERENT_THEME_JS_URL."jquery-lightbox.js", Array('jquery'), '', false);
		wp_enqueue_script("easing" , UNIQMAG_DIFFERENT_THEME_JS_URL."jquery-easing.js", Array('jquery'), '', false);
		wp_enqueue_script("fitvids" , UNIQMAG_DIFFERENT_THEME_JS_URL."jquery-fitvids.js", Array('jquery'), '', false);
		wp_enqueue_script("viewportchecker" , UNIQMAG_DIFFERENT_THEME_JS_URL."jquery-viewportchecker.js", Array('jquery'), '', true);
		wp_enqueue_script("swiper" , UNIQMAG_DIFFERENT_THEME_JS_URL."jquery-swiper.js", Array('jquery'), '', true);
		wp_enqueue_script("magnific" , UNIQMAG_DIFFERENT_THEME_JS_URL."jquery-magnific.js", Array('jquery'), '', true);
		
		if( $maintenance_mode_date == "on" ) {
			wp_enqueue_script("countdown" , UNIQMAG_DIFFERENT_THEME_JS_URL."jquery-countdown.js", Array('jquery'), '', false);
		}

		wp_enqueue_script(UNIQMAG_DIFFERENT_THEME_JS_URL."-scripts" , UNIQMAG_DIFFERENT_THEME_JS_URL."jquery-init.js", Array('jquery'), "", true);

		if ( is_singular() ) wp_enqueue_script( "comment-reply" );

		wp_enqueue_script("df-scripts" , UNIQMAG_DIFFERENT_THEME_JS_URL."scripts.js", Array('jquery'), "1.0", true);
		wp_enqueue_script("scripts-wp" , UNIQMAG_DIFFERENT_THEME_JS_URL.THEME_NAME.".js", Array('jquery'), "1.0.0", true);
		
		if(Different_Themes()->options->get(THEME_NAME."_scriptLoad") != "on" ) {
			wp_enqueue_script("dynamic-scripts" , admin_url('admin-ajax.php').'?action=different_themes_dynamic_js', "1.0", true);
		}

		add_action( 'wp_head', function() {
		   echo '<!--[if lte IE 9]><script src="'.esc_url(UNIQMAG_DIFFERENT_THEME_JS_URL.'shiv.min.js').'"></script><![endif]-->';
		} );
		$post_type = get_post_type();
		if($post_type=="gallery") {
			$gallery_id =get_the_ID();
		} else { 
			$gallery_id = false;
		}
		
		wp_localize_script('jquery','df',
			array(
				'THEME_NAME' => THEME_NAME,
				'THEME_FULL_NAME' => THEME_FULL_NAME,
				'adminUrl' => admin_url("admin-ajax.php"),
				'gallery_id' => $gallery_id,
				'galleryCat' => get_query_var('gallery-cat'),
				'imageUrl' => UNIQMAG_DIFFERENT_THEME_IMAGE_URL,
				'cssUrl' => UNIQMAG_DIFFERENT_THEME_CSS_URL,
				'themeUrl' => UNIQMAG_DIFFERENT_THEME_URL
			)
		);
		
	}
	
?>