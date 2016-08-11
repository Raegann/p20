<?php 
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	get_header();
	wp_reset_postdata();
	//get post settings
    $df_post = Different_Themes()->posts;



	$galleryImages = get_post_meta ( $post->ID, "different_themes_gallery_gallery_images", true ); 
	$imageIDs = explode(",",$galleryImages);
	$count = uniqmag_different_themes_image_count($post->ID);

	//main image
	$file = wp_get_attachment_url($imageIDs[0]);
	$image = uniqmag_different_themes_get_post_thumb(false, 916, 0, false, $file);	

	$term_list = wp_get_post_terms($post->ID, UNIQMAG_DIFFERENT_THEME_POST_GALLERY.'-cat');

	$catCount=0;
	foreach($term_list as $term){
		$catCount++;
	}
	
	$randID = rand(0,$catCount-1);	

	$galID = uniqmag_different_themes_get_page("gallery-1");
	$title = get_the_title($galID[0]);
	$subTitle = get_post_meta( $galID[0], "_".THEME_NAME."_subtitle", true );
?>
<?php get_template_part(UNIQMAG_DIFFERENT_THEME_LOOP."loop-start"); ?>
	<?php get_template_part(UNIQMAG_DIFFERENT_THEME_SINGLE."page-title"); ?>
    <!-- Gallery single -->
    <div class="cs-gallery-single">
        <!-- Slider -->
        <div class="cs-thumbnail-slider">
            <!-- Swiper -->
            <div class="swiper-container cs-gallery-top">
                <div class="swiper-wrapper">
		    		<?php 
		        		$c=1;
		        		foreach($imageIDs as $id) { 
		        			if($id) {
		            			$file = wp_get_attachment_url($id);
		            			$image = uniqmag_different_themes_get_post_thumb(false, 1012, 0, false, $file);
		            			$imageL = uniqmag_different_themes_get_post_thumb(false, 0, 0, false, $file);
		        	?>
	                    <!-- Slide -->
	                    <div class="swiper-slide">
	                        <div class="cs-post-item">
	                            <div class="cs-post-thumb">
	                                <img src="<?php echo esc_url($image['src']);?>" alt="<?php echo esc_attr($title); ?>">
	                            </div>
	                        </div>
	                    </div><!-- end .swiper-slide -->

	                <?php $c++; ?>
	           	 	<?php } ?>
	            <?php } ?>

                </div>
            </div>
            <div class="swiper-container cs-gallery-thumbs">
                <div class="swiper-wrapper">
 		    		<?php 
		        		$c=1;
		        		foreach($imageIDs as $id) { 
		        			if($id) {
		            			$file = wp_get_attachment_url($id);
		            			$image = uniqmag_different_themes_get_post_thumb(false, 100, 67, false, $file);
		            			$imageL = uniqmag_different_themes_get_post_thumb(false, 0, 0, false, $file);
		        	?>
		        	
		        		<div class="swiper-slide">
		        			 <img src="<?php echo esc_url($image['src']);?>" alt="<?php echo esc_attr($title); ?>">
		        		</div>

		                <?php $c++; ?>
		           	 	<?php } ?>
		            <?php } ?>

                </div>
            </div>
        </div><!-- end .cs-thumbnail-slider-->
		<?php 
			if (get_the_content() != "") { 				
				add_filter('the_content','uniqmag_different_themes_remove_images');
				add_filter('the_content','uniqmag_different_themes_remove_objects');
				the_content();
			} 
		?>	
    </div><!-- end .cs-gallery-single -->

        <?php if( $df_post->compare( get_the_ID(), 'similar_posts_gallery','similar_posts' ) == "1") { ?> 
        <!-- Gallery grid -->
        <div class="cs-gallery-category-grid">
            <div class="cs-row">
				<?php 
					$categories = get_the_terms($post->ID, UNIQMAG_DIFFERENT_THEME_POST_GALLERY.'-cat');
					$categoriesNew = array();
					$i=0;
					if(!empty($categories)) {
						foreach ($categories as $category) {
							$categoriesNew[$i]['term_id'] = $category->term_id;
							$categoriesNew[$i]['name'] = $category->name;
							$i++;
						}
						$categories = $categoriesNew;
						if($i==1) {
							$randID = 0;
						} else {
							$randID = rand(0,$i-1);
						}
					} else {
						$randID = 0;
					}


					$counter=1;
					$my_query = new WP_Query( 
						array( 
							'post__not_in' => array($post->ID),
							'post_type' => UNIQMAG_DIFFERENT_THEME_POST_GALLERY, 
							'showposts' => 3, 
							'tax_query' => array(
								array(
									'taxonomy' => UNIQMAG_DIFFERENT_THEME_POST_GALLERY.'-cat',
									'field' => 'id',
									'terms' => $categories[$randID]['term_id'],
								)
							),
							'orderby' => 'rand'
						)
					);
					
					if ( $my_query->have_posts() ) : while ( $my_query->have_posts() ) : $my_query->the_post(); 
						$term_list = wp_get_post_terms($my_query->post->ID, UNIQMAG_DIFFERENT_THEME_POST_GALLERY.'-cat');
						$catCount=0;
						foreach($term_list as $term){
							$catCount++;
						}
						
						$randID = rand(0,$catCount-1);	

						$src = uniqmag_different_themes_get_post_thumb($my_query->post->ID,717,472);
					?>

                        <div class="cs-col cs-col-4-of-12">
                            <!-- Gallery item -->
                            <div class="cs-post-item">
                                <div class="cs-post-thumb">
                                    <div class="cs-post-category-icon">
                                        <a href="#" title="Games"><i class="fa fa-gamepad"></i></a>
                                    </div>
                                    <div class="cs-photo-count"><?php echo esc_html(sprintf( _n( '%s photo', '%s photos', uniqmag_different_themes_image_count(get_the_ID()), 'uniqmag' ), uniqmag_different_themes_image_count(get_the_ID()) ));?></div>
                                    <a href="<?php the_permalink();?>">
                                    	 <img src="<?php echo esc_url($src["src"]); ?>" alt="<?php esc_attr(get_the_title());?>" />
                                    </a>
                                </div>
                                <div class="cs-post-inner">
                                    <h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                                </div>
                            </div><!-- end .cs-gallery-item -->
                        </div>

					<?php 
						if($counter%3==0 && $counter!=$my_query->post_count) {
					?>
						</div>
						<div class="cs-row">

					<?php
						} 
					?>
					<?php $counter++; ?>
				<?php endwhile; ?>
				<?php else : ?>
					<h2 class="title"><?php esc_html_e('No galleries were found','uniqmag');?></h2>
				<?php endif; ?>
			</div>
		</div>
		<?php } ?> 

<?php get_template_part(UNIQMAG_DIFFERENT_THEME_LOOP."loop-end"); ?>
<?php get_footer(); ?>