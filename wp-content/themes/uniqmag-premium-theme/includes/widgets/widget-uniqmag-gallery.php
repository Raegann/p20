<?php
add_action('widgets_init', create_function('', 'return register_widget("different_themes_gallery");'));

class different_themes_gallery extends WP_Widget {
	function different_themes_gallery() {
		 parent::__construct (false, $name = THEME_FULL_NAME.' '.esc_html__("Latest Galleries",'uniqmag'));	
	}

	function form($instance) {
		/* Set up some default widget settings. */
		$defaults = array(
			'title' => esc_html__("Latest Galleries",'uniqmag'),
			'subtitle' => '',
			'count' => '3',
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = esc_attr($instance['title']);
		$subtitle = esc_attr($instance['subtitle']);
		$count = esc_attr($instance['count']);
        ?>
            <p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php  esc_html_e('Title:','uniqmag'); ?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			<p><label for="<?php echo esc_attr($this->get_field_id('count')); ?>"><?php  esc_html_e('Item shown:','uniqmag');?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id('count')); ?>" name="<?php echo esc_attr($this->get_field_name('count')); ?>" type="text" value="<?php echo esc_attr($count); ?>" /></label></p>

        <?php 
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['count'] = strip_tags($new_instance['count']);
		$instance['color'] = strip_tags($new_instance['color']);
		return $instance;
	}

	function widget($args, $instance) {
		extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
		$count = $instance['count'];
		$counter=1;
		if(!$count) $count=3;

		$my_query = new WP_Query(array('post_type' => UNIQMAG_DIFFERENT_THEME_POST_GALLERY, 'showposts' => $count));  

		
		$totalCount = $my_query->found_posts;
		//get post settings
	    $df_post = Different_Themes()->posts;
        ?>
	<?php echo balanceTags($before_widget, false); ?>
		<?php 
			if($title) { 
				echo balanceTags($before_title);
				echo esc_html($title);
				echo balanceTags($after_title);
			}
		?>
			<div class="cs-widget_gallery_post">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
						<?php if ( $my_query->have_posts() ) : while ( $my_query->have_posts() ) : $my_query->the_post(); ?>
							<?php
								
								$g = $my_query->post->ID;
								$gallery_style = get_post_meta ( $g, "_".THEME_NAME."_gallery_style", true );
								$galleryImages = get_post_meta ( $g, "orange_themes_gallery_gallery_images", true ); 
								$imageIDs = explode(",",$galleryImages);
								$src = uniqmag_different_themes_get_post_thumb($my_query->post->ID,330,250); 

								$term_list = wp_get_post_terms($my_query->post->ID, UNIQMAG_DIFFERENT_THEME_POST_GALLERY.'-cat');

								$catCount=0;
								foreach($term_list as $term){
									$catCount++;
								}
								
								$randID = rand(0,$catCount-1);	


							?>
                                <!-- Post item -->
                                <div class="swiper-slide">
                                    <div class="cs-post-item">
                                        <div class="cs-post-thumb">

							            	<?php 
							            		if( $df_post->compare( get_the_ID(), 'post_category' ) == "1" && $term_list ) { 
							            		$category_color = $df_post->get_color($randID,UNIQMAG_DIFFERENT_THEME_POST_GALLERY."-cat", false);
							            	?>
							                    <div class="cs-post-category-icon" style="border-right-color: <?php echo esc_attr($category_color);?>">
							                        <a href="<?php echo esc_url(get_term_link($term_list[$randID]->term_id, UNIQMAG_DIFFERENT_THEME_POST_GALLERY."-cat"));?>" title="<?php echo esc_attr(get_cat_name($term_list[$randID]->term_id));?>">
							                        	<i class="fa fa-gamepad"></i>
							                        </a>
							                    </div>
							                <?php } ?>
		                            
											<?php $df_post->image_html( get_the_ID(), 450, 300, null, null, true );?>
                                        </div>
                                        <div class="cs-post-inner">
                                            <div class="cs-align-middle">
                                                <h3>
                                                	<a href="<?php the_permalink();?>">
                                                		<?php the_title();?>
                                                	</a>
                                                </h3>
                                                <div class="cs-post-meta cs-clearfix">
									                <?php 
									                	if( $df_post->compare( get_the_ID(), 'post_author' ) == "1" ) { 
									                ?>
									                	<span class="cs-post-meta-author">
									                		<?php echo the_author_posts_link(); ?>
									                	</span>
									                <?php
									                	} 
									                ?>
									                <?php if( $df_post->compare( get_the_ID(), 'post_date' ) == "1" ) { ?>
								                    	<span class="cs-post-meta-date">
								                    		<?php the_time(get_option('date_format'));?>
								                    	</span>
								                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

						<?php $counter++; ?>
						<?php endwhile; ?>
						<?php endif; ?>	
					</div>

				</div>
                <!-- Gallery controls -->
                <div class="cs-widget_gallery_post-controls">
                    <div class="wgp-swiper-button-prev"><i class="fa fa-angle-left"></i></div>
                    <div class="wgp-swiper-button-next"><i class="fa fa-angle-right"></i></div>
                </div>
			</div>

		<?php echo balanceTags($after_widget, false); ?>	
        <?php
	}
}
?>