<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


	$page_layout = Different_Themes()->options->get(THEME_NAME."_page_layout");

	//logo settings
	$logo = Different_Themes()->options->get(THEME_NAME.'_logo');	
	// search
	$search = Different_Themes()->options->get(THEME_NAME.'_search');	
	//woocommerce cart
	$cart = Different_Themes()->options->get(THEME_NAME.'_cart');	


	//header style
	$header_style = Different_Themes()->options->get(THEME_NAME."_header_style");
	if(!$header_style) $header_style = 1;
	//top banner	
	$topBanner = Different_Themes()->options->get(THEME_NAME."_top_banner");
	$topBannerCode = Different_Themes()->options->get(THEME_NAME."_top_banner_code");

	//fixed menu
	$stickyMenu = Different_Themes()->options->get(THEME_NAME."_stickyMenu");
	if($stickyMenu=="on") {
		$sticky = " cs-header-menu-is-sticky";
	} else {
		$sticky = false;
	}




	//social icons
	$facebook = Different_Themes()->options->get(THEME_NAME."_facebook");
	$twitter = Different_Themes()->options->get(THEME_NAME."_twitter");
	$linkedin = Different_Themes()->options->get(THEME_NAME."_linkedin");
	$instagram = Different_Themes()->options->get(THEME_NAME."_instagram");
	$youtube = Different_Themes()->options->get(THEME_NAME."_youtube");
	$google = Different_Themes()->options->get(THEME_NAME."_google");
?>

    <!-- Wrapper -->
    <div id="cs-wrapper" class="<?php echo esc_attr($page_layout=="boxed" ? " boxed" : 'wide'); ?>">

            <!-- Header -->
            <?php if( $header_style == "1" ) { ?>
            <div id="cs-header-style-one">
            <?php } else if( $header_style == "2" || $header_style == "3" ){ ?>
			<div id="cs-header-style-two" <?php if( $header_style == "3" ) { echo ' class="drop-shadow"'; } ?>>
            <?php } else { ?> 
            <div id="cs-header-style-three">
            <?php } ?>
                <?php
					if ( function_exists( 'register_nav_menus' )) {
						$walker = new different_themes_walker_top;
						$args = array(
							'container' => 'nav',
							'container_class' => 'cs-clearfix',
							'container_id' => 'cs-top-navigation',
							'theme_location' => 'top-menu',
							'menu_class'      => 'cs-top-navigation cs-clearfix',
							'items_wrap' => '<ul class="%2$s" rel="'.esc_html__("Top Menu",'uniqmag').'">%3$s</ul>',
							'depth' => 3,
							'walker' => $walker,
							"echo" => false
						);

						if(has_nav_menu('top-menu')) {
				?>
	                <!-- Header meta -->
	                <div id="cs-header-meta">
	                    <div class="cs-container">
	                        <!-- Top navigation -->
	                        <div class="cs-toggle-top-navigation"><i class="fa fa-bars"></i></div>
	                   		<?php echo wp_nav_menu($args); ?>
	                    </div>
	                </div>
				<?php
						}		

					}
				?>
				<?php get_template_part(UNIQMAG_DIFFERENT_THEME_SLIDERS."breaking-news");?>
				<?php if( $header_style == "1" || $header_style == "2" ) { ?>
	                <!-- Header main -->
	                <div id="cs-header-main">
	                    <div class="cs-container">
	                        <div class="cs-header-body-table">
	                            <div class="cs-header-body-row">
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
	                                <?php if( $topBanner == "on" ) { ?>
		                   				<div class="cs-header-banner">
		                   					<?php echo stripslashes(balanceTags($topBannerCode));?>
		                   				</div>
		                   			<?php } ?> 

	                            </div>
	                        </div>
	                    </div>
	                </div>
                <?php } ?>

                <!-- Header menu -->
                <div id="cs-header-menu" class="<?php echo esc_html($sticky);?>">
                    <div class="cs-container">

                    	<?php if( $header_style == "4" ) { ?>
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
                        <?php } ?>

                        <!-- Main navigation -->
                        <div class="cs-toggle-main-navigation"><i class="fa fa-bars"></i></div>

                	<?php
						if ( function_exists( 'register_nav_menus' )) {
							$walker = new different_themes_walker;
							$args = array(
								'container' => 'nav',
								'container_class' => 'cs-clearfix',
								'container_id' => 'cs-main-navigation',
								'theme_location' => 'main-menu',
								'menu_class'      => 'cs-main-navigation cs-clearfix',
								'menu_id'      => '',
								'items_wrap' => '<ul id="%1$s" class="%2$s" rel="'.esc_html__("Main Menu",'uniqmag').'">%3$s</ul>',
								'depth' => 3,
								"echo" => false,
								'walker' => $walker
							);
										
										
							if(has_nav_menu('main-menu')) {
								echo wp_nav_menu($args);		
							} else {
								echo "<nav id=\"cs-main-navigation\" class=\"cs-clearfix\"><ul id=\"cs-main-navigation\" class=\"cs-clearfixx\"><li class=\"navi-none\"><a href=\"".esc_url(admin_url("nav-menus.php")) ."\">Please set up ".THEME_FULL_NAME." menu!</a></li></ul></nav>";
							}		

						}

                	?>
                    <?php if($search=="on") { ?>
                        <!-- Search icon show -->
                        <div id="cs-header-menu-search-button-show"><i class="fa fa-search"></i></div>
                        <!-- Search icon -->
                        <div id="cs-header-menu-search-form">
                            <div id="cs-header-menu-search-button-hide"><i class="fa fa-close"></i></div>
                           	<form method="get" action="<?php echo esc_url(home_url('/')); ?>" name="searchform">
                                <input type="text" placeholder="<?php esc_attr_e('Type and press enter...','uniqmag');?>" name="s" id="s">
                            </form>
                        </div>
                    <?php } ?>



                    </div>
                </div>

				<?php if( $header_style == "3" ) { ?>
	                <!-- Header main -->
	                <div id="cs-header-main">
	                    <div class="cs-container">
	                        <div class="cs-header-body-table">
	                            <div class="cs-header-body-row">
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
	                                <?php if( $topBanner == "on" ) { ?>
		                   				<div class="cs-header-banner">
		                   					<?php echo stripslashes(balanceTags($topBannerCode));?>
		                   				</div>
		                   			<?php } ?> 

	                            </div>
	                        </div>
	                    </div>
	                </div>
                <?php } ?>


            </div>


<?php wp_reset_postdata(); ?>
