<?php
$differentThemes_fields = Different_Themes()->pagebuilder;
$differentThemes_general_options= array(



/* ------------------------------------------------------------------------*
 * HOME SETTINGS
 * ------------------------------------------------------------------------*/   

array(
	"type" => "homepage_blocks",
	"title" => esc_html__("Homepage Blocks:",'uniqmag'),
	"id" => $differentThemes_fields->themeslug."_homepage_blocks",
	/*
	"background_settings" => array(
		"type" => "column_background_settings",
		"title" => esc_html__("Column Background Settings:",'uniqmag'),
		"options" => array(
			array(
				"type" => "select",
				"title" => esc_html__("Background Color:",'uniqmag'),
				"id" => $differentThemes_fields->themeslug."_background_color",
				"options"=>array(
					array("slug"=>"ffffff", "name"=>esc_html__("White",'uniqmag')), 
					array("slug"=>"111", "name"=>esc_html__("Black",'uniqmag')), 
					
				),
				"home" => "yes"
			),
		),
	),
	*/
	"blocks" => array(
		array(
			"title" => esc_html__("Latest,Popular or Category News",'uniqmag'),
			"type" => "homepage_news_block",
			"image" => "icon-article.png",
			"description" => esc_html__("Latest news, category news or popular news post listing, with several layouts",'uniqmag'),
			"options" => array(
				array(
					"type" => "select",
					"title" => esc_html__("Block Style:",'uniqmag'),
					"id" => $differentThemes_fields->themeslug."_style",
					"options"=>array(
						array("slug"=>"1", "name"=>esc_html__("Post List With First Large Image and Small on Right",'uniqmag')), 
						array("slug"=>"7", "name"=>esc_html__("Post List With First Large Image and Other Small ( Category in Top Corner )",'uniqmag')), 
						array("slug"=>"6", "name"=>esc_html__("Post List With First Large Image and Other Small ( Category ar Bottom )",'uniqmag')), 
						array("slug"=>"2", "name"=>esc_html__("Grid Block",'uniqmag')), 
						array("slug"=>"5", "name"=>esc_html__("Grid Block Style 2",'uniqmag')), 
						array("slug"=>"9", "name"=>esc_html__("Grid Block Style 3",'uniqmag')), 
						array("slug"=>"11", "name"=>esc_html__("Grid Block Style 4",'uniqmag')), 
						array("slug"=>"4", "name"=>esc_html__("Post List With Images on Left",'uniqmag')),
						array("slug"=>"3", "name"=>esc_html__("Post List With Small Images on Left",'uniqmag')),
						array("slug"=>"10", "name"=>esc_html__("Large Image in Background",'uniqmag')),
						array("slug"=>"12", "name"=>esc_html__("Main Grid",'uniqmag')), 
						array("slug"=>"8", "name"=>esc_html__("Main Slider 1",'uniqmag')), 
						array("slug"=>"13", "name"=>esc_html__("Main Slider 2",'uniqmag')), 
						array("slug"=>"14", "name"=>esc_html__("Main Slider 3",'uniqmag')), 
						array("slug"=>"15", "name"=>esc_html__("Main Slider 4",'uniqmag')), 

					),
					"home" => "yes"
				),	
				array( "type" => "input", "id" => $differentThemes_fields->themeslug."_title", "title" => esc_html__("Title:",'uniqmag'), "home" => "yes" ),
				array( "type" => "input", "id" => $differentThemes_fields->themeslug."_subtitle", "title" => esc_html__("Subtitle:",'uniqmag'), "home" => "yes" ),
				array( "type" => "scroller", "id" => $differentThemes_fields->themeslug."_count", "title" => esc_html__("Count:",'uniqmag'), "max" => 30, "home" => "yes" ),
				array(
					"type" => "select",
					"title" => esc_html__("Block Type:",'uniqmag'),
					"id" => $differentThemes_fields->themeslug."_type",
					"options"=>array(
						array("slug"=>"1", "name"=>esc_html__("Latest News",'uniqmag')), 
						array("slug"=>"2", "name"=>esc_html__("Popular News",'uniqmag')), 
					),
					"home" => "yes"
				),
				array(
					"type" => "multiple_select",
					"id" => $differentThemes_fields->themeslug."_cat",
					"taxonomy" => "category",
					"title" => esc_html__("Filter by Categories",'uniqmag'),
					"home" => "yes"
				),
				array( "type" => "input", "id" => $differentThemes_fields->themeslug."_offset", "title" => esc_html__("From which post should start the loop (for example 4 ), for default leave it empty, or add 0. (Offset):",'uniqmag'), "home" => "yes" ),
				array( 
					"type" => "color", 
					"id" => $differentThemes_fields->themeslug."_color", 
					"title" => esc_html__("Title Color:",'uniqmag'),
					"std" => "#9c8dc1",
					"home" => "yes"
				),

			),
		),
/*
		array(
			"title" => esc_html__("Shop",'uniqmag'),
			"type" => "homepage_news_block_2",
			"image" => "icon-shop.png",
			"description" => esc_html__("Shop Items",'uniqmag'),
			"options" => array(
				array( "type" => "input", "id" => $differentThemes_fields->themeslug."_title", "title" => esc_html__("Title:",'uniqmag'), "home" => "yes" ),
				array( "type" => "scroller", "id" => $differentThemes_fields->themeslug."_count", "title" => esc_html__("Count:",'uniqmag'), "max" => 30, "home" => "yes" ),
				array(
					"type" => "categories",
					"id" => $differentThemes_fields->themeslug."_cat",
					"taxonomy" => "product_cat",
					"title" => esc_html__("Set Category",'uniqmag'),
					"home" => "yes"
				),
				array( "type" => "input", "id" => $differentThemes_fields->themeslug."_offset", "title" => esc_html__("From which post should start the loop (for example 4 ), for default leave it empty, or add 0. (Offset):",'uniqmag'), "home" => "yes" ),
				array(
					"type" => "select",
					"title" => esc_html__("Type:",'uniqmag'),
					"id" => $differentThemes_fields->themeslug."_type",
					"options"=>array(
						array("slug"=>"1", "name"=>esc_html__("Latest",'uniqmag')), 
						array("slug"=>"2", "name"=>esc_html__("Featured",'uniqmag')), 
					),
					"home" => "yes"
				),	
				
			),
		),

		array(
			"title" => esc_html__("Reviews",'uniqmag'),
			"type" => "homepage_news_block_3",
			"image" => "icon-review.png",
			"description" => esc_html__("Latest/Top reviews.",'uniqmag'),
			"options" => array(

				array( "type" => "input", "id" => $differentThemes_fields->themeslug."_title", "title" => esc_html__("Title:",'uniqmag'), "home" => "yes" ),
				array( "type" => "scroller", "id" => $differentThemes_fields->themeslug."_count", "title" => esc_html__("Count:",'uniqmag'), "max" => 30, "home" => "yes" ),
				array(
					"type" => "select",
					"title" => esc_html__("Block Style:",'uniqmag'),
					"id" => $differentThemes_fields->themeslug."_style",
					"options"=>array(
						array("slug"=>"3", "name"=>esc_html__("Post List With Images on Left",'uniqmag')), 
						array("slug"=>"5", "name"=>esc_html__("Post List With First Large Image and Other Small",'uniqmag')), 
					),
					"home" => "yes"
				),
				array(
					"type" => "multiple_select",
					"id" => $differentThemes_fields->themeslug."_cat",
					"taxonomy" => "category",
					"title" => esc_html__("Filter by Categories",'uniqmag'),
					"home" => "yes"
				),
				array( "type" => "input", "id" => $differentThemes_fields->themeslug."_offset", "title" => esc_html__("From which post should start the loop (for example 4 ), for default leave it empty, or add 0. (Offset):",'uniqmag'), "home" => "yes" ),
				array(
					"type" => "select",
					"title" => esc_html__("Type:",'uniqmag'),
					"id" => $differentThemes_fields->themeslug."_type",
					"options"=>array(
						array("slug"=>"latest", "name"=>esc_html__("Latest Reviews",'uniqmag')), 
						array("slug"=>"top", "name"=>esc_html__("Top Reviews",'uniqmag')), 
					),
					"home" => "yes"
				),				

			),
		),
		*/
		array(
			"title" => esc_html__("Title Block",'uniqmag'),
			"type" => "title_block",
			"image" => "icon-article-cateogry.png",
			"description" => esc_html__("Block Title",'uniqmag'),
			"options" => array(
				array( "type" => "input", "id" => $differentThemes_fields->themeslug."_title", "title" => esc_html__("Title:",'uniqmag'), "home" => "yes" ),
				array( "type" => "input", "id" => $differentThemes_fields->themeslug."_subtitle", "title" => esc_html__("Subtitle:",'uniqmag'), "home" => "yes" ),
				array( 
					"type" => "color", 
					"id" => $differentThemes_fields->themeslug."_color", 
					"title" => esc_html__("Title Color:",'uniqmag'),
					"std" => "#9c8dc1",
					"home" => "yes"
				),
			array( "type" => "input", "id" => $differentThemes_fields->themeslug."_link", "title" => esc_html__("Link:",'uniqmag'), "home" => "yes" ),

			),
		),
		array(
			"title" => esc_html__("Text Block",'uniqmag'),
			"type" => "text_block",
			"image" => "icon-text.png",
			"description" => esc_html__("Custom Text Block/Shortcodes Block",'uniqmag'),
			"options" => array(
				array( "type" => "textarea", "id" => $differentThemes_fields->themeslug."_text", "title" => esc_html__("Text:",'uniqmag'), "editor" => "yes", "home" => "yes" ),
			),
		),
		array(
			"title" => esc_html__("HTML Code",'uniqmag'),
			"type" => "homepage_html",
			"image" => "icon-html.png",
			"description" => esc_html__("Custom HTML/Shortcodes Block",'uniqmag'),
			"options" => array(
				array( "type" => "textarea", "id" => $differentThemes_fields->themeslug."_html", "title" => esc_html__("Code/Text:",'uniqmag'), "home" => "yes" ),
			),
		),
		array(
			"title" => esc_html__("Banner Block",'uniqmag'),
			"type" => "homepage_banner",
			"image" => "icon-banner.png",
			"description" => esc_html__("Supports HTML,CSS, Javascript and Shortcodes.",'uniqmag'),
			"options" => array(
				array( "type" => "textarea", "id" => $differentThemes_fields->themeslug."_banner", "title" => esc_html__("Code/Text:",'uniqmag'), "home" => "yes","sample" => '<a href="http://themeforest.net/user/different-themes/portfolio?ref=different-themes" target="_blank"><img src="'.esc_url(UNIQMAG_DIFFERENT_THEME_IMAGE_URL.'4.jpg').'" alt="Banner"></a>', ),
			),
		),

	)
),


 
 );


$differentThemes_fields->add_options($differentThemes_general_options);
?>