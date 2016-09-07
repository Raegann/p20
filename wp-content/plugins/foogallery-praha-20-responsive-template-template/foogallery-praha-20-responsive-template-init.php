<?php
//This init class is used to add the extension to the extensions list while you are developing them.
//When the extension is added to the supported list of extensions, this file is no longer needed.

if ( !class_exists( 'Praha_20_Responsive_Template_Template_FooGallery_Extension_Init' ) ) {
	class Praha_20_Responsive_Template_Template_FooGallery_Extension_Init {

		function __construct() {
			add_filter( 'foogallery_available_extensions', array( $this, 'add_to_extensions_list' ) );
		}

		function add_to_extensions_list( $extensions ) {
			$extensions[] = array(
				'slug'=> 'praha-20-responsive-template',
				'class'=> 'Praha_20_Responsive_Template_Template_FooGallery_Extension',
				'title'=> __('Praha 20 Responsive Template', 'foogallery-praha-20-responsive-template'),
				'file'=> 'foogallery-praha-20-responsive-template-extension.php',
				'description'=> __('Základní šablona galerií', 'foogallery-praha-20-responsive-template'),
				'author'=> 'Your System',
				'author_url'=> 'http://ys.cz/',
				'thumbnail'=> PRAHA_20_RESPONSIVE_TEMPLATE_TEMPLATE_FOOGALLERY_EXTENSION_URL . '/assets/extension_bg.png',
				'tags'=> array( __('template', 'foogallery') ),	//use foogallery translations
				'categories'=> array( __('Build Your Own', 'foogallery') ), //use foogallery translations
				'source'=> 'generated'
			);

			return $extensions;
		}
	}

	new Praha_20_Responsive_Template_Template_FooGallery_Extension_Init();
}