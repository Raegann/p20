<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Different_Themes_Animations {

    public function __construct() {
        
    }


    /**
     * Get list of all the animations
     * @return array animations
     */
    function get_list() {
        return $this->animations();
    }


    /**
     * jQuery animations
     * @return  array
     */

    protected function animations() {
        $animations = array(
            array(
                "optgroup" => esc_html__("No Effect",'uniqmag'),
                "options" => array(
                    array("option" => esc_html__("None",'uniqmag'), "value" => ''),
                ),
            ),
            array(
                "optgroup" => esc_html__("Attention Seekers",'uniqmag'),
                "options" => array(
                    array("option" => esc_html__("bounce",'uniqmag'), "value" => 'bounce'),
                    array("option" => esc_html__("flash",'uniqmag'), "value" => 'flash'),
                    array("option" => esc_html__("pulse",'uniqmag'), "value" => 'pulse'),
                    array("option" => esc_html__("rubberBand",'uniqmag'), "value" => 'rubberBand'),
                    array("option" => esc_html__("shake",'uniqmag'), "value" => 'shake'),
                    array("option" => esc_html__("swing",'uniqmag'), "value" => 'swing'),
                    array("option" => esc_html__("tada",'uniqmag'), "value" => 'tada'),
                    array("option" => esc_html__("wobble",'uniqmag'), "value" => 'wobble'),
                ),
            ),
            array(
                "optgroup" => esc_html__("Bouncing Entrances",'uniqmag'),
                "options" => array(
                    array("option" => esc_html__("bounceIn",'uniqmag'), "value" => 'bounceIn'),
                    array("option" => esc_html__("bounceInDown",'uniqmag'), "value" => 'bounceInDown'),
                    array("option" => esc_html__("bounceInLeft",'uniqmag'), "value" => 'bounceInLeft'),
                    array("option" => esc_html__("bounceInRight",'uniqmag'), "value" => 'bounceInRight'),
                    array("option" => esc_html__("bounceInUp",'uniqmag'), "value" => 'bounceInUp'),
                ),
            ),
            /*
            array(
                "optgroup" => esc_html__("Bouncing Exits",'uniqmag'),
                "options" => array(
                    array("option" => esc_html__("bounceOut",'uniqmag'), "value" => 'bounceOut'),
                    array("option" => esc_html__("bounceOutDown",'uniqmag'), "value" => 'bounceOutDown'),
                    array("option" => esc_html__("bounceOutLeft",'uniqmag'), "value" => 'bounceOutLeft'),
                    array("option" => esc_html__("bounceOutRight",'uniqmag'), "value" => 'bounceOutRight'),
                    array("option" => esc_html__("bounceOutUp",'uniqmag'), "value" => 'bounceOutUp'),
                ),
            ),
            */
            array(
                "optgroup" => esc_html__("Fading Entrances",'uniqmag'),
                "options" => array(
                    array("option" => esc_html__("fadeIn",'uniqmag'), "value" => 'fadeIn'),
                    array("option" => esc_html__("fadeInDown",'uniqmag'), "value" => 'fadeInDown'),
                    array("option" => esc_html__("fadeInDownBig",'uniqmag'), "value" => 'fadeInDownBig'),
                    array("option" => esc_html__("fadeInLeft",'uniqmag'), "value" => 'fadeInLeft'),
                    array("option" => esc_html__("fadeInLeftBig",'uniqmag'), "value" => 'fadeInLeftBig'),
                    array("option" => esc_html__("fadeInRight",'uniqmag'), "value" => 'fadeInRight'),
                    array("option" => esc_html__("fadeInRightBig",'uniqmag'), "value" => 'fadeInRightBig'),
                    array("option" => esc_html__("fadeInUp",'uniqmag'), "value" => 'fadeInUp'),
                    array("option" => esc_html__("fadeInUpBig",'uniqmag'), "value" => 'fadeInUpBig'),
                ),
            ),
            /*
            array(
                "optgroup" => esc_html__("Fading Exits",'uniqmag'),
                "options" => array(
                    array("option" => esc_html__("fadeOut",'uniqmag'), "value" => 'fadeOut'),
                    array("option" => esc_html__("fadeOutDown",'uniqmag'), "value" => 'fadeOutDown'),
                    array("option" => esc_html__("fadeOutDownBig",'uniqmag'), "value" => 'fadeOutDownBig'),
                    array("option" => esc_html__("fadeOutLeft",'uniqmag'), "value" => 'fadeOutLeft'),
                    array("option" => esc_html__("fadeOutLeftBig",'uniqmag'), "value" => 'fadeOutLeftBig'),
                    array("option" => esc_html__("fadeOutRight",'uniqmag'), "value" => 'fadeOutRight'),
                    array("option" => esc_html__("fadeOutRightBig",'uniqmag'), "value" => 'fadeOutRightBig'),
                    array("option" => esc_html__("fadeOutUp",'uniqmag'), "value" => 'fadeOutUp'),
                    array("option" => esc_html__("fadeOutUpBig",'uniqmag'), "value" => 'fadeOutUpBig'),
                ),
            ),
            */
            array(
                "optgroup" => esc_html__("Flippers",'uniqmag'),
                "options" => array(
                    array("option" => esc_html__("flip",'uniqmag'), "value" => 'flip'),
                    array("option" => esc_html__("flipInX",'uniqmag'), "value" => 'flipInX'),
                    array("option" => esc_html__("flipInY",'uniqmag'), "value" => 'flipInY'),
                    /*
                    array("option" => esc_html__("flipOutX",'uniqmag'), "value" => 'flipOutX'),
                    array("option" => esc_html__("flipOutY",'uniqmag'), "value" => 'flipOutY'),
                    */
                ),
            ),
            array(
                "optgroup" => esc_html__("Lightspeed",'uniqmag'),
                "options" => array(
                    array("option" => esc_html__("lightSpeedIn",'uniqmag'), "value" => 'lightSpeedIn'),
                    /*
                    array("option" => esc_html__("lightSpeedOut",'uniqmag'), "value" => 'lightSpeedOut'),
                    */
                ),
            ),
            array(
                "optgroup" => esc_html__("Rotating Entrances",'uniqmag'),
                "options" => array(
                    array("option" => esc_html__("rotateIn",'uniqmag'), "value" => 'rotateIn'),
                    array("option" => esc_html__("rotateInDownLeft",'uniqmag'), "value" => 'rotateInDownLeft'),
                    array("option" => esc_html__("rotateInDownRight",'uniqmag'), "value" => 'rotateInDownRight'),
                    array("option" => esc_html__("rotateInUpLeft",'uniqmag'), "value" => 'rotateInUpLeft'),
                    array("option" => esc_html__("rotateInUpRight",'uniqmag'), "value" => 'rotateInUpRight'),
                ),
            ),
            /*
            array(
                "optgroup" => esc_html__("Rotating Exits",'uniqmag'),
                "options" => array(
                    array("option" => esc_html__("rotateOut",'uniqmag'), "value" => 'rotateOut'),
                    array("option" => esc_html__("rotateOutDownLeft",'uniqmag'), "value" => 'rotateOutDownLeft'),
                    array("option" => esc_html__("rotateOutDownRight",'uniqmag'), "value" => 'rotateOutDownRight'),
                    array("option" => esc_html__("rotateOutUpLeft",'uniqmag'), "value" => 'rotateOutUpLeft'),
                    array("option" => esc_html__("rotateOutUpRight",'uniqmag'), "value" => 'rotateOutUpRight'),
                ),
            ),
            */
            array(
                "optgroup" => esc_html__("Sliding Entrances",'uniqmag'),
                "options" => array(
                    array("option" => esc_html__("slideInUp",'uniqmag'), "value" => 'slideInUp'),
                    array("option" => esc_html__("slideInDown",'uniqmag'), "value" => 'slideInDown'),
                    array("option" => esc_html__("slideInLeft",'uniqmag'), "value" => 'slideInLeft'),
                    array("option" => esc_html__("slideInRight",'uniqmag'), "value" => 'slideInRight'),
                ),
            ),
            /*
            array(
                "optgroup" => esc_html__("Sliding Exits",'uniqmag'),
                "options" => array(
                    array("option" => esc_html__("slideOutUp",'uniqmag'), "value" => 'slideOutUp'),
                    array("option" => esc_html__("slideOutDown",'uniqmag'), "value" => 'slideOutDown'),
                    array("option" => esc_html__("slideOutLeft",'uniqmag'), "value" => 'slideOutLeft'),
                    array("option" => esc_html__("slideOutRight",'uniqmag'), "value" => 'slideOutRight'),
                ),
            ),
            */
            array(
                "optgroup" => esc_html__("Zoom Entrances",'uniqmag'),
                "options" => array(
                    array("option" => esc_html__("zoomIn",'uniqmag'), "value" => 'zoomIn'),
                    array("option" => esc_html__("zoomInDown",'uniqmag'), "value" => 'zoomInDown'),
                    array("option" => esc_html__("zoomInLeft",'uniqmag'), "value" => 'zoomInLeft'),
                    array("option" => esc_html__("zoomInRight",'uniqmag'), "value" => 'zoomInRight'),
                    array("option" => esc_html__("zoomInUp",'uniqmag'), "value" => 'zoomInUp'),
                ),
            ),
            /*
            array(
                "optgroup" => esc_html__("Zoom Exits",'uniqmag'),
                "options" => array(
                    array("option" => esc_html__("zoomOut",'uniqmag'), "value" => 'zoomOut'),
                    array("option" => esc_html__("zoomOutDown",'uniqmag'), "value" => 'zoomOutDown'),
                    array("option" => esc_html__("zoomOutLeft",'uniqmag'), "value" => 'zoomOutLeft'),
                    array("option" => esc_html__("zoomOutRight",'uniqmag'), "value" => 'zoomOutRight'),
                    array("option" => esc_html__("zoomOutUp",'uniqmag'), "value" => 'zoomOutUp'),
                ),
            ),
            */
            array(
                "optgroup" => esc_html__("Specials",'uniqmag'),
                "options" => array(
                    array("option" => esc_html__("hinge",'uniqmag'), "value" => 'hinge'),
                    array("option" => esc_html__("rollIn",'uniqmag'), "value" => 'rollIn'),
                    /*
                    array("option" => esc_html__("rollOut",'uniqmag'), "value" => 'rollOut'),
                    */
                ),
            ),
        );

        return $animations;

    }

}


