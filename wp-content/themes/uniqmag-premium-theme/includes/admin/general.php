<?php
$different_themes_managment = Different_Themes()->themes_management;
$differentThemes_general_options= array(
 array(
	"type" => "navigation",
	"name" => "General",
	"slug" => "general"
),

array(
	"type" => "tab",
	"slug"=>'general'
),

array(
	"type" => "sub_navigation",
	"subname"=>array(
		array("slug"=>"page", "name"=>esc_html__("General",'uniqmag')), 
		array("slug"=>"blog", "name"=>esc_html__("Blog",'uniqmag')),
		array("slug"=>"contact", "name"=>esc_html__("Contact/Footer",'uniqmag')),
		array("slug"=>"banner_settings", "name"=>esc_html__("Banners",'uniqmag'))
	)
),

/* ------------------------------------------------------------------------*
 * PAGE SETTINGS
 * ------------------------------------------------------------------------*/

 array(
	"type" => "sub_tab",
	"slug"=>'page'
),
 array(
	"type" => "row"
),

array(
	"type" => "homepage_set_test",
	"title" => "Set up Your Homepage and post page!",
	"desc" => "	<p><b>You have not selected the correct template page for homepage.</b></p>
	<p>Please make sure, you choose template \"Drag & Drop Page Builder\".</p>
	<br/>
	<ul>
		<li>Current front page: <a href='".esc_url(get_permalink(get_option('page_on_front')))."'>".get_the_title(get_option('page_on_front'))."</a></li>
		<li>Current blog page: <a href'".esc_url(get_permalink(get_option('page_for_posts')))."'>".get_the_title(get_option('page_for_posts'))."</a></li>
	</ul>",
	"desc_2" => "<p><b>You have NOT enabled homepage.</b></p>
	<p>To use custom homepage, you must first create two <a href='".esc_url(home_url('/'))."/wp-admin/post-new.php?post_type=page'>new pages</a>, and one of them assign to \"<b>Homepage</b>\" template.Give each page a title, but avoid adding any text.</p>
	<p>Then enable homepage  in <a href='".esc_url(home_url('/'))."/wp-admin/options-reading.php'>wordpress reading settings</a> (See \"Front page displays\" option). Select your previously created pages from both dropdowns and save changes.</p>"
),
array(
	"type" => "close"
),


array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => esc_html__("Load dynamic js/css files directly in header",'uniqmag'),
),

array(
	"type" => "checkbox",
	"id"=>$different_themes_managment->themeslug."_scriptLoad",
	"options" => array(
		array("title" => esc_html__("Load in Header (this improves your page speed on some servers, but it depends on server configuration):",'uniqmag'), "value" => "on")
	)
),
   
array(
	"type" => "checkbox",
	"options" => array(
		array("title" => esc_html__("Allow to Output JavaScript and All HTML tags in Dynamic Data in Theme:",'uniqmag'), "value" => "on")
	),
	"id"=>$different_themes_managment->themeslug."_javaScriptOut"
),
   

array(
	"type" => "close"
), 
array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => esc_html__("Add logo image",'uniqmag')
),
   
array(
	"type" => "upload",
	"title" => esc_html__("Add Header Logo Image",'uniqmag'),
	"info" => esc_html__("Suggested image size is 200x50px",'uniqmag'),
	"id" => $different_themes_managment->themeslug."_logo",
),      

array(
	"type" => "close"
),


array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => esc_html__("Theme Auto Update Needed Details",'uniqmag')
),

array(
	"type" => "input",
	"title" => esc_html__("Themeforest Username:",'uniqmag'),
	"id" => $different_themes_managment->themeslug."_user_name"
),

array(
	"type" => "input",
	"title" => esc_html__("Themeforest API key:",'uniqmag'),
	"info" => esc_html__("You can get the API key here: https://build.envato.com/my-apps/",'uniqmag'),
	"id" => $different_themes_managment->themeslug."_api_key"
),
array(
	"type" => "input",
	"title" => esc_html__(THEME_FULL_NAME." Purchase Code:",'uniqmag'),
	"info" => esc_html__("You can get it in themeforest download section",'uniqmag'),
	"id" => $different_themes_managment->themeslug."_purchase_key"
),

