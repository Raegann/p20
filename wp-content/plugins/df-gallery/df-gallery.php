<?php
/*
Plugin Name: Different Themes Gallery
Plugin URI: http://www.different-themes.com/
Description: Gallery plugin for Different Themes themes
Version: 1.0
Author: Different Themes
Author URI: http://www.different-themes.com/
License: GPL
*/

define("PLUGIN_NAME", 'different_themes_gallery');
define("PLUGIN_FULL_NAME", 'Different Themes Gallery');
if ( ! defined( 'UNIQMAG_DIFFERENT_THEME_POST_GALLERY' ) ) {
	define( 'UNIQMAG_DIFFERENT_THEME_POST_GALLERY', 'gallery' );
}



/* Runs when plugin is activated */
register_activation_hook(__FILE__,'different_themes_gallery'); 

function different_themes_gallery() {
	/* Creates new database field */
	add_option("different_themes_gallery_items", '8', '', 'yes');
	add_option("different_themes_similar_posts_gallery", 'custom', '', 'yes');
}

function different_theme_gallery_active() {
	return true;
}

class df_PageTemplater {

    /**
     * A reference to an instance of this class.
     */
    private static $instance;

    /**
     * The array of templates that this plugin tracks.
     */
    protected $templates;

    /**
     * Returns an instance of this class. 
     */
    public static function get_instance() {

            if( null == self::$instance ) {
                    self::$instance = new df_PageTemplater();
            } 

            return self::$instance;

    } 

    /**
     * Initializes the plugin by setting filters and administration functions.
     */
    private function __construct() {

            $this->templates = array();


            // Add a filter to the attributes metabox to inject template into the cache.
            add_filter(
				'page_attributes_dropdown_pages_args',
				 array( $this, 'register_project_templates' ) 
			);


            // Add a filter to the save post to inject out template into the page cache
            add_filter(
				'wp_insert_post_data', 
				array( $this, 'register_project_templates' ) 
			);


            // Add a filter to the template include to determine if the page has our 
			// template assigned and return it's path
            add_filter(
				'template_include', 
				array( $this, 'view_project_template') 
			);

        
            // Add your templates to this array.
            $this->templates = array(
                    'template-gallery-1.php'     => esc_html('Photo Gallery', PLUGIN_NAME),
            );	
            

			
    } 


    /**
     * Adds our template to the pages cache in order to trick WordPress
     * into thinking the template file exists where it doens't really exist.
     *
     */

    public function register_project_templates( $atts ) {

            // Create the key used for the themes cache
            $cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

            // Retrieve the cache list. 
			// If it doesn't exist, or it's empty prepare an array
            $templates = wp_get_theme()->get_page_templates();
            if ( empty( $templates ) ) {
                    $templates = array();
            } 

            // New cache, therefore remove the old one
            wp_cache_delete( $cache_key , 'themes');

            // Now add our template to the list of templates by merging our templates
            // with the existing templates array from the cache.
            $templates = array_merge( $templates, $this->templates );

            // Add the modified cache to allow WordPress to pick it up for listing
            // available templates
            wp_cache_add( $cache_key, $templates, 'themes', 1800 );

            return $atts;

    } 

    /**
     * Checks if the template is assigned to the page
     */
    public function view_project_template( $template ) {

            global $post;

            if (!isset($this->templates[get_post_meta( 
				$post->ID, '_wp_page_template', true 
			)] ) ) {
				
                    return $template;
					
            } 

            $file = plugin_dir_path(__FILE__). get_post_meta( 
				$post->ID, '_wp_page_template', true 
			);
			
            // Just to be safe, we check if the file exist first
            if( file_exists( $file ) ) {
                    return $file;
            } 
			else { echo $file; }

            return $template;

    } 


} 

add_action( 'init', array( 'df_PageTemplater', 'get_instance' ) );

if ( is_admin() ){

	/* Call the html code */
	add_action('admin_menu', 'different_themes_admin_menu');
	add_action( 'admin_init', 'my_plugin_admin_init' );

	function different_themes_admin_menu() {
		add_action( 'admin_print_styles', 'my_plugin_admin_styles' );
	}

   	function my_plugin_admin_init() {
       	/* Register our stylesheet. */
       	wp_register_style( PLUGIN_NAME, plugins_url('css/admin-style.css', __FILE__) );
   	}

    function my_plugin_admin_styles() {
		wp_enqueue_style( PLUGIN_NAME );
   	}
}

