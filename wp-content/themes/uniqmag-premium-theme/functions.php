<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	update_option("use_balanceTags", 0);

	// THEME PATHS
	define("UNIQMAG_DIFFERENT_THEME_FUNCTIONS_PATH",get_template_directory()."/functions/");
	define("UNIQMAG_DIFFERENT_THEME_INCLUDES_PATH",get_template_directory()."/includes/");
	define("UNIQMAG_DIFFERENT_THEME_SCRIPTS_PATH",get_template_directory()."/js/");
	define("UNIQMAG_DIFFERENT_THEME_CSS_PATH",get_template_directory()."/css/");
	define("UNIQMAG_DIFFERENT_THEME_ADMIN_INCLUDES_PATH", UNIQMAG_DIFFERENT_THEME_INCLUDES_PATH."admin/");
	define("UNIQMAG_DIFFERENT_THEME_WIDGETS_PATH", UNIQMAG_DIFFERENT_THEME_INCLUDES_PATH."widgets/");


	//POST TYPES
	if ( ! defined( 'UNIQMAG_DIFFERENT_THEME_POST_GALLERY' ) ) {
		define( 'UNIQMAG_DIFFERENT_THEME_POST_GALLERY', 'gallery' );
	}
	//POST TYPES
	if ( ! defined( 'UNIQMAG_DIFFERENT_THEME_POST_PORTFOLIO' ) ) {
		define( 'UNIQMAG_DIFFERENT_THEME_POST_PORTFOLIO', 'portfolio' );
	}

	define("UNIQMAG_DIFFERENT_DIFFERENT_THEME_INCLUDES", "functions/");

	define("UNIQMAG_DIFFERENT_THEME_INCLUDES", "includes/");
	define("UNIQMAG_DIFFERENT_THEME_SLIDERS", UNIQMAG_DIFFERENT_THEME_INCLUDES."sliders/");
	define("UNIQMAG_DIFFERENT_THEME_LOOP", UNIQMAG_DIFFERENT_THEME_INCLUDES."loop/");
	define("UNIQMAG_DIFFERENT_THEME_SINGLE", UNIQMAG_DIFFERENT_THEME_INCLUDES."single/");
	define("UNIQMAG_DIFFERENT_THEME_ADMIN_INCLUDES", UNIQMAG_DIFFERENT_THEME_INCLUDES."admin/");


	define("UNIQMAG_DIFFERENT_THEME_URL", get_template_directory_uri());

	define("UNIQMAG_DIFFERENT_THEME_CSS_URL",UNIQMAG_DIFFERENT_THEME_URL."/css/");
	define("UNIQMAG_DIFFERENT_THEME_CSS_ADMIN_URL",UNIQMAG_DIFFERENT_THEME_URL."/css/admin/");
	define("UNIQMAG_DIFFERENT_THEME_JS_URL",UNIQMAG_DIFFERENT_THEME_URL."/js/");
	define("UNIQMAG_DIFFERENT_THEME_JS_ADMIN_URL",UNIQMAG_DIFFERENT_THEME_URL."/js/admin/");
	define("UNIQMAG_DIFFERENT_THEME_IMAGE_URL",UNIQMAG_DIFFERENT_THEME_URL."/images/");
	define("UNIQMAG_DIFFERENT_THEME_IMAGE_CPANEL_URL",UNIQMAG_DIFFERENT_THEME_IMAGE_URL."/control-panel-images/");
	define("UNIQMAG_DIFFERENT_DIFFERENT_THEME_INCLUDES_URL",UNIQMAG_DIFFERENT_THEME_URL."/functions/");
	define("UNIQMAG_DIFFERENT_THEME_ADMIN_URL",UNIQMAG_DIFFERENT_THEME_URL."/includes/admin/");
	define("UNIQMAG_DIFFERENT_THEME_HOME_BLOCKS", UNIQMAG_DIFFERENT_THEME_INCLUDES."home-blocks/");
	define("UNIQMAG_DIFFERENT_THEME_HOME_BLOCK_ROWS", UNIQMAG_DIFFERENT_THEME_HOME_BLOCKS."rows/");



	require_once(UNIQMAG_DIFFERENT_THEME_INCLUDES_PATH."theme-config.php");
	require_once(UNIQMAG_DIFFERENT_THEME_FUNCTIONS_PATH.'class-different-sidebars.php');
	require_once(UNIQMAG_DIFFERENT_THEME_FUNCTIONS_PATH.'class-different-posts.php');
	require_once(UNIQMAG_DIFFERENT_THEME_FUNCTIONS_PATH.'class-different-ratings.php');
	require_once(UNIQMAG_DIFFERENT_THEME_FUNCTIONS_PATH.'class-different-updater.php');
	require_once(UNIQMAG_DIFFERENT_THEME_FUNCTIONS_PATH.'class-different-animations.php');
	require_once(UNIQMAG_DIFFERENT_THEME_FUNCTIONS_PATH.'class-different-fontawesome.php');
	require_once(UNIQMAG_DIFFERENT_THEME_FUNCTIONS_PATH.'class-different-breadcrumbs.php');
	require_once(UNIQMAG_DIFFERENT_THEME_FUNCTIONS_PATH.'class-different-weather.php');
	require_once(UNIQMAG_DIFFERENT_THEME_FUNCTIONS_PATH.'class-different-other.php');
	require_once(UNIQMAG_DIFFERENT_THEME_FUNCTIONS_PATH.'class-different-woocommerce.php');
	require_once(UNIQMAG_DIFFERENT_THEME_FUNCTIONS_PATH.'class-different-filters.php');
	require_once(UNIQMAG_DIFFERENT_THEME_FUNCTIONS_PATH.'class-different-javascript.php');
	require_once(UNIQMAG_DIFFERENT_THEME_FUNCTIONS_PATH.'class-different-options.php');
	require_once(UNIQMAG_DIFFERENT_THEME_FUNCTIONS_PATH.'class-different-themes.php');
	require_once(UNIQMAG_DIFFERENT_THEME_FUNCTIONS_PATH.'class-different-ajax.php');

	function Different_Themes() {
		global $Different_Themes;
		// Instantiate the class
		$Different_Themes = Different_Themes::get_instance();	
		return $Different_Themes;

	}


	require_once(UNIQMAG_DIFFERENT_THEME_ADMIN_INCLUDES_PATH."functions/default-values.php");
	require_once(UNIQMAG_DIFFERENT_THEME_ADMIN_INCLUDES_PATH."functions/jquery-css-include.php");
	require_once(UNIQMAG_DIFFERENT_THEME_ADMIN_INCLUDES_PATH."functions/general.php");
	require_once(UNIQMAG_DIFFERENT_THEME_FUNCTIONS_PATH."tax-meta-class/tax-meta-class.php");
	
	require_once(UNIQMAG_DIFFERENT_THEME_FUNCTIONS_PATH."init.php");

	if(Different_Themes()->options->get(THEME_NAME."_scriptLoad") == "on") {
		require_once(UNIQMAG_DIFFERENT_THEME_CSS_PATH."dynamic-css.php");	
		require_once(UNIQMAG_DIFFERENT_THEME_CSS_PATH."fonts.php");	
		require_once(UNIQMAG_DIFFERENT_THEME_SCRIPTS_PATH."scripts.php");	
		add_action('wp_head','uniqmag_different_themes_custom_style');
		add_action('wp_head','uniqmag_different_themes_custom_fonts');
		add_action('wp_head','uniqmag_different_themes_custom_js');

	}
	require_once(UNIQMAG_DIFFERENT_THEME_WIDGETS_PATH."init.php");



	//remove visual composer notifier
	if(function_exists('vc_set_as_theme')) {
		vc_set_as_theme($notifier = false);
	}



	//turn off ot-galleries plugin default layouts
	remove_action( 'init', array( 'df_PageTemplater', 'get_instance' ) );
	remove_action("template_redirect", 'DFstats_redirect');
	remove_action("admin_print_styles", 'my_plugin_admin_styles');
	remove_action( 'wp_enqueue_scripts', 'different_themes_plugin_scripts');



?>
