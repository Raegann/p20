<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	//get post settings
    $df_post = Different_Themes()->posts;
    $df_ratings = Different_Themes()->ratings;
 
    $blogStyle = 8;
    $post_wrap_class = "cs-row";
    $post_class = "cs-col cs-col-6-of-12";
    $postsInRow = 2;
    
    $post_class.= " no-image";
    
    $count = 1;
?>


    <div class="<?php echo esc_attr($post_wrap_class); ?>">
           
                                        

	<?php

	if (have_posts()) : while (have_posts()) : the_post();

		//categories
		$categories = get_the_category(get_the_ID());
	    $catCount = count($categories);
	    //select a random category id
	    $cat_id = rand(0,$catCount-1);

		$audio = get_post_meta( get_the_ID(), "_".THEME_NAME."_audio", true );
		$slider = get_post_meta ( get_the_ID(),  THEME_NAME."_gallery_images", true ); 	

		//get post ratings information

	    $avarage_rating = $df_ratings->avarage_rating(get_the_ID());

?>
        <div <?php post_class($post_class); ?> id="post-<?php the_ID(); ?>">
            <!-- Block layout 3 -->
            <div class="cs-post-block-layout-3">
                 
                <!-- Post item -->
                <div class="cs-post-item">
                	<?php if( $df_post->is_image(get_the_ID()) == true ) { ?>
	                    <div class="cs-post-thumb">
	                    	<?php if( $df_post->compare( get_the_ID(), 'post_category' ) == "1" && $categories ) { ?>
		                        <div class="cs-post-category-border cs-clearfix">
		                        	<?php 
		                        		foreach($categories as $cat) {
		                        			$category_color = $df_post->get_color($cat->term_id,"category", false);
		                        	?>
		                            	<a href="<?php echo esc_url(get_category_link($cat->term_id));?>" style="border-color:<?php echo esc_attr($category_color);?>">
		                            		<?php echo esc_html(get_cat_name($cat->term_id));?>
		                            	</a>
		                            <?php } ?>
		                        </div>
		                    <?php } ?>
		                   	<?php 
				            	if( $df_post->compare( get_the_ID(), 'post_icons' ) == "1" && $df_post->get_icon(get_post_format()) ) { 
				            ?>
		                        <div class="cs-post-format-icon">
		                            <?php echo uniqmag_different_themes_html_output($df_post->get_icon(get_post_format()));?>
		                        </div>
	                        <?php } ?>
	                        <?php get_template_part(UNIQMAG_DIFFERENT_THEME_LOOP."image"); ?>
	                    </div>
                    <?php } ?>
               <div class="cs-post-inner">
                        <h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                        
                        <?php the_date(); ?>
                        
                       
                        <?php

                                $gal = foogallery_get_all_galleries();
                                $args = array(
                                    'width'  => 250,
                                    'height' => 250,
                                    'crop'   => true,
                                );

                                if($tmp==null){

                                    $tmp = 0;

                                }
            
                                $g = $gal[$tmp];


                                $src = apply_filters('foogallery_attachment_resize_thumbnail', $g->featured_image_src('full'), $args, $g);
                                $tmp += 1;
                                ?>
                        <li>
                    <a href="<?php echo get_the_permalink($g->ID) ?>">
                        <img src="<?php echo $src ?>"/>

                        <div class="hover_overlay">
                            <div class="centered">
                                <span class="line"></span>
                                <span
                                    class="description"><?php echo $g->settings['masonry-direction-hover_description'] ?></span>
                            </div>
                        </div>
                    </a>
                </li>

                        <div class="cs-post-meta cs-clearfix">
			               
			                <?php if( $df_post->compare( get_the_ID(), 'post_date' ) == "1" ) { ?>
                            	<span class="cs-post-meta-date">
                            		<?php the_time(get_option('date_format'));?>
                            	</span>
                            <?php } ?>
                             <?php 
			                	if( $df_post->compare( get_the_ID(), 'postAuthor' ) == "1" ) { 
			                ?>
			                	<span class="cs-post-meta-author">
			                		<?php echo get_the_author(); ?>
			                	</span>
			                <?php
			                	} 
			                ?>
                            
                                                    <?php
                                                            $my_excerpt = get_the_excerpt();
                                                            if ( '' != $my_excerpt ) {
                                                                    // Some string manipulation performed
                                                            }
                                                            echo $my_excerpt; // Outputs the processed value to the page
                                                    ?>
                            
                            
  /* Kategorie */                          
                            
                            
                            
                         
                            
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

<?php if($postsInRow != false && $count%$postsInRow==0 && $count!=$wp_query->post_count) { ?>
        

</div>
<!-- Row -->
<div class="<?php echo esc_attr($post_wrap_class); ?>">
  

    <?php } ?>
		<?php $count++; ?>
	<?php
        endwhile;
    else: ?>
            <?php get_template_part(UNIQMAG_DIFFERENT_THEME_LOOP."no-post"); ?>
    <?php endif; ?>
</div>