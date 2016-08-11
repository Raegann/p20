<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	class Different_Themes {
	    /**
	     * Theme name used mostly for prefixes in the system
	     * @var string
	     */
	    public static $theme_name = 'uniqmag';
	 
	    /**
	     * Theme name used for displaying (pretty version)
	     * @var string
	     */
	    public static $theme_full_name = 'UniqMag';



	    /**
	     * The maximum one rating value
	     * @var string
	     */
		public static $rating_max_val = '5';

	    /**
	     * The rating type, 'single' or 'multiple'
	     * @var string
	     */
		public static $rating_type = 'multiple';
		


		public static $instance = null;
		public $settings;
		public $updater;
		public $posts;
		public $ratings;
		public $sidebars;
		public $themes_management;
		public $themes_management_meta;
		public $pagebuilder;
		public $animations;
		public $icons;
		public $breadcrumbs;
		public $weather;
		public $other;
		public $woocommerce;
		public $filters;
		public $javascript;
		public $options;
		public $ajax;


		private function __construct() {
			if (!defined('THEME_NAME')) {
				define("THEME_NAME", self::$theme_name);
			}
			if (!defined('THEME_FULL_NAME')) {
				define("THEME_FULL_NAME", self::$theme_full_name);
			}


			// Instantiate secondary classes
			$this->options = new Different_Themes_Options();
			$this->updater = new Different_Themes_Updater($this->options->get(THEME_NAME.'_user_name'),$this->options->get(THEME_NAME.'_api_key'),$this->options->get(THEME_NAME.'_purchase_key'));
			$this->themes_management = new DifferentThemesManagment(self::$theme_full_name, self::$theme_name);
			$this->pagebuilder = new DifferentThemesManagment(self::$theme_full_name, self::$theme_name);
			$this->themes_management_meta = new DifferentThemesManagment(self::$theme_full_name, self::$theme_name, 'meta');
			$this->ratings = new Different_Themes_Ratings(self::$rating_max_val, self::$rating_type);
			$this->posts = new Different_Themes_Posts();
			$this->sidebars = new Different_Themes_Sidebars();
			$this->animations = new Different_Themes_Animations();
			$this->icons = new Different_Themes_Fontawesome();
			$this->breadcrumbs = new Different_Themes_Breadcrumbs();
			$this->weather = new Different_Themes_Weather();
			$this->other = new Different_Themes_Other();
			$this->woocommerce = new Different_Themes_Woocommerce();
			$this->filters = new Different_Themes_Filters();
			$this->javascript = new Different_Themes_Javascript();
			$this->ajax = new Different_Themes_Ajax();
			
		}


		/**
		 * Access the single instance of this class
		 * @return Different_Themes
		 */
		public static function get_instance() {

			if ( self::$instance==null ) {
				self::$instance = new Different_Themes();
			}

			return self::$instance;
		}

		/**
		 * Shortcut method to get the settings
		 */
		public static function settings() {
			return self::get_instance()->settings->get_all();
		}


		/**
		 * Get page id
		 * @return int
		 */
		function page_id() {
			$page_id = get_queried_object_id();

			if(isset($page_id) && $page_id!=0) {
				return $page_id;	
			} elseif(Different_Themes()->woocommerce->is_activated() == true) {
				return woocommerce_get_page_id('shop');
			}

		}
		

	}