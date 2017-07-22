<?php
$themename = "medicenter";
//for is_plugin_active
include_once( ABSPATH . 'wp-admin/includes/plugin.php');
//plugins activator
require_once("plugins_activator.php");

//vc_remove_element("vc_row_inner");
if(function_exists("vc_remove_element"))
{
	vc_remove_element("vc_gmaps");
	vc_remove_element("vc_tour");
}

//theme options
mc_get_theme_file("/theme-options.php");

//custom meta box
mc_get_theme_file("/meta-box.php");

//dropdown menu
mc_get_theme_file("/nav-menu-dropdown-walker.php");
//mobile menu
mc_get_theme_file("/mobile-menu-walker.php");

//gallery functions
mc_get_theme_file("/gallery-functions.php");
//weekdays
mc_get_theme_file("/post-type-weekdays.php");
//departments
mc_get_theme_file("/post-type-departments.php");
if(function_exists("vc_map"))
{
	//doctors
	mc_get_theme_file("/post-type-doctors.php");
	//gallery
	mc_get_theme_file("/post-type-gallery.php");
	//features
	mc_get_theme_file("/post-type-features.php");
	//contact_form
	mc_get_theme_file("/contact_form.php");
}

//comments
mc_get_theme_file("/comments-functions.php");

//sidebars
mc_get_theme_file("/sidebars.php");

//widgets
mc_get_theme_file("/widgets/widget-cart-icon.php");
mc_get_theme_file("/widgets/widget-home-box.php");
mc_get_theme_file("/widgets/widget-departments.php");
mc_get_theme_file("/widgets/widget-appointment.php");
mc_get_theme_file("/widgets/widget-twitter.php");
mc_get_theme_file("/widgets/widget-footer-box.php");
mc_get_theme_file("/widgets/widget-contact-details.php");
mc_get_theme_file("/widgets/widget-scrolling-recent-posts.php");
mc_get_theme_file("/widgets/widget-scrolling-most-commented.php");
mc_get_theme_file("/widgets/widget-scrolling-most-viewed.php");

//shortcodes
if(function_exists("vc_map"))
	mc_get_theme_file("/shortcodes/shortcodes.php");

//admin functions
mc_get_theme_file("/admin/functions.php");

