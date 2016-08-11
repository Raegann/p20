<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* -------------------------------------------------------------------------*
 * 								HOMEPAGE BUILDER							*
 * -------------------------------------------------------------------------*/
 
class different_themes_home_builder {

	private static $data;
	public static $duplicateArray = array();
	private static $counter = -1; 
	public static $row_counter = 0; 
	private static $sliderSet = false; 
	public static $layoutArray = array();
	public static $df_post = array();
	public static $df_ratings = array();

    public function __construct() {
    	$this->settings();
    }

	public function block_values($blocksContent,$values, $type="block") {
		wp_reset_postdata();
		global $post;

		if($type!="block") {
			//asign them to strings with id name
			foreach ($blocksContent as $id => $value) {
				$c = self::counter();
				if(!is_array($value)) {
					$value = html_entity_decode($value, ENT_QUOTES | ENT_IGNORE, "UTF-8");
				}
				${substr($id, 0, strrpos($id, "_"))} = $value;
			}
		} else {
			//asign them to strings with id name
			foreach ($blocksContent->blocksContent as $id => $value) {
				$c = self::counter();
				if(!is_array($value)) {
					$value = html_entity_decode($value, ENT_QUOTES | ENT_IGNORE, "UTF-8");
				}
				${substr($id, 0, strrpos($id, "_"))} = $value;
			}
		}

		
		//shorter string name
		foreach ($values as $value){
			$array[$value] = (isset(${THEME_NAME."_".$value})) ? ${THEME_NAME."_".$value} : false ;
		}

		return $array;

	}

	private function get_option($option) {
		return Different_Themes()->options->get(THEME_NAME."_".$option);
	}

	//check and remove duplicated posts if needed
	private function duplicate($args) {
		if($this->get_option("duplicate") == "on") {
			$args['post__not_in'] = $this->get_double();
		}
		return $args;
	}

	/* -------------------------------------------------------------------------*
	 * 							HOMEPAGE LATEST NEWS						*
	 * -------------------------------------------------------------------------*/
	 
	public function homepage_news_block($blocks,$columnID) {
		global $post;
		//set variable short names
		$values = array("title","subtitle", "count", "color", "offset", "cat", "style", "type");

		//extract the block variables
		extract($this->block_values($blocks,$values));

		if(is_array($cat)) {
			$carUrl = implode(",", $cat);
			$link = "?cat=".($carUrl);
		} else if($cat) {
			$link = get_category_link($cat);
		} else {
			$link = get_page_link(get_option('page_for_posts'));
		}

		//set wp query
		$args = array(
			'post_type' => "post",
			'offset' =>$offset,
			'showposts' => $count,
			'ignore_sticky_posts' => "1"
		);

		if(is_array($cat)) {
			$args['category__in'] = $cat;
		} else if($cat) {
			$args['cat'] = $cat;
		}

		if($type==2) {
			$args['orderby'] = 'meta_value_num';
			$args['meta_key'] = "_".THEME_NAME.'_post_views_count';
			$link = false;
		}
		if( $style == 12 || $style == 13 || $style == 8 || $style == 14 || $style == 15) {
			$args['meta_key'] =  "_".THEME_NAME.'_main_slider_post';
			$args['meta_value'] = "on";
		}

		//check for duplicate posts
		$args = $this->duplicate($args);

		$my_query = new WP_Query($args);
	

		//set block attributes
		$attr = array(
			'df_post' => self::$df_post,
			'df_ratings' => self::$df_ratings,
			'count' =>$count,
			'cat' => $cat,
			'offset' =>$offset,
			'link' =>$link,
			'columnID' =>$columnID,
			'color' =>$color,
			'title' =>$title,
			'subtitle' =>$subtitle,
			'args' => $args
		);

		//add all data in array
		$data = array($my_query, $attr);

		//set data
		$this->set_data($data);

		$block = "latest-news-".$style;
		get_template_part(UNIQMAG_DIFFERENT_THEME_HOME_BLOCKS.$block);
	}



