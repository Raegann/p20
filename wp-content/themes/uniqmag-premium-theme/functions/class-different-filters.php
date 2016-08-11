<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Different_Themes_Filters {

	var $options;

	public function __construct() {
		$this->options = New Different_Themes_Options();
		
		if( $this->options->get(THEME_NAME."_the_time") == "on" ) {
			add_filter( 'the_time', array( $this, 'the_time' ), 10, 2 );
		}
		
		if( $this->options->get(THEME_NAME.'_maintenance_mode') == "on" ) {
			add_action('get_header', array( $this, 'maintenance_mode' ));
		}
			
		//escape all js and illegal html	
		if($this->options->get(THEME_NAME."_javaScriptOut")!="on") {
			add_filter('get_the_excerpt', array( $this, 'escape_the_content' ));
			add_filter('the_content', array( $this, 'escape_the_content' ));
			add_filter('comment_text', array( $this, 'escape_the_content' ));
			add_filter('get_the_content', array( $this, 'escape_the_content' ));
			add_filter('uniqmag_different_themes_html_output', array( $this, 'escape_the_content' ));
		}

	}

	/**
	* Change time format
	* @return time
	 */
	function the_time( $d, $d ) {
	    return human_time_diff( get_the_time('U'), current_time('timestamp') ) .esc_html__(' ago','uniqmag');
	}
	    
	/**
	* turn of bbpress breadcrumb if theme breadcrumb is enabled
	* @return true
	 */
	function bbp_no_breadcrumb ($param) {

		return true;

	}

	 /**
	 * Activate WordPress Maintenance Mode
	 *
	 */
	function maintenance_mode(){
	    if(!current_user_can('edit_themes') || !is_user_logged_in()){
	    	get_template_part('maintenance');
	    }
	}





	function escape_the_content($param) {
		$allowed_html = array(
		    'label' => array(
		        'for' => array(),
		        'class' => array(),
		        'id' => array(),
		    ),
		    'form' => array(
		        'action' => array(),
		        'class' => array(),
		        'id' => array(),
		        'method' => array(),
		    ),
		    'input' => array(
		        'name' => array(),
		        'class' => array(),
		        'id' => array(),
		        'type' => array(),
		        'value' => array(),
		    ),
		    'a' => array(
		        'href' => array(),
		        'title' => array(),
		        'class' => array(),
		        'alt' => array(),
		        'target' => array(),
		        'style' => array()
		    ),
		    'br' => array(
				'class' => array(),
				'style' => array(),
			),
		    'em' => array(
				'class' => array(),
				'style' => array(),
			),
		    'address' => array(
				'class' => array(),
				'id' => array(),
				'style' => array(),
			),
		    'strong' => array(
				'class' => array(),
				'style' => array(),
			),
		    'div' => array(
				'class' => array(),
				'style' => array(),
			),
		    'b' => array(
				'class' => array(),
				'style' => array(),
			),
		    'i' => array(
				'class' => array(),
				'style' => array(),
			),
		    'u' => array(
				'class' => array(),
				'style' => array(),
			),
		    'p' => array(
				'class' => array(),
				'style' => array(),
			),
		    'pre' => array(
				'class' => array(),
				'style' => array(),
			),
		    'sup' => array(
				'class' => array(),
				'style' => array(),
			),
		    'sub' => array(
				'class' => array(),
				'style' => array(),
			),
		    'q' => array(
				'class' => array(),
				'style' => array(),
			),
		    'kbd' => array(
				'class' => array(),
				'style' => array(),
			),
		    'ins' => array(
				'class' => array(),
				'style' => array(),
			),
		    'cite' => array(
				'class' => array(),
				'style' => array(),
				'id' => array(),
			),
		    'del' => array(
				'class' => array(),
				'style' => array(),
			),
		    'abbr' => array(
				'class' => array(),
				'style' => array(),
			),
		    'acronym' => array(
				'class' => array(),
				'style' => array(),
			),
		    'em' => array(
				'class' => array(),
				'style' => array(),
			),
		    'img' => array(
				'class' => array(),
				'style' => array(),
				'id' => array(),
				'src' => array(),
				'alt' => array(),
				'title' => array(),
				'width' => array(),
				'height' => array(),
				'data-ot-retina' => array(),
				'srcset' => array(),
			),
		    'table' => array(
				'class' => array(),
				'style' => array(),
			),
		    'tr' => array(
				'class' => array(),
				'style' => array(),
			),
		    'th' => array(
				'class' => array(),
				'style' => array(),
			),
		    'td' => array(
				'class' => array(),
				'style' => array(),
			),
		    'span' => array(
				'class' => array(),
				'style' => array(),
			),
		    'blockquote' => array(
				'class' => array(),
				'style' => array(),
			),
		    'hr' => array(
				'class' => array(),
				'style' => array(),
			),
		    'ul' => array(
				'class' => array(),
				'style' => array(),
			),
		    'ol' => array(
				'class' => array(),
				'style' => array(),
			),
		    'li' => array(
				'class' => array(),
				'style' => array(),
			),
		    'dl' => array(
				'class' => array(),
				'style' => array(),
			),
		    'dt' => array(
				'class' => array(),
				'style' => array(),
				'id' => array(),
			),
		    'dd' => array(
				'class' => array(),
				'style' => array(),
				'id' => array(),
			),
		    'strike' => array(
				'class' => array(),
				'style' => array(),
				'id' => array(),
			),
		    'code' => array(
				'class' => array(),
				'style' => array(),
				'id' => array(),
			),
		    'h1' => array(
				'class' => array(),
				'style' => array(),
			),
		    'h2' => array(
				'class' => array(),
				'style' => array(),
			),
		    'h3' => array(
				'class' => array(),
				'style' => array(),
			),
		    'h4' => array(
				'class' => array(),
				'style' => array(),
			),
		    'h5' => array(
				'class' => array(),
				'style' => array(),
			),
		    'h6' => array(
				'class' => array(),
				'style' => array(),
			),
		    'iframe' => array(
				'class' => array(),
				'style' => array(),
				'src' => array(),
				'width' => array(),
				'height' => array(),
				'frameborder' => array(),
				'allowfullscreen' => array(),
			),
		);
		return wp_kses($param, $allowed_html);

	}
}
?>