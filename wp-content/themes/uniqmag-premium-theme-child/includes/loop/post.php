<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	//get post settings
    $df_post = Different_Themes()->posts;
    $df_ratings = Different_Themes()->ratings;
 

	//counter
	$count = 1;
        if(is_home() || is_front_page())
        {
            $blogStyle = 7;
            $sidebar = uniqmag_different_themes_get_custom_option( get_cat_id( single_cat_title("",false) ), 'sidebar_select', false );
        }
	else if(is_category()) {
		$blogStyle = uniqmag_different_themes_get_custom_option( get_cat_id( single_cat_title("",false) ), 'blogStyle', false );
		$sidebar = uniqmag_different_themes_get_custom_option( get_cat_id( single_cat_title("",false) ), 'sidebar_select', false );
	} else if( is_tax() || is_tag() ) {
		$blogStyle = uniqmag_different_themes_get_custom_option( get_queried_object()->term_id, 'blogStyle', false );
		$sidebar = uniqmag_different_themes_get_custom_option( get_queried_object()->term_id, 'sidebar_select', false );
	} else {
		$blogStyle = get_post_meta ( Different_Themes()->page_id(), "_".THEME_NAME."_blogStyle", true ); 	
		$sidebar = get_post_meta( Different_Themes()->page_id(), "_".THEME_NAME.'_sidebar_select', true );
	}

	if(!$blogStyle) {
		$blogStyle = 1;
	}



	switch ($blogStyle) {
		case '1':
			$post_wrap_class = "cs-row";
			break;
		case '2':
			$post_wrap_class = "cs-row";
			break;
		case '3':
			$post_wrap_class = "cs-post-block-layout-4";
			break;
		case '4':
			$post_wrap_class = "cs-row";
			break;
		case '5':
			$post_wrap_class = "cs-row";
			break;
		case '6':
			$post_wrap_class = "cs-row";
			break;
                case '7':
                        $post_wrap_class = "cs-row";
			break;
	}


	?>
       <div class="<?php echo esc_attr($post_wrap_class); ?>">Tets
           
                               
                <?php  $getslugid = wp_get_post_terms( $post->ID, 'profession' ); 
                            foreach( $getslugid as $thisslug ) {

                                echo $thisslug->slug . ' '; 
                                $term_link = get_term_link( $term );
                                echo $term_link;

                }?>
           
                    
	<?php

	if (have_posts()) : while (have_posts()) : the_post();


		switch ($blogStyle) {
			case '1':
				$post_class = "cs-col cs-col-12-of-12";
				$postsInRow = 2;
				break;
			case '2':
				$post_class = "cs-col cs-col-6-of-12";
				$postsInRow = 2;
				break;
			case '3':
				$post_class = "cs-post-item";
				$postsInRow = false;
				break;
			case '4':
				$post_class = "cs-post-item";
				$postsInRow = 2;
				break;
			case '5':
				$post_class = "cs-post-item";
				$postsInRow = 2;
				break;
			case '6':
				$post_class = "cs-col cs-col-6-of-12";
				$postsInRow = 2;
				break;
                        case '7':
				$post_class = "cs-col cs-col-6-of-12";
				$postsInRow = 2;
				break;
		}


		if( $df_post->is_image(get_the_ID()) != true ) {
			$post_class.= " no-image";
		}

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

	<?php if($blogStyle=="1" || $blogStyle=="2") { ?>
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
                        <?php if(get_post_type(get_the_ID()) === 'workingplaces') : ?>
                        <div class="workingplaces-company">

                                    <?php if(get_field('spolecnost', get_the_ID())) : ?>
                                        <?php echo get_field('spolecnost', get_the_ID()); ?>

                                    <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if(get_post_type(get_the_ID()) === 'action') : ?>
                            <div class="workingplaces-company">

                                    <?php
                                        $date = new DateTime(get_field('datum_akce'));
                                        echo $date->format('d. m. Y'); 
                                     ?>
                            </div>
                        <?php endif; ?>
                        <div class="cs-post-meta cs-clearfix">
			               
			                <?php if( $df_post->compare( get_the_ID(), 'post_date' ) == "1" ) { ?>
                            	<span class="cs-post-meta-date">
                            		<?php the_time(get_option('date_format'));?>
                            	</span>
                            <?php } ?>
                             <?php 
			                	if( $df_post->compare( get_the_ID(), 'post_author' ) == "1" ) { 
			                ?>
			                	<span class="cs-post-meta-author">
			                		<?php echo the_author_posts_link(); ?>
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
                            
                            <?php if( $df_post->compare( get_the_ID(), 'post_category' ) == "1" && $categories ) { ?>
		                        <div class="cs-post-category-border cs-clearfix new-category">
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
                            
                         
                            
                            <?php if( $avarage_rating ) { ?>
	                            <span class="cs-post-meta-rating" title="<?php printf ( esc_attr__('Rated %1$s out of %2$s','uniqmag'), floatval($avarage_rating[1]), intval($df_ratings::$max_val));?>">
	                                <span style="width: <?php echo floatval($avarage_rating[0]);?>%"><?php printf ( esc_html__('Rated %1$s out of %2$s','uniqmag'), floatval($avarage_rating[1]), intval($df_ratings::$max_val));?></span>
	                            </span>
                            <?php } ?>
                        </div>
                        <?php 
                        	if( $blogStyle == "2" ) { 
						?>
							<p class="cs-post-excerpt">
								<?php echo esc_html($df_post->get_the_excerpt(12)); ?>
							</p>
						<?php 
                        	}
                        ?>
                    </div>
                </div>
            </div>
        </div>

    <?php } elseif( $blogStyle=="3") { ?>
                    
        <!-- Post item -->
        <div <?php post_class($post_class); ?> id="post-<?php the_ID(); ?>">
            <?php if( $df_post->is_image(get_the_ID()) == true ) { ?>
	            <div class="cs-post-thumb">
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
            	<?php if( $df_post->compare( get_the_ID(), 'post_category' ) == "1" && $categories ) { ?>
                    <div class="cs-post-category-solid cs-clearfix">
                    	<?php 
                    		foreach($categories as $cat) {
                    			$category_color = $df_post->get_color($cat->term_id,"category", false);
                    	?>
                        	<a href="<?php echo esc_url(get_category_link($cat->term_id));?>" style="background-color:<?php echo esc_attr($category_color);?>">
                        		<?php echo esc_html(get_cat_name($cat->term_id));?>
                        	</a>
                        <?php } ?>
                    </div>
                <?php } ?>

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
                    <?php if( $avarage_rating ) { ?>
                        <span class="cs-post-meta-rating" title="<?php printf ( esc_attr__('Rated %1$s out of %2$s','uniqmag'), floatval($avarage_rating[1]), intval($df_ratings::$max_val));?>">
                            <span style="width: <?php echo floatval($avarage_rating[0]);?>%"><?php printf ( esc_html__('Rated %1$s out of %2$s','uniqmag'), floatval($avarage_rating[1]), intval($df_ratings::$max_val));?></span>
                        </span>
                    <?php } ?>
                </div>
				<p class="cs-post-excerpt">
					<?php echo esc_html($df_post->get_the_excerpt(20)); ?>
                                         
				</p>
                <a class="cs-post-read-more" href="<?php the_permalink();?>">
                	<?php esc_html_e("Read more",'uniqmag');?> <i class="fa fa-angle-double-right"></i>
                </a>
            </div>
        </div>
        


    <?php } elseif( $blogStyle == "4" ) { ?>
    	<div class="cs-col cs-col-6-of-12">
            <!-- Block layout 2 -->
            <div class="cs-post-block-layout-2">
		        <!-- Post item -->
		        <div <?php post_class($post_class); ?> id="post-<?php the_ID(); ?>">
		            <?php if( $df_post->is_image(get_the_ID()) == true ) { ?>
			            <div class="cs-post-thumb">
				            <?php get_template_part(UNIQMAG_DIFFERENT_THEME_LOOP."image"); ?>
			            </div>
		            <?php } ?>
		            <div class="cs-post-inner">
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
    <?php } elseif( $blogStyle == "5" ) { ?>
        <div class="cs-col cs-col-6-of-12">
            <!-- Block layout 5 -->
            <div class="cs-post-block-layout-5">
                <!-- Post item -->
                <div <?php post_class($post_class); ?> id="post-<?php the_ID(); ?>">
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


		            <?php if( $df_post->is_image(get_the_ID(), true) == true ) { ?>
			            <div class="cs-post-thumb">
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

    <?php } elseif( $blogStyle == "6" ) { ?>
        <div <?php post_class($post_class); ?> id="post-<?php the_ID(); ?>">
            <!-- Block layout 6 -->
            <div class="cs-post-block-layout-6">
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

		            <?php if( $df_post->is_image(get_the_ID(), true) == true ) { ?>
			            <div class="cs-post-thumb">
				            <?php get_template_part(UNIQMAG_DIFFERENT_THEME_LOOP."image"); ?>
			            </div>
		            <?php } ?>
		            <div class="cs-post-inner">

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

    <?php } ?>
        


<?php if($postsInRow != false && $count%$postsInRow==0 && $count!=$wp_query->post_count) { ?>
        

</div>
<!-- Row -->
<div class="<?php echo esc_attr($post_wrap_class); ?>">
  

<?php } ?>
		<?php $count++; ?>
	<?php endwhile; else: ?>
		<?php get_template_part(UNIQMAG_DIFFERENT_THEME_LOOP."no-post"); ?>
	<?php endif; ?>


		</div>