	/* -------------------------------------------------------------------------*
	 * 							HOMEPAGE SHOP BLOCK							*
	 * -------------------------------------------------------------------------*/
	 
	public function homepage_news_block_2($blocks,$columnID) {
		global $post;
		//set variable short names
		$values = array("title", "count", "cat", "offset", "type", "color");

		//extract the block variables
		extract($this->block_values($blocks,$values));


		if(!$offset) {
			$offset = "0";
		}

		if($cat && $type=="1") {
			$link = get_term_link(intval($cat), 'product_cat');
		} else if($type=="1" && !$cat) {
			if(df_is_woocommerce_activated()==true) {
				$link = get_page_link(woocommerce_get_page_id('shop'));
			} else {
				$link = false;
			}
		} else {
				$link = false;
		}

		if(!is_wp_error( $link ) ) {
			$link = $link;
		} else {
			$link = false;
		}	
		
		//set block attributes
		$attr = array(
			'title' =>$title,
			'count' =>$count,
			'cat' => $cat,
			'offset' =>$offset,
			'link' =>$link,
			'color' =>$color,
		);

		if($type=="1") {
			if($cat) {
				//set wp query
				$args = array(
					'post_type' => "product",
					'tax_query' => array(
						array(
							'taxonomy' => 'product_cat',
							'field' => 'id',
							'terms' => $cat
						)
					),
					'showposts' => $count,
					'ignore_sticky_posts' => "1",
					'offset' =>$offset
				);
			} else {
				//set wp query
				$args = array(
					'post_type' => "product",
					'showposts' => $count,
					'ignore_sticky_posts' => "1",
					'offset' =>$offset
				);
			}
		} else {
			if($cat) {
				//set wp query
				$args = array(
					'post_type' => "product",
					'showposts' => $count,
					'ignore_sticky_posts' => "1",
					'offset' =>$offset,
					'post_status '	=> 'publish',
					'meta_key'	=> '_featured',
					'meta_value'	=> 'yes',
					'tax_query' => array(
						array(
							'taxonomy' => 'product_cat',
							'field' => 'id',
							'terms' => $cat
						)
					),
				);
			} else {
				//set wp query
				$args = array(
					'post_type' => "product",
					'showposts' => $count,
					'ignore_sticky_posts' => "1",
					'offset' =>$offset,
					'post_status '	=> 'publish',
					'meta_key'	=> '_featured',
					'meta_value'	=> 'yes',
				);
			}
		}

		//check for duplicate posts
		$args = $this->duplicate($args);

		$my_query = new WP_Query($args);

		//add all data in array
		$data = array($my_query, $attr);

		//set data
		$this->set_data($data);
		$block = "shop";
		get_template_part(UNIQMAG_DIFFERENT_THEME_HOME_BLOCKS.$block);

	}

	/* -------------------------------------------------------------------------*
	 * 							HOMEPAGE LATEST REWVIEWS						*
	 * -------------------------------------------------------------------------*/
	 