array(
	"type" => "close"
),
/*
 array(
	"type" => "row"
),
array(
	"type" => "select",
	"title" => "Page Name Style",
	"info" => esc_html__("Works only if you leave the logo image field empty.",'uniqmag'),
	"id" => $different_themes_managment->themeslug."_subcount",
	"options"=>array(
		array("slug"=>"0", "name"=> esc_html__("None character in theme color scheme color",'uniqmag')), 
		array("slug"=>"1", "name"=>esc_html__("1 character in theme color scheme color",'uniqmag')),
		array("slug"=>"2", "name"=>esc_html__("2 characters in theme color scheme color",'uniqmag')),
		array("slug"=>"3", "name"=>esc_html__("3 characters in theme color scheme color",'uniqmag')),
		array("slug"=>"4", "name"=>esc_html__("4 characters in theme color scheme color",'uniqmag')),
		array("slug"=>"5", "name"=>esc_html__("5 characters in theme color scheme color",'uniqmag')),
		array("slug"=>"6", "name"=>esc_html__("6 characters in theme color scheme color",'uniqmag')),
		array("slug"=>"7", "name"=>esc_html__("7 characters in theme color scheme color",'uniqmag')),
		array("slug"=>"8", "name"=>esc_html__("8 characters in theme color scheme color",'uniqmag')),
		array("slug"=>"9", "name"=>esc_html__("9 characters in theme color scheme color",'uniqmag')),
		array("slug"=>"10", "name"=>esc_html__("10 characters in theme color scheme color",'uniqmag')),
		),
	"std" => "4"
),
array(
	"type" => "close"
),
*/
 array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => esc_html__("Export/Import Theme Settings",'uniqmag')
),
   
array(
	"type" => "export_content",
	"title" => esc_html__("Export Settings",'uniqmag'),
	"section" => "management",
	"id" => $different_themes_managment->themeslug."_export"
),      
   
array(
	"type" => "import_content",
	"title" => esc_html__("Import Settings",'uniqmag'),
	"section" => "management",
	"id" => $different_themes_managment->themeslug."_import"
),      

array(
	"type" => "close"
),  

array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => esc_html__("Unit Settings",'uniqmag'),
),

array(
	"type" => "checkbox",
	"options" => array(
		array("title" => esc_html__("Show Search In Main Menu:",'uniqmag'), "value" => "on")
	),
	"id"=>$different_themes_managment->themeslug."_search"
),

array(
	"type" => "checkbox",
	"options" => array(
		array("title" => esc_html__("Hide Duplicate Posts On Homepage:",'uniqmag'), "value" => "on")
	),
	"id"=>$different_themes_managment->themeslug."_duplicate"
),
   

array(
	"type" => "close"
),

/*
array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => esc_html__("Weather Forecast",'uniqmag'),
),

array(
	"type" => "checkbox",
	"options" => array(
		array("title" => esc_html__("Show Weather Forecast:",'uniqmag'), "value" => "on")
	),
	"id"=>$different_themes_managment->themeslug."_weather",
),

array(
	"type" => "title",
	"title" => "Temperature Type",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_weather", "value" => "on")
	)
),
array(
	"type" => "radio",
	"id" => $different_themes_managment->themeslug."_temperature",
	"radio" => array(
		array("title" => esc_html__("Show Temperature In C:",'uniqmag'), "value" => "C"),
		array("title" => esc_html__("Show Temperature In F:",'uniqmag'), "value" => "F")
	),
	"std" => "C",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_weather", "value" => "on")
	)
),
array(
	"type" => "title",
	"title" => "API type",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_weather", "value" => "on")
	)
),

array(
	"type" => "radio",
	"id" => $different_themes_managment->themeslug."_weather_api_key_type",
	"radio" => array(
		array("title" => esc_html__("Free API Key:",'uniqmag'), "value" => "free"),
		array("title" => esc_html__("Premium API Key:",'uniqmag'), "value" => "premium")
	),
	"std" => "free",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_weather", "value" => "on")
	)
),
array(
	"type" => "title",
	"title" => "Location",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_weather", "value" => "on")
	)
),

array(
	"type" => "radio",
	"id" => $different_themes_managment->themeslug."_weather_location_type",
	"radio" => array(
		array("title" => esc_html__("Search For Customer Location:",'uniqmag'), "value" => "customer"),
		array("title" => esc_html__("Set Your Own Custom Location:",'uniqmag'), "value" => "custom")
	),
	"std" => "customer",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_weather", "value" => "on")
	)
),
array(
	"type" => "input",
	"title" => esc_html__("City Name, Country",'uniqmag'),
	"info" => esc_html__("Example - London,United Kingdom",'uniqmag'),
	"id" => $different_themes_managment->themeslug."_weather_city",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_weather_location_type", "value" => "custom")
	)
),

array(
	"type" => "input",
	"title" => esc_html__("API Key",'uniqmag'),
	"info" => esc_html__("The API Key You Can Get Here:",'uniqmag')." <a href='https://developer.worldweatheronline.com/auth/register' style='color:#fff' target='_blank'>".esc_html__("Register API Key",'uniqmag')."</a>",
	"id" => $different_themes_managment->themeslug."_weather_api",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_weather", "value" => "on")
	)
),


array(
	"type" => "close"
),
*/

