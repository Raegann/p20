<?php 
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    $DF_builder = new different_themes_home_builder; 
    //get block data
    $data = $DF_builder->get_data(); 
    //set query
    $my_query = $data[0]; 
    //extract array data
    extract($data[1]); 
    $counter = 1;

?>

<div class="cs-row">
    <?php if($title) { ?>
        <div class="cs-col cs-col-12-of-12">
            <!-- Post block title -->
            <div class="cs-post-block-title" style="border-left-color: #<?php echo esc_attr($color);?>;">
                <h4>
                    <?php if($link) { ?>
                        <a href="<?php echo esc_url($link);?>">
                    <?php } ?>
                        <?php echo esc_html($title);?>
                    <?php if($link) { ?>
                        </a>
                    <?php } ?>
                </h4>
                <?php if($subtitle) { ?>
                    <p><?php echo esc_html($subtitle);?></p>
                <?php } ?>
            </div>
        </div>
    <?php } ?>


    <div class="cs-col cs-col-12-of-12">

        <?php if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post(); ?>
            <?php
                //categories
                $categories = get_the_category($my_query->post->ID);
                $catCount = count($categories);
                //select a random category id
                $cat_id = rand(0,$catCount-1);

                //get post ratings information
                $avarage_rating = Different_Themes()->ratings->avarage_rating( get_the_ID() );

            ?>
            <!-- Block layout 7 -->
            <div class="cs-post-block-layout-7">
                <div class="cs-post-item">
                    <div class="cs-post-thumb">
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
                        <div class="cs-post-border"></div>

                        <?php $df_post->image_html( get_the_ID(), 687, 350, null, null, true );?>

                    </div>
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

        <?php endwhile; endif; ?>
    </div>
</div>
