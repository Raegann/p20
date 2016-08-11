<?php 
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	get_header();
	wp_reset_postdata();

    if (uniqmag_different_themes_is_template_active("template-contact.php")) {
        $contactPages = uniqmag_different_themes_get_page("contact");
        if($contactPages[0]) {
            $contactUrl = get_page_link($contactPages[0]);
        }
    } else {
        $contactUrl = false;
    }
?>

            <!-- Main content and sidebar -->
            <div class="cs-container">
                <!-- Main content -->
                <div class="cs-main-content">
                    <!-- Page 404 -->
                    <div class="cs-404-page">
                        <h3><?php esc_html_e("404",'uniqmag');?></h3>
                        <h4><?php esc_html_e("Something went terribly wrong...",'uniqmag');?></h4>
                        <p>
                            <?php esc_html_e("But don't worry, it can happen to the best of us - and it just happen to you!",'uniqmag');?><br>
                            <?php esc_html_e(" You can search something else or read this text one more time.",'uniqmag');?>
                        </p>

                        <form method="get" action="<?php echo esc_url(home_url('/')); ?>" name="searchform">
                            <input name="s" id="s" type="search" placeholder="<?php esc_html_e("Type and press enter...",'uniqmag');?>">
                        </form>
                        <a href="<?php echo esc_url(home_url('/'));?>" class="cs-404-page-back-link">
                            <?php esc_html_e("Back to home page",'uniqmag');?>
                        </a>
                    </div>
                </div>
            </div>

<?php get_footer(); ?>