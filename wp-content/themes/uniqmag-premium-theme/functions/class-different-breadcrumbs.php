<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Different_Themes_Breadcrumbs {

	var $delimiter = '';
	var $currentBefore = '<li>';
	var $currentAfter = '</li>';
	var $breadcrumbs = "";


	public function html_out() {

	  	if ( !is_page_template('template-homepage.php') && !is_home() && !is_front_page() || is_paged() || (get_queried_object_id() == get_option('page_for_posts'))) {
	 
			$this->breadcrumbs ='<ul class="breadcrumb">';

			global $post;
			$home = get_home_url('/');
			$this->breadcrumbs.= $this->currentBefore . '<a href="' . esc_url($home) . '">' . esc_html__('Homepage','uniqmag') . '</a>' . $this->currentAfter . $this->delimiter . ' ';
	 
		    if ( is_category() ) {
				global $wp_query;
				$cat_obj = $wp_query->get_queried_object();
				$thisCat = $cat_obj->term_id;
				$thisCat = get_category($thisCat);
				$parentCat = get_category($thisCat->parent);
				if ($thisCat->parent != 0) {
					$this->breadcrumbs.=$this->currentBefore . (get_category_parents($parentCat, TRUE, ' ' . $this->delimiter . ' ')).$this->currentAfter;
				} 
				$this->breadcrumbs.=$this->currentBefore . single_cat_title('', false).$this->currentAfter;
		 
		    }
		    if ( is_day() ) {
				$this->breadcrumbs.=$this->currentBefore . '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li>' . $this->delimiter . ' ';
				$this->breadcrumbs.=$this->currentBefore . '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a>'. $this->currentAfter . $this->delimiter . ' ';
				$this->breadcrumbs.=$this->currentBefore . get_the_time('d') . $this->currentAfter;
		 
		    }

		    if ( is_month() ) {
				$this->breadcrumbs.=$this->currentBefore . '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $this->currentAfter . $this->delimiter . ' ';
				$this->breadcrumbs.=$this->currentBefore . get_the_time('F') . $this->currentAfter;
		 
		    }

		    if ( is_year() ) {
				$this->breadcrumbs.=$this->currentBefore . get_the_time('Y') . $this->currentAfter;
		 
		    }

		    if ( is_single() ) {
		    	
				if(get_the_category()) {
					$cat = get_the_category(); $cat = $cat[0];
				} else {
					$cat = false;
				}
				$pageType = get_query_var( 'post_type' );
				$terms = get_terms( $pageType.'-cat', 'orderby=count&hide_empty=0' );
				if($cat) {
					$categorys = explode("|",get_category_parents($cat, TRUE, '|' . $this->delimiter . ''),-1); 
					foreach($categorys as $category) { 
						$this->breadcrumbs.=$this->currentBefore . $category.$this->currentAfter;
					}
				} elseif (!$cat && is_array($terms)) {
					if(isset($terms[0]->slug)) {
						$this->breadcrumbs.=$this->currentBefore . "<a href=".get_term_link( $terms[0]->slug, $pageType."-cat" ).">".$terms[0]->name."</a>".$this->currentAfter.$this->delimiter;
					}
				}
				$this->breadcrumbs.=$this->currentBefore;
				$this->breadcrumbs.=get_the_title();
				$this->breadcrumbs.=$this->currentAfter;
		 
		    }

		    if ( is_page() && !$post->post_parent ) {
				$this->breadcrumbs.=$this->currentBefore;
				$this->breadcrumbs.=get_the_title();
				$this->breadcrumbs.=$this->currentAfter;
		 
		    }

		    if ( is_page() && $post->post_parent ) {
				$parent_id = $post->post_parent;
				$breadcrumbsA = array();
				while ($parent_id) {
					$page = get_page($parent_id);
					$breadcrumbsA[] = $this->currentBefore.'<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>'.$this->currentAfter;
					$parent_id  = $page->post_parent;
				}
				$breadcrumbsA = array_reverse($breadcrumbsA);
				foreach ($breadcrumbsA as $crumb) {
					$this->breadcrumbs.= $crumb . '' . $this->delimiter . '';
				
				}

					
				$this->breadcrumbs.=$this->currentBefore;
				$this->breadcrumbs.=get_the_title();
				$this->breadcrumbs.=$this->currentAfter;
		 
		    }
		    if ( is_search() ) {
				$this->breadcrumbs.=$this->currentBefore . get_search_query() . $this->currentAfter;
		    }
		    if ( is_tag() ) {
				$this->breadcrumbs.=$this->currentBefore.single_tag_title(null, false).$this->currentAfter;
		    }
		    if ( is_author() ) {
				global $author;
				$userdata = get_userdata($author);
				$this->breadcrumbs.=$this->currentBefore . $userdata->display_name . $this->currentAfter;
		    }
		    if ( is_404() ) {
				$this->breadcrumbs.=$this->currentBefore . 'Error 404' . $this->currentAfter;
		    }

			$page_id = get_queried_object_id();

			if ( class_exists( 'woocommerce' ) && is_shop()) {
				$page_id = woocommerce_get_page_id('shop');
			}

		    if( $page_id == get_option('page_for_posts')) {
				$this->breadcrumbs.=$this->currentBefore .get_the_title($page_id). $this->currentAfter;
			}
			if (is_tax()) {
				$this->breadcrumbs.=$this->currentBefore;
				global $wp_query;
				$term =	$wp_query->queried_object;
				$this->breadcrumbs.=$term->name;
		      	$this->breadcrumbs.=$this->currentAfter;
			}
		 	
		    if ( get_query_var('paged') ) {
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
					$this->breadcrumbs.=' (';
				}
				$this->breadcrumbs.=$this->currentBefore.esc_html__('Page','uniqmag') . ' '.get_query_var('paged'). $this->currentAfter;
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
					$this->breadcrumbs.=')';
				} 
		    }
		 
		    $this->breadcrumbs.='</ul>';
		 
	  }

	}
}
?>