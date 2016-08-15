<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



/* -------------------------------------------------------------------------*
 * 								CONTENT WIDTH								*
 * -------------------------------------------------------------------------*/
 
 if ( ! isset( $content_width ) ) 
    $content_width = 900;


/* -------------------------------------------------------------------------*
 * 							CATEGORIE CUSTOM COLOR							*
 * -------------------------------------------------------------------------*/	

	$taxnow = isset($_REQUEST['taxonomy'])? $_REQUEST['taxonomy'] : '';
	$config = array(
	   'pages' => array('category','post_tag',UNIQMAG_DIFFERENT_THEME_POST_GALLERY.'-cat'),                     // taxonomy name, accept categories, post_tag and custom taxonomies
	   'context' => 'normal',                           // where the meta box appear: normal (default), advanced, side; optional
	   'fields' => array(),                             // list of meta fields (can be added by field arrays)
	   'local_images' => false,                         // Use local or hosted images (meta box images for add/remove)
	   'use_with_theme' => true                        	//change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
	);




	$sidebar_names = Different_Themes()->options->get( THEME_NAME."_sidebar_names" );
	$sidebar_names = explode( "|*|", $sidebar_names );
	$sidebars = array();
	$sidebars['default'] = 'Default';
	$sidebars['off'] = 'Off';

	if(!empty($sidebar_names)) {
		foreach ($sidebar_names as $sidebar) {
			if($sidebar!="") {
				$sidebars[strtolower($sidebar)] = $sidebar;
			}
		}
	}	

	$sidebarSmall = array();
	$sidebarSmall['off'] = 'Off';
	$sidebarSmall['default'] = 'Default';

	if(!empty($sidebar_names)) {
		foreach ($sidebar_names as $sidebar) {
			if($sidebar!="") {
				$sidebarSmall[strtolower($sidebar)] = $sidebar;
			}
		}
	}


	$sidebarPosition = Different_Themes()->options->get(THEME_NAME.'_sidebar_position');
	$sidebarPosition_2 = Different_Themes()->options->get(THEME_NAME.'_sidebar_position_2');

	$my_meta = new Tax_Meta_Class($config);
	$my_meta->addColor(THEME_NAME.'_title_color',array('name'=> esc_html__('Categoy/Tag Color','uniqmag')));
	if( $taxnow != UNIQMAG_DIFFERENT_THEME_POST_GALLERY.'-cat' ) {
		$my_meta->addSelect(THEME_NAME.'_blogStyle',
		array(
			'1'=>'Default Grid View (without excerpt)',
			'2'=>'Default Grid View (with excerpt)', 
			'3'=>'List With Small Images',
			'4'=>'Small Grid View',
			'5'=>'Grid View Style 3',
			'6'=>'Grid View Style 4',
		),
		array(
			'name'=> esc_html__('Category/Tag Style ','uniqmag'), 
			'std'=> array('1')
			)
		);
	}
	if($sidebarPosition=="custom") {
		$my_meta->addSelect(THEME_NAME.'_sidebar_position',array('right'=>esc_html__('Right','uniqmag'),'left'=>esc_html__('Left','uniqmag')),array('name'=> esc_html__('Main Sidebar Position ','tax-meta'), 'std'=> array('right')));
	}

	$my_meta->addSelect(THEME_NAME.'_sidebar_select', $sidebars ,array('name'=> esc_html__('Main Sidebar','tax-meta'), 'std'=> array('default')));
	

	//category icons
	$icons = Different_Themes()->icons->get_list();
	$icons_new = array();
	foreach ($icons as $icon) {
		$icons_new[$icon] = $icon;	
	}

	if( $taxnow != 'post_tag' ) {
		$my_meta->addSelect(
			THEME_NAME.'_category_icon',
			$icons_new,
			array(
				'name'=> esc_html__('Category Icon ','tax-meta'), 
				'std'=> array('no-icon')
			)
		);
	}
/*
	if($sidebarPosition_2=="custom") {
		$my_meta->addSelect(THEME_NAME.'_sidebar_position_2',array('right'=>esc_html__('Right','uniqmag'),'left'=>esc_html__('Left','uniqmag')),array('name'=> esc_html__('Second Sidebar Position ','tax-meta'), 'std'=> array('right')));
	}
	$my_meta->addSelect(THEME_NAME.'_sidebar_select_2', $sidebarSmall ,array('name'=> esc_html__('Second Sidebar','tax-meta'), 'std'=> array('off')));
*/
	$my_meta->addSelect(THEME_NAME.'_breaking_slider',array('show'=>esc_html__('Show','uniqmag'),'slider_off'=>esc_html__('Hide','uniqmag')),array('name'=> esc_html__('Breaking News Slider','uniqmag'), 'std'=> array('slider_off')));

/*
	if( $taxnow == UNIQMAG_DIFFERENT_THEME_POST_GALLERY.'-cat' ) {
			}

	if($sidebarPosition_2=="custom") {
		$my_meta->addSelect(THEME_NAME.'_sidebar_position_2',array('right'=>esc_html__('Right','uniqmag'),'left'=>esc_html__('Left','uniqmag')),array('name'=> esc_html__('Second Sidebar Position ','tax-meta'), 'std'=> array('right')));
	}
	$my_meta->addSelect(THEME_NAME.'_sidebar_select_2', $sidebarSmall ,array('name'=> esc_html__('Second Sidebar','tax-meta'), 'std'=> array('off')));
*/
	//$my_meta->addSelect(THEME_NAME.'_breaking_slider',array('show'=>esc_html__('Show','uniqmag'),'slider_off'=>esc_html__('Hide','uniqmag')),array('name'=> esc_html__('Breaking News Slider','uniqmag'), 'std'=> array('slider_off')));

	
	$my_meta->Finish();




	


/* -------------------------------------------------------------------------*
 * 					GET META VALUE OUTSIDE THE LOOP							*
 * -------------------------------------------------------------------------*/
 
 function uniqmag_different_themes_meta($id,$value) {
	$meta = get_post_meta($id, $value, true);
	return $meta;
}



