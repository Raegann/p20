<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    //get post settings
    $df_post = Different_Themes()->posts;
    $df_ratings = Different_Themes()->ratings;

	if( $df_post->compare( get_the_ID(), 'similar_posts' ) == "1" &&  !is_attachment() && get_post_type() == "post") {
	
		wp_reset_postdata();
		$categories = get_the_category($post->ID);
	    $catCount = count($categories);
	    //select a random category id
	    $id = rand(0,$catCount-1);
	    //cat id
	    $catId = $categories[$id]->term_id;
	    $count = Different_Themes()->options->get(THEME_NAME.'_similar_post_count');
	    if(!$count) $count = 3;

		if ($categories) {
			$category_ids = array();
			foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;

			$args=array(
				'category__in' => $category_ids,
				'post__not_in' => array($post->ID),
				'showposts'=> 2,
				'ignore_sticky_posts'=>1,
				'orderby' => 'rand'
			);

			$my_query = new wp_query($args);
			$postCount = $my_query->post_count;
			$counter = 1;
?>

<!-- Related articles -->
<div class="cs-single-related-aticles">
	<h4 class="cs-heading-subtitle"><?php esc_html_e("Related articles",'uniqmag');?></h4>

	<div class="cs-row">
		<?php
			wp_reset_postdata();
			if( $my_query->have_posts() ) {
				while ($my_query->have_posts()) {
					$my_query->the_post();

					//categories
					$categories = get_the_category($my_query->post->ID);
				    $catCount = count($categories);
				    //select a random category id
				    $cat_id = rand(0,$catCount-1);


					//get post ratings information
				    $avarage_rating = $df_ratings->avarage_rating(get_the_ID());
		?>
            <div class="cs-col cs-col-6-of-12">
                <!-- Block layout 3 -->
                <div class="cs-post-block-layout-3">
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
                            <h3>
                            	<a href="<?php the_permalink();?>"><?php the_title();?></a>
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
			                    <?php if( $avarage_rating ) { ?>
			                        <span class="cs-post-meta-rating" title="<?php printf ( esc_attr__('Rated %1$s out of %2$s','uniqmag'), floatval($avarage_rating[1]), intval($df_ratings::$max_val));?>">
			                            <span style="width: <?php echo floatval($avarage_rating[0]);?>%"><?php printf ( esc_html__('Rated %1$s out of %2$s','uniqmag'), floatval($avarage_rating[1]), intval($df_ratings::$max_val));?></span>
			                        </span>
			                    <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

		<?php if($counter%2==0 && $postCount!=$counter) { ?>
            </div>
            <div class="cs-row">
		<?php } ?>
		<?php $counter++; ?>

	<?php
			}
		} else { 
			esc_html_e('Sorry, no posts were found.','uniqmag'); 
		}
	?>
	</div>
</div>

	
	<?php } ?>
<?php } ?>

<?php wp_reset_postdata();  ?>