	public function homepage_news_block_3($blocks,$columnID) {
		global $post;
		//set variable short names
		$values = array("title", "subtitle", "cat", "offset", "type", "style", "count", "color");

		//extract the block variables
		extract($this->block_values($blocks,$values));


		if(!$offset) {
			$offset = "0";
		}

		
		//set block attributes
		$attr = array(
			'title' =>$title,
			'subtitle' =>$subtitle,
			'cat' => $cat,
			'offset' =>$offset,
			'color' =>$color,
			'count' =>$count,
			'columnID' =>$columnID,
			'link' =>false,
		);

		if($type=="top") {
			//set wp query
			$args = array(
				'post_type' => "post",
				'showposts' => $count,
				'ignore_sticky_posts' => "1",
				'order' => 'DESC',
				'orderby'	=> 'meta_value_num',
				'meta_key'	=> "_".THEME_NAME.'_ratings_average',
				'meta_query' => array(
				    array(
				        'key' => "_".THEME_NAME.'_ratings_average',
				        'value'   => '0',
				        'compare' => '>='
				    )
				),
				'offset' =>$offset
			);
		} else {
			//set wp query
			$args = array(
				'post_type' => "post",
				'showposts' => $count,
				'order' => 'DESC',
				'ignore_sticky_posts' => "1",
				'meta_query' => array(
				    array(
				        'key' => "_".THEME_NAME.'_ratings_average',
				        'value'   => '0',
				        'compare' => '>='
				    )
				),
				'offset' =>$offset
			);	
		}

		if(is_array($cat)) {
			$args['category__in'] = $cat;
		} else if($cat) {
			$args['cat'] = $cat;
		}

		//check for duplicate posts
		$args = $this->duplicate($args);

		$my_query = new WP_Query($args);

		//add all data in array
		$data = array($my_query, $attr);

		//set data
		$this->set_data($data);
		$block = "latest-news-".$style;
		//$block = "reviews";
		get_template_part(UNIQMAG_DIFFERENT_THEME_HOME_BLOCKS.$block);

	}

	/* -------------------------------------------------------------------------*
	 * 						HOMEPAGE LATEST/TOP VIDEO BLOCK						*
	 * -------------------------------------------------------------------------*/
	 
	public function homepage_news_block_4($blocks,$columnID) {
		global $post;
		//set variable short names
		$values = array("title", "subtitle", "cat", "offset", "type", "color", "style", "animation");

		//extract the block variables
		extract($this->block_values($blocks,$values));
	

		if(!$offset) {
			$offset = "0";
		}

		if($cat) {
			$pageColor = df_title_color($cat, "category", false);
		} else {
			$pageColor = df_title_color(get_option('page_for_posts'),'page', false);
		}
		if($style=="1") {
			$count = 5;
		} else {
			$count = 3;
		}

		//set block attributes
		$attr = array(
			'animation' =>$animation,
			'title' =>$title,
			'count' =>$count,
			'cat' => $cat,
			'offset' =>$offset,
			'pageColor' => $pageColor,
		);

		if($type=="top") {
			//set wp query
			$args = array(
				'post_type' => "post",
				'showposts' => $count,
				'ignore_sticky_posts' => "1",
				'order' => 'DESC',
				'orderby'	=> 'meta_value_num',
				'meta_key'	=> "_".THEME_NAME.'_post_views_count',
				'meta_query' => array(
				    array(
				        'key' => "_".THEME_NAME.THEME_NAME.'_video_code',
				        'value'   => array(''),
				        'compare' => 'NOT IN'
				    )
				),
				'offset' =>$offset
			);
		} else {
			//set wp query
			$args = array(
				'post_type' => "post",
				'showposts' => $count,
				'order' => 'DESC',
				'ignore_sticky_posts' => "1",
				'meta_query' => array(
				    array(
				        'key' => "_".THEME_NAME.'_video_code',
				        'value'   => array(''),
				        'compare' => 'NOT IN'
				    )
				),
				'offset' =>$offset
			);	
		}

		if(is_array($cat)) {
			$args['category__in'] = $cat;
		} else if($cat) {
			$args['cat'] = $cat;
		}


		if(isset($catSingle)) {
			$cat = $catSingle;	
		}

		$my_query = new WP_Query($args);

		//add all data in array
		$data = array($my_query, $attr);

		//set data
		$this->set_data($data);
		$block = "video-".$style;
		get_template_part(UNIQMAG_DIFFERENT_THEME_HOME_BLOCKS.$block);

	}

	/* -------------------------------------------------------------------------*
	 * 							HOMEPAGE TITLE BLOCK								*
	 * -------------------------------------------------------------------------*/
	 
