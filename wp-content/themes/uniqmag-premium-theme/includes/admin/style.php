<?php
$different_themes_managment = Different_Themes()->themes_management;
$differentThemes_slider_options= array(
 array(
	"type" => "navigation",
	"name" => esc_html__("Style Settings",'uniqmag'),
	"slug" => "custom-styling"
),

array(
	"type" => "tab",
	"slug"=>'custom-styling'
),

array(
	"type" => "sub_navigation",
	"subname"=>array(
		array("slug"=>"font_style", "name"=>esc_html__("Font Style",'uniqmag')),
		array("slug"=>"page_colors", "name"=>esc_html__("Page Colors/Style",'uniqmag')),
		array("slug"=>"page_layout", "name"=>esc_html__("Layout",'uniqmag'))
		)
),

/* ------------------------------------------------------------------------*
 * PAGE FONT SETTINGS
 * ------------------------------------------------------------------------*/

 array(
	"type" => "sub_tab",
	"slug"=> 'font_style'
),

array(
	"type" => "row"
),
array(
	"type" => "title",
	"title" => esc_html__("Fonts",'uniqmag')
),

array(
	"type" => "google_font_select",
	"title" => esc_html__("Body Font:",'uniqmag'),
	"id" => $different_themes_managment->themeslug."_google_font_1",
	"sort" => "alpha",
	"info" => esc_html__("Font previews You Can find here: <a href='http://www.google.com/webfonts' target='_blank'>Google Fonts</a>",'uniqmag'),
	"default_font" => array('font' => "Arial", 'txt' => "(default)")
),

array(
	"type" => "google_font_select",
	"title" => esc_html__("Title Fonts:",'uniqmag'),
	"id" => $different_themes_managment->themeslug."_google_font_2",
	"sort" => "alpha",
	"info" => esc_html__("Font previews You Can find here: <a href='http://www.google.com/webfonts' target='_blank'>Google Fonts</a>",'uniqmag'),
	"default_font" => array('font' => "Montserrat", 'txt' => "(default)")
),


array(
	"type" => "close"

),



array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => esc_html__("Font Character Sets",'uniqmag'),
),

array(
	"type" => "checkbox",
	"options" => array(
		array("title" => esc_html__("Cyrillic Extended (cyrillic-ext):",'uniqmag'), "value" => "on")
	),
	"id"=>$different_themes_managment->themeslug."_font_cyrillic_ex"
),
array(
	"type" => "checkbox",
	"options" => array(
		array("title" => esc_html__("Cyrillic (cyrillic):",'uniqmag'), "value" => "on")
	),
	"id"=>$different_themes_managment->themeslug."_font_cyrillic"
),
array(
	"type" => "checkbox",
	"options" => array(
		array("title" => esc_html__("Greek Extended (greek-ext):",'uniqmag'), "value" => "on")
	),
	"id"=>$different_themes_managment->themeslug."_font_greek_ex"
),
array(
	"type" => "checkbox",
	"options" => array(
		array("title" => esc_html__("Greek (greek):",'uniqmag'), "value" => "on")
	),
	"id"=>$different_themes_managment->themeslug."_font_greek"
),
array(
	"type" => "checkbox",
	"options" => array(
		array("title" => esc_html__("Vietnamese (vietnamese):",'uniqmag'), "value" => "on")
	),
	"id"=>$different_themes_managment->themeslug."_font_vietnamese"
),
array(
	"type" => "checkbox",
	"options" => array(
		array("title" => esc_html__("Latin Extended (latin-ext):",'uniqmag'), "value" => "on")
	),
	"id"=>$different_themes_managment->themeslug."_font_latin_ex"
),

array(
	"type" => "close",

),
array(
	"type" => "save",
	"title" => esc_html__("Save Changes",'uniqmag')
),
   
array(
	"type" => "closesubtab"
),

/* ------------------------------------------------------------------------*
 * PAGE COLORS
 * ------------------------------------------------------------------------*/

 array(
	"type" => "sub_tab",
	"slug"=> 'page_colors'
),

array(
	"type" => "row"
),
array(
	"type" => "title",
	"title" => esc_html__("Default Category/News page Color",'uniqmag')
),

array( 
	"type" => "color", 
	"id" => $different_themes_managment->themeslug."_default_cat_color", 
	"title" => esc_html__("Color:",'uniqmag'),
	"std" => "9c8dc1",
),

array(
	"type" => "close"
),

array(
	"type" => "row"
),
array(
	"type" => "title",
	"title" => esc_html__("Colors",'uniqmag')
),

array( 
	"type" => "color", 
	"id" => $different_themes_managment->themeslug."_color_1", 
	"title" => esc_html__("Page Color Scheme:",'uniqmag'),
	"std" => "9c8dc1",
),


array(
	"type" => "close"
),


array(
	"type" => "row",

),
array(
	"type" => "title",
	"title" => esc_html__("Body Backgrounds (only boxed view)",'uniqmag')
),

array(
	"type" => "radio",
	"id" => $different_themes_managment->themeslug."_body_bg_type",
	"radio" => array(
		array("title" => esc_html__("Pattern:",'uniqmag'), "value" => "pattern"),
		array("title" => esc_html__("Custom Image:",'uniqmag'), "value" => "image"),
		array("title" => esc_html__("Color:",'uniqmag'), "value" => "color"),
	),
	"std" => "pattern"
),

