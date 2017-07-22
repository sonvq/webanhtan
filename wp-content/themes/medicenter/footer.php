			<?php global $theme_options, $themename; ?>
			<div class="footer-container">
				<div class="footer">
					<ul class="footer-banner-box-container clearfix">
						<?php
						$sidebar_footer_top = get_post(get_post_meta(get_the_ID(), "page_sidebar_footer_top", true));
						if(isset($sidebar_footer_top) && !(int)get_post_meta($sidebar_footer_top->ID, "hidden", true) && is_active_sidebar($sidebar_footer_top->post_name))
							dynamic_sidebar($sidebar_footer_top->post_name);
						?>
					</ul>
					<div class="footer-box-container vc_row wpb_row vc_row-fluid clearfix">
						<?php
						$sidebar = get_post(get_post_meta(get_the_ID(), "page_sidebar_footer_bottom", true));
						if(isset($sidebar) && !(int)get_post_meta($sidebar->ID, "hidden", true) && is_active_sidebar($sidebar->post_name))
							dynamic_sidebar($sidebar->post_name);
						?>
					</div>
				</div>
			</div>
			<div class="copyright-area-container">
			<?php 
			$locations = get_nav_menu_locations();
			if(isset($locations["footer-menu"]))
				$footer_menu_object = get_term($locations["footer-menu"], "nav_menu");
			if($theme_options["footer_text_left"]!="" || (has_nav_menu("footer-menu") && $footer_menu_object->count>0)): ?>
				<div class="copyright-area clearfix">
					<?php if($theme_options["footer_text_left"]!=""): ?>
					<div class="copyright-text">
					<?php
					echo do_shortcode($theme_options["footer_text_left"]);
					?>
					</div>
					<?php
					endif;
					dynamic_sidebar('sidebar-copyright-area');
					if(has_nav_menu("footer-menu") && $footer_menu_object->count>0) 
					{
						wp_nav_menu(array(
							"theme_location" => "footer-menu",
							"menu_class" => "footer-menu"
						));
					}
					?>
				</div>
				<?php endif; ?>
			</div>
		</div>
		<?php if((int)$theme_options["scroll_top"]): ?>
		<a href="#top" class="scroll-top animated-element template-arrow-vertical-3" title="<?php esc_html_e("Scroll to top", 'medicenter'); ?>"></a>
		<?php
		endif;
		if((int)$theme_options["layout_picker"])
			mc_get_theme_file("/style_selector/style_selector.php");		
		wp_footer();
		?>
	</body>
</html>