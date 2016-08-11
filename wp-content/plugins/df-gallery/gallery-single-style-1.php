<?php 
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	get_header();
	wp_reset_query();

	global $query_string;
	$query_vars = explode('&',$query_string);
									
	foreach($query_vars as $key) {
		if(strpos($key,'page=') !== false) {
			$i = substr($key,8,12);
			break;
		}
	}
	
	if(!isset($i)) {
		$i = 1;
	}

	$galleryImages = get_post_meta ( $post->ID, PLUGIN_NAME."_gallery_images", true ); 
	$imageIDs = explode(",",$galleryImages);
	$count = DF_plugin_image_count($post->ID);

	//main image
	$image = wp_get_attachment_image_src($imageIDs[$i-1],array(1230,691));

	$term_list = wp_get_post_terms($post->ID, UNIQMAG_DIFFERENT_THEME_POST_GALLERY.'-cat');

	$catCount=0;
	foreach($term_list as $term){
		$catCount++;
	}
	
	$randID = rand(0,$catCount-1);	

	$galID = df_plugin_get_page("gallery-1");
	$title = get_the_title($galID[0]);

?>
	<!-- BEGIN .wrapper -->
	<div class="wrapper" id="primary">
		<!-- BEGIN .main-block -->
		<div class="main-block df-galleries-content" id="content">
			<div class="main-title">
				<a href="<?php echo esc_url(get_permalink($galID[0]));?>" class="right"><?php esc_html_e("back to galleries", PLUGIN_NAME); ?></a>
				<h3><?php esc_html_e($title); ?></h3>
			</div>
			<?php if (have_posts()): ?>
				<div class="main-content photo-gallery-large df-slide-item gallery-full-photo" id="<?php echo esc_attr__($post->ID);?>">

					<div class="photo-gallery-full">
						<a href="#" class="photo-gallery-full-nav-left prev" rel="<?php if($i>1) { echo intval($i-1); } else { echo intval($i-1); } ?>"><<</a>
						<a href="#" class="photo-gallery-full-nav-right next" rel="<?php if($i<$count) { echo intval($i+1); } else { echo intval($i); } ?>">>></a>
						<div class="photo-gallery-inner the-image loading waiter">
							<img class="image-big-gallery df-gallery-image" data-id="<?php echo intval($i);?>" style="display:none;" src="<?php echo esc_url($image[0]);?>" alt="<?php echo esc_attr__(the_title());?>" />
						</div>
					</div>

					<div class="photo-gallery-thumbs">
						<button class="photo-gallery-nav nav-me-left"><<</button>
						<button class="photo-gallery-nav nav-me-right">>></button>
						<div class="photo-gallery-thumb-list the-thumbs">
		            		<?php 
			            		$c=1;
			            		foreach($imageIDs as $id) { 
			            			if($id) {
			            				$image = wp_get_attachment_image($id,array(90,90));
			            	?>
								<a href="javascript:;" class="item gal-thumbs <?php if($c==$i) { ?>active<?php } ?>" rel="<?php echo intval($c);?>" data-nr="<?php echo intval($c);?>">
									<?php echo $image;?>
								</a>
				                <?php $c++; ?>
			               	 	<?php } ?>
			                <?php } ?>
						</div>
					</div>

					<div class="photo-gallery-description shortcode-content">
						<h2><?php the_title();?></h2>
						<?php 
							if (get_the_content() != "") { 	
								the_content();
							} 
						?>	
					</div>

				</div>
				
		<!-- END .main-block -->
		</div>
		<?php endif;?>

	<!-- END .wrapper -->
	</div>
<?php get_footer(); ?>