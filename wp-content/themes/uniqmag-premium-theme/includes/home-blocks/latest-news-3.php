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
        <!-- Block layout 2 -->
        <div class="cs-post-block-layout-2">
            <?php if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post(); ?>
                <?php

                    //categories
                    $categories = get_the_category($my_query->post->ID);
                    $catCount = count($categories);
                    //select a random category id
                    $id = rand(0,$catCount-1);


                    //get post ratings information
                    $avarage_rating = Different_Themes()->ratings->avarage_rating($post->ID);

               
                    $item_class = "";
                    if( $df_post->is_image() != true ) {
                        $item_class.= " no-image";
                    }

                ?>
                    <!-- Post item -->
                    <div class="cs-post-item<?php echo esc_attr($item_class);?>">
                        <?php if( $df_post->is_image() ) { ?>
                            <div class="cs-post-thumb">
                                <a href="<?php the_permalink();?>">
                                    <?php $df_post->image_html( get_the_ID(), 450, 275 );?>
                                </a>
                            </div>
                        <?php } ?>
                        <div class="cs-post-inner">
                            <h3>
                                <a href="<?php the_permalink();?>">
                                    <?php the_title();?>
                                </a>
                            </h3>
                            <?php if( $df_post->compare( get_the_ID(), 'post_category' ) == "1" && $categories ) { ?>
                                <div class="cs-post-category-empty cs-clearfix">
                                    <?php 
                                        foreach($categories as $cat) {
                                            $category_color = $df_post->get_color($cat->term_id,"category", false);
                                    ?>
                                        <a href="<?php echo esc_url(get_category_link($cat->term_id));?>" style="color:<?php echo esc_attr($category_color);?>">
                                            <?php echo esc_html(get_cat_name($cat->term_id));?>
                                        </a>
                                    <?php } ?>
                                </div>
                            <?php } ?>
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
            <?php endwhile; endif; ?>
        </div>
    </div>
</div>
