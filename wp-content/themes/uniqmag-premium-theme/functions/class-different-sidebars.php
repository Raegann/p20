<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Different_Themes_Sidebars {

    public static $sidebar;
    var $options;


    public function __construct() {
        $this->options = New Different_Themes_Options();
        $this->__add_sidebars();

        add_filter('dynamic_sidebar_params', array( $this, 'widget_counter'));
    }


    /**
     * register page sidebars
     */
    protected function __register( $name, $id, $description ){
        register_sidebar( 
            array(
                'name' => $name,
                'id' => $id,
                'description' => $description,
                'before_widget' => '<aside class="widget %2$s">',
                'after_widget' => '</aside>',
                'before_title' => '<h2 class="widget-title">',
                'after_title' => '</h2>'
            )
        );
    }


    /**
     * create page default&custom sidebars
     * @return  sidebar array
     */
    protected function __add_sidebars(){
        $sticky_sidebar = $this->options->get( THEME_NAME."_sticky_sidebar" );

        $different_sidebars = array();

        // create the default page sidebars
        $different_sidebars[] = array('name'=>esc_html__('Default Main Sidebar','uniqmag'), 'id'=>'default','description' => esc_html__('The default page sidebar.','uniqmag'));
        //$different_sidebars[] = array('name'=>esc_html__('Default Small Sidebar','uniqmag'), 'id'=>'default_small','description' => esc_html__('The default small page sidebar.','uniqmag'));
        $different_sidebars[] = array('name'=>esc_html__('Footer 1st Column','uniqmag'), 'id'=>'df_footer_1', 'description' => esc_html__('Footer first column widget area','uniqmag'));    
        $different_sidebars[] = array('name'=>esc_html__('Footer 2nd Column','uniqmag'), 'id'=>'df_footer_2', 'description' => esc_html__('Footer second column widget area','uniqmag')); 
        $different_sidebars[] = array('name'=>esc_html__('Footer 3rd Column','uniqmag'), 'id'=>'df_footer_3', 'description' => esc_html__('Footer third column widget area','uniqmag'));   
        //$different_sidebars[] = array('name'=>esc_html__('Footer 4th Column','uniqmag'), 'id'=>'df_footer_4', 'description' => esc_html__('Footer forth column widget area','uniqmag')); 

        if(function_exists('is_woocommerce')) {
            $different_sidebars[] = array('name'=>'Woocommerce', 'id'=>'df_woocommerce', 'description' => esc_html__('Woocommerce Page Sidebar','uniqmag')); 
        }
        if(function_exists("is_bbpress")) {
            $different_sidebars[] = array('name'=>'bbPress', 'id'=>'df_bbpress', 'description' => esc_html__('bbPress Page Sidebar','uniqmag'));
        }
        if(function_exists("is_buddypress")) {
            $different_sidebars[] = array('name'=>'BuddyPress', 'id'=>'df_buddypress', 'description' => esc_html__('BuddyPress Page Sidebar','uniqmag'));    
        }
        if($sticky_sidebar=="on") {
            //$different_sidebars[] = array('name'=>'Default Sticky Sidebar', 'id'=>'sicky_sidebar', 'description' => esc_html__('Sticky sidebar under the main sidebar, that will stay fixed while you scroll down the page','uniqmag'));   
        }


        // get dynamic created sidebars
        $sidebar_strings = $this->options->get( THEME_NAME.'_sidebar_names' );
        $generated_sidebars = explode( "|*|" , $sidebar_strings );
        array_pop( $generated_sidebars );
        $different_generated_sidebars = array();
            
        foreach( $generated_sidebars as $sidebar ) {
            $different_sidebars[] = array(
                'name' => $sidebar, 
                'id' => sanitize_title_with_dashes( $sidebar ), 
                'description' => $sidebar
            );

            $different_generated_sidebars[] = array(
                'name' => $sidebar, 
                'id' => sanitize_title_with_dashes( $sidebar ), 
                'description' => $sidebar
            );
        }

        //register all sidebars
        foreach( $different_sidebars as $sidebar ) {
            if($sidebar['id'] && $sidebar['name']) {
                $this->__register( $sidebar['name'], $sidebar['id'], $sidebar['description'] ); 
            }

        }
 
    }


    /**
     * Get default post/page sidebar
     * @return  string
     */
    private function get_default() {

        $sidebar = $this->options->get(THEME_NAME."_default_sidebar");

        if(function_exists('is_woocommerce') && is_woocommerce()) {
            $sidebar = 'df_woocommerce';
        }
        if(function_exists("is_bbpress") && is_bbpress()) {
            $sidebar = 'df_bbpress';
        }

        if(function_exists("is_buddypress") && is_buddypress()) {
            $sidebar = 'df_buddypress';
        }
    
        if($sidebar=='' || is_search()) {
            $sidebar = "default";
        }

        return $sidebar;

    }


    /**
     * Get post/page sidebar
     * @return  string
     */
    public function get_sidebar() {
        global $wp_query;

        if(isset($wp_query->post->ID)){
            if( $wp_query->is_posts_page ) {
                $sidebar = get_post_meta( get_option( 'page_for_posts' ), "_".THEME_NAME.'_sidebar_select', true ); 
            } else {
                $sidebar = get_post_meta( $wp_query->post->ID, "_".THEME_NAME.'_sidebar_select', true );   
            }
          
        }
        

        if(is_category()) {
            $sidebar = uniqmag_different_themes_get_custom_option( get_cat_id( single_cat_title("",false) ), 'sidebar_select', false );
        } else if( is_tax() || is_tag() ) {

            $sidebar = uniqmag_different_themes_get_custom_option( get_queried_object()->term_id, 'sidebar_select', false );
        }

        if( !isset($sidebar) || $sidebar == '' ) {
            $sidebar = $this->get_default();
        }
       
        return $sidebar;

    }

    /**
     * Set sidebar
     */
    public static function set_sidebar() {
        self::$sidebar = "on";
    }
    /**
     * Set sidebar
     */
    public static function reset_sidebar() {
        self::$sidebar = "off";
    }

    /**
     * Check if Page has a sidebar
     * @return  string
     */
    public function is_sidebar() {
        if( !is_page_template('template-homepage.php') ) {
            if ( $this->get_sidebar() == "off" ) {
                return false;
            } else {
                return true;
            }
        } else if( is_page_template('template-homepage.php') ) {
            if( self::$sidebar == "on" ) {
                return true;  
            } else {
                return false; 
            }
           
        } else {
            return true;
            
        }


    }


    /**
     * Get post/page sidebar position
     * @return  string
     */
    public function position() {

        $defPosition = $this->options->get(THEME_NAME."_sidebar_position");
        $sidebarPosition = get_post_meta ( Different_Themes()->page_id(), "_".THEME_NAME."_sidebar_position", true ); 


        if(is_category()) {
            $sidebarPosition = uniqmag_different_themes_get_custom_option( get_cat_id( single_cat_title("",false) ), 'sidebar_position', false );
        } else if( is_tax() || is_tag() ) {
            $sidebarPosition = uniqmag_different_themes_get_custom_option( get_queried_object()->term_id, 'sidebar_position', false );
        }

        if (( $sidebarPosition == '' && $defPosition != "custom" ) || ( $sidebarPosition != '' && $defPosition != "custom" ) ) {

            $sidebarPosition = $defPosition;

        } else if ( ( !$sidebarPosition && $defPosition == "custom" ) || ( $sidebarPosition == '' && $defPosition == "custom" ) ) {
            
            $sidebarPosition = "right";

        }

        return $sidebarPosition;

    }


    /**
     * Widget Counter, adds classes to widgets, like widget-1 first, widget-2, widget-3 last
     * @return  string
     */
 
    function widget_counter($params) {

        global $my_widget_num; // Global a counter array
        $this_id = $params[0]['id']; // Get the id for the current sidebar we're processing
        $arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets  

        if(!$my_widget_num) {// If the counter array doesn't exist, create it
            $my_widget_num = array();
        }

        if(!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) { // Check if the current sidebar has no widgets
            return $params; // No widgets in this sidebar... bail early.
        }

        if(isset($my_widget_num[$this_id])) { // See if the counter array has an entry for this sidebar
            $my_widget_num[$this_id] ++;
        } else { // If not, create it starting with 1
            $my_widget_num[$this_id] = 1;
        }

        $class = 'class="widget-' . $my_widget_num[$this_id] . ' '; // Add a widget number class for additional styling options

        if($my_widget_num[$this_id] == 1) { // If this is the first widget
            $class .= 'first ';
        } elseif($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) { // If this is the last widget
            $class .= 'last ';
        }

        $params[0]['before_widget'] = str_replace('class="', $class, $params[0]['before_widget']); // Insert our new classes into "before widget"

        return $params;

    }

}