function theme_after_setup_theme()
{
	global $themename;
	if(!get_option($themename . "_installed") || !get_option("wpb_js_content_types"))
	{
		$theme_options = array(
			"favicon_url" => get_template_directory_uri() . "/images/favicon.ico",
			"logo_url" => get_template_directory_uri() . "/images/header_logo.png",
			"logo_text" => "medicenter",
			"footer_text_left" => "© 2017 <a href='https://themeforest.net/user/QuanticaLabs/portfolio?ref=QuanticaLabs' target='_blank'>MediCenter Theme</a>. All rights reserved.",
			//"home_page_top_hint" => "Give us a call: +123 356 123 124",
			"sticky_menu" => 0,
			"responsive" => 1,
			"scroll_top" => 1,
			"direction" => "default",
			"animations" => 1,
			"layout" => "fullwidth",
			"layout_picker" => 0,
			//"home_page_top_hint" => "",
			"collapsible_mobile_submenus" => 1,
			"google_api_code" => "",
			"ga_tracking_code" => "",
			"color_scheme" => "",
			"primary_color" => "",
			"secondary_color" => "",
			"tertiary_color" => "",
			"header_top_sidebar" => "",
			"accordion_tab_color" => "",
			"tabs_text_color" => "",
			"tabs_border_color" => "",
			"tabs_hover_text_color" => "",
			"tabs_border_hover_color" => "",
			"featured_icon_color" => "",
			"featured_icon_background_color" => "",
			"light_featured_icon_color" => "",
			"light_featured_icon_background_color" => "",
			"social_icon_color" => "",
			"social_icon_background_color" => "",
			"social_icon_hover_color" => "",
			"social_icon_hover_background_color" => "",
			"body_background_color" => "",
			"categories_and_pagination_color" => "",
			"categories_and_pagination_hover_color" => "",
			"categories_and_pagination_border_color" => "",
			"categories_and_pagination_border_hover_color" => "",
			"categories_and_pagination_background_color" => "",
			"categories_and_pagination_hover_background_color" => "",
			"light_button_color" => "",
			"light_button_hover_color" => "",
			"light_button_border_color" => "",
			"light_button_border_hover_color" => "",
			"light_button_background_color" => "",
			"light_button_hover_background_color" => "",
			"light_color_button_color" => "",
			"light_color_button_hover_color" => "",
			"light_color_button_border_color" => "",
			"light_color_button_border_hover_color" => "",
			"light_color_button_background_color" => "",
			"light_color_button_hover_background_color" => "",
			"dark_color_button_color" => "",
			"dark_color_button_hover_color" => "",
			"dark_color_button_border_color" => "",
			"dark_color_button_border_hover_color" => "",
			"dark_color_button_background_color" => "",
			"dark_color_button_hover_background_color" => "",
			"body_headers_border_color" => "",
			"body_headers_color" => "",
			"body_text_color" => "",
			"bread_crumb_border_color" => "",
			"comment_reply_button_color" => "",
			"contact_details_box_background_color" => "",
			"date_box_color" => "",
			"date_box_comments_number_color" => "",
			"date_box_comments_number_text_color" => "",
			"date_box_text_color" => "",
			"divider_background_color" => "",
			"dropdownmenu_background_color" => "",
			"dropdownmenu_border_color" => "",
			"dropdownmenu_hover_background_color" => "",
			"mobile_menu_link_color" => "",
			"mobile_menu_position_background_color" => "",
			"mobile_menu_active_link_color" => "",
			"mobile_menu_active_position_background_color" => "",
			"footer_background_color" => "",
			"copyright_area_background_color" => "",
			"scrolling_list_number_color" => "",
			"scrolling_list_number_border_color" => "",
			"scrolling_list_number_hover_color" => "",
			"scrolling_list_number_border_hover_color" => "",
			"scrolling_list_control_arrow_color" => "",
			"scrolling_list_control_border_color" => "",
			"scrolling_list_control_arrow_hover_color" => "",
			"scrolling_list_control_arrow_border_hover_color" => "",
			"footer_scrolling_list_control_arrow_color" => "",
			"footer_scrolling_list_control_border_color" => "",
			"footer_scrolling_list_control_arrow_hover_color" => "",
			"footer_scrolling_list_control_arrow_border_hover_color" => "",
			"footer_headers_border_color" => "",
			"footer_headers_color" => "",
			"footer_link_color" => "",
			"footer_link_hover_color" => "",
			"footer_text_color" => "",
			"footer_timeago_label_color" => "",
			"form_button_background_color" => "",
			"form_button_hover_background_color" => "",
			"form_button_hover_text_color" => "",
			"form_button_text_color" => "",
			"form_field_border_color" => "",
			"form_field_text_color" => "",
			"form_field_background_color" => "",
			"gallery_box_border_color" => "",
			"gallery_box_color" => "",
			"gallery_box_hover_border_color" => "",
			"gallery_box_hover_color" => "",
			"gallery_box_hover_text_first_line_color" => "",
			"gallery_box_hover_text_second_line_color" => "",
			"gallery_box_text_first_line_color" => "",
			"gallery_box_text_second_line_color" => "",
			"gallery_details_box_border_color" => "",
			"gallery_box_control_color" => "",
			"gallery_box_control_hover_color" => "",
			"header_background_color" => "",
			"header_font" => "",
			"header_font_subset" => "",
			"header_layout_type" => "1",
			"header_top_right_sidebar" => "",
			"link_color" => "",
			"link_hover_color" => "",
			"logo_text_color" => "",
			"main-menu" => "",
			"menu_position_background_color" => "",
			"menu_position_hover_background_color" => "",
			"menu_position_hover_text_color" => "",
			"menu_position_text_color" => "",
			"menu_position_childrens_hover_text_color" => "",
			"menu_position_childrens_hover_background_color" => "",
			"post_author_link_color" => "",
			"quote_color" => "",
			"sentence_color" => "",
			"site_background_color" => "",
			"content_font" => "",
			"content_font_subset" => "",
			"blockquote_font" => "",
			"blockquote_font_subset" => "",
			"submenu_position_border_color" => "",
			"submenu_position_hover_border_color" => "",
			"submenu_position_hover_text_color" => "",
			"submenu_position_text_color" => "",
			"timeago_label_color" => "",
			"timetable_box_color" => "",
			"timetable_box_hover_color" => "",
			"timetable_box_hover_text_color" => "",
			"timetable_box_text_color" => "",
			"timetable_tip_box_color" => "",
			//"top_hint_background_color" => "",
			//"top_hint_text_color" => "",
			"cf_admin_name" => get_option("admin_email"),
			"cf_admin_email" => get_option("admin_email"),
			"cf_smtp_host" => "",
			"cf_smtp_username" => "",
			"cf_smtp_password" => "",
			"cf_smtp_port" => "",
			"cf_smtp_secure" => "",
			"cf_email_subject" => "MediCenter WP: Contact from WWW",
			"cf_template" => "<html>
	<head>
	</head>
	<body>
		<div><b>First and last name</b>: [first_name] [last_name]</div>
		<div><b>E-mail</b>: [email]</div>
		<div><b>Department</b>: [department]</div>
		<div><b>Date of Birth (mm/dd/yyyy)</b>: [date]</div>
		<div><b>Social Security Number</b>: [social_security_number]</div>
		<div><b>Reason of Appointment</b>: [message]</div>
	</body>
</html>"
		);
		add_option($themename . "_options", $theme_options);
		
		//add_option($themename . "_slider_settings_home-slider", array('slider_image_url' => array (0 => get_template_directory_uri() . "/images/slider/img1.jpg", 1 => get_template_directory_uri() . "/images/slider/img2.jpg", 2 => get_template_directory_uri() . "/images/slider/img3.jpg"), 'slider_image_title' => array(0 => 'Top notch<br>experience', 1 => 'Show your<br>schedule', 2 => 'Build it<br>your way'), 'slider_image_subtitle' => array (0 => 'Medicenter is a responsive template<br>perfect for all screen sizes', 1 => 'Organize and visualize your week<br>with build-in timetable', 2 => 'Limitless possibilities with multiple<br>page layouts and different shortcodes'), 'slider_image_link' => array (), 'slider_autoplay' => '1', 'slider_navigation' => '1', 'slider_pause_on_hover' => NULL, 'slider_height' => 670, 'slide_interval' => 5000, 'slider_effect' => 'scroll', 'slider_transition' => 'easeInOutQuint', 'slider_transition_speed' => 750));
		update_option("blogdescription", "Responsive Medical Health WordPress Theme");
		
		add_option("wpb_js_content_types", array(
			"page",
			"doctors", 
			"medicenter_gallery", 
			"features")
		);
		
		global $wp_rewrite;
		$wp_rewrite->flush_rules();
		add_option($themename . "_installed", 1);
	}
	//Make theme available for translation
	//Translations can be filed in the /languages/ directory
	load_theme_textdomain('medicenter', get_template_directory() . '/languages');
	
	//register blog post thumbnail & portfolio thumbnail
	add_theme_support("post-thumbnails");
	add_image_size("blog-post-thumb", 670, 446, true);
	add_image_size($themename . "-gallery-image", 600, 400, true);
	add_image_size($themename . "-gallery-thumb-type-1", 390, 260, true);
	add_image_size($themename . "-gallery-thumb-type-2", 285, 190, true);
	add_image_size($themename . "-small-thumb", 100, 100, true);
	
	//posts order
	add_post_type_support('post', 'page-attributes');
	
	//woocommerce
	add_theme_support("woocommerce");
	//enable custom background
	add_theme_support("custom-background"); //3.4
	//add_custom_background(); //deprecated
	//title tag
	add_theme_support("title-tag");
	//register menu
	add_theme_support("menus");
	
	if(function_exists("register_nav_menu"))
	{
		register_nav_menu("main-menu", "Main Menu");
		register_nav_menu("footer-menu", "Footer Menu");
	}
	
	//custom theme filters
	add_filter('wp_title', 'mc_wp_title_filter', 10, 2);
	add_filter("image_size_names_choose", "theme_image_sizes");
	add_filter('upload_mimes', 'custom_upload_files');
	add_filter('excerpt_more', 'theme_excerpt_more', 99);
	add_filter('site_transient_update_plugins', 'medicenter_filter_update_vc_plugin', 10, 2);
	//using shortcodes in sidebar
	add_filter("widget_text", "do_shortcode");
	
	//custom theme woocommerce filters
	add_filter('woocommerce_pagination_args' , 'mc_woo_custom_override_pagination_args');
	add_filter('woocommerce_product_single_add_to_cart_text', 'mc_woo_custom_cart_button_text');
	add_filter('woocommerce_product_add_to_cart_text', 'mc_woo_custom_cart_button_text');
	add_filter('loop_shop_columns', 'mc_woo_custom_loop_columns');
	add_filter('woocommerce_product_description_heading', 'mc_woo_custom_product_description_heading');
	add_filter('woocommerce_checkout_fields' , 'mc_woo_custom_override_checkout_fields');
	add_filter('woocommerce_show_page_title', 'mc_woo_custom_show_page_title');
	add_filter('loop_shop_per_page', create_function( '$cols', 'return 6;' ), 20);
	add_filter('woocommerce_review_gravatar_size', 'mc_woo_custom_review_gravatar_size');
	
	//custom theme actions
	if(!function_exists('_wp_render_title_tag')) 
		add_action('wp_head', 'cs_theme_slug_render_title');
	
	//custom theme woocommerce actions
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
	remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
	
	//remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
	add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
	add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
	add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
	
	//phpMailer
	add_action('phpmailer_init', 'mc_phpmailer_init');
	
	//content width
	if(!isset($content_width)) 
		$content_width = 1230;
	
	//register sidebars
	if(function_exists("register_sidebar"))
	{
		//register custom sidebars
		$sidebars_list = get_posts(array( 
			'post_type' => $themename . '_sidebars',
			'posts_per_page' => '-1',
			'post_status' => 'publish',
			'orderby' => 'menu_order',
			'order' => 'ASC'
		));
		foreach($sidebars_list as $sidebar)
		{
			$before_widget = get_post_meta($sidebar->ID, "before_widget", true);
			$after_widget = get_post_meta($sidebar->ID, "after_widget", true);
			$before_title = get_post_meta($sidebar->ID, "before_title", true);
			$after_title = get_post_meta($sidebar->ID, "after_title", true);
			register_sidebar(array(
				"id" => $sidebar->post_name,
				"name" => $sidebar->post_title,
				'before_widget' => ($before_widget!='' && $before_widget!='empty' ? $before_widget : ''),
				'after_widget' => ($after_widget!='' && $after_widget!='empty' ? $after_widget : ''),
				'before_title' => ($before_title!='' && $before_title!='empty' ? $before_title : ''),
				'after_title' => ($after_title!='' && $after_title!='empty' ? $after_title : '')
			));
		}
	}
}
add_action("after_setup_theme", "theme_after_setup_theme");
function theme_switch_theme($theme_template)
{
	global $themename;
	delete_option($themename . "_installed");
}
add_action("switch_theme", "theme_switch_theme");

