<?php
//custom post type - features
function theme_features_init()
{
	$labels = array(
		'name' => _x('Features', 'post type general name', 'medicenter'),
		'singular_name' => _x('Feature', 'post type singular name', 'medicenter'),
		'add_new' => _x('Add New', 'features', 'medicenter'),
		'add_new_item' => __('Add New Feature', 'medicenter'),
		'edit_item' => __('Edit Feature', 'medicenter'),
		'new_item' => __('New Feature', 'medicenter'),
		'all_items' => __('All Features', 'medicenter'),
		'view_item' => __('View Feature', 'medicenter'),
		'search_items' => __('Search Features', 'medicenter'),
		'not_found' =>  __('No features found', 'medicenter'),
		'not_found_in_trash' => __('No features found in Trash', 'medicenter'), 
		'parent_item_colon' => '',
		'menu_name' => __("Features", 'medicenter')
	);
	$args = array(  
		"labels" => $labels, 
		"public" => true,  
		"show_ui" => true,  
		"capability_type" => "post",  
		"menu_position" => 20,
		"hierarchical" => false,  
		"rewrite" => true,  
		"supports" => array("title", "editor", "excerpt", "thumbnail", "page-attributes", "comments")  
	);
	register_post_type("features", $args);
	register_taxonomy("features_category", array("features"), array("label" => "Categories", "singular_label" => "Category", "rewrite" => true));
}  
add_action("init", "theme_features_init"); 

//Adds a box to the right column and to the main column on the Features edit screens
function theme_add_features_custom_box() 
{
	add_meta_box( 
        "features_config",
        __("Options", 'medicenter'),
        "theme_inner_features_custom_box_main",
        "features",
		"normal",
		"high"
    );
}
add_action("add_meta_boxes", "theme_add_features_custom_box");
//backwards compatible (before WP 3.0)
//add_action("admin_init", "theme_add_custom_box", 1);

function theme_inner_features_custom_box_main($post)
{
	global $themename;
	//Use nonce for verification
	wp_nonce_field(plugin_basename( __FILE__ ), $themename . "_features_noncename");
	
	//The actual fields for data entry
	$icon = get_post_meta($post->ID, "icon", true);
	$icons = array(
		"address",
		"ambulance",
		"app",
		"baby",
		"baby-bed",
		"baby-bottle",
		"bacteria",
		"balance",
		"battery",
		"book",
		"box",
		"brain",
		"briefcase",
		"burns",
		"cart",
		"cat",
		"certificate",
		"chart",
		"chat",
		"clock",
		"config",
		"credit-card",
		"cross",
		"dental-shield",
		"dentist",
		"diary",
		"dna",
		"doctor",
		"document",
		"document-missing",
		"dog",
		"drip",
		"ear",
		"email",
		"eye",
		"facebook",
		"first-aid",
		"fitness",
		"frostbite",
		"gallery",
		"glasses",
		"graph",
		"healthcare",
		"heart",
		"heart-beat",
		"home",
		"hospital",
		"id",
		"image",
		"keyboard",
		"lab",
		"laptop",
		"leaf",
		"lifeline",
		"list",
		"location",
		"lock",
		"map",
		"medical-bed",
		"medical-cast",
		"medical-cross",
		"medical-document",
		"medical-results",
		"medical-scissors",
		"medical-staff",
		"minus",
		"mobile",
		"molecule",
		"money",
		"mortar",
		"movie",
		"network",
		"paypal",
		"pen",
		"people",
		"pet-box",
		"phone",
		"piano",
		"pill",
		"pin",
		"plaster",
		"plus",
		"printer",
		"pulse",
		"quote",
		"science",
		"screen",
		"signpost",
		"spa",
		"spa-bamboo",
		"spa-lotion",
		"speaker",
		"stethoscope",
		"syringe",
		"tablet",
		"tags",
		"teddy-bear",
		"test-tube",
		"tick",
		"time",
		"toothbrush",
		"twitter",
		"video",
		"wallet",
		"x-ray"
	);
	echo '
	<table>
		<tr>
			<td>
				<label for="icon">' . __('Icon', 'medicenter') . ':</label>
			</td>
			<td>
				<select id="features_icon" name="features_icon">
					<option value="-">' . __("none", 'medicenter') . '</option>';
					foreach($icons as $single_icon)
					{
						echo '<option class="features-' . esc_attr($single_icon) . '" value="' . esc_attr($single_icon) . '"' . ($single_icon==$icon ? ' selected="selected"' : '') . '>' . $single_icon . '</option>';
					}
				echo '</select>
			</td>
		</tr>
	</table>';
}

