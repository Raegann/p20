<?php
	add_shortcode('blocktext', 'blocktext_handler');

	function blocktext_handler($atts, $content=null, $code="") {
		extract(shortcode_atts(array('align' => null), $atts) );
		$return =  '<p class="pullquotes '.esc_attr($align).'">';
			$return.=  esc_html($content);
		$return.=  '</p>';

		return $return;
	}
?>