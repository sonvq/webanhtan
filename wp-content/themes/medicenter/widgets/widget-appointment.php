<?php
class appointment_widget extends WP_Widget 
{
	/** constructor */
	function __construct() 
	{
		$widget_options = array(
			'classname' => 'appointment-widget',
			'description' => 'Displays Appointment Box'
		);
		$control_options = array('width' => 632);
        parent::__construct('medicenter_appointment', __('Appointment', 'medicenter'), $widget_options, $control_options);
    }
	
	/** @see WP_Widget::widget */
    function widget($args, $instance) 
	{
		extract($args);

		//these are our widget options
		$title = isset($instance['title']) ? $instance['title'] : "";
		$animation = isset($instance['animation']) ? $instance['animation'] : "";
		$sentence = isset($instance['sentence']) ? $instance['sentence'] : "";
		$content = isset($instance['content']) ? $instance['content'] : "";
		$icon_type = isset($instance['icon_type']) ? $instance["icon_type"] : "";
		$icon_value = isset($instance['icon_value']) ? $instance["icon_value"] : "";
		//$icon_target = $instance["icon_target"];

		echo $before_widget;
		if($title) 
		{
			echo ((int)$animation ? str_replace("box-header", "box-header animation-slide", $before_title) : str_replace("animation-slide", "", $before_title)) . apply_filters("widget_title", $title) . $after_title;
		} 
		if($content!="")
			echo '<div class="appointment-content">' . do_shortcode(apply_filters("widget_text", $content)) . '</div>';
		$arrayEmpty = true;
		for($i=0; $i<count($icon_type); $i++)
		{
			if($icon_type[$i]!="")
				$arrayEmpty = false;
		}
		if(!$arrayEmpty):
		?>
		<ul class="contact-data">
			<?php
			for($i=0; $i<count($icon_type); $i++)
			{
				if($icon_type[$i]!=""):
			?>
			<li class="clearfix social-<?php echo esc_attr($icon_type[$i]); ?>"><div class="value"><?php echo $icon_value[$i];?></div></li>
			<?php
				endif;
			}
			?>
		</ul>
		<?php
		endif;
		if($sentence!="")
			echo do_shortcode($sentence);
        echo $after_widget;
    }
	
	/** @see WP_Widget::update */
    function update($new_instance, $old_instance) 
	{
		$instance = $old_instance;
		$instance['title'] = isset($new_instance['title']) ? $new_instance['title'] : "";
		$instance['animation'] = isset($new_instance['animation']) ? $new_instance['animation'] : "";
		$instance['sentence'] = isset($new_instance['sentence']) ? $new_instance['sentence'] : "";
		$instance['content'] = isset($new_instance['content']) ? $new_instance['content'] : "";
		$icon_type = isset($new_instance['icon_type']) ? (array)$new_instance['icon_type'] : array("");
		while(end($icon_type)==="")
			array_pop($icon_type);
		$instance['icon_type'] = isset($icon_type) ? $icon_type : "";
		$instance['icon_value'] = isset($new_instance['icon_value']) ? $new_instance['icon_value'] : "";
		//$instance['icon_target'] = $new_instance['icon_target'];
		return $instance;
    }
	