/* -------------------------------------------------------------------------*
 * 								GET OPTION									*
 * -------------------------------------------------------------------------*/
 
function uniqmag_different_themes_get_custom_option($id, $type, $echo=false) {
	$config = array(
	   'pages' => array('category',UNIQMAG_DIFFERENT_THEME_POST_GALLERY.'-cat',UNIQMAG_DIFFERENT_THEME_POST_PORTFOLIO.'-cat'),                    // taxonomy name, accept categories, post_tag and custom taxonomies
	   'context' => 'normal',                           // where the meta box appear: normal (default), advanced, side; optional
	   'fields' => array(),                             // list of meta fields (can be added by field arrays)
	   'local_images' => false,                         // Use local or hosted images (meta box images for add/remove)
	   'use_with_theme' => true                        	//change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
	);
	$my_meta = new Tax_Meta_Class($config);
	$value = $my_meta->get_tax_meta($id, THEME_NAME.'_'.$type);
	$my_meta->Finish();

	if($echo!=false) {
		echo esc_html($value);
	} else {
		return $value;
	}
}



/* -------------------------------------------------------------------------*
 * 							MAIN NAV MENU WALKER							*
 * -------------------------------------------------------------------------*/

class different_themes_walker extends Walker_Nav_Menu {

	public static $count = 0;
	public static $style = false;
	public static $parent_menu_type = 0;


    public static function plus_one() {
		return ++self::$count;
	}
    public static function count() {
		return self::$count;
	}
    public static function reset_count($val) {
		self::$count = $val;
	}
	
    public static function set_style($val=false) {
    	if($val=='reset') {
    		return self::$style = false;		
    	} elseif($val) {
    		return self::$style = $val;	
    	} else {
    		return self::$style;	
    	}
    	
	}	



    public static function set_menu_type($val) {
		self::$parent_menu_type = $val;
	}
    public static function menu_type() {
		return self::$parent_menu_type;
	}

    function start_lvl( &$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		$menu_type = $this->menu_type();
		$count = $this->count();
		if($menu_type=="2" && $depth==0) { 
			$output .= "\n$indent<span class=\"site_sub_menu_toggle\"></span>\n";	
			$output .= "\n$indent<ul class=\"dt_mega_menu\"".$this->set_style().">\n";

		} else {
			$output .= "\n$indent<span class=\"site_sub_menu_toggle\"></span>\n";	
			$output .= "\n$indent<ul class=\"sub-menu\"".$this->set_style().">\n";	

		}
		
	}

    function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {
        global $wp_query, $df_menu_catID;
		$config = array(
		   'pages' => array('category',UNIQMAG_DIFFERENT_THEME_POST_GALLERY.'-cat',UNIQMAG_DIFFERENT_THEME_POST_PORTFOLIO.'-cat'),                    // taxonomy name, accept categories, post_tag and custom taxonomies
		   'context' => 'normal',                           // where the meta box appear: normal (default), advanced, side; optional
		   'fields' => array(),                             // list of meta fields (can be added by field arrays)
		   'local_images' => false,                         // Use local or hosted images (meta box images for add/remove)
		   'use_with_theme' => true                        	//change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
		);
		$my_meta = new Tax_Meta_Class($config);
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        if($depth==0) {
        	$this->set_menu_type($item->menu_type);
        	$parent_menu_type = $this->menu_type();
        } else {
       		$parent_menu_type = $this->menu_type();
        }

        if(($item->menu_type=="2" || $item->menu_type=="3") && $depth==0) {
        	$this->reset_count(0);
        	$OTclass = "menu-item-has-children has-cs-mega-menu ";
        } else {
        	$OTclass = "normal-drop ";
        }

        if(!$item->description) {
        	$OTclass .= "  no-description ";
        }


        $class_names = $value = '';

		if($depth==1) {
			$count = $this->plus_one();
		} else {
			$count = $this->count();
		}

		if($count==1 && $depth==2) {
			$megaClass = " color-light";
		} else {
			$megaClass = false;
		}

 		//mega menu with widgets
		if(($parent_menu_type=="2") && ($depth==0)) {
	        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
	        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
	        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
	        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_url( $item->url        ) .'"' : '';
	        
	        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

	        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
	        $class_names = ' class="'.$OTclass. esc_attr( $class_names ).'"';




	        if($item->object=="category") {
				$titleColor = $my_meta->get_tax_meta($item->object_id, THEME_NAME.'_title_color');
			}
			if($item->object=="page") {
				$titleColor = "#".uniqmag_different_themes_meta($item->object_id, "_".THEME_NAME."_title_color"); 	
			}
			
			if(!isset($titleColor) || $titleColor=="#") $titleColor = "#".Different_Themes()->options->get(THEME_NAME."_default_cat_color"); 
			
			if(isset($titleColor) && $item->color=="yes") {
				$style=' style="border-bottom-color: '.$titleColor.'; "';
				$this->set_style($style);
			} else {
				$style = false;
			}

			$output .= $indent . '<li id="menu-item-'. $item->ID . '"'.$value . $class_names.$style.'>';	
			$item_output = $args->before;

			$item_output .= '<a'. $attributes.'>';

		    
		    	
 			$item_output .= '<span>';
	        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			
	        if($item->description) {
	        	//$item_output .= '<div class="subtitle">'.$item->description.'</div>';	
	        }
 			

		   
		   $item_output .= '</span>';


	        $item_output .= '</a>';

	        //$item_output.= $indent . '<span class="site_sub_menu_toggle"></span>';
	        $item_output.= $indent . '<ul class="cs-mega-menu">';
				$item_output.= $indent . '<li>';
						ob_start();
						if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($item->menu_sidebar) ) :
						endif;
						$item_output.= ob_get_contents();
						ob_end_clean();
				$item_output.= $indent . '</li>';	
			$item_output.= $indent . '</ul>';	

			$item_output.= $args->after;

		} else { 	//default menu

	        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

	        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
	        $class_names = ' class="'.$OTclass. esc_attr( $class_names ).'"';
	        

	        if($item->object=="category") {
				$titleColor = $my_meta->get_tax_meta($item->object_id, THEME_NAME.'_title_color');
			}
			if($item->object=="page") {
				$titleColor = "#".uniqmag_different_themes_meta($item->object_id, "_".THEME_NAME."_title_color"); 	
			}
			
			if(!isset($titleColor) || $titleColor=="#") $titleColor = "#".Different_Themes()->options->get(THEME_NAME."_default_cat_color"); 
			if(isset($titleColor) && $item->color=="yes") {
				$style=' style="border-bottom-color:'.$titleColor.'; "';
				$this->set_style($style);
			} else {
				$style = false;
			}

				
			$output .= $indent . '<li id="menu-item-'. $item->ID . '"'.$value . $class_names.$style.'>';	
				


	        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
	        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
	        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
	        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_url( $item->url        ) .'"' : '';
	        //$attributes .= $style;

	        //$attributes .= ' data-id="'. esc_attr( $item->object_id        ) .'"';
	        //$attributes .= ' data-slug="'. esc_attr(  basename(get_permalink($item->object_id )) ) .'"';

	        $item_output = $args->before;
	        $item_output .= '<a'. $attributes .'>';


		    if(isset($item->classes[4]) && in_array("df-dropdown", $item->classes)) {
		      $item_output .= '<span>';
		    } 	
	        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			
			
	        if($item->description) {
	        	//$item_output .= '<div class="subtitle">'.$item->description.'</div>';	
	        }

		    if(isset($item->classes[4]) && in_array("df-dropdown", $item->classes)) {
		      $item_output .= '</span>';
		    } 	


	        $item_output .= '</a>';
        	$item_output .= $args->after;

       		
        }
       

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		$my_meta->Finish();


    }
	
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}
}

