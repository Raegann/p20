<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/* Template Name: Photo Gallery */
?>
<?php get_header(); ?>
<?php
	wp_reset_postdata();
	//get post settings
    $df_post = Different_Themes()->posts;

	$paged = uniqmag_different_themes_get_query_string_paged();
	$posts_per_page = Different_Themes()->options->get(THEME_NAME.'_gallery_items');

	if($posts_per_page == "") {
		$posts_per_page = Different_Themes()->options->get('posts_per_page');
	}
	
	$catSlug = $wp_query->queried_object->slug;
	if(!$catSlug) {
		$my_query = new WP_Query(
			array(
				'post_type' => UNIQMAG_DIFFERENT_THEME_POST_GALLERY, 
				'posts_per_page' => $posts_per_page, 
				'paged'=>$paged
			)
		);  
	} else {
		$my_query = new WP_Query(
			array(
				'post_type' => UNIQMAG_DIFFERENT_THEME_POST_GALLERY, 
				'posts_per_page' => $posts_per_page, 
				'paged'=>$paged,
				'tax_query' => array(
					array(
						'taxonomy' => UNIQMAG_DIFFERENT_THEME_POST_GALLERY.'-cat',
						'field' => 'slug',
						'terms' => $catSlug
					)
				)
			)
		); 

	}
	$categories = get_terms( UNIQMAG_DIFFERENT_THEME_POST_GALLERY.'-cat', 'orderby=name&hide_empty=0' );
	
	//page title
	$titleShow = get_post_meta ( $post->ID, THEME_NAME."_title_show", true );
	$subTitle = get_post_meta ( Different_Themes()->page_id(), THEME_NAME."_subtitle", true ); 
?>
<?php get_template_part(UNIQMAG_DIFFERENT_THEME_LOOP."loop-start"); ?>

<?php get_template_part(UNIQMAG_DIFFERENT_THEME_SINGLE."page-title"); ?>

    <!-- Gallery nav -->
    <nav class="cs-gallery-category-nav">
        <ul>
			<li>
				<a href="<?php echo esc_url(get_page_link(uniqmag_different_themes_get_page("gallery", false)));?>" class="<?php if(!$catSlug) { ?> active<?php } ?>">
					<?php esc_html_e("All",'uniqmag');?>
				</a>
			</li>
			<?php foreach ($categories as $category) { ?>
				<?php if(isset($category->term_id)) { ?>
					<li>
						<a href="<?php echo esc_url(get_term_link((int)$category->term_id,UNIQMAG_DIFFERENT_THEME_POST_GALLERY.'-cat'));?>" class="<?php if($catSlug==$category->slug) { ?> active<?php } ?>">
							<?php echo esc_html($category->name);?>
						</a>
					</li>
				<?php } ?>
			<?php } ?>
        </ul>
    </nav><!-- end .cs-gallery-category-nav -->

    <!-- Gallery grid -->
    <div class="cs-gallery-category-grid">
        <div class="cs-row">
			<?php 
															
				$args = array(
					'post_type'     	=> UNIQMAG_DIFFERENT_THEME_POST_GALLERY,
					'post_status'  	 	=> 'publish',
					'showposts' 		=> -1
				);

				$myposts = get_posts( $args );	
				$count_total = count($myposts);

				$counter=1;	
			?>

			<?php if ( $my_query->have_posts() ) : while ( $my_query->have_posts() ) : $my_query->the_post(); ?>
				<?php 
					$src = uniqmag_different_themes_get_post_thumb($post->ID,720,550); 
				?>
				<?php 
					$term_list = wp_get_post_terms($post->ID, UNIQMAG_DIFFERENT_THEME_POST_GALLERY.'-cat');
					$catCount=0;
					foreach($term_list as $term){
						$catCount++;
					}
					
					$cat_id = rand(0,$catCount-1);
				?>
				<?php $gallery_style = get_post_meta ( $post->ID, "_".THEME_NAME."_gallery_style", true ); ?>
                    <div class="cs-col cs-col-4-of-12">
                        <!-- Gallery item -->
                        <div class="cs-post-item">
                            <div class="cs-post-thumb">
			                    <?php
			                        if( $df_post->compare( get_the_ID(), 'post_category' ) == "1" && $term_list && ( $df_post->get_cat_icon($term_list[$cat_id]->term_id) && $df_post->get_cat_icon($term_list[$cat_id]->term_id) != "no-icon" ) ) { 
			                        $category_color = $df_post->get_color($term_list[$cat_id]->term_id,"category", false);
			                    ?>
			                        <div class="cs-post-category-icon" style="border-right-color: <?php echo esc_attr($category_color);?>">
			                            <a href="<?php echo esc_url(get_term_link($term_list[$cat_id]->term_id));?>" title="<?php echo esc_attr($term_list[$cat_id]->name);?>">
			                                <i class="fa <?php esc_attr($df_post->cat_icon($term_list[$cat_id]->term_id));?>"></i>
			                            </a>
			                        </div>
			                    <?php } ?>

                                <div class="cs-photo-count"><?php echo esc_html(sprintf( _n( '%s photo', '%s photos', uniqmag_different_themes_image_count(get_the_ID()), 'uniqmag' ), uniqmag_different_themes_image_count(get_the_ID()) ));?></div>
                                <a href="<?php the_permalink();?>">
									<img src="<?php echo esc_url($src["src"]); ?>" alt="<?php esc_attr(get_the_title());?>" />
                                </a>
                            </div>
                            <div class="cs-post-inner">
                                <h3>
                                	<a href="<?php the_permalink();?>">
                                		<?php the_title();?>
                                	</a>
                                </h3>
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
	<?php uniqmag_different_themes_customized_nav_btns($paged, $my_query->max_num_pages); ?>
<?php get_template_part(UNIQMAG_DIFFERENT_THEME_LOOP."loop-end"); ?>
<?php get_footer(); ?>