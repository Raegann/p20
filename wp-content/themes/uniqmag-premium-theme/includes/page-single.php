<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	wp_reset_postdata();


?>

	<?php get_template_part(UNIQMAG_DIFFERENT_THEME_LOOP."loop-start"); ?>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <!-- ======== SINGLE ARTICLE ======== -->
            <?php get_template_part(UNIQMAG_DIFFERENT_THEME_SINGLE."page-title"); ?>
            <div <?php post_class('cs-page-content'); ?>>
            	<?php get_template_part(UNIQMAG_DIFFERENT_THEME_SINGLE."image");?>
				<?php wp_reset_postdata();?>		
				<?php the_content();?>	
				<?php 
					$args = array(
						'before'           => '<div class="post-pages"><p>' . esc_html__('Pages:','uniqmag'),
						'after'            => '</p></div>',
						'link_before'      => '',
						'link_after'       => '',
						'next_or_number'   => 'number',
						'nextpagelink'     => esc_html__('Next page','uniqmag'),
						'previouspagelink' => esc_html__('Previous page','uniqmag'),
						'pagelink'         => '%',
						'echo'             => 1
					);

					wp_link_pages($args); 
				?>				
           	</div>			
			<?php endwhile; else: ?>
				<p><?php  esc_html_e('Sorry, no page matched your criteria.','uniqmag'); ?></p>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
			<?php if ( comments_open() ) : ?>
				<?php comments_template(); // Get comments.php template ?>
			<?php endif; ?>
	<?php get_template_part(UNIQMAG_DIFFERENT_THEME_LOOP."loop-end"); ?>