//theme options
global $theme_options;
$theme_options = array(
	"favicon_url" => '',
	"logo_url" => '',
	"logo_text" => '',
	"footer_text_left" => '',
	"sticky_menu" => '',
	"responsive" => '',
	"scroll_top" => '',
	"layout" => '',
	"layout_picker" => '',
	"direction" => '',
	"animations" => '',
	"collapsible_mobile_submenus" => '',
	"google_api_code" => '',
	"ga_tracking_code" => '',
	//"home_page_top_hint" => '',
	"cf_admin_name" => '',
	"cf_admin_email" => '',
	"cf_smtp_host" => '',
	"cf_smtp_username" => '',
	"cf_smtp_password" => '',
	"cf_smtp_port" => '',
	"cf_smtp_secure" => '',
	"cf_email_subject" => '',
	"cf_template" => '',
	"color_scheme" => '',
	"primary_color" => '',
	"secondary_color" => '',
	"tertiary_color" => '',
	"site_background_color" => '',
	"header_background_color" => '',
	"body_background_color" => '',
	"footer_background_color" => '',
	"copyright_area_background_color" => '',
	"link_color" => '',
	"link_hover_color" => '',
	"footer_link_color" => '',
	"footer_link_hover_color" => '',
	"body_headers_color" => '',
	"body_headers_border_color" => '',
	"body_text_color" => '',
	"timeago_label_color" => '',
	"footer_headers_color" => '',
	"footer_headers_border_color" => '',
	"footer_text_color" => '',
	"footer_timeago_label_color" => '',
	"sentence_color" => '',
	"quote_color" => '',
	"logo_text_color" => '',
	"categories_and_pagination_color" => '',
	"categories_and_pagination_hover_color" => '',
	"categories_and_pagination_border_color" => '',
	"categories_and_pagination_border_hover_color" => '',
	"categories_and_pagination_background_color" => '',
	"categories_and_pagination_hover_background_color" => '',
	"light_button_color" => '',
	"light_button_hover_color" => '',
	"light_button_border_color" => '',
	"light_button_border_hover_color" => '',
	"light_button_background_color" => '',
	"light_button_hover_background_color" => '',
	"light_color_button_color" => '',
	"light_color_button_hover_color" => '',
	"light_color_button_border_color" => '',
	"light_color_button_border_hover_color" => '',
	"light_color_button_background_color" => '',
	"light_color_button_hover_background_color" => '',
	"dark_color_button_color" => '',
	"dark_color_button_hover_color" => '',
	"dark_color_button_border_color" => '',
	"dark_color_button_border_hover_color" => '',
	"dark_color_button_background_color" => '',
	"dark_color_button_hover_background_color" => '',
	"scrolling_list_number_color" => '',
	"scrolling_list_number_border_color" => '',
	"scrolling_list_number_hover_color" => '',
	"scrolling_list_number_border_hover_color" => '',
	"scrolling_list_control_arrow_color" => '',
	"scrolling_list_control_border_color" => '',
	"scrolling_list_control_arrow_hover_color" => '',
	"scrolling_list_control_arrow_border_hover_color" => '',
	"footer_scrolling_list_control_arrow_color" => '',
	"footer_scrolling_list_control_border_color" => '',
	"footer_scrolling_list_control_arrow_hover_color" => '',
	"footer_scrolling_list_control_arrow_border_hover_color" => '',
	"menu_position_text_color" => '',
	"menu_position_hover_text_color" => '',
	"menu_position_childrens_hover_text_color" => '',
	"menu_position_background_color" => '',
	"menu_position_hover_background_color" => '',
	"menu_position_childrens_hover_background_color" => '',
	"submenu_position_text_color" => '',
	"submenu_position_hover_text_color" => '',
	"submenu_position_border_color" => '',
	"submenu_position_hover_border_color" => '',
	"dropdownmenu_background_color" => '',
	"dropdownmenu_hover_background_color" => '',
	"dropdownmenu_border_color" => '',
	"mobile_menu_link_color" => '',
	"mobile_menu_position_background_color" => '',
	"mobile_menu_active_link_color" => '',
	"mobile_menu_active_position_background_color" => '',
	"form_field_text_color" => '',
	"form_field_border_color" => '',
	"form_field_background_color" => '',
	"form_button_background_color" => '',
	"form_button_hover_background_color" => '',
	"form_button_text_color" => '',
	"form_button_hover_text_color" => '',
	//"top_hint_background_color" => '',
	//"top_hint_text_color" => '',
	"divider_background_color" => '',
	"date_box_color" => '',
	"date_box_text_color" => '',
	"date_box_comments_number_color" => '',
	"date_box_comments_number_text_color" => '',
	"gallery_box_color" => '',
	"gallery_box_text_first_line_color" => '',
	"gallery_box_text_second_line_color" => '',
	"gallery_box_hover_color" => '',
	"gallery_box_hover_text_first_line_color" => '',
	"gallery_box_hover_text_second_line_color" => '',
	"gallery_box_border_color" => '',
	"gallery_box_hover_border_color" => '',
	"gallery_box_control_color" => '',
	"gallery_box_control_hover_color" => '',
	"timetable_box_color" => '',
	"timetable_box_hover_color" => '',
	"timetable_box_text_color" => '',
	"timetable_box_hover_text_color" => '',
	"timetable_tip_box_color" => '',
	"accordion_tab_color" => '',
	"tabs_text_color" => '',
	"tabs_border_color" => '',
	"tabs_hover_text_color" => '',
	"tabs_border_hover_color" => '',
	"featured_icon_color" => '',
	"featured_icon_background_color" => '',
	"light_featured_icon_color" => '',
	"light_featured_icon_background_color" => '',
	"social_icon_color" => '',
	"social_icon_background_color" => '',
	"social_icon_hover_color" => '',
	"social_icon_hover_background_color" => '',
	"header_layout_type" => '',
	"header_top_sidebar" => '',
	"header_top_right_sidebar" => '',
	"header_font" => '',
	"header_font_subset" => '',
	"content_font" => '',
	"content_font_subset" => '',
	"blockquote_font" => '',
	"blockquote_font_subset" => ''
);
$theme_options = theme_stripslashes_deep(array_merge($theme_options, (array)get_option($themename . "_options")));

