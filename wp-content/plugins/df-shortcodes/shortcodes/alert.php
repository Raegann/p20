<?php
	add_shortcode('alert', 'alert_handler');

function alert_handler($atts, $content=null, $code="") {
	extract(shortcode_atts(array('color' => null, 'icon' => null, 'title' => null), $atts) );
	if(isset($icon) && $icon!="Select a Icon" ) {
		$icon = '<i class="fa '.$icon.'"></i>';
	} else {
		$icon = false;
	}
	return '<div class="cs-alert cs-alert-'.$color.'">'.$icon.'<p>'.do_shortcode($content).'</p></div>';		


}


?>