array(
	"type" => "select",
	"title" => esc_html__("Patterns ",'uniqmag'),
	"id" => $different_themes_managment->themeslug."_body_pattern",
	"options"=>array(
		array("slug"=>"patt2", "name"=>esc_html__("Texture 1",'uniqmag')), 
		array("slug"=>"patt3", "name"=>esc_html__("Texture 2",'uniqmag')), 
		array("slug"=>"patt4", "name"=>esc_html__("Texture 3",'uniqmag')), 
		array("slug"=>"patt5", "name"=>esc_html__("Texture 4",'uniqmag')), 
		array("slug"=>"patt6", "name"=>esc_html__("Texture 5",'uniqmag')), 
		array("slug"=>"patt7", "name"=>esc_html__("Texture 6",'uniqmag')), 
		array("slug"=>"patt8", "name"=>esc_html__("Texture 7",'uniqmag')), 
		array("slug"=>"patt9", "name"=>esc_html__("Texture 8",'uniqmag')), 
		array("slug"=>"patt10", "name"=>esc_html__("Texture 9",'uniqmag')), 
	),
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_body_bg_type", "value" => "pattern")
	)
),

array(
	"type" => "color",
	"title" => esc_html__("Body Background Color:",'uniqmag'),
	"id" => $different_themes_managment->themeslug."_body_color",
	"std" => "f1f1f1",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_body_bg_type", "value" => "color")
	)
),

array(
	"type" => "upload",
	"title" => esc_html__("Body Background Image:",'uniqmag'),
	"id" => $different_themes_managment->themeslug."_body_image",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_body_bg_type", "value" => "image")
	)
),

array(
	"type" => "input",
	"title" => esc_html__("Background Image Url:",'uniqmag'),
	"id" => $different_themes_managment->themeslug."_body_image_url",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_body_bg_type", "value" => "image")
	)
),
array(
	"type" => "title",
	"title" => esc_html__("Image Repeat",'uniqmag'),
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_body_bg_type", "value" => "image")
	)
),
array(
	"type" => "radio",
	"id" => $different_themes_managment->themeslug."_body_image_repeat",
	"radio" => array(
		array("title" => esc_html__("Repeat X:",'uniqmag'), "value" => "repeat-x"),
		array("title" => esc_html__("Repeat Y:",'uniqmag'), "value" => "repeat-y"),
		array("title" => esc_html__("Repeat X and Y:",'uniqmag'), "value" => "repeat"),
		array("title" => esc_html__("Off:",'uniqmag'), "value" => "no-repeat"),
	),
	"std" => "no-repeat",
	"protected" => array(
		array("id" => $different_themes_managment->themeslug."_body_bg_type", "value" => "image")
	)
),
array(
	"type" => "close",

),

array(
	"type" => "save",
	"title" => esc_html__("Save Changes",'uniqmag'),
),
   
array(
	"type" => "closesubtab"
),
/* ------------------------------------------------------------------------*
 * PAGE LAYOUT
 * ------------------------------------------------------------------------*/

 array(
	"type" => "sub_tab",
	"slug"=> 'page_layout'
),

array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => esc_html__("Menu",'uniqmag'),
),

array(
	"type" => "radio",
	"id" => $different_themes_managment->themeslug."_stickyMenu",
	"radio" => array(
		array("title" => esc_html__("Sticky:",'uniqmag'), "value" => "on"),
		array("title" => esc_html__("Fixed:",'uniqmag'), "value" => "off"),
	),
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
	"title" => esc_html__("Enable Responsive",'uniqmag'),
),

array(
	"type" => "checkbox",
	"options" => array(
		array("title" => esc_html__("Enable",'uniqmag'), "value" => "on")
	),
	"id" => $different_themes_managment->themeslug."_responsive"
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
	"title" => esc_html__("Header Style",'uniqmag'),
),

array(
	"type" => "radio",
	"class" => "radio-with-images",
	"id" => $different_themes_managment->themeslug."_header_style",
	"radio" => array(
		array("img" => UNIQMAG_DIFFERENT_THEME_IMAGE_CPANEL_URL.'header_style_1.png', "value" => "1"),
		array("img" => UNIQMAG_DIFFERENT_THEME_IMAGE_CPANEL_URL.'header_style_2.png', "value" => "2"),
		array("img" => UNIQMAG_DIFFERENT_THEME_IMAGE_CPANEL_URL.'header_style_3.png', "value" => "3"),
		array("img" => UNIQMAG_DIFFERENT_THEME_IMAGE_CPANEL_URL.'header_style_4.png', "value" => "4"),
	),
	'std' => '1'
),

array(
	"type" => "close"
),

array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => esc_html__("Page Layout",'uniqmag'),
),

array(
	"type" => "radio",
	"class" => "radio-with-images",
	"id" => $different_themes_managment->themeslug."_page_layout",
	"radio" => array(
		array("img" => UNIQMAG_DIFFERENT_THEME_IMAGE_CPANEL_URL.'page-width-boxed.png', "value" => "boxed"),
		array("img" => UNIQMAG_DIFFERENT_THEME_IMAGE_CPANEL_URL.'page-width-full.png', "value" => "wide"),
	),
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

array(
	"type" => "closetab"
)
 
);

$different_themes_managment->add_options($differentThemes_slider_options);
?>