//When the post is saved, saves our custom data
function theme_save_features_postdata($post_id) 
{
	global $themename;
	//verify if this is an auto save routine. 
	//if it is our form has not been submitted, so we dont want to do anything
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
		return;

	//verify this came from the our screen and with proper authorization,
	//because save_post can be triggered at other times
	if (!isset($_POST[$themename . '_features_noncename']) || !wp_verify_nonce($_POST[$themename . '_features_noncename'], plugin_basename( __FILE__ )))
		return;


	//Check permissions
	if(!current_user_can('edit_post', $post_id))
		return;

	//OK, we're authenticated: we need to find and save the data
	update_post_meta($post_id, "icon", $_POST["features_icon"]);
}
add_action("save_post", "theme_save_features_postdata");

function features_edit_columns($columns)
{
	$columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => _x('Title', 'post type singular name', 'medicenter'),
			"features_category" => __('Categories', 'medicenter'),
			"features_icon" => __('Icon', 'medicenter'),
			"date" => __('Date', 'medicenter')
	);

	return $columns;
}
add_filter("manage_edit-features_columns", "features_edit_columns");

function manage_features_posts_custom_column($column)
{
	global $post;
	switch ($column)
	{
		case "features_category":
			echo get_the_term_list($post->ID, "features_category", '', ', ','');
			break;
		case "features_icon":
			echo  get_post_meta($post->ID, "icon", true);
			break;
	}
}
add_action("manage_features_posts_custom_column", "manage_features_posts_custom_column");

function theme_features_shortcode($atts)
{
	extract(shortcode_atts(array(
		"category" => "",
		"ids" => "",
		"order_by" => "title menu_order",
		"order" => "ASC",
		"type" => "large",
		"style" => "default",
		"columns" => 0,
		"headers" => 0,
		"headers_links" => 1,
		"read_more" => 1,
		"icon_links" => 1,
		"animation" => 0,
		"animation_duration" => "",
		"animation_delay" => "",
		"top_margin" => "none" 
	), $atts));
	
	$ids = explode(",", $ids);
	if($ids[0]=="-" || $ids[0]=="")
	{
		unset($ids[0]);
		$ids = array_values($ids);
	}
	$category = explode(",", $category);
	if($category[0]=="-" || $category[0]=="")
	{
		unset($category[0]);
		$category = array_values($category);
	}
	query_posts(array(
		'post__in' => $ids,
		'post_type' => 'features',
		'posts_per_page' => '-1',
		'post_status' => 'publish',
		'features_category' => implode(",", $category),
		'orderby' => implode(" ", explode(",", $order_by)),
		'order' => $order
	));
	
	global $wp_query; 
	$post_count = $wp_query->post_count;
	
	$output = "";
	if(have_posts())
	{
		$i=0;
		$output .= '<ul class="clearfix mc-features mc-features-' . esc_attr($type) . ' mc-features-style-' . esc_attr($style) . ($top_margin!="none" ? ' ' . $top_margin : '') . '">';
		while(have_posts()): the_post();
		if((int)$columns && ($i==0 || ($type=="large" && $i==ceil($post_count/2)) || ($type=="small" && $i==ceil($post_count/3)) || ($type=="small" && $i==ceil($post_count/3*2))))
		{
			if(($type=="large" && $i==ceil($post_count/2)) || ($type=="small" && $i==ceil($post_count/3)) || ($type=="small" && $i==ceil($post_count/3*2)))
				$output .= '</ul>';
			$output .= '<ul class="mc-features mc-features-' . esc_attr($type) . ' mc-features-style-' . esc_attr($style) . ' column' . ($type=="large" ? ($i==ceil($post_count/2) ? '_right' : '_left') : '') . '">';
		}
		$icon = get_post_meta(get_the_ID(), "icon", true);
		$output .= '<li class="item-content clearfix' . (!isset($icon) || $icon=="-" ? ' no-icon' : '') . '">
				' . (isset($icon) && $icon!="-" ? '<' . ($icon_links==1 ? 'a' : 'span') . ' class="hexagon' . ($type=="small" ? ' small' : '') . ($animation!='' ? ' animated-element animation-' . $animation . ((int)$animation_duration>0 && (int)$animation_duration!=600 ? ' duration-' . (int)$animation_duration : '') . ((int)$animation_delay>0 ? ' delay-' . (int)$animation_delay : '') : '') . '" ' . ($icon_links==1 ? 'href="' . get_permalink() . '"' : '') . ' title="' . esc_attr(get_the_title()) . '"><span class="features-' . esc_attr($icon) . '"></span></' . ($icon_links==1 ? 'a' : 'span') . '>' : '') . '<div class="text">'
				. ((int)$headers==1 ? '<h' . ($type=="large" ? '2' : '3') . '><' . ($headers_links==1 ? 'a' : 'span') . ' ' . ($headers_links==1 ? 'href="' . get_permalink() . '"' : '') . '  title="' . esc_attr(get_the_title()) . '">' . get_the_title() . '</' . ($headers_links==1 ? 'a' : 'span') . '></h' . ($type=="large" ? '2' : '3') . '>' : '')
				. apply_filters('the_excerpt', get_the_excerpt()) . 
				((int)$read_more==1 ? '<div class="item-footer clearfix"><a title="' . __("Read more", 'medicenter') . '" href="' . get_permalink() . '" class="more template-arrow-horizontal-1-after">' . __("Read more", 'medicenter') . '</a></div>' : '') .
				'</div>
			</li>';
		$i++;
		endwhile;
		$output .= '</ul>' . ((int)$columns ? '</div>' : '');
	}
	//Reset Query
	wp_reset_query();
	return $output;
}
add_shortcode("features", "theme_features_shortcode");