array(
	"type" => "row"
),
array(
	"type" => "title",
	"title" => esc_html__("Show Breadcrumb",'uniqmag'),
),

array(
	"type" => "checkbox",
	"options" => array(
		array("title" => esc_html__("Show Breadcrumb:",'uniqmag'), "value" => "on")
	),
	"id"=>$different_themes_managment->themeslug."_breadcrumb"
),
array(
	"type" => "close"
),

array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => esc_html__("Maintenance Mode",'uniqmag'),
),

array(
	"type" => "checkbox",
	"options" => array(
		array("title" => esc_html__("Enable Maintenance Mode:",'uniqmag'), "value" => "on")
	),
	"id"=>$different_themes_managment->themeslug."_maintenance_mode"
),
array(
	"type" => "datepicker",
	"title" => esc_html__("Maintenance Mode End:",'uniqmag'),
	"id"=>$different_themes_managment->themeslug."_maintenance_mode_date"
),



array(
	"type" => "close"
),

array(
	"type" => "save",
	"title" => esc_html__("Save Changes",'uniqmag'),
),
   
array(
	"type" => "closesubtab"
),

/* ------------------------------------------------------------------------*
 * BLOG SETTINGS
 * ------------------------------------------------------------------------*/   
  
array(
	"type" => "sub_tab",
	"slug"=>'blog'
),

array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => esc_html__("Unit Settings",'uniqmag'),
),

array(
	"type" => "checkbox",
	"options" => array(
		array("title" => esc_html__("Show thumbnails in blog post list:",'uniqmag'), "value" => "on")
	),
	"id"=>$different_themes_managment->themeslug."_show_first_thumb",
),

array(
	"type" => "checkbox",
	"options" => array(
		array("title" => esc_html__("Show placeholder thumbnail, when no thumbnail is available:",'uniqmag'), "value" => "on")
	),
	"id"=>$different_themes_managment->themeslug."_show_no_image_thumb"
),
array(
	"type" => "close"
),
array(
	"type" => "row"
),
array(
	"type" => "title",
	"title" => esc_html__("Show thumbnail in open post/page",'uniqmag')
),

array(
	"type" => "radio",
	"id" => $different_themes_managment->themeslug."_show_single_thumb",
	"radio" => array(
		array("title" => esc_html__("Show:",'uniqmag'), "value" => "1"),
		array("title" => esc_html__("Hide:",'uniqmag'), "value" => "2"),
		array("title" => esc_html__("Custom For Each Post:",'uniqmag'), "value" => "custom")
	),
	"std" => "custom"
),

array(
	"type" => "close"
),
array(
	"type" => "row"
),
array(
	"type" => "title",
	"title" => esc_html__("Post/Page Image PopUp View",'uniqmag')
),

