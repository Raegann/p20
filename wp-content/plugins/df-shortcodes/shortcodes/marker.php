<?php
	add_shortcode('textmarker', 'textmarker_handler');

	function textmarker_handler($atts, $content=null, $code="") {

		return '<kbd style="background-color:#'.$atts['color'].';">'.$content.'</kbd>';
	
	}
?>