	 /** @see WP_Widget::form */
	function form($instance) 
	{
		if(!isset($instance["icon_type"])):
		?>
			<input type="hidden" id="widget-appointment-button_id" value="<?php echo $this->get_field_id('add_new_button'); ?>">
		<?php
		endif;
		$title = isset($instance['title']) ? $instance['title'] : "";
		$animation = isset($instance['animation']) ? $instance['animation'] : "";
		$sentence = isset($instance['sentence']) ? $instance['sentence'] : "";
		$content = isset($instance['content']) ? $instance['content'] : "";
		$icon_type = isset($instance['icon_type']) ? $instance["icon_type"] : "";
		$icon_value = isset($instance['icon_value']) ? $instance["icon_value"] : "";
		//$icon_target = $instance["icon_target"];
		$icons = array(
			"angies-list",
			"behance",
			"deviantart",
			"dribbble",
			"email",
			"envato",
			"facebook",
			"flickr",
			"foursquare",
			"github",
			"google-plus",
			"houzz",
			"instagram",
			"linkedin",
			"location",
			"mobile",
			"paypal",
			"pinterest",
			"reddit",
			"rss",
			"skype",
			"soundcloud",
			"spotify",
			"stumbleupon",
			"tumblr",
			"twitter",
			"vimeo",
			"vine",
			"vk",
			"weibo",
			"xing",
			"yelp",
			"youtube"
		);
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
			<label for="<?php echo $this->get_field_id('content'); ?>"><?php _e('Content', 'medicenter'); ?></label>
			<textarea rows="6" class="widefat" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>"><?php echo esc_attr($content); ?></textarea>
		</p>
		<?php
		for($i=0; $i<(count($icon_type)<4 ? 4 : count($icon_type)); $i++)
		{
		?>
		<p>
			<label for="<?php echo $this->get_field_id('icon_type') . $i; ?>"><?php _e('Icon type', 'medicenter'); ?></label>
			<select id="<?php echo $this->get_field_id('icon_type') . $i; ?>" name="<?php echo $this->get_field_name('icon_type'); ?>[]">
				<option value="">-</option>
				<?php for($j=0; $j<count($icons); $j++)
				{
				?>
				<option value="<?php echo $icons[$j]; ?>"<?php echo (isset($icon_type[$i]) && $icons[$j]==$icon_type[$i] ? " selected='selected'" : "") ?>><?php echo $icons[$j]; ?></option>
				<?php
				}
				?>
			</select>
			<input style="width: 445px;" type="text" class="regular-text" value="<?php echo isset($icon_value[$i]) ? esc_attr($icon_value[$i]) : ""; ?>" name="<?php echo $this->get_field_name('icon_value'); ?>[]">
			<?php /*<select name="<?php echo $this->get_field_name('icon_target'); ?>[]">
				<option value="same_window"<?php echo ($icon_target[$i]=="same_window" ? " selected='selected'" : ""); ?>>same window</option>
				<option value="new_window"<?php echo ($icon_target[$i]=="new_window" ? " selected='selected'" : ""); ?>>new window</option>
			</select> */?>
		</p>
		<?php
		}
		?>
		<p>
			<input type="button" class="button" name="<?php echo $this->get_field_name('add_new_button'); ?>" id="<?php echo $this->get_field_id('add_new_button'); ?>" value="<?php _e('Add icon', 'medicenter'); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('sentence'); ?>"><?php _e('Sentence', 'medicenter'); ?></label>
			<textarea rows="6" class="widefat" id="<?php echo $this->get_field_id('sentence'); ?>" name="<?php echo $this->get_field_name('sentence'); ?>"><?php echo esc_attr($sentence); ?></textarea>
		</p>
		<script type="text/javascript">
		jQuery(document).ajaxStop(function(){
			var selector = "#<?php echo $this->get_field_id('add_new_button'); ?>";
			if(jQuery(".widgets-holder-wrap #widget-appointment-button_id").length)
			{
				selector = "#" + jQuery(jQuery(".widgets-holder-wrap #widget-appointment-button_id")[1]).val();
				jQuery(".widgets-holder-wrap #widget-appointment-button_id").remove();
			}
			jQuery(selector).off("click");
			jQuery(selector).on("click", function(){
				jQuery(this).parent().before(jQuery(this).parent().prev().clone().wrap('<div>').parent().html());
				jQuery(this).parent().prev().find("input").val('');
				jQuery(this).parent().prev().find("select").each(function(){
					jQuery(this).val(jQuery(this).children("option:first").val());
				});
			});
		});
		jQuery(document).ready(function($){
			$("#<?php echo $this->get_field_id('add_new_button'); ?>").click(function(){
				$(this).parent().before($(this).parent().prev().clone().wrap('<div>').parent().html());
				$(this).parent().prev().find("input, select").val('');
			});
		});
		</script>
		<?php
	}
}
//register widget
add_action('widgets_init', create_function('', 'return register_widget("appointment_widget");'));
?>