array(
	"type" => "radio",
	"id" => $different_themes_managment->themeslug."_imagePopUp",
	"radio" => array(
		array("title" => esc_html__("Yes:",'uniqmag'), "value" => "1"),
		array("title" => esc_html__("No:",'uniqmag'), "value" => "2"),
		array("title" => esc_html__("Custom For Each Post:",'uniqmag'), "value" => "custom")
	),
	"std" => "custom"
),

array(
	"type" => "close"
),


array(
	"type" => "row"
),
array(
	"type" => "title",
	"title" => esc_html__("Show Post Title In Single Post/Page",'uniqmag')
),

array(
	"type" => "radio",
	"id" => $different_themes_managment->themeslug."_show_single_title",
	"radio" => array(
		array("title" => esc_html__("Show:",'uniqmag'), "value" => "1"),
		array("title" => esc_html__("Hide:",'uniqmag'), "value" => "2"),
		array("title" => esc_html__("Custom For Each Post:",'uniqmag'), "value" => "custom")
	),
	"std" => "custom"
),

array(
	"type" => "close"
),
/*
array(
	"type" => "row"
),
array(
	"type" => "title",
	"title" => esc_html__("Show Post Views",'uniqmag')
),

array(
	"type" => "radio",
	"id" => $different_themes_managment->themeslug."_postViews",
	"radio" => array(
		array("title" => esc_html__("Show:",'uniqmag'), "value" => "1"),
		array("title" => esc_html__("Hide:",'uniqmag'), "value" => "2"),
		array("title" => esc_html__("Custom For Each Post:",'uniqmag'), "value" => "custom")
	),
	"std" => "custom"
),

array(
	"type" => "close"
),
*/
array(
	"type" => "row"
),
array(
	"type" => "title",
	"title" => esc_html__("Show Post Controls",'uniqmag')
),

array(
	"type" => "radio",
	"id" => $different_themes_managment->themeslug."_postControls",
	"radio" => array(
		array("title" => esc_html__("Show:",'uniqmag'), "value" => "1"),
		array("title" => esc_html__("Hide:",'uniqmag'), "value" => "2"),
		array("title" => esc_html__("Custom For Each Post:",'uniqmag'), "value" => "custom")
	),
	"std" => "custom"
),

array(
	"type" => "close"
),
array(
	"type" => "row"
),
array(
	"type" => "title",
	"title" => esc_html__("Show Post Author",'uniqmag')
),

array(
	"type" => "radio",
	"id" => $different_themes_managment->themeslug."_postAuthor",
	"radio" => array(
		array("title" => esc_html__("Show:",'uniqmag'), "value" => "1"),
		array("title" => esc_html__("Hide:",'uniqmag'), "value" => "2"),
		array("title" => esc_html__("Custom For Each Post:",'uniqmag'), "value" => "custom")
	),
	"std" => "custom"
),

array(
	"type" => "close"
),


array(
	"type" => "row"
),
array(
	"type" => "title",
	"title" => esc_html__("Show Post Date",'uniqmag')
),

array(
	"type" => "radio",
	"id" => $different_themes_managment->themeslug."_postDate",
	"radio" => array(
		array("title" => esc_html__("Show:",'uniqmag'), "value" => "1"),
		array("title" => esc_html__("Hide:",'uniqmag'), "value" => "2"),
		array("title" => esc_html__("Custom For Each Post:",'uniqmag'), "value" => "custom")
	),
	"std" => "custom"
),

array(
	"type" => "close"
),

array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => esc_html__("Show Categories",'uniqmag')
),

array(
	"type" => "radio",
	"id" => $different_themes_managment->themeslug."_postCategory",
	"radio" => array(
		array("title" => esc_html__("Show:",'uniqmag'), "value" => "1"),
		array("title" => esc_html__("Hide:",'uniqmag'), "value" => "2"),
		array("title" => esc_html__("Custom For Each Post:",'uniqmag'), "value" => "custom")
	),
	"std" => "custom"
),

array(
	"type" => "close"
),
array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => esc_html__("Show Post Icon ( Except Grid View Style 4 )",'uniqmag')
),

array(
	"type" => "radio",
	"id" => $different_themes_managment->themeslug."_post_icons",
	"radio" => array(
		array("title" => esc_html__("Show:",'uniqmag'), "value" => "1"),
		array("title" => esc_html__("Hide:",'uniqmag'), "value" => "2"),
		array("title" => esc_html__("Custom For Each Post:",'uniqmag'), "value" => "custom")
	),
	"std" => "custom"
),