	public function title_block($blocks,$columnID) {
		//set variable short names
		$values = array("title", "subtitle", "color", "link");

		//extract the block variables
		extract($this->block_values($blocks,$values));

		
		//set block attributes
		$attr = array(
			'title' => $title,
			'subtitle' => $subtitle,
			'color' => $color,
			'link' => $link,
		);


		//add all data in array
		$data = array($attr);

		//set data
		$this->set_data($data);
		$block = "title";
		get_template_part(UNIQMAG_DIFFERENT_THEME_HOME_BLOCKS.$block);

	}
	/* -------------------------------------------------------------------------*
	 * 							HOMEPAGE HTML BLOCK								*
	 * -------------------------------------------------------------------------*/
	 
	public function homepage_html($blocks,$columnID) {
		//set variable short names
		$values = array("html");

		//extract the block variables
		extract($this->block_values($blocks,$values));

		
		//set block attributes
		$attr = array(
			'code' =>wpautop(stripslashes(do_shortcode($html))),
		);


		//add all data in array
		$data = array($attr);

		//set data
		$this->set_data($data);
		$block = "html";
		get_template_part(UNIQMAG_DIFFERENT_THEME_HOME_BLOCKS.$block);

	}
	/* -------------------------------------------------------------------------*
	 * 							HOMEPAGE TEXT BLOCK								*
	 * -------------------------------------------------------------------------*/
	 
	public function text_block($blocks,$columnID) {
		//set variable short names
		$values = array("text");

		//extract the block variables
		extract($this->block_values($blocks,$values));

		
		//set block attributes
		$attr = array(
			'code' =>wpautop(stripslashes(do_shortcode($text))),
		);


		//add all data in array
		$data = array($attr);

		//set data
		$this->set_data($data);
		$block = "html";
		get_template_part(UNIQMAG_DIFFERENT_THEME_HOME_BLOCKS.$block);

	}
	/* -------------------------------------------------------------------------*
	 * 							HOMEPAGE BANNER BLOCK							*
	 * -------------------------------------------------------------------------*/
	 
	public function homepage_banner($blocks,$columnID) {
		global $post;
		//set variable short names
		$values = array("banner");

		//extract the block variables
		extract($this->block_values($blocks,$values));

		
		//set block attributes
		$attr = array(
			'code' =>stripslashes(do_shortcode($banner))
		);

		//add all data in array
		$data = array($attr);

		//set data
		$this->set_data($data);
		$block = "banner";
		get_template_part(UNIQMAG_DIFFERENT_THEME_HOME_BLOCKS.$block);

	}
	/* -------------------------------------------------------------------------*
	 * 							HOMEPAGE COLUMNS							*
	 * -------------------------------------------------------------------------*/
	 
	public function columRows($columRows) {
		$dataArray = array($columRows);
		//set data
		$this->set_data($dataArray);

		get_template_part(UNIQMAG_DIFFERENT_THEME_HOME_BLOCK_ROWS.'row');
	}

	public static function sliderSet($val=false) {
		if($val==true) {
			return self::$sliderSet = $val;
		} else {
			return self::$sliderSet;
		}
	}

	//set layout hierarchy
	public static function layout($val=false) {
		if($val!=false && $val!="return") {
			self::$layoutArray[] = $val;
			return self::$layoutArray;
		} else if($val!="return") {
			self::$layoutArray = array();
			return self::$layoutArray;
		}

		if($val=="return") {
			return self::$layoutArray;
		}


	}


	//set double posts filter
	public static function set_double($data) {
		self::$duplicateArray[] = $data;
	}

	public static function get_double() {
		return self::$duplicateArray;
	}

    private function counter() {
        return ++self::$counter;
    }

    public function row_counter($type) {
    	if($type == "count") {
			return self::$row_counter;
    	}
    	if($type == "add") {
			++self::$row_counter;
    	}

    	if($type == "reset") {
			self::$row_counter=0;
    	}

    }


	private static function set_data($data) {
		self::$data = $data;
	}

	public static function get_data() {
		return self::$data;
	}

	public static function settings() {
		self::$df_post = Different_Themes()->posts;
		self::$df_ratings = Different_Themes()->ratings;
	}


} 
?>