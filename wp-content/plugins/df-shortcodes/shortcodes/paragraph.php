<?php
	
	add_shortcode('double_paragraph', 'double_paragraph_handler');
	add_shortcode('third_paragraph', 'third_paragraph_handler');
	add_shortcode('forth_paragraph', 'forth_paragraph_handler');
	add_shortcode('paragraph_left', 'paragraph_left_handler');
	add_shortcode('paragraph_right', 'paragraph_right_handler');

	add_shortcode('row', 'row_handler');


	function double_paragraph_handler($atts, $content=null, $code="") {
		$return = '<div class="cs-col cs-col-6-of-12">'.do_shortcode($content).'</div>';
		return $return;
	}
	
	function third_paragraph_handler($atts, $content=null, $code="") {
		$return = '<div class="cs-col cs-col-4-of-12">'.do_shortcode($content).'</div>';
		return $return;
	}	
		
	function forth_paragraph_handler($atts, $content=null, $code="") {
		$return = '<div class="cs-col cs-col-3-of-12">'.do_shortcode($content).'</div>';
		return $return;
	}	
	
	function paragraph_left_handler($atts, $content=null, $code="") {
		$return = '<div class="cs-col cs-col-8-of-12">'.do_shortcode($content).'</div>';
		return $return;
	}	

	function paragraph_right_handler($atts, $content=null, $code="") {
		$return = '<div class="cs-col cs-col-8-of-_12">'.do_shortcode($content).'</div>';
		return $return;
	}
	

	function row_handler($atts, $content=null, $code="") {
		$return = '<div class="df-shortcode-row cs-row">'.do_shortcode($content).'</div>';
		return $return;
	}	


?>