/* -------------------------------------------------------------------------*
 * 								TOP NAV MENU WALKER							*
 * -------------------------------------------------------------------------*/

class different_themes_walker_top extends Walker_Nav_Menu {
    function start_lvl( &$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<span class=\"top_sub_menu_toggle\"></span>\n";	
		$output .= "\n$indent<ul class=\"sub-menu\">\n";	
	}


	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        /**
         * Filter the CSS class(es) applied to a menu item's list item element.
         *
         * @since 3.0.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
         * @param object $item    The current menu item.
         * @param array  $args    An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth   Depth of menu item. Used for padding.
         */
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
        /**
         * Filter the ID applied to a menu item's list item element.
         *
         * @since 3.0.1
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
         * @param object $item    The current menu item.
         * @param array  $args    An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth   Depth of menu item. Used for padding.
         */
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
        $output .= $indent . '<li' . $id . $class_names .'>';
        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';
        /**
         * Filter the HTML attributes applied to a menu item's anchor element.
         *
         * @since 3.6.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array $atts {
         *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
         *
         *     @type string $title  Title attribute.
         *     @type string $target Target attribute.
         *     @type string $rel    The rel attribute.
         *     @type string $href   The href attribute.
         * }
         * @param object $item  The current menu item.
         * @param array  $args  An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth Depth of menu item. Used for padding.
         */
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
        $attributes = '';
        foreach ( $atts as $attr => $value ) {
                if ( ! empty( $value ) ) {
                        $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                        $attributes .= ' ' . $attr . '="' . $value . '"';
                }
        }
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
	    if(isset($item->classes[4]) && in_array("df-dropdown", $item->classes)) {
	      $item_output .= '<span>';
	    } 	
        /** This filter is documented in wp-includes/post-template.php */
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
	    if(isset($item->classes[4]) && in_array("df-dropdown", $item->classes)) {
	      $item_output .= '</span>';
	    } 	
        $item_output .= '</a>';
        $item_output .= $args->after;
        /**
         * Filter a menu item's starting output.
         *
         * The menu item's starting output only includes `$args->before`, the opening `<a>`,
         * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
         * no filter for modifying the opening and closing `<li>` for a menu item.
         *
         * @since 3.0.0
         *
         * @param string $item_output The menu item's starting HTML output.
         * @param object $item        Menu item data object.
         * @param int    $depth       Depth of menu item. Used for padding.
         * @param array  $args        An array of {@see wp_nav_menu()} arguments.
         */
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

}
add_filter( 'wp_nav_menu_objects', 'uniqmag_different_themes_add_menu_parent_class' );
function uniqmag_different_themes_add_menu_parent_class( $items ) {
	
	$parents = array();
	foreach ( $items as $item ) {
		if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
			$parents[] = $item->menu_item_parent;
		}
	}
	
	foreach ( $items as $item ) {
		if ( in_array( $item->ID, $parents ) ) {
			$item->classes[] = 'df-dropdown'; 
		}
	}
	
	return $items;    
}


function uniqmag_different_themes_remove_br($subject) {
	$subject = str_replace("<br/>", " ", $subject );
	$subject = str_replace("<br>", " ", $subject );
	$subject = str_replace("<br />", " ", $subject );
	return $subject;
}

function uniqmag_different_themes_get_query_string_paged() {
	global $query_string;
	$pos = strpos($query_string,"paged=");
	if($pos !== false ) {
		$sub = substr($query_string,$pos);
		$posand = strpos($sub,"&");
		if ($posand == 0) {$paged = substr($sub,6);}
		else { $paged = substr($sub,6,$posand-6);}
		return $paged;
	}
	return 0;
}


function uniqmag_different_themes_get_page($name, $type="array") {
	$pages = get_pages();
	$pageID = array();
	foreach($pages as $p) {
		$meta = get_post_custom_values("_wp_page_template",$p->ID);
		if($meta[0] == "template-".$name.".php" || strpos($meta[0],"template-".$name.".php") !== false) {
			$pageID[]=$p->ID;
		}
	}
	if($type=="array") {
		return $pageID;	
	} else {
		if(isset($pageID[0])) {
			return $pageID[0];	
		} else {
			return false;
		}

	}



}