function theme_enqueue_scripts()
{
	global $themename;
	global $theme_options;
	//style
	if(!empty($theme_options["header_font"]))
		wp_enqueue_style("google-font-header", "//fonts.googleapis.com/css?family=" . urlencode($theme_options["header_font"]) . (!empty($theme_options["header_font_subset"]) ? "&subset=" . implode(",", $theme_options["header_font_subset"]) : ""));
	else
		wp_enqueue_style("google-font-source-sans-pro", "//fonts.googleapis.com/css?family=Source+Sans+Pro:400,200,300,600,700&amp;subset=latin,latin-ext");
	if(!empty($theme_options["content_font"]))
		wp_enqueue_style("google-font-subheader", "//fonts.googleapis.com/css?family=" . urlencode($theme_options["content_font"]) . (!empty($theme_options["content_font_subset"]) ? "&subset=" . implode(",", $theme_options["content_font_subset"]) : ""));
	else
		wp_enqueue_style("google-font-open-sans", "//fonts.googleapis.com/css?family=Open+Sans:400,300&amp;subset=latin,latin-ext");
	if(!empty($theme_options["blockquote_font"]))
		wp_enqueue_style("google-font-subheader", "//fonts.googleapis.com/css?family=" . urlencode($theme_options["blockquote_font"]) . (!empty($theme_options["blockquote_font_subset"]) ? "&subset=" . implode(",", $theme_options["blockquote_font_subset"]) : ""));
	else
		wp_enqueue_style("google-font-pt-serif", "//fonts.googleapis.com/css?family=PT+Serif:400italic&amp;subset=latin,latin-ext");
	wp_enqueue_style("reset", get_template_directory_uri() . "/style/reset.css");
	wp_enqueue_style("superfish", get_template_directory_uri() ."/style/superfish.css");
	wp_enqueue_style("prettyPhoto", get_template_directory_uri() ."/style/prettyPhoto.css");
	//wp_enqueue_style("jquery-fancybox", get_template_directory_uri() ."/style/fancybox/jquery.fancybox.css");
	wp_enqueue_style("jquery-qtip", get_template_directory_uri() ."/style/jquery.qtip.css");
	if(((int)$theme_options["animations"] || !isset($theme_options["animations"])) && (isset($_COOKIE["mc_animations"]) && $_COOKIE["mc_animations"]==1 || !isset($_COOKIE["mc_animations"])))
	{
		wp_enqueue_style("animations", get_template_directory_uri() ."/style/animations.css");
		if(is_rtl())
			wp_enqueue_style("animations", get_template_directory_uri() ."/style/animations_rtl.css");
	}
	wp_enqueue_style("main-style", get_stylesheet_uri());
	if((int)$theme_options["responsive"])
		wp_enqueue_style("responsive", get_template_directory_uri() ."/style/responsive.css");
	else
		wp_enqueue_style("no-responsive", get_template_directory_uri() ."/style/no_responsive.css");
	
	if(function_exists("is_plugin_active") && is_plugin_active('woocommerce/woocommerce.php'))
	{
		wp_enqueue_style("woocommerce-custom", get_template_directory_uri() ."/woocommerce/style.css");
		if((int)$theme_options["responsive"])
			wp_enqueue_style("woocommerce-responsive", get_template_directory_uri() ."/woocommerce/responsive.css");
		else
			wp_dequeue_style("woocommerce-smallscreen");
		if(is_rtl())
			wp_enqueue_style("woocommerce-rtl", get_template_directory_uri() ."/woocommerce/rtl.css");
	}
	wp_enqueue_style("mc-features", get_template_directory_uri() ."/fonts/features/style.css");
	wp_enqueue_style("mc-template", get_template_directory_uri() ."/fonts/template/style.css");
	wp_enqueue_style("mc-social", get_template_directory_uri() ."/fonts/social/style.css");
	wp_enqueue_style("custom", get_template_directory_uri() ."/custom.css");
	//js
	wp_enqueue_script("jquery", false, array(), false, true);
	wp_enqueue_script("jquery-ui-core", false, array("jquery"), false, true);
	wp_enqueue_script("jquery-ui-accordion", false, array("jquery"), false, true);
	wp_enqueue_script("jquery-ui-tabs", false, array("jquery"), false, true);
	wp_enqueue_script("jquery-ui-datepicker", false, array("jquery"), false, true);
	wp_enqueue_script("jquery-ba-bqq", get_template_directory_uri() ."/js/jquery.ba-bbq.min.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-history", get_template_directory_uri() ."/js/jquery.history.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-easing", get_template_directory_uri() ."/js/jquery.easing.1.3.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-carouFredSel", get_template_directory_uri() ."/js/jquery.carouFredSel-6.2.1-packed.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-sliderControl", get_template_directory_uri() ."/js/jquery.sliderControl.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-timeago", get_template_directory_uri() ."/js/jquery.timeago.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-hint", get_template_directory_uri() ."/js/jquery.hint.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-isotope", get_template_directory_uri() ."/js/jquery.isotope-packed.js", array("jquery"), false, true);
	//if((is_rtl() || (isset($theme_options['direction']) && $theme_options["direction"]=='rtl')) && ((isset($_COOKIE["mc_direction"]) && $_COOKIE["mc_direction"]!="LTR") || !isset($_COOKIE["mc_direction"])))
	//	wp_enqueue_script("rtl-js", get_template_directory_uri() ."/js/rtl.js", array("jquery", "jquery-isotope"), "jquery-isotope-masonry", false, true);
	wp_enqueue_script("jquery-prettyPhoto", get_template_directory_uri() ."/js/jquery.prettyPhoto.js", array("jquery"), false, true);
	//wp_enqueue_script("jquery-fancybox", get_template_directory_uri() ."/js/jquery.fancybox-1.3.4.pack.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-qtip", get_template_directory_uri() ."/js/jquery.qtip.min.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-block-ui", get_template_directory_uri() ."/js/jquery.blockUI.js", array("jquery"), false, true);
	wp_enqueue_script("google-maps-v3", "//maps.google.com/maps/api/js" . ($theme_options["google_api_code"]!="" ? "?key=" . esc_attr($theme_options["google_api_code"]) : ""), false, array(), false, true);

	wp_enqueue_script("theme-main", get_template_directory_uri() ."/js/main.js", array("jquery", "jquery-ui-core", "jquery-ui-accordion", "jquery-ui-tabs"), false, true);
	
	//ajaxurl
	$data["ajaxurl"] = admin_url("admin-ajax.php");
	//themename
	$data["themename"] = $themename;
	//home url
	$data["home_url"] = get_home_url();
	//is_rtl
	$data["is_rtl"] = ((is_rtl() || $theme_options["direction"]=='rtl') && ((isset($_COOKIE["mc_direction"]) && $_COOKIE["mc_direction"]!="LTR") || !isset($_COOKIE["mc_direction"]))) || (isset($_COOKIE["mc_direction"]) && $_COOKIE["mc_direction"]=="RTL") ? 1 : 0;
	
	//pass data to javascript
	$params = array(
		'l10n_print_after' => 'config = ' . json_encode($data) . ';'
	);
	wp_localize_script("theme-main", "config", $params);
}
add_action("wp_enqueue_scripts", "theme_enqueue_scripts");

