<?php

	get_template_part(UNIQMAG_DIFFERENT_THEME_INCLUDES.'widgets/widget-ad125x125');
	get_template_part(UNIQMAG_DIFFERENT_THEME_INCLUDES.'widgets/widget-ad300x250');
	get_template_part(UNIQMAG_DIFFERENT_THEME_INCLUDES.'widgets/widget-'.THEME_NAME.'-latest-posts');
	get_template_part(UNIQMAG_DIFFERENT_THEME_INCLUDES.'widgets/widget-'.THEME_NAME.'-comments');
	get_template_part(UNIQMAG_DIFFERENT_THEME_INCLUDES.'widgets/widget-'.THEME_NAME.'-popular-posts');
	if(function_exists('different_theme_gallery_active')) {
		get_template_part(UNIQMAG_DIFFERENT_THEME_INCLUDES.'widgets/widget-'.THEME_NAME.'-gallery');
	}