//visual composer
function theme_features_vc_init()
{
	//get features list
	$features_list = get_posts(array(
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC',
		'post_type' => 'features'
	));
	$features_array = array();
	$features_array[__("All", 'medicenter')] = "-";
	foreach($features_list as $feature)
		$features_array[$feature->post_title . " (id:" . $feature->ID . ")"] = $feature->ID;

	//get features categories list
	$features_categories = get_terms("features_category");
	$features_categories_array = array();
	$features_categories_array[__("All", 'medicenter')] = "-";
	foreach($features_categories as $features_category)
		$features_categories_array[$features_category->name] =  $features_category->slug;

	vc_map( array(
		"name" => __("Features list", 'medicenter'),
		"base" => "features",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-features-list",
		"category" => __('MediCenter', 'medicenter'),
		"params" => array(
			array(
				"type" => "dropdownmulti",
				"class" => "",
				"heading" => __("Display selected", 'medicenter'),
				"param_name" => "ids",
				"value" => $features_array
			),
			array(
				"type" => "dropdownmulti",
				"class" => "",
				"heading" => __("Display from Category", 'medicenter'),
				"param_name" => "category",
				"value" => $features_categories_array
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Type", 'medicenter'),
				"param_name" => "type",
				"value" => array(__("Large", 'medicenter') => "large", __("Small", 'medicenter') => "small")
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Style", 'medicenter'),
				"param_name" => "style",
				"value" => array(__("Default", 'medicenter') => "default", __("Light", 'medicenter') => "light")
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Order by", 'medicenter'),
				"param_name" => "order_by",
				"value" => array(__("Title, menu order", 'medicenter') => "title,menu_order", __("Menu order", 'medicenter') => "menu_order", __("Date", 'medicenter') => "date")
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Order", 'medicenter'),
				"param_name" => "order",
				"value" => array(__("ascending", 'medicenter') => "ASC", __("descending", 'medicenter') => "DESC")
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Headers", 'medicenter'),
				"param_name" => "headers",
				"value" => array(__("No", 'medicenter') => 0, __("Yes", 'medicenter') => 1)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Headers links", 'medicenter'),
				"param_name" => "headers_links",
				"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Read more button", 'medicenter'),
				"param_name" => "read_more",
				"value" => array(__("No", 'medicenter') => 0, __("Yes", 'medicenter') => 1)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Icon links", 'medicenter'),
				"param_name" => "icon_links",
				"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0)
			),
			array(
				"type" => "dropdown",
				"heading" => __("Icon animation", "medicenter"),
				"param_name" => "animation",
				"value" => array(
					__("none", "medicenter") => "",
					__("fade in", "medicenter") => "fadeIn",
					__("scale", "medicenter") => "scale",
					__("slide right", "medicenter") => "slideRight",
					__("slide right 200%", "medicenter") => "slideRight200",
					__("slide left", "medicenter") => "slideLeft",
					__("slide left 50%", "medicenter") => "slideLeft50",
					__("slide down", "medicenter") => "slideDown",
					__("slide down 200%", "medicenter") => "slideDown200",
					__("slide up", "medicenter") => "slideUp"
				)
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Icon animation duration", 'medicenter'),
				"param_name" => "animation_duration",
				"value" => "600"
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Icon animation delay", 'medicenter'),
				"param_name" => "animation_delay",
				"value" => "0"
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Top margin", 'medicenter'),
				"param_name" => "top_margin",
				"value" => array(__("None", 'medicenter') => "none", __("Page (small)", 'medicenter') => "page-margin-top", __("Section (large)", 'medicenter') => "page-margin-top-section")
			)
		)
	));
}
add_action("init", "theme_features_vc_init"); 
?>