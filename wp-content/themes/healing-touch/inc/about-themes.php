<?php
/**
 * Healing Touch About Theme
 *
 * @package Healing Touch
 */
 
//about theme info
add_action( 'admin_menu', 'healing_touch_abouttheme' );
function healing_touch_abouttheme() {    	
	add_theme_page( __('About Theme', 'healing-touch'), __('About Theme', 'healing-touch'), 'edit_theme_options', 'healing_touch_guide', 'healing_touch_mostrar_guide');   
} 

//guidline for about theme
function healing_touch_mostrar_guide() { 
	//custom function about theme customizer
	$return = add_query_arg( array()) ;
?>

<style type="text/css">
@media screen and (min-width: 800px) {
.col-left {float:left; width: 65%; padding: 1%;}
.col-right {float:right; width: 30%; padding:1%; border-left:1px solid #DDDDDD; }
}
</style>

<div class="wrapper-info">
	<div class="col-left">
   		   <div style="font-size:16px; font-weight:bold; padding-bottom:5px; border-bottom:1px solid #ccc;">
			  <?php esc_attr_e('About Theme Info', 'healing-touch'); ?>
		   </div>
          <p><?php esc_attr_e('Healing Touch is a responsive WordPress theme catering to dentists, hospitals, medical, doctors, and any other medicine field. This theme uses customizr and is Google mobile friendly. Comes compatible with WooCommerce, and contact form 7. It is a multipurpose theme and can be used by other industries as well. Homepage is easy to set up and use.','healing-touch'); ?></p>
		  <a href="<?php echo SKT_PRO_THEME_URL; ?>"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/free-vs-pro.png" alt="" /></a>
	</div><!-- .col-left -->
	
	<div class="col-right">			
			<div style="text-align:center; font-weight:bold;">
				<hr />
				<a href="<?php echo SKT_LIVE_DEMO; ?>" target="_blank"><?php esc_attr_e('Live Demo', 'healing-touch'); ?></a> | 
				<a href="<?php echo SKT_PRO_THEME_URL; ?>"><?php esc_attr_e('Buy Pro', 'healing-touch'); ?></a> | 
				<a href="<?php echo SKT_THEME_DOC; ?>" target="_blank"><?php esc_attr_e('Documentation', 'healing-touch'); ?></a>
                <div style="height:5px"></div>
				<hr />                
                <a href="<?php echo SKT_THEME_URL; ?>" target="_blank"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/sktskill.jpg" alt="" /></a>
			</div>		
	</div><!-- .col-right -->
</div><!-- .wrapper-info -->
<?php } ?>