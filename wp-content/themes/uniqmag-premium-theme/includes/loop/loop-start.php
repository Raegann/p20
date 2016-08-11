<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	wp_reset_postdata();
    $post_type = get_post_type();

    $different_themes = Different_Themes();

    //get post options
    $df_post = $different_themes->posts;

    //load breadcrumbs
    $different_themes->breadcrumbs->html_out();
    $breadcrumbs = Different_Themes()->options->get(THEME_NAME."_breadcrumb");

    //get sidebars settins
    $sidebars = $different_themes->sidebars;

?>
    <?php 
        if(!is_page_template('template-homepage.php')) {
    ?>   
    <!-- Main content and sidebar -->
    <div class="cs-container">

        <?php
            if( $sidebars->is_sidebar() && $sidebars->position() == "left") {
                get_template_part(UNIQMAG_DIFFERENT_THEME_INCLUDES."sidebar");
            } 
        ?>

        <!-- Main content -->
        <div class="cs-main-content<?php if($sidebars->is_sidebar()) { echo " cs-sidebar-on-the-".$sidebars->position(); } ?>">
            <?php if( !is_page_template('template-homepage.php') && !is_front_page() && $breadcrumbs == "on" ) { ?>
                <?php echo balanceTags($different_themes->breadcrumbs->breadcrumbs,true);?>
            <?php } ?>


    <?php } ?>
	<?php wp_reset_postdata();  ?>