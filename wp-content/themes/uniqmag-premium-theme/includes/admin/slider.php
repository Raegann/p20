<?php
$different_themes_managment = Different_Themes()->themes_management;
$differentThemes_slider_options= array(
 array(
	"type" => "navigation",
	"name" => esc_html__("Slider Settings",'uniqmag'),
	"slug" => "sliders"
),

array(
	"type" => "tab",
	"slug"=>'sliders'
),

array(
	"type" => "sub_navigation",
	"subname"=>array(
		array("slug"=>"breaking_slider", "name"=>esc_html__("Breaking News Slider",'uniqmag')),
		)
),



/* ------------------------------------------------------------------------*
 * BREAKING NEWS SLIDER SETTINGS
 * ------------------------------------------------------------------------*/

 array(
	"type" => "sub_tab",
	"slug"=> 'breaking_slider'
),


array(
	"type" => "row"
),
array(
	"type" => "title",
	"title" => esc_html__("Show Breaking News Slider",'uniqmag')
),

array(
	"type" => "checkbox",
	"options" => array(
		array("title" => esc_html__("Show In Posts:",'uniqmag'), "value" => "on")
	),	
	"id" => $different_themes_managment->themeslug."_breaking_news_post",
),
array(
	"type" => "checkbox",
	"options" => array(
		array("title" => esc_html__("Show In Pages:",'uniqmag'), "value" => "on")
	),
	"id"=> $different_themes_managment->themeslug."_breaking_news_page"
),
array(
	"type" => "checkbox",
	"options" => array(
		array("title" => esc_html__("Show In Blog:",'uniqmag'), "value" => "on")
	),
	"id"=> $different_themes_managment->themeslug."_breaking_news_blog"
),
array(
	"type" => "checkbox",
	"options" => array(
		array("title" => esc_html__("Show In Homepage:",'uniqmag'), "value" => "on")
	),
	"id"=> $different_themes_managment->themeslug."_breaking_news_home"
),
array(
	"type" => "title",
	"title" => esc_html__("Breaking News Slider Categories",'uniqmag')
),
array(
	"type" => "multiple_select",
	"title" => esc_html__("Set Categories",'uniqmag'),
	"id" => $different_themes_managment->themeslug."_breaking_slider",
	"taxonomy" => "category",
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