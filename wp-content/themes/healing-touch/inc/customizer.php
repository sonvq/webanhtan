<?php
/**
 * SKT Healing Touch Theme Customizer
 *
 * @package SKT Healing Touch
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function healing_touch_customize_register( $wp_customize ) {
	
	//Add a class for titles
    class healing_touch_Info extends WP_Customize_Control {
        public $type = 'info';
        public $label = '';
        public function render_content() {
        ?>
			<h3 style="text-decoration: underline; color: #DA4141; text-transform: uppercase;"><?php echo esc_html( $this->label ); ?></h3>
        <?php
        }
    }
	
	class WP_Customize_Textarea_Control extends WP_Customize_Control {
    public $type = 'textarea';
 
    public function render_content() {
        ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
            </label>
        <?php
    }
}
	
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->remove_control('header_textcolor');
	$wp_customize->remove_control('display_header_text');
	
	$wp_customize->add_setting('color_scheme',array(
			'default'	=> '#3695eb',
			'sanitize_callback'	=> 'sanitize_hex_color'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'color_scheme',array(
			'label' => __('Color Scheme','healing-touch'),
 			'description' => __( 'More color options in PRO Version.', 'healing-touch' ),	
			'section' => 'colors',
			'settings' => 'color_scheme'
		))
	);
	
	$wp_customize->add_section('slider_section',array(
		'title'	=> __('Slider Settings','healing-touch'),
		'description' => sprintf( __( 'Slider Image Dimensions ( 1400 X 717 )<br/> Select Featured Image for these pages <br /> How to set featured image <a href="%1$s" target="_blank">Click Here ?</a>', 'healing-touch' ),
			esc_url( '"'.SKT_THEME_FEATURED_SET_VIDEO_URL.'"' )
		),			   	
		'priority'		=> null
	));
// Slider Section
	
	// Slide Image 1
	$wp_customize->add_setting('slide_image1',array(
		'default'	=> get_template_directory_uri().'/images/slides/slider1.jpg',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	
	$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'slide_image1',
        array(
            'label' => __('Slide Image 1','healing-touch'),
            'section' => 'slider_section',
            'settings' => 'slide_image1'
        )
    )
);

	$wp_customize->add_setting('slide_title1',array(
			'default'	=> __('The Next Level in WordPress Theme','healing-touch'),
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('slide_title1',array(
		'label'	=> __('Slider title 1','healing-touch'),
		'setting'	=> 'slide_title1',
		'section'	=> 'slider_section'
	));
	
	$wp_customize->add_setting('slide_desc1',array(
		'default'	=> __('Take your Website to the next level.','healing-touch'),
		'sanitize_callback'	=> 'sanitize_text_field'	
	));
	
	$wp_customize->add_control(
		new WP_Customize_Textarea_Control(
			$wp_customize,
			'slide_desc1',
			array(
				'label'	=> __('Slider description  1','healing-touch'),
				'setting'	=> 'slide_desc1',
				'section'	=> 'slider_section'
			)
		)
	);
	
	$wp_customize->add_setting('slide_link1',array(
			'default'	=> '#link1',
			'sanitize_callback'	=> 'esc_url_raw'
	));
	
	$wp_customize->add_control('slide_link1',array(
			'label'	=> __('Slide link 1','healing-touch'),
			'setting'	=> 'slide_link1',
			'section'	=> 'slider_section'
	));
	
	$wp_customize->add_setting('slide_image2',array(
			'default'	=> get_template_directory_uri().'/images/slides/slider2.jpg',
			'sanitize_callback'	=> 'esc_url_raw'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'slide_image2',
			array(
				'label'	=> __('Slide image 2','healing-touch'),
				'setting'	=> 'slide_image2',
				'section'	=> 'slider_section'
			)
		)
	);
	
	$wp_customize->add_setting('slide_title2',array(
			'default'	=> __('Healing Touch WordPress Theme','healing-touch'),
			'sanitize_callback'		=> 'sanitize_text_field',
	));
	
	$wp_customize->add_control('slide_title2',array(
			'label'	=> __('Slide title 2','healing-touch'),
			'setting'	=> 'slide_title2',
			'section'	=> 'slider_section'
	));
	
	$wp_customize->add_setting('slide_desc2',array(
			'default'	=> __('Responsive & Retina Ready with Clean and Modern Design','healing-touch'),
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Textarea_Control(
			$wp_customize,
			'slide_desc2',
			array(
				'label'	=> __('Slide description 2','healing-touch'),
				'setting'	=> 'slide_desc2',
				'section'	=> 'slider_section'
			)
		)
	);
	
	$wp_customize->add_setting('slide_link2',array(
			'default'	=> '#link2',
			'sanitize_callback'	=> 'esc_url_raw'
	));
	
	$wp_customize->add_control('slide_link2',array(
		'label'	=> __('Slide link 2','healing-touch'),
		'setting'	=> 'slide_link2',
		'section'	=> 'slider_section'
	));
 
	$wp_customize->add_setting('slide_image3',array(
		'default'	=> get_template_directory_uri().'/images/slides/slider3.jpg',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	
	$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'slide_image3',
        array(
            'label' => __('Slide Image 3 (1400x446)','healing-touch'),
            'section' => 'slider_section',
            'settings' => 'slide_image3'
        )
    )
);

	$wp_customize->add_setting('slide_title3',array(
			'default'	=> __('The Next Level in WordPress Theme','healing-touch'),
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('slide_title3',array(
		'label'	=> __('Slider title 3','healing-touch'),
		'setting'	=> 'slide_title3',
		'section'	=> 'slider_section'
	));
	
	$wp_customize->add_setting('slide_desc3',array(
		'default'	=> __('Take your Website to the next level.','healing-touch'),
		'sanitize_callback'	=> 'sanitize_text_field'	
	));
	
	$wp_customize->add_control(
		new WP_Customize_Textarea_Control(
			$wp_customize,
			'slide_desc3',
			array(
				'label'	=> __('Slider description  3','healing-touch'),
				'setting'	=> 'slide_desc3',
				'section'	=> 'slider_section'
			)
		)
	);
	
	$wp_customize->add_setting('slide_link3',array(
			'default'	=> '#link3',
			'sanitize_callback'	=> 'esc_url_raw'
	));
	
	$wp_customize->add_control('slide_link3',array(
			'label'	=> __('Slide link 3','healing-touch'),
			'setting'	=> 'slide_link3',
			'section'	=> 'slider_section'
	)); 
 
	$wp_customize->add_setting('slide_image4',array(
			'default'	=> '',
			'sanitize_callback'	=> 'esc_url_raw'
	));
	
	$wp_customize->add_control(
	 	new WP_Customize_Image_Control(
			$wp_customize,
			'slide_image4',
			array(
				'label'	=> __('Slide Image 4','healing-touch'),
				'setting'	=> 'slide_image4',
				'section'	=> 'slider_section'
			)
		)
	);
	
	$wp_customize->add_setting('slide_title4',array(
			'default'	=> '',
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('slide_title4',array(
			'label'	=> __('Slide title 4','healing-touch'),
			'setting'	=> 'slide_title4',
			'section'	=> 'slider_section'
	));
	
	$wp_customize->add_setting('slide_desc4',array(
			'default'	=> '',
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Textarea_Control(
			$wp_customize,
			'slide_desc4',
			array(
				'label'	=> __('Slide description 4','healing-touch'),
				'setting'	=> 'slide_desc4',
				'section'	=> 'slider_section'
			)
		)
	);
	
	$wp_customize->add_setting('slide_link4',array(
			'default'	=> '',
			'sanitize_callback'	=> 'esc_url_raw'
	));	
	
	$wp_customize->add_control('slide_link4',array(
			'label'	=> __('Slide link 4','healing-touch'),
			'setting'	=> 'slide_link4',
			'section'	=> 'slider_section'
	));
	
	$wp_customize->add_setting('slide_image5',array(
			'default'	=> '',
			'sanitize_callback'	=> 'esc_url_raw'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'slide_image5',
			array(
				'label'	=> __('Slide image 5','healing-touch'),
				'setting'	=> 'slide_image5',
				'section'	=> 'slider_section'
			)
		)
	);
	
	$wp_customize->add_setting('slide_title5',array(
			'default'	=> '',
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('slide_title5',array(
			'label'	=> __('Slide title 5','healing-touch'),
			'setting'	=> 'slide_title5',
			'section'	=> 'slider_section'
	));
	
	$wp_customize->add_setting('slide_desc5',array(
			'default'	=> '',
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Textarea_Control(
			$wp_customize,
			'slide_desc5',
			array(
				'label'	=> __('Slide description 5','healing-touch'),
				'setting'	=> 'slide_desc5',
				'section'	=> 'slider_section'
			)
		)
	);
	
	$wp_customize->add_setting('slide_link5',array(
			'default'	=> '',
			'sanitize_callback'	=> 'esc_url_raw'
	));
	
	$wp_customize->add_control('slide_link5',array(
			'label'	=> __('Slide link 5','healing-touch'),
			'setting'	=> 'slide_link5',
			'section'	=> 'slider_section'
	));
	
	$wp_customize->add_setting('hide_slider',array(
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
	));	 

	$wp_customize->add_control( 'hide_slider', array(
    	   'section'   => 'slider_section',
    	   'label'     => __('Hide This Section','healing-touch'),
    	   'type'      => 'checkbox'
     ));	
	
// Home Boxes 	
	$wp_customize->add_section('page_boxes',array(
		'title'	=> __('Homepage Boxes','healing-touch'),
 			'description' => sprintf( __( 'Featured Image Dimensions : ( 46 X 39 )<br/> Select Featured Image for these pages <br /> How to set featured image %s', 'healing-touch' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url( '"'.SKT_THEME_FEATURED_SET_VIDEO_URL.'"' ), __( 'Click Here ?', 'healing-touch' )
						)
					),
		'priority'	=> null
	));	
	
	$wp_customize->add_setting(
    'page-setting1',
		array(
			'default' => '0',
			'capability' => 'edit_theme_options',			
			'sanitize_callback' => 'healing_touch_sanitize_integer',
		)
	);
 
	$wp_customize->add_control(
		'page-setting1',
		array(
			'type' => 'dropdown-pages',
			'label' => __('Choose a page for box one:','healing-touch'),
			'section' => 'page_boxes',
		)
	);
	
	$wp_customize->add_setting('page-setting2',array(
			'default' => '0',
			'capability' => 'edit_theme_options',		
			'sanitize_callback'	=> 'healing_touch_sanitize_integer'
	));
	
	$wp_customize->add_control('page-setting2',array(
			'type'	=> 'dropdown-pages',
			'label'	=> __('Choose a page for box two:','healing-touch'),
			'section'	=> 'page_boxes'	
	));
	
	$wp_customize->add_setting('page-setting3',array(
			'default' => '0',
			'capability' => 'edit_theme_options',		
			'sanitize_callback'	=> 'healing_touch_sanitize_integer'
	));
	
	$wp_customize->add_control('page-setting3',array(
			'type'	=> 'dropdown-pages',
			'label'	=> __('Choose a page for box three:','healing-touch'),
			'section'	=> 'page_boxes'
	));
	
	$wp_customize->add_setting('page-setting4',array(
			'default' => '0',
			'capability' => 'edit_theme_options',		
			'sanitize_callback'	=> 'healing_touch_sanitize_integer'
	));
	
	$wp_customize->add_control('page-setting4',array(
			'type'	=> 'dropdown-pages',
			'label'	=> __('Choose a page for box four:','healing-touch'),
			'section'	=> 'page_boxes'
	));
	
	
	$wp_customize->add_setting('hide_boxes',array(
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
	));	 

	$wp_customize->add_control( 'hide_boxes', array(
    	   'section'   => 'page_boxes',
    	   'label'     => __('Hide This Section','healing-touch'),
    	   'type'      => 'checkbox'
     ));	
	
	$wp_customize->add_section('social_sec',array(
			'title'	=> __('Social Settings','healing-touch'),
	 		'description' => __( 'Add social icons link here More icon available in PRO Version.', 'healing-touch' ),			
			'priority'		=> null
	));
	
	$wp_customize->add_setting('fb_link',array(
			'default'	=> '#facebook',
			'sanitize_callback'	=> 'esc_url_raw'	
	));
	
	$wp_customize->add_control('fb_link',array(
			'label'	=> __('Add facebook link here','healing-touch'),
			'setting'	=> 'fb_link',
			'section'	=> 'social_sec'
	));
	
	$wp_customize->add_setting('twitt_link',array(
			'default'	=> '#twitter',
			'sanitize_callback'	=> 'esc_url_raw'
	));
	
	$wp_customize->add_control('twitt_link',array(
			'label'	=> __('Add twitter link here','healing-touch'),
			'setting'	=> 'twitt_link',
			'section'	=> 'social_sec'
	));
	
	$wp_customize->add_setting('gplus_link',array(
			'default'	=> '#gplus',
			'sanitize_callback'	=> 'esc_url_raw'
	));
	
	$wp_customize->add_control('gplus_link',array(
			'label'	=> __('Add google plus link here','healing-touch'),
			'setting'	=> 'gplus_link',
			'section'	=> 'social_sec'
	));
	
	$wp_customize->add_setting('linked_link',array(
			'default'	=> '#linkedin',
			'sanitize_callback'	=> 'esc_url_raw'
	));
	
	$wp_customize->add_control('linked_link',array(
			'label'	=> __('Add linkedin link here','healing-touch'),
			'setting'	=> 'linked_link',
			'section'	=> 'social_sec'
	));
	
	$wp_customize->add_section('contact_sec',array(
			'title'	=> __('Contact Details','healing-touch'),
			'description'	=> __('Add you contact details here','healing-touch'),
			'priority'	=> null
	));
	
	$wp_customize->add_setting('contact_title',array(
			'default'	=> __('Skt Healing Touch','healing-touch'),
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('contact_title',array(
			'label'	=> __('Add contact title here','healing-touch'),
			'setting'	=> 'contact_title',
			'section'	=> 'contact_sec'
	));
	
	$wp_customize->add_setting('contact_desc',array(
			'default'	=> __('Lorem Ipsum is simply dummy text of the printing and typesetting industry.','healing-touch'),
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Textarea_Control(
			$wp_customize,
			'contact_desc',
			array(
				'label'	=> __('Add contact description here','healing-touch'),
				'setting'	=> 'contact_desc',
				'section'	=> 'contact_sec'
			)
		)
	);
	
	$wp_customize->add_setting('contact_fax',array(
			'default'	=> __('+9876543210','healing-touch'),
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Textarea_Control(
			$wp_customize,
			'contact_fax',
			array(
				'label'	=> __('Add fax number here','healing-touch'),
				'setting'	=> 'contact_fax',
				'section'	=> 'contact_sec'
			)
		)
	);
	
	$wp_customize->add_setting('contact_no',array(
			'default'	=> __('+123 456 7890','healing-touch'),
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('contact_no',array(
			'label'	=> __('Add contact number here.','healing-touch'),
			'setting'	=> 'contact_no',
			'section'	=> 'contact_sec'
	));
	
	$wp_customize->add_setting('contact_mail',array(
			'default'	=> 'contact@company.com',
			'sanitize_callback'	=> 'sanitize_email'
	));
	
	$wp_customize->add_control('contact_mail',array(
			'label'	=> __('Add you email here','healing-touch'),
			'setting'	=> 'contact_mail',
			'section'	=> 'contact_sec'
	));
}
add_action( 'customize_register', 'healing_touch_customize_register' );
 
//Integer
function healing_touch_sanitize_integer( $input ) {
    if( is_numeric( $input ) ) {
        return intval( $input );
    }
}

function healing_touch_custom_css(){
		?>
        	<style type="text/css">
					#sidebar aside ul li a:hover,
					.recent-post-title a:hover,
					#copyright a,
					.foot-label,
					.theme-default .nivo-caption a:hover,
					.logo h2 a,
					.latest-blog span a,
					.postmeta a:hover, 
					a, 
					#footer .widget-column a:hover, 
					#copyright a:hover,
					.blog-post-repeat .entry-summary a, 
					.entry-content a,
					#sidebar aside h3.widget-title,
					.blog-post-repeat .blog-title a{
						color:<?php echo  esc_attr(get_theme_mod('color_scheme','#3695eb')); ?>;
					}
					.slide_more a:hover{
						border-color:<?php echo esc_attr(get_theme_mod('color_scheme','#3695eb')); ?>;
					}
					.theme-default .nivo-controlNav a.active,
					.site-nav li:hover ul li:hover, 
					.site-nav li:hover ul li.current-page-item,
					.site-nav li:hover ul li,
					p.form-submit input[type="submit"],
					#sidebar aside.widget_search input[type="submit"], 
					.wpcf7 input[type="submit"], 
					.pagination ul li .current, .pagination ul li a:hover, .feature-box{
						background-color:<?php echo esc_attr(get_theme_mod('color_scheme','#60646d')); ?>
					}
					.site-nav li:hover a, 
					.site-nav li.current_page_item a,
 					.site-nav li:hover ul li:hover, 
					.site-nav li:hover ul li.current-page-item,
					.site-nav li:hover ul li{
						color:<?php echo esc_attr(get_theme_mod('color_scheme','#3695eb')); ?>
					}					
			</style>
	<?php }
add_action('wp_head','healing_touch_custom_css');	

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function healing_touch_customize_preview_js() {
	wp_enqueue_script( 'healing_touch_customizer', get_template_directory_uri() . '/js/customize-preview.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'healing_touch_customize_preview_js' );


function healing_touch_custom_customize_enqueue() {
	wp_enqueue_script( 'healing_touch_custom_customize', get_template_directory_uri() . '/js/custom.customize.js', array( 'jquery', 'customize-controls' ), false, true );
}
add_action( 'customize_controls_enqueue_scripts', 'healing_touch_custom_customize_enqueue' );