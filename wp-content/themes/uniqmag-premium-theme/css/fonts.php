<?php
	function uniqmag_different_themes_custom_fonts() { 

		//fonts
		$google_font_1 = Different_Themes()->options->get(THEME_NAME."_google_font_1");
		$google_font_2 = Different_Themes()->options->get(THEME_NAME."_google_font_2");


		if(Different_Themes()->options->get(THEME_NAME."_scriptLoad") == "on") {
			echo "<style>";	
		} 
?>

/*------------------------------------------------------------------

[Table of contents]

1.  Body
2.  Headings
	Breaking news
	Main navigation
	Post categories
	Post read more
	Widget tags links
	Comments reply

-------------------------------------------------------------------*/

/*------------------------------------------------------------------
    1. Body
-------------------------------------------------------------------*/
body {
    font-family: <?php echo esc_html($google_font_1);?>, Helvetica, sans-serif
}

/*------------------------------------------------------------------
    2. Headings
-------------------------------------------------------------------*/
h1,
h2,
h3,
h4,
h5,
h6,
#cs-breaking-news .cs-breaking-news-title,
#cs-main-navigation .cs-main-navigation > li > a,
.cs-post-category-empty,
.cs-post-category-solid,
.cs-post-category-border,
.cs-post-item .cs-post-read-more,
.widget_tag_cloud .tagcloud a,
#cs-footer-navigation .cs-footer-navigation > li > a,
.cs-reply {
	font-family: '<?php echo esc_html($google_font_2);?>', sans-serif
}





<?php
		if(Different_Themes()->options->get(THEME_NAME."_scriptLoad") == "on") {
			echo "</style>";	
		} 
	}

	if(Different_Themes()->options->get(THEME_NAME."_scriptLoad") != "on") {
		uniqmag_different_themes_custom_fonts();	
	} 

?>