function uniqmag_different_themes_get_page_array($array) {
	$pages = get_pages();
	$pageID = array();
	foreach($array as $name) {
		foreach($pages as $p) {
			$meta = get_post_custom_values("_wp_page_template",$p->ID);
			if($meta[0] == "template-".$name.".php" || strpos($meta[0],"template-".$name.".php") !== false) {
				$pageID[]=$p->ID;
			}
		}
	}
	return $pageID;	
}




/* -------------------------------------------------------------------------*
 * 							GALLERY IMAGE SELECT							*
 * -------------------------------------------------------------------------*/
 
function uniqmag_different_themes_gallery_image_select($id, $value) {
	global $post_id,$post;
	if(!$post_id) {
		$post_id = $post->ID;
	}
	?>
	<div id="df_images_container">
		<ul class="df_gallery_images">
			<?php
				if ( $value ) {
					$product_image_gallery = $value;
				} else {
					// Backwards compat
					$attachment_ids = get_posts( 'post_parent=' . $post_id . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids&meta_value=0' );
					$attachment_ids = array_diff( $attachment_ids, array( get_post_thumbnail_id() ) );
					$product_image_gallery = implode( ',', $attachment_ids );
				}

				$attachments = array_filter( explode( ',', $product_image_gallery ) );

				if ( $attachments )
					foreach ( $attachments as $attachment_id ) {
						echo '<li class="image" data-attachment_id="' . $attachment_id . '">
							' . wp_get_attachment_image( $attachment_id, array(80,80) ) . '
							<ul class="actions">
								<li><a href="#" class="delete" title="' . esc_attr__('Delete image','uniqmag') . '">' . esc_html__('Delete','uniqmag') . '</a></li>
							</ul>
						</li>';
					}
			?>
		</ul>

		<input type="hidden" id="<?php echo esc_attr($id);?>" name="<?php echo esc_attr($id);?>" value="<?php echo esc_attr( $product_image_gallery ); ?>" />

	</div>
	<p class="add_product_images hide-if-no-js">
		<a href="#"><?php esc_html_e('Add images','uniqmag'); ?></a>
	</p>
	<script type="text/javascript">
		jQuery(document).ready(function($){

			// Uploading files
			var product_gallery_frame;
			var $image_gallery_ids = $('#<?php echo esc_attr($id);?>');
			var $df_gallery_images = $('#df_images_container ul.df_gallery_images');

			jQuery('.add_product_images').on( 'click', 'a', function( event ) {

				var $el = $(this);
				var attachment_ids = $image_gallery_ids.val();

				event.preventDefault();

				// If the media frame already exists, reopen it.
				if ( product_gallery_frame ) {
					product_gallery_frame.open();
					return;
				}

				// Create the media frame.
				product_gallery_frame = wp.media.frames.downloadable_file = wp.media({
					// Set the title of the modal.
					title: '<?php esc_html_e('Add Images to Product Gallery','uniqmag'); ?>',
					button: {
						text: '<?php esc_html_e('Add to gallery','uniqmag'); ?>',
					},
					multiple: true
				});

				// When an image is selected, run a callback.
				product_gallery_frame.on( 'select', function() {

					var selection = product_gallery_frame.state().get('selection');

					selection.map( function( attachment ) {

						attachment = attachment.toJSON();

						if ( attachment.id ) {
							attachment_ids = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;

							$df_gallery_images.append('\
								<li class="image" data-attachment_id="' + attachment.id + '">\
									<img src="' + attachment.url + '" width="80" height="80"/>\
									<ul class="actions">\
										<li><a href="#" class="delete" title="<?php echo addslashes(esc_html__('Delete image','uniqmag')); ?>"> <?php echo addslashes(esc_html__('Delete','uniqmag')); ?></a></li>\
									</ul>\
								</li>');
						}

					} );

					$image_gallery_ids.val( attachment_ids );
				});

				// Finally, open the modal.
				product_gallery_frame.open();
			});

			// Image ordering
			$df_gallery_images.sortable({
				items: 'li.image',
				cursor: 'move',
				scrollSensitivity:40,
				forcePlaceholderSize: true,
				forceHelperSize: false,
				helper: 'clone',
				opacity: 0.65,
				placeholder: 'wc-metabox-sortable-placeholder',
				start:function(event,ui){
					ui.item.css('background-color','#f6f6f6');
				},
				stop:function(event,ui){
					ui.item.removeAttr('style');
				},
				update: function(event, ui) {
					var attachment_ids = '';

					$('#df_images_container ul li.image').css('cursor','default').each(function() {
						var attachment_id = jQuery(this).attr( 'data-attachment_id' );
						attachment_ids = attachment_ids + attachment_id + ',';
					});

					$image_gallery_ids.val( attachment_ids );
				}
			});

			// Remove images
			$('#df_images_container').on( 'click', 'a.delete', function() {

				$(this).closest('li.image').remove();

				var attachment_ids = '';

				$('#df_images_container ul li.image').css('cursor','default').each(function() {
					var attachment_id = jQuery(this).attr( 'data-attachment_id' );
					attachment_ids = attachment_ids + attachment_id + ',';
				});

				$image_gallery_ids.val( attachment_ids );

				return false;
			} );

		});
	</script>
	<?php

}


function uniqmag_different_themes_follow() {
		echo "<!-- BEGIN .follow -->";
		echo "<div class=\"follow\">";
			echo "<p>Follow Different Themes</p>";
			echo "<a href=\"//themeforest.net/user/different-themes?ref=different-themes\" class=\"themeforest\" target=\"blank\">Theme Forest</a>";
			echo "<a href=\"//twitter.com/#!/differentthemes\" class=\"twitter\" target=\"blank\">Twitter</a>";
			echo "<a href=\"//www.different-themes.com/\" class=\"differentthemes\" target=\"blank\">Different-Themes.com</a>";
		echo "<!-- END .follow -->";
		echo "</div>";
	}	
	

	
$uploadsdir=wp_upload_dir();
define("THEME_UPLOADS_URL", $uploadsdir['url']);



/* -------------------------------------------------------------------------*
 * 							GET VIDEO TYPE								*
 * -------------------------------------------------------------------------*/
 
function uniqmag_different_themes_get_video_type( $code ) {
	if (strpos($code, "dailymotion.com") !== false) {
	    return 'dailymotion';
	} else if (strpos($code, "twitch.tv") !== false) {
	    return 'twitch';
	} else if (strpos($code, "vine.co") !== false) {
	    return 'vine';
	} else if (strpos($code, "vimeo.com") !== false) {
	    return 'vimeo';
	} else if (strpos($code, "soundcloud.com") !== false) {
	    return 'soundcloud';
	} else if (strpos($code, "mixcloud.com") !== false) {
	    return 'mixcloud';
	} else if (strpos($code, "youtube.com") !== false || strpos($code, "youtu.be") !== false) {
	    return 'youtube';
	} else { 
		return false;
	}
}



/* -------------------------------------------------------------------------*
 * 							REMOTE THUMBNAIL UPLOAD							*
 * -------------------------------------------------------------------------*/

function uniqmag_different_themes_image_upload($thumbnail, $postID, $desc = null) {
	if(!function_exists('download_url')) {
    	require_once(ABSPATH . "wp-admin" . '/includes/image.php');
   	 	require_once(ABSPATH . "wp-admin" . '/includes/file.php');
   	 	require_once(ABSPATH . "wp-admin" . '/includes/media.php');
    }

    // Download file to temp location
    $tmp = download_url( $thumbnail );
    // Set variables for storage
    // fix file filename for query strings
    preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $thumbnail, $matches);
    $file_array['name'] = basename($matches[0]);
    $file_array['tmp_name'] = $tmp;
    // If error storing temporarily, unlink
    if ( is_wp_error( $tmp ) ) {
        @unlink($file_array['tmp_name']);
        $file_array['tmp_name'] = '';
    }
    // do the validation and storage stuff
    $id = media_handle_sideload( $file_array, $postID, null );
    // If error storing permanently, unlink
    if ( is_wp_error($id) ) {@unlink($file_array['tmp_name']);}
    add_post_meta($postID, '_thumbnail_id', $id, true);
}

