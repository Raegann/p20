<?php
define("UNIQMAG_CHILD_THEME_INCLUDES", "includes/");

include_once get_stylesheet_directory() . '/includes/widgets/class-ys-widget-recent-posts.php';
add_action( 'widgets_init', function(){
	register_widget( 'YS_Widget_Recent_Posts' );
});

include_once get_stylesheet_directory() . '/includes/widgets/class-ys-widget-workingplaces.php';
add_action( 'widgets_init', function(){
	register_widget( 'YS_Widget_Working_Places' );
});

include_once get_stylesheet_directory() . '/includes/widgets/class-ys-widget-actions.php';
add_action( 'widgets_init', function(){
	register_widget( 'YS_Widget_Actions' );
});

function ys_enqueue_scripts(){
    wp_enqueue_script('ys-scripts', get_stylesheet_directory_uri(). '/js/scripts.js', array('jquery'), null, true);
}
add_action( 'wp_enqueue_scripts', 'ys_enqueue_scripts' );

function ys_enqueue_admin_scripts($hook) {
    if ( 'post-new.php' != $hook ) {
        return;
    }

    wp_enqueue_script( 'ys_admin_scripts', get_stylesheet_directory_uri() . '/js/admin_scripts.js', array('jquery','jquery-uniform') );
}
add_action( 'admin_enqueue_scripts', 'ys_enqueue_admin_scripts' );

// Our custom post type function
function create_posttype() {

	register_post_type( 'workingplaces',
	// CPT Options
		array(
			'labels' => array(
				'name' => __( 'Nabídka volných pracovních míst' ),
				'singular_name' => __( 'Pracovní místa' )
			),
			'public' => true,
			'has_archive' => true,
                        'supports' => array( 'title','editor','custom-fields'),
                        'menu_icon' => 'dashicons-admin-users',
                        'rewrite' => array('slug' => 'pracovni-mista'),
		)
	);
        
        $labels = array(
            'name' => 'Profese',
            'singular_name' => 'Profese',
            'search_items' =>  'Hledat profese',
            'popular_items' => 'Oblíbené Profese',
            'all_items' => 'Všechny Profese',
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => 'Editovat Profese',
            'update_item' => 'Uložit Profesi',
            'add_new_item' => 'Přidat Profesi',
            'new_item_name' => 'Nové jméno Profese',
            'separate_items_with_commas' => 'Oddělte Profese čárkami',
            'add_or_remove_items' => 'Přidat nebo Odebrat Profese',
            'choose_from_most_used' => 'Zvolit z nejčastěji používaných Profesí',
            'menu_name' => 'Profese',   
        );  
        
        register_taxonomy('profession','workingplaces',array(
            'hierarchical' => false,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'profese' ),
        ));
        
        
        
    /*
        register_post_type( 'action',
	// CPT Options
		array(
			'labels' => array(
				'name' => __( 'Akce' ),
				'singular_name' => __( 'Akce' )
			),
			'public' => true, 
			'has_archive' => true,
                        'supports' => array( 'title','editor'),
                        'menu_icon' => 'dashicons-format-audio',
                        'rewrite' => array('slug' => 'akce'),
		)
	);*/
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );

function change_gallery_args(){

    $default_arr = array(
            'labels'        => array(
                    'name'               => __( 'Galleries', 'foogallery' ),
                    'singular_name'      => __( 'Gallery', 'foogallery' ),
                    'add_new'            => __( 'Add Gallery', 'foogallery' ),
                    'add_new_item'       => __( 'Add New Gallery', 'foogallery' ),
                    'edit_item'          => __( 'Edit Gallery', 'foogallery' ),
                    'new_item'           => __( 'New Gallery', 'foogallery' ),
                    'view_item'          => __( 'View Gallery', 'foogallery' ),
                    'search_items'       => __( 'Search Galleries', 'foogallery' ),
                    'not_found'          => __( 'No Galleries found', 'foogallery' ),
                    'not_found_in_trash' => __( 'No Galleries found in Trash', 'foogallery' ),
                    'menu_name'          => foogallery_plugin_name(),
                    'all_items'          => __( 'Galleries', 'foogallery' )
            ),
            'hierarchical'          => false,
            'public'                => true,
            'publicly_queryable'    => true,
            'has_archive'           => true,
            'rewrite'               => array ('slug' => 'galerie', 'with_front' => true),
            'show_ui'               => true,
            'show_in_menu'          => true,
            'show_in_nav_menus'     => true,
            'menu_icon'             => 'dashicons-format-gallery',
            'supports'              => array( 'title', 'thumbnail', ),
    );

    return $default_arr;
}
add_filter('foogallery_gallery_posttype_register_args','change_gallery_args');


/**
 * Filter the except length to 45 characters.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function ys_custom_excerpt_length( $length ) {
    return 45;
}
add_filter( 'excerpt_length', 'ys_custom_excerpt_length', 999 );

function wpdocs_child_theme_setup() {
    load_theme_textdomain( 'uniqmag-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'wpdocs_child_theme_setup' );


function uniqmag_child_different_themes_page_title() {
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
		$title = esc_html__("Posts From",'uniqmag-child'). " ".$curauth->display_name;
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
                    $postType = get_queried_object();
                    $postType_name = $postType->labels->name;
                    if(isset($postType_name) && $postType_name !== null && $postType_name != '') :
                        $title = esc_html__($postType_name,'uniqmag-child');
                    else :
			$title = esc_html__("Archive",'uniqmag-child');	
                    endif;
		}
	}else {
		$title = get_the_title(Different_Themes()->page_id());
	}
	echo esc_html(stripslashes($title));
}

function filter_events($posts)
{
    
    return $posts;
}
add_filter('tribe_get_list_widget_events','filter_events');