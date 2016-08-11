<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	wp_reset_postdata();
    //get post settings
    $df_post = Different_Themes()->posts;

	// author id
	$user_ID = get_the_author_meta('ID');

	//social
	$twitter = get_user_meta($user_ID, 'twitter', true);
	$facebook = get_user_meta($user_ID, 'facebook', true);
	$google = get_user_meta($user_ID, 'google', true);
	$youtube = get_user_meta($user_ID, 'youtube', true);
	$dribbble = get_user_meta($user_ID, 'dribbble', true);


	$user_post_count = count_user_posts( $user_ID );

?>

<?php if( $df_post->compare( get_the_ID(), 'aboutPostAuthor' ) == "1" ) { ?>

    <!-- Author box -->
    <div class="author_box">
    	<h4 class="cs-heading-subtitle"><?php esc_html_e("About Author", 'uniqmag');?></h4>
		<?php if(get_avatar( get_the_author_meta('user_email',$user_ID), 80)) { ?>
	    	<?php echo get_avatar( get_the_author_meta('user_email',$user_ID), 80, "", esc_attr(get_the_author_meta('display_name',$user_ID)), array('class' => 'avatar'));?>
	    <?php } ?>
        <div class="description">
	        <a class="bio" itemprop="url" href="<?php $user_info = get_userdata($user_ID); echo esc_url(get_author_posts_url($user_ID, $user_info->user_nicename )); ?>">
	        	<?php echo esc_html(get_the_author_meta('display_name',$user_ID)); ?>
	        	<span class="posts"><?php echo esc_html($user_post_count);?> <?php esc_html_e("posts",'different_themes');?></span>
	        </a>
 			<p><span class='vcard author'><span class='fn'><?php echo esc_html(get_the_author_meta('description')); ?></span></span></p>           
	        <ul class="social_icons">
	            <li><?php if($facebook) { ?><a href="<?php echo esc_url($facebook);?>"><i class="fa fa-facebook"></i></a><?php } ?></li>
	            <li><?php if($twitter) { ?><a href="<?php echo esc_url($twitter);?>"><i class="fa fa-twitter"></i></a><?php } ?></li>
	            <li><?php if($dribbble) { ?><a href="<?php echo esc_url($dribbble);?>"><i class="fa fa-dribbble"></i></a><?php } ?></li>
	            <li><?php if($youtube) { ?><a href="<?php echo esc_url($youtube);?>"><i class="fa fa-youtube"></i></a><?php } ?></li>
	            <li><?php if($google) { ?><a href="<?php echo esc_url($google);?>"><i class="fa fa-google-plus"></i></a><?php } ?></li>
	        </ul>
        </div>
    </div>

<?php } ?>
<?php wp_reset_postdata(); ?>