/* -------------------------------------------------------------------------*
 * 							GET VIDEO THUMBNAIL								*
 * -------------------------------------------------------------------------*/
 
function uniqmag_different_themes_video_thumbnail( $code, $postID ) {
	$Different_Themes_Other = new Different_Themes_Other();

	$time = get_post_modified_time('U',false,$postID);
	if(!isset($time)){
		$time = "0";
	}

	$thumb = get_post_meta($postID, '_thumbnail_id', true);
	if($thumb !== false && $thumb) {
		//check if a thumbnail exists
		$thumbnail = uniqmag_different_themes_get_post_thumb($postID,670,377); 
		return $thumbnail['src'];
	} else {

		$videoType = uniqmag_different_themes_get_video_type($code); 
		//Dailymotion thumbnail

		if($videoType=="dailymotion") {
			preg_match('#<object[^>]+>.+?//www.dailymotion.com/swf/video/([A-Za-z0-9]+).+?</object>#s', $code, $matches);

	        // Dailymotion url
	        if(!isset($matches[1])) {
	            preg_match('#//www.dailymotion.com/video/([A-Za-z0-9]+)#s', $code, $matches);
	        }

	        // Dailymotion iframe
	        if(!isset($matches[1])) {
	            preg_match('#//www.dailymotion.com/embed/video/([A-Za-z0-9]+)#s', $code, $matches);
	        }
	 		$id =  $matches[1];

			$thumbnail ="https://api.dailymotion.com/video/".$id."?fields=thumbnail_large_url";
			$thumbnail = $Different_Themes_Other->json_response($thumbnail, true);
			$thumbnail = $thumbnail['thumbnail_large_url'];

		} else if ($videoType=="twitch") {
			preg_match('#<object (.*)><param name=["|\']flashvars["|\'] value=["|\'](.*)["|\'] (.*)><\/object>#s', $code, $matches);

			if (strpos($matches[2], "chapter_id")) {
			    preg_match('/chapter_id=([^"]+)/', $matches[2], $match);
				$id = $match[1];

				$type = "a";
				$thumbnail = $Different_Themes_Other->json_response("https://api.twitch.tv/kraken/videos/".$type.$id, true);
				$thumbnail = $thumbnail['preview'];
				if(!$thumbnail) {
					$type = "b";
					$thumbnail = $Different_Themes_Other->json_response("https://api.twitch.tv/kraken/videos/".$type.$id, true);	
					$thumbnail = $thumbnail['preview'];
					if(!$thumbnail) {
						$type = "c";
						$thumbnail = $Different_Themes_Other->json_response("https://api.twitch.tv/kraken/videos/".$type.$id, true);	
						$thumbnail = $thumbnail['preview'];
					} else {
						$thumbnail = $thumbnail['preview'];
					}
				} else {
					$thumbnail = $thumbnail['preview'];
				}


			} else if (strpos($matches[2], "archive_id")) {
			    preg_match('/archive_id=([^"]+)/', $matches[2], $match);
				$id = $match[1];

				$type = "a";
				$thumbnail = $Different_Themes_Other->json_response("https://api.twitch.tv/kraken/videos/".$type.$id, true);
				if(!isset($thumbnail['preview'])) {
					$type = "b";
					$thumbnail = $Different_Themes_Other->json_response("https://api.twitch.tv/kraken/videos/".$type.$id, true);	
					if(!isset($thumbnail['preview'])) {
						$type = "c";
						$thumbnail = $Different_Themes_Other->json_response("https://api.twitch.tv/kraken/videos/".$type.$id, true);	
					} else {
						$thumbnail = $thumbnail['preview'];
					}
				} else {
					$thumbnail = $thumbnail['preview'];
				}

			} else {
			    preg_match('/channel=([a-zA-Z0-9_]\w*)/', $matches[2], $match);
				$channel = $match[1];
				$thumbnail = $Different_Themes_Other->json_response("https://api.twitch.tv/kraken/channels/$channel/videos", true);

				$thumbnail = $thumbnail['videos'][0]['preview'];


			}
			
		} else if($videoType=="youtube") { // get youtube thumbnail
			preg_match('#<iframe(.*)([^src]*)(src=)([\'\"]?)([^>\s\'\"]+)([\'\"]?)#s', $code, $matches);
			$id = uniqmag_different_themes_youtube_image($matches[5]);
			$thumbnail = "http://img.youtube.com/vi/".$id."/maxresdefault.jpg";
			
		} else if($videoType=="vine") { // get vine thumbnail
			preg_match('#<iframe(.*)([^src]*)(src=)([\'\"]?)([^>\s\'\"]+)([\'\"]?) (.*)><\/iframe>#s', $code, $matches);  // get src
			preg_match("#(?<=vine.co/v/)[0-9A-Za-z]+#", $matches[5], $match);  // get video id

			$args = array(
				'timeout' => '10',
				'redirection' => '10',
				'sslverify' => false // for localhost
			);

			$vine = wp_remote_get("https://vine.co/v/".$match[0], $args);

			preg_match('/property="og:image" content="(.*?)"/', $vine['body'], $match);

			$thumbnail = $match[1];

			
		} else if($videoType=="vimeo") { // get vimeo thumbnail
			preg_match('#<iframe(.*)([^src]*)(src=)([\'\"]?)([^>\s\'\"]+)([\'\"]?)#s', $code, $matches);
			$id = uniqmag_different_themes_youtube_image($matches[5]);
			$id = explode("?", $id, 2);

			$url = "http://vimeo.com/api/v2/video/".$id[0].".xml";
			$args = array(
				'timeout' => '10',
				'redirection' => '10',
				'sslverify' => false // for localhost
			);
				
			
			$raw = wp_remote_get( $url, $args );
			$hash = simplexml_load_string($raw['body']);
			$thumbnail = $hash[0]->video->thumbnail_large;

			
		}

		//retunr a thumbnail if it's set
		if(isset($thumbnail)) {
			uniqmag_different_themes_image_upload($thumbnail,$postID);
			return $thumbnail;
		} else {
			return false;
		}
	}

	
}


