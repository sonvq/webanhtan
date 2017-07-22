<?php
class contact_details_widget extends WP_Widget 
{
	/** constructor */
    function __construct()
	{
		$widget_options = array(
			'classname' => 'contact_details_widget',
			'description' => 'Displays Contact Details Box'
		);
		$control_options = array('width' => 665);
        parent::__construct('medicenter_contact_details', __('Contact Details Box', 'medicenter'), $widget_options, $control_options);
    }
	
	/** @see WP_Widget::widget */
    function widget($args, $instance) 
	{
        extract($args);

		//these are our widget options
		$title = isset($instance['title']) ? $instance['title'] : "";
		$animation = isset($instance['animation']) ? $instance['animation'] : "";
		$content = isset($instance['content']) ? $instance['content'] : "";
		$address_line_1 = isset($instance['address_line_1']) ? $instance['address_line_1'] : "";
		$address_line_2 = isset($instance['address_line_2']) ? $instance['address_line_2'] : "";
		$address_line_3 = isset($instance['address_line_3']) ? $instance['address_line_3'] : "";
		$address_line_4 = isset($instance['address_line_4']) ? $instance['address_line_4'] : "";
		$contact_line_1 = isset($instance['contact_line_1']) ? $instance['contact_line_1'] : "";
		$contact_line_2 = isset($instance['contact_line_2']) ? $instance['contact_line_2'] : "";
		$contact_line_3 = isset($instance['contact_line_3']) ? $instance['contact_line_3'] : "";
		$contact_line_4 = isset($instance['contact_line_4']) ? $instance['contact_line_4'] : "";
		$icon_type = isset($instance['icon_type']) ? $instance["icon_type"] : "";
		$icon_color = isset($instance['icon_color']) ? $instance["icon_color"] : "";
		$icon_value = isset($instance['icon_value']) ? $instance["icon_value"] : "";

		echo $before_widget;
		if($title) 
		{
			echo ((int)$animation ? str_replace("box-header", "box-header animation-slide", $before_title) : str_replace("animation-slide", "", $before_title)) . apply_filters("widget_title", $title) . $after_title;
		}
		if($content!='')
			echo '<p class="info">' . do_shortcode(apply_filters("widget_text", $content)) . '</p>';
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
			<li class="clearfix template-<?php echo esc_attr($icon_type[$i]); ?>"><div class="value"><?php echo $icon_value[$i];?></div></li>
			<?php
				endif;
			}
			?>
		</ul>
		<?php
		endif;
        echo $after_widget;
    }
	
	/** @see WP_Widget::update */
    function update($new_instance, $old_instance) 
	{
		$instance = $old_instance;
		$instance['title'] = isset($new_instance['title']) ? strip_tags($new_instance['title']) : "";
		$instance['animation'] = isset($new_instance['animation']) ? strip_tags($new_instance['animation']) : "";
		$instance['content'] = isset($new_instance['content']) ? $new_instance['content'] : "";
		$icon_type = isset($new_instance['icon_type']) ? (array)$new_instance['icon_type'] : array("");
		while(end($icon_type)==="")
			array_pop($icon_type);
		$instance['icon_type'] = isset($icon_type) ? $icon_type : "";
		$instance['icon_value'] = isset($new_instance['icon_value']) ? $new_instance['icon_value'] : "";
		return $instance;
    }
	
	 /** @see WP_Widget::form */
	function form($instance) 
	{	
		if(!isset($instance["icon_type"])):
		?>
			<input type="hidden" id="widget-contact-details-button_id" value="<?php echo $this->get_field_id('add_new_button'); ?>">
		<?php
		endif;
		$title = isset($instance['title']) ? esc_attr($instance['title']) : "";
		$animation = isset($instance['animation']) ? esc_attr($instance['animation']) : "";
		$content = isset($instance['content']) ? esc_attr($instance['content']) : "";
		$icon_type = isset($instance['icon_type']) ? $instance["icon_type"] : "";
		$icon_value = isset($instance['icon_value']) ? $instance["icon_value"] : "";
		$icons = array(
			"arrow-circle",
			"arrow-horizontal-1",
			"arrow-horizontal-2",
			"arrow-horizontal-3",
			"arrow-horizontal-4",
			"arrow-horizontal-5",
			"arrow-vertical-1",
			"arrow-vertical-3",
			"arrow-vertical-4",
			"arrow-vertical-5",
			"cart",
			"check",
			"chevron",
			"comment-1",
			"comment-2",
			"location",
			"mail",
			"menu-1",
			"menu-2",
			"minus-1",
			"minus-2",
			"phone",
			"plus-1",
			"plus-2",
			"remove-1",
			"remove-2",
			"search",
			"quote"
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
			<textarea rows="10" class="widefat" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>"><?php echo $content; ?></textarea>
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
		</p>
		<?php
		}
		?>
		<p>
			<input type="button" class="button" name="<?php echo $this->get_field_name('add_new_button'); ?>" id="<?php echo $this->get_field_id('add_new_button'); ?>" value="<?php esc_attr_e('Add icon', 'medicenter'); ?>" />
		</p>
		<script type="text/javascript">
		jQuery(document).ajaxStop(function(){
			var selector = "#<?php echo $this->get_field_id('add_new_button'); ?>";
			if(jQuery(".widgets-holder-wrap #widget-contact-details-button_id").length)
			{
				selector = "#" + jQuery(jQuery(".widgets-holder-wrap #widget-contact-details-button_id")[1]).val();
				jQuery(".widgets-holder-wrap #widget-contact-details-button_id").remove();
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
add_action('widgets_init', create_function('', 'return register_widget("contact_details_widget");'));
?>