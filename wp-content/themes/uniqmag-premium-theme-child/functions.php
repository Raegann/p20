<?php



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



// Our custom post type function
function create_posttype() {

	register_post_type( 'workingplaces',
	// CPT Options
		array(
			'labels' => array(
				'name' => __( 'Pracovní místa' ),
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
    $args = array(
            'public'                => true,
            'publicly_queryable'    => true,
            'show_in_nav_menus'     => true,
            'has_archive'           => true,
            'rewrite'               => array ('slug' => 'galerie', 'with_front' => true)
    );
    return $args;
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

