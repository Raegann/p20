<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	wp_reset_postdata();
	$post_type = get_post_type();
    if((!is_category() && $post_type=="post" && Different_Themes()->options->get(THEME_NAME."_breaking_news_post") == "on" && Different_Themes()->page_id() != get_option('page_for_posts')) || 
        (!is_category() && Different_Themes()->options->get(THEME_NAME."_breaking_news_page") == "on" && is_page() && !is_page_template('template-homepage.php') && Different_Themes()->page_id() != get_option('page_for_posts')) ||
        (!is_category() && Different_Themes()->options->get(THEME_NAME."_breaking_news_blog") == "on" && Different_Themes()->page_id() == get_option('page_for_posts')) ||
        (!is_category() && Different_Themes()->options->get(THEME_NAME."_breaking_news_home") == "on" && is_page_template('template-homepage.php')) ||
        (is_category() && uniqmag_different_themes_get_custom_option( get_cat_id( single_cat_title("",false) ), 'breaking_slider', false ) != "slider_off")) { 

		//braking slider		
		$breakingSlider = Different_Themes()->options->get(THEME_NAME.'_breaking_slider');
	

?>
		<?php
			if(is_category()) {
				$catId = get_cat_id( single_cat_title("",false) );
				$category_in = $catId;
			} else {
				$category_in = $breakingSlider;
			}

			$args=array(
				'category__in' => $category_in,
				'posts_per_page' => 6,
				'order'	=> 'DESC',
				'orderby'	=> 'date',
				'meta_key'	=> "_".THEME_NAME.'_breaking_post',
				'meta_value'	=> 'on',
				'post_type'	=> 'post',
				'ignore_sticky_posts'	=> true,
				'post_status '	=> 'publish'
			);
			$the_query = new WP_Query($args);
		?>
                <!-- Braking news -->
                <div id="cs-breaking-news">
                    <div class="cs-container swiper-container">
                        <div class="cs-breaking-news-title"><?php esc_html_e("Breaking news",'uniqmag');?></div>
                       	<div class="cs-breaking-news-display swiper-wrapper">
							<?php if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post(); ?>
		                        <div class="swiper-slide">
		                            <a href="<?php the_permalink();?>"><?php the_title();?></a>
		                        </div>
							<?php endwhile; else: ?>
								<div class="swiper-slide"><?php  esc_html_e('Please be sure that you have selected breaking slider posts, you can do it by adding/editing a post that you want to see in the slider.','uniqmag');?></div>
							<?php endif; ?>
                        </div>
                    </div>
                </div>

<?php wp_reset_postdata();  ?>
	<?php } ?>
