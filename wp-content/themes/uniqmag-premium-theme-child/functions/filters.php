<?php

function uniqmag_different_themes_register_my_session() {
  	if(!session_id()){
    	session_start();
 	}
}

add_action('init', 'uniqmag_different_themes_register_my_session');



function uniqmag_different_themes_remove_html_slashes($content) {
	return filter_var(stripslashes($content), FILTER_SANITIZE_SPECIAL_CHARS);
}


function uniqmag_different_themes_new_excerpt_more($more) {
	return '';
}


function uniqmag_different_themes_remove_objects($content) {
	$content = preg_replace('/\<div(.*?)\>(.*?)\<\/div\>/s', '', $content);
	$content = preg_replace('/\<object(.*?)\>(.*?)\<\/object\>/s', '', $content);
	$content = preg_replace('/\<iframe(.*?)\>(.*?)\<\/iframe\>/s', '', $content);
	return $content;
}

function uniqmag_different_themes_remove_images($content) {
	$content = preg_replace('#(<[/]?a.*><[/]?img.*></a>)#U', '', $content);
	$content = preg_replace('#(<[/]?img.*>)#U', '', $content);
	$content = preg_replace("/\[caption(.*)\](.*)\[\/caption\]/Usi", "", $content);
    return $content;
}



/* -------------------------------------------------------------------------*
 * 							BBPRESS BREADCRUMB 								*
 * -------------------------------------------------------------------------*/
function uniqmag_different_themes_bbp_no_breadcrumb ($param) {
	return true;
}
if(Different_Themes()->options->get(THEME_NAME."_breadcrumb")=="on") {
	add_filter ('bbp_no_breadcrumb', 'uniqmag_different_themes_bbp_no_breadcrumb');
}


if(!function_exists('BigFirstChar')) {
	function BigFirstChar ($content = '') {
		$content = preg_replace('/<p>/', '<p class="dropcap">',$content, 1);
		return $content;
	}
}



function uniqmag_different_themes_convert_to_class($name){
	return strtolower( str_replace( array(' ',',','.','"',"'",'/',"\\",'+','=',')','(','*','&','^','%','$','#','@','!','~','`','<','>','?','[',']','{','}','|',':',),'',$name ) );
}



/* -------------------------------------------------------------------------*
 * 							CUSTOM USER PROFILE								*
 * -------------------------------------------------------------------------*/
 
function uniqmag_different_themes_extra_contact_info($contactmethods) {
    unset($contactmethods['aim']);
    unset($contactmethods['yim']);
    unset($contactmethods['jabber']);
    $contactmethods['twitter'] = esc_html__('Twitter Account Url','uniqmag');
    $contactmethods['facebook'] = esc_html__('Facebook Account Url','uniqmag');
 	$contactmethods['google'] = esc_html__('Google+ Account Url','uniqmag');  
    $contactmethods['youtube'] = esc_html__('Youtube Account Url','uniqmag');
    $contactmethods['dribbble'] = esc_html__('Dribbble Account Url','uniqmag');
    


    return $contactmethods;
}



/* -------------------------------------------------------------------------*
 * 							CUSTOM COMMENT FIELDS							*
 * -------------------------------------------------------------------------*/
 
function uniqmag_different_themes_fields($fields) {
	$fields['author'] = '<p><label for="c_name">'.esc_html__("Nickname",'uniqmag').' <span class="required">*</span></label><input type="text" placeholder="'.esc_html__("Nickname",'uniqmag').'" name="author" id="author"></p>';
	$fields['email'] = '<p><label for="c_email">'.esc_html__("E-mail",'uniqmag').' <span class="required">*</span></label><input type="text" placeholder="'.esc_html__("E-mail",'uniqmag').'" name="email" id="email"></p>';
	$fields['url'] = '<p><label for="c_webside">'.esc_html__("Website",'uniqmag').'</label><input type="text" placeholder="'.esc_html__("Website",'uniqmag').'" name="url" id="url"></p>';

	return $fields;
}

