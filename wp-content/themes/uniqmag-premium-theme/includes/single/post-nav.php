<?php
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    wp_reset_postdata();
    
    //get post settings
    $df_post = Different_Themes()->posts;
    //previous/next post data
    $next_post = get_next_post();
    $prev_post = get_previous_post();
?>        
<?php if( $df_post->compare( get_the_ID(), 'postControls' ) == "1" ) { ?>
    <!-- ======== CONTROLS ======== -->
    <div class="cs-single-post-controls">
        <?php if(isset($prev_post->post_title)) { ?>
            <div class="cs-prev-post">
                <span><i class="fa fa-angle-double-left"></i> <?php esc_html_e("Prev",'uniqmag');?></span>
                <a href="<?php echo esc_url(get_permalink( $prev_post->ID )); ?>"><?php echo esc_html($prev_post->post_title); ?></a>
            </div>
        <?php } ?>
        <?php if(isset($next_post->post_title)) { ?>
            <div class="cs-next-post">
                <span><?php esc_html_e("Next",'uniqmag');?> <i class="fa fa-angle-double-right"></i></span>
                <a href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>"><?php echo esc_html($next_post->post_title); ?></a>
            </div>
        <?php } ?>
    </div>
<?php } ?>