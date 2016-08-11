<?php 
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	wp_reset_postdata();
	//post title
	$titleShow = get_post_meta ( $post->ID, "_".THEME_NAME."_show_single_title", true ); 

?>					


<?php if($titleShow!="hide"){ ?>
		<h1 class="entry_title entry-title"><?php echo the_title(); ?></h1>
<?php } ?> 