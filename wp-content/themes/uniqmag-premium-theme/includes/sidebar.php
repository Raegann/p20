<?php
	wp_reset_postdata();

    $different_themes = Different_Themes();

    //get post options
    $df_post = $different_themes->posts;

    //get sidebars settins
    $sidebars = $different_themes->sidebars;

	$sidebar = $sidebars->get_sidebar();
	
	if($sidebars->is_sidebar()) {
?>

    <!-- Sidebar -->
	<div class="cs-main-sidebar cs-sticky-sidebar">
    	<?php 
			if ( is_active_sidebar( $sidebar ) ) { 
				dynamic_sidebar( $sidebar );
			} 
		?>
	<!-- END sidebar -->
	</div>
<?php }  ?>
<?php wp_reset_postdata();  ?>