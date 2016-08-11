<?php
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php printf ( esc_html__('This post is password protected. Enter the password to view comments.','uniqmag'));?></p>
	<?php
		return;
	}

	
	add_action('comment_form_top', 'uniqmag_different_themes_fields_rules' );
	$differentThemesCommentID=1;
?>
<?php //You can start editing here. ?>

    <!-- Comments -->
    <div class="cs-comments-area">
		<h4 class="cs-heading-subtitle"><?php comments_number(esc_html__('0 Comments','uniqmag'), esc_html__('1 Comment','uniqmag'), esc_html__('% Comments','uniqmag')); ?></h4>
		<?php if ( have_comments() && comments_open()) : ?>
			<ol class="cs-comment-list" id="comments">
				<?php wp_list_comments('type=comment&callback=uniqmag_different_themes_comment'); ?>
			</ol>
			<div class="comments-pager"><?php paginate_comments_links(); ?></div>
		<?php else : // this is displayed if there are no comments so far ?>
			<?php if ( comments_open() ) : ?>
				<!-- No comments -->
				<div class="no_comments">
				    <i class="fa fa-comments-o"></i>
		            <h4><?php esc_html_e('No Comments Yet!','uniqmag');?></h4>
		            <p><?php esc_html_e('You can be first to','uniqmag');?> <a href="#respond"><?php esc_html_e('comment this post!','uniqmag');?></p>
			    </div>
			<?php endif; ?>
		<?php endif; ?>
	</div>


	<?php if ( comments_open() ) : ?>
		<!-- Respond -->
        <div id="respond" class="comment-respond">
        	<h4 class="cs-heading-subtitle"><?php esc_html_e('Leave a Comment','uniqmag');?></h4>
			<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
			<p class="registered-user-restriction"><?php printf ( esc_html__('Only %1$s registered %2$s users can comment.','uniqmag'), '<a href="'.esc_url(wp_login_url( get_permalink() )).'">', '</a>');?> </p>
			<?php else : ?>
				<div id="writecomment" class="writecomment">
					<a href="#" name="respond"></a>
					<?php 
						$defaults = array(
							'comment_field'       	=> '<p><label for="comment">'.esc_html__("Comment",'uniqmag').' <span>*</span></label><textarea name="comment" id="comment" placeholder="'.esc_html__("Your comment..",'uniqmag').'"></textarea></p>',
							'comment_notes_before' 	=> '',
							'comment_notes_after'  	=> '',
							'id_form'              	=> '',
							'id_submit'            	=> 'submit',
							'title_reply'          => '',
							'title_reply_to'       => '',
							'cancel_reply_link'    	=> '',
							'label_submit'         	=> ''.esc_html__('Post a Comment','uniqmag').'',
						);
						comment_form($defaults);			
					?>
				</div>
			<?php endif; // if you delete this the sky will fall on your head ?>
		</div>
	<?php endif; ?>