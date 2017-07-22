<?php
global $themename;
//contact form
function theme_contact_form_shortcode($atts)
{
	extract(shortcode_atts(array(
		"id" => "contact_form",
		"header" => __("Online Appointment Form ", 'medicenter'),
		"animation" => 0,
		"department_select_box" => 1,
		"department_select_box_title" => __("Select Department", 'medicenter'),
		"top_margin" => "none"
	), $atts));
	
	$output = "";
	if($header!="")
		$output .= '<h3 class="box-header' . ((int)$animation ? ' animation-slide' : '') . ($top_margin!="none" ? ' ' . $top_margin : '') . '">' . $header . '</h3>';
	$output .= '<form class="contact-form ' . ($top_margin!="none" && $header!="" ? esc_attr($top_margin) : '') . '" id="' . esc_attr($id) . '" method="post" action="">';
	if((int)$department_select_box)
	{
		//get departments list
		$departments_list = get_posts(array(
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
			'post_type' => 'departments'
		));
		if(count($departments_list))
		{
			$output .= '<ul class="clearfix tabs-box-navigation sf-menu">
				<li class="tabs-box-navigation-selected wide template-plus-2-after" aria-haspopup="true">
					<input type="hidden" name="department" value="" />
					<span>' . $department_select_box_title . '</span>
					<ul class="sub-menu">';
			foreach($departments_list as $department)
				$output .= '<li><a href="#' . urldecode($department->post_name) . '" title="' . esc_attr($department->post_title) . '">' . $department->post_title . '</a></li>';
			$output .= '</ul>
				</ul>';
			$output .= '<input type="hidden" id="department_select_box_title" value="' . esc_attr($department_select_box_title) . '">';
		}
	}
	$output .= '<div class="vc_row wpb_row vc_inner">
			<fieldset class="vc_col-sm-6 wpb_column vc_column_container">
			<label>' . __("FIRST NAME", 'medicenter') . '</label>
				<div class="block">
					<input class="text_input" name="first_name" type="text" value="" tabindex="1">
				</div>
				<label>' . __("DATE OF BIRTH (mm/dd/yyyy)", 'medicenter') . '</label>
				<div class="block">
					<input class="text_input" type="text" name="date_of_birth" value="" tabindex="3">
				</div>
				<label>' . __("PHONE NUMBER", 'medicenter') . '</label>
				<div class="block">
					<input class="text_input" name="phone_number" type="text" value="" tabindex="5">
				</div>
			</fieldset>
			<fieldset class="vc_col-sm-6 wpb_column vc_column_container">
				<label>' . __("LAST NAME", 'medicenter') . '</label>
				<div class="block">
					<input class="text_input" type="text" name="last_name" value="" tabindex="2">
				</div>
				<label>' . __("SOCIAL SECURITY NUMBER", 'medicenter') . '</label>
				<div class="block">
					<input class="text_input" type="text" name="social_security_number" value="" tabindex="4">
				</div>
				<label>' . __("E-MAIL", 'medicenter') . '</label>
				<div class="block">
					<input class="text_input" type="text" name="email" value="" tabindex="6">
				</div>
			</fieldset>
		</div>
		<div class="vc_row wpb_row vc_inner">
			<fieldset style="clear:both;">
				<label>' . __("REASON OF APPOINTMENT", 'medicenter') . '</label>
				<div class="block">
					<textarea name="message" tabindex="7"></textarea>
				</div>
			</fieldset>
		</div>
		<div class="vc_row wpb_row vc_inner">
			<fieldset class="vc_col-sm-8 wpb_column vc_column_container">
				<p>' . __("We will contact you within one business day.", 'medicenter') . '</p>
			</fieldset>
			<fieldset class="vc_col-sm-4 wpb_column vc_column_container margin-top-0">
				<input type="hidden" name="action" value="theme_contact_form" />
				<input type="hidden" name="id" value="' . $id . '" />
				<input type="submit" name="submit" value="' . __("SEND", 'medicenter') . '" class="more mc-button" />
			</fieldset>
		</div>
	</form>';
	return $output;
}
add_shortcode($themename . "_contact_form", "theme_contact_form_shortcode");

