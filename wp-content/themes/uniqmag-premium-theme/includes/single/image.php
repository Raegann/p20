<?php 
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	wp_reset_postdata();

	//get post settings
    $df_post = Different_Themes()->posts;

	$width = 1024;
	$height = 500;
	

	$votes = get_post_meta( $post->ID, "_".THEME_NAME."_total_votes", true );
	$video = get_post_meta( $post->ID, "_".THEME_NAME."_video_code", true );
	$slider = get_post_meta( $post->ID, THEME_NAME."_gallery_images", true );
	$audio = get_post_meta( $post->ID, "_".THEME_NAME."_audio", true );
	$credits_title = get_post_meta( $post->ID, "_".THEME_NAME."_credits_title", true );
	$credits_url = get_post_meta( $post->ID, "_".THEME_NAME."_credits_url", true );

	//image show/hide
	$show_single_thumb = $df_post->compare( get_the_ID(), 'show_single_thumb' );


	if( $show_single_thumb == "1" && ( $df_post->get_image_html( get_the_ID(), $width, $height ) || $video ) && !(function_exists('is_cart') && is_cart()) && !(function_exists('is_checkout') && is_checkout()) && !(function_exists("is_bbpress") && is_bbpress()) && !is_attachment() && get_post_format() != "gallery" && get_post_format() != "audio") { 

		//check if we want to show the image
		if ( $show_single_thumb == '1' && $df_post->get_image_html( get_the_ID(), $width, $height ) && !has_post_format() ) {
			
?>
	    <div class="cs-single-post-media">
	    	<?php if($credits_title) { ?>
	       		<div class="cs-media-credits">
	       			<?php esc_html_e("Photography",'uniqmag');?> 
	       			<?php if($credits_url) { ?>
	       				<a href="<?php echo esc_url($credits_url);?>">
	       			<?php } ?>
	       				<?php echo esc_html($credits_title);?>
	       			<?php if($credits_url) { ?>
	       				</a>
	       			<?php } ?>
	       		</div>
	       	<?php } ?>
	        <?php if( $df_post->compare( get_the_ID(), 'imagePopUp' ) == "1") { ?> 
	        	<a href="<?php echo esc_url($df_post->get_image_src( get_the_ID(), 0, 0 ));?>" class="cs-lightbox-image" title="<?php echo esc_attr(get_the_title());?>">
	        <?php } ?>
	        	<?php $df_post->image_html( get_the_ID(), $width, $height ); ?>
	        <?php if( $df_post->compare( get_the_ID(), 'imagePopUp' ) == "1") { ?> 
				</a>
	        <?php } ?>
	    </div>
	 
	    <!-- End Media -->
	<?php } else if($show_single_thumb == '1' && get_post_format() == "video" && $video) { ?>
		<div class="cs-single-post-media">
			<?php echo balanceTags( $video ); ?>
		</div>
	<?php } ?>
<?php } else if($show_single_thumb == '1' && get_post_format() == "audio" && $audio) { ?>
	<div class="cs-single-post-media">
		<?php echo balanceTags( $audio ); ?>
	</div>
<?php } else if($show_single_thumb == '1' && get_post_format() == "gallery" && $slider) { ?>
	<div class="cs-single-post-media">
        <div class="cs-post-slider-layout swiper-container">
            <div class="swiper-wrapper">
            	<?php
            		$imageIDs = explode(",",$slider);
            		foreach($imageIDs as $sliderImage) {
            			if($sliderImage) {
            				$file = wp_get_attachment_url($sliderImage);
            				$image = uniqmag_different_themes_get_post_thumb(false, $width, $height, false, $file);
            				$imageL = uniqmag_different_themes_get_post_thumb(false, 0, 0, false, $file);

            	?>
	                <!-- Post item -->
	                <div class="swiper-slide">
	                    <div class="cs-post-item">
	                        <div class="cs-post-thumb">

						        <?php if( $df_post->compare( get_the_ID(), 'imagePopUp' ) == "1") { ?>
						        	<a href="<?php echo esc_url($imageL['src']);?>"  class="cs-lightbox-image" title="<?php the_title_attribute(); ?>">
						        <?php } ?>	
	                            	<img src="<?php echo esc_url($image['src']);?>" alt="<?php the_title_attribute(); ?>">
						        <?php if( $df_post->compare( get_the_ID(), 'imagePopUp' ) == "1") { ?>
						        	</a>
						        <?php } ?>	

	                        </div>
	                    </div>
	                </div>

            	<?php
            			}
            		}


            	?>

            </div>
            <!-- Post slider controls -->
            <div class="cs-post-slider-controls">
                <div class="cpsl-swiper-button-prev"><i class="fa fa-angle-left"></i></div>
                <div class="cpsl-swiper-button-next"><i class="fa fa-angle-right"></i></div>
            </div>
        </div>
	</div>
<?php } ?>