array(
	"type" => "close"
),
/*
array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => esc_html__("Show Tags In Single Post",'uniqmag')
),

array(
	"type" => "radio",
	"id" => $different_themes_managment->themeslug."_post_tag_single",
	"radio" => array(
		array("title" => esc_html__("Show:",'uniqmag'), "value" => "1"),
		array("title" => esc_html__("Hide:",'uniqmag'), "value" => "2"),
		array("title" => esc_html__("Custom For Each Post:",'uniqmag'), "value" => "custom")
	),
	"std" => "custom"
),

array(
	"type" => "close"
),
*/
array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => esc_html__("Show \"About Author\" In Single Post",'uniqmag')
),

array(
	"type" => "radio",
	"id" => $different_themes_managment->themeslug."_aboutPostAuthor",
	"radio" => array(
		array("title" => esc_html__("Show:",'uniqmag'), "value" => "1"),
		array("title" => esc_html__("Hide:",'uniqmag'), "value" => "2"),
		array("title" => esc_html__("Custom For Each Post:",'uniqmag'), "value" => "custom")
	),
	"std" => "custom"
),

array(
	"type" => "close"
),
array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => esc_html__("Show \"Similar News\" In Single Post",'uniqmag')
),

array(
	"type" => "radio",
	"id" => $different_themes_managment->themeslug."_similar_posts",
	"radio" => array(
		array("title" => esc_html__("Show:",'uniqmag'), "value" => "1"),
		array("title" => esc_html__("Hide:",'uniqmag'), "value" => "2"),
		array("title" => esc_html__("Custom For Each Post:",'uniqmag'), "value" => "custom")
	),
	"std" => "custom"
),


array(
	"type" => "close"
),



array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => esc_html__("Show Share Buttons",'uniqmag')
),

array(
	"type" => "radio",
	"id" => $different_themes_managment->themeslug."_share_buttons",
	"radio" => array(
		array("title" => esc_html__("Show:",'uniqmag'), "value" => "1"),
		array("title" => esc_html__("Hide:",'uniqmag'), "value" => "2"),
		array("title" => esc_html__("Custom For Each Post/Page:",'uniqmag'), "value" => "custom")
	),
	"std" => "custom"
),

array(
	"type" => "close"
),

array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => esc_html__("Show Post Comment Count",'uniqmag')
),

array(
	"type" => "radio",
	"id" => $different_themes_managment->themeslug."_postComments",
	"radio" => array(
		array("title" => esc_html__("Show:",'uniqmag'), "value" => "1"),
		array("title" => esc_html__("Hide:",'uniqmag'), "value" => "2"),
		array("title" => esc_html__("Custom For Each Post:",'uniqmag'), "value" => "custom")
	),
	"std" => "custom"
),

array(
	"type" => "close"
),

array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => esc_html__("Show Post Icons",'uniqmag')
),

array(
	"type" => "radio",
	"id" => $different_themes_managment->themeslug."_post_icon",
	"radio" => array(
		array("title" => esc_html__("Show:",'uniqmag'), "value" => "1"),
		array("title" => esc_html__("Hide:",'uniqmag'), "value" => "2"),
		array("title" => esc_html__("Custom For Each Post:",'uniqmag'), "value" => "custom")
	),
	"std" => "custom"
),

array(
	"type" => "close"
),

array(
	"type" => "save",
	"title" => esc_html__("Save Changes",'uniqmag')
),

array(
	"type" => "closesubtab"
),


/* ------------------------------------------------------------------------*
 * CONTACT SETTINGS
 * ------------------------------------------------------------------------*/   