/* -------------------------------------------------------------------------*
 * 								NEWS PAGE TITLE								*
 * -------------------------------------------------------------------------*/
 
function uniqmag_different_themes_page_title() {
	$post_type = get_post_type();
	//check if bbpress
	if (function_exists("is_bbpress") && is_bbpress()) {
		$OTbbpress = true;
	} else {
		$OTbbpress = false;
	}

	if(!is_archive() && !is_category() && !is_search() && $post_type!=UNIQMAG_DIFFERENT_THEME_POST_GALLERY && $post_type!=UNIQMAG_DIFFERENT_THEME_POST_PORTFOLIO) {
		$title = get_the_title(Different_Themes()->page_id());
	} else if(is_single() && $post_type==UNIQMAG_DIFFERENT_THEME_POST_GALLERY) {
		$galID = uniqmag_different_themes_get_page('gallery-1');
		$title = get_the_title($galID[0]);
	}  else if(is_single() && $post_type==UNIQMAG_DIFFERENT_THEME_POST_PORTFOLIO) {
		$portID = uniqmag_different_themes_get_page(UNIQMAG_DIFFERENT_THEME_POST_PORTFOLIO);
		$title = get_the_title($portID[0]);
	}  else if(is_search()) {
		$title = esc_html__("Search Results for",'uniqmag')." \"".esc_html($_GET['s'])."\"";
	} else if(is_category()) {
		$category = get_category( get_query_var( 'cat' ) );
		$cat_id = $category->cat_ID;
		$catName = get_category($cat_id )->name;
		$title = $catName;
	} else if (is_author()) {
		$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
		$title = esc_html__("Posts From",'uniqmag'). " ".$curauth->display_name;
	} else if(is_tag()) {
		$category = single_tag_title('',false);
		$title =  esc_html__("Tag",'uniqmag')." \"".$category."\"";
	} else if(is_tax()) {
		$category = single_tag_title('',false);
		$title = $category;
	} else if(is_archive()) {
		if(Different_Themes()->woocommerce->is_activated() == true && is_woocommerce() && $OTbbpress!=true) {
			$title = woocommerce_page_title(false);
		} elseif( $OTbbpress==true) {
			$title = get_the_title(get_the_ID());
		} else {
			$title = esc_html__("Archive",'uniqmag');	
		}
	}else {
		$title = get_the_title(Different_Themes()->page_id());
	}
	echo esc_html(stripslashes($title));
}




/* -------------------------------------------------------------------------*
 * 							UPDATE POST VIEW COUNT							*
 * -------------------------------------------------------------------------*/
 
function uniqmag_different_themes_setPostViews() {
	global $post;
	if(is_single() && isset($post)) {
		$postID = $post->ID;
		$count_key = "_".THEME_NAME.'_post_views_count';
		$count = get_post_meta($postID, $count_key, true);
		
		if ( !current_user_can( 'manage_options' ) && !isset($_COOKIE[THEME_NAME."_post_views_count_".$postID])) {
			if ( $count=='' ) {
				delete_post_meta($postID, $count_key);
				add_post_meta($postID, $count_key, '0');
			} else {
				$count++;
				update_post_meta($postID, $count_key, $count, $count-1);
			}
			
			setcookie(THEME_NAME."_post_views_count_".$postID, "1", time()+2678400); 
		}

	}
}

/* -------------------------------------------------------------------------*
 * 							GET POST VIEW COUNT								*
 * -------------------------------------------------------------------------*/
 
