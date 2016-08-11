<?php 
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	wp_reset_postdata();

	if (uniqmag_different_themes_is_template_active("template-contact.php")) {
		$contactPages = uniqmag_different_themes_get_page("contact");
		if($contactPages[0]) {
			$contactUrl = get_page_link($contactPages[0]);
		}
	} else {
		$contactUrl = false;
	}
 ?>

	<div class="the-error-msg">
		<strong class="font-replace"><?php esc_html_e("No Articles Found",'uniqmag');?></strong>
		<p><?php printf(esc_html__('Sorry, there are no articles here ! %1$sYou can %2$scontact us%3$s to resolve this problem !','uniqmag'), '<br>','<a href="'.$contactUrl.'">','</a>');?></p>
		<p><?php printf(esc_html__('Or You can still %1$sgo back to Homepage%2$s!','uniqmag'), '<a href="'.esc_url(home_url('/')).'">','</a>');?></p>
	</div>