//visual composer
function theme_contact_form_vc_init()
{
	vc_map( array(
		"name" => __("Contact form", 'medicenter'),
		"base" => "medicenter_contact_form",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-contact-form",
		"category" => __('MediCenter', 'medicenter'),
		"params" => array(
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Id", 'medicenter'),
				"param_name" => "id",
				"value" => "contact_form",
				"description" => __("Please provide unique id for each contact form on the same page/post", 'medicenter')
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Header", 'medicenter'),
				"param_name" => "header",
				"value" => __("Online Appointment Form ", 'medicenter')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Header border animation", 'medicenter'),
				"param_name" => "animation",
				"value" => array(__("no", 'medicenter') => 0,  __("yes", 'medicenter') => 1)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Display department select box", 'medicenter'),
				"param_name" => "department_select_box",
				"value" => array(__("yes", 'medicenter') => 1, __("no", 'medicenter') => 0)
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Department select box title", 'medicenter'),
				"param_name" => "department_select_box_title",
				"value" => __("Select Department", 'medicenter'),
				"dependency" => Array('element' => "department_select_box", 'value' => '1')
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
add_action("init", "theme_contact_form_vc_init");

//contact form submit
function theme_contact_form()
{
	ob_start();
	global $theme_options;

    $result = array();
	$result["isOk"] = true;
	if($_POST["first_name"]!="" && $_POST["last_name"]!="" && $_POST["email"]!="" && preg_match("#^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,12})$#", $_POST["email"]) && $_POST["message"]!="")
	{
		$values = array(
			"department" => $_POST["department"],
			"first_name" => $_POST["first_name"],
			"last_name" => $_POST["last_name"],
			"date_of_birth" => $_POST["date_of_birth"],
			"phone_number" => $_POST["phone_number"],
			"social_security_number" => $_POST["social_security_number"],
			"email" => $_POST["email"],
			"message" => $_POST["message"]
		);
		if((bool)ini_get("magic_quotes_gpc")) 
			$values = array_map("stripslashes", $values);
		$values = array_map("htmlspecialchars", $values);
		
		$headers[] = 'Reply-To: ' . $values["first_name"] . " " . $values["last_name"] . ' <' . $values["email"] . '>' . "\r\n";
		$headers[] = 'From: ' . $theme_options["cf_admin_name"] . ' <' . $theme_options["cf_admin_email"] . '>' . "\r\n";
		$headers[] = 'Content-type: text/html';
		$subject = $theme_options["cf_email_subject"];
		$subject = str_replace("[department]", $values["department"], $subject);
		$subject = str_replace("[first_name]", $values["first_name"], $subject);
		$subject = str_replace("[last_name]", $values["last_name"], $subject);
		$subject = str_replace("[date]", $values["date_of_birth"], $subject); 
		$subject = str_replace("[social_security_number]", $values["social_security_number"], $subject);
		$subject = str_replace("[phone_number]", $values["phone_number"], $subject);
		$subject = str_replace("[email]", $values["email"], $subject);
		$subject = str_replace("[message]", $values["message"], $subject);
		$mail->Subject = $subject;
		$body = $theme_options["cf_template"];
		$body = str_replace("[department]", $values["department"], $body);
		$body = str_replace("[first_name]", $values["first_name"], $body);
		$body = str_replace("[last_name]", $values["last_name"], $body);
		$body = str_replace("[date]", $values["date_of_birth"], $body); 
		$body = str_replace("[social_security_number]", $values["social_security_number"], $body);
		$body = str_replace("[phone_number]", $values["phone_number"], $body);
		$body = str_replace("[email]", $values["email"], $body);
		$body = str_replace("[message]", $values["message"], $body);

		if(wp_mail($theme_options["cf_admin_name"] . ' <' . $theme_options["cf_admin_email"] . '>', $subject, $body, $headers))
			$result["submit_message"] = __("Thank you for contacting us", 'medicenter');
		else
		{
			$result["isOk"] = false;
			$result["error_message"] = $GLOBALS['phpmailer']->ErrorInfo;
			$result["submit_message"] = __("Sorry, we can't send this message", 'medicenter');
		}
	}
	else
	{
		$result["isOk"] = false;
		if($_POST["first_name"]=="")
			$result["error_first_name"] = __("Please enter your first name.", 'medicenter');
		if($_POST["last_name"]=="")
			$result["error_last_name"] = __("Please enter your last name.", 'medicenter');
		if($_POST["email"]=="" || !preg_match("#^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,12})$#", $_POST["email"]))
			$result["error_email"] = __("Please enter valid e-mail.", 'medicenter');
		if($_POST["message"]=="")
			$result["error_message"] = __("Please enter your message.", 'medicenter');
	}
	$system_message = ob_get_clean();
	$result["system_message"] = $system_message;
	echo @json_encode($result);
	exit();
}
add_action("wp_ajax_theme_contact_form", "theme_contact_form");
add_action("wp_ajax_nopriv_theme_contact_form", "theme_contact_form");
?>