//function to display number of posts
function getPostViews($postID)
{
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count=='')
	{
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }
    return (int)$count;
}

//function to count views
function setPostViews($postID) 
{
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count=='')
	{
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, 1);
    }
	else
	{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
/* --- phpMailer config --- */
function mc_phpmailer_init(PHPMailer $mail) 
{
	global $theme_options;
	$mail->CharSet='UTF-8';

	$smtp = $theme_options["cf_smtp_host"];
	if(!empty($smtp))
	{
		$mail->IsSMTP();
		$mail->SMTPAuth = true; 
		//$mail->SMTPDebug = 2;
		$mail->Host = $theme_options["cf_smtp_host"];
		$mail->Username = $theme_options["cf_smtp_username"];
		$mail->Password = $theme_options["cf_smtp_password"];
		if((int)$theme_options["cf_smtp_port"]>0)
			$mail->Port = (int)$theme_options["cf_smtp_port"];
		$mail->SMTPSecure = $theme_options["cf_smtp_secure"];
	}
}
function mc_custom_template_for_vc() 
{
    $data = array();
    $data['name'] = __('Single Post Template', 'medicenter');
    $data['weight'] = 0;
    $data['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/admin/images/visual_composer/layout.png');
    $data['custom_class'] = 'custom_template_for_vc_custom_template';
    $data['content'] = <<<CONTENT
        [vc_row el_position="first last"][vc_column width="2/3"][single_post columns="1" show_post_title="1" show_post_featured_image="1" show_post_categories="1" show_post_author="1" comments="1" comments_form_animation="slideRight" show_post_comments_label="1" post_date_animation="slideRight" post_comments_animation="slideUp" post_comments_animation_duration="300" post_comments_animation_delay="500" top_margin="page-margin-top" el_position="first last"][/vc_column][vc_column width="1/3"][vc_widget_sidebar top_margin="page-margin-top" sidebar_id="sidebar-blog" el_position="first"][box_header title="Photostream" bottom_border="1" animation="1" top_margin="page-margin-top"][photostream images="21,15,16,17,18,19,1816,1817" images_loop="1"][vc_widget_sidebar top_margin="page-margin-top" sidebar_id="sidebar-blog-2" el_position="last"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates($data);
	
	$data = array();
    $data['name'] = __('Blog Template', 'medicenter');
    $data['weight'] = 0;
    $data['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/admin/images/visual_composer/layout.png');
    $data['custom_class'] = 'custom_template_for_vc_custom_template';
    $data['content'] = <<<CONTENT
        [vc_row el_position="first last"][vc_column width="2/3"][blog mc_pagination="1" items_per_page="1" layout_type="1" ids="-" category="-" order_by="date" show_post_title="1" read_more="1" show_post_categories="1" show_post_author="1" show_post_comments_box="1" show_post_comments_label="1" post_date_animation="slideRight" post_comments_animation="slideUp" post_comments_animation_duration="300" post_comments_animation_delay="500" show_post_date_footer="0" show_post_comments_footer="0" top_margin="page-margin-top" el_position="first last"][/vc_column][vc_column width="1/3"][vc_widget_sidebar top_margin="page-margin-top" sidebar_id="sidebar-blog" el_position="first"][box_header title="Photostream" bottom_border="1" animation="1" top_margin="page-margin-top"][photostream images="21,15,16,17,18,19,1816,1817" images_loop="1"][vc_widget_sidebar top_margin="page-margin-top" sidebar_id="sidebar-blog-2" el_position="last"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates($data);
	
	$data = array();
    $data['name'] = __('Search Template', 'medicenter');
    $data['weight'] = 0;
    $data['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/admin/images/visual_composer/layout.png');
    $data['custom_class'] = 'custom_template_for_vc_custom_template';
    $data['content'] = <<<CONTENT
        [vc_row el_position="first last"][vc_column width="2/3"][blog mc_pagination="1" items_per_page="4" layout_type="1" ids="-" category="-" show_post_title="1" read_more="1" show_post_categories="1" show_post_author="1" show_post_comments_box="1" show_post_comments_label="0" show_post_date_footer="0" show_post_comments_footer="0" top_margin="page-margin-top" el_position="first last"][/vc_column][vc_column width="1/3"][vc_widget_sidebar top_margin="page-margin-top" sidebar_id="sidebar-blog" el_position="first"][box_header title="Photostream" bottom_border="1" animation="0" top_margin="page-margin-top"][photostream images="21,15,16,17,18,19,1816,1817" images_loop="1"][vc_widget_sidebar top_margin="page-margin-top" sidebar_id="sidebar-blog-2" el_position="last"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates($data);
	
	$data = array();
    $data['name'] = __('Single Doctor Template', 'medicenter');
    $data['weight'] = 0;
    $data['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/admin/images/visual_composer/layout.png');
    $data['custom_class'] = 'custom_template_for_vc_custom_template';
    $data['content'] = <<<CONTENT
        [vc_row top_margin="page-margin-top"][vc_column][single_doctor][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates($data);
	
	$data = array();
    $data['name'] = __('Single Features Template', 'medicenter');
    $data['weight'] = 0;
    $data['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/admin/images/visual_composer/layout.png');
    $data['custom_class'] = 'custom_template_for_vc_custom_template';
    $data['content'] = <<<CONTENT
        [vc_row el_position="first last"][vc_column width="2/3"][single_post featured_image_size="mc_blog-post-thumb" columns="2" show_post_title="1" show_post_featured_image="1" show_post_categories="0" show_post_author="0" comments="0" show_post_date_box="0" show_post_comments_box="0" show_post_comments_label="0" top_margin="page-margin-top" el_position="first last"][/vc_column][vc_column width="1/3"][box_header title="Features" bottom_border="1" animation="0" top_margin="page-margin-top" el_position="first"][features ids="964,963,965,966" headers="0" headers_links="1" read_more="1" icon_links="1" top_margin="page-margin-top"][vc_widget_sidebar top_margin="page-margin-top" sidebar_id="sidebar-departments-2" el_position="last"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates($data);
	
	$data = array();
    $data['name'] = __('Doctor Page Layout', 'medicenter');
    $data['weight'] = 0;
    $data['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/admin/images/visual_composer/layout.png');
    $data['custom_class'] = 'custom_template_for_vc_custom_template';
    $data['content'] = <<<CONTENT
        [vc_row el_position="first last"][vc_column width="1/3"][doctor_box title_box="1" display_social_icons="1" headers="1" headers_links="1" headers_border="1" show_subtitle="1" show_excerpt="1" show_social_icons="1" show_featured_image="1" featured_image_links="1"][/vc_column][vc_column width="2/3"][box_header title="Ann Blyumin, Prof." type="h2" bottom_border="1" animation="1"][vc_row_inner][vc_column_inner width="1/2"][vc_column_text el_class="description"]Dr. Adams is certified by the American Board in Internal Medicine and in hematology and medical oncology. He currently serves as a consultant in medical oncology at Medicenter Hospital and as the program director for the National Healthcare Group Medical Oncology Residency Program, which is run in collaboration with Medicenter Hospital.[/vc_column_text][vc_button title="TIMETABLE" icon="template-arrow-horizontal-1-after"][/vc_column_inner][vc_column_inner width="1/2"][doctor_description_box][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row top_margin="page-margin-top"][vc_column][vc_separator][/vc_column][/vc_row][vc_row top_margin="page-margin-top"][vc_column width="1/3"][features ids="936" type="small" headers="1" headers_links="1" read_more="0" icon_links="1"][/vc_column][vc_column width="1/3"][features ids="281" type="small" headers="1" headers_links="1" read_more="0" icon_links="1"][/vc_column][vc_column width="1/3"][features ids="925" type="small" headers="1" headers_links="1" read_more="0" icon_links="1"][/vc_column][/vc_row][vc_row top_margin="page-margin-top"][vc_column][vc_separator][/vc_column][/vc_row][vc_row top_margin="page-margin-top"][vc_column width="2/3"][box_header title="Services" bottom_border="1" animation="1"][vc_column_text el_class="description"]Dr. Adams is certified by the American Board in Internal Medicine and in hematology and medical oncology. He currently serves as a consultant in medical oncology at Medicenter Hospital and as the program director for the National Healthcare Group Medical Oncology Residency Program, which is run in collaboration with Medicenter Hospital.[/vc_column_text][vc_row_inner top_margin="page-margin-top"][vc_column_inner width="1/2"][items_list animation="0" additembutton="" read_more="0"][item type="items" value="$350" url="" url_target="new_window" icon="" text_color="" value_color="" border_color=""]Colonoscopy[/item][item type="items" value="$275" url="" url_target="new_window" icon="" text_color="" value_color="" border_color=""]Gastroscopy[/item][item type="items" value="$175" url="" url_target="new_window" icon="" text_color="" value_color="" border_color=""]Allergy Testing[/item][item type="items" value="$100" url="" url_target="new_window" icon="" text_color="" value_color="" border_color=""]Molecule[/item][/items_list][/vc_column_inner][vc_column_inner width="1/2"][items_list animation="0" additembutton="" read_more="0"][item type="items" value="$350" url="" url_target="new_window" icon="" text_color="" value_color="" border_color=""]CT Scan[/item][item type="items" value="$275" url="" url_target="new_window" icon="" text_color="" value_color="" border_color=""]Bronchoscopy[/item][/items_list][/vc_column_inner][/vc_row_inner][vc_row_inner top_margin="page-margin-top"][vc_column_inner][box_header title="Medical Education" bottom_border="1" animation="1"][timeline_item label="SINCE 2005" label_position="" title="Royal College of Surgeons of Edinburg" subtitle="HEAD OF THE DEPARTMENT" animations="1" top_margin="page-margin-top"]Paetos dignissim at cursus elefeind norma arcu. Pellentesque accumsan est in tempus etos ullamcorper, sem quam suscipit lacus maecenas tortor.[/timeline_item][timeline_item label="SINCE 2002" title="Fellowship, Royal College of Physicians &amp; Surgeons of Glasgow" subtitle="DOCTOR" animations="1"]Paetos dignissim at cursus elefeind norma arcu. Pellentesque accumsan est in tempus etos ullamcorper, sem quam suscipit lacus maecenas tortor.[/timeline_item][timeline_item label="1998 - 2002" title="Residency, St. Vincent's University Hospital" subtitle="INTERN" animations="1"]Paetos dignissim at cursus elefeind norma arcu. Pellentesque accumsan est in tempus etos ullamcorper, sem quam suscipit lacus maecenas tortor.[/timeline_item][/vc_column_inner][/vc_row_inner][/vc_column][vc_column width="1/3"][vc_widget_sidebar sidebar_id="sidebar-home-right-style-2"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates($data);
}
if(is_plugin_active("js_composer/js_composer.php") && function_exists("vc_set_default_editor_post_types"))
	add_action("vc_load_default_templates_action", "mc_custom_template_for_vc");
//add new mimes for upload dummy content files (code can be removed after dummy content import)
function custom_upload_files($mimes) 
{
    $mimes = array_merge($mimes, array('xml' => 'application/xml'), array('json' => 'application/json'), array('zip' => 'application/zip'), array('gz' => 'application/x-gzip'), array('ico' => 'image/x-icon'));
    return $mimes;
}
function theme_image_sizes($sizes)
{
	global $themename;
	$addsizes = array(
		"blog-post-thumb" => __("Blog post thumbnail", 'medicenter'),
		$themename . "-gallery-image" => __("Gallery image", 'medicenter'),
		$themename . "-gallery-thumb" => __("Gallery thumbnail", 'medicenter'),
		$themename . "-small-thumb" => __("Small thumbnail", 'medicenter')
	);
	$newsizes = array_merge($sizes, $addsizes);
	return $newsizes;
}
if(!function_exists('_wp_render_title_tag')) 
{
    function cs_theme_slug_render_title() 
	{
		echo '<title>'. wp_title('-', true, 'right') . '</title>';
    }
}
function mc_wp_title_filter($title, $sep)
{
	//$title = get_bloginfo('name') . " | " . (is_home() || is_front_page() ? get_bloginfo('description') : $title);
	return $title;
}
//excerpt
function theme_excerpt_more($more) 
{
	return '';
}
function medicenter_filter_update_vc_plugin($date) 
{
    if(!empty($date->checked["js_composer/js_composer.php"]))
        unset($date->checked["js_composer/js_composer.php"]);
    if(!empty($date->response["js_composer/js_composer.php"]))
        unset($date->response["js_composer/js_composer.php"]);
    return $date;
}

/* --- Theme WooCommerce Custom Filters Functions --- */
function mc_woo_custom_override_pagination_args($args) 
{
	$args['prev_text'] = __('&lsaquo;', 'medicenter');
	$args['next_text'] = __('&rsaquo;', 'medicenter');
	return $args;
}
function mc_woo_custom_cart_button_text() 
{
	return __('ADD TO CART', 'medicenter');
}
if(!function_exists('loop_columns')) 
{
	function mc_woo_custom_loop_columns() 
	{
		return 3; // 3 products per row
	}
}
function mc_woo_custom_product_description_heading() 
{
    return '';
}
function mc_woo_custom_show_page_title()
{
	return false;
}
function mc_woo_custom_override_checkout_fields($fields) 
{
	$fields['billing']['billing_first_name']['placeholder'] = 'First Name';
	$fields['billing']['billing_last_name']['placeholder'] = 'Last Name';
	$fields['billing']['billing_company']['placeholder'] = 'Company Name';
	$fields['billing']['billing_email']['placeholder'] = 'Email Address';
	$fields['billing']['billing_phone']['placeholder'] = 'Phone';
	return $fields;
}
function mc_woo_custom_review_gravatar_size()
{
	return 100;
}

function get_time_iso8601() 
{
	$offset = get_option('gmt_offset');
	$timezone = ($offset < 0 ? '-' : '+') . (abs($offset)<10 ? '0'.abs($offset) : abs($offset)) . '00' ;
	return get_the_time('Y-m-d\TH:i:s') . $timezone;					
}

function theme_direction() 
{
	global $wp_locale, $theme_options;
	if(isset($theme_options['direction']) || (isset($_COOKIE["mc_direction"]) && ($_COOKIE["mc_direction"]=="LTR" || $_COOKIE["mc_direction"]=="RTL")))
	{
		if($theme_options['direction']=='default' && empty($_COOKIE["mc_direction"]))
			return;
		$wp_locale->text_direction = ((!empty($theme_options['direction']) && $theme_options['direction']=='rtl') && (empty($_COOKIE["mc_direction"]) || $_COOKIE["mc_direction"]!="LTR")) || (!empty($_COOKIE["mc_direction"]) && $_COOKIE["mc_direction"]=="RTL") ? 'rtl' : 'ltr';
	}
}
add_action("after_setup_theme", "theme_direction");

// default locate_template() method returns file PATH, we need file URL for javascript and css
//function locate_template_uri($file)
//{
//    $website_path = str_replace("\\", "/", realpath(dirname($_SERVER["SCRIPT_FILENAME"])));
//    $site_url = site_url();
//    $file_path = str_replace("\\", "/", locate_template(ltrim($file, "/")));
//    $file_url = str_replace($website_path, $site_url, $file_path);
//    return $file_url;
//}
function mc_get_theme_file($file)
{
	if(file_exists(get_stylesheet_directory() . $file))
        require_once(get_stylesheet_directory() . $file);
    else
        require_once(get_template_directory() . $file);
}

//medicenter get_font_subsets
function mc_ajax_get_font_subsets()
{
	if($_POST["font"]!="")
	{
		$subsets = '';
		$fontExplode = explode(":", $_POST["font"]);
		$subsets_array = mc_get_google_font_subset($fontExplode[0]);
		
		foreach($subsets_array as $subset)
			$subsets .= '<option value="' . $subset . '">' . $subset . '</option>';
		
		echo "mc_start" . $subsets . "mc_end";
	}
	exit();
}
add_action('wp_ajax_medicenter_get_font_subsets', 'mc_ajax_get_font_subsets');

/**
 * Returns array of Google Fonts
 * @return array of Google Fonts
 */
function mc_get_google_fonts()
{
	//get google fonts
	$fontsArray = get_option("medicenter_google_fonts");
	//update if option doesn't exist or it was modified more than 2 weeks ago
	if($fontsArray===FALSE || (time()-$fontsArray->last_update>2*7*24*60*60))
	{
		$google_api_url = 'http://quanticalabs.com/.tools/GoogleFont/font.txt';
		$fontsJson = wp_remote_retrieve_body(wp_remote_get($google_api_url, array('sslverify' => false )));
		$fontsArray = json_decode($fontsJson);
		$fontsArray->last_update = time();		
		update_option("medicenter_google_fonts", $fontsArray);
	}
	return $fontsArray;
}

/**
 * Returns array of subsets for provided Google Font
 * @param type $font - Google font
 * @return array of subsets for provided Google Font
 */
function mc_get_google_font_subset($font)
{
	$subsets = array();
	//get google fonts
	$fontsArray = mc_get_google_fonts();		
	$fontsCount = count($fontsArray->items);
	for($i=0; $i<$fontsCount; $i++)
	{
		if($fontsArray->items[$i]->family==$font)
		{
			for($j=0, $max=count($fontsArray->items[$i]->subsets); $j<$max; $j++)
			{
				$subsets[] = $fontsArray->items[$i]->subsets[$j];
			}
			break;
		}
	}
	return $subsets;
}
?>