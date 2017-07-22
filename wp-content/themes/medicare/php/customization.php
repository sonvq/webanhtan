<?php
if ( ! class_exists( 'BoldThemes_Customize_Default' ) ) {

	class BoldThemes_Customize_Default {

		// GENERAL SETTINGS	

		public static $logo = '';
		public static $alt_logo = '';
		public static $page_background = '';
		
		public static $menu_type = 'hRight';
		public static $boxed_menu = true;
		public static $below_menu = false;
		public static $top_tools_in_menu = false;

		public static $hide_headline = false;

		public static $sticky_header = false;
		public static $hide_menu = false;
		public static $template_skin = false;
		public static $footer_dark_skin = false;
	
		public static $sidebar = 'right';
		public static $sidebar_use_dash = true;
		
		public static $accent_color = '';
		public static $alter_color = '';

		public static $disable_preloader = false;
		public static $preloader_text = '';
		
		public static $autoplay_interval = '';

		public static $custom_css = '';
		public static $custom_js_top = '';
		public static $custom_js_bottom = '';
		
		public static $custom_text = '';
		
		public static $footer_page_slug = '';
		 
		// TYPO
		
		public static $body_font = 'no_change';
		public static $menu_font = 'no_change';
		public static $heading_font = 'no_change';
		public static $heading_supertitle_font = 'no_change';
		public static $heading_subtitle_font = 'no_change';
		

		
		// BLOG
		
		public static $blog_ghost_slider = false;
		public static $blog_grid_gallery_columns = '4';
		public static $blog_grid_gallery_gap = '0';
		public static $blog_single_view = 'standard';
		public static $blog_list_view = 'standard';
		public static $blog_author = true;
		public static $blog_date = true;
		public static $blog_side_info = true;
		public static $blog_author_info = false;
		public static $blog_share_facebook = true;
		public static $blog_share_twitter = true;
		public static $blog_share_google_plus = true;
		public static $blog_share_linkedin = true;
		public static $blog_share_vk = true;
		public static $blog_use_dash = true;
		public static $sticky_in_grid = false;
		public static $blog_settings_page_slug = '';
		
		// PORTFOLIO
		
		public static $pf_ghost_slider = true;
		public static $pf_grid_gallery_columns = '3';
		public static $pf_grid_gallery_gap = '5';
		public static $pf_single_view = 'standard';
		public static $pf_share_facebook = true;
		public static $pf_share_twitter = true;
		public static $pf_share_google_plus = true;
		public static $pf_share_linkedin = true;
		public static $pf_share_vk = true;
		public static $pf_use_dash = true;
		public static $pf_settings_page_slug = '';
		
		// SHOP
		
		public static $shop_share_facebook = true;
		public static $shop_share_twitter = true;
		public static $shop_share_google_plus = true;
		public static $shop_share_linkedin = true;
		public static $shop_share_vk = true;
		public static $shop_use_dash = true;
		public static $shop_settings_page_slug = '';
		
	}
}

if ( ! function_exists( 'boldthemes_get_option' ) ) {
	function boldthemes_get_option( $opt ) {

		global $boldthemes_options;
		global $boldthemes_page_options;

		if ( isset( BoldThemes_Customize_Default::$$opt ) ) {
			if ( isset( $_GET[ $opt ] ) ) {
				$ret = $_GET[ $opt ];
				if ( $ret === 'true' ) {
					$ret = true;
				} else if ( $ret === 'false' ) {
					$ret = false;
				}
				return $ret;
			}			
		}
		if ( $boldthemes_page_options !== null && array_key_exists( BoldThemesPFX . '_' . $opt, $boldthemes_page_options ) && $boldthemes_page_options[ BoldThemesPFX . '_' . $opt ] === 'null' ) {
			return BoldThemes_Customize_Default::$$opt;
		}
		if ( $boldthemes_page_options !== null && array_key_exists( BoldThemesPFX . '_' . $opt, $boldthemes_page_options ) ) {
			$ret = $boldthemes_page_options[ BoldThemesPFX . '_' . $opt ];
			if ( $ret === 'true' ) {
				$ret = true;
			} else if ( $ret === 'false' ) {
				$ret = false;
			}
			return $ret;
		}
		if ( $boldthemes_options !== null && $boldthemes_options !== false && array_key_exists( $opt, $boldthemes_options ) ) {
			$ret = $boldthemes_options[ $opt ];
			if ( $ret === 'true' ) {
				$ret = true;
			} else if ( $ret === 'false' ) {
				$ret = false;
			}
			return $ret;
		} else { 
			if ( $boldthemes_options !== null ) {
				return BoldThemes_Customize_Default::$$opt;
			} else {
				$boldthemes_options = get_option( BoldThemesPFX . '_theme_options' );
				if ( is_array( $boldthemes_options ) && array_key_exists( $opt, $boldthemes_options ) ) {
					$ret = $boldthemes_options[ $opt ];
					if ( $ret === 'true' ) {
						$ret = true;
					} else if ( $ret === 'false' ) {
						$ret = false;
					}
					return $ret;
				} else {
					return BoldThemes_Customize_Default::$$opt;
				}
			}
		}

	}
}