// register custom post type
add_action('init', 'create_gallery');
function create_gallery() {
		
	$labels = array(
    'name' => _x('Gallery', PLUGIN_NAME),
    'singular_name' => _x('Gallery Menu', PLUGIN_NAME),
    'add_new' => _x('Add New', PLUGIN_NAME),
    'add_new_item' => esc_html__('Add New Item', PLUGIN_NAME),
    'edit_item' => esc_html__('Edit Item', PLUGIN_NAME),
    'new_item' => esc_html__('New Gallery Item', PLUGIN_NAME),
    'view_item' => esc_html__('View Item', PLUGIN_NAME),
    'search_items' => esc_html__('Search Gallery Items', PLUGIN_NAME),
    'not_found' =>  esc_html__('No gallery items found', PLUGIN_NAME),
    'not_found_in_trash' => esc_html__('No gallery items found in Trash', PLUGIN_NAME), 
    'parent_item_colon' => ''
	);
  
	register_taxonomy(UNIQMAG_DIFFERENT_THEME_POST_GALLERY."-cat", 
					    	array("Gallery Categories"), 
					    	array(	"hierarchical" => true, 
					    			"label" => "Gallery Categories", 
					    			"singular_label" => "Gallery Categories", 
					    			"rewrite" => true,
					    			"query_var" => true
					    		));  
		
		register_post_type( UNIQMAG_DIFFERENT_THEME_POST_GALLERY,
		array( 'labels' => $labels,
	         'public' => true,  
	         'show_ui' => true,  
	         'capability_type' => 'post',  
	         'hierarchical' => false,  
			 'taxonomies' => array(UNIQMAG_DIFFERENT_THEME_POST_GALLERY.'-cat'),
	         'supports' => array('title', 'editor', 'thumbnail', 'comments', 'page-attributes', 'excerpt') ) );

}

add_action("template_redirect", 'DFstats_redirect');

function DFstats_redirect() {
	global $wp;
	$singleFile = "gallery-single-style-1.php";
	if (isset($wp->query_vars['post_type']) && $wp->query_vars['post_type'] == UNIQMAG_DIFFERENT_THEME_POST_GALLERY) {
	   if (file_exists(TEMPLATEPATH . '/' . $singleFile)) {
			$return_template = TEMPLATEPATH . '/' . $singleFile;
		} else {
			$return_template = dirname(__FILE__) . '/' . $singleFile;
		}
		DF_redirect($return_template);
	}


}

function DF_redirect($url) {
	global $post, $wp_query;
	if (have_posts()) {
		require_once($url);
		die();
	} else {
		$wp_query->is_404 = true;
	}
}

