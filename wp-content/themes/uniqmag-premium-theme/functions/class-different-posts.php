<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Different_Themes_Posts {

    public static $titleColor = array();

    public function __construct() {
    
    }


    /**
     * Compare default options with post custom option and return the needed value
     * @return  string
     */

    public function compare( $post_ID, $option, $meta_option = null, $type = null) {
        if( !$meta_option ) {
            $meta_option = $option;
        }        

        if( !$type ) {
            //get default details
            $option = Different_Themes()->options->get(THEME_NAME."_".$option);
        } else if ( $type == 'meta_blog' ) {
            //get post details
            $option = get_post_meta( get_option('page_for_posts'), "_".THEME_NAME."_".$option, true );
        }

        //get post details
        $meta_option = get_post_meta( $post_ID, "_".THEME_NAME."_".$meta_option, true );

        if( !$meta_option ) {
            $meta_option = "1";
        }

        if( $option != '' && $option != 'custom' ) {
            return $option;
        } else {
            return $meta_option;
        }

    }


    /**
     * generates image html code
     * @return  string
     */

    public function get_image_html( $post_ID, $width = 0, $height = 0, $class = false, $custom = false, $force = false ) {
        $image = uniqmag_different_themes_get_post_thumb( $post_ID, $width, $height, $custom );
        $retina_image = uniqmag_different_themes_get_post_thumb($post_ID, ( $width * 2 ), ( $height * 2 ), $custom );

        if( $class ) {
            $class = ' class="'.esc_attr( $class ).'"';
        } else {
            $class = false;
        }
        if( $image["show"] != false || $force == true ) {
            if($width && $width!="0") {
                $width_attr = ' width="'.$width.'"';     
            } else {
               $width_attr = false; 
            }
            if($height && $height!="0") {
                $height_attr = ' height="'.$height.'"';     
            } else {
                $height_attr = false; 
            }
            
            $return = '<img'.$class.''.$width_attr.$height_attr.' src="'.esc_url( $image["src"] ).'" alt="'.esc_attr( get_the_title( $post_ID ) ).'" srcset="'.esc_url( $retina_image["src"] ).'" />';
        } else {
            $return = false;
        }

        return $return;
    }

    /**
     * check if post has a featured image
     * @return  true/false
     */

    public function is_image( $post_ID = false, $force = false ) {
        
        if( $post_ID == false ) {
            $post_ID = get_the_ID();
        }

        $image = $this->get_image_html( $post_ID, null, null, null, null, $force );

        if( $image == false ) {
            return false;
        } else {
            return true;
        }
    }


    /**
     * image html code output
     * @return  string
     */

    public function image_html( $post_ID, $width = 0, $height = 0, $class = false, $custom = false, $force = false ) {
        echo uniqmag_different_themes_html_output( $this->get_image_html( $post_ID, $width, $height, $class, $custom, $force ) );
    }



    /**
     * generates image src
     * @return  string
     */

    public function get_image_src( $post_ID, $width = 0, $height = 0 ) {
        $image = uniqmag_different_themes_get_post_thumb( $post_ID, $width, $height );

        if( $image["show"] != false ) {
            return esc_url( $image["src"] );
        } else {
            return false;
        }

    }

    /**
     * get color
     * @return  string
     */

    public function get_color( $id, $type = "category", $echo = true ) {
        if( $type == "category" || $type == "post_tag" ) {
            $config = array(
               'pages' => array('category','post_tag',UNIQMAG_DIFFERENT_THEME_POST_GALLERY.'-cat',UNIQMAG_DIFFERENT_THEME_POST_PORTFOLIO.'-cat'),                    // taxonomy name, accept categories, post_tag and custom taxonomies
               'context' => 'normal',                           // where the meta box appear: normal (default), advanced, side; optional
               'fields' => array(),                             // list of meta fields (can be added by field arrays)
               'local_images' => false,                         // Use local or hosted images (meta box images for add/remove)
               'use_with_theme' => true                         //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
            );
            $my_meta = new Tax_Meta_Class($config);
            $titleColor = $my_meta->get_tax_meta($id, THEME_NAME.'_title_color');
            $my_meta->Finish();
        } else if ( $type == "page" ) {
            $titleColor = "#".uniqmag_different_themes_meta($id, "_".THEME_NAME."_title_color"); 
        }

        
        if( !isset( $titleColor ) || $titleColor == "" || $titleColor == "#" ) {
            $titleColor = "#".Different_Themes()->options->get(THEME_NAME."_default_cat_color");
        }
        
        if( $echo != false ) {
            echo esc_html( $titleColor );
        } else {
            return esc_html( $titleColor );
        }
    }


    /**
     * get category random color
     * @return  string
     */

    public function random_cat_color( $post_ID, $type = 'category', $echo = false ) {
        if( isset(self::$titleColor[$post_ID]) && self::$titleColor[$post_ID] ) {
            return self::$titleColor[$post_ID];
        }
        
        if($type == "category" ) {
           $categories = wp_get_post_categories($post_ID);  
        } else {
            $categories = wp_get_post_terms($post_ID,$type);  
        }
        
        $catCount = count($categories);

        if( $catCount >= 1 ) {
            //select a random category id
            $id = intval(rand(0,$catCount-1));  
        } else {
            //select a random category id
            $id = intval($catCount);  
        }


        if($type == "category" && !empty( $categories ) ) {
            //random cat id
            $cat_ID = $categories[$id];
        } else if( !empty( $categories ) ) {
            //random term id
            $cat_ID = $categories[$id]->term_id;
        }

        if( isset( $cat_ID ) )  {
            //get category color    
            $titleColor = $this->get_color($cat_ID, 'category', $echo);

            return self::$titleColor[$post_ID] = $titleColor;
        } else {
            //get category color    
            $titleColor = $this->get_color(false, 'category', $echo);

            return self::$titleColor[$post_ID] = $titleColor;
        }

        return false;

    }

    /**
     * get category random color
     * @return  string
     */

    public function adjust_brightness( $hex, $steps ) {
        // Steps should be between -255 and 255. Negative = darker, positive = lighter
        $steps = max(-255, min(255, $steps));

        // Normalize into a six character long hex string
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
        }

        // Split into three parts: R, G and B
        $color_parts = str_split($hex, 2);
        $return = '#';

        foreach ($color_parts as $color) {
            $color   = hexdec($color); // Convert to decimal
            $color   = max(0,min(255,$color + $steps)); // Adjust color
            $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
        }

        return $return;
    }


    /**
     * get icon
     * @return  string
     */

    public function get_icon( $type ) {
        switch ($type) {
            case 'video':
                $icon = '<i class="fa fa-play"></i>';
                break;
            case 'audio':
                $icon = '<i class="fa fa-volume-up"></i>';
                break;
            case 'gallery':
                $icon = '<i class="fa fa-picture-o"></i>';
                break;
            case 'standard':
                $icon = '<i class="fa fa-file-text-o"></i>';
                break;
            default:
                $icon = '<i class="fa fa-file-text-o"></i>';
                break;
        }


        return $icon;
    }

    /**
     * category icons
     * @return  string
     */

    public function get_cat_icon( $cat_id = false ) {
        if( $cat_id == false ) {
            $cat_id = get_cat_id( single_cat_title("",false) );
        }

        $icon = uniqmag_different_themes_get_custom_option( $cat_id , 'category_icon', false );

        return $icon;
    }
    /**
     * category icons
     * @return  string
     */

    public function cat_icon( $cat_id = false ) {
        if( $cat_id == false ) {
            $cat_id = get_cat_id( single_cat_title("",false) );
        }

        echo esc_attr($this->get_cat_icon($cat_id));
    }

    /**
     * post custom excerpt leght
     * @echo  string
     */
    public function the_excerpt( $length ) {
        $output = $this->get_the_excerpt($length);
        $output = apply_filters('wptexturize', $output);
        $output = apply_filters('convert_chars', $output);
        $output = '<p>' . $output . '</p>';
        echo uniqmag_different_themes_html_output($output);
    }

    /**
     * post custom excerpt leght
     * @return  string
     */
    public function get_the_excerpt( $length ) {
        add_filter('excerpt_length', function () use ($length) {
            return $length;
        }, 999);

        $output = get_the_excerpt();
        $output = apply_filters('wptexturize', $output);
        $output = apply_filters('convert_chars', $output);

        return $output;

    }
}