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
        <!-- Post slider -->
        <div class="cs-post-slider-layout swiper-container">
            <div class="swiper-wrapper">
                <?php if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post(); ?>
                    <?php 
                        $DF_builder->set_double($my_query->post->ID);

                        //categories
                        $categories = get_the_category($my_query->post->ID);
                        $catCount = count($categories);
                        //select a random category id
                        $cat_id = rand(0,$catCount-1);

                        //get post ratings information
                        $avarage_rating = Different_Themes()->ratings->avarage_rating( get_the_ID() );

                    ?>
                    <!-- Post item -->
                    <div class="swiper-slide">
                        <div class="cs-post-item">
                            <div class="cs-post-thumb">
                                <a href="<?php the_permalink();?>">
                                    <?php $df_post->image_html( get_the_ID(), 1024, 500, null, THEME_NAME.'_homepage_image', true );?>
                                </a>
                            </div>
                            <div class="cs-post-inner">
                                <?php if( $df_post->compare( get_the_ID(), 'post_category' ) == "1" && $categories ) { ?>
                                    <div class="cs-post-category-border cs-clearfix">
                                        <?php 
                                            foreach($categories as $cat) {
                                                $category_color = $df_post->get_color($cat->term_id,"category", false);
                                        ?>
                                            <a href="<?php echo esc_url(get_category_link($cat->term_id));?>" style="border-color:<?php echo esc_attr($category_color);?>">
                                                <?php echo esc_html(get_cat_name($cat->term_id));?>
                                            </a>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
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
                                </div>
                            </div>
                        </div>
                    </div>

                <?php $counter++; ?>
                <?php endwhile; ?>
                <?php else: ?>
                        <p><?php esc_html_e("Please be sure that you have selected main slider posts, you can do it by adding/editing a post that you want to see in the slider.",'uniqmag'); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <!-- Post slider controls -->
        <div class="cs-post-slider-controls">
            <div class="cpsl-swiper-button-prev"><i class="fa fa-angle-left"></i></div>
            <div class="cpsl-swiper-button-next"><i class="fa fa-angle-right"></i></div>
        </div>
    </div>

</div>
