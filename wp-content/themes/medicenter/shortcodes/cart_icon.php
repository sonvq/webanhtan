<?php
function theme_mc_cart_icon($atts)
{
	extract(shortcode_atts(array(
		"cart_items_number" => "yes",
		"icon_target" => "",
		"class" => "",
	), $atts));
	
	global $woocommerce;
	$result = "";
	if(is_plugin_active('woocommerce/woocommerce.php'))
	{
		ob_start();
		$cart_url = $woocommerce->cart->get_cart_url();
		?>
		<a <?php echo ($icon_target=="new_window" ? " target='_blank'" : ""); ?>href="<?php echo esc_url($cart_url);?>" class="template-cart <?php echo esc_attr($class);?>">&nbsp;<?php if($cart_items_number=="yes"): ?><span class="cart-items-number<?php echo (!(int)$woocommerce->cart->cart_contents_count ? ' cart-empty' : ''); ?>"><?php echo $woocommerce->cart->cart_contents_count; ?></span><?php endif;?></a>
		<?php
		$result = ob_get_clean();
	}
	return $result;
}
add_shortcode("mc_cart_icon", "theme_mc_cart_icon");
