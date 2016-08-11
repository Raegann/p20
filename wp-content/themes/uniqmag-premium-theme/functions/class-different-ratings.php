<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Different_Themes_Ratings {

    public static $avarageRate;
    public static $max_val;
    public static $type;


    public function __construct($max_val = 5, $type = 'multiple') {
        self::$max_val = $max_val;
        self::$type = $type;

    }


    /**
     * Get avarage post rating
     * @return  array($avaragePrecentage,$avarageRate)
     */

    function avarage_rating( $post_id = '' ) {
        if( $post_id == '' ) {
            global $post;
            if(isset($post)) {
                $post_id = $post->ID;   
            }
        }
        

        $max_val= self::$max_val;
        $type = self::$type;
        

        if( $type == "multiple" ) {
            $ratings = get_post_meta( $post_id, "_".THEME_NAME."_ratings", true );

            $totalRate = array();
            $rating = explode(";", $ratings);

            foreach($rating as $rate) { 
                $ratingValues = explode(":", $rate);
                if(isset($ratingValues[1])){
                    $ratings = (str_replace(",",".",$ratingValues[1]));
                    $totalRate[] = $ratings;
                }
              
            } 

            if(!empty($totalRate)) {
                $rateCount = count($totalRate); 
                $total = 0;
                foreach ($totalRate as $val) {
                    $total = $total + $val;
                }

                
                $avarageRate = self::$avarageRate = floatval(round(($total/$rateCount),1));
                $avaragePrecentage =  floatval(round(($avarageRate/$max_val)*100,2));


                return array($avaragePrecentage,$avarageRate);
            } else {
                return false;
            }
        }

        if($type=="single") {
            $ratings = get_post_meta( $post_id, "_".THEME_NAME."_ratings_average", true );
            if($ratings) {
                $avarageRate = self::$avarageRate = floatval(round($ratings,1));
                $avaragePrecentage =  floatval(round(($ratings/$max_val)*100,2));

                return array($avaragePrecentage,$avarageRate);

            } else {
                return false;
            }
        }


    }


    /**
     * Generate rating text rate
     * @return  string
     */
    function rate_text() {
        $rate_text_array = array(
            esc_html__("Abysmal",'uniqmag'),
            esc_html__("Terrible",'uniqmag'),
            esc_html__("Bad",'uniqmag'),
            esc_html__("Poor",'uniqmag'),
            esc_html__("Mediocre",'uniqmag'),
            esc_html__("Fair",'uniqmag'),
            esc_html__("Good",'uniqmag'),
            esc_html__("Great",'uniqmag'),
            esc_html__("Superb",'uniqmag'),
            esc_html__("Essential",'uniqmag')
        );

        if(!self::$max_val || !self::$avarageRate) {
            return esc_html__("Please run the avarage_rating function first",'uniqmag');
        }

        if(self::$max_val) {
            $max_val = self::$max_val;
            $rating_text_step = round($max_val/10,1); 


            $needed_rating_text = (floor(self::$avarageRate/$rating_text_step));
            if($needed_rating_text>=1) {
                $needed_rating_text = $needed_rating_text -1;
            }

            $rating_text = $rate_text_array[$needed_rating_text]; 
            return $rating_text;
        }

        return false;
    }





}