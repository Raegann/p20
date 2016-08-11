<?php
	add_shortcode('blockquote', 'blockquote_handler');

	function blockquote_handler($atts, $content=null, $code="") {
		if($atts['style'] == "2" ) {
			$class = ' class="alt"';
		} else {
			$class = false;
		}
		$return =  '<blockquote'.$class.'>';
		if($atts['style'] == "2" ) {
			$return.=  '<i class="fa fa-quote-left"></i>';
		}
		$return.=  '<p>';
			$return.=  $content;
		$return.=  '</p>';
		$return.=  '<footer>'.$atts['author'].'</footer>';
		$return.=  '</blockquote>';

		return $return;
	}
?>