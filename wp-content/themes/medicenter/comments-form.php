<?php 
if(comments_open())
{
	?>
<div class="comment-form-container">
	<h3 class="box-header animation-slide">
		<?php _e("Leave a reply", 'medicenter'); ?>
	</h3>
	<form class="comment-form" id="comment_form" method="post" action="">
	<?php
	if(get_option('comment_registration') && !is_user_logged_in())
	{
	?>
	<p><?php printf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'medicenter' ), wp_login_url(get_permalink())); ?></p>
	<?php
	}
	else
	{
	?>
		<fieldset class="vc_col-sm-6 wpb_column vc_column_container">
			<label class="first"><?php echo __('YOUR NAME', 'medicenter'); ?></label>
			<div class="block">
				<input name="name" type="text" value="" />
			</div>
			<label><?php echo __('YOUR EMAIL', 'medicenter'); ?></label>
			<div class="block">
				<input name="email" type="text" value="" />
			</div>
			<label><?php echo __('WEBSITE (optional)', 'medicenter'); ?></label>
			<div class="block">
				<input name="website" type="text" value="" />
			</div>
		</fieldset>
		<fieldset class="vc_col-sm-6 wpb_column vc_column_container">
			<label class="first"><?php echo __('YOUR COMMENT', 'medicenter'); ?></label>
			<div class="block">
				<textarea name="message"></textarea>
			</div>
			<input name="submit" type="submit" value="<?php _e('POST COMMENT', 'medicenter'); ?>" class="more mc-button" />
			<a href="#cancel" id="cancel_comment" title="<?php _e('CANCEL REPLY', 'medicenter'); ?>"><?php _e('CANCEL REPLY', 'medicenter'); ?></a>
			<input type="hidden" name="action" value="theme_comment_form" />
			<input type="hidden" name="comment_parent_id" value="0" />
			<input type="hidden" name="paged" value="1" />
			<input type="hidden" name="prevent_scroll" value="0" />
		</fieldset>
	<?php
	}
	?>
		<fieldset>
			<input type="hidden" name="post_id" value="<?php echo esc_attr(get_the_ID()); ?>" />
			<input type="hidden" name="post_type" value="<?php echo (isset($post) ? esc_attr($post->post_type) : ''); ?>" />
		</fieldset>
	</form>
</div>
<?php
}
?>