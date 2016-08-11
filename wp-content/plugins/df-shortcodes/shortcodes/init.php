<?php
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	require_once(plugin_dir_path(__FILE__).'dropcaps.php');
	require_once(plugin_dir_path(__FILE__).'buttons.php');
	require_once(plugin_dir_path(__FILE__).'alert.php');
	require_once(plugin_dir_path(__FILE__).'paragraph.php');
	require_once(plugin_dir_path(__FILE__).'lists.php');
	require_once(plugin_dir_path(__FILE__).'qoutes.php');
	require_once(plugin_dir_path(__FILE__).'marker.php');
	require_once(plugin_dir_path(__FILE__).'tab.php');
	require_once(plugin_dir_path(__FILE__).'accordion.php');
	require_once(plugin_dir_path(__FILE__).'caption.php');
	require_once(plugin_dir_path(__FILE__).'spacers.php');

	if ( is_plugin_active( 'df-gallery/df-gallery.php' ) ) {
		require_once(plugin_dir_path(__FILE__).'gallery-box.php');
	}
	

	require_once(plugin_dir_path(__FILE__).'service.php');
	require_once(plugin_dir_path(__FILE__).'blocktext.php');
?>