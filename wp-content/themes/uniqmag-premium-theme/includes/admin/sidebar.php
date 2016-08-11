<?php
$different_themes_managment = Different_Themes()->themes_management;
$differentThemes_sidebar_options= array(
 array(
	"type" => "navigation",
	"name" => "Sidebar Settings",
	"slug" => "sidebars"
),

array(
	"type" => "tab",
	"slug"=>'sidebar_settings'
),

array(
	"type" => "sub_navigation",
	"subname"=>array(
			array("slug"=>"sidebar", "name"=>esc_html__("Sidebar",'uniqmag'))
		)
),

/* ------------------------------------------------------------------------*
 * SIDEBAR GENERATOR
 * ------------------------------------------------------------------------*/

 array(
	"type" => "sub_tab",
	"slug"=>'sidebar'
),
array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => esc_html__("Default Main Sidebar Position",'uniqmag')
),

array(
	"type" => "radio",
	"id" => $different_themes_managment->themeslug."_sidebar_position",
	"radio" => array(
		array("title" => esc_html__("Left:",'uniqmag'), "value" => "left"),
		array("title" => esc_html__("Right:",'uniqmag'), "value" => "right"),
		array("title" => esc_html__("Custom For Each Page:",'uniqmag'), "value" => "custom")
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
	"title" => esc_html__("Change Default Sidebar",'uniqmag'),
),

array(
	"type" => "sidebar_select",
	"id" => $different_themes_managment->themeslug."_default_sidebar",
	"title" => esc_html__("Page/Post Default sidebar",'uniqmag'),
	"default" => array(
		array('', esc_html__('Default','uniqmag'))
	),
	
),
  
array(
	"type" => "close"
),

array(
	"type" => "row"
),
array(
	"type" => "title",
	"title" => esc_html__("Make Sidebars Sticky",'uniqmag'),
),

array(
	"type" => "checkbox",
	"options" => array(
		array("title" => esc_html__("Sticky:",'uniqmag'), "value" => "on")
	),	
	"id"=>$different_themes_managment->themeslug."_stickySidebar"
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
	"title" => esc_html__("Default Second Sidebar Position",'uniqmag')
),

array(
	"type" => "radio",
	"id" => $different_themes_managment->themeslug."_sidebar_position_2",
	"radio" => array(
		array("title" => esc_html__("Left:",'uniqmag'), "value" => "left"),
		array("title" => esc_html__("Right:",'uniqmag'), "value" => "right"),
		array("title" => esc_html__("Custom For Each Page:",'uniqmag'), "value" => "custom")
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
	"title" => esc_html__("Add Sidebar",'uniqmag'),
),

array(
	"type" => "add_text",
	"title" => esc_html__("Add New Sidebar:",'uniqmag'),
	"id" => $different_themes_managment->themeslug."_sidebar_name"
),

array(
	"type" => "close"
),

array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => esc_html__("Sidebar Sequence",'uniqmag'),
	"info" => esc_html__("To sort the slides just drag and drop them!",'uniqmag')
),

array(
	"type" => "sidebar_order",
	"title" => esc_html__("Order Sidebars",'uniqmag'),
	"id" => $different_themes_managment->themeslug."_sidebar_name"
),
  
array(
	"type" => "close"
),
 
array(
	"type" => "closesubtab"
),

array(
	"type" => "closetab"
)
 
);

$different_themes_managment->add_options($differentThemes_sidebar_options);
?>