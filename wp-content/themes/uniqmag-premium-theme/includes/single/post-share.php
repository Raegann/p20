<?php
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    //get post settings
    $df_post = Different_Themes()->posts;

    //social share icons
    $image = uniqmag_different_themes_get_post_thumb($post->ID,0,0); 
    $title = htmlspecialchars($post->post_title);
    $subject = htmlspecialchars(get_bloginfo('name')).' : '.$title;
    $body = esc_html__("Check out this article: ",'uniqmag').$title.' - '.esc_url(get_permalink($post->ID));
?>
<?php if( $df_post->compare( get_the_ID(), 'share_buttons' ) == "1" ) { ?>
    <div class="cs-single-post-share">
        <div>
       
            <a href="//www.facebook.com/sharer/sharer.php?u=<?php echo esc_url(get_permalink());?>" data-url="<?php echo esc_url(get_permalink());?>" class="facebook df-share"><i class="fa fa-facebook"></i></a>
            <a data-hashtags="" data-url="<?php echo esc_url(get_permalink());?>" data-via="<?php echo esc_attr(Different_Themes()->options->get(THEME_NAME.'_twitter_name'));?>" data-text="<?php echo esc_attr(get_the_title());?>" href="#" class="twitter df-tweet"><i class="fa fa-twitter"></i></a>
            <a href="//plus.google.com/share?url=<?php echo esc_url(get_permalink());?>" class="google df-pluss"><i class="fa fa-google-plus"></i></a>
            <a href="//pinterest.com/pin/create/button/?url=<?php echo esc_url(get_permalink());?>&media=<?php echo esc_url($image['src']); ?>&description=<?php echo esc_attr(get_the_title()); ?>" data-url="<?php echo esc_url(get_permalink());?>" class="pinterest df-pin"><i class="fa fa-pinterest"></i></a>
            <a href="mailto:?subject=<?php echo rawurlencode($subject);?>&body=<?php echo rawurlencode($body);?>" target="_blank"><i class="fa fa-envelope"></i></a>
        </div>
    </div>
<?php } ?>