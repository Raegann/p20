<?php
add_action('widgets_init', create_function('', 'return register_widget("different_themes_popular_posts");'));

class different_themes_popular_posts extends WP_Widget {
	function different_themes_popular_posts() {
		 parent::__construct (false, $name = THEME_FULL_NAME.' '.esc_html__("Popular Posts",'uniqmag'));	
	}

	function form($instance) {
		/* Set up some default widget settings. */
		$defaults = array(
			'title' => esc_html__("Popular Posts",'uniqmag'),
			'count' => '3',
			'cat' => '',
			'style' => 'list',
			'images' => 'show',
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = $instance['title'];
		$cat = $instance['cat'];
		$count = $instance['count'];
		$images = $instance['images'];
		$style = $instance['style'];
        ?>
            <p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:','uniqmag'); ?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			<p><label for="<?php echo esc_attr($this->get_field_id('cat')); ?>"><?php esc_html_e('Category:','uniqmag');?>
			<?php
			$args = array(
				'type'                     => 'post',
				'child_of'                 => 0,
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 1,
				'hierarchical'             => 1,
				'taxonomy'                 => 'category');
				$args = get_categories( $args ); 
			?> 	
			<select name="<?php echo esc_attr($this->get_field_name('cat')); ?>" style="width: 100%; clear: both; margin: 0;">
				<option value=""><?php esc_html_e("Latest News",'uniqmag');?></option>
				<?php foreach($args as $ar) { ?>
					<option value="<?php echo esc_attr($ar->term_id); ?>" <?php if($ar->term_id==$cat)  {echo 'selected="selected"';} ?>><?php echo esc_html($ar->cat_name); ?></option>
				<?php } ?>
			</select>
			
			</label></p>
			<p><label for="<?php echo esc_attr($this->get_field_id('images')); ?>"><?php esc_html_e('Images:','uniqmag');?>
			<select name="<?php echo esc_attr($this->get_field_name('images')); ?>" style="width: 100%; clear: both; margin: 0;">
				<option value="show" <?php if("show"==$images)  {echo 'selected="selected"';} ?>><?php esc_html_e("Show",'uniqmag');?></option>
				<option value="hide" <?php if("hide"==$images)  {echo 'selected="selected"';} ?>><?php esc_html_e("Hide",'uniqmag');?></option>
			</select>
			
			</label></p>
			<p><label for="<?php echo esc_attr($this->get_field_id('style')); ?>"><?php esc_html_e('Style:','uniqmag');?>
			<select name="<?php echo esc_attr($this->get_field_name('style')); ?>" style="width: 100%; clear: both; margin: 0;">
				<option value="list" <?php if( "list" == $style )  { echo 'selected="selected"'; } ?>><?php esc_html_e("List",'uniqmag');?></option>
				<option value="grid" <?php if( "grid" == $style )  { echo 'selected="selected"'; } ?>><?php esc_html_e("Grid",'uniqmag');?></option>
				<option value="large" <?php if( "large" == $style )  { echo 'selected="selected"'; } ?>><?php esc_html_e("Large Images",'uniqmag');?></option>
			</select>
			
			</label></p>
			<p><label for="<?php echo esc_attr($this->get_field_id('count')); ?>"><?php esc_html_e('Post count:','uniqmag');?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id('count')); ?>" name="<?php echo esc_attr($this->get_field_name('count')); ?>" type="text" value="<?php echo esc_attr($count); ?>" /></label></p>

		
        <?php 
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['cat'] = strip_tags($new_instance['cat']);
		$instance['count'] = strip_tags($new_instance['count']);
		$instance['images'] = strip_tags($new_instance['images']);
		$instance['style'] = strip_tags($new_instance['style']);

		return $instance;
	}

