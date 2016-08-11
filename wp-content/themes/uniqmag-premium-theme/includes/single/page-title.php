<?php 
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	wp_reset_postdata();
	//get post options
	$df_post = Different_Themes()->posts;

	$post_type = get_post_type();

?>					

<?php if ( isset($post->ID) && $df_post->compare( $post->ID, 'show_single_title' ) == '1' ) { ?>
    <!-- Page title -->
    <h1 class="cs-page-title"><?php uniqmag_different_themes_page_title(); ?></h1>
<?php } ?>