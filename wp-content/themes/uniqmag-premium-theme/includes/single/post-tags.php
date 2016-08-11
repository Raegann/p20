<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	wp_reset_postdata();
    
    //get post settings
    $df_post = Different_Themes()->posts;

	//post tags
	$posttags = get_the_tags();
	$tagCount = count($posttags);

	$categories = get_the_category();
	$catCount = count($categories);


?>


    <?php if( $posttags  && $df_post->compare( get_the_ID(), 'post_tag_single','post_tag' ) == "1" ) { ?>
        <div class="cs-single-post-tags">
            <span><?php esc_html_e('Tags','uniqmag');?></span>
			<?php	
				$i = 1;
				foreach($posttags as $tag) {
					$tag_color = $df_post->get_color($tag->term_id,"post_tag", false);
					if( $tag_color ) {
						$style = ' style="color:'.$tag_color.'"';
					}
					echo '<a href="'.esc_url(get_tag_link($tag->term_id)).'"'.$style.'>'.$tag->name . '</a>';
					//if($tagCount!=$i) { echo ", "; }
					$i++;
				}
			?>
        </div>
    <?php } ?>