if ( ! function_exists( 'boldthemes_logo' ) ) {
	function boldthemes_logo( $type = 'header' ) {
		
		$logo = boldthemes_get_option( 'logo' );
		$alt_logo = boldthemes_get_option( 'alt_logo' );
		
		if ( strpos( $logo, '/wp-content' ) === 0 ) {
			$logo = get_site_url() . $logo;
		}
		
		$hw = '';
		
		if ( $logo != '' ) {
			$logo_size = @getimagesize( $logo );
			if ( $logo_size[1] > 0 ) {
				$hw = $logo_size[0] / $logo_size[1];
			}
		}

		$home_link = home_url( '/' );
		if ( $logo != '' && $logo != ' ' ) {
			if ( $type == 'header' ) {
				echo '<a href="' . esc_url_raw( $home_link ) . '"><img class="btMainLogo" data-hw="' . $hw . '" src="' . esc_url_raw( $logo ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '">';
				if ( $alt_logo != '' && $alt_logo != ' ' ) echo '<img class="btAltLogo" src="' . esc_url_raw( $alt_logo ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '">';
				echo '</a>';
			} else if ( $type == 'footer' ) {
				echo '<a href="' . esc_url_raw( $home_link ) . '"><img src="' . esc_url_raw( $logo ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '"></a>';
			} else if ( $type == 'preloader' ) {
				echo '<img class="preloaderLogo" src="' . esc_url_raw( $logo ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" data-alt-logo="' . esc_attr( $alt_logo ) . '">';
			}
		} else {
			echo '<a href="' . esc_url_raw( $home_link ) . '" class="btTextLogo">' . get_bloginfo( 'name' ) . '</a>';
		}
	}
}

if ( ! function_exists( 'boldthemes_custom_controls' ) ) {
	function boldthemes_custom_controls() {
		class BoldThemes_Customize_Textarea_Control extends WP_Customize_Control {
			public function render_content() {
				?>
				<label>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<textarea rows="5" style="width:98%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value()); ?></textarea>
				</label>
				<?php
			}
		}
		
		class BoldThemes_Reset_Control extends WP_Customize_Control {
			public function render_content() {
				?>
				<div style="margin: 5px 0px 10px 0px">
				<label><span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span></label>			
					<input type="submit" onclick="var c = confirm('<?php echo esc_js( esc_html__( 'Reset theme settings to default values?', 'medicare' ) ); ?>'); if (c != true) return false;var href=window.location.href;if (href.indexOf('?') > -1) {window.location.replace(href + '&boldthemes_reset=reset')} else {window.location.replace(href + '?boldthemes_reset=reset')};return false;" name="boldthemes_reset" id="boldthemes_reset" class="button" value="Reset">
				</div>
				<?php
			}
		}
	}
}
add_action( 'customize_register', 'boldthemes_custom_controls' );

if ( ! function_exists( 'boldthemes_customize_register' ) ) {
	function boldthemes_customize_register( $wp_customize ) {
		global $wpdb;
		if ( isset( $_GET['boldthemes_reset'] ) && $_GET['boldthemes_reset'] == 'reset' ) {
			$wpdb->query( 'delete from ' . $wpdb->options . ' where option_name = "' . BoldThemesPFX . '_theme_options"' );
			header( 'Location: ' . wp_customize_url());
		}

		$wp_customize->remove_section( 'colors' );
		//$wp_customize->remove_section( 'title_tagline' );
		$wp_customize->remove_section( 'nav' );
		$wp_customize->remove_section( 'static_front_page' );
		
		$wp_customize->add_section( BoldThemesPFX . '_general_section' , array(
			'title'      => esc_html__( 'General Settings', 'medicare' ),
			'priority'   => 10,
		));
		$wp_customize->add_section( BoldThemesPFX . '_header_footer_section' , array(
			'title'      => esc_html__( 'Header and Footer', 'medicare' ),
			'priority'   => 30,
		));
		$wp_customize->add_section( BoldThemesPFX . '_typo_section' , array(
			'title'      => esc_html__( 'Typography', 'medicare' ),
			'priority'   => 30,
		));
		$wp_customize->add_section( BoldThemesPFX . '_blog_section' , array(
			'title'      => esc_html__( 'Blog', 'medicare' ),
			'priority'   => 50,
		));
		$wp_customize->add_section( BoldThemesPFX . '_pf_section' , array(
			'title'      => esc_html__( 'Portfolio', 'medicare' ),
			'priority'   => 52,
		));
		$wp_customize->add_section( BoldThemesPFX . '_shop_section' , array(
			'title'      => esc_html__( 'Shop', 'medicare' ),
			'priority'   => 100,
		));		
		
		/* GENERAL SETTINGS */
			
		// LOGO
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[logo]', array(
			'default'           => BoldThemes_Customize_Default::$logo,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'logo',
				array(
					'label'    => esc_html__( 'Logo', 'medicare' ),
					'section'  => BoldThemesPFX . '_general_section',
					'settings' => BoldThemesPFX . '_theme_options[logo]',
					'priority' => 20,
					'context'  => BoldThemesPFX . '_logo'
				)
			)
		);
		
		// ALTERNATIVE LOGO
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[alt_logo]', array(
			'default'           => BoldThemes_Customize_Default::$alt_logo,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'alt_logo',
				array(
					'label'    => esc_html__( 'Alternative Logo', 'medicare' ),
					'section'  => BoldThemesPFX . '_general_section',
					'settings' => BoldThemesPFX . '_theme_options[alt_logo]',
					'priority' => 25,
					'context'  => BoldThemesPFX . '_alt_logo'
				)
			)
		);
				
	
		// ACCENT COLOR
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[accent_color]', array(
			'default'        	   => BoldThemes_Customize_Default::$accent_color,
			'type'           	   => 'option',
			'capability'     	   => 'edit_theme_options',
			'sanitize_callback'    => 'sanitize_text_field'
		));
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_color', array(
			'label'    => esc_html__( 'Accent Color', 'medicare' ),
			'section'  => BoldThemesPFX . '_general_section',
			'settings' => BoldThemesPFX . '_theme_options[accent_color]',
			'priority' => 26,
			'context'  => BoldThemesPFX . '_accent_color'
		)));

		// ALTERNATE COLOR
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[alter_color]', array(
			'default'        	   => BoldThemes_Customize_Default::$alter_color,
			'type'           	   => 'option',
			'capability'     	   => 'edit_theme_options',
			'sanitize_callback'    => 'sanitize_text_field'
		));
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'alter_color', array(
			'label'    => esc_html__( 'Alternate Color', 'medicare' ),
			'section'  => BoldThemesPFX . '_general_section',
			'settings' => BoldThemesPFX . '_theme_options[alter_color]',
			'priority' => 26,
			'context'  => BoldThemesPFX . '_alter_color'
		)));
				
		// PAGE BACKGROUND
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[page_background]', array(
			'default'           => BoldThemes_Customize_Default::$page_background,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'page_background',
				array(
					'label'    => esc_html__( 'Page background', 'medicare' ),
					'section'  => BoldThemesPFX . '_general_section',
					'settings' => BoldThemesPFX . '_theme_options[page_background]',
					'priority' => 27,
					'context'  => BoldThemesPFX . '_page_background'
				)
			)
		);

		// HIDE HEADLINE
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[hide_headline]', array(
				'default'           => BoldThemes_Customize_Default::$hide_headline,
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'hide_headline', array(
				'label'    => esc_html__( 'Hide Headline', 'medicare' ),
				'section'  => BoldThemesPFX . '_general_section',
				'settings' => BoldThemesPFX . '_theme_options[hide_headline]',
				'priority' => 64,
				'type'     => 'checkbox'
		));	

		// TEMPLATE SKIN
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[template_skin]', array(
			'default'           => BoldThemes_Customize_Default::$template_skin,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'template_skin', array(
			'label'    => esc_html__( 'Use Dark Skin', 'medicare' ),
			'section'  => BoldThemesPFX . '_general_section',
			'settings' => BoldThemesPFX . '_theme_options[template_skin]',
			'priority' => 80,
			'type'     => 'checkbox'
		));	
		
		// SIDEBAR
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[sidebar]', array(
			'default'           => BoldThemes_Customize_Default::$sidebar,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'sidebar', array(
			'label'     => esc_html__( 'Sidebar', 'medicare' ),
			'section'   => BoldThemesPFX . '_general_section',
			'settings'  => BoldThemesPFX . '_theme_options[sidebar]',
			'priority'  => 93,
			'type'      => 'select',
			'choices'   => array(
				'no_sidebar' => esc_html__( 'No Sidebar', 'medicare' ),
				'left'       => esc_html__( 'Left', 'medicare' ),
				'right'      => esc_html__( 'Right', 'medicare' )
			)
		));

		// USE DASH SIDEBAR
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[sidebar_use_dash]', array(
			'default'           => BoldThemes_Customize_Default::$sidebar_use_dash,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'sidebar_use_dash', array(
			'label'    => esc_html__( 'Use Dash in Widgets', 'medicare' ),
			'section'  => BoldThemesPFX . '_general_section',
			'settings' => BoldThemesPFX . '_theme_options[sidebar_use_dash]',
			'priority' => 94,
			'type'     => 'checkbox'
		));

		// DISABLE PRELOADER
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[disable_preloader]', array(
			'default'           => BoldThemes_Customize_Default::$disable_preloader,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'disable_preloader', array(
			'label'    => esc_html__( 'Disable Preloader', 'medicare' ),
			'section'  => BoldThemesPFX . '_general_section',
			'settings' => BoldThemesPFX . '_theme_options[disable_preloader]',
			'priority' => 101,
			'type'     => 'checkbox'
		));		
		
		// PRELOADER TEXT
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[preloader_text]', array(
			'default'           => BoldThemes_Customize_Default::$preloader_text,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'preloader_text', array(
			'label'    => esc_html__( 'Preloader Text', 'medicare' ),
			'section'  => BoldThemesPFX . '_general_section',
			'settings' => BoldThemesPFX . '_theme_options[preloader_text]',
			'priority' => 102,
			'type'     => 'text'
		));
		
		// AUTOPLAY INTERVAL
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[autoplay_interval]', array(
			'default'           => BoldThemes_Customize_Default::$autoplay_interval,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'autoplay_interval', array(
			'label'    => esc_html__( 'Autoplay Interval (ms)', 'medicare' ),
			'section'  => BoldThemesPFX . '_general_section',
			'settings' => BoldThemesPFX . '_theme_options[autoplay_interval]',
			'priority' => 103,
			'type'     => 'text'
		));		

		// CUSTOM CSS
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[custom_css]', array(
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( new BoldThemes_Customize_Textarea_Control( 
			$wp_customize, 
			'custom_css', array(
				'label'    => esc_html__( 'Custom CSS', 'medicare' ),
				'section'  => BoldThemesPFX . '_general_section',
				'priority' => 104,
				'settings' => BoldThemesPFX . '_theme_options[custom_css]'
			)
		));
		
		// CUSTOM JS TOP
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[custom_js_top]', array(
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'boldthemes_custom_js'
		));
		$wp_customize->add_control( new BoldThemes_Customize_Textarea_Control( 
			$wp_customize, 
			'custom_js_top', array(
				'label'    => esc_html__( 'Custom JS (Top)', 'medicare' ),
				'section'  => BoldThemesPFX . '_general_section',
				'priority' => 105,
				'settings' => BoldThemesPFX . '_theme_options[custom_js_top]'
			)
		));
		
		// CUSTOM JS BOTTOM
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[custom_js_bottom]', array(
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'boldthemes_custom_js'
		));
		$wp_customize->add_control( new BoldThemes_Customize_Textarea_Control( 
			$wp_customize, 
			'custom_js_bottom', array(
				'label'    => esc_html__( 'Custom JS (Bottom)', 'medicare' ),
				'section'  => BoldThemesPFX . '_general_section',
				'priority' => 110,
				'settings' => BoldThemesPFX . '_theme_options[custom_js_bottom]'
			)
		));
		
		// MENU TYPE
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[menu_type]', array(
			'default'           => 'right',
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'menu_type', array(
			'label'     => esc_html__( 'Menu Type', 'medicare' ),
			'section'   => BoldThemesPFX . '_header_footer_section',
			'settings'  => BoldThemesPFX . '_theme_options[menu_type]',
			'priority'  => 60,
			'type'      => 'select',
			'choices'   => array(
				'hLeft'			=> esc_html__( 'Horizontal Left', 'medicare' ),
				'hCenter'		=> esc_html__( 'Horizontal Centered', 'medicare' ),
				'hRight'		=> esc_html__( 'Horizontal Right', 'medicare' ),
				'hLeftBelow'	=> esc_html__( 'Horizontal Left Below Logo', 'medicare' ),
				'hRightBelow'	=> esc_html__( 'Horizontal Right Below Logo', 'medicare' ),
				'vLeft'			=> esc_html__( 'Vertical Left', 'medicare' ),
				'vRight'		=> esc_html__( 'Vertical Right', 'medicare' )
			)
		));
		
		// BOXED MENU
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[boxed_menu]', array(
			'default'           => BoldThemes_Customize_Default::$boxed_menu,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'boxed_menu', array(
			'label'    => esc_html__( 'Boxed Menu', 'medicare' ),
			'section'  => BoldThemesPFX . '_header_footer_section',
			'settings' => BoldThemesPFX . '_theme_options[boxed_menu]',
			'priority' => 65,
			'type'     => 'checkbox'
		));

		// BELOW MENU
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[below_menu]', array(
			'default'           => BoldThemes_Customize_Default::$below_menu,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'below_menu', array(
			'label'    => esc_html__( 'Content Below Menu', 'medicare' ),
			'section'  => BoldThemesPFX . '_header_footer_section',
			'settings' => BoldThemesPFX . '_theme_options[below_menu]',
			'priority' => 70,
			'type'     => 'checkbox'
		));

		// TOP TOOLS IN MENU AREA
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[top_tools_in_menu]', array(
			'default'           => BoldThemes_Customize_Default::$top_tools_in_menu,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'top_tools_in_menu', array(
			'label'    => esc_html__( 'Show Top Widgets in Menu Area', 'medicare' ),
			'section'  => BoldThemesPFX . '_header_footer_section',
			'settings' => BoldThemesPFX . '_theme_options[top_tools_in_menu]',
			'priority' => 70,
			'type'     => 'checkbox'
		));
		
		// STICKY HEADER
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[sticky_header]', array(
			'default'           => BoldThemes_Customize_Default::$sticky_header,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'sticky_header', array(
			'label'    => esc_html__( 'Sticky Header', 'medicare' ),
			'section'  => BoldThemesPFX . '_header_footer_section',
			'settings' => BoldThemesPFX . '_theme_options[sticky_header]',
			'priority' => 80,
			'type'     => 'checkbox'
		));

		// HIDE MENU
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[hide_menu]', array(
			'default'           => BoldThemes_Customize_Default::$hide_menu,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'hide_menu', array(
			'label'    => esc_html__( 'Hide Menu', 'medicare' ),
			'section'  => BoldThemesPFX . '_header_footer_section',
			'settings' => BoldThemesPFX . '_theme_options[hide_menu]',
			'priority' => 80,
			'type'     => 'checkbox'
		));

		
		// FOOTER DARK SKIN
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[footer_dark_skin]', array(
			'default'           => BoldThemes_Customize_Default::$footer_dark_skin,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'footer_dark_skin', array(
			'label'    => esc_html__( 'Use Dark Skin in Footer', 'medicare' ),
			'section'  => BoldThemesPFX . '_header_footer_section',
			'settings' => BoldThemesPFX . '_theme_options[footer_dark_skin]',
			'priority' => 80,
			'type'     => 'checkbox'
		));		

		require_once( get_template_directory() . '/php/web_fonts.php' );
		$choices = array( 'no_change' => esc_html__( 'No Change', 'medicare' ) );
		foreach ( MedicareTheme::$boldthemes_fonts as $font ) {
			$choices[$font['css-name']] = $font['font-name'];
		}

		// BODY FONT
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[body_font]', array(
			'default'           => 'no_change',
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'body_font', array(
			'label'     => esc_html__( 'Body Font', 'medicare' ),
			'section'   => BoldThemesPFX . '_typo_section',
			'settings'  => BoldThemesPFX . '_theme_options[body_font]',
			'priority'  => 97,
			'type'      => 'select',
			'choices'   => $choices
		));
		
		// HEADING FONT
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[heading_font]', array(
			'default'           => 'no_change',
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'heading_font', array(
			'label'     => esc_html__( 'Heading Font', 'medicare' ),
			'section'   => BoldThemesPFX . '_typo_section',
			'settings'  => BoldThemesPFX . '_theme_options[heading_font]',
			'priority'  => 100,
			'type'      => 'select',
			'choices'   => $choices
		));

		// SUPERTITLE HEADING FONT
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[heading_supertitle_font]', array(
			'default'           => 'no_change',
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'heading_supertitle_font', array(
			'label'     => esc_html__( 'Heading Supertitle Font', 'medicare' ),
			'section'   => BoldThemesPFX . '_typo_section',
			'settings'  => BoldThemesPFX . '_theme_options[heading_supertitle_font]',
			'priority'  => 100,
			'type'      => 'select',
			'choices'   => $choices
		));

		// HEADING SUBTITLE FONT
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[heading_subtitle_font]', array(
			'default'           => 'no_change',
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'heading_subtitle_font', array(
			'label'     => esc_html__( 'Heading Subtitle Font', 'medicare' ),
			'section'   => BoldThemesPFX . '_typo_section',
			'settings'  => BoldThemesPFX . '_theme_options[heading_subtitle_font]',
			'priority'  => 100,
			'type'      => 'select',
			'choices'   => $choices
		));

		// MENU FONT
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[menu_font]', array(
			'default'           => 'no_change',
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'menu_font', array(
			'label'     => esc_html__( 'Menu Font', 'medicare' ),
			'section'   => BoldThemesPFX . '_typo_section',
			'settings'  => BoldThemesPFX . '_theme_options[menu_font]',
			'priority'  => 100,
			'type'      => 'select',
			'choices'   => $choices
		));
			
		// CUSTOM TEXT
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[custom_text]', array(
			'default'           => BoldThemes_Customize_Default::$custom_text,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'custom_text', array(
			'label'    => esc_html__( 'Custom Footer Text', 'medicare' ),
			'section'  => BoldThemesPFX . '_header_footer_section',
			'settings' => BoldThemesPFX . '_theme_options[custom_text]',
			'priority' => 120,
			'type'     => 'text'
		));
		
		// FOOTER PAGE SLUG
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[footer_page_slug]', array(
			'default'           => BoldThemes_Customize_Default::$blog_settings_page_slug,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'footer_page_slug', array(
			'label'    => esc_html__( 'Footer Page Slug', 'medicare' ),
			'section'  => BoldThemesPFX . '_header_footer_section',
			'settings' => BoldThemesPFX . '_theme_options[footer_page_slug]',
			'priority' => 121,
			'type'     => 'text'
		));

		// RESET
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[reset]', array(
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( new BoldThemes_Reset_Control( 
			$wp_customize, 
			'reset', array(
				'label'    => esc_html__( 'Reset Theme Settings', 'medicare' ),
				'section'  => BoldThemesPFX . '_general_section',
				'priority' => 130,
				'settings' => BoldThemesPFX . '_theme_options[reset]'
			)
		));
		
		/* BLOG */
		
		// GHOST SLIDER
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[blog_ghost_slider]', array(
			'default'           => BoldThemes_Customize_Default::$blog_ghost_slider,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'blog_ghost_slider', array(
			'label'    => esc_html__( 'Ghost Slider', 'medicare' ),
			'section'  => BoldThemesPFX . '_blog_section',
			'settings' => BoldThemesPFX . '_theme_options[blog_ghost_slider]',
			'priority' => 1,
			'type'     => 'checkbox'
		));
		
		// GRID GALLERY COLUMNS
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[blog_grid_gallery_columns]', array(
			'default'           => BoldThemes_Customize_Default::$blog_grid_gallery_columns,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'blog_grid_gallery_columns', array(
			'label'     => esc_html__( 'Grid Gallery Columns', 'medicare' ),
			'section'   => BoldThemesPFX . '_blog_section',
			'settings'  => BoldThemesPFX . '_theme_options[blog_grid_gallery_columns]',
			'priority'  => 6,
			'type'      => 'select',
			'choices'   => array(
				'3' => esc_html__( '3', 'medicare' ),
				'4' => esc_html__( '4', 'medicare' ),
				'5' => esc_html__( '5', 'medicare' ),
				'6' => esc_html__( '6', 'medicare' )				
			)
		));
		
		// GRID GALLERY GAP
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[blog_grid_gallery_gap]', array(
			'default'           => BoldThemes_Customize_Default::$blog_grid_gallery_gap,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'blog_grid_gallery_gap', array(
			'label'     => esc_html__( 'Grid Gallery Gap', 'medicare' ),
			'section'   => BoldThemesPFX . '_blog_section',
			'settings'  => BoldThemesPFX . '_theme_options[blog_grid_gallery_gap]',
			'priority'  => 7,
			'type'      => 'select',
			'choices'   => array(
				'0' => esc_html__( '0', 'medicare' ),
				'1' => esc_html__( '1', 'medicare' ),
				'2' => esc_html__( '2', 'medicare' ),
				'3' => esc_html__( '3', 'medicare' ),
				'4' => esc_html__( '4', 'medicare' ),
				'5' => esc_html__( '5', 'medicare' ),
				'6' => esc_html__( '6', 'medicare' ),
				'7' => esc_html__( '7', 'medicare' ),
				'8' => esc_html__( '8', 'medicare' ),
				'9' => esc_html__( '9', 'medicare' ),
				'10' => esc_html__( '10', 'medicare' ),
				'15' => esc_html__( '15', 'medicare' ),
				'20' => esc_html__( '20', 'medicare' )
			)
		));	
		
		// Blog list view
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[blog_list_view]', array(
			'default'           => BoldThemes_Customize_Default::$blog_list_view,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'blog_list_view', array(
			'label'     => esc_html__( 'Posts list view', 'medicare' ),
			'section'   => BoldThemesPFX . '_blog_section',
			'settings'  => BoldThemesPFX . '_theme_options[blog_list_view]',
			'priority'  => 8,
			'type'      => 'select',
			'choices'   => array(
				'standard' => esc_html__( 'Standard', 'medicare' ),
				'columns' => esc_html__( 'Columns', 'medicare' )
			)
		));

		// Blog single view
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[blog_single_view]', array(
			'default'           => BoldThemes_Customize_Default::$blog_single_view,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'blog_single_view', array(
			'label'     => esc_html__( 'Single post view', 'medicare' ),
			'section'   => BoldThemesPFX . '_blog_section',
			'settings'  => BoldThemesPFX . '_theme_options[blog_single_view]',
			'priority'  => 8,
			'type'      => 'select',
			'choices'   => array(
				'standard' => esc_html__( 'Standard', 'medicare' ),
				'columns' => esc_html__( 'Columns', 'medicare' )
			)
		));

		// AUTHOR
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[blog_author]', array(
			'default'           => BoldThemes_Customize_Default::$blog_author,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'blog_author', array(
			'label'    => esc_html__( 'Show Author Name', 'medicare' ),
			'section'  => BoldThemesPFX . '_blog_section',
			'settings' => BoldThemesPFX . '_theme_options[blog_author]',
			'priority' => 8,
			'type'     => 'checkbox'
		));

		// DATE
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[blog_date]', array(
			'default'           => BoldThemes_Customize_Default::$blog_date,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'blog_date', array(
			'label'    => esc_html__( 'Show Post Date', 'medicare' ),
			'section'  => BoldThemesPFX . '_blog_section',
			'settings' => BoldThemesPFX . '_theme_options[blog_date]',
			'priority' => 10,
			'type'     => 'checkbox'
		));
		
		// BLOG SIDE INFO
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[blog_side_info]', array(
			'default'           => BoldThemes_Customize_Default::$blog_side_info,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'blog_side_info', array(
			'label'    => esc_html__( 'Show Author Avatar in List', 'medicare' ),
			'section'  => BoldThemesPFX . '_blog_section',
			'settings' => BoldThemesPFX . '_theme_options[blog_side_info]',
			'priority' => 12,
			'type'     => 'checkbox'
		));
		
		// AUTHOR INFO
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[blog_author_info]', array(
			'default'           => BoldThemes_Customize_Default::$blog_author_info,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'blog_author_info', array(
			'label'    => esc_html__( 'Show Author Info in Post', 'medicare' ),
			'section'  => BoldThemesPFX . '_blog_section',
			'settings' => BoldThemesPFX . '_theme_options[blog_author_info]',
			'priority' => 15,
			'type'     => 'checkbox'
		));

		// SHARE ON FACEBOOK
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[blog_share_facebook]', array(
			'default'           => BoldThemes_Customize_Default::$blog_share_facebook,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'blog_share_facebook', array(
			'label'    => esc_html__( 'Share on Facebook', 'medicare' ),
			'section'  => BoldThemesPFX . '_blog_section',
			'settings' => BoldThemesPFX . '_theme_options[blog_share_facebook]',
			'priority' => 18,
			'type'     => 'checkbox'
		));
		
		// SHARE ON TWITTER
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[blog_share_twitter]', array(
			'default'           => BoldThemes_Customize_Default::$blog_share_twitter,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'blog_share_twitter', array(
			'label'    => esc_html__( 'Share on Twitter', 'medicare' ),
			'section'  => BoldThemesPFX . '_blog_section',
			'settings' => BoldThemesPFX . '_theme_options[blog_share_twitter]',
			'priority' => 20,
			'type'     => 'checkbox'
		));

		// SHARE ON GOOGLE PLUS
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[blog_share_google_plus]', array(
			'default'           => BoldThemes_Customize_Default::$blog_share_google_plus,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'blog_share_google_plus', array(
			'label'    => esc_html__( 'Share on Google Plus', 'medicare' ),
			'section'  => BoldThemesPFX . '_blog_section',
			'settings' => BoldThemesPFX . '_theme_options[blog_share_google_plus]',
			'priority' => 30,
			'type'     => 'checkbox'
		));

		// SHARE ON LINKEDIN
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[blog_share_linkedin]', array(
			'default'           => BoldThemes_Customize_Default::$blog_share_linkedin,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'blog_share_linkedin', array(
			'label'    => esc_html__( 'Share on LinkedIn', 'medicare' ),
			'section'  => BoldThemesPFX . '_blog_section',
			'settings' => BoldThemesPFX . '_theme_options[blog_share_linkedin]',
			'priority' => 40,
			'type'     => 'checkbox'
		));
		
		// SHARE ON VK
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[blog_share_vk]', array(
			'default'           => BoldThemes_Customize_Default::$blog_share_vk,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'blog_share_vk', array(
			'label'    => esc_html__( 'Share on VK', 'medicare' ),
			'section'  => BoldThemesPFX . '_blog_section',
			'settings' => BoldThemesPFX . '_theme_options[blog_share_vk]',
			'priority' => 50,
			'type'     => 'checkbox'
		));

		// USE DASH
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[blog_use_dash]', array(
			'default'           => BoldThemes_Customize_Default::$blog_use_dash,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'blog_use_dash', array(
			'label'    => esc_html__( 'Use Dash in Headlines', 'medicare' ),
			'section'  => BoldThemesPFX . '_blog_section',
			'settings' => BoldThemesPFX . '_theme_options[blog_use_dash]',
			'priority' => 50,
			'type'     => 'checkbox'
		));
		
		// STICKY POSTS IN GRID/TILES
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[sticky_in_grid]', array(
			'default'           => BoldThemes_Customize_Default::$sticky_in_grid,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'sticky_in_grid', array(
			'label'    => esc_html__( 'Sticky Posts in Grid/Tiles', 'medicare' ),
			'section'  => BoldThemesPFX . '_blog_section',
			'settings' => BoldThemesPFX . '_theme_options[sticky_in_grid]',
			'priority' => 60,
			'type'     => 'checkbox'
		));
		
		// SETTINGS PAGE SLUG
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[blog_settings_page_slug]', array(
			'default'           => BoldThemes_Customize_Default::$blog_settings_page_slug,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'blog_settings_page_slug', array(
			'label'    => esc_html__( 'Settings Page Slug', 'medicare' ),
			'section'  => BoldThemesPFX . '_blog_section',
			'settings' => BoldThemesPFX . '_theme_options[blog_settings_page_slug]',
			'priority' => 60,
			'type'     => 'text'
		));
		
		/* PORTFOLIO */
		
		// GHOST SLIDER
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[pf_ghost_slider]', array(
			'default'           => BoldThemes_Customize_Default::$pf_ghost_slider,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'pf_ghost_slider', array(
			'label'    => esc_html__( 'Ghost Slider', 'medicare' ),
			'section'  => BoldThemesPFX . '_pf_section',
			'settings' => BoldThemesPFX . '_theme_options[pf_ghost_slider]',
			'priority' => 3,
			'type'     => 'checkbox'
		));
		
		// GRID GALLERY COLUMNS
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[pf_grid_gallery_columns]', array(
			'default'           => BoldThemes_Customize_Default::$pf_grid_gallery_columns,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'pf_grid_gallery_columns', array(
			'label'     => esc_html__( 'Grid Gallery Columns', 'medicare' ),
			'section'   => BoldThemesPFX . '_pf_section',
			'settings'  => BoldThemesPFX . '_theme_options[pf_grid_gallery_columns]',
			'priority'  => 5,
			'type'      => 'select',
			'choices'   => array(
				'3' => esc_html__( '3', 'medicare' ),
				'4' => esc_html__( '4', 'medicare' ),
				'5' => esc_html__( '5', 'medicare' ),
				'6' => esc_html__( '6', 'medicare' )				
			)
		));

		// GRID GALLERY GAP
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[pf_grid_gallery_gap]', array(
			'default'           => BoldThemes_Customize_Default::$pf_grid_gallery_gap,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'pf_grid_gallery_gap', array(
			'label'     => esc_html__( 'Grid Gallery Gap', 'medicare' ),
			'section'   => BoldThemesPFX . '_pf_section',
			'settings'  => BoldThemesPFX . '_theme_options[pf_grid_gallery_gap]',
			'priority'  => 8,
			'type'      => 'select',
			'choices'   => array(
				'0' => esc_html__( '0', 'medicare' ),
				'1' => esc_html__( '1', 'medicare' ),
				'2' => esc_html__( '2', 'medicare' ),
				'3' => esc_html__( '3', 'medicare' ),
				'4' => esc_html__( '4', 'medicare' ),
				'5' => esc_html__( '5', 'medicare' ),
				'6' => esc_html__( '6', 'medicare' ),
				'7' => esc_html__( '7', 'medicare' ),
				'8' => esc_html__( '8', 'medicare' ),
				'9' => esc_html__( '9', 'medicare' ),
				'10' => esc_html__( '10', 'medicare' ),
				'15' => esc_html__( '15', 'medicare' ),
				'20' => esc_html__( '20', 'medicare' )
			)
		));

		// Portfolio single view
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[pf_single_view]', array(
			'default'           => BoldThemes_Customize_Default::$pf_single_view,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'pf_single_view', array(
			'label'     => esc_html__( 'Single project view', 'medicare' ),
			'section'   => BoldThemesPFX . '_pf_section',
			'settings'  => BoldThemesPFX . '_theme_options[pf_single_view]',
			'priority'  => 8,
			'type'      => 'select',
			'choices'   => array(
				'standard' => esc_html__( 'Standard', 'medicare' ),
				'columns' => esc_html__( 'Columns', 'medicare' )
			)
		));

		// SHARE ON FACEBOOK
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[pf_share_facebook]', array(
			'default'           => BoldThemes_Customize_Default::$pf_share_facebook,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'pf_share_facebook', array(
			'label'    => esc_html__( 'Share on Facebook', 'medicare' ),
			'section'  => BoldThemesPFX . '_pf_section',
			'settings' => BoldThemesPFX . '_theme_options[pf_share_facebook]',
			'priority' => 10,
			'type'     => 'checkbox'
		));
		
		// SHARE ON TWITTER
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[pf_share_twitter]', array(
			'default'           => BoldThemes_Customize_Default::$pf_share_twitter,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'pf_share_twitter', array(
			'label'    => esc_html__( 'Share on Twitter', 'medicare' ),
			'section'  => BoldThemesPFX . '_pf_section',
			'settings' => BoldThemesPFX . '_theme_options[pf_share_twitter]',
			'priority' => 20,
			'type'     => 'checkbox'
		));

		// SHARE ON GOOGLE PLUS
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[pf_share_google_plus]', array(
			'default'           => BoldThemes_Customize_Default::$pf_share_google_plus,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'pf_share_google_plus', array(
			'label'    => esc_html__( 'Share on Google Plus', 'medicare' ),
			'section'  => BoldThemesPFX . '_pf_section',
			'settings' => BoldThemesPFX . '_theme_options[pf_share_google_plus]',
			'priority' => 30,
			'type'     => 'checkbox'
		));

		// SHARE ON LINKEDIN
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[pf_share_linkedin]', array(
			'default'           => BoldThemes_Customize_Default::$pf_share_linkedin,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'pf_share_linkedin', array(
			'label'    => esc_html__( 'Share on LinkedIn', 'medicare' ),
			'section'  => BoldThemesPFX . '_pf_section',
			'settings' => BoldThemesPFX . '_theme_options[pf_share_linkedin]',
			'priority' => 40,
			'type'     => 'checkbox'
		));
		
		// SHARE ON VK
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[pf_share_vk]', array(
			'default'           => BoldThemes_Customize_Default::$pf_share_vk,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'pf_share_vk', array(
			'label'    => esc_html__( 'Share on VK', 'medicare' ),
			'section'  => BoldThemesPFX . '_pf_section',
			'settings' => BoldThemesPFX . '_theme_options[pf_share_vk]',
			'priority' => 50,
			'type'     => 'checkbox'
		));

		// USE DASH
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[pf_use_dash]', array(
			'default'           => BoldThemes_Customize_Default::$pf_use_dash,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'pf_use_dash', array(
			'label'    => esc_html__( 'Use Dash in Headlines', 'medicare' ),
			'section'  => BoldThemesPFX . '_pf_section',
			'settings' => BoldThemesPFX . '_theme_options[pf_use_dash]',
			'priority' => 50,
			'type'     => 'checkbox'
		));
		
		// SETTINGS PAGE SLUG
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[pf_settings_page_slug]', array(
			'default'           => BoldThemes_Customize_Default::$pf_settings_page_slug,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'pf_settings_page_slug', array(
			'label'    => esc_html__( 'Settings Page Slug', 'medicare' ),
			'section'  => BoldThemesPFX . '_pf_section',
			'settings' => BoldThemesPFX . '_theme_options[pf_settings_page_slug]',
			'priority' => 60,
			'type'     => 'text'
		));
		
		/* SHOP */
		
		// SHARE ON FACEBOOK
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[shop_share_facebook]', array(
			'default'           => BoldThemes_Customize_Default::$shop_share_facebook,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'shop_share_facebook', array(
			'label'    => esc_html__( 'Share on Facebook', 'medicare' ),
			'section'  => BoldThemesPFX . '_shop_section',
			'settings' => BoldThemesPFX . '_theme_options[shop_share_facebook]',
			'priority' => 10,
			'type'     => 'checkbox'
		));
		
		// SHARE ON TWITTER
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[shop_share_twitter]', array(
			'default'           => BoldThemes_Customize_Default::$shop_share_twitter,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'shop_share_twitter', array(
			'label'    => esc_html__( 'Share on Twitter', 'medicare' ),
			'section'  => BoldThemesPFX . '_shop_section',
			'settings' => BoldThemesPFX . '_theme_options[shop_share_twitter]',
			'priority' => 20,
			'type'     => 'checkbox'
		));

		// SHARE ON GOOGLE PLUS
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[shop_share_google_plus]', array(
			'default'           => BoldThemes_Customize_Default::$shop_share_google_plus,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'shop_share_google_plus', array(
			'label'    => esc_html__( 'Share on Google Plus', 'medicare' ),
			'section'  => BoldThemesPFX . '_shop_section',
			'settings' => BoldThemesPFX . '_theme_options[shop_share_google_plus]',
			'priority' => 30,
			'type'     => 'checkbox'
		));

		// SHARE ON LINKEDIN
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[shop_share_linkedin]', array(
			'default'           => BoldThemes_Customize_Default::$shop_share_linkedin,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'shop_share_linkedin', array(
			'label'    => esc_html__( 'Share on LinkedIn', 'medicare' ),
			'section'  => BoldThemesPFX . '_shop_section',
			'settings' => BoldThemesPFX . '_theme_options[shop_share_linkedin]',
			'priority' => 40,
			'type'     => 'checkbox'
		));
		
		// SHARE ON VK
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[shop_share_vk]', array(
			'default'           => BoldThemes_Customize_Default::$shop_share_vk,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'shop_share_vk', array(
			'label'    => esc_html__( 'Share on VK', 'medicare' ),
			'section'  => BoldThemesPFX . '_shop_section',
			'settings' => BoldThemesPFX . '_theme_options[shop_share_vk]',
			'priority' => 50,
			'type'     => 'checkbox'
		));
		
		// USE DASH
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[shop_use_dash]', array(
			'default'           => BoldThemes_Customize_Default::$shop_use_dash,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'shop_use_dash', array(
			'label'    => esc_html__( 'Use Dash in Headlines', 'medicare' ),
			'section'  => BoldThemesPFX . '_shop_section',
			'settings' => BoldThemesPFX . '_theme_options[shop_use_dash]',
			'priority' => 50,
			'type'     => 'checkbox'
		));		
		
		// SETTINGS PAGE SLUG
		$wp_customize->add_setting( BoldThemesPFX . '_theme_options[shop_settings_page_slug]', array(
			'default'           => BoldThemes_Customize_Default::$shop_settings_page_slug,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control( 'shop_settings_page_slug', array(
			'label'    => esc_html__( 'Settings Page Slug', 'medicare' ),
			'section'  => BoldThemesPFX . '_shop_section',
			'settings' => BoldThemesPFX . '_theme_options[shop_settings_page_slug]',
			'priority' => 60,
			'type'     => 'text'
		));		

	}
}
add_action( 'customize_register', 'boldthemes_customize_register' );

if ( ! function_exists( 'boldthemes_js_bottom' ) ) {
	function boldthemes_js_bottom() {
		$j = boldthemes_get_option( 'custom_js_bottom' );
		echo '<script>' . wp_kses_post( $j ) . '</script>';
	}
}

if ( ! function_exists( 'boldthemes_customize_css_js' ) ) {
	function boldthemes_customize_css_js() {

		echo '<style>';
		
		if ( boldthemes_get_option( 'custom_css' ) != '' ) {
			echo boldthemes_get_option( 'custom_css' );
		}
		
		echo '</style>';
		
		if ( boldthemes_get_option( 'custom_js_top' ) != '' ) {
			$j = boldthemes_get_option( 'custom_js_top' );
			echo '<script>' . wp_kses_post( $j ) . '</script>';
		}

		if ( boldthemes_get_option( 'custom_js_bottom' ) != '' ) {
			add_action( 'wp_footer', 'boldthemes_js_bottom' );
		}
		
	}
}
add_action( 'wp_head', 'boldthemes_customize_css_js' );

function boldthemes_custom_text( $text ) {
	return $text;
}

function boldthemes_custom_js( $js ) {
	return trim( $js );
}