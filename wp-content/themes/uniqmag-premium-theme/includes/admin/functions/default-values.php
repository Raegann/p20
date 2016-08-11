<?php
	/* -------------------------------------------------------------------------*
	 * 						SET DEFAULT VALUES BY THEME INSTALL					*
	 * -------------------------------------------------------------------------*/
	function uniqmag_different_themes_default_settings() {
		global $pagenow;
		$different_themes = Different_Themes();
		get_template_part(UNIQMAG_DIFFERENT_THEME_INCLUDES."/lib/class-tgm-plugin-activation");

		if(get_option($different_themes::$theme_name."_settings_set")!="1") {
			// with activate istall option
			if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
				
				$theme_logo = UNIQMAG_DIFFERENT_THEME_IMAGE_URL."UniqMag-dark.png";
				//$theme_logo_f = UNIQMAG_DIFFERENT_THEME_IMAGE_URL."logo-footer.png";
				$favicon = UNIQMAG_DIFFERENT_THEME_IMAGE_URL."favicon.png";
				$banner = '	<a href="http://www.different-themes.com" target="_blank"><img src="'.esc_url(UNIQMAG_DIFFERENT_THEME_IMAGE_URL.'1.jpg').'" alt="" title="" /></a>';
				$copyright = '&copy; '.date("Y").' Copyright '.$different_themes::$theme_full_name.' theme. All Rights reserved. <a href="http://themeforest.net/user/different-themes/portfolio?ref=different-themes" target="_blank">Different Themes</a>';
				
				Different_Themes()->options->update($different_themes::$theme_name."_logo", $theme_logo, true);
				Different_Themes()->options->update($different_themes::$theme_name.'_stickyMenu', 'on', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_top_banner', 'on', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_top_banner_code', $banner, true);
				Different_Themes()->options->update($different_themes::$theme_name.'_autostartFeatured', 'on', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_loopFeatured', 'on', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_featured_slider_count', '8', true);

				Different_Themes()->options->update($different_themes::$theme_name.'_main_news_autostart', 'on', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_main_news_loop', 'on', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_breadcrumb', 'on', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_main_slider_count', '10', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_similar_post_count', '3', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_similar_post_excerpt', 'on', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_stickySidebar', 'on', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_similar_posts_gallery', 'custom', true);

				
				Different_Themes()->options->update($different_themes::$theme_name.'_google_font_1', 'Arial', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_google_font_2', 'Montserrat', true);

				Different_Themes()->options->update($different_themes::$theme_name.'_body_bg_type', 'color', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_color_1', '9c8dc1', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_default_cat_color', '9c8dc1', true);


				Different_Themes()->options->update($different_themes::$theme_name.'_mainMenu', 'dark', true);



				Different_Themes()->options->update($different_themes::$theme_name.'_body_color', 'f1f1f1', true);

				Different_Themes()->options->update($different_themes::$theme_name.'_sticky_sidebar', 'on', true);



				Different_Themes()->options->update($different_themes::$theme_name.'_similar_posts_gallery', 'custom', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_show_single_title', 'custom', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_showTumbIcon', 'custom', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_sidebar_type', 'custom', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_share_buttons', 'custom', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_postViews', 'custom', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_postControls', 'custom', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_post_icons', 'custom', true);


				
				Different_Themes()->options->update($different_themes::$theme_name.'_showLikes', 'custom', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_imagePopUp', 'custom', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_share_all', 'custom', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_aboutPostAuthor', 'custom', true);

				Different_Themes()->options->update($different_themes::$theme_name.'_sidebar_position', "custom", true);
				Different_Themes()->options->update($different_themes::$theme_name.'_subcount', "4", true);
				Different_Themes()->options->update($different_themes::$theme_name.'_post_style', "custom", true);



				
				
				Different_Themes()->options->update($different_themes::$theme_name.'_page_layout', 'wide', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_responsive', 'on', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_menu_style', 'on', true);



				Different_Themes()->options->update($different_themes::$theme_name.'_similar_posts', "custom", true);
				//Different_Themes()->options->update($different_themes::$theme_name.'_single_post_style', 'custom', true);
				//Different_Themes()->options->update($different_themes::$theme_name.'_post_likes_single', 'custom', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_postComments', 'custom', true);
				//Different_Themes()->options->update($different_themes::$theme_name.'_post_views_single', 'custom', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_postAuthor', 'custom', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_postDate', 'custom', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_postImageStyle', 'custom', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_postCategory', 'custom', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_postPrint', 'custom', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_postFont', 'custom', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_imageStyle', 'custom', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_post_tag_single', 'custom', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_show_single_thumb', "custom", true);
				Different_Themes()->options->update($different_themes::$theme_name."_rss_url", get_bloginfo("rss_url"), true);
				Different_Themes()->options->update($different_themes::$theme_name.'_copyright', $copyright, true);
				Different_Themes()->options->update($different_themes::$theme_name.'_show_first_thumb', "on", true);
				Different_Themes()->options->update($different_themes::$theme_name.'_singlePostBlogTitle', "on", true);

				
				Different_Themes()->options->update($different_themes::$theme_name.'_search', 'on', true);
				Different_Themes()->options->update($different_themes::$theme_name.'_header_style', '1', true);

				//set default thumbnail sizes in woocommerce
				update_option('shop_single',  array('width'  => '258','height' => '327','crop'   => 1));
				update_option('shop_thumbnail',  array('width'  => '200','height' => '200','crop'   => 1));
				update_option('shop_catalog',  array('width'  => '258','height' => '327','crop'   => 1));

				update_option("site_icon", $favicon);
			}

			update_option($different_themes::$theme_name."_settings_set", '1');
		}

	}

		
uniqmag_different_themes_default_settings();



add_action( 'tgmpa_register', 'uniqmag_different_themes_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function uniqmag_different_themes_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
/*
		// This is an example of how to include a plugin pre-packaged with a theme
		array(
			'name'     				=> 'Woocommerce', // The plugin name
			'slug'     				=> 'woocommerce', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory(). '/includes/lib/plugins/woocommerce.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		*/
		// This is an example of how to include a plugin pre-packaged with a theme
		array(
			'name'     				=> 'Different Themes Gallery', // The plugin name
			'slug'     				=> 'df-gallery', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory(). '/includes/lib/plugins/df-gallery.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),

		array(
			'name'     				=> 'Different Themes Shortcodes', // The plugin name
			'slug'     				=> 'df-shortcodes', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory(). '/includes/lib/plugins/df-shortcodes.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),		

	);


	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'uniqmag' ),
			'menu_title'                      => __( 'Install Plugins', 'uniqmag' ),
			'installing'                      => __( 'Installing Plugin: %s', 'uniqmag' ), // %s = plugin name.
			'oops'                            => __( 'Something went wrong with the plugin API.', 'uniqmag' ),
			'notice_can_install_required'     => _n_noop(
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'uniqmag'
			), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop(
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'uniqmag'
			), // %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop(
				'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
				'uniqmag'
			), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop(
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'uniqmag'
			), // %1$s = plugin name(s).
			'notice_ask_to_update_maybe'      => _n_noop(
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'uniqmag'
			), // %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop(
				'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
				'uniqmag'
			), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop(
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'uniqmag'
			), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop(
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'uniqmag'
			), // %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop(
				'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
				'uniqmag'
			), // %1$s = plugin name(s).
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'uniqmag'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'uniqmag'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'uniqmag'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'uniqmag' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'uniqmag' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'uniqmag' ),
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'uniqmag' ),  // %1$s = plugin name(s).
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'uniqmag' ),  // %1$s = plugin name(s).
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'uniqmag' ), // %s = dashboard link.
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'uniqmag' ),
			'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		),
			);
	tgmpa( $plugins, $config );
}

	


?>