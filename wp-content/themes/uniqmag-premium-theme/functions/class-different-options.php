<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	class Different_Themes_Options {
	 
		public static $Management_Settings;

		function __construct() {
			
		}


		/**
		 * Custom Update Option
		 */
		function update($name, $value, $save=false) {
			if(isset($name)) {
				self::$Management_Settings[$name] = $value;
			}
			if($save == true) {
				update_option('DifferentThemesManagementSettings',self::$Management_Settings);
			}
		}

		/**
		 * Custom Get Option
		 */
		function get($name) {
			if(!isset(self::$Management_Settings) || !self::$Management_Settings) {
				self::$Management_Settings = get_option('DifferentThemesManagementSettings');
			}
			
		 	return (isset(self::$Management_Settings[$name])) ? self::$Management_Settings[$name] : '';
		}

		/**
		 * Custom Delete Option
		 */
		function delete($name, $save=false) {
			if(isset($name)) {
				unset(self::$Management_Settings[$name]);
			}
			if($save == true) {
				update_option('DifferentThemesManagementSettings',self::$Management_Settings);
			}
		}

	}