/* -------------------------------------------------------------------------*
 * 							CUSTOM COMMENT FIELDS							*
 * -------------------------------------------------------------------------*/
 
function uniqmag_different_themes_fields_rules($fields) {
	$fields['rules'] = '
						<p class="comment-info">
							<i class="fa fa-info"></i>
							<strong>'.esc_html__("Your data will be safe!",'uniqmag').'</strong>
							<span>'.esc_html__('Your e-mail address will not be published. Also other data will not be shared with third person. Required fields marked as ','uniqmag').'<span class="c_required">*</span</span>
						</p>
	';
	//print $fields['rules'];
}

/* -------------------------------------------------------------------------*
 * 									YOUTUBE									*
 * -------------------------------------------------------------------------*/
 
function uniqmag_different_themes_youtube_image( $link ) {

	$ytarray=explode("/", $link);
	$ytendstring=end($ytarray);
	$ytendarray=explode("?v=", $ytendstring);
	$ytendstring=end($ytendarray);
	$ytendarray=explode("&", $ytendstring);
	$ytcode=$ytendarray[0];
	
	
	return $ytcode;


}	

/* -------------------------------------------------------------------------*
 * 							ESCAPE ALL JAVASCRIPT							*
 * -------------------------------------------------------------------------*/
function uniqmag_different_themes_html_output($value) {
	return apply_filters(  'uniqmag_different_themes_html_output', stripslashes($value) );
}


/* -------------------------------------------------------------------------*
 * 							CUSTOM WP TITLE									*
 * -------------------------------------------------------------------------*/
 
function uniqmag_different_themes_wp_title(  ) {

	if ( is_single() ) { 
		$title = single_post_title('',false).' | '.get_bloginfo('name');
	} elseif ( is_home() || is_front_page() ) { 
		$title = get_bloginfo('name'); 
		if(get_bloginfo('description')) { 
			$title.= ' | '.get_bloginfo('description'); 
		} 
	} elseif ( is_page() ) { 
		$title = single_post_title('',false); 
		if(get_bloginfo('description')) { 
			$title.=  ' | '.get_bloginfo('description'); 
		} 
	} elseif ( is_search() ) { 
		$title = get_bloginfo('name'); 
		$title.= ' | Search results '; 
		if(isset($s))
			$title.=  esc_html($s)
		; 
	} elseif ( is_404() ) { 
		$title = get_bloginfo('name').' | Page not found'; 
	} else { 
		$title = get_bloginfo('name').' | '.get_the_title(); 
	}
	
	
	return $title;


}	


/* -------------------------------------------------------------------------*
 * 		ADDING A CSS CLASS TO EACH LINK OF the_author_posts_link()			*
 * -------------------------------------------------------------------------*/

function uniqmag_different_themes_author_posts_link($output) {
	$output= preg_replace('#(<a(.*)>(.*)</a>)#U', '<a $2>$3</a>', $output);
    return $output;
}	



load_theme_textdomain(THEME_NAME, get_template_directory() . '/languages');
	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );



/* -------------------------------------------------------------------------*
 * 								ATTACHMENT SIZE			 					*
 * -------------------------------------------------------------------------*/

function uniqmag_different_themes_attachment($p) {
   $p = '<p class="attachment">';
 	 // show the medium sized image representation of the attachment if available, and link to the raw file
	$p .= wp_get_attachment_link(0, 'full', false);
	$p .= '</p>';

	return $p;
}

add_filter('prepend_attachment', 'uniqmag_different_themes_attachment');	

add_filter('excerpt_more', 'uniqmag_different_themes_new_excerpt_more');

add_filter('the_author_posts_link','uniqmag_different_themes_author_posts_link');

add_filter('user_contactmethods', 'uniqmag_different_themes_extra_contact_info');
add_filter('comment_form_default_fields','uniqmag_different_themes_fields');
add_filter( 'wp_title', 'uniqmag_different_themes_wp_title', 10, 2 );

?>