array(
	"type" => "sub_tab",
	"slug"=>'contact'
),
/*
array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => esc_html__("Social Account Icons In Header",'uniqmag')
),

array(
	"type" => "input",
	"title" => esc_html__("Facebook Account Url:",'uniqmag'),
	"id" => $different_themes_managment->themeslug."_facebook"

),
array(
	"type" => "input",
	"title" => esc_html__("Twitter Account Url:",'uniqmag'),
	"id" => $different_themes_managment->themeslug."_twitter"
),
array(
	"type" => "input",
	"title" => esc_html__("LinkedIn Account Url:",'uniqmag'),
	"id" => $different_themes_managment->themeslug."_linkedin"
),
array(
	"type" => "input",
	"title" => esc_html__("Instagram Account Url:",'uniqmag'),
	"id" => $different_themes_managment->themeslug."_instagram",
),
array(
	"type" => "input",
	"title" => esc_html__("Youtube Account Url:",'uniqmag'),
	"id" => $different_themes_managment->themeslug."_youtube",
),

array(
	"type" => "input",
	"title" => esc_html__("Google+ Account Url:",'uniqmag'),
	"id" => $different_themes_managment->themeslug."_google",
),

array(
	"type" => "close"
),
*/
array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => esc_html__("Twitter Account",'uniqmag')
),

array(
	"type" => "input",
	"title" => esc_html__("Twitter Account Name:",'uniqmag'),
	"id" => $different_themes_managment->themeslug."_twitter_name"
),

array(
	"type" => "close"
),

array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => esc_html__("Footer CopyRight",'uniqmag'),
),

array(
	"type" => "textarea",
	"title" => esc_html__("Text:",'uniqmag'),
	"id" => $different_themes_managment->themeslug."_copyright"
),

array(
	"type" => "close"
),


array(
	"type" => "save",
	"title" => esc_html__("Save Changes",'uniqmag'),
),

array(
	"type" => "closesubtab"
),


/* ------------------------------------------------------------------------*
 * GALLERY SETTINGS
 * ------------------------------------------------------------------------*/   

array(
	"type" => "gallery_tab",
	"id" => $different_themes_managment->themeslug
),

array(
	"type" => "just_for_save",
	"id" => $different_themes_managment->themeslug."_gallery_items"
),
array(
	"type" => "just_for_save",
	"id" => $different_themes_managment->themeslug."_similar_posts_gallery"
),


/* ------------------------------------------------------------------------*
 * BANNER SETTINGS
 * ------------------------------------------------------------------------*/   

array(
	"type" => "sub_tab",
	"slug"=>'banner_settings'
),

array(
	"type" => "row",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_header_style", "value" => "1")
	)
),

array(
	"type" => "title",
	"title" => esc_html__("Header Banner",'uniqmag'),
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_header_style", "value" => "1")
	)
),

array(
	"type" => "checkbox",
	"options" => array(
		array("title" => esc_html__("Enable Banner",'uniqmag'), "value" => "on")
	),
	"id" => $different_themes_managment->themeslug."_top_banner",
	"std" => "off",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_header_style", "value" => "1")
	)
),
array(
	"type" => "row",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_header_style", "value" => "2")
	)
),

array(
	"type" => "title",
	"title" => esc_html__("Header Banner",'uniqmag'),
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_header_style", "value" => "2")
	)
),

array(
	"type" => "checkbox",
	"options" => array(
		array("title" => esc_html__("Enable Banner",'uniqmag'), "value" => "on")
	),
	"id" => $different_themes_managment->themeslug."_top_banner",
	"std" => "off",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_header_style", "value" => "2")
	)
),

array(
	"type" => "row",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_header_style", "value" => "3")
	)
),

array(
	"type" => "title",
	"title" => esc_html__("Header Banner",'uniqmag'),
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_header_style", "value" => "3")
	)
),

array(
	"type" => "checkbox",
	"options" => array(
		array("title" => esc_html__("Enable Banner",'uniqmag'), "value" => "on")
	),
	"id" => $different_themes_managment->themeslug."_top_banner",
	"std" => "off",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_header_style", "value" => "3")
	)
),

array(
	"type" => "textarea",
	"title" => esc_html__("Banner HTML Code",'uniqmag'),
	"sample" => '<a href="http://www.different-themes.com" target="_blank"><img src="'.esc_url(UNIQMAG_DIFFERENT_THEME_IMAGE_URL.'1.jpg').'" alt="" title="" /></a>',
	"id" => $different_themes_managment->themeslug."_top_banner_code",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_header_style", "value" => "1")
	)
),

