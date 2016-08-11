<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Different_Themes_Javascript {

	static public $js_start = '<script type="text/javascript">';
	static public $js_end = '</script>';
	static public $footer_js;

	public function __construct() {
		add_action('wp_footer', array( $this, 'print_theme_js' ));  
		add_action('wp_footer', array( $this, 'print_footer_js' ));  
	}

	/**
	 * Add javascript in theme footer
	 * @param $footer_js javascript
	 */
	public function footer_js( $footer_js )	{
		self::$footer_js.= $footer_js;
	}

	/**
	 * Add javascript in theme footer
	* @return js string
	 */
	public function print_footer_js() {
		echo self::$js_start;
		echo self::$footer_js;
		echo self::$js_end;
	}

	/**
	 * Add other javascript in theme footer
	* @return js string
	 */
	public function print_theme_js() {
		// pop up banner
		$banner_type = Different_Themes()->options->get ( THEME_NAME."_banner_type" );
		
		$banner_fly_in = Different_Themes()->options->get ( THEME_NAME."_banner_fly_in" );
		$banner_fly_out = Different_Themes()->options->get ( THEME_NAME."_banner_fly_out" );
		$banner_start = Different_Themes()->options->get ( THEME_NAME."_banner_start" );
		$banner_close = Different_Themes()->options->get ( THEME_NAME."_banner_close" );
		$banner_overlay = Different_Themes()->options->get ( THEME_NAME."_banner_overlay" );
		$banner_views = Different_Themes()->options->get ( THEME_NAME."_banner_views" );
		$banner_timeout = Different_Themes()->options->get ( THEME_NAME."_banner_timeout" );
		
		$banner_text_image_img = Different_Themes()->options->get ( THEME_NAME."_banner_text_image_img" ) ;
		$banner_image = Different_Themes()->options->get ( THEME_NAME."_banner_image" );
		$banner_text = stripslashes ( Different_Themes()->options->get ( THEME_NAME."_banner_text" ) );
		
		if ( $banner_type == "image" ) {
		//Image Banner
			$cookie_name = substr ( md5 ( $banner_image ), 1,6 );
		} else if ( $banner_type == "text" ) { 
		//Text Banner
			$cookie_name = substr ( md5 ( $banner_text ), 1,6 );
		} else if ( $banner_type == "text_image" ) { 
		//Image And Text Banner
			$cookie_name = substr ( md5 ( $banner_text_image_img ), 1,6 );
		} else {
			$cookie_name = "popup";
		}

		if ( !$banner_start) {
			$banner_start = 0;
		}
		
		if ( !$banner_close) {
			$banner_close = 0;
		}
		
		if ( $banner_overlay == "on") {
			$banner_overlay = "true";
		} else {
			$banner_overlay = "false";
		}


	 	if(Different_Themes()->options->get(THEME_NAME."_stickySidebar") == "on") {
			ob_start();
		?>
	        // Sticky sidebar
	        jQuery(".cs-sticky-sidebar").theiaStickySidebar(
	        	<?php 
	        		$marginTop = 0;
	        		if(Different_Themes()->options->get(THEME_NAME."_stickyMenu") == "on") { 
	        			$marginTop = $marginTop+53;
	        		} 
	        		if(is_admin_bar_showing()) { 
	        			$marginTop = $marginTop+32;
	        		} 
	        	?>

	        		{additionalMarginTop: <?php echo intval($marginTop);?>}
	        );

		<?php
		    $this->footer_js(ob_get_contents());
			ob_end_clean();
  
		} 
			//pop up banner
			if ($banner_type && $banner_type != "off" ) {
			ob_start();
		?>
			jQuery(document).ready(function($){
				$('#popup_content').popup( {
					starttime 			 : <?php echo esc_js($banner_start); ?>,
					selfclose			 : <?php echo esc_js($banner_close); ?>,
					popup_div			 : 'popup',
					overlay_div	 		 : 'overlay',
					close_id			 : 'baner_close',
					overlay				 : <?php echo esc_js($banner_overlay); ?>,
					opacity_level		 : 0.7,
					overlay_cc			 : false,
					centered			 : true,
					top	 		   		 : 130,
					left	 			 : 130,
					setcookie 			 : true,
					cookie_name	 		 : '<?php echo esc_js($cookie_name);?>',
					cookie_timeout 	 	 : <?php echo esc_js($banner_timeout); ?>,
					cookie_views 		 : <?php echo esc_js($banner_views); ?>,
					floating	 		 : true,
					floating_reaction	 : 700,
					floating_speed 		 : 12,
					<?php 
						if ( $banner_fly_in != "off") { 
							echo "fly_in : true,
							fly_from : '".esc_js($banner_fly_in)."', "; 
						} else {
							echo "fly_in : false,";
						}
					?>
					<?php 
						if ( $banner_fly_out != "off") { 
							echo "fly_out : true,
							fly_to : '".esc_js($banner_fly_out)."', "; 
						} else {
							echo "fly_out : false,";
						}
					?>
					popup_appear  		 : 'show',
					popup_appear_time 	 : 0,
					confirm_close	 	 : false,
					confirm_close_text 	 : 'Do you really want to close?'
				} );
			});

		<?php
		   	 	$this->footer_js(ob_get_contents());
				ob_end_clean();
		 	} 
	}

}
