<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	wp_reset_postdata();

	//get post settings
    $df_post = Different_Themes()->posts;
    $df_ratings = Different_Themes()->ratings;

	$video = get_post_meta( $post->ID, "_".THEME_NAME."_video_code", true );
	$slider = get_post_meta( $post->ID, THEME_NAME."_gallery_images", true );
	$audio = get_post_meta( $post->ID, "_".THEME_NAME."_audio", true );
	$image = uniqmag_different_themes_get_post_thumb($post->ID,0,0); 
	$votes = get_post_meta( $post->ID, "_".THEME_NAME."_total_votes", true );
    //categories
    $categories = get_the_category($post->ID);

    $post_class = "cs-single-post";
    
    if($df_post->compare( get_the_ID(), 'share_buttons' ) != "1" ) {
		$post_class.= " cs-single-post-no-share-buttons";
	}
?>

	<?php get_template_part(UNIQMAG_DIFFERENT_THEME_LOOP."loop-start"); ?>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


            <!-- Post header -->
            <header class="cs-post-single-title">
                <?php if(get_post_type(get_the_ID()) === 'workingplaces') : ?>
                  <a href="<?php echo get_post_type_archive_link( 'workingplaces' ); ?>">Zpět na výpis pozic</a>
                <?php endif; ?>
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
                <?php get_template_part(UNIQMAG_DIFFERENT_THEME_SINGLE."post-title"); ?>
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
	                		<?php echo get_the_author(); ?>
	                	</span>
	                <?php
	                	} 
	                ?>
                    
                    
	                
                    
                </div>
                
                  
                   <?php get_template_part(UNIQMAG_DIFFERENT_THEME_SINGLE."post-tags"); ?>
                     
                 
                <?php if(get_post_type(get_the_ID()) === 'workingplaces') : ?>
                      <div class="workingplaces-company">
                             <?php echo get_field('spolecnost'); ?>
                        </div>
                <?php endif; ?>
                
                 <?php if(get_post_type(get_the_ID()) === 'action') : ?>
                        <div class="action-date">  
                              <?php
                                        $date = new DateTime(get_field('datum_akce'));
                                         echo $date->format('d. m. Y');
                              ?>
                        </div>
                <?php endif; ?>

            </header>

	        <!-- Single post -->
	        <article <?php post_class($post_class); ?>>
                     
	            <!-- Post share -->
	            <?php get_template_part(UNIQMAG_DIFFERENT_THEME_SINGLE."post-share"); ?>
	            <!-- Post content -->
	            <div class="cs-single-post-content">
	                <!-- Media -->
	            	<?php get_template_part(UNIQMAG_DIFFERENT_THEME_SINGLE."image");?>

	                <!-- Content -->
	                <div class="cs-single-post-paragraph">
                                <?php if(get_post_type(get_the_ID()) === 'foogallery') : ?>
                                    <?php echo do_shortcode('[foogallery id="'.get_the_ID().'"]'); ?>
                                <?php else : ?>
						<?php wp_reset_postdata();?>		
						<?php
								
							the_content();
						?>	
						<?php 
							$args = array(
								'before'           => '<div class="post-pages"><p>' . esc_html__('Pages:','uniqmag'),
								'after'            => '</p></div>',
								'link_before'      => '',
								'link_after'       => '',
								'next_or_number'   => 'number',
								'nextpagelink'     => esc_html__('Next page','uniqmag'),
								'previouspagelink' => esc_html__('Previous page','uniqmag'),
								'pagelink'         => '%',
								'echo'             => 1
							);

							wp_link_pages($args); 
						?>
                                <?php endif; ?>
	                </div>
	               

	            </div>
	        </article>

	        <!-- Review -->
			<?php get_template_part(UNIQMAG_DIFFERENT_THEME_SINGLE."post-ratings"); ?>
			
			<!-- Controls -->
			<?php get_template_part(UNIQMAG_DIFFERENT_THEME_SINGLE."post-nav"); ?>

			<?php get_template_part(UNIQMAG_DIFFERENT_THEME_SINGLE."about-author"); ?>
			
			<!-- Related articles -->
			<?php get_template_part(UNIQMAG_DIFFERENT_THEME_SINGLE."post-related"); ?>


			<?php wp_reset_postdata(); ?>
			<?php if ( comments_open() ) : ?>
				<?php comments_template(); // Get comments.php template ?>
			<?php endif; ?>

		<?php endwhile; else: ?>
			<p><?php  esc_html_e('Sorry, no posts matched your criteria.','uniqmag'); ?></p>
		<?php endif; ?>

<?php get_template_part(UNIQMAG_DIFFERENT_THEME_LOOP."loop-end"); ?>