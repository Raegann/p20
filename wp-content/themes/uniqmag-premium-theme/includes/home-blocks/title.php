<?php 
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    $DF_builder = new different_themes_home_builder; 
    //get block data
    $data = $DF_builder->get_data(); 

    //extract array data
    extract($data[0]); 
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
</div>