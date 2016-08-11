<?php
/*
Template Name: Drag & Drop Page Builder
*/	
?>
<?php get_header(); ?>
<?php

	wp_reset_postdata();
	
	//pagebuilder saved layout 
	$pagebuilder_layout = get_post_meta( get_the_id(), "_".THEME_NAME."_pagebuilder_layout", true );
	
?>
<?php get_template_part(UNIQMAG_DIFFERENT_THEME_LOOP."loop-start"); ?>

	<?php 
		if(get_the_content()) {
			the_content();
		} 
		if(!$pagebuilder_layout && get_post_meta ( Different_Themes()->page_id(), "_".THEME_NAME."_sliderStyle", true ) == "1") {
	?>
		<div class="row">
			<div class="col col_12_of_12">
				<?php get_template_part(UNIQMAG_DIFFERENT_THEME_SLIDERS."main-slider");?>
			</div>
		</div>		
	<?php
		}
		$DF_builder = new different_themes_home_builder;  

		if($pagebuilder_layout) {
			//foreach columns
			foreach ($pagebuilder_layout->columnRows as $columRows) {
				$DF_builder->columRows($columRows);
				//reset the layout hierarchy
				$DF_builder->layout(false); 
			}
		}

	?> 
	&nbsp;
<?php get_template_part(UNIQMAG_DIFFERENT_THEME_LOOP."loop-end"); ?>
<?php get_footer();?>