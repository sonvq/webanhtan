<?php
class scrolling_recent_posts_widget extends WP_Widget 
{
	/** constructor */
    function __construct()
	{
		global $themename;
		$widget_options = array(
			'classname' => 'scrolling_recent_posts_widget',
			'description' => 'Displays scrolling recent posts list'
		);
        parent::__construct('medicenter_scrolling_recent_posts', __('Scrolling Recent Posts', 'medicenter'), $widget_options);
    }
	
	/** @see WP_Widget::widget */
    function widget($args, $instance) 
	{
        extract($args);

		//these are our widget options
		$title = isset($instance['title']) ? $instance['title'] : "";
		$animation = isset($instance['animation']) ? $instance['animation'] : "";
		$count = isset($instance['count']) ? $instance['count'] : "";

		//get recent posts
		query_posts(array( 
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => $count,
			'order' => 'DESC'
		));
		
		echo $before_widget;
		?>
		<div class="clearfix scrolling-controls">
			<div class="header-left">
				<?php
				if($title) 
				{
					echo ((int)$animation ? str_replace("box-header", "box-header animation-slide", $before_title) : str_replace("animation-slide", "", $before_title)) . apply_filters("widget_title", $title) . $after_title;
				}
				?>
			</div>
			<div class="header-right">
				<a href="#" id="footer_recent_posts_prev" class="scrolling-list-control-left template-arrow-horizontal-3"></a>
				<a href="#" id="footer_recent_posts_next" class="scrolling-list-control-right template-arrow-horizontal-3"></a>
			</div>
		</div>
		<div class="scrolling-list-wrapper">
			<ul class="scrolling-list footer-recent-posts">
				<?php
				if(have_posts()) : while (have_posts()) : the_post();
				?>
				<li>
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<?php the_title(); ?>
					</a>
					<abbr title="<?php echo date_i18n(get_option('date_format'), get_post_time()); ?>" class="timeago"><?php echo date_i18n(get_option('date_format'), get_post_time()); ?></abbr>
				</li>
				<?php
				endwhile; endif;
				wp_reset_query();
				?>
			</ul>
		</div>
		<?php
        echo $after_widget;
    }
	
	/** @see WP_Widget::update */
    function update($new_instance, $old_instance) 
	{
		$instance = $old_instance;
		$instance['title'] = isset($new_instance['title']) ? strip_tags($new_instance['title']) : "";
		$instance['animation'] = isset($new_instance['animation']) ? strip_tags($new_instance['animation']) : "";
		$instance['count'] = isset($new_instance['count']) ? strip_tags($new_instance['count']) : "";
		return $instance;
    }
	
	 /** @see WP_Widget::form */
	function form($instance) 
	{	
		global $themename;
		$title = isset($instance['title']) ? esc_attr($instance['title']) : "";
		$animation = isset($instance['animation']) ? esc_attr($instance['animation']) : "";
		$count = isset($instance['count']) ? esc_attr($instance['count']) : "";
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'medicenter'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('animation'); ?>"><?php _e('Title border animation', 'medicenter'); ?></label>
			<select id="<?php echo $this->get_field_id('animation'); ?>" name="<?php echo $this->get_field_name('animation'); ?>">
				<option value="0"><?php _e('no', 'medicenter'); ?></option>
				<option value="1"<?php echo ((int)$animation==1 ? ' selected="selected"' : ''); ?>><?php _e('yes', 'medicenter'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Count', 'medicenter'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" />
		</p>
		<?php
	}
}
//register widget
add_action('widgets_init', create_function('', 'return register_widget("scrolling_recent_posts_widget");'));
?>