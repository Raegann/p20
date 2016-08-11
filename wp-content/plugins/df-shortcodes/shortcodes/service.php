<?php
	add_shortcode('service', 'service_handler');

	function service_handler($atts, $content=null, $code="") {
		extract(shortcode_atts(array('color' => null,'icon' => null,'title' => null,'align' => null,), $atts) );
		if(isset($color) ) {
			$color = ' style="color: #'.$color.'"';
		} else {
			$color = false;
		}

		if(isset($icon) && $icon!="Select a Icon" ) {
			$icon = '<i class="fa '.$icon.'"'.$color.'></i>';
		} else {
			$icon = false;
		}
		if(isset($align) ) {
			$align = ' text_'.$align;
		} else {
			$align = false;
		}


		$return = '<div class="cs-service-box'.$align.'">';
			$return.= $icon;
			if($title) {
				$return.= "<h4>".$title."</h4>";
			}
			$return.= wpautop($content);
		$return.= '</div>';
		return $return;
	}
?>
