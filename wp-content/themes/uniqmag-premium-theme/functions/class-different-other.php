<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Different_Themes_Other {



	public function __construct() {

	}

	/**
	 * Get remote content and conert it to array
	* @return content array
	 */
	public function json_response( $url, $type = false )	{
			$args = array(
				 'timeout' => '10',
				 'redirection' => '10',
				 'sslverify' => false // for localhost
			);
			
			# Parse the given url
			$raw = wp_remote_get( $url, $args );
			if (!is_wp_error($raw)) {	
				if($type!=false) {
					$decoded = json_decode( $raw['body'],$type );	
				} else {
					$decoded = json_decode( $raw['body'] );
				}
				
				return $decoded;
			} else {

				//return $url;	
				return false;	
			}

	}


	/* -------------------------------------------------------------------------*
	 * 															*
	 * -------------------------------------------------------------------------*/
	 /**
	 * Converts HEX color -> RGB color code	
	 *
	 * @param $hex hex color code
	 * @return $color array, RGB
	 */
	function hex_to_rgb($hex) {
			$hex = str_replace("#", "", $hex);
			$color = array();
	 
			if(strlen($hex) == 3) {
				$color['r'] = hexdec(substr($hex, 0, 1) . $r);
				$color['g'] = hexdec(substr($hex, 1, 1) . $g);
				$color['b'] = hexdec(substr($hex, 2, 1) . $b);
			}
			else if(strlen($hex) == 6) {
				$color['r'] = hexdec(substr($hex, 0, 2));
				$color['g'] = hexdec(substr($hex, 2, 2));
				$color['b'] = hexdec(substr($hex, 4, 2));
			}
	 
			return $color;
	}


	 /**
	 * Word limitter
	 *
	 * @param $string text
	 * @param $count output word count
	 * @return $string
	 */
	function the_excerpt( $string, $count = 10 ) {
		echo esc_html($this->get_the_excerpt($string, $count)."...");
	}

	 /**
	 * Word limitter
	 *
	 * @param $string text
	 * @param $count output word count
	 * @return $string
	 */
	function get_the_excerpt( $string, $count = 10 ) {
		$string = esc_html(preg_replace('/\[\/.*?\]/', '', preg_replace('/\[.*?\]/', '', $string)));

		$words = explode(' ', $string);
		if (count($words) > $count){
			array_splice($words, $count);
			$string = implode(' ', $words);
		}

		return esc_html($string)."...";
	}


	function add_shrc( $shrc, $function, $action = "add" ) {
		$funct = $action."_short"."code";
		$funct($shrc, $function);
	}

	

}
?>
