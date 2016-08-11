<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/* Template Name: Photo Gallery */
?>
<?php get_header(); ?>
<?php
	wp_reset_query();
	$paged = df_plugin_get_query_string_paged();
	$posts_per_page = get_option('posts_per_page');
	
	
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

?>

	<!-- BEGIN .wrapper -->
	<div class="wrapper" id="primary">
			<?php wp_reset_query();  ?>
			<!-- BEGIN .main-block -->
			<div class="main-block df-galleries-content" id="content">
				<div class="main-title">
					<a href="<?php echo esc_url(home_url());?>" class="right"><?php esc_html_e("back to homepage", PLUGIN_NAME);?></a>
					<h3><?php the_title(); ?></h3>
				</div>

				<div class="main-content photo-gallery-items lets-do-3">
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
							$height = 200;
							$width = 285;
							$src = get_the_post_thumbnail($post->ID, array($width,$height)); 
		 
							$term_list = wp_get_post_terms($post->ID, UNIQMAG_DIFFERENT_THEME_POST_GALLERY.'-cat');
							$catCount=0;
							foreach($term_list as $term){
								$catCount++;
							}
							
							$randID = rand(0,$catCount-1);
						?>

							<!-- BEGIN .item -->
							<div class="item<?php if(!$src) { ?> no-image<?php } ?>" data-id="gallery-<?php the_ID(); ?>">
								<div class="item-header">
									<a href="<?php the_permalink();?>" data-id="gallery-<?php the_ID(); ?>">
										<span class="item-header-overlay">
											<i class="fa fa-photo"></i>
											<span>+<?php echo DF_plugin_image_count($post->ID);?> 								
												<?php 
													if(DF_plugin_image_count()==1) {
														esc_html_e("photo", PLUGIN_NAME);
													} else {
														esc_html_e("photos", PLUGIN_NAME);
													}
												?>
											</span>
										</span>
										<?php echo $src; ?>
									</a>
								</div>
								<div class="item-content">
									<h3><a href="<?php the_permalink();?>" data-id="gallery-<?php the_ID(); ?>"><?php the_title();?></a></h3>
									<?php if(isset($term_list[$randID]->term_id)) { ?>
										<div class="item-category">
											<a href="<?php echo esc_url(get_term_link((int)$term_list[$randID]->term_id, UNIQMAG_DIFFERENT_THEME_POST_GALLERY.'-cat'));?>" ><?php echo esc_html($term_list[$randID]->name);?></a>
										</div>
									<?php } ?>
									<?php the_excerpt(); ?>
									<a href="<?php the_permalink();?>" class="button view-more" data-id="gallery-<?php the_ID(); ?>"><?php esc_html_e("View all photos", PLUGIN_NAME);?></a>
								</div>
							<!-- END .item -->
							</div>

					<?php $counter++; ?>
					<?php endwhile; ?>
					<?php else : ?>
						<h2 class="title"><?php esc_html_e( 'No galleries were found' , PLUGIN_NAME );?></h2>
					<?php endif; ?>

				</div>
				<div class="df-pagination">
					<?php 
						$args = array(
							'base' 			=> str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
							'format'       	=> '?page=%#%',
							'total'       	=> $my_query->max_num_pages,
							'current'      	=> max( 1, $paged ),
							'show_all'     	=> false,
							'end_size'    	=> 1,
							'mid_size'     	=> 2,
							'prev_next'    	=> true,
							'prev_text'    	=> esc_html__("Previous Page", PLUGIN_NAME),
							'next_text'    	=> esc_html__("Next Page", PLUGIN_NAME),
							'type'         	=> 'plain',
							'add_args'     	=> false,
							'add_fragment' 	=> ''
						);
						echo paginate_links($args); 
					?>
				</div>
			<!-- END .main-block -->
			</div>

	<!-- END .wrapper -->
	</div>
<?php get_footer(); ?>