function df_plugin_get_query_string_paged() {
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


function DF_plugin_page_id() {
	return get_the_ID();
}

/* -------------------------------------------------------------------------*
 * 							GALLERY IMAGE COUNT								*
 * -------------------------------------------------------------------------*/
 
function DF_plugin_image_count($post_id = false) {
    //Get all images
   	$galleryImages = get_post_meta ( $post_id, PLUGIN_NAME."_gallery_images", true ); 
   	$imageIDs = explode(",",$galleryImages);
   	$att_count = count(array_filter($imageIDs));

	return $att_count;
}


if(!function_exists('df_plugin_get_page')) {
 	function df_plugin_get_page($name, $type="array") {

	  	$query = new WP_Query( 
	   		array( 
	    		'post_type' => 'page',
	    		'meta_key' => '_wp_page_template', 
	    		'meta_value' => 'template-'.$name.'.php', 
	    		'fields' => 'ids' 
	    	) 
	   	);

  		if(isset($query->posts) && is_array($query->posts)) return ($query->posts);
  		return false;
 	}
}

/* -------------------------------------------------------------------------*
 * 						LOAD NEXT IMAGE IN GALLERY							*
 * -------------------------------------------------------------------------*/
add_action('wp_ajax_df_plugin_load_next_image', 'df_plugin_load_next_image');
add_action('wp_ajax_nopriv_df_plugin_load_next_image', 'df_plugin_load_next_image');
function df_plugin_load_next_image(){
	$g = $_POST['gallery_id'];
	$next_image = $_POST['next_image'];

	$galleryImages = get_post_meta ($g, PLUGIN_NAME."_gallery_images", true );  
	$imageIDs = explode(",",$galleryImages);

	$image = wp_get_attachment_image_src($imageIDs[$next_image-1],array(1230,691));
	echo esc_url($image[0]);


	die();
}


/* -------------------------------------------------------------------------*
 * 							GALLERY IMAGE SELECT							*
 * -------------------------------------------------------------------------*/
 
function df_plugin_gallery_image_select($id, $value) {
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
								<li><a href="#" class="delete" title="' . esc_attr__( 'Delete image', PLUGIN_NAME ) . '">' . esc_html__( 'Delete', PLUGIN_NAME ) . '</a></li>
							</ul>
						</li>';
					}
			?>
		</ul>

		<input type="hidden" id="<?php echo esc_attr__($id);?>" name="<?php echo esc_attr__($id);?>" value="<?php echo esc_attr__( $product_image_gallery ); ?>" />

	</div>
	<p class="add_product_images hide-if-no-js">
		<a href="#"><?php esc_html_e( 'Add images', PLUGIN_NAME ); ?></a>
	</p>
	<script type="text/javascript">
		jQuery(document).ready(function($){

			// Uploading files
			var product_gallery_frame;
			var $image_gallery_ids = $('#<?php echo esc_attr__($id);?>');
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
					title: '<?php esc_html_e( 'Add Images to Product Gallery', PLUGIN_NAME ); ?>',
					button: {
						text: '<?php esc_html_e( 'Add to gallery', PLUGIN_NAME ); ?>',
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
										<li><a href="#" class="delete" title="<?php echo addslashes(esc_html__( 'Delete image', PLUGIN_NAME )); ?>"> <?php echo addslashes(esc_html__( 'Delete', PLUGIN_NAME )); ?></a></li>\
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

// Add meta box
function add_plugin_sticky_box() {
	add_meta_box('post-slider-images', esc_html__("Gallery Images", PLUGIN_NAME), 'sticky_plugin_show_box', UNIQMAG_DIFFERENT_THEME_POST_GALLERY, 'side', 'low', array('id' => PLUGIN_NAME. '_gallery_images'));
}

function sticky_plugin_show_box( $post, $metabox) {
	global $post_id;
	df_plugin_gallery_image_select($metabox['args']['id'],get_post_meta($post_id, $metabox['args']['id'], true));
}

// Save data from meta box
function save_plugin_meta_sticky_data($post_id) {
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}

	// check permissions
	if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}

	if(isset($_POST[PLUGIN_NAME.'_gallery_images'])) {
		// Sanitize the user input.
		$mydata = sanitize_text_field( $_POST[PLUGIN_NAME.'_gallery_images'] );

		// Update the meta field.
		update_post_meta( $post_id, PLUGIN_NAME. '_gallery_images', $mydata );	
	}


}


add_action('save_post', 'save_plugin_meta_sticky_data');
add_action('admin_menu', 'add_plugin_sticky_box');	


	add_action( 'wp_enqueue_scripts', 'different_themes_plugin_scripts');

	function different_themes_plugin_scripts() { 
		global $wp_styles,$wp_scripts;

		wp_enqueue_style("df-gallery-main", plugins_url('css/style.css', __FILE__));
		wp_enqueue_script("move" , plugins_url('js/jquery.event.move.js', __FILE__), Array('jquery'), '1.3.1', true);
		wp_enqueue_script("swipe" , plugins_url('js/jquery.event.swipe.js', __FILE__), Array('jquery'), '', true);
		wp_enqueue_script("df-gallery" , plugins_url('js/df_gallery.js', __FILE__), Array('jquery'), "1.0", true);



		$post_type = get_post_type();
		if($post_type==UNIQMAG_DIFFERENT_THEME_POST_GALLERY) {
			$gallery_id =get_the_ID();
		} else { 
			$gallery_id = false;
		}
		
		wp_localize_script('jquery','dfp',
			array(
				'adminUrl' => admin_url("admin-ajax.php"),
				'gallery_id' => $gallery_id,
				'galleryCat' => get_query_var('gallery-cat')
			)
		);
		
	}

?>