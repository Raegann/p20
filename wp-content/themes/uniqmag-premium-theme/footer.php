<?php
	//copyright
	$copyRight = Different_Themes()->options->get(THEME_NAME."_copyright");
	
?>


			<?php			
				if ( function_exists( 'register_nav_menus' )) {

					$args = array(
						//'container' => 'div',
						//'container_class' => 'footer-menu',
						'theme_location' => 'footer-menu',
						'menu_class'      => 'cs-footer-navigation cs-clearfix',
						'items_wrap' => '<ul class="%2$s" rel="'.esc_html__("Footer Menu",'uniqmag').'">%3$s</ul>',
						'depth' => 1,
						"echo" => false,

					);
								
					if(has_nav_menu('footer-menu')) {	
					?>
			 		<!-- Footer menu -->
		            <div id="cs-footer-menu">
		                <div class="cs-container">
		                    <!-- Footer navigation -->
		                    <div class="cs-toggle-footer-navigation"><i class="fa fa-bars"></i></div>
		                    <nav id="cs-footer-navigation" class="cs-clearfix">
								<?php echo wp_nav_menu($args); ?>
		                    </nav>
		                </div>
		            </div>
					<?php
					} 

				}
			?>

            
            <!-- Footer -->
            <div id="cs-footer">
                <div class="cs-container">
                    <div class="cs-row">
                        <div class="cs-col cs-col-4-of-12">
							<?php 
								if ( is_active_sidebar( 'df_footer_1' ) ) { 
									dynamic_sidebar( 'df_footer_1' );
								} 
							?>
                        </div>
                        <div class="cs-col cs-col-4-of-12">
                        	<?php 
								if ( is_active_sidebar( 'df_footer_2' ) ) { 
									dynamic_sidebar( 'df_footer_2' );
								} 
							?>
                        </div>
                        <div class="cs-col cs-col-4-of-12">
							<?php 
								if ( is_active_sidebar( 'df_footer_3' ) ) { 
									dynamic_sidebar( 'df_footer_3' );
								} 
							?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Copyirght -->
            <div id="cs-copyright">
                <div class="cs-container"><?php echo uniqmag_different_themes_html_output($copyRight);?></div>
            </div>

        </div>




	<?php wp_footer(); ?>
	<!-- END body -->
	</body>
<!-- END html -->
</html>