<?php
/**
 * FooGallery Praha 20 Responsive Template Extension
 *
 * Základní šablona galerií
 *
 * @package   Praha_20_Responsive_Template_Template_FooGallery_Extension
 * @author    Your System
 * @license   GPL-2.0+
 * @link      http://ys.cz/
 * @copyright 2014 Your System
 *
 * @wordpress-plugin
 * Plugin Name: FooGallery - Praha 20 Responsive Template
 * Description: Základní šablona galerií
 * Version:     1.0.0
 * Author:      Your System
 * Author URI:  http://ys.cz/
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( !class_exists( 'Praha_20_Responsive_Template_Template_FooGallery_Extension' ) ) {

	define('PRAHA_20_RESPONSIVE_TEMPLATE_TEMPLATE_FOOGALLERY_EXTENSION_FILE', __FILE__ );
	define('PRAHA_20_RESPONSIVE_TEMPLATE_TEMPLATE_FOOGALLERY_EXTENSION_URL', plugin_dir_url( __FILE__ ));
	define('PRAHA_20_RESPONSIVE_TEMPLATE_TEMPLATE_FOOGALLERY_EXTENSION_VERSION', '1.0.0');
	define('PRAHA_20_RESPONSIVE_TEMPLATE_TEMPLATE_FOOGALLERY_EXTENSION_PATH', plugin_dir_path( __FILE__ ));
	define('PRAHA_20_RESPONSIVE_TEMPLATE_TEMPLATE_FOOGALLERY_EXTENSION_SLUG', 'foogallery-praha-20-responsive-template');
	//define('PRAHA_20_RESPONSIVE_TEMPLATE_TEMPLATE_FOOGALLERY_EXTENSION_UPDATE_URL', 'http://fooplugins.com');
	//define('PRAHA_20_RESPONSIVE_TEMPLATE_TEMPLATE_FOOGALLERY_EXTENSION_UPDATE_ITEM_NAME', 'Praha 20 Responsive Template');

	require_once( 'foogallery-praha-20-responsive-template-init.php' );

	class Praha_20_Responsive_Template_Template_FooGallery_Extension {
		/**
		 * Wire up everything we need to run the extension
		 */
		function __construct() {
			add_filter( 'foogallery_gallery_templates', array( $this, 'add_template' ) );
			add_filter( 'foogallery_gallery_templates_files', array( $this, 'register_myself' ) );
			add_filter( 'foogallery_located_template-praha-20-responsive-template', array( $this, 'enqueue_dependencies' ) );
			add_filter( 'foogallery_template_js_ver-praha-20-responsive-template', array( $this, 'override_version' ) );
			add_filter( 'foogallery_template_css_ver-praha-20-responsive-template', array( $this, 'override_version' ) );

			//used for auto updates and licensing in premium extensions. Delete if not applicable
			//init licensing and update checking
			//require_once( PRAHA_20_RESPONSIVE_TEMPLATE_TEMPLATE_FOOGALLERY_EXTENSION_PATH . 'includes/EDD_SL_FooGallery.php' );

			//new EDD_SL_FooGallery_v1_1(
			//	PRAHA_20_RESPONSIVE_TEMPLATE_TEMPLATE_FOOGALLERY_EXTENSION_FILE,
			//	PRAHA_20_RESPONSIVE_TEMPLATE_TEMPLATE_FOOGALLERY_EXTENSION_SLUG,
			//	PRAHA_20_RESPONSIVE_TEMPLATE_TEMPLATE_FOOGALLERY_EXTENSION_VERSION,
			//	PRAHA_20_RESPONSIVE_TEMPLATE_TEMPLATE_FOOGALLERY_EXTENSION_UPDATE_URL,
			//	PRAHA_20_RESPONSIVE_TEMPLATE_TEMPLATE_FOOGALLERY_EXTENSION_UPDATE_ITEM_NAME,
			//	'Praha 20 Responsive Template');
		}

		/**
		 * Register myself so that all associated JS and CSS files can be found and automatically included
		 * @param $extensions
		 *
		 * @return array
		 */
		function register_myself( $extensions ) {
			$extensions[] = __FILE__;
			return $extensions;
		}

		/**
		 * Override the asset version number when enqueueing extension assets
		 */
		function override_version( $version ) {
			return PRAHA_20_RESPONSIVE_TEMPLATE_TEMPLATE_FOOGALLERY_EXTENSION_VERSION;
		}

		/**
		 * Enqueue any script or stylesheet file dependencies that your gallery template relies on
		 */
		function enqueue_dependencies() {
			//$js = PRAHA_20_RESPONSIVE_TEMPLATE_TEMPLATE_FOOGALLERY_EXTENSION_URL . 'js/jquery.praha-20-responsive-template.js';
			//wp_enqueue_script( 'praha-20-responsive-template', $js, array('jquery'), PRAHA_20_RESPONSIVE_TEMPLATE_TEMPLATE_FOOGALLERY_EXTENSION_VERSION );

			//$css = PRAHA_20_RESPONSIVE_TEMPLATE_TEMPLATE_FOOGALLERY_EXTENSION_URL . 'css/praha-20-responsive-template.css';
			//foogallery_enqueue_style( 'praha-20-responsive-template', $css, array(), PRAHA_20_RESPONSIVE_TEMPLATE_TEMPLATE_FOOGALLERY_EXTENSION_VERSION );
		}

		/**
		 * Add our gallery template to the list of templates available for every gallery
		 * @param $gallery_templates
		 *
		 * @return array
		 */
		function add_template( $gallery_templates ) {

			$gallery_templates[] = array(
				'slug'        => 'praha-20-responsive-template',
				'name'        => __( 'Praha 20 Responsive Template', 'foogallery-praha-20-responsive-template'),
				'preview_css' => PRAHA_20_RESPONSIVE_TEMPLATE_TEMPLATE_FOOGALLERY_EXTENSION_URL . 'css/gallery-praha-20-responsive-template.css',
				'admin_js'	  => PRAHA_20_RESPONSIVE_TEMPLATE_TEMPLATE_FOOGALLERY_EXTENSION_URL . 'js/admin-gallery-praha-20-responsive-template.js',
				'fields'	  => array(
					array(
									'id'      => 'lightbox',
									'title'   => __( 'Lightbox', 'foogallery' ),
									'desc'    => __( 'Choose which lightbox you want to use. The lightbox will only work if you set the thumbnail link to "Full Size Image".', 'foogallery' ),
									'type'    => 'lightbox',
							),
							array(
									'id'      => 'spacing',
									'title'   => __( 'Spacing', 'foogallery' ),
									'desc'    => __( 'The spacing or gap between thumbnails in the gallery.', 'foogallery' ),
									'type'    => 'select',
									'default' => 'spacing-width-10',
									'choices' => array(
											'spacing-width-0' => __( '0 pixels', 'foogallery' ),
											'spacing-width-5' => __( '5 pixels', 'foogallery' ),
											'spacing-width-10' => __( '10 pixels', 'foogallery' ),
											'spacing-width-15' => __( '15 pixels', 'foogallery' ),
											'spacing-width-20' => __( '20 pixels', 'foogallery' ),
											'spacing-width-25' => __( '25 pixels', 'foogallery' ),
									),
							),
							array(
									'id'      => 'alignment',
									'title'   => __( 'Alignment', 'foogallery' ),
									'desc'    => __( 'The horizontal alignment of the thumbnails inside the gallery.', 'foogallery' ),
									'default' => 'alignment-center',
									'type'    => 'select',
									'choices' => array(
											'alignment-left' => __( 'Left', 'foogallery' ),
											'alignment-center' => __( 'Center', 'foogallery' ),
											'alignment-right' => __( 'Right', 'foogallery' ),
									)
							),
							array(
									'id'      => 'loading_animation',
									'title'   => __( 'Loading Indicator', 'foogallery' ),
									'default' => 'yes',
									'type'    => 'radio',
									'choices' => array(
											'yes'  => __( 'Show Thumbnail Loading Indicator', 'foogallery' ),
											'no'   => __( 'Disabled', 'foogallery' )
									),
									'spacer'  => '<span class="spacer"></span>',
									'desc'	  => __( 'By default, an animated loading animation indicator is shown before the thumbnails have loaded. You can disable the loader if you want.', 'foogallery' ),
							),
							array(
									'id'      => 'thumbnail_dimensions',
									'title'   => __( 'Size', 'foogallery' ),
									'desc'    => __( 'Choose the size of your thumbnails.', 'foogallery' ),
									'section' => __( 'Thumbnail Settings', 'foogallery' ),
									'type'    => 'thumb_size',
									'default' => array(
											'width' => get_option( 'thumbnail_size_w' ),
											'height' => get_option( 'thumbnail_size_h' ),
											'crop' => true,
									),
							),
							array(
									'id'      => 'thumbnail_link',
									'title'   => __( 'Link', 'foogallery' ),
									'section' => __( 'Thumbnail Settings', 'foogallery' ),
									'default' => 'image',
									'type'    => 'thumb_link',
									'spacer'  => '<span class="spacer"></span>',
									'desc'	  => __( 'You can choose to link each thumbnail to the full size image, the image\'s attachment page, a custom URL, or you can choose to not link to anything.', 'foogallery' ),
							),
							array(
									'id'      => 'border-style',
									'title'   => __( 'Border Style', 'foogallery' ),
									'desc'    => __( 'The border style for each thumbnail in the gallery.', 'foogallery' ),
									'section' => __( 'Thumbnail Settings', 'foogallery' ),
									'type'    => 'icon',
									'default' => 'border-style-square-white',
									'choices' => array(
											'border-style-square-white' => array( 'label' => __( 'Square white border with shadow' , 'foogallery' ), 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_SHARED_URL . 'img/admin/border-style-icon-square-white.png' ),
											'border-style-circle-white' => array( 'label' => __( 'Circular white border with shadow' , 'foogallery' ), 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_SHARED_URL . 'img/admin/border-style-icon-circle-white.png' ),
											'border-style-square-black' => array( 'label' => __( 'Square Black' , 'foogallery' ), 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_SHARED_URL . 'img/admin/border-style-icon-square-black.png' ),
											'border-style-circle-black' => array( 'label' => __( 'Circular Black' , 'foogallery' ), 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_SHARED_URL . 'img/admin/border-style-icon-circle-black.png' ),
											'border-style-inset' => array( 'label' => __( 'Square Inset' , 'foogallery' ), 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_SHARED_URL . 'img/admin/border-style-icon-square-inset.png' ),
											'border-style-rounded' => array( 'label' => __( 'Plain Rounded' , 'foogallery' ), 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_SHARED_URL . 'img/admin/border-style-icon-plain-rounded.png' ),
											'' => array( 'label' => __( 'Plain' , 'foogallery' ), 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_SHARED_URL . 'img/admin/border-style-icon-none.png' ),
									)
							),
							array(
									'id'      => 'hover-effect-type',
									'title'   => __( 'Hover Effect Type', 'foogallery' ),
									'section' => __( 'Thumbnail Settings', 'foogallery' ),
									'default' => '',
									'type'    => 'radio',
									'choices' => apply_filters( 'foogallery_gallery_template_hover-effect-types', array(
											''  => __( 'Icon', 'foogallery' ),
											'hover-effect-tint'   => __( 'Dark Tint', 'foogallery' ),
											'hover-effect-color' => __( 'Colorize', 'foogallery' ),
											'hover-effect-caption' => __( 'Caption', 'foogallery' ),
											'hover-effect-none' => __( 'None', 'foogallery' )
									) ),
									'spacer'  => '<span class="spacer"></span>',
									'desc'	  => __( 'The type of hover effect the thumbnails will use.', 'foogallery' ),
							),
							array(
									'id'      => 'hover-effect',
									'title'   => __( 'Icon Hover Effect', 'foogallery' ),
									'desc'    => __( 'When the hover effect type of Icon is chosen, you can choose which icon is shown when you hover over each thumbnail.', 'foogallery' ),
									'section' => __( 'Thumbnail Settings', 'foogallery' ),
									'type'    => 'icon',
									'default' => 'hover-effect-zoom',
									'choices' => array(
											'hover-effect-zoom' => array( 'label' => __( 'Zoom' , 'foogallery' ), 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_SHARED_URL . 'img/admin/hover-effect-icon-zoom.png' ),
											'hover-effect-zoom2' => array( 'label' => __( 'Zoom 2' , 'foogallery' ), 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_SHARED_URL . 'img/admin/hover-effect-icon-zoom2.png' ),
											'hover-effect-zoom3' => array( 'label' => __( 'Zoom 3' , 'foogallery' ), 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_SHARED_URL . 'img/admin/hover-effect-icon-zoom3.png' ),
											'hover-effect-plus' => array( 'label' => __( 'Plus' , 'foogallery' ), 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_SHARED_URL . 'img/admin/hover-effect-icon-plus.png' ),
											'hover-effect-circle-plus' => array( 'label' => __( 'Cirlce Plus' , 'foogallery' ), 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_SHARED_URL . 'img/admin/hover-effect-icon-circle-plus.png' ),
											'hover-effect-eye' => array( 'label' => __( 'Eye' , 'foogallery' ), 'img' => FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_SHARED_URL . 'img/admin/hover-effect-icon-eye.png' )
									),
							),
							array(
									'id'      => 'caption-hover-effect',
									'title'   => __( 'Caption Effect', 'foogallery' ),
									'section' => __( 'Thumbnail Settings', 'foogallery' ),
									'default' => 'hover-caption-simple',
									'type'    => 'radio',
									'choices' => apply_filters( 'foogallery_gallery_template_caption-hover-effects', array(
											'hover-caption-simple'  => __( 'Simple', 'foogallery' ),
											'hover-caption-full-drop'   => __( 'Drop', 'foogallery' ),
											'hover-caption-full-fade' => __( 'Fade In', 'foogallery' ),
											'hover-caption-push' => __( 'Push', 'foogallery' ),
											'hover-caption-simple-always' => __( 'Always Visible', 'foogallery' )
									) ),
									'spacer'  => '<span class="spacer"></span>'
							),
							array(
									'id'      => 'caption-content',
									'title'   => __( 'Caption Content', 'foogallery' ),
									'section' => __( 'Thumbnail Settings', 'foogallery' ),
									'default' => 'title',
									'type'    => 'radio',
									'choices' => apply_filters( 'foogallery_gallery_template_caption-content', array(
											'title'  => __( 'Title Only', 'foogallery' ),
											'desc'   => __( 'Description Only', 'foogallery' ),
											'both' => __( 'Title and Description', 'foogallery' )
									) ),
									'spacer'  => '<span class="spacer"></span>'
							),
							array(
									'id' => 'thumb_preview',
									'title' => __( 'Preview', 'foogallery' ),
									'desc' => __( 'This is what your gallery thumbnails will look like.', 'foogallery' ),
									'section' => __( 'Thumbnail Settings', 'foogallery' ),
									'type' => 'default_thumb_preview',
							)
				)
			);

			return $gallery_templates;
		}
	}
}