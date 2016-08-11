<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	wp_reset_postdata();
	$post_type = get_post_type();

	//get sidebars settins
	$sidebars = Different_Themes()->sidebars;

?>
					
		<?php 
			if(!is_page_template('template-homepage.php')) {
		?>
			</div>
			<?php
				if( $sidebars->is_sidebar() && $sidebars->position() == "right") {
					get_template_part(UNIQMAG_DIFFERENT_THEME_INCLUDES."sidebar");
				} 
			?>
		</div>

		<?php  
			} 
		?>
         

				