array(
	"type" => "textarea",
	"title" => esc_html__("Banner HTML Code",'uniqmag'),
	"sample" => '<a href="http://www.different-themes.com" target="_blank"><img src="'.esc_url(UNIQMAG_DIFFERENT_THEME_IMAGE_URL.'1.jpg').'" alt="" title="" /></a>',
	"id" => $different_themes_managment->themeslug."_top_banner_code",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_header_style", "value" => "2")
	)
),

array(
	"type" => "textarea",
	"title" => esc_html__("Banner HTML Code",'uniqmag'),
	"sample" => '<a href="http://www.different-themes.com" target="_blank"><img src="'.esc_url(UNIQMAG_DIFFERENT_THEME_IMAGE_URL.'1.jpg').'" alt="" title="" /></a>',
	"id" => $different_themes_managment->themeslug."_top_banner_code",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_header_style", "value" => "3")
	)
),

array(
	"type" => "close",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_header_style", "value" => "1")
	)
),
array(
	"type" => "close",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_header_style", "value" => "2")
	)
),
array(
	"type" => "close",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_header_style", "value" => "3")
	)
),
/*
array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => esc_html__("Custom HTML Under Main Menu",'uniqmag')
),

array(
	"type" => "textarea",
	"title" => esc_html__("HTML Code",'uniqmag'),
	"sample" => '<span>Custom links here:</span><a href="#">Google Adsense</a><a href="#">Cheap laptops and netbooks</a><a href="#">lpad, Laptops &amp; Books</a><a href="#">Cheapest Cell Phones</a><a href="#">Buy Quality HP laptops</a>',
	"id" => $different_themes_managment->themeslug."_custom_html",
),

array(
	"type" => "close"
),
*/
array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => esc_html__("Select Pop Up Banner Type",'uniqmag'),
),

array(
	"type" => "radio",
	"id" => $different_themes_managment->themeslug."_banner_type",
	"radio" => array(
		array("title" => "Off", "value" => "off"),
		array("title" => "Banner With Image", "value" => "image"),
		array("title" => "Banner With Text Or HTML Code", "value" => "text"),
		array("title" => "Banner With Image &amp; Text", "value" => "text_image")
	),
	"std" => "off"
),

array(
	"type" => "upload",
	"title" => "Add Banner Image",
	"id" => $different_themes_managment->themeslug."_banner_image",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_banner_type", "value" => "image")
	)
),

array(
	"type" => "textarea",
	"title" => "Banner content",
	"info" => "You can copy also some HTML code here.",
	"id" => $different_themes_managment->themeslug."_banner_text",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_banner_type", "value" => "text")
	)
),

array(
	"type" => "upload",
	"title" => "Add Banner Image",
	"id" => $different_themes_managment->themeslug."_banner_text_image_img",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_banner_type", "value" => "text_image")
	)
),

array(
	"type" => "textarea",
	"title" => "Banner text",
	"info" => "You add only text.",
	"id" => $different_themes_managment->themeslug."_banner_text_image_txt",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_banner_type", "value" => "text_image")
	)
),

array(
	"type" => "close"
),

array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => "Banner Settings",
),

array(
	"type" => "select",
	"title" => "Start Time",
	"id" => $different_themes_managment->themeslug."_banner_start",
	"options"=>array(
		array("slug"=>"0", "name"=>"0 Secconds"), 
		array("slug"=>"5", "name"=>"5 Secconds"),
		array("slug"=>"10", "name"=>"10 Secconds"),
		array("slug"=>"15", "name"=>"15 Secconds"),
		array("slug"=>"20", "name"=>"20 Secconds"),
		array("slug"=>"25", "name"=>"25 Secconds"),
		array("slug"=>"30", "name"=>"30 Secconds"),
		array("slug"=>"60", "name"=>"1 Minute"),
		array("slug"=>"120", "name"=>"2 Minute"),
		array("slug"=>"180", "name"=>"3 Minute"),

		),
	"std" => "off"
),

