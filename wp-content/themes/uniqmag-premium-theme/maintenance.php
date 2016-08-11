<?php 
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	wp_reset_postdata();

    //logo settings
    $logo = Different_Themes()->options->get(THEME_NAME.'_logo');  
    $maintenance_mode_date = Different_Themes()->options->get(THEME_NAME.'_maintenance_mode_date');  
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->

<!-- BEGIN html -->
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<!--<![endif]-->
    <!-- BEGIN head -->
    <head>


        <!-- Meta Tags -->
        <meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <?php wp_head(); ?> 

    <!-- END head -->
    </head>
    
    <!-- BEGIN body -->
    <body <?php body_class();?> style="background-color:#fff;">


        <!-- Wrapper -->
        <div id="cs-wrapper" class="wide">

            <!-- Main content and sidebar -->
            <div class="cs-container">
                <!-- Main content -->
                <div class="cs-main-content">
                    <!-- Page content -->
                    <div class="cs-page-content">
                        <!-- Underc construction -->
                        <div class="cs-under-construction">
                            <!-- Logo brand image -->
                            <div id="cs-logo-brand">
                                <?php if($logo) { ?>
                                    <a href="<?php echo esc_url(home_url('/')); ?>">
                                        <img src="<?php echo esc_url($logo);?>" alt="<?php bloginfo('name'); ?>" />
                                    </a>
                                <?php } else { ?>
                                    <h1>
                                        <a href="<?php echo esc_url(home_url('/')); ?>">
                                            <?php echo esc_html(get_bloginfo('name'));?>
                                        </a>
                                    </h1>
                                <?php } ?>
                            </div>
                            <h2><?php esc_html_e("Our website is temporarily under construction.", 'uniqmag');?></h2>
                            <h4><?php esc_html_e("See you in a short time!", 'uniqmag');?></h4>
                            <div class="cs-countdown"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php if( $maintenance_mode_date ) { ?>
            <!-- End Wrapper -->
            <script type="text/javascript">
                // Countdown
                jQuery(".cs-countdown").countdown("<?php echo esc_attr($maintenance_mode_date);?>", function(event) {
                    jQuery(this).html(event.strftime(''
                        + '<div class="cs-countdown-block">'
                            + '<div class="cs-countdown-number">%-m</div>'
                            + '<div class="cs-countdown-label">month%!m</div>'
                        + '</div>'
                        + '<div class="cs-countdown-block">'
                            + '<div class="cs-countdown-number">%-w</div>'
                            + '<div class="cs-countdown-label">week%!w</div>'
                        + '</div>'
                        + '<div class="cs-countdown-block">'
                            + '<div class="cs-countdown-number">%-d</div>'
                            + '<div class="cs-countdown-label">day%!d</div>'
                        + '</div>'
                        + '<div class="cs-countdown-block">'
                            + '<div class="cs-countdown-number">%H</div>'
                            + '<div class="cs-countdown-label">hour%!H</div>'
                        + '</div>'
                        + '<div class="cs-countdown-block">'
                            + '<div class="cs-countdown-number">%M</div>'
                            + '<div class="cs-countdown-label">minute%!M</div>'
                        + '</div>'
                        + '<div class="cs-countdown-block">'
                            + '<div class="cs-countdown-number">%S</div>'
                            + '<div class="cs-countdown-label">seconds</div>'
                        + '</div>'));
                });
            </script>
        <?php } ?>
    <?php wp_footer(); ?>
    <!-- END body -->
    </body>
<!-- END html -->
</html>
<?php exit(); ?>