	function widget($args, $instance) {
		extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
		$count = $instance['count'];
		$cat = $instance['cat'];
		$images = $instance['images'];
		$style = $instance['style'];

		$args=array(
			'posts_per_page' => $count,
			'order' => 'DESC',
			'cat' => $cat,
			'orderby'	=> 'meta_value_num',
			'meta_key'	=> "_".THEME_NAME.'_post_views_count',
			'post_type'=> 'post',
			'ignore_sticky_posts' => true
		);



		$the_query = new WP_Query($args);
		$counter = 1;
		
		$totalCount = $the_query->found_posts;
		
		$blogID = get_option('page_for_posts');
		
		if($cat) {
			$link = get_category_link( $cat );
		} else {
			$link = get_page_link($blogID);
		}

		//get post settings
	    $df_post = Different_Themes()->posts;
	    $df_ratings = Different_Themes()->ratings;
?>		
	<?php echo balanceTags($before_widget); ?>
		<?php 
			if($title) { 
				echo balanceTags($before_title);
				echo esc_html($title);
				echo balanceTags($after_title);
			}
		?>
		<?php if( $style == 'grid') { ?>
			<div class="cs-widget_grid_posts">
		<?php } else if( $style == 'large') { ?>
			<div class="cs-widget_featured_post">
		<?php } else { ?>
			<div class="cs-widget_latest_posts">
		<?php } ?>
			<?php if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post(); ?>
			<?php

                //categories
                $categories = get_the_category(get_the_ID());
			    $catCount = count($categories);
			    //select a random category id
			    $cat_id = rand(0,$catCount-1);
				//get post ratings information
			    $avarage_rating = $df_ratings->avarage_rating(get_the_ID());
			?>
				<?php if( $style == 'grid' ) { ?>
                    <!-- Post item -->
                    <div class="cs-post-item">
                        <div class="cs-post-thumb">
                            <?php
                                if( $df_post->compare( get_the_ID(), 'post_category' ) == "1" && $categories && ( $df_post->get_cat_icon($categories[$cat_id]->term_id) && $df_post->get_cat_icon($categories[$cat_id]->term_id) != "no-icon" ) ) { 
                                $category_color = $df_post->get_color($categories[$cat_id]->term_id,"category", false);
                            ?>
                                <div class="cs-post-category-icon" style="border-right-color: <?php echo esc_attr($category_color);?>">
                                    <a href="<?php echo esc_url(get_category_link($categories[$cat_id]->term_id));?>" title="<?php echo esc_attr(get_cat_name($categories[$cat_id]->term_id));?>">
                                        <i class="fa <?php esc_attr($df_post->cat_icon($categories[$cat_id]->term_id));?>"></i>
                                    </a>
                                </div>
                            <?php } ?>

		                    <a href="<?php the_permalink();?>">
		                    	<?php $df_post->image_html( get_the_ID(), 100, 75, null, null, true );?>
		                    </a>
                        </div>
                        <div class="cs-post-inner">
                            <h3>
                            	<a href="<?php the_permalink();?>">
                            		<?php the_title();?>
                            	</a>
                            </h3>
                            <div class="cs-post-meta cs-clearfix">
				               
				                <?php if( $df_post->compare( get_the_ID(), 'post_date' ) == "1" ) { ?>
			                    	<span class="cs-post-meta-date">
			                    		<?php the_time(get_option('date_format'));?>
			                    	</span>
			                    <?php } ?>
			                    <?php if( $avarage_rating ) { ?>
			                        <span class="cs-post-meta-rating" title="<?php printf ( esc_attr__('Rated %1$s out of %2$s','uniqmag'), floatval($avarage_rating[1]), intval($df_ratings::$max_val));?>">
			                            <span style="width: <?php echo floatval($avarage_rating[0]);?>%"><?php printf ( esc_html__('Rated %1$s out of %2$s','uniqmag'), floatval($avarage_rating[1]), intval($df_ratings::$max_val));?></span>
			                        </span>
			                    <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } else if ( $style == 'large' ) { ?>
                        <!-- Post item -->
                        <div class="cs-post-item">
                            <?php
                                if( $df_post->compare( get_the_ID(), 'post_category' ) == "1" && $categories && ( $df_post->get_cat_icon($categories[$cat_id]->term_id) && $df_post->get_cat_icon($categories[$cat_id]->term_id) != "no-icon" ) ) { 
                                $category_color = $df_post->get_color($categories[$cat_id]->term_id,"category", false);
                            ?>
                                <div class="cs-post-category-icon" style="border-right-color: <?php echo esc_attr($category_color);?>">
                                    <a href="<?php echo esc_url(get_category_link($categories[$cat_id]->term_id));?>" title="<?php echo esc_attr(get_cat_name($categories[$cat_id]->term_id));?>">
                                        <i class="fa <?php esc_attr($df_post->cat_icon($categories[$cat_id]->term_id));?>"></i>
                                    </a>
                                </div>
                            <?php } ?>
                            <div class="cs-post-thumb">
					           	<?php 
					            	if( $df_post->compare( get_the_ID(), 'post_icons' ) == "1" && $df_post->get_icon(get_post_format()) ) { 
					            ?>
					                <div class="cs-post-format-icon">
					                    <?php echo uniqmag_different_themes_html_output($df_post->get_icon(get_post_format()));?>
					                </div>
					            <?php } ?>
			                    <a href="<?php the_permalink();?>">
			                    	<?php $df_post->image_html( get_the_ID(), 450, 275, null, null, true );?>
			                    </a>
		                    </div>
                            <div class="cs-post-inner">
                                <h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                                <div class="cs-post-meta cs-clearfix">
					              
					                <?php if( $df_post->compare( get_the_ID(), 'post_date' ) == "1" ) { ?>
				                    	<span class="cs-post-meta-date">
				                    		<?php the_time(get_option('date_format'));?>
				                    	</span>
				                    <?php } ?>
                                </div>
                            </div>
                        </div>
				<?php } else { ?>
		            <!-- Post item -->
		            <div class="cs-post-item<?php if( $df_post->is_image(get_the_ID()) == false || $images == "hide" ) { ?> no-image<?php } ?>">
		                <?php if( $df_post->is_image(get_the_ID()) == true && $images!="hide" ) { ?>
			                <div class="cs-post-thumb">
			                    <a href="<?php the_permalink();?>">
			                    	<?php $df_post->image_html( get_the_ID(), 100, 75 );?>
			                    </a>
			                </div>
		                <?php } ?>
		                <div class="cs-post-inner">
                                     <div class="cs-post-meta cs-clearfix">
				          
				                <?php if( $df_post->compare( get_the_ID(), 'post_date' ) == "1" ) { ?>
			                    	<span class="cs-post-meta-date">
			                    		<?php the_time(get_option('date_format'));?>
			                    	</span>
			                    <?php } ?>
		                    </div>
		                    <h3>
		                    	<a href="<?php the_permalink();?>">
		                    		<?php the_title();?>
		                    	</a>
		                    </h3>
			            	<?php if( $df_post->compare( get_the_ID(), 'post_category' ) == "1" && $categories ) { ?>
			                    <div class="cs-post-category-empty cs-clearfix">
			                    	<?php 
			                    		foreach($categories as $cat) {
			                    			$category_color = $df_post->get_color($cat->term_id,"category", false);
			                    	?>
			                        	<a href="<?php echo esc_url(get_category_link($cat->term_id));?>" style="color:<?php echo esc_attr($category_color);?>">
			                        		<?php echo esc_html(get_cat_name($cat->term_id));?>
			                        	</a>
			                        <?php } ?>
			                    </div>
			                <?php } ?>
		                   
		                </div>
		            </div>
		        <?php } ?>
			<?php endwhile; else: ?>
				<p><?php  esc_html_e('No posts where found','uniqmag');?></p>
			<?php endif; ?>
		</div>

	<?php echo balanceTags($after_widget); ?>
    <?php
	}
}
?>