array(
	"type" => "select",
	"title" => "Close Time",
	"id" => $different_themes_managment->themeslug."_banner_close",
	"options"=>array(
		array("slug"=>"0", "name"=>"Off"), 
		array("slug"=>"5", "name"=>"5 Secconds"),
		array("slug"=>"10", "name"=>"10 Secconds"),
		array("slug"=>"15", "name"=>"15 Secconds"),
		array("slug"=>"20", "name"=>"20 Secconds"),
		array("slug"=>"25", "name"=>"25 Secconds"),
		array("slug"=>"30", "name"=>"30 Secconds"),
		array("slug"=>"60", "name"=>"1 Minute"),
		array("slug"=>"120", "name"=>"2 Minute"),
		array("slug"=>"180", "name"=>"3 Minute"),

		),
	"std" => "off"
),

array(
	"type" => "select",
	"title" => "Fly In From",
	"id" => $different_themes_managment->themeslug."_banner_fly_in",
	"options"=>array(
		array("slug"=>"off", "name"=>"Off"), 
		array("slug"=>"top", "name"=>"Top"),
		array("slug"=>"top-left", "name"=>"Top Left"),
		array("slug"=>"top-right", "name"=>"Top Right"),
		array("slug"=>"left", "name"=>"Left"),
		array("slug"=>"bottom", "name"=>"Bottom"),
		array("slug"=>"bottom-left", "name"=>"Bottom Left"),
		array("slug"=>"bottom-right", "name"=>"Bottom Right"),
		),
	"std" => "off"
),

array(
	"type" => "select",
	"title" => "Fly Out To",
	"id" => $different_themes_managment->themeslug."_banner_fly_out",
	"options"=>array(
		array("slug"=>"off", "name"=>"Off"), 
		array("slug"=>"top", "name"=>"Top"),
		array("slug"=>"top-left", "name"=>"Top Left"),
		array("slug"=>"top-right", "name"=>"Top Right"),
		array("slug"=>"left", "name"=>"Left"),
		array("slug"=>"bottom", "name"=>"Bottom"),
		array("slug"=>"bottom-left", "name"=>"Bottom Left"),
		array("slug"=>"bottom-right", "name"=>"Bottom Right"),
		),
	"std" => "off"
),

array(
	"type" => "select",
	"title" => "Show Banner after",
	"info" => "How many times site may be viewed until the popup will be shown again",
	"id" => $different_themes_managment->themeslug."_banner_views",
	"options"=>array(
		array("slug"=>"0", "name"=>"0 Click"), 
		array("slug"=>"1", "name"=>"1 Click"),
		array("slug"=>"2", "name"=>"2 Clicks"),
		array("slug"=>"2", "name"=>"3 Clicks"),
		array("slug"=>"4", "name"=>"4 Clicks"),
		array("slug"=>"5", "name"=>"5 Clicks"),
		array("slug"=>"10", "name"=>"10 Clicks"),
		array("slug"=>"20", "name"=>"20 Clicks"),
		),
	"std" => "0"
),

array(
	"type" => "select",
	"title" => "How offen show the banner",
	"id" => $different_themes_managment->themeslug."_banner_timeout",
	"options"=>array(
		array("slug"=>"0", "name"=>"One time per visit"), 
		array("slug"=>"1", "name"=>"Once a day"), 
		array("slug"=>"2", "name"=>"Once in 2 days"),
		array("slug"=>"3", "name"=>"Once in 3 days"),
		),
	"std" => "0"
),

array(
	"type" => "checkbox",
	"options" => array(
		array("title" => esc_html__("Enable Background Overlay:",'uniqmag'), "value" => "on")
	),
	"id" => $different_themes_managment->themeslug."_banner_overlay",
	"std" => "off"
),

array(
	"type" => "close"
),

array(
	"type" => "save",
	"title" => "Save Changes"
),

array(
	"type" => "closesubtab"
),

array(
	"type" => "closetab"
)
 
 );
//add gallery tab if gallery plugin is active
if(function_exists('different_theme_gallery_active')) {
	array_push($differentThemes_general_options[2]['subname'], array("slug"=>"gallery", "name"=>esc_html__("Gallery",'uniqmag')));
}

$different_themes_managment->add_options($differentThemes_general_options);
?>