function uniqmag_different_themes_getPostViews($postID, $text = false){
    $count_key = "_".THEME_NAME.'_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
   
   if( $count=='' ){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        $count = 0;
    }
	if( $text!=false) {
		if($count==1) {
			$text = esc_html__('view','uniqmag');
		} else {
			$text = esc_html__('views','uniqmag');
		}
	}

	if($text==false) {
		 return $count;
	} else {
		 return $count.' '.$text;
	}
   
}



 /* -------------------------------------------------------------------------*
 * 						ADD CUSTOM TEXT FORMATTING BUTTONS					*
 * -------------------------------------------------------------------------*/

if( function_exists( 'different_themes_shortcodes_active' ) ) { 
	function uniqmag_different_themes_shortcode_buttons() {
		$buttons = array("differentthemesbutton", "differentthemesspacer", "differentthemesquote","differentthemesblocktext", "|", "|",
				 "differentthemeslists", "|","differentthemesvideo" ,"differentthemesmarker","differentthemestabs","differentthemesdropcaps", "differentthemestables", "|",
				 "differentthemescaption", "|", "differentthemesparagraph", "differentthemesparagraph2", "differentthemesparagraph5", "differentthemesparagraph3", "differentthemesparagraph4", "differentthemesalert", "differentthemesaccordion", "|", "differentthemesbreak");
		
		//add gallery shortcode if gallery plugin is active
		if(function_exists('different_theme_gallery_active')) {

			array_push($buttons, 'differentthemesgallery');
		}

		return $buttons;
	}




	function uniqmag_different_themes_add_buttons() {
	   if ( get_user_option('rich_editing') == 'true') {
	     add_filter('mce_external_plugins', 'uniqmag_different_themes_add_btn_tinymce_plugin');
	     add_filter('mce_buttons_3', 'uniqmag_different_themes_register_buttons');
	     add_filter('df_mce_external_plugins', 'uniqmag_different_themes_add_btn_tinymce_plugin');
	     add_filter('df_mce_buttons_3', 'uniqmag_different_themes_register_buttons');
	   }
	}

	add_action('init', 'uniqmag_different_themes_add_buttons');
	function uniqmag_different_themes_register_buttons($buttons) {
		global $differentthemes_buttons;
			
	   array_push($buttons, implode(",",uniqmag_different_themes_shortcode_buttons()));
	   return $buttons;
	}

	function uniqmag_different_themes_add_btn_tinymce_plugin($plugin_array) {
		$buttons = uniqmag_different_themes_shortcode_buttons();
		
		foreach($buttons as $btn){
			$plugin_array[$btn] = UNIQMAG_DIFFERENT_THEME_ADMIN_URL.'buttons-formatting/editor-plugin.js';
		}
		return $plugin_array;

	}
	
}
 /* -------------------------------------------------------------------------*
 * 						PAGE BUILDER EDITOR JS					*
 * -------------------------------------------------------------------------*/
 function uniqmag_different_themes_editor_js() {
 ?>
 	<script type="text/javascript">
		OTtinymceSettings = {	
			theme:"modern",
			skin:"lightgray",
			language:"en",
			formats:{
				alignleft: [
					{selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li', styles: {textAlign:'left'}},
					{selector: 'img,table,dl.wp-caption', classes: 'alignleft'}
				],
				aligncenter: [
					{selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li', styles: {textAlign:'center'}},
					{selector: 'img,table,dl.wp-caption', classes: 'aligncenter'}
				],
				alignright: [
					{selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li', styles: {textAlign:'right'}},
					{selector: 'img,table,dl.wp-caption', classes: 'alignright'}
				],
				strikethrough: {inline: 'del'}
			},
			relative_urls:false,
			remove_script_host:false,
			convert_urls:false,
			browser_spellcheck:true,
			keep_styles:false,
			preview_styles:"font-family font-size font-weight font-style text-decoration text-transform",
			plugins:"charmap,colorpicker,hr,lists,media,paste,tabfocus,textcolor,fullscreen,wordpress,wpautoresize,wpeditimage,wpgallery,wplink,wpdialogs,wpview",
			external_plugins:{
<?php
			$df_mce_external_plugins = apply_filters( 'df_mce_external_plugins', array() );
			foreach ( $df_mce_external_plugins as $name => $url ) {
				echo '"'.$name.'":"'.set_url_scheme($url).'",';
			}
?>
			},
			selector:"#active-homepage-blocks .df-tinymce",
			resize:false,
			menubar:false,
			indent:false,
			toolbar1:"bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,wp_fullscreen,wp_adv",
			toolbar2:"formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help",
			toolbar3:"<?php $df_mce_buttons_3 = apply_filters( 'df_mce_buttons_3', array() );echo implode($df_mce_buttons_3, ',');?>",
			body_class:"content post-type-page post-status-publish",
		};
	</script>
 <?php
 }

/* -------------------------------------------------------------------------*
 * 							COUNT ATTACHMENTS								*
 * -------------------------------------------------------------------------*/
 
function uniqmag_uniqmag_different_themes_attachment_count($post_id = false) {
	global $post;
    //Get all attachments
    $attachments = get_posts( array(
        'post_type' => 'attachment',
        'posts_per_page' => -1
    ) );

    $att_count = 0;
    if ( $attachments ) {
        foreach ( $attachments as $attachment ) {
            // Check for the post type based on individual attachment's parent
            if ( UNIQMAG_DIFFERENT_THEME_POST_GALLERY == get_post_type($attachment->post_parent) && $post_id == $attachment->post_parent ) {
                $att_count = $att_count + 1;
            } else if (UNIQMAG_DIFFERENT_THEME_POST_GALLERY == get_post_type($attachment->post_parent) && $post_id == false) {
				$att_count = $att_count + 1;
			}
        }
    }
	 return $att_count;
}

/* -------------------------------------------------------------------------*
 * 							GALLERY IMAGE COUNT								*
 * -------------------------------------------------------------------------*/
 
function uniqmag_different_themes_image_count($post_id = false) {
    //Get all images
   	$galleryImages = get_post_meta ( $post_id, "different_themes_gallery_gallery_images", true ); 
   	$imageIDs = explode(",",$galleryImages);
   	$att_count = count(array_filter($imageIDs));

	return $att_count;
}

/* -------------------------------------------------------------------------*
 * 							CHECK PAGE TEMPLATE								*
 * -------------------------------------------------------------------------*/
 
function uniqmag_different_themes_is_template_active($pagetemplate = '') {
	global $wpdb;
	$meta_key = '_wp_page_template';
	$result = $wpdb->get_var( $wpdb->prepare( 
		"SELECT meta_key
			FROM $wpdb->postmeta 
			WHERE meta_key like %s
			AND meta_value like '%s'
		", 
		$wpdb->esc_like($meta_key),
		$wpdb->esc_like($pagetemplate)
	) );

	if ($result) {
		return TRUE;
	} else {
		return FALSE;
	}
}



/* -------------------------------------------------------------------------*
 * 								GET GOOGLE FONTS							*
 * -------------------------------------------------------------------------*/
 
function uniqmag_different_themes_get_google_fonts($sort = "alpha") {

	$font_list = Different_Themes()->options->get(THEME_NAME."_google_font_list");
	$font_list_time = Different_Themes()->options->get(THEME_NAME."_google_font_list_update");
	$now = time();
	$interval = 41600;
	
	if($font_list && (( $now - $font_list_time ) < $interval)) {
		$font_list = $font_list;
	} else if(!$font_list || (( $now - $font_list_time ) > $interval)) {
		$url = "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyCpatq_HIaUbw1XUxVAellP4M1Uoa6oibU&sort=" . $sort;
		$result = Different_Themes()->other->json_response( $url );

		if($result!=false) {
			$font_list = array();
			foreach ( $result->items as $font ) {

				$font_list[] .= $font->family;
				
			}

		Different_Themes()->options->update(THEME_NAME."_google_font_list",$font_list);
		Different_Themes()->options->update(THEME_NAME."_google_font_list_update",time());
		} else {
			$font_list = false;
		}

	} else {
		$font_list = false;
	}

		
	return $font_list;
	
}


/* -------------------------------------------------------------------------*
 * 								PASSWORD									*
 * -------------------------------------------------------------------------*/
function uniqmag_different_themes_password_form() {
    global $post;
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
    $o = '<form class="post-password-form" action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
        ' . esc_html__("This content is password protected. To view it please enter your password below:",'uniqmag') . '
        <label for="' . $label . '">' . esc_html__("Password:",'uniqmag') . ' </label>'
        . '<input name="post_password" id="' . $label . '" type="password" />'
        . '<input type="submit" name="Submit" value="' . esc_attr__("Submit",'uniqmag') . '" />
    </form>
    ';
    return $o;
}

add_filter( 'the_password_form', 'uniqmag_different_themes_password_form' );

/* -------------------------------------------------------------------------*
 * 								MENU NAME									*
 * -------------------------------------------------------------------------*/
 
function uniqmag_different_themes_get_theme_menu_name( $theme_location ) {
	if( ! $theme_location ) return false;
 
	$theme_locations = get_nav_menu_locations();
	if( ! isset( $theme_locations[$theme_location] ) ) return false;
 
	$menu_obj = get_term( $theme_locations[$theme_location], 'nav_menu' );
	if( ! $menu_obj ) $menu_obj = false;
	if( ! isset( $menu_obj->name ) ) return false;
 
	return $menu_obj->name;
}





/* -------------------------------------------------------------------------*
 * 							COMMENT FORMATION								*
 * -------------------------------------------------------------------------*/

function uniqmag_different_themes_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	global $differentThemesCommentID;


	if($depth==1) {
		$differentThemesCommentID = $differentThemesCommentID+1;
	}

	if($comment->user_id == get_the_author_meta('ID')) {
		$class = "user-author";
	} else {
		$class = false;
	}


   ?>
	<li <?php comment_class('cs-comment'); ?> id="li-comment-<?php comment_ID(); ?>">
		<article<?php if($class) echo ' class="'.$class.'"';?>>
	        <div class="cs-comment-author">
	        	<?php if( get_avatar( $comment, 80 ) ) { ?>
	        		<?php 
	        			echo get_avatar( $comment, 80, null, null, array( 'class' => array( 'cs-avatar' ) ) ); 
	        		?>
				<?php } ?>
	            <b>
	            	<a href="<?php if(get_comment_author_url()) { echo esc_url(get_comment_author_url());} else { echo "#"; } ?>">
	            		<?php comment_author();?>
	            	</a>
	            </b>
	            <a class="cs-comment-metadata" href="#">
	                <time datetime="<?php comment_date("c");?>">
						<?php printf(esc_html__(' %1$s, at %2$s','uniqmag'), get_comment_date("F d"), get_comment_time("H:i"));?>
	                </time>
	            </a>
	        </div>
            <div class="cs-comment-content">
                <?php comment_text(); ?>
                <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => ''.( esc_html__('Reply','uniqmag')).''))) ?>
            </div>
        </article>
    </li>
    <?php if($comment->user_id == get_the_author_meta('ID')) { } ?>                

<?php
       }
	

	/* Fix pagination issue caused by Facebook plugin */

	function uniqmag_different_themes_fb_plugin_pagination_fix() {

	  //Check if plugin is activated and if we are on the homepage
	  if(class_exists('Facebook_Loader') && is_front_page()){
	    global $wp_query;
	    $page = get_query_var('page');
	    $paged = get_query_var('paged');

	    //Check if we are trying to reach pagination link
	    if($page > 1 || $paged > 1){
	      unset($wp_query->queried_object);
	     }

	  }

	}


add_action( 'admin_print_scripts', 'uniqmag_different_themes_editor_js' );
add_action( 'wp', 'uniqmag_different_themes_fb_plugin_pagination_fix', 99 );


add_theme_support('automatic-feed-links' ); 
add_filter('wp', 'uniqmag_different_themes_setPostViews');


?>