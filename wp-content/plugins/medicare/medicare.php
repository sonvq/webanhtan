<?php

/**
 * Plugin Name: Medicare
 * Description: Shortcodes and widgets by BoldThemes.
 * Version: 1.0.5
 * Author: BoldThemes
 * Author URI: http://bold-themes.com
 */
 
 function bt_load_custom_wp_admin_style() {
	wp_enqueue_style( 'bt_custom_wp_admin_css', plugin_dir_url( __FILE__ ) . 'admin-style.css' );
}
add_action( 'admin_enqueue_scripts', 'bt_load_custom_wp_admin_style' ); 

function bt_plugin_enqueue() {
	wp_enqueue_script( 'bt_plugin_enqueue', plugin_dir_url( __FILE__ ) . 'bt_elements.js', array( 'jquery' ), '', false );
}
add_action( 'wp_enqueue_scripts', 'bt_plugin_enqueue' );
 
function bt_load_plugin_textdomain() {

	$domain = 'bt_plugin';
	$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

	load_plugin_textdomain( $domain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

}
add_action( 'plugins_loaded', 'bt_load_plugin_textdomain' );

 // [bt_highlight]
function bt_highlight( $atts, $content ) {
	extract( shortcode_atts( array(
	), $atts, 'bt_highlight' ) );
	return '<span class="btHighlight">' . wptexturize( do_shortcode( $content ) ) . '</span>';
} 
add_shortcode( 'bt_highlight', 'bt_highlight' );

// [bt_drop_cap type="1/2/3"]
function bt_drop_cap( $atts, $content ) {
	extract( shortcode_atts( array(
		'type' => '1'
	), $atts, 'bt_drop_cap' ) );
	
	$type = intval( $type );
	
	$class = 'enhanced';
	
	if ( $type == 2 ) {
		$class = 'enhanced circle colored';
	} else if ( $type == 3 ) {
		$class = 'enhanced ring';
	}

	return '<span class="' . $class . '">' . wptexturize( do_shortcode( $content ) ) . '</span>';
}
add_shortcode( 'bt_drop_cap', 'bt_drop_cap' );

// [bt_image]
class bt_image {
	static function init() {
		add_shortcode( 'bt_image', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'image'  		=> '',
			'caption_text'	=> '',
			'size'     		=> '',
			'shape'     	=> '',
			'url'      		=> '',
			'target'      	=> '',
			'hover_type'    => '',
			'el_style' 		=> '',
			'el_class' 		=> ''
		), $atts, 'bt_image' ) );
		
		$image = sanitize_text_field( $image );
		$caption_text = $caption_text;
		$size = sanitize_text_field( $size );
		$shape = sanitize_text_field( $shape );
		$url = sanitize_text_field( $url );
		$target = sanitize_text_field( $target );
		$hover_type = sanitize_text_field( $hover_type ); 
		$el_style = sanitize_text_field( $el_style );
		$el_class = 'btTextCenter ' . sanitize_text_field( $el_class );

		if ( strpos( $caption_text, PHP_EOL ) !== false) {
			$caption_text = '<p>' . str_replace( "\n", '</p><p>', $caption_text ) . '</p>';
		}

		if ( $target == '' ) $target = "_self";
		if ( $hover_type != '' ) $el_class .= " " . $hover_type;
		$alt = '';
		
		$caption = '';
		if ( $image != '' ) {
			$post_image = get_post( $image );
			if ( $post_image ) $caption = get_post( $image )->post_excerpt;
			$image = wp_get_attachment_image_src( $image, $size );
			$image = $image[0];
			$alt = get_post_meta($post_image->ID, '_wp_attachment_image_alt', true);
		}
 		
		return boldthemes_get_image_html( $image, '', $caption_text, $size, $shape, $url, $target, false, $el_style, $el_class, $alt );
	}
}

remove_shortcode( 'image' );
// [image]
class image {
	static function init() {
		add_shortcode( 'image', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts ) {
		extract( shortcode_atts( array(
				'ids'      => '',
				'orderby'  => '',
				'order'    => '',
				'size'     => '',
				'el_style' => '',
				'el_class' => ''
		), $atts, 'gallery' ) );

		$ids = sanitize_text_field( $ids );
		$orderby = sanitize_text_field( $orderby );
		$order = sanitize_text_field( $order );
		$el_style = sanitize_text_field( $el_style );
		$el_class = sanitize_text_field( $el_class );
		$size = sanitize_text_field( $size );

		if ( $orderby == 'post_date' ) {
			$orderby = 'date';
		}

		if ( $orderby == '' ) {
			$orderby = 'post__in';
		}

		if ( $order == '' ) {
			$order = 'ASC';
		}

		if ( $size == '' ) {
			$size = 'large';
		}

		$ids = trim( $ids );
		$ids = explode( ',', $ids );
		$the_query = new WP_Query( array ( 'post_type' => 'attachment', 'post_status' => 'any', 'orderby' => $orderby, 'order' => $order, 'post__in' => $ids, 'posts_per_page' => -1, 'nopaging' => true ) );

		$output = '';

		while ( $the_query->have_posts() ) {

			$the_query->the_post();
			$img = wp_get_attachment_image_src( $the_query->post->ID, $size );
				
			$img_full = wp_get_attachment_image_src( $the_query->post->ID, 'full' );
			$img_full = $img_full[0];

			$img = $img[0];
			$caption = $the_query->post->post_excerpt;
			$title = $the_query->post->post_title;
				
			$output = '<div class="btImage"><img src="' . esc_url( $img ) . '" alt="' . esc_attr( $title ) . '"></div>';
				
		}

		wp_reset_postdata();


		return $output;
	}
}

remove_shortcode( 'gallery' );
// [gallery]
class gallery {
	static function init() {
		add_shortcode( 'gallery', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'ids'      => '',
			'orderby'  => '',
			'order'    => '',
			'size'     => '',
			'el_style' => '',
			'el_class' => ''
		), $atts, 'gallery' ) );
		
		$ids = sanitize_text_field( $ids );
		$orderby = sanitize_text_field( $orderby );
		$order = sanitize_text_field( $order );
		$el_style = sanitize_text_field( $el_style );
		$el_class = sanitize_text_field( $el_class );
		$size = sanitize_text_field( $size );
		
		if ( $orderby == 'post_date' ) {
			$orderby = 'date';
		}
		
		if ( $orderby == '' ) {
			$orderby = 'post__in';
		}
		
		if ( $order == '' ) {
			$order = 'ASC';
		}
		
		if ( $size == '' ) {
			$size = 'large';
		}
		
		$ids = trim( $ids );
		$ids = explode( ',', $ids );
		$the_query = new WP_Query( array ( 'post_type' => 'attachment', 'post_status' => 'any', 'orderby' => $orderby, 'order' => $order, 'post__in' => $ids, 'posts_per_page' => -1, 'nopaging' => true ) );
		
		$output = '';
		
		while ( $the_query->have_posts() ) {
		
			$the_query->the_post();
			$img = wp_get_attachment_image_src( $the_query->post->ID, $size );
			
			$img_full = wp_get_attachment_image_src( $the_query->post->ID, 'full' );
			$img_full = $img_full[0];			
	
			$img = $img[0];
			$caption = $the_query->post->post_excerpt;
			$title = $the_query->post->post_title;
			
			$output .= '<div class="bpbItem"><img src="' . esc_url( $img ) . '" alt="' . esc_attr( $title ) . '"></div>';
			
		}
		
		wp_reset_postdata();
		
		$class_html = '';
		if ( $el_class != '' ) {
			$class_html = ' ' . $el_class;
		}
		
		$style_html = '';
		if ( $el_style != '' ) {
			$style_html= ' ' . 'style="' . $el_style . '"';
		}		

		$output = '<div class="boldPhotoSlide' . $class_html . '"' . $style_html . '>' . $output . '</div>';
		
		return $output;
	}
}

// [bt_grid_gallery]
class bt_grid_gallery {
	static function init() {
		add_shortcode( 'bt_grid_gallery', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts ) {
	
		wp_enqueue_script( 
			'bt_imagesloaded',
			plugin_dir_url( __FILE__ ) . 'imagesloaded.pkgd.min.js',
			array( 'jquery' ),
			'',
			true
		);
		
		wp_enqueue_script( 
			'bt_packery',
			plugin_dir_url( __FILE__ ) . 'packery.pkgd.min.js',
			array( 'jquery' ),
			'',
			true
		);	
		
		wp_enqueue_script( 
			'bt_grid_tweak',
			plugin_dir_url( __FILE__ ) . 'bt_grid_tweak.js',
			array( 'jquery' ),
			'',
			true
		);
	
		wp_enqueue_script( 
			'bt_grid_gallery',
			plugin_dir_url( __FILE__ ) . 'bt_grid_gallery.js',
			array( 'jquery' ),
			'',
			true
		);
	
		extract( shortcode_atts( array(
			'ids'       => '',
			'format'    => '',
			'grid_gap'  => '',
			'columns'   => '',
			'lightbox'  => '',
			'orderby'   => '',
			'order'     => '',
			'has_thumb' => '',
			'links'     => '',
			'el_style'  => '',
			'el_class'  => ''
		), $atts, 'bt_grid_gallery' ) );
		
		$ids = sanitize_text_field( $ids );
		$format = sanitize_text_field( $format );
		$grid_gap = sanitize_text_field( $grid_gap );
		$columns = sanitize_text_field( $columns );
		$lightbox = sanitize_text_field( $lightbox );
		$orderby = sanitize_text_field( $orderby );
		$order = sanitize_text_field( $order );
		$has_thumb = sanitize_text_field( $has_thumb );
		$links = sanitize_text_field( $links );
		$el_style = sanitize_text_field( $el_style );
		$el_class = sanitize_text_field( $el_class );
		
		$format_arr = explode( ',', $format );
		
		$links_arr = explode( ',', $links );
		
		if ( $orderby == 'post_date' ) {
			$orderby = 'date';
		}
		
		if ( $orderby == '' ) {
			$orderby = 'post__in';
		}
		
		if ( $order == '' ) {
			$order = 'ASC';
		}

		if ( $grid_gap != '' ) {
			$el_class .= ' btGridGap-' . $grid_gap;
		}
		
		$ids = trim( $ids );
		$ids = explode( ',', $ids );
		$the_query = new WP_Query( array ( 'post_type' => 'attachment', 'post_status' => 'any', 'orderby' => $orderby, 'order' => $order, 'post__in' => $ids, 'posts_per_page' => -1, 'nopaging' => true ) );
		
		$output = '';
		
		$n = 0;
		
		$lightbox_class = '';
		
		while ( $the_query->have_posts() ) {

			$the_query->the_post();
			
			$size = 'boldthemes_grid_11';
			$tile_format = '11';
			
			if ( isset( $format_arr[ $n ] ) ) {
				if ( $format_arr[ $n ] == '11' ) {
					$size = 'boldthemes_grid_11';
					$tile_format = '11';
				} else if ( $format_arr[ $n ] == '21' ) {
					$size = 'boldthemes_grid_21';
					$tile_format = '21';
				} else if ( $format_arr[ $n ] == '12' ) {
					$size = 'boldthemes_grid_12';
					$tile_format = '12';
				} else if ( $format_arr[ $n ] == '22' ) {
					$size = 'boldthemes_grid_22';
					$tile_format = '22';
				}
			}
			
			$img = wp_get_attachment_image_src( $the_query->post->ID, $size );
			$img = $img[0];
			
			$caption = $the_query->post->post_excerpt;
			
			$data_order_num = $n;
			if ( $has_thumb == 'yes' ) {
				$data_order_num++;
			}
			
			if ( ! boldthemes_get_option( 'pf_ghost_slider' ) ) {
				$data_order_num--;
			}
			
			if ( $lightbox != 'yes' ) {
				$link = '<a href="#"></a>';
			} else {
				$lightbox_class = ' ' . 'lightbox';
				$img_full = wp_get_attachment_image_src( $the_query->post->ID, 'full' );
				$img_full = $img_full[0];
				$link = '<a href="' . esc_url( $img_full ) . '" class="lightbox" data-title="' . esc_attr( $caption ) . '"></a>';
			}
			
			if ( isset( $links_arr[ $n ] ) && $links_arr[ $n ] != '' ) {
				$lightbox_class = '';
				$link = '<a href="' . $links_arr[ $n ] . '" target="_blank"></a>';
			}

			$output .= '<div class="gridItem btGhostSliderThumb bt' . $tile_format . '" data-order-num="' . esc_attr( $data_order_num ) . '"><div class="btTileBox">' . boldthemes_get_image_html( $img, $caption, '', $size, '', $link, '_self', false, '', '' ) . '</div></div>';
			
			$n++;
		}
		
		wp_reset_postdata();
		
		$class_html = '';
		if ( $el_class != '' ) {
			$class_html = ' ' . $el_class;
		}
		
		$style_html = '';
		if ( $el_style != '' ) {
			$style_html= ' ' . 'style="' . $el_style . '"';
		}		

		$output = '<div class="tilesWall btGridGallery tiled' . $class_html . $lightbox_class . '"' . $style_html . ' data-col="' . $columns . '"><div class="gridSizer"></div>' . $output . '</div>';
		
		return $output;
	}
}

// [bt_section]
class bt_section {
	static function init() {
		add_shortcode( 'bt_section', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		
		extract( shortcode_atts( array(
			'layout'            => '', // boxed/wide
			'top_spaced'        => '', // not-spaced/semiSpaced/spaced/extraSpaced
			'bottom_spaced'     => '', // not-spaced/semiSpaced/spaced/extraSpaced
			'skin'              => '', // inherit/dark/light
			'full_screen'       => '', // no/yes
			'vertical_align'    => '', // inherit/top/middle/bottom
			'back_image'        => '',
			'back_color'        => '',
			'back_video'        => '',
			'video_settings'    => '',
			'parallax'          => '',
			'parallax_offset'   => '',
			'animation'         => '',
			'animation_back'    => '',
			'animation_impress' => '',
			'divider'           => '', // no/yes
			'el_id'             => '',
			'el_class'          => '',
			'el_style'          => ''
		), $atts, 'bt_section' ) );
		
		$layout = sanitize_text_field( $layout );
		$top_spaced = sanitize_text_field( $top_spaced );
		$bottom_spaced = sanitize_text_field( $bottom_spaced );
		$skin = sanitize_text_field( $skin );
		$full_screen = sanitize_text_field( $full_screen );
		$vertical_align = sanitize_text_field( $vertical_align );
		$back_image = sanitize_text_field( $back_image );
		$back_color = sanitize_text_field( $back_color );
		$back_video = sanitize_text_field( $back_video );
		$video_settings = sanitize_text_field( $video_settings );
		$parallax = sanitize_text_field( $parallax );
		$parallax_offset = sanitize_text_field( $parallax_offset );
		$animation = sanitize_text_field( $animation );
		$animation_back = sanitize_text_field( $animation_back );
		$animation_impress = sanitize_text_field( $animation_impress );
		$divider = sanitize_text_field( $divider );
		$el_id = sanitize_text_field( $el_id );
		$el_class = sanitize_text_field( $el_class );
		$el_style = sanitize_text_field( $el_style );
		
		$class = array( 'boldSection' );

		if ( $divider != 'no' && $divider != '' ) {
			$class[] = 'btDivider';
		}

		if ( $top_spaced != 'not-spaced' && $top_spaced != '' ) {
			$class[] = $top_spaced;
		}

		if ( $bottom_spaced != 'not-spaced' && $bottom_spaced != '' ) {
			$class[] = $bottom_spaced;
		}
		
		if ( $skin == 'dark' ) {
			$class[] = 'btDarkSkin';
		} else if ( $skin == 'light' ) {
			$class[] = 'btLightSkin';
		}
		
		if ( $layout != 'wide' ) {
			$class[] = 'gutter';
		}

		if ( $full_screen == 'yes' && ! MedicareTheme::$boldthemes_sidebar ) {
			$class[] = 'fullScreenHeight';
		}

		if ( $vertical_align != 'Inherit' && $vertical_align != '' ) {
			$class[] = $vertical_align;
		}

		$data_parallax_attr = '';
		if ( $parallax != '' && ! wp_is_mobile() ) {
		
			wp_enqueue_script( 
				'bt_parallax',
				plugin_dir_url( __FILE__ ) . 'bt_parallax.js',
				array( 'jquery' ),
				'',
				true
			);
		
			$data_parallax_attr = 'data-parallax="' . $parallax . '" data-parallax-offset="' . intval( $parallax_offset ) . '"';
			$class[] = 'btParallax';
		}
		
		if ( $back_image != '' ) {
			$back_image = wp_get_attachment_image_src( $back_image, 'full' );
			$back_image_url = $back_image[0];
			$back_image_style = 'background-image:url(\'' . $back_image_url . '\');';
			$el_style = $back_image_style . $el_style;	
			$class[] = 'wBackground cover';
		}

		if ( $back_color != '' ) {
			$back_color_style = 'background-color:' . $back_color . ';';
			$el_style = $back_color_style . $el_style;	
		}
		
		$page_anim = boldthemes_rwmb_meta( BoldThemesPFX . '_animations' );
		
		$http_user_agent = $_SERVER['HTTP_USER_AGENT'];
		$is_ie = false;
		if ( strpos( $http_user_agent, 'MSIE' ) || strpos( $http_user_agent, 'Trident/' ) || strpos( $http_user_agent, 'Edge/' ) ) {
			$is_ie = true;
		}
		
		/*if ( $is_ie && $page_anim == 'impress' && $animation_impress != '' ) {
			$page_anim = '';
			$animation = '0';
		}*/
		
		$data_anim_attr = '';
		$data_anim_back_attr = '';
		if ( $page_anim != 'impress' && $animation != '' ) {
			wp_enqueue_style( 'bt_section_anims_css', plugin_dir_url( __FILE__ ) . 'css/animations.css', array(), false );
			wp_enqueue_script( 
				'bt_section_anims_js',
				plugin_dir_url( __FILE__ ) . 'pagetransitions.js',
				array( 'jquery' ),
				'',
				true
			);
			$data_anim_attr = ' ' . 'data-animation="' . $animation . '"';
			$data_anim_back_attr = ' ' . 'data-animation-back="' . $animation_back . '"';
		}
		
		$data_anim_impress_attr = '';
		if ( $page_anim == 'impress' && $animation_impress != '' ) {
			$temp_arr = explode( ';', $animation_impress );
			if ( count( $temp_arr ) == 3 ) {
				$class[] = 'step';
				wp_enqueue_script( 
					'bt_impress',
					plugin_dir_url( __FILE__ ) . 'impress.js',
					array( 'jquery' ),
					'',
					true
				);
				wp_enqueue_script( 
					'bt_impress_custom',
					plugin_dir_url( __FILE__ ) . 'impress_custom.js',
					array( 'jquery' ),
					'',
					true
				);
				$data_anim_impress_attr = ' ';
				for ( $i = 0; $i < 3; $i++ ) {
					$temp_arr1 = explode( ',', $temp_arr[ $i ] );
					
					if ( $i == 0 ) {
						if ( $is_ie ) {
							$temp_arr1[2] = 0;
						}
						$data_anim_impress_attr .= 'data-x="' . intval( $temp_arr1[0] ) . '" data-y="' . intval( $temp_arr1[1] ) . '" data-z="' . intval( $temp_arr1[2] ) . '"';
					} else if ( $i == 1 ) {
						if ( $is_ie ) {
							$temp_arr1[1] = 0;
							$temp_arr1[2] = 0;
						}
						$data_anim_impress_attr .= ' ' . 'data-rotate="' . intval( $temp_arr1[0] ) . '" data-rotate-x="' . intval( $temp_arr1[1] ) . '" data-rotate-y="' . intval( $temp_arr1[2] ) . '"';
					} else if ( $i == 2 ) {
						$data_anim_impress_attr .= ' ' . 'data-scale="' . floatval( $temp_arr1[0] ) . '"';
					}
				}
			}
		}
		
		$id_attr = '';
		if ( $el_id == '' ) {
			$el_id = uniqid( 'bt_section' );
		}
		$id_attr = 'id="' . $el_id . '"';
		
		$back_video_attr = '';
		if ( $back_video != '' ) {
			wp_enqueue_style( 'bt_style_yt', plugin_dir_url( __FILE__ ) . 'css/YTPlayer.css', array(), false );
			wp_enqueue_script( 
				'bt_yt',
				plugin_dir_url( __FILE__ ) . 'jquery.mb.YTPlayer.min.js',
				array( 'jquery' ),
				'',
				true
			);
			
			$class[] = 'bt_yt_video';
			
			if ( $video_settings == '' ) {
				$video_settings = 'showControls:false,showYTLogo:false,mute:true,stopMovieOnBlur:false,opacity:1';
			}
			
			$back_video_attr = ' ' . 'data-property="{videoURL:\'' . $back_video . '\',containment:\'self\',' . $video_settings . '}"';
			$proxy = new YT_Video_Proxy();
			add_action( 'wp_footer', array( $proxy, 'js_init' ) );
		}
		
		if ( $el_class != '' ) {
			$class[] = $el_class;
		}
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}
		

		$output = '<section ' . $id_attr . ' ' . $data_parallax_attr . ' class="' . implode( ' ', $class ) . '" ' . $style_attr . $back_video_attr . $data_anim_attr . $data_anim_back_attr . $data_anim_impress_attr . '>';
			$output .= '<div class="port">';
				$output .= '<div class="boldCell">';
					$output .= '<div class="boldCellInner">';
					$output .= wptexturize( do_shortcode( $content ) );
					$output .= '</div>';
				$output .= '</div>';
		$output .= '</div>';

		$output .= '</section>';
		
		return $output;
	}
}

class YT_Video_Proxy {
	function __construct() {
		
	}	

	public function js_init() { ?>
		<script>
			jQuery(function() {
				jQuery( '.bt_yt_video' ).YTPlayer();
			});
		</script>
	<?php }
}

// [bt_row]
class bt_row {
	static function init() {
		add_shortcode( 'bt_row', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'el_class'  	     => '',
			'el_style'  		 => ''
		), $atts, 'bt_row' ) );
		
		$el_class = sanitize_text_field( $el_class );
		$el_style = sanitize_text_field( $el_style );
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}
	
		$output = '<div class="boldRow ' . $el_class . '" ' . $style_attr . '>';
		$output .= '<div class="boldRowInner">';
		$output .= wptexturize( do_shortcode( $content ) );
		$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}
}

// [bt_row_inner]
class bt_row_inner {
	static function init() {
		add_shortcode( 'bt_row_inner', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'el_class'  	     => '',
			'el_style'  		 => ''
		), $atts, 'bt_row_inner' ) );
		
		$el_class = sanitize_text_field( $el_class );
		$el_style = sanitize_text_field( $el_style );
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}
	
		$output = '<div class="boldRow boldInnerRow ' . $el_class . '" ' . $style_attr . '>';
		$output .= wptexturize( do_shortcode( $content ) );
		$output .= '</div>';
		
		return $output;
	}
}

// [bt_column]
class bt_column {
	static function init() {
		add_shortcode( 'bt_column', array( __CLASS__, 'handle_shortcode' ) );
	}
	
	static function hex2rgb($hex) {
		$hex = str_replace("#", "", $hex);
	
		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		$rgb = array($r, $g, $b);
		//return implode(",", $rgb); // returns the rgb values separated by commas
		return $rgb; // returns an array with the rgb values
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'width'    		         => '',
			'align'   		         => '', // inherit/left/right/center
			'animation'		         => '', // no_animation/...
			'vertical_align'         => '', // inherit/top/middle/bottom
			'border'                 => '',
			'cell_padding'           => '', 
			'text_indent'	         => '', 
			'highlight'              => '', 
			'background_image'       => '', 
			'background_color'       => '',
			'inner_background_color' => '',
			'opacity'	             => '', 
			'el_class' 		         => '',
			'el_style'		         => ''
		), $atts, 'bt_column' ) );
		
		$class = array( 'rowItem' );
		
		if ( $border == 'btLeftBorder' || $border == 'btRightBorder' ) {
			$class[] = $border;
		}
		
		$array = explode( '/', $width );

		if ( empty( $array ) || $array[0] == 0 || $array[1] == 0 ) {
			$width = 12;
		} else {
			$top = $array[0];
			$bottom = $array[1];
			
			$width = 12 * $top / $bottom;
			
			if ( ! is_int( $width ) || $width < 1 || $width > 12 ) {
				$width = 12;
			}
		}
		
		if ( $width == 2 ) {
			$class[] = 'col-md-2  col-sm-4 col-ms-12';
		} else if ( $width == 3 ) {
			$class[] = 'col-md-3 col-sm-6 col-ms-12';
		} else if ( $width == 4 ) {
			$class[] = 'col-md-4 col-ms-12';
		} else if ( $width == 6 ) {
			$class[] = 'col-md-6 col-sm-12';	
		} else if ( $width == 8 ) {
			$class[] = 'col-md-8 col-ms-12';
		} else {
			$class[] = 'col-md-' . $width . ' col-ms-12 ';
		}
		
		if ( $align == 'left' || $align == '' || $align == 'inherit' ) {
			$class[] = 'btTextLeft';
		} else if ( $align == 'right' ) {
			$class[] = 'btTextRight';
		} else if ( $align == 'center' ) {
			$class[] = 'btTextCenter';
		}
		
		if ( $animation != 'no_animation' && $animation != '' ) {
			$class[] = $animation;
		}		

		if ( $text_indent != 'no_text_indent' && $text_indent != '' ) {
			$class[] = $text_indent;
		}	
		
		if ( $highlight != 'no_highlight' && $highlight != '' ) {
			$class[] = $highlight;
		}	

		if ( $vertical_align != 'Inherit' && $vertical_align != '' ) {
			$class[] = $vertical_align;
		}		

		if ( $cell_padding != 'default' && $cell_padding != '' ) {
			$class[] = $cell_padding;
		}	
		
		if ( $el_class != '' ) {
			$class[] = $el_class;
		}
				
		if ( $opacity == '' ) {
			$opacity = 1;
		}

		if ( $background_image != '' ) {
			$image = wp_get_attachment_image_src( $background_image, 'full' );
			$image = $image[0];
			$el_style .= 'background-image: url(' . $image . ');';
			$class[] = 'wBackground cover';
		}	
		
		if ( $background_color != '' ) {
			$background_color = bt_column::hex2rgb( $background_color );
			if ( $opacity == '' ) $opacity = '1';
			$el_style .= 'background-color: rgba(' . $background_color[0] . ', ' . $background_color[1] . ', ' . $background_color[2] . ', ' . $opacity . ');';
		}

		$style_attr = '';

		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}

		$inner_el_style = '';
		if ( $inner_background_color != '' ) {
			$inner_el_style .= 'style = "background-color:' . $inner_background_color . ';"';
		}

		$output = '<div class="' . implode( ' ', $class ) . '" ' . $style_attr . ' >';  
			$output .= '<div class="rowItemContent" ' . $inner_el_style . '>';
				$output .= wptexturize( do_shortcode( $content ) );
			$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}
}

// [bt_column_inner]
class bt_column_inner {
	static function init() {
		add_shortcode( 'bt_column_inner', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'width'    		   => '',
			'align'   		   => '',
			'vertical_align'   => '',
			'cell_padding'     => '',
			'highlight'		   => '',
			'background_color' => '',
			'opacity'	       => '', 
			'el_class' 		   => '',
			'el_style'		   => ''
		), $atts, 'bt_column_inner' ) );
		
		$class = array( 'rowItem rowInnerItem' );
		
		$array = explode( '/', $width );

		if ( empty( $array ) || $array[0] == 0 || $array[1] == 0 ) {
			$width = 12;
		} else {
			$top = $array[0];
			$bottom = $array[1];
			
			$width = 12 * $top / $bottom;
			
			if ( ! is_int( $width ) || $width < 1 || $width > 12 ) {
				$width = 12;
			}
		}
		
		$class[] = 'col-md-' . $width . ' ';
		
		if ( $align == 'left' || $align == '' || $align == 'inherit' ) {
			$class[] = 'btTextLeft';
		} else if ( $align == 'right' ) {
			$class[] = 'btTextRight';
		} else if ( $align == 'center' ) {
			$class[] = 'btTextCenter';
		}

		if ( $highlight != 'no_highlight' && $highlight != '' ) {
			$class[] = $highlight;
		}	

		if ( $vertical_align != 'Inherit' && $vertical_align != '' ) {
			$class[] = $vertical_align;
		}		

		if ( $cell_padding != 'default' && $cell_padding != '' ) {
			$class[] = $cell_padding;
		}
		
		if ( $el_class != '' ) {
			$class[] = $el_class;
		}
		
		if ( $opacity == '' ) {
			$opacity = 1;
		}		
		
		if ( $background_color != '' ) {
			$background_color = bt_column::hex2rgb( $background_color );
			if ( $opacity == '' ) $opacity = '1';
			$el_style .= 'background-color: rgba(' . $background_color[0] . ', ' . $background_color[1] . ', ' . $background_color[2] . ', ' . $opacity . ');';
		}		

		$style_attr = '';

		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}

		$output = '<div class="' . implode( ' ', $class ) . '" ' . $style_attr . ' >';  
			$output .= '<div class="rowItemContent">';
				$output .= wptexturize( do_shortcode( $content ) );
			$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}
}

// [bt_custom_menu]
class bt_custom_menu {
	static function init() {
		add_shortcode( 'bt_custom_menu', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'menu'  			=> '',	
			'el_class'  	     => '',
			'el_style'  		 => ''
		), $atts, 'bt_row' ) );
		
		$menu = sanitize_text_field( $menu );
		$el_class = sanitize_text_field( $el_class );
		$el_style = sanitize_text_field( $el_style );
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}

		if ( $menu != '' ) {
			$output = '<div class="btCustomMenu ' . $el_class . '" ' . $style_attr . '>';
			// $output .= wptexturize( do_shortcode( $content ) );
			$output .= wp_nav_menu( array( 'menu' => $menu, 'echo' => false ) );
			$output .= '</div>';
		}
		
		return $output;
	}
}

// [bt_text]
class bt_text {
	static function init() {
		add_shortcode( 'bt_text', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'el_class' 			=> '',
			'el_style'			=> ''
		), $atts, 'bt_text' ) );
		
		$el_class = sanitize_text_field( $el_class );
		$el_style = sanitize_text_field( $el_style );

		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}

		$output = '<div class="btText" ' . $style_attr . '>' . wptexturize( wpautop ( do_shortcode( $content ) ) ) . '</div>';
		
		return $output;
	}
}

// [bt_header]
class bt_header {
	static function init() {
		add_shortcode( 'bt_header', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'superheadline'		=> '',
			'headline'			=> '',
			'headline_size'		=> '', // small/medium/large/extralarge/huge
			'dash'				=> '', // no/top/bottom
			'dash_style'		=> '',
			'subheadline'		=> '', 
			'el_class' 			=> '',
			'el_style'			=> ''
		), $atts, 'bt_header' ) );

		require_once( get_template_directory() . '/php/boldthemes_functions.php' );

		$headline = str_replace( "\n", '<br>', $headline );
		$subheadline = str_replace( "\n", '<br>', $subheadline );
		
		return boldthemes_get_heading_html( $superheadline, $headline, $subheadline, $headline_size, $dash, $el_class . ' ' . $dash_style, $el_style );
	}
}

// [bt_tabs]
class bt_tabs {
	static function init() {
		add_shortcode( 'bt_tabs', array( __CLASS__, 'handle_shortcode' ) );
	}
	
	static function handle_shortcode( $atts, $content ) {
	
		$content = do_shortcode( $content );
		$content = explode( '%$%', $content );	
		
		$output = '<div class="btTabs tabsHorizontal">';
			$output .='<ul class="tabsHeader">';
				for ( $i = 0; $i < count( $content ); $i = $i + 2 ) {
					$output .= wptexturize( $content[ $i ] );
				}
			$output .='</ul>';
			$output .='<div class="tabPanes tabPanesTabs">';
				for ( $i = 1; $i < count( $content ); $i = $i + 2 ) {
					$output .= wptexturize( $content[ $i ] );
				}
			$output .='</div>';
		$output .='</div>';
			
		return $output;
	}
}
class bt_tabs_proxy {
	function __construct() {
	}	
}

// [bt_tabs_items]
class bt_tabs_items {
	static function init() {
		add_shortcode( 'bt_tabs_items', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'headline'	=> '',
		), $atts, 'bt_tabs_items' ) );

		$headline = sanitize_text_field( $headline );

		$output1 = '<li><span>' . $headline . '</span></li>';
		
		$output2 = '<div class="tabPane">
			<div class="tabAccordionContent">' . wptexturize( wpautop( $content ) ) . '</div>
		</div>';
		
		return $output1 . '%$%' . $output2 . '%$%';

	}
}

// [bt_accordion]
class bt_accordion {
	static function init() {
		add_shortcode( 'bt_accordion', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
				'open_first' => '',
		), $atts, 'bt_accordion' ) );
	
		$content = do_shortcode( $content );
		$content = explode( '%$%', $content );	

		$output = '<div class="btTabs tabsVertical" data-open-first="' . $open_first . '">';
			$output .= '<ul class="tabsHeader">';
				for ( $i = 0; $i < count( $content ); $i = $i + 2 ) {
					$output .= wptexturize( $content[ $i ] );
				}
			$output .= '</ul>';
			$output .= '<div class="tabPanes accordionPanes">';
				for ( $i = 1; $i < count( $content ); $i = $i + 2 ) {
					$output .= wptexturize( $content[ $i ] );
				}
			$output .= '</div>';
		$output .= '</div>';

		$proxy = new bt_accordion_proxy();
		add_action( 'wp_footer', array( $proxy, 'js_init' ) );
		
		return $output;
	}
}
class bt_accordion_proxy {
	function __construct() {
	}	

	public function js_init() { ?>
		
	<?php }
}

// [bt_accordion_items]
class bt_accordion_items {
	static function init() {
		add_shortcode( 'bt_accordion_items', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
				'headline'	=> '',
		), $atts, 'bt_accordion_items' ) );

		$headline = sanitize_text_field( $headline );

		$output1 = '<li><span>' . $headline . '</span></li>';
		
		$output2 = '<div class="tabPane">
			<div class="tabAccordionTitle"><span>' . $headline . '</span></div>
			<div class="tabAccordionContent">' . wptexturize( wpautop( $content ) ) . '</div>
		</div>';
		
		return $output1 . '%$%' . $output2 . '%$%';

	}
}

// [bt_service]
class bt_service {
	static function init() {
		add_shortcode( 'bt_service', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'icon'      => '',
			'icon_type' => '',
			'icon_size' => '',
			'icon_color' => '',
			'url'       => '',
			'headline'  => '',
			'dash'		=> '',
			'text'      => '',
			'el_style'  => '',
			'el_class'  => ''
		), $atts, 'bt_service' ) );
		
		$icon = sanitize_text_field( $icon );
		$icon_type = sanitize_text_field( $icon_type );
		$icon_size = sanitize_text_field( $icon_size );
		$icon_color = sanitize_text_field( $icon_color );
		$url = sanitize_text_field( $url );
		$headline = sanitize_text_field( $headline );
		$dash = sanitize_text_field( $dash );
		$el_style = sanitize_text_field( $el_style );
		$el_class = sanitize_text_field( $el_class );

		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = ' style="' . $el_style . '"';
		}
		
		if (strpos($text, PHP_EOL) !== false) {
			$text = str_replace( "\n", '<br/>', $text ) ;
		}
		
		require_once( get_template_directory() . '/php/boldthemes_functions.php' );
		
		$output = '<div class="servicesItem ' . ' ' . $icon_color . 'Icon ' . $icon_size . 'Icon ' . $el_class . '"' . $style_attr . '>';
			$output .= '<div class="sIcon">';
				$output .= boldthemes_get_icon_html( $icon, $url, '', $icon_size . ' ' . $icon_type . ' ' . $icon_color );
			$output .= '</div>';
			if ( $headline != '' || $text != '') {
				$output .= '<div class="sTxt">';
					$output .= boldthemes_get_heading_html( '', $headline, '', 'small', $dash, '', '' ) . '<p>' . $text . '</p>';
				$output .= '</div>';
			}

		$output .= '</div>';
		
		return $output;
	}
}

// [bt_gmaps]
class bt_gmaps {
	static function init() {
		add_shortcode( 'bt_gmaps', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {

		extract( shortcode_atts( array(
			'api_key'         => '',
			'latitude'        => '',
			'longitude'       => '',
			'zoom'            => '',
			'icon'            => '',
			'height'          => '',
			'primary_color'   => '',
			'secondary_color' => '',
			'custom_style'    => '',
			'water_color'     => '',
			'el_style'        => '',
			'el_class'        => ''
		), $atts, 'bt_gmaps' ) );
		
		if ( $api_key != '' ) {
			wp_enqueue_script( 
				'gmaps_api',
				'https://maps.googleapis.com/maps/api/js?key=' . $api_key
			);
		} else {
			wp_enqueue_script( 
				'gmaps_api',
				'https://maps.googleapis.com/maps/api/js?v=&sensor=false'
			);
		}

		wp_enqueue_script( 
			'bt_gmap_init',
			plugin_dir_url( __FILE__ ) . 'bt_gmap.js',
			array( 'jquery' ),
			'',
			true
		);
		
		if ( $zoom == '' ) $zoom = 14;
		if ( $height == '' ) $height = '250px';

		$icon_img = '""';
		if ( $icon != '' ) {
			$icon_tmp = wp_get_attachment_image_src( $icon, 'small' );
			$icon_img = '"' . $icon_tmp[0] . '"';
		}
		
		if ( $el_class != '' ) {
			$el_class = 'class="btGmap ' . $el_class . '"';
		} else {
			$el_class = 'class="btGmap"';
		}
		
		$map_id = uniqid( 'map_canvas' );
			
		if ( $content != '' ) {
			$content = '<div class="btGoogleMapsContent"><div class="btGoogleMapsWrap"><span class="btInfoPaneToggler"></span>' . wptexturize( do_shortcode( $content ) ) . '</div></div>';
		}

		return '
		<div class="btGoogleMapsWrapper"><div id="' . $map_id . '" style="height:' . $height . ';' . $el_style . ';" ' . $el_class . '></div>' . $content . '</div>
		<script type="text/javascript">
			jQuery( document ).ready(function() {
				bt_gmap_init( ' . $map_id . ', ' . $latitude . ', ' . $longitude . ', ' . $zoom . ', ' . $icon_img . ', "' . $primary_color . '", "' . $secondary_color . '", "' . $water_color . '", "' . $custom_style . '" );
				});	
		</script>
		';
	}
}

// [bt_clients]
class bt_clients {
	static function init() {
		add_shortcode( 'bt_clients', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'display_type'    => ''
		), $atts, 'bt_clients' ) );
		
		$display_type = sanitize_text_field( $display_type );

		if ( $display_type == 'regular' ) {
			$extra_class = 'boldClientRegularList';
			$inner_class = '';
		} else {
			$extra_class = 'boldClientList';
			$inner_class = 'bclPort';
		}
		
		$output = '<div class="' . $extra_class . '">';
			$output .= '<div class="' . $inner_class . '">';
				$output .= wptexturize( do_shortcode( $content ) );
			$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}
}


// [bt_client]
class bt_client {
	static function init() {
		add_shortcode( 'bt_client', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'image'    => '',
			'url'      => ''
		), $atts, 'bt_client' ) );
		
		$image = sanitize_text_field( $image );
		$url = sanitize_text_field( $url );
		
		if ( $image != '' ) {
			$image = wp_get_attachment_image_src( $image, 'medium' );
			$image = $image[0];
		}
		
		$output = '<div class="bclItem">';
			$output .= '<div class = "bclItemChild"><img src = "' . get_template_directory_uri() . '/gfx/aspect-square.png" alt="Aspect image">';
				if ( $url != '' ) {
					$output .= '<div style="background-image:url(' . $image . ');"><a href="' . $url . '"></a></div>';
				} else {
					$output .= '<div style="background-image:url(' . $image . ');"></div>';
				}
			$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}
}

// [bt_button]
class bt_button {
	static function init() {
		add_shortcode( 'bt_button', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'text'				=> '',
			'icon'				=> '',
			'url'				=> '',
			'target'			=> '',
			'style'				=> '',
			'icon_position'		=> '',
			'color'				=> '',
			'size'				=> '',
			'width'				=> '',
			'el_style'			=> '',
			'el_class'			=> ''			
		), $atts, 'bt_button' ) );
		
		$text = sanitize_text_field( $text );
		$icon = sanitize_text_field( $icon );
		$url = sanitize_text_field( $url );
		$target = sanitize_text_field( $target );
		$style = sanitize_text_field( $style );
		$icon_position = sanitize_text_field( $icon_position );
		$color = sanitize_text_field( $color );
		$size = sanitize_text_field( $size );
		$width = sanitize_text_field( $width );
		$el_style = sanitize_text_field( $el_style );
		$el_class = sanitize_text_field( $el_class );		
		
		$class = array( 'btBtn' );
		
		if ( $style != '' ) {
			$class[] = 'btn'.$style.'Style';
		}

		if ( $color != '' ) {
			$class[] = 'btn'.$color.'Color';
		}
		 
		if ( $size != '' ) {
			$class[] = 'btn'.$size;
		} 
		
		if ( $width != '' ) {
			$class[] = 'btn'.$width.'Width';
		}

		if ( $el_class != '' ) {
			$class[] = $el_class;
		}

		if ( $icon_position == '' ) {
			$icon_position = 'Right';
		}
		$class[] = 'btn'.$icon_position.'Position';

		if ( $icon != '' && $icon != 'no_icon' ) {
			$class[] = 'btnIco';
		}
			
		if ( $url == '' ) {
			$url = '#';
		}

		if ( $target != 'no_target' ) {
			$target = ' ' . 'target="' . $target . '"';
		} else {
			$target= '';
		}

		return boldthemes_get_button_html( $icon, $url, $text, $class, $el_style, $target );

	}
}

// [bt_counter]
class bt_counter {
	static function init() {
		add_shortcode( 'bt_counter', array( __CLASS__, 'handle_shortcode' ) );
	}
	
	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'number' => ''
		), $atts, 'bt_counter' ) );

		$number = sanitize_text_field( $number );
		$output = '';
		$output .= '<div class="btCounterHolder">';
		$output .= '<span class="btCounter animate" data-digit-length="' . strlen( $number ) . '">';
		
		for ( $i = 0; $i < strlen( $number ); $i++ ) {
			
			$output .= '<span class="onedigit p' . ( strlen( $number ) - $i ) . ' d' . $number[ $i ] . '" data-digit="' . $number[ $i ] . '">';
			
				if ( ctype_digit( $number[ $i ] ) ) {
					for ( $j = 0; $j <= 9; $j++ ) {
						$output .= '<span class="n' . $j . '">' . $j . '</span>';
					}
					$output .= '<span class="n0">0</span>';				
				} else {
					$output .= '<span>' . $number[ $i ] . '</span>';	
				}
			
			$output .= '</span>';
		}
		
		$output .= '</span>';
		$output .= '</div>';
			
		return $output;
	}
}

// [bt_percentage_bar]
class bt_percentage_bar {
	static function init() {
		add_shortcode( 'bt_percentage_bar', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'text'			=> '',
			'percentage'	=> '',
			'bar_color'		=> '',	
			'bar_style'		=> '',
			'el_style'		=> '',
			'el_class'		=> ''	
		), $atts, 'bt_percentage_bar' ) );

		$text = sanitize_text_field( $text );
		if( $text == '' ) $text = $percentage . '%';
		$percentage = sanitize_text_field( $percentage );
		$bar_color = sanitize_text_field( $bar_color );
		$bar_style = sanitize_text_field( $bar_style );
		$el_style = sanitize_text_field( $el_style );
		$el_class = sanitize_text_field( $el_class );
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = ' style="' . $el_style . '"';
		}

		$color_style_attr = '';
		if ( $bar_color != '' ) {
			if( $bar_style == 'Line' ) {
				$color_style_attr = ' style="border-color:' . $bar_color . '; color:' . $bar_color . ';"';	
			} else {
				$color_style_attr = ' style="background-color:' . $bar_color . ';"';	
			}
		}

		$class = array( 'btProgressBar', 'animate' );

		if ( $el_class != '' ) {
			$class[] = $el_class;
		}

		if ( $bar_style != '' ) {
			$class[] = 'btProgressBar' . $bar_style . 'Style';
		}

		$output = '';
		$output .= '<div class="' . implode( ' ', $class ) . '" '. $style_attr .'>';
		$output .= '<div class="btProgressContent">';
		$output .= '<div data-percentage="' . $percentage . '" class="btProgressAnim animate" ' . $color_style_attr . '></div>';
		$output .= '</div>';
		$output .= '<span>' . $text . '</span>';
		$output .= '</div>';

		return $output;
	}
}

// [bt_slider]
class bt_slider {
	static function init() {
		add_shortcode( 'bt_slider', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'auto_play'     => '',
			'height'        => '',
			'hide_arrows'   => '',
			'hide_paging'   => '',
			'simple_arrows' => '',
			'el_style'      => '',
			'el_class'      => ''			
		), $atts, 'bt_slider' ) );
		
		$auto_play = sanitize_text_field( $auto_play );
		$height = sanitize_text_field( $height );
		$hide_arrows = sanitize_text_field( $hide_arrows );
		$hide_paging = sanitize_text_field( $hide_paging );
		$el_style = sanitize_text_field( $el_style );
		$el_class = sanitize_text_field( $el_class );		
		
		$class = array( 'slided' );
		
		$slick_data = '';
		$auto_play = intval( $auto_play );
		if ( $auto_play > 0 ) {
			$slick_data = ' ' . "data-slick='{\"autoplay\":true,\"autoplaySpeed\":" . $auto_play . ",\"pauseOnHover\":false,\"pauseOnDotsHover\":true}'";
		}

		if ( $height == '' ) {
			$class[] = "autoSliderHeight";
		} else {
			$class[] = $height . "SliderHeight";
		}
		
		if ( $hide_arrows != '' ) {
			$class[] = $hide_arrows;
		}

		if ( $hide_paging != '' ) {
			$class[] = $hide_paging;
		}
		
		if ( $el_class != '' ) {
			$class[] = $el_class;
		}
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}
		
		$simple_arrows_data = '';
		
		if ( $simple_arrows == 'yes' ) {
			$simple_arrows_data = 'data-simple_arrows="yes"';
		} else {
			$simple_arrows_data = 'data-simple_arrows="no"';
		}

		$output = '<div class="' . implode( ' ', $class ) . '" ' . $style_attr . $slick_data . $simple_arrows_data . '>';
			$output .= wptexturize( do_shortcode( $content ) );
		$output .= '</div>';
		
		return $output;
	}
}

// [bt_slider_item]
class bt_slider_item {
	static function init() {
		add_shortcode( 'bt_slider_item', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'image'    => '',
			'el_style' => '',
			'el_class' => ''			
		), $atts, 'bt_slider_item' ) );
		
		$image = sanitize_text_field( $image );
		$el_style = sanitize_text_field( $el_style );
		$el_class = sanitize_text_field( $el_class );
		
		$img_full = '';
		$img_thumb = '';
		if ( $image != '' ) {
			$img_full = wp_get_attachment_image_src( $image, 'full' );
			$img_full = $img_full[0];
			$img_thumb = wp_get_attachment_image_src( $image, 'medium' );
			$img_thumb = $img_thumb[0];		
		}		
		
		$class = array( 'slidedItem', 'firstItem' );
		
		if ( $el_class != '' ) {
			$class[] = $el_class;
		}
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}

		$output = '<div class="' . implode( ' ', $class ) . '" ' . $style_attr . ' data-thumb="' . $img_thumb . '">';
			$output .= '<div class="btSliderPort wBackground cover" style="background-image: url(\'' . $img_full . '\')">';
				$output .= '<div class="btSliderCell" data-slick="yes">';
					$output .= '<div class="btSlideGutter">';
						$output .= '<div class="btSlidePane">';
							$output .= wptexturize( do_shortcode( $content ) );
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';	
		$output .= '</div>';		
		
		return $output;
	}
}

// [bt_hr]
class bt_hr {
	static function init() {
		add_shortcode( 'bt_hr', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'top_spaced'  			 => '',
			'bottom_spaced'  		 => '',
			'transparent_border'  	 => '',
			'el_style'				 => '',
			'el_class' 				 => ''			
		), $atts, 'bt_hr' ) );
		
		$top_spaced = sanitize_text_field( $top_spaced );
		$bottom_spaced = sanitize_text_field( $bottom_spaced );
		$transparent_border = sanitize_text_field( $transparent_border );
		$el_style = sanitize_text_field( $el_style );
		$el_class = sanitize_text_field( $el_class );
		
		$class = array( "btClear btSeparator" );
		
		if ( $top_spaced != 'not-spaced' && $top_spaced != '' ) {
			$class[] = $top_spaced;
		}

		if ( $bottom_spaced != 'not-spaced' && $bottom_spaced != '' ) {
			$class[] = $bottom_spaced;
		}

		if ( $transparent_border != '') {
			$class[] = $transparent_border;
		}
		
		if ( $el_class != '') {
			$class[] = $el_class;
		}
		
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = ' ' . 'style="' . $el_style . '"';
		}
		

		$output = '<div class="' . implode( ' ', $class ) . '" '. $style_attr . '><hr></div>';
		
		return $output;
	}
}

// [bt_icon]
class bt_icon {
	static function init() {
		add_shortcode( 'bt_icon', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'icon'				=> '',
			'icon_type'			=> '',
			'icon_color'		=> '',
			'icon_size'			=> '',
			'icon_animation'	=> '',
			'icon_outline'		=> '',
			'icon_title'		=> '',
			'url'				=> '',
			'target'			=> '',
			'el_style'			=> '',
			'el_class'			=> ''
		), $atts, 'bt_icon' ) );
		
		$icon = sanitize_text_field( $icon );
		$icon_type = sanitize_text_field( $icon_type );
		$icon_size = sanitize_text_field( $icon_size );
		$icon_animation = sanitize_text_field( $icon_animation );
		$icon_outline = sanitize_text_field( $icon_outline );
		$icon_title = sanitize_text_field( $icon_title );
		$url = sanitize_text_field( $url );
		$target = sanitize_text_field( $target );
		
		$el_style = sanitize_text_field( $el_style );
		$el_class = sanitize_text_field( $el_class );	
		
		$output = boldthemes_get_icon_html( $icon, $url, $icon_title, $icon_type . ' ' . $icon_size . ' ' . $icon_color . ' ' . $icon_animation . ' ' . $icon_outline . ' ' . $el_class, $target, $el_style );

		return $output;
	}
}

// [bt_icons]
class bt_icons {
	static function init() {
		add_shortcode( 'bt_icons', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'position'		=> '',	
			'el_style'		=> '',
			'el_class'		=> ''
		), $atts, 'bt_icons' ) );
		
		$el_style = sanitize_text_field( $el_style );
		$el_class = sanitize_text_field( $el_class );		
		
		$class = array( 'btIconImageRow' );
		
		if ( $el_class != '' ) {
			$class[] = $el_class;
		}

		if ( $position != '' ) {
			$class[] = $position;
		}
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}

		$output = '<div class="' . implode( ' ', $class ) . '" ' . $style_attr . '>';
			$output .= wptexturize( do_shortcode( $content ) );
		$output .= '</div>';
		
		return $output;
	}
}

// [bt_grid]
class bt_grid {
	static function init() {
		add_shortcode( 'bt_grid', array( __CLASS__, 'handle_shortcode' ) );
		add_action( 'wp_ajax_bt_get_grid', array( __CLASS__, 'bt_get_grid_callback' ) );
		add_action( 'wp_ajax_nopriv_bt_get_grid', array( __CLASS__, 'bt_get_grid_callback' ) );
	}
	
	static function bt_get_grid_callback() {
		$data = boldthemes_get_posts_data( intval( $_POST['number'] ), intval( $_POST['offset'] ), $_POST['cat_slug'], $_POST['post_type'] );
		bt_grid::bt_dump_grid( $data, $_POST['grid_type'], $_POST['post_type'], $_POST['format'], $_POST['tiles_title'] );
		die();
	}
	
	static function bt_dump_grid( $data, $grid_type, $post_type, $format, $tiles_title ) {
		if ( count( $data ) == 0 ) {
			echo 'no_posts';
			die();
		}
		
		$new_arr = array();
		
		$format_arr = explode( ',', $format );
		
		$i = 0;
		foreach( $data as $post ) {
		
			$item = '';
			
			if ( isset( $format_arr[ $i ] ) ) {
				if ( $format_arr[ $i ] == '21' ) {
					$tile_format = '21';
				} else if (  $format_arr[ $i ] == '12' ) {
					$tile_format = '12';
				} else if (  $format_arr[ $i ] == '22' ) {
					$tile_format = '22';
				} else {
					$tile_format = '11';
				}
			} else {
				if ( $post['tile_format'] != '' ) {
					$tile_format = $post['tile_format'];
					if ( $tile_format != '11' || $tile_format != '12' || $tile_format != '21' || $tile_format != '22' ) $tile_format = '11';
				} else {
					$tile_format = '11';
				}
			}
			
			$img_size = 'boldthemes_grid_' . $tile_format;
			
			if ( $grid_type  == 'classic' ) {
				$img_size = 'boldthemes_grid';
			}
			
			// post formats
			
			$media_html = '';
			
			$img_src = '';
			$post_thumbnail_id = get_post_thumbnail_id( $post['ID'] );
			
			$hw = '';
			
			if ( $post_thumbnail_id != '' ) {
				$img = wp_get_attachment_image_src( $post_thumbnail_id, $img_size );
				$img_src = $img[0];
				if ( $grid_type == 'classic' && $img[1] != '' ) $hw = $img[2] / $img[1];
				
			} else if ( ( $post['format'] == 'image' && count( $post['images'] ) > 0 ) || ( $post_type == 'portfolio' && count( $post['images'] ) == 1 ) ) {
				foreach ( $post['images'] as $img ) {
					$img = wp_get_attachment_image_src( $img['ID'], $img_size );
					$img_src = $img[0];
					if ( $grid_type == 'classic' && $img[1] != '' ) $hw = $img[2] / $img[1];
					break;
				}
			}
			
			if ( $grid_type == 'classic' ) {
			
				require_once( get_template_directory() . '/php/boldthemes_functions.php' );
			
				if ( $post['format'] == 'gallery' || ( $post_type == 'portfolio' && count( $post['images'] ) > 1 ) ) {
						
					if ( count( $post['images'] ) > 0 ) {
						$images_ids = array();
						foreach ( $post['images'] as $img ) {
							$images_ids[] = $img['ID'];
						}
						$img = wp_get_attachment_image_src( $images_ids[0], 'boldthemes_grid_gallery' );
						$src = $img[0];
						if ( $img[1] == 0 || $img[1] == '' ) {
							$media_html = '';
						} else {
							$hw = $img[2] / $img[1];
							$media_html = boldthemes_get_media_html( 'gallery', array( $images_ids, $hw, 'boldthemes_grid_gallery' ) );
						}
					}
					
				} else if ( $post['format'] == 'video' || ( $post_type == 'portfolio' && $post['video'] != '' ) ) {
					
					$media_html = boldthemes_get_media_html( 'video', array( $post['video'] ) );
					
				} else if ( $post['format'] == 'audio' || ( $post_type == 'portfolio' && $post['audio'] != '' ) ) {
					
					$media_html = boldthemes_get_media_html( 'audio', array( $post['audio'] ) );
					
				} else if ( $post['format'] == 'link' || ( $post_type == 'portfolio' && $post['link_url'] != '' ) ) {
					
					$media_html = boldthemes_get_media_html( 'link', array( $post['link_url'], $post['link_title'] ) );
					
				} else if ( $post['format'] == 'quote' || ( $post_type == 'portfolio' && $post['quote'] != '' ) ) {
					
					$media_html = boldthemes_get_media_html( 'quote', array( $post['quote'], $post['quote_author'], $post['permalink'] ) );
				}
			}
			
			if ( $media_html == '' ) {
				$extra_class = ' ' . 'noPhoto';
				if ( $img_src != '' ) {
					if ( $grid_type == 'classic' ) {
						$media_html = boldthemes_get_media_html( 'image', array( $post['permalink'], $img_src, $hw ) );
					}
					$extra_class = '';
				} else if ( $grid_type != 'classic' ) {
					$img_src = get_template_directory_uri() . '/gfx/ph_tiles.png';
				}
			}

			$comments = '';
			if ( $post['comments'] !== false ) {
				$comments = ' ' . '<a class="btArticleComments" href="' . esc_url( $post['permalink'] ) . '#comments">' . $post['comments'] . '</a>';
			}

			$use_dash = '';
			$author = '';
			if ( $post_type == 'portfolio' ) {
				$author = '';
				$bold_article_meta = '';
				$use_dash = boldthemes_get_option( 'pf_use_dash' );
			} else {
				if ( boldthemes_get_option( 'blog_author' ) ) {
					$author = ' ' . esc_html( get_the_author() );
					$author_url = get_author_posts_url( get_the_author_meta( 'ID' ) );
					$author = '<a href="' . esc_url_raw( $author_url ) . '" class="btArticleAuthor">' . __( 'by', 'bt_theme' ) . ' ' . esc_html( get_the_author() ) . '</a>';		
				}
				$bold_article_meta = "<span class='btArticleDate'>" . $post['date'] . "</span>" . $author . $comments ;
				$use_dash = boldthemes_get_option( 'blog_use_dash' );
			}

			$dash = $use_dash ? "top" : "";
			
			if ( $grid_type == 'classic' ) {
				
				if ( $post_type == 'portfolio' ) {
					$share_html = boldthemes_get_share_html( $post['permalink'], 'pf', 'btIcoExtraSmallSize', 'btIcoDefaultColor btIcoDefaultType' );
				} else {
					$share_html = boldthemes_get_share_html( $post['permalink'], 'blog', 'btIcoExtraSmallSize', 'btIcoDefaultColor btIcoDefaultType' );	
				}
			
				$new_arr[ $i ]['container_class'] = 'gridItem';
				$catgs = str_replace( ', ', '', $post['category'] );
				if ( $post_type == 'portfolio' ) $catgs = $post['category'];
				$item .= '<div class="btGridOuterContent">' .$media_html . '<div class="btGridContent">' . boldthemes_get_heading_html( '<span class="btArticleCategories">' . $catgs . '</span>', '<a href="' . esc_url_raw( $post['permalink'] ) . '">' . $post['title'] . '</a>', $bold_article_meta, 'small', $dash, 'btAlternateDash', '' ) . '<p>' . $post['excerpt'] . '</p><div class="btGridShare">' . $share_html . '</div></div></div>';
			} else {
				if ( $post_type == 'post' ) {
					$subtitle =  $bold_article_meta;
				} else {
					$subtitle =  '<span class="btArticleCategories">' . $post['category'] . '</span>';
				}
				$new_arr[ $i ]['container_class'] = 'gridItem bt' . $tile_format . $extra_class;			
				$item = '<div class="btTileBox" data-hw="' . $hw . '">' . boldthemes_get_image_html( esc_url( $img_src ), $post['title'], $subtitle, 'large', 'square', esc_url_raw( $post['permalink'] ), '_self', true, 'btAlternateDash', '' ) . '</div>'; 
			}
			
			$new_arr[ $i ]['html'] = $item;
			$new_arr[ $i ]['hw'] = $hw;
			$i++;			
			
		}

		echo json_encode( $new_arr );
	}
	
	static function handle_shortcode( $atts, $content ) {
	
		extract( shortcode_atts( array(
			'number'          => '',
			'columns'         => '',
			'category'        => '',
			'category_filter' => '',
			'related'         => '',
			'grid_type'       => '',
			'grid_gap'        => '',
			'format'          => '',
			'tiles_title'     => '',
			'post_type'       => '',
			'scroll_loading'  => '',
			'sticky_in_grid'  => '',
			'el_class'        => '',
			'el_style'        => ''
		), $atts, 'bt_grid' ) );
		
		$number = sanitize_text_field( $number );
		$columns = sanitize_text_field( $columns );	
		$category = sanitize_text_field( $category );
		$category_filter = sanitize_text_field( $category_filter );
		$related = sanitize_text_field( $related );
		$grid_type = sanitize_text_field( $grid_type );
		$grid_gap = sanitize_text_field( $grid_gap );
		$format = sanitize_text_field( $format );
		$tiles_title = sanitize_text_field( $tiles_title );
		$post_type = sanitize_text_field( $post_type );
		$scroll_loading = sanitize_text_field( $scroll_loading );
		$sticky_in_grid = sanitize_text_field( $sticky_in_grid );
		$el_class = sanitize_text_field( $el_class );
		$el_style = sanitize_text_field( $el_style );

		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}
		
		if ( $number == '' || $number <= 0 ) $number = 12;
		
		$col = 4;
		if ( $columns != '' ) $col = $columns;
		
		if ( $grid_type != 'classic' ) $grid_type = 'tiled';

		if ( $grid_gap != '' ) $el_class .= 'btGridGap-' . $grid_gap;

		$tiles_title_class = '';

		if ( $tiles_title == 'yes' ) $tiles_title_class = 'btHasTitles';
		
		if ( $post_type != 'portfolio' ) $post_type = 'post';
		
		if ( $scroll_loading != 'yes' ) {
			$scroll_loading = 'no';
		}
		
		wp_enqueue_script( 
			'bt_imagesloaded',
			plugin_dir_url( __FILE__ ) . 'imagesloaded.pkgd.min.js',
			array( 'jquery' ),
			'',
			true
		);
		
		wp_enqueue_script( 
			'bt_packery',
			plugin_dir_url( __FILE__ ) . 'packery.pkgd.min.js',
			array( 'jquery' ),
			'',
			true
		);
		
		wp_enqueue_script( 
			'bt_grid_tweak',
			plugin_dir_url( __FILE__ ) . 'bt_grid_tweak.js',
			array( 'jquery' ),
			'',
			true
		);		
		
		wp_enqueue_script( 
			'bt_grid',
			plugin_dir_url( __FILE__ ) . 'bt_grid.js',
			array( 'jquery' ),
			'',
			true
		);
		
		$output = '<div class="btGridContainer ' . $grid_type . ' ' . $el_class . ' ' . $tiles_title_class . '" ' . $style_attr . '>';
		if ( $category_filter == 'yes' ) {
			if ( $post_type == 'post' ) {
				$cats = get_categories();
			} else {
				$cats = get_categories( array( 'type' => 'portfolio', 'taxonomy' => 'portfolio_category' ) );
			}
			$output .= '<div class="btCatFilter">';
			$output .= '<span class="btCatFilterTitle">' . __( 'Category filter:', 'bt_plugin' ) . '</span>';
			$output .= '<span class="btCatFilterItem all" data-slug="">' . __( 'All', 'bt_plugin' ) . '</span>';
			foreach ( $cats as $cat ) {
				$output .= '<span class="btCatFilterItem" data-slug="' . $cat->slug . '">' . $cat->name . '</span>';
			}
			$output .= '</div>';
		}
		$output .= '<div class="tilesWall btAjaxGrid ' . $grid_type . '" data-num="' . $number . '" data-tiles-title="' . $tiles_title . '" data-grid-type="' . $grid_type . '" data-post-type="' . $post_type . '" data-col="' . $col . '" data-cat-slug="' . $category . '" data-scroll-loading="' . $scroll_loading . '" data-format="' . $format . '" data-related="' . $related . '" data-sticky="' . $sticky_in_grid . '">';
		$output .= '<div class="gridSizer"></div>';
		$output .= '</div>';
		$output .= '<div class="btLoader btLoaderGrid"></div><div class="btNoMore btTextCenter topSmallSpaced bottomSmallSpaced">' . esc_html( __( 'No more posts', 'bt_plugin' ) ) . '</div>';
		$output .= '</div>';
		
		return $output;

	}
}

// [bt_latest_posts]
class bt_latest_posts {
	static function init() {
		add_shortcode( 'bt_latest_posts', array( __CLASS__, 'handle_shortcode' ) );
	}
	static function handle_shortcode( $atts, $content ) {
	
		extract( shortcode_atts( array(
			'number'          => '',
			'category'        => '',
			'format'          => '',
			'show_excerpt'    => '',
			'show_date'    => '',
			'show_author'    => '',
			'post_type'       => '',
			'el_class'        => '',
			'el_style'        => ''
		), $atts, 'bt_grid' ) );
		
		$number = sanitize_text_field( $number );
		$category = sanitize_text_field( $category );
		$format = sanitize_text_field( $format );
		$show_excerpt = sanitize_text_field( $show_excerpt );
		$show_date = sanitize_text_field( $show_date );
		$show_author = sanitize_text_field( $show_author );
		$post_type = sanitize_text_field( $post_type );
		$el_class = sanitize_text_field( $el_class );
		$el_style = sanitize_text_field( $el_style );
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}
		
		if ( $number == '' || $number <= 0 ) $number = 3;

		$column_width = 12;

		$img_size = 'boldthemes_latest_posts';
		$dash = 'bottom';
		$indent_class = '';

		if( $format == 'horizontal' ) {
			$column_width = intval(12/$number);
			//$img_size = 'boldthemes_grid_22';
			$dash = 'bottom';
			//$indent_class = 'btTextIndent';
		}

		$use_dash = '';
		/*if ( $post_type == 'portfolio' ) {
			$use_dash = boldthemes_get_option( 'pf_use_dash' );
		} else {
			$use_dash = boldthemes_get_option( 'blog_use_dash' );
		}*/

		$dash = $use_dash ? "top" : "";
		
		if ( $post_type != 'portfolio' ) $post_type = 'post';

		$data = boldthemes_get_posts_data( $number, 0, $category, $post_type );
		
		$output = '<div class="btLatestPostsContainer ' . $format . 'Posts ' . $el_class . '" ' . $style_attr . '>';
		
		$i = 0;
		foreach( $data as $post_item ) { 
			$i++;
			if ( $i > $number ) break;
			
			$img_src = '';
			$post_thumbnail_id = get_post_thumbnail_id( $post_item['ID'] );
			
			if ( $post_thumbnail_id != '' ) {
				$img = wp_get_attachment_image_src( $post_thumbnail_id, $img_size );
				$img_src = $img[0];			
			} else if ( ( $post_item['format'] == 'image' && count( $post_item['images'] ) > 0 ) || ( $post_type == 'portfolio' && count( $post_item['images'] ) == 1 ) ) {
				foreach ( $post_item['images'] as $img ) {
					$img = wp_get_attachment_image_src( $img['ID'], $img_size );
					$img_src = $img[0];
					break;
				}
			}
	
			$comments = '';
			if ( $post_item['comments'] !== false ) {
				$comments = ' ' . '<a class="btArticleComments" href="' . esc_url( $post_item['permalink'] ) . '#comments">' . $post_item['comments'] . '</a>';
			}
			
			$author = '';
			if ( $post_type == 'portfolio' ) {
				$author = '';
				$bold_article_subtitle = '<span class="btArticleCategories">' . $post_item['category'] . '</span>';
				$bold_article_supertitle = '';
			} else {
				if ( boldthemes_get_option( 'blog_author' ) ) { 
					$author = ' ' . esc_html( get_the_author() );
					$author_url = get_author_posts_url( get_the_author_meta( 'ID' ) );
					$author = '<a href="' . esc_url_raw( $author_url ) . '" class="btArticleAuthor">' . esc_html( get_the_author() ) . '</a>';
				}
				$bold_article_supertitle = '<span class="btArticleDate">' . $post_item['date'] . '</span>' . $author ;
				$bold_article_subtitle = $post_item['category'] . $comments ;
			}
			
			require_once( get_template_directory() . '/php/boldthemes_functions.php' );

			$image_html = '';

			if( $img_src != '' ) {

				$image_html .= '<div class="btSingleLatestPostImage btTextCenter">' . boldthemes_get_image_html( $img_src, '', '', '', '', $post_item['permalink'], '_self', '', $el_style, $el_class, "" ) . '</div>';
	
			}

			$output .= '
				<div class="btSingleLatestPost col-sm-' . $column_width . ' col-ms-12 ' . $indent_class . ' inherit"' . $el_style . '>'
					. $image_html ;
					// $output .= '<span class="btIco btIcoFilledType btIcoMediumSize btIcoAccentColor"><a href="#" target="no_target" data-ico-s7="&#xe623;" class="btIcoHolder"></a></span>';
					$output .= boldthemes_get_icon_html( 'cs_e9f9', $post_item['permalink'], '', 'btIcoMediumSize btIcoFilledType btIcoAccentColor', '' );
					$output .= '<div class = "btSingleLatestPostContent"><div class="btSLPCCwrap">
						
						' . boldthemes_get_heading_html( $bold_article_supertitle, '<a href="' . $post_item['permalink'] . '" target="_self">' . $post_item['title'] . '</a>', '', 'medium', $dash, 'btAlternateDash', '' );
			if ( $show_excerpt == "yes" ) $output .= '
				<p class="btLatestPostContent">' . $post_item['excerpt'] . '</p>';
			$output .= '<div class="btSingleLatestPostFooter">' . $bold_article_subtitle . '</div>';
			// $output .= boldthemes_get_heading_html( '', '', $bold_article_subtitle, 'medium', '', 'btLatestPostsContentFooter', '' ) . '
			$output .= '</div>';
			$output .= '</div></div>';
		}

		$output .= '</div>';
		
		return $output;

	}
}

// [bt_price_list]
class bt_price_list {

	static function init() {
		add_shortcode( 'bt_price_list', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'title'       => '',
			'subtitle'    => '',
			'sticker'     => '',
			'currency'    => '',
			'price'       => '',
			'items'       => '',
			'el_class'    => '',
			'el_style'    => ''
		), $atts, 'bt_price_list' ) );
		
		$title = sanitize_text_field( $title );
		$subtitle = sanitize_text_field( $subtitle );
		$sticker = sanitize_text_field( $sticker );
		$currency = sanitize_text_field( $currency );
		$price = sanitize_text_field( $price );
		$el_class = sanitize_text_field( $el_class );
		$el_style = sanitize_text_field( $el_style );
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}

		$output = '<div class="btPriceTable ' . $el_class . '" ' . $style_attr . '>';
		
		if ( $sticker != '' ) $sticker = '<div class="btPriceTableSticker"><div><div>' . $sticker . '</div></div></div>';

		$items_arr = preg_split( '/$\R?^/m', $items );
		
		$output .= 
			'<div class="btPriceTableHeader btDarkSkin">' . $sticker .
				boldthemes_get_heading_html( $title, '<span class="btPriceTableCurrency">' . $currency . '</span>'	. $price, $subtitle, 'large', 'top', '', '' ) .
			'</div><!-- /ptHeader -->
			<ul>';
				foreach ( $items_arr as $item ) {
					$arr = explode( '::', $item );
					if ( isset( $arr[1] ) ) {
						$output .= '<li>' . $arr[0] . '<span>' . $arr[1] . '</span>' . '</li>';
					} else {
						$output .= '<li>' . $item . '</li>';
					}
					
				}
			$output .= '</ul>
		';
		$output .= '</div>';
		
		return $output;
	}
}

// [bt_dropdown]
class bt_dropdown {

	static function init() {
		add_shortcode( 'bt_dropdown', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'title'       => '',
			'dd_content'  => '',
			'el_class'    => '',
			'el_style'    => ''
		), $atts, 'bt_dropdown' ) );
		
		$el_class = sanitize_text_field( $el_class );
		$el_style = sanitize_text_field( $el_style );
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}

		$output = '<div class="btDropdown ' . $el_class . '" ' . $style_attr . '><select class="btDropdownSelect">';

		$items_arr = preg_split( '/$\R?^/m', $dd_content );
		
		$output .= '<option value="">' . $title . '</option>';
		
		foreach ( $items_arr as $item ) {
			$item_arr = explode( ';', $item );
			$output .= '<option value="' . $item_arr[1] . '">' . $item_arr[0] . '</option>';
		}
		
		$output .= '</select></div>';
		
		return $output;
	}
}

// [bt_working_hours]
class bt_working_hours {

	static function init() {
		add_shortcode( 'bt_working_hours', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'wh_content'  => '',
			'el_class'    => '',
			'el_style'    => ''
		), $atts, 'bt_working_hours' ) );
		
		$el_class = sanitize_text_field( $el_class );
		$el_style = sanitize_text_field( $el_style );
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}

		$output_inner = '';
		$has_link = '';
		$items_arr = preg_split( '/$\R?^/m', $wh_content );
		
		foreach ( $items_arr as $item ) {
			$output_inner .= '<div class="btWorkingHoursInnerRow">';
			$item_arr = explode( ';', $item );
			$output_inner .= '<div class="btWorkingHoursInnerTitle">' . $item_arr[0] . '</div>';
			unset( $item_arr[0] );
			$link = array_pop($item_arr);
		
			foreach ( $item_arr as $inner_item ) {
				$output_inner .= '<div class="btWorkingHoursInnerContent">' . $inner_item . '</div>';
			}

			if( $link != '' && !ctype_space($link) ) {
				$link_arr = explode( ',', $link );
				$output_inner .= '<div class="btWorkingHoursInnerLink">';
				//$output_inner .=  boldthemes_get_button_html( '', $link_arr[1], $link_arr[0], "", "", "" );
				$output_inner .=  '<a href="' . $link_arr[1] . '" title="' . $link_arr[0] . '">' . $link_arr[0] . '</a>';
				$output_inner .= '</div>';
				$has_link = ' btWorkingHoursHasLink';
			}
			$output_inner .= '</div>';
		}

		$output = '<div class="btWorkingHours ' . $el_class . $has_link . '" ' . $style_attr . '>';
			$output .= '<div class="btWorkingHoursInner">';
				$output .= $output_inner;
			$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}
}

bt_image::init();
gallery::init();
image::init();

bt_grid_gallery::init();

bt_section::init();
bt_row::init();
bt_row_inner::init();
bt_custom_menu::init();
bt_column::init();
bt_column_inner::init();
bt_text::init();
bt_header::init();
bt_tabs::init();
bt_tabs_items::init();
bt_accordion::init();
bt_accordion_items::init();
bt_service::init();
bt_gmaps::init();
bt_clients::init();
bt_client::init();
bt_button::init();
bt_counter::init();
bt_percentage_bar::init();
bt_slider::init();
bt_slider_item::init();
bt_hr::init();
bt_icon::init();
bt_icons::init();
bt_grid::init();
bt_latest_posts::init();
bt_price_list::init();

bt_dropdown::init();
bt_working_hours::init();

function bt_map_sc() {
	if ( function_exists( 'bt_rc_map' ) ) {
	
		if ( ! function_exists( 'bt_fa_icons' ) ) {
			require_once( 'bt_fa_icons.php' );
		}
		if ( ! function_exists( 'bt_s7_icons' ) ) {
			require_once( 'bt_s7_icons.php' );
		}
		if ( ! function_exists( 'bt_custom_icons' ) ) {
			require_once( 'bt_custom_icons.php' );
		}
		$icon_arr = array( 'Font Awesome' => bt_fa_icons(), 'S7' => bt_s7_icons(), 'Custom' => bt_custom_icons() );
		
		require_once( 'section_anims.php' );
		$section_anims = bt_get_section_anims();		
	
		bt_rc_map( 'bt_image', array( 'name' => __( 'Image', 'bt_plugin' ), 'description' => __( 'Single image', 'bt_plugin' ),
			'params' => array(
				array( 'param_name' => 'image', 'type' => 'attach_image', 'heading' => __( 'Image', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'caption_text', 'type' => 'textarea', 'heading' => __( 'Caption Text', 'bt_plugin' ) ),
				array( 'param_name' => 'size', 'type' => 'textfield', 'heading' => __( 'Size (e.g. thumbnail, medium, large, full)', 'bt_plugin' ) ),
				array( 'param_name' => 'shape', 'type' => 'dropdown', 'heading' => __( 'Shape', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Square', 'bt_plugin' ) => 'square',
						__( 'Circle', 'bt_plugin' ) => 'circle'
				) ),
				array( 'param_name' => 'url', 'type' => 'textfield', 'heading' => __( 'URL', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'target', 'type' => 'dropdown', 'heading' => __( 'Target', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Self', 'bt_plugin' ) => '_self',
						__( 'Blank', 'bt_plugin' ) => '_blank'
				) ),
				array( 'param_name' => 'hover_type', 'type' => 'dropdown', 'heading' => __( 'Hover type', 'bt_plugin' ),
					'value' => array(
						__( 'Default', 'bt_plugin' ) => '',
						__( 'Simple', 'bt_plugin' ) => 'btSimpleHoverType'
				) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ) )
			) )
		);

		bt_rc_map( 'bt_section', array( 'name' => __( 'Section', 'bt_plugin' ), 'description' => __( 'Basic root element', 'bt_plugin' ), 'root' => true, 'container' => 'vertical', 'accept' => array( 'bt_row' => true ), 'toggle' => true, 'show_settings_on_create' => false,
			'params' => array( 
				array( 'param_name' => 'layout', 'type' => 'dropdown', 'heading' => __( 'Layout', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Boxed', 'bt_plugin' ) => 'boxed',
						__( 'Wide', 'bt_plugin' ) => 'wide'
				) ),		
				array( 'param_name' => 'top_spaced', 'type' => 'dropdown', 'heading' => __( 'Top spaced', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'not-spaced',
						__( 'Extra-Small-Spaced', 'bt_plugin' ) => 'topExtraSmallSpaced',
						__( 'Small-Spaced', 'bt_plugin' ) => 'topSmallSpaced',		
						__( 'Semi-Spaced', 'bt_plugin' ) => 'topSemiSpaced',
						__( 'Spaced', 'bt_plugin' ) => 'topSpaced',
						__( 'Extra-Spaced', 'bt_plugin' ) => 'topExtraSpaced'
				) ),
				array( 'param_name' => 'bottom_spaced', 'type' => 'dropdown', 'heading' => __( 'Bottom spaced', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'not-spaced',
						__( 'Extra-Small-Spaced', 'bt_plugin' ) => 'bottomExtraSmallSpaced',		
						__( 'Small-Spaced', 'bt_plugin' ) => 'bottomSmallSpaced',
						__( 'Semi-Spaced', 'bt_plugin' ) => 'bottomSemiSpaced',
						__( 'Spaced', 'bt_plugin' ) => 'bottomSpaced',
						__( 'Extra-Spaced', 'bt_plugin' ) => 'bottomExtraSpaced'
				) ),
				array( 'param_name' => 'skin', 'type' => 'dropdown', 'heading' => __( 'Skin', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Inherit', 'bt_plugin' ) => 'inherit',			
						__( 'Dark', 'bt_plugin' ) => 'dark',
						__( 'Light', 'bt_plugin' ) => 'light'
				) ),
				array( 'param_name' => 'full_screen', 'type' => 'dropdown', 'heading' => __( 'Full Screen', 'bt_plugin' ), 
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no',
						__( 'Yes', 'bt_plugin' ) => 'yes'
				) ),
				array( 'param_name' => 'vertical_align', 'type' => 'dropdown', 'heading' => __( 'Vertical Align', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Inherit', 'bt_plugin' ) => 'inherit',
						__( 'Top', 'bt_plugin' )     => 'btTopVertical',
						__( 'Middle', 'bt_plugin' )  => 'btMiddleVertical',
						__( 'Bottom', 'bt_plugin' )  => 'btBottomVertical'					
				) ),
				array( 'param_name' => 'divider', 'type' => 'dropdown', 'heading' => __( 'Divider', 'bt_plugin' ), 
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no',
						__( 'Yes', 'bt_plugin' ) => 'yes'
				) ),
				array( 'param_name' => 'back_image', 'type' => 'attach_image', 'heading' => __( 'Background Image', 'bt_plugin' ) ),
				array( 'param_name' => 'back_color', 'type' => 'colorpicker', 'heading' => __( 'Background color', 'bt_plugin' ) ),
				array( 'param_name' => 'back_video', 'type' => 'textfield', 'heading' => __( 'YouTube Background Video', 'bt_plugin' ) ),
				array( 'param_name' => 'video_settings', 'type' => 'textfield', 'heading' => __( 'Video Settings (e.g. startAt:20, mute:true, stopMovieOnBlur:false)', 'bt_plugin' ) ),
				array( 'param_name' => 'parallax', 'type' => 'textfield', 'heading' => __( 'Parallax (e.g. -.7)', 'bt_plugin' ) ),
				array( 'param_name' => 'parallax_offset', 'type' => 'textfield', 'heading' => __( 'Parallax Offset in px (e.g. -100)', 'bt_plugin' ) ),
				array( 'param_name' => 'animation', 'type' => 'dropdown', 'heading' => __( 'Animation (forward)', 'bt_plugin' ), 'value' => $section_anims ),
				array( 'param_name' => 'animation_back', 'type' => 'dropdown', 'heading' => __( 'Animation (backward)', 'bt_plugin' ), 'value' => $section_anims ),
				array( 'param_name' => 'animation_impress', 'type' => 'textfield', 'heading' => __( 'Impress Animation Settings', 'bt_plugin' ), 'description' => 'x,y,z;rotate,rotate-x,rotate-y;scale' ),
				array( 'param_name' => 'el_id', 'type' => 'textfield', 'heading' => __( 'Custom Id Attribute', 'bt_plugin' ) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ) )
			) )
		);
		
		bt_rc_map( 'bt_row', array( 'name' => __( 'Row', 'bt_plugin' ), 'description' => __( 'Row element', 'bt_plugin' ), 'container' => 'horizontal', 'accept' => array( 'bt_column' => true ), 'toggle' => true, 'show_settings_on_create' => false,
			'params' => array( 
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ) )
			) )
		);

		bt_rc_map( 'bt_row_inner', array( 'name' => __( 'Inner Row', 'bt_plugin' ), 'description' => __( 'Inner Row element', 'bt_plugin' ), 'container' => 'horizontal', 'accept' => array( 'bt_column_inner' => true ), 'toggle' => true, 'show_settings_on_create' => false,
			'params' => array( 
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ) )
			) )
		);
	
		bt_rc_map( 'bt_column', array( 'name' => __( 'Column', 'bt_plugin' ), 'description' => __( 'Column element', 'bt_plugin' ), 'width_param' => 'width', 'container' => 'vertical', 'accept' => array( 'bt_section' => false, 'bt_row' => false, 'bt_column' => false, 'bt_column_inner' => false, '_content' => false, 'bt_client' => false, 'bt_icon' => false, 'bt_testimonials_items' => false, 'bt_dropdown' => true, 'bt_tabs_items' => false, 'bt_accordion_items' => false, 'bt_slider_item' => false ), 'accept_all' => true, 'toggle' => true,
			'params' => array(
				array( 'param_name' => 'align', 'type' => 'dropdown', 'heading' => __( 'Align', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Left', 'bt_plugin' ) => 'left',
						__( 'Right', 'bt_plugin' ) => 'right',
						__( 'Center', 'bt_plugin' ) => 'center'					
				) ),
				array( 'param_name' => 'vertical_align', 'type' => 'dropdown', 'heading' => __( 'Vertical Align', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Inherit', 'bt_plugin' ) => 'inherit',
						__( 'Top', 'bt_plugin' )     => 'btTopVertical',
						__( 'Middle', 'bt_plugin' )  => 'btMiddleVertical',
						__( 'Bottom', 'bt_plugin' )  => 'btBottomVertical'					
				) ),
				array( 'param_name' => 'border', 'type' => 'dropdown', 'heading' => __( 'Border', 'bt_plugin' ),
					'value' => array(
						__( 'No Border', 'bt_plugin' ) => 'no_border',
						__( 'Left', 'bt_plugin' )      => 'btLeftBorder',
						__( 'Right', 'bt_plugin' )     => 'btRightBorder'					
				) ),				
				array( 'param_name' => 'cell_padding', 'type' => 'dropdown', 'heading' => __( 'Padding', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Default', 'bt_plugin' ) => 'default',
						__( 'No padding', 'bt_plugin' ) => 'btNoPadding',
						__( 'Double padding', 'bt_plugin' ) => 'btDoublePadding'				
				) ),
				array( 'param_name' => 'animation', 'type' => 'dropdown', 'heading' => __( 'Animation', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'No Animation', 'bt_plugin' ) => 'no_animation',
						__( 'Fade In', 'bt_plugin' ) => 'animate animate-fadein',
						__( 'Move Up', 'bt_plugin' ) => 'animate animate-moveup',
						__( 'Move Left', 'bt_plugin' ) => 'animate animate-moveleft',
						__( 'Move Right', 'bt_plugin' ) => 'animate animate-moveright',
						__( 'Move Down', 'bt_plugin' ) => 'animate animate-movedown',
						__( 'Fade In / Move Up', 'bt_plugin' ) => 'animate animate-fadein animate-moveup',
						__( 'Fade In / Move Left', 'bt_plugin' ) => 'animate animate-fadein animate-moveleft',
						__( 'Fade In / Move Right', 'bt_plugin' ) => 'animate animate-fadein animate-moveright',
						__( 'Fade In / Move Down', 'bt_plugin' ) => 'animate animate-fadein animate-movedown'				
				) ),
				array( 'param_name' => 'text_indent', 'type' => 'dropdown', 'heading' => __( 'Text indent', 'bt_plugin' ),
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no_text_indent',
						__( 'Yes', 'bt_plugin' ) => 'btTextIndent'
				) ),
				array( 'param_name' => 'highlight', 'type' => 'dropdown', 'heading' => __( 'Highlight', 'bt_plugin' ),
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no_highlight',
						__( 'Yes', 'bt_plugin' ) => 'btHighlight'
				) ),
				array( 'param_name' => 'background_color', 'type' => 'colorpicker', 'heading' => __( 'Background color', 'bt_plugin' ) ),
				array( 'param_name' => 'opacity', 'type' => 'textfield', 'heading' => __( 'Opacity (0 - 1, e.g. 0.4)', 'bt_plugin' ) ),
				array( 'param_name' => 'inner_background_color', 'type' => 'colorpicker', 'heading' => __( 'Inner Background color', 'bt_plugin' ) ),
				array( 'param_name' => 'background_image', 'type' => 'attach_image', 'heading' => __( 'Background image', 'bt_plugin' ) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ) )
			) )
		);


		bt_rc_map( 'bt_column_inner', array( 'name' => __( 'Inner Column', 'bt_plugin' ), 'description' => __( 'Inner Column element', 'bt_plugin' ), 'width_param' => 'width', 'container' => 'vertical', 'accept' => array( 'bt_section' => false, 'bt_row' => false, 'bt_column' => false, '_content' => false, 'bt_client' => false, 'bt_icon' => false, 'bt_testimonials_items' => false, 'bt_tabs_items' => false, 'bt_accordion_items' => false, 'bt_slider_item' => false ), 'accept_all' => true, 'toggle' => true,
			'params' => array(
				array( 'param_name' => 'align', 'type' => 'dropdown', 'heading' => __( 'Align', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Left', 'bt_plugin' ) => 'left',
						__( 'Right', 'bt_plugin' ) => 'right',
						__( 'Center', 'bt_plugin' ) => 'center'					
				) ),
				array( 'param_name' => 'cell_padding', 'type' => 'dropdown', 'heading' => __( 'Padding', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Default', 'bt_plugin' ) => 'default',
						__( 'No padding', 'bt_plugin' ) => 'btNoPadding',
						__( 'Double padding', 'bt_plugin' ) => 'btDoublePadding'				
				) ),				
				array( 'param_name' => 'vertical_align', 'type' => 'dropdown', 'heading' => __( 'Vertical Align', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Inherit', 'bt_plugin' ) => 'inherit',
						__( 'Top', 'bt_plugin' )     => 'btTopVertical',
						__( 'Middle', 'bt_plugin' )  => 'btMiddleVertical',
						__( 'Bottom', 'bt_plugin' )  => 'btBottomVertical'					
				) ),
				array( 'param_name' => 'highlight', 'type' => 'dropdown', 'heading' => __( 'Highlight', 'bt_plugin' ),
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no_highlight',
						__( 'Yes', 'bt_plugin' ) => 'btHighlight'
				) ),
				array( 'param_name' => 'background_color', 'type' => 'colorpicker', 'heading' => __( 'Background color', 'bt_plugin' ) ),
				array( 'param_name' => 'opacity', 'type' => 'textfield', 'heading' => __( 'Opacity (0 - 1, e.g. 0.4)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ) )
			) )
		);

		bt_rc_map( 'bt_custom_menu', array( 'name' => __( 'Custom Menu', 'bt_plugin' ), 'description' => __( 'Custom Menu', 'bt_plugin' ),
			'params' => array( 
				array( 'param_name' => 'menu', 'type' => 'textfield', 'heading' => __( 'Menu Name', 'bt_plugin' ) ),		
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ) )
			) )
		);
		
		bt_rc_map( 'bt_text', array( 'name' => __( 'Text', 'bt_plugin' ), 'description' => __( 'Text element', 'bt_plugin' ), 'container' => 'vertical', 'accept' => array( '_content' => true ), 'toggle' => true, 'show_settings_on_create' => false ) );
		
		bt_rc_map( 'bt_header', array( 'name' => __( 'Header', 'bt_plugin' ), 'description' => __( 'Header element', 'bt_plugin' ),
			'params' => array( 
				array( 'param_name' => 'superheadline', 'type' => 'textfield', 'heading' => __( 'Superheadline', 'bt_plugin' ) ),
				array( 'param_name' => 'headline', 'type' => 'textarea', 'heading' => __( 'Headline', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'headline_size', 'type' => 'dropdown', 'heading' => __( 'Headline Size', 'bt_plugin' ), 'preview' => true, 
					'value' => array(
						__( 'Small', 'bt_plugin' ) => 'small',
						__( 'Medium', 'bt_plugin' ) => 'medium',
						__( 'Large', 'bt_plugin' ) => 'large',
						__( 'Extra large', 'bt_plugin' ) => 'extralarge',
						__( 'Huge', 'bt_plugin' ) => 'huge'
				) ),		
				array( 'param_name' => 'dash', 'type' => 'dropdown', 'heading' => __( 'Dash', 'bt_plugin' ), 'preview' => true, 
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no',
						__( 'Top', 'bt_plugin' ) => 'top',
						__( 'Bottom', 'bt_plugin' ) => 'bottom'
		 		) ),
				array( 'param_name' => 'dash_style', 'type' => 'dropdown', 'heading' => __( 'Dash Style', 'bt_plugin' ), 'preview' => true, 
					'value' => array(
						__( 'Normal color', 'bt_plugin' ) => 'btNormalDash',		
						__( 'Accent color', 'bt_plugin' ) => 'btAccentDash',
						__( 'Alternate color', 'bt_plugin' ) => 'btAlternateDash',
		 		) ),				
				array( 'param_name' => 'subheadline', 'type' => 'textarea', 'heading' => __( 'Subheadline', 'bt_plugin' ) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ) )
			) )
		);

		bt_rc_map( 'bt_testimonials', array( 'name' => __( 'Testimonials', 'bt_plugin' ), 'description' => __( 'Testimonials container', 'bt_plugin' ), 'container' => 'vertical', 'accept' => array( 'bt_testimonials_items' => true ), 'show_settings_on_create' => false )
		);
		
		bt_rc_map( 'bt_testimonials_items', array( 'name' => __( 'Testimonial Item', 'bt_plugin' ), 'description' => __( 'Single testimonial item', 'bt_plugin' ),
			'params' => array( 
				array( 'param_name' => 'headline', 'type' => 'textfield', 'heading' => __( 'Headline', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'image', 'type' => 'attach_image', 'heading' => __( 'Image', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'text', 'type' => 'textfield', 'heading' => __( 'Text', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'name', 'type' => 'textfield', 'heading' => __( 'Name', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'job', 'type' => 'textfield', 'heading' => __( 'Job', 'bt_plugin' ), 'preview' => true )
			) )
		);
		
		
		bt_rc_map( 'bt_tabs', array( 'name' => __( 'Tabs', 'bt_plugin' ), 'description' => __( 'Tabs container', 'bt_plugin' ), 'container' => 'vertical', 'accept' => array( 'bt_tabs_items' => true ), 'show_settings_on_create' => false ));
		
		bt_rc_map( 'bt_tabs_items', array( 'name' => __( 'Tab Item', 'bt_plugin' ), 'description' => __( 'Tabs items', 'bt_plugin' ), 'container' => 'vertical', 'accept' => array( '_content' => true, 'bt_header' => true, 'bt_image' => true, 'bt_icons' => true, 'bt_service' => true, 'bt_row_inner' => true ), 'params' => array(
				array( 'param_name' => 'headline', 'type' => 'textfield', 'heading' => __( 'Headline', 'bt_plugin' ), 'preview' => true )
			) )
		);
		
		bt_rc_map( 'bt_accordion', array( 'name' => __( 'Accordion', 'bt_plugin' ), 'description' => __( 'Accordion container', 'bt_plugin' ), 'container' => 'vertical', 'accept' => array( 'bt_accordion_items' => true ), 'show_settings_on_create' => false, 'params' => array(
				array( 'param_name' => 'open_first', 'type' => 'dropdown', 'heading' => __( 'Open first item initially', 'bt_plugin' ),
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no',
						__( 'Yes', 'bt_plugin' ) => 'yes'
				) )
			) )
		);
		
		bt_rc_map( 'bt_accordion_items', array( 'name' => __( 'Accordion Item', 'bt_plugin' ), 'description' => __( 'Single accordion element', 'bt_plugin' ), 'accept' => array( '_content' => true, 'bt_header' => true, 'bt_image' => true, 'bt_icons' => true ), 'container' => 'vertical', 'params' => array(
				array( 'param_name' => 'headline', 'type' => 'textfield', 'heading' => __( 'Headline', 'bt_plugin' ), 'preview' => true )
			) )
		);
		
		bt_rc_map( 'bt_service', array( 'name' => __( 'Service', 'bt_plugin' ), 'description' => __( 'Service element', 'bt_plugin' ),
			'params' => array(
				array( 'param_name' => 'icon', 'type' => 'iconpicker', 'preview' => true, 'heading' => __( 'Icon', 'bt_plugin' ), 'value' => $icon_arr ),	
				array( 'param_name' => 'icon_type', 'type' => 'dropdown', 'heading' => __( 'Icon Type', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Default', 'bt_plugin' ) 	=> 'btIcoDefaultType',
						__( 'Filled', 'bt_plugin' )	 	=> 'btIcoFilledType',
						__( 'Outline', 'bt_plugin' )	=> 'btIcoOutlineType'
					) ),
				array( 'param_name' => 'icon_color', 'type' => 'dropdown', 'heading' => __( 'Icon Color', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Default', 'bt_plugin' ) 	=> 'btIcoDefaultColor',
						__( 'Accent', 'bt_plugin' )	 	=> 'btIcoAccentColor',
						__( 'Alter', 'bt_plugin' )	 	=> 'btIcoAlterColor',
					) ),
				array( 'param_name' => 'icon_size', 'type' => 'dropdown', 'heading' => __( 'Icon Size', 'bt_plugin' ), 'preview' => true,
					'value' => array(
							__( 'Small', 'bt_plugin' ) 			=> 'btIcoSmallSize',		
							__( 'Extra Small', 'bt_plugin' )	=> 'btIcoExtraSmallSize',
							__( 'Medium', 'bt_plugin' )	 		=> 'btIcoMediumSize',
							__( 'Large', 'bt_plugin' )			=> 'btIcoLargeSize'
					) ),
				array( 'param_name' => 'url', 'type' => 'textfield', 'heading' => __( 'URL', 'bt_plugin' ) ),
				array( 'param_name' => 'headline', 'type' => 'textfield', 'heading' => __( 'Headline', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'dash', 'type' => 'dropdown', 'heading' => __( 'Dash', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'No', 'bt_plugin' ) 	=> '',
						__( 'Bottom', 'bt_plugin' )	 	=> 'bottom',
					) ),
				array( 'param_name' => 'text', 'type' => 'textarea', 'heading' => __( 'Text', 'bt_plugin' ) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ) )
			) )
		);
		
		bt_rc_map( 'bt_gmaps', array( 'name' => __( 'Google Maps', 'bt_plugin' ), 'description' => __( 'Google Maps with marker on specified coordinates', 'bt_plugin' ), 'container' => 'vertical', 'accept' => array( 'bt_header' => true, 'bt_button' => true, 'bt_counter' => true, 'bt_icons' => true, 'bt_image' => true, 'bt_text' => true, 'bt_hr' => true, 'bt_dropdown' => true, 'bt_service' => true ),
			'params' => array(
				array( 'param_name' => 'api_key', 'type' => 'textfield', 'heading' => __( 'API key', 'bt_plugin' ) ),
				array( 'param_name' => 'latitude', 'type' => 'textfield', 'heading' => __( 'Latitude', 'bt_plugin' ) ),
				array( 'param_name' => 'longitude', 'type' => 'textfield', 'heading' => __( 'Longitude', 'bt_plugin' ) ),
				array( 'param_name' => 'zoom', 'type' => 'textfield', 'heading' => __( 'Zoom (e.g. 14)', 'bt_plugin' ) ),
				array( 'param_name' => 'icon', 'type' => 'attach_image', 'heading' => __( 'Icon', 'bt_plugin' ) ),
				array( 'param_name' => 'height', 'type' => 'textfield', 'heading' => __( 'Height (e.g. 250px)', 'bt_plugin' ) ),
				array( 'param_name' => 'primary_color', 'type' => 'colorpicker', 'heading' => __( 'Map primary color', 'bt_plugin' ) ),
				array( 'param_name' => 'secondary_color', 'type' => 'colorpicker', 'heading' => __( 'Map secondary color', 'bt_plugin' ) ),
				array( 'param_name' => 'water_color', 'type' => 'colorpicker', 'heading' => __( 'Map water color', 'bt_plugin' ) ),
				array( 'param_name' => 'custom_style', 'type' => 'textarea_object', 'heading' => __( 'Custom map style array', 'bt_plugin' ), 'description' => 'Find more custom styles at https://snazzymaps.com/' ),			
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ) )
			) )
		);
		
		bt_rc_map( 'bt_clients', array( 'name' => __( 'Clients', 'bt_plugin' ), 'container' => 'vertical', 'description' => __( 'Client container', 'bt_plugin' ), 'accept' => array( 'bt_client' => true ), 'toggle' => true, 'show_settings_on_create' => false,
			'params' => array(
				array( 'param_name' => 'display_type', 'type' => 'dropdown', 'heading' => __( 'Type', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Slider', 'bt_plugin' ) => 'slider',
						__( 'Regular', 'bt_plugin' ) => 'regular'
					) )
			) )
		);
		
		bt_rc_map( 'bt_client', array( 'name' => __( 'Client', 'bt_plugin' ), 'description' => __( 'Individual client element', 'bt_plugin' ),
			'params' => array(
				array( 'param_name' => 'image', 'type' => 'attach_image', 'heading' => __( 'Image', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'url', 'type' => 'textfield', 'heading' => __( 'URL', 'bt_plugin' ) )
			) )
		);
		
		bt_rc_map( 'bt_button', array( 'name' => __( 'Button', 'bt_plugin' ), 'description' => __( 'Button with custom link', 'bt_plugin' ),
			'params' => array(
				array( 'param_name' => 'text', 'type' => 'textfield', 'heading' => __( 'Text', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'icon', 'type' => 'iconpicker', 'heading' => __( 'Icon', 'bt_plugin' ), 'value' => $icon_arr, 'preview' => true ),
				array( 'param_name' => 'url', 'type' => 'textfield', 'heading' => __( 'URL', 'bt_plugin' ) ),
				array( 'param_name' => 'target', 'type' => 'dropdown', 'heading' => __( 'Target window', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no_target',
						__( 'Self', 'bt_plugin' ) => '_self',
						__( 'Blank', 'bt_plugin' ) => '_blank',
						__( 'Parent', 'bt_plugin' ) => '_parent',
						__( 'Top', 'bt_plugin' ) => '_top'
				) ),
				array( 'param_name' => 'style', 'type' => 'dropdown', 'heading' => __( 'Style', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Outline', 'bt_plugin' ) => 'Outline',
						__( 'Filled', 'bt_plugin' ) => 'Filled',
						__( 'Borderless', 'bt_plugin' ) => 'Borderless'
				) ),
				array( 'param_name' => 'icon_position', 'type' => 'dropdown', 'heading' => __( 'Icon Position', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Right', 'bt_plugin' ) => 'Right',
						__( 'Inline', 'bt_plugin' ) => 'Inline',
						__( 'Left', 'bt_plugin' ) => 'Left'
				) ),
				array( 'param_name' => 'color', 'type' => 'dropdown', 'heading' => __( 'Color', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Dark', 'bt_plugin' ) => 'Normal',
						__( 'Accent', 'bt_plugin' ) => 'Accent',
						__( 'Alternate', 'bt_plugin' ) => 'Alternate',
						__( 'Light', 'bt_plugin' ) => 'Light' 
				) ),
				array( 'param_name' => 'size', 'type' => 'dropdown', 'heading' => __( 'Size', 'bt_plugin' ), 'preview' => true,
					'value' => array(
					__( 'Extra Small', 'bt_plugin' ) => 'ExtraSmall',
					__( 'Small', 'bt_plugin' ) => 'Small',
					__( 'Medium', 'bt_plugin' ) => 'Medium',
					__( 'Big', 'bt_plugin' ) => 'Big'
										
				) ),
				array( 'param_name' => 'width', 'type' => 'dropdown', 'heading' => __( 'Width', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Normal', 'bt_plugin' ) => 'Normal',
						__( 'Full', 'bt_plugin' ) => 'Full'				
				) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ) )			
			) )
		);
		
		bt_rc_map( 'bt_counter', array( 'name' => __( 'Counter', 'bt_plugin' ), 'description' => __( 'Animated counter', 'bt_plugin' ),
			'params' => array(
				array( 'param_name' => 'number', 'type' => 'textfield', 'heading' => __( 'Number', 'bt_plugin' ), 'preview' => true )
			) )
		);

		bt_rc_map( 'bt_percentage_bar', array( 'name' => __( 'Percentage bar', 'bt_plugin' ), 'description' => __( 'Animated percentage bar', 'bt_plugin' ),
			'params' => array(
				array( 'param_name' => 'text', 'type' => 'textfield', 'heading' => __( 'Text', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'percentage', 'type' => 'textfield', 'heading' => __( 'Percentage', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'bar_color', 'type' => 'colorpicker', 'heading' => __( 'Color', 'bt_plugin' ) ),		
				array( 'param_name' => 'bar_style', 'type' => 'dropdown', 'heading' => __( 'Style', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Filled', 'bt_plugin' ) => 'Filled',
						__( 'Line', 'bt_plugin' ) => 'Line'
				) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ) )
			) )
		);
		
		bt_rc_map( 'bt_slider', array( 'name' => __( 'Slider', 'bt_plugin' ), 'description' => __( 'Slider container', 'bt_plugin' ), 'container' => 'vertical', 'accept' => array( 'bt_slider_item' => true ), 'toggle' => true, 'show_settings_on_create' => false,
			'params' => array(
				array( 'param_name' => 'height', 'type' => 'dropdown', 'heading' => __( 'Slider height', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Auto', 'bt_plugin' ) => 'auto',
						__( 'Small', 'bt_plugin' ) => 'small',
						__( 'Medium', 'bt_plugin' ) => 'medium',
						__( 'Large', 'bt_plugin' ) => 'large'
				) ),
				array( 'param_name' => 'auto_play', 'type' => 'textfield', 'heading' => __( 'Auto Play Speed (e.g. 3000)', 'bt_plugin' ) ),
				array( 'param_name' => 'hide_arrows', 'type' => 'dropdown', 'heading' => __( 'Hide Arrows', 'bt_plugin' ),
					'value' => array(
						__( 'No', 'bt_plugin' ) => '',
						__( 'Yes', 'bt_plugin' ) => 'btSliderHideArrows'
				) ),				
				array( 'param_name' => 'hide_paging', 'type' => 'dropdown', 'heading' => __( 'Hide Paging', 'bt_plugin' ),
					'value' => array(
						__( 'No', 'bt_plugin' ) => '',
						__( 'Yes', 'bt_plugin' ) => 'btSliderHidePaging'
				) ),
				array( 'param_name' => 'simple_arrows', 'type' => 'dropdown', 'heading' => __( 'Simple Arrows', 'bt_plugin' ),
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no',
						__( 'Yes', 'bt_plugin' ) => 'yes'
				) ),				
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ) )
			) )
		);
		
		bt_rc_map( 'bt_slider_item', array( 'name' => __( 'Slider Item', 'bt_plugin' ), 'description' => __( 'Individual slide element', 'bt_plugin' ), 'container' => 'vertical', 'accept' => array( 'bt_row_inner' => true, 'bt_header' => true, 'bt_button' => true, 'bt_counter' => true, 'bt_icons' => true, 'bt_image' => true, 'bt_text' => true, 'bt_hr' => true, 'bt_service' => true ),
			'params' => array( 
				array( 'param_name' => 'image', 'type' => 'attach_image', 'heading' => __( 'Image', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ) )
			) )
		);
		
		bt_rc_map( 'bt_hr', array( 'name' => __( 'Separator', 'bt_plugin' ), 'description' => __( 'Horizontal separator', 'bt_plugin' ),
			'params' => array( 
				array( 'param_name' => 'top_spaced', 'type' => 'dropdown', 'heading' => __( 'Top spaced', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'not-spaced',
						__( 'Extra-Small-Spaced', 'bt_plugin' ) => 'topExtraSmallSpaced',
						__( 'Small-Spaced', 'bt_plugin' ) => 'topSmallSpaced',		
						__( 'Semi-Spaced', 'bt_plugin' ) => 'topSemiSpaced',
						__( 'Spaced', 'bt_plugin' ) => 'topSpaced',
						__( 'Extra-Spaced', 'bt_plugin' ) => 'topExtraSpaced'
				) ),
				array( 'param_name' => 'bottom_spaced', 'type' => 'dropdown', 'heading' => __( 'Bottom spaced', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'not-spaced',
						__( 'Extra-Small-Spaced', 'bt_plugin' ) => 'bottomExtraSmallSpaced',
						__( 'Small-Spaced', 'bt_plugin' ) => 'bottomSmallSpaced',
						__( 'Semi-Spaced', 'bt_plugin' ) => 'bottomSemiSpaced',
						__( 'Spaced', 'bt_plugin' ) => 'bottomSpaced',
						__( 'Extra-Spaced', 'bt_plugin' ) => 'bottomExtraSpaced'
				) ),				
				array( 'param_name' => 'transparent_border', 'type' => 'dropdown', 'heading' => __( 'Border', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'noBorder',
						__( 'Yes', 'bt_plugin' ) => 'border'
				) ),				
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ) )
			) )
		);

		bt_rc_map( 'bt_icon', array( 'name' => __( 'Icon', 'bt_plugin' ), 'description' => __( 'Single icon with link', 'bt_plugin' ),
			'params' => array(
				array( 'param_name' => 'icon', 'type' => 'iconpicker', 'heading' => __( 'Icon', 'bt_plugin' ), 'value' => $icon_arr, 'preview' => true ),	
				array( 'param_name' => 'icon_title', 'type' => 'textfield', 'heading' => __( 'Title', 'bt_plugin' ) ),
				array( 'param_name' => 'icon_type', 'type' => 'dropdown', 'heading' => __( 'Icon Type', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Default', 'bt_plugin' ) 	=> 'btIcoDefaultType',
						__( 'Filled', 'bt_plugin' )	 	=> 'btIcoFilledType',
						__( 'Outline', 'bt_plugin' )	=> 'btIcoOutlineType'
					) ),
				array( 'param_name' => 'icon_color', 'type' => 'dropdown', 'heading' => __( 'Icon Color', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Default Color', 'bt_plugin' ) 	=> 'btIcoDefaultColor',
						__( 'Accent Color', 'bt_plugin' )	 	=> 'btIcoAccentColor',
						__( 'Alternate Color', 'bt_plugin' )	 	=> 'btIcoAlterColor',
					) ),
				array( 'param_name' => 'icon_size', 'type' => 'dropdown', 'heading' => __( 'Icon Size', 'bt_plugin' ), 'preview' => true,
					'value' => array(
							__( 'Small', 'bt_plugin' ) 			=> 'btIcoSmallSize',		
							__( 'Extra Small', 'bt_plugin' )	=> 'btIcoExtraSmallSize',
							__( 'Medium', 'bt_plugin' )	 		=> 'btIcoMediumSize',
							__( 'Big', 'bt_plugin' )	 		=> 'btIcoBigSize',
							__( 'Large', 'bt_plugin' )			=> 'btIcoLargeSize'
					) ),
				array( 'param_name' => 'icon_animation', 'type' => 'dropdown', 'heading' => __( 'Icon Animation', 'bt_plugin' ), 'preview' => true,
					'value' => array(
							__( 'Default', 'bt_plugin' ) 				=> '',		
							__( 'Move from bottom', 'bt_plugin' )		=> 'btIcoFromBottom',
							__( 'Move from left', 'bt_plugin' )	 		=> 'btIcoFromLeft',
							__( 'Move from top', 'bt_plugin' )	 		=> 'btIcoFromTop'
					) ),
				array( 'param_name' => 'icon_outline', 'type' => 'dropdown', 'heading' => __( 'Icon Outline', 'bt_plugin' ), 'preview' => true,
					'value' => array(
							__( 'No', 'bt_plugin' ) 			=> '',		
							__( 'Yes', 'bt_plugin' )			=> 'btIcoOutline'
					) ),
				array( 'param_name' => 'url', 'type' => 'textfield', 'heading' => __( 'URL', 'bt_plugin' ) ),
				array( 'param_name' => 'target', 'type' => 'dropdown', 'heading' => __( 'Target window', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no_target',
						__( 'Self', 'bt_plugin' ) => '_self',
						__( 'Blank', 'bt_plugin' ) => '_blank',
						__( 'Parent', 'bt_plugin' ) => '_parent',
						__( 'Top', 'bt_plugin' ) => '_top'
				) ),				
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ) )
			) )
		);
		
		bt_rc_map( 'bt_icons', array( 'name' => __( 'Icon and images holder', 'bt_plugin' ), 'description' => __( 'Icon container', 'bt_plugin' ), 'container' => 'vertical', 'accept' => array( 'bt_icon' => true, 'bt_image' => true, 'bt_service' => true ), 'toggle' => true, 'show_settings_on_create' => false,
			'params' => array( 
				array( 'param_name' => 'position', 'type' => 'dropdown', 'heading' => __( 'Position', 'bt_plugin' ), 'preview' => true,
							'value' => array(
								__( 'Normal', 'bt_plugin' ) => 'btIconsNormalPosition',
								__( 'Over previous element (half height)', 'bt_plugin' ) => 'btIconsHalfHoverPosition',
								__( 'Over previous element (full height)', 'bt_plugin' ) => 'btIconsFullHoverPosition'
						) ),		
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ) )
			) )
		);

		bt_rc_map( 'bt_latest_posts', array( 'name' => __( 'Latest Posts', 'bt_plugin' ), 'description' => __( 'Recent posts', 'bt_plugin' ),
			'params' => array(
				array( 'param_name' => 'number', 'type' => 'textfield', 'heading' => __( 'Number of Items', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'category', 'type' => 'textfield', 'heading' => __( 'Category Slug', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'format', 'type' => 'dropdown', 'heading' => __( 'Format', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Horizontal', 'bt_plugin' ) => 'horizontal',
						__( 'Vertical', 'bt_plugin' ) => 'vertical'
				) ),
				array( 'param_name' => 'post_type', 'type' => 'dropdown', 'heading' => __( 'Post Type', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Blog', 'bt_plugin' ) => 'blog',
						__( 'Portfolio', 'bt_plugin' ) => 'portfolio'
				) ),
				array( 'param_name' => 'show_excerpt', 'type' => 'dropdown', 'heading' => __( 'Show Excerpt', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Yes', 'bt_plugin' ) => 'yes',
						__( 'No', 'bt_plugin' ) => 'no'
				) ),
				array( 'param_name' => 'show_date', 'type' => 'dropdown', 'heading' => __( 'Show Date', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Yes', 'bt_plugin' ) => 'yes',
						__( 'No', 'bt_plugin' ) => 'no'
				) ),
				array( 'param_name' => 'show_author', 'type' => 'dropdown', 'heading' => __( 'Show Author', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Yes', 'bt_plugin' ) => 'yes',
						__( 'No', 'bt_plugin' ) => 'no'
				) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ) )
			) )
		);	

		bt_rc_map( 'bt_grid', array( 'name' => __( 'Grid', 'bt_plugin' ), 'description' => __( 'Grid with recent posts', 'bt_plugin' ),
			'params' => array(
				array( 'param_name' => 'number', 'type' => 'textfield', 'heading' => __( 'Number of items', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'columns', 'type' => 'dropdown', 'heading' => __( 'Columns', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( '3', 'bt_plugin' ) => '3',
						__( '4', 'bt_plugin' ) => '4',
						__( '5', 'bt_plugin' ) => '5',
						__( '6', 'bt_plugin' ) => '6'
				) ),
				array( 'param_name' => 'category', 'type' => 'textfield', 'heading' => __( 'Category Slug', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'category_filter', 'type' => 'dropdown', 'heading' => __( 'Category Filter', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no',
						__( 'Yes', 'bt_plugin' ) => 'yes'
				) ),
				array( 'param_name' => 'grid_type', 'type' => 'dropdown', 'heading' => __( 'Grid Type', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Classic', 'bt_plugin' ) => 'classic',
						__( 'Tiled', 'bt_plugin' ) => 'tiled'
				) ),
				array( 'param_name' => 'grid_gap', 'type' => 'dropdown', 'heading' => __( 'Grid Gap', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( '0', 'bt_plugin' ) => '0',
						__( '1', 'bt_plugin' ) => '1',
						__( '2', 'bt_plugin' ) => '2',
						__( '3', 'bt_plugin' ) => '3',
						__( '4', 'bt_plugin' ) => '4',
						__( '5', 'bt_plugin' ) => '5',
						__( '6', 'bt_plugin' ) => '6',
						__( '7', 'bt_plugin' ) => '7',
						__( '8', 'bt_plugin' ) => '8',
						__( '9', 'bt_plugin' ) => '9',
						__( '10', 'bt_plugin' ) => '10',
						__( '15', 'bt_plugin' ) => '15',
						__( '20', 'bt_plugin' ) => '20'
				) ),
				array( 'param_name' => 'format', 'type' => 'textfield', 'heading' => __( 'Tiled Format', 'bt_plugin' ) ),				
				array( 'param_name' => 'tiles_title', 'type' => 'dropdown', 'heading' => __( 'Show Title in Tiles', 'bt_plugin' ),
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no',
						__( 'Yes', 'bt_plugin' ) => 'yes'
				) ),				
				array( 'param_name' => 'post_type', 'type' => 'dropdown', 'heading' => __( 'Post Type', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Blog', 'bt_plugin' ) => 'blog',
						__( 'Portfolio', 'bt_plugin' ) => 'portfolio'
				) ),
				array( 'param_name' => 'scroll_loading', 'type' => 'dropdown', 'heading' => __( 'Scroll Loading', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no',
						__( 'Yes', 'bt_plugin' ) => 'yes'
				) ),
				array( 'param_name' => 'sticky_in_grid', 'type' => 'dropdown', 'heading' => __( 'Show Sticky Posts', 'bt_plugin' ),
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no',
						__( 'Yes', 'bt_plugin' ) => 'yes'
				) ),				
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ) )
			) )
		);
		
		bt_rc_map( 'bt_grid_gallery', array( 'name' => __( 'Grid Gallery', 'bt_plugin' ), 'description' => __( 'Responsive grid gallery with lightbox.', 'bt_plugin' ),
			'params' => array(
				array( 'param_name' => 'ids', 'type' => 'attach_images', 'heading' => __( 'Images', 'bt_plugin' ) ),
				array( 'param_name' => 'format', 'type' => 'textfield', 'heading' => __( 'Format (e.g. 21,11,12)', 'bt_plugin' ) ),
				array( 'param_name' => 'lightbox', 'type' => 'hidden', 'value' => 'yes' ),
				array( 'param_name' => 'grid_gap', 'type' => 'dropdown', 'heading' => __( 'Grid Gap', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( '0', 'bt_plugin' ) => '0',
						__( '1', 'bt_plugin' ) => '1',
						__( '2', 'bt_plugin' ) => '2',
						__( '3', 'bt_plugin' ) => '3',
						__( '4', 'bt_plugin' ) => '4',
						__( '5', 'bt_plugin' ) => '5',
						__( '6', 'bt_plugin' ) => '6',
						__( '7', 'bt_plugin' ) => '7',
						__( '8', 'bt_plugin' ) => '8',
						__( '9', 'bt_plugin' ) => '9',
						__( '10', 'bt_plugin' ) => '10',
						__( '15', 'bt_plugin' ) => '15',
						__( '20', 'bt_plugin' ) => '20'
				) ),
				array( 'param_name' => 'columns', 'type' => 'dropdown', 'heading' => __( 'Columns', 'bt_plugin' ),
					'value' => array(
						__( '3', 'bt_plugin' ) => '3',
						__( '4', 'bt_plugin' ) => '4',
						__( '5', 'bt_plugin' ) => '5',
						__( '6', 'bt_plugin' ) => '6'
				) ),
				array( 'param_name' => 'links', 'type' => 'textarea', 'heading' => __( 'Links (comma-separated)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ) )
			) )
		);		
		
		bt_rc_map( 'bt_price_list', array( 'name' => __( 'Price List', 'bt_plugin' ), 'description' => __( 'Price List element', 'bt_plugin' ),
			'params' => array( 
				array( 'param_name' => 'title', 'type' => 'textfield', 'heading' => __( 'Title', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'subtitle', 'type' => 'textfield', 'heading' => __( 'Subtitle', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'sticker', 'type' => 'textfield', 'heading' => __( 'Sticker Text', 'bt_plugin' ) ),
				array( 'param_name' => 'currency', 'type' => 'textfield', 'heading' => __( 'Currency', 'bt_plugin' ) ),
				array( 'param_name' => 'price', 'type' => 'textfield', 'heading' => __( 'Price', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'items', 'type' => 'textarea', 'heading' => __( 'Items', 'bt_plugin' ) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ) )
			) )
		);
		
		bt_rc_map( 'bt_dropdown', array( 'name' => __( 'Dropdown', 'bt_plugin' ), 'description' => __( 'Dropdown with links', 'bt_plugin' ),
			'params' => array( 
				array( 'param_name' => 'title', 'type' => 'textfield', 'heading' => __( 'Title', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'dd_content', 'type' => 'textarea', 'heading' => __( 'Dropdown Items', 'bt_plugin' ), 'description' => __( 'name;URL separated by new line.', 'bt_plugin' ) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ) )
			) )
		);
		
		bt_rc_map( 'bt_working_hours', array( 'name' => __( 'Working hours', 'bt_plugin' ), 'description' => __( 'Working hours with links', 'bt_plugin' ),
			'params' => array( 
				array( 'param_name' => 'wh_content', 'type' => 'textarea', 'heading' => __( 'Working Hours', 'bt_plugin' ), 'description' => __( 'value;value;URL title,URL separated by new line (leave ; at the end to remove link)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ) )
			) )
		);	

	}
}
add_action( 'plugins_loaded', 'bt_map_sc' );


// WIDGETS

if ( ! class_exists( 'BT_Gallery' ) ) {

	// GALLERY

	class BT_Gallery extends WP_Widget {
	
		function __construct() {
			parent::__construct(
				'bt_gallery', // Base ID
				__( 'BT Gallery', 'bt_plugin' ), // Name
				array( 'description' => __( 'Gallery widget.', 'bt_plugin' ) ) // Args
			);
		}

		public function widget( $args, $instance ) {
		
			echo $args['before_widget'];
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
			}
			
			if ( $instance['ids'] != '' ) {
				echo do_shortcode( '[gallery ids="' . $instance['ids'] . '"]' );
			}
			
			echo $args['after_widget'];
		}
		
		public function form( $instance ) {
			$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Gallery', 'bt_plugin' );
			$ids = ! empty( $instance['ids'] ) ? $instance['ids'] : '';
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'ids' ) ); ?>"><?php _e( 'List of image IDs (comma-separated):', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'ids' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ids' ) ); ?>" type="text" value="<?php echo esc_attr( $ids ); ?>">
			</p>			
			<?php 
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['ids'] = ( ! empty( $new_instance['ids'] ) ) ? strip_tags( $new_instance['ids'] ) : '';

			return $instance;
		}
	}	
}

if ( ! class_exists( 'BT_Text_Image' ) ) {

	// TEXT IMAGE

	class BT_Text_Image extends WP_Widget {

		function __construct() {
			parent::__construct(
				'bt_text_image', // Base ID
				__( 'BT Text Image', 'bt_plugin' ), // Name
				array( 'description' => __( 'Text with image.', 'bt_plugin' ) ) // Args
			);
		}

		public function widget( $args, $instance ) {

			echo $args['before_widget'];
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
			}
				
			if ( $instance['ids'] != '' ) {
				echo do_shortcode( '[image ids="' . $instance['ids'] . '"]' );
			}
			echo '<div class="widget_sp_image-description">' . wpautop( $instance['text'] ) . '</div>';
			
			echo $args['after_widget'];
		}

		public function form( $instance ) {
			$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$ids = ! empty( $instance['ids'] ) ? $instance['ids'] : '';
			$text = ! empty( $instance['text'] ) ? $instance['text'] : '';
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'ids' ) ); ?>"><?php _e( 'Image IDs:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'ids' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ids' ) ); ?>" type="text" value="<?php echo esc_attr( $ids ); ?>">
			</p>			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php _e( 'Text:', 'bt_plugin' ); ?></label> 
				<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" > <?php echo esc_attr( $text ); ?></textarea>
			</p>			
			<?php 
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['ids'] = ( ! empty( $new_instance['ids'] ) ) ? strip_tags( $new_instance['ids'] ) : '';
			$instance['text'] = ( ! empty( $new_instance['text'] ) ) ? strip_tags( $new_instance['text'] ) : '';

			return $instance;
		}
	}	
}

if ( ! class_exists( 'BT_Icon_Widget' ) ) {

	// ICON

	class BT_Icon_Widget extends WP_Widget {

		function __construct() {
			parent::__construct(
				'bt_icon_widget', // Base ID
				__( 'BT Icon', 'bt_plugin' ), // Name
				array( 'description' => __( 'Icon with text and link.', 'bt_plugin' ) ) // Args
			);
		}

		public function widget( $args, $instance ) {
		
			$icon = ! empty( $instance['icon'] ) ? $instance['icon'] : '';
			$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$text = ! empty( $instance['text'] ) ? $instance['text'] : '';
			$url = ! empty( $instance['url'] ) ? $instance['url'] : '';
			$show_button = ! empty( $instance['show_button'] ) ? $instance['show_button'] : '';
			$target = ! empty( $instance['target'] ) ? $instance['target'] : '';

			$extra_class = '';
			if ( $show_button != '' ) {
				$extra_class = 'btSpecialHeaderIcon';
			}

			$wrap_start_tag = '<span class="btIconWidget ' . $extra_class . '">';
			$wrap_end_tag = '</span>';

			if ( $url != '' ) {
				$wrap_start_tag = '<a href="' . $url . '" target="' . $target . '" class="btIconWidget ' . $extra_class . '">';
				$wrap_end_tag = '</a>';
			}

			// echo boldthemes_get_icon_html( $icon, $url, $text, 'btIcoExtraSmallSize btIcoDefaultType btIcoDefaultColor', $target );

			echo $wrap_start_tag;
				if ( $icon != '' ) {
					echo '<span class="btIconWidgetIcon">';
						echo boldthemes_get_icon_html( $icon, '', '', '', $target );
					echo '</span>';
				}
				if ( $title != '' || $text != '' ) {
					echo '<span class="btIconWidgetContent">';
						if ( $title != '' ) echo '<span class="btIconWidgetTitle">' . $title . '</span>';
						if ( $text != '' ) echo '<span class="btIconWidgetText">' . $text . '</span>';
					echo '</span>';
				}
			echo $wrap_end_tag;
		}

		public function form( $instance ) {
			$icon = ! empty( $instance['icon'] ) ? $instance['icon'] : '';
			$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$text = ! empty( $instance['text'] ) ? $instance['text'] : '';
			$url = ! empty( $instance['url'] ) ? $instance['url'] : '';
			$show_button = ! empty( $instance['show_button'] ) ? $instance['show_button'] : '';
			$target = ! empty( $instance['target'] ) ? $instance['target'] : '';
			
			if ( ! function_exists( 'bt_fa_icons' ) ) {
				require_once( 'bt_fa_icons.php' );
			}
			if ( ! function_exists( 'bt_s7_icons' ) ) {
				require_once( 'bt_s7_icons.php' );
			}		
			if ( ! function_exists( 'bt_custom_icons' ) ) {
				require_once( 'bt_custom_icons.php' );
			}
			$icon_arr = array_merge( array( ' ' => 'no_icon' ), bt_fa_icons(), bt_s7_icons(), bt_custom_icons() );
			ksort( $icon_arr );
			?>		
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>"><?php _e( 'Icon:', 'bt_plugin' ); ?></label> 
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon' ) ); ?>">
					<option value=""></option>;
					<?php
					foreach( $icon_arr as $key => $value ) {
						if ( $value == $icon ) {
							echo '<option value="' . $value . '" selected>' . $key . '</option>';
						} else {
							echo '<option value="' . $value . '">' . $key . '</option>';
						}
					}
					?>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php _e( 'Text:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"><?php _e( 'URL or slug:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'url' ) ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>">
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $instance['show_button'], 'on' ); ?> id="<?php echo $this->get_field_id('show_button'); ?>" name="<?php echo $this->get_field_name('show_button'); ?>" /> 
				<label for="<?php echo $this->get_field_id('show_button'); ?>"><?php _e( 'Show in accent color', 'bt_plugin' ); ?></label>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><?php _e( 'Target:', 'bt_plugin' ); ?></label> 
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>">
					<option value=""></option>;
					<?php
					$target_arr = array("Self" => "_self", "Blank" => "_blank", "Parent" => "_parent", "Top" => "_top");
					foreach( $target_arr as $key => $value ) {
						if ( $value == $target ) {
							echo '<option value="' . $value . '" selected>' . $key . '</option>';
						} else {
							echo '<option value="' . $value . '">' . $key . '</option>';
						}
					}
					?>
				</select>
			</p>
			<?php 
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['icon'] = ( ! empty( $new_instance['icon'] ) ) ? strip_tags( $new_instance['icon'] ) : '';
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['text'] = ( ! empty( $new_instance['text'] ) ) ? strip_tags( $new_instance['text'] ) : '';
			$instance['url'] = ( ! empty( $new_instance['url'] ) ) ? strip_tags( $new_instance['url'] ) : '';
			$instance['show_button'] = $new_instance['show_button'];
			$instance['target'] = ( ! empty( $new_instance['target'] ) ) ? strip_tags( $new_instance['target'] ) : '';

			return $instance;
		}
	}	
}

if ( ! class_exists( 'BT_Recent_Posts' ) ) {
	
	// RECENT POSTS	
	
	class BT_Recent_Posts extends WP_Widget {
	
		function __construct() {
			parent::__construct(
				'bt_recent_posts', // Base ID
				__( 'BT Recent Posts', 'bt_plugin' ), // Name
				array( 'description' => __( 'Recent posts with thumbnails.', 'bt_plugin' ) ) // Args
			);
		}

		public function widget( $args, $instance ) {
		
			echo $args['before_widget'];
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
			}

			$number = intval( trim( $instance['number'] ) );
			if ( $number < 1 ) {
				$number = 5;
			} else if ( $number > 30 ) {
				$number = 30;
			}
			
			echo '<div class="popularPosts"><ul>';
			
			$recent_posts = wp_get_recent_posts( array( 'numberposts' => $number, 'post_status' => 'publish' ) );
			foreach ( $recent_posts as $recent ) {
				$link = get_permalink( $recent['ID'] );
				$user_data = get_userdata( $recent['post_author'] );
				$user_url = $user_data->data->user_url;
				
				$post_format = get_post_format( $recent['ID'] );
				$images = boldthemes_rwmb_meta( BoldThemesPFX . '_images', 'type=image', $recent['ID'] );
				if ( $images == null ) $images = array();
				
				$img = get_the_post_thumbnail( $recent['ID'], 'thumbnail' );
				
				if ( $post_format == 'image' && $img == '' ) {
					foreach ( $images as $img ) {
						$src = $img['full_url'];
						$img = '<img src="' . esc_url( $src ) . '" alt="' . esc_attr( basename( $src ) ) . '">';
						break;
					}
				}					

				echo '<li>';
				if ( $img != '' ) echo '<div class="ppImage"><a href="' . esc_url( $link ) . '">' . $img . '</a></div>';
				// echo '<div class="ppTxt"><p class="posted">' . date_i18n( MedicareTheme::$boldthemes_date_format, strtotime( get_the_time( 'Y-m-d', $recent['ID'] ) ) ) . '<h5><a href="' . esc_url( $link ) . '">' . esc_html( $recent['post_title'] ) . '</a></h5></div></li>';
				echo '<div class="ppTxt"><p class="posted">' . date_i18n( MedicareTheme::$boldthemes_date_format, strtotime( get_the_time( 'Y-m-d', $recent['ID'] ) ) ) . '</p>' . boldthemes_get_heading_html( '', '<a href="' . esc_url( $link ) . '">' . esc_html( $recent['post_title'] ) . '</a>', '', 'small', '', '', '' ) . '</div>';
			}
			
			echo '</ul></div>';
				
			echo $args['after_widget'];
		}
		
		public function form( $instance ) {
			$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Recent Posts', 'bt_plugin' );
			$number = ! empty( $instance['number'] ) ? $instance['number'] : '5';
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of posts:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>">			
			</p>
			<?php 
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';

			return $instance;
		}
	}
}


if ( ! class_exists( 'BT_Recent_Comments' ) ) {
	
	// RECENT COMMENTS	
	
	class BT_Recent_Comments extends WP_Widget {
	
		function __construct() {
			parent::__construct(
				'bt_recent_comments', // Base ID
				__( 'BT Recent Comments', 'bt_plugin' ), // Name
				array( 'description' => __( 'Recent comments with avatars.', 'bt_plugin' ) ) // Args
			);
		}

		public function widget( $args, $instance ) {
		
			echo $args['before_widget'];
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
			}			

			$number = intval( trim( $instance['number'] ) );
			if ( $number < 1 ) {
				$number = 5;
			} else if ( $number > 30 ) {
				$number = 30;
			}
			
			echo '<div class="latestComments"><ul>';
			
			$comments_query = new WP_Comment_Query;
			$recent_comments = $comments_query->query( array( 'number' => $number, 'status' => 'approve' ) );
			if ( $recent_comments ) {
				foreach ( $recent_comments as $recent ) {
					echo '<li><h5><a href="' . esc_url( get_permalink( $recent->comment_post_ID ) ) . '">' . esc_html( get_the_title( $recent->comment_post_ID ) ) . '</a></h5><p class="posted">' . date_i18n( MedicareTheme::$boldthemes_date_format, strtotime( get_the_time( 'Y-m-d', $recent->comment_date ) ) ) . ' &mdash; ' . __( 'by', 'bt_plugin' ) . ' <a href="' . esc_url( $recent->comment_author_url ) . '">' . $recent->comment_author . '</a></p></li>';
				}
			}

			echo '</div></ul>';
				
			echo $args['after_widget'];
		}
		
		public function form( $instance ) {
			$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Recent Comments', 'bt_plugin' );
			$number = ! empty( $instance['number'] ) ? $instance['number'] : '5';
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of comments:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>">			
			</p>
			<?php 
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';

			return $instance;
		}
	}
}

if ( ! class_exists( 'BT_Instagram' ) ) {
	
	// INSTAGRAM	
	
	class BT_Instagram extends WP_Widget {
		
		private $feed_id;
	
		function __construct() {
			parent::__construct(
				'bt_instagram', // Base ID
				__( 'BT Instagram', 'bt_plugin' ), // Name
				array( 'description' => __( 'Instagram photos.', 'bt_plugin' ) ) // Args
			);
		}

		public function widget( $args, $instance ) {

			wp_enqueue_script( 'bt_instagram', plugin_dir_url( __FILE__ ) . 'instafeed.min.js', array(), '', true );

			$number = intval( trim( $instance['number'] ) );
			if ( $number < 1 ) {
				$number = 4;
			} else if ( $number > 30 ) {
				$number = 30;
			}
			
			$instance['tag'] = isset( $instance['tag'] ) ? $instance['tag'] : '';
			$instance['access_token'] = isset( $instance['access_token'] ) ? $instance['access_token'] : '';
			
			$this->feed_id = uniqid( 'instafeed' );
			
			$this->number = $number;
			$this->user_id = trim( $instance['user_id'] );
			$this->tag = trim( $instance['tag'] );
			$this->client_id = trim( $instance['client_id'] );
			$this->access_token = trim( $instance['access_token'] );
			
			// if ( $this->number == '' || $this->user_id == '' || $this->client_id == '' ) {
			if ( $this->access_token == '' || $this->client_id == '' ) {
				return;
			}

			echo $args['before_widget'];
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
			}
			
			echo '<div class="btInstaWrap">';
			echo '<div id="' . $this->feed_id . '" class="btInstaGrid"></div>';
			echo '</div>';				
			echo $args['after_widget'];
			
			$proxy = new BT_Instagram_Proxy( $this->feed_id, $this->number, $this->user_id, $this->tag, $this->client_id, $this->access_token );
			add_action( 'wp_footer', array( $proxy, 'js' ) );
		}
	
		
		public function form( $instance ) {
			$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Instagram', 'bt_plugin' );
			$number = ! empty( $instance['number'] ) ? $instance['number'] : '4';
			$user_id = ! empty( $instance['user_id'] ) ? $instance['user_id'] : '';
			$tag = ! empty( $instance['tag'] ) ? $instance['tag'] : '';
			$client_id = ! empty( $instance['client_id'] ) ? $instance['client_id'] : '';
			$access_token = ! empty( $instance['access_token'] ) ? $instance['access_token'] : '';
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of photos:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>">			
			</p>
			<!--p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'user_id' ) ); ?>"><?php _e( 'User ID:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'user_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'user_id' ) ); ?>" type="text" value="<?php echo esc_attr( $user_id ); ?>">			
			</p-->
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'tag' ) ); ?>"><?php _e( 'Hashtag:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tag' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tag' ) ); ?>" type="text" value="<?php echo esc_attr( $tag ); ?>">			
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'client_id' ) ); ?>"><?php _e( 'Client ID:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'client_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'client_id' ) ); ?>" type="text" value="<?php echo esc_attr( $client_id ); ?>">			
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'access_token' ) ); ?>"><?php _e( 'Access token:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'access_token' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'access_token' ) ); ?>" type="text" value="<?php echo esc_attr( $access_token ); ?>">			
			</p>
			<?php 
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
			$instance['user_id'] = ( ! empty( $new_instance['user_id'] ) ) ? strip_tags( $new_instance['user_id'] ) : '';
			$instance['tag'] = ( ! empty( $new_instance['tag'] ) ) ? strip_tags( $new_instance['tag'] ) : '';
			$instance['client_id'] = ( ! empty( $new_instance['client_id'] ) ) ? strip_tags( $new_instance['client_id'] ) : '';
			$instance['access_token'] = ( ! empty( $new_instance['access_token'] ) ) ? strip_tags( $new_instance['access_token'] ) : '';
			
			return $instance;
		}
	}
	
	class BT_Instagram_Proxy {
		function __construct( $feed_id, $number, $user_id, $tag, $client_id, $access_token ) {
			$this->feed_id = $feed_id;
			$this->number = $number;
			$this->user_id = $user_id;
			$this->tag = $tag;
			$this->client_id = $client_id;
			$this->access_token = $access_token;
		}
		public function js() { ?>
			<script>
				jQuery( document ).ready(function() {
					var feed = new Instafeed({
						get: 'tagged',
						tagName: '<?php echo $this->tag; ?>',
						target: '<?php echo $this->feed_id; ?>', 
						limit: '<?php echo $this->number; ?>',
						template: '<span><a href="{{link}}"><img src="{{image}}" /></a></span>',
						clientId: '<?php echo $this->client_id; ?>',
						accessToken: '<?php echo $this->access_token; ?>'
					});
					feed.run();
				});
			</script>
		<?php }
	}	
	
}

if ( ! class_exists( 'BT_Twitter' ) ) {
	
	// TWITTER	
	
	class BT_Twitter extends WP_Widget {
	
		function __construct() {
			parent::__construct(
				'bt_twitter', // Base ID
				__( 'BT Twitter', 'bt_plugin' ), // Name
				array( 'description' => __( 'Twitter feed.', 'bt_plugin' ) ) // Args
			);
		}

		public function widget( $args, $instance ) {
			
			$number = intval( trim( $instance['number'] ) );
			
			if ( $number < 1 ) {
				$number = 5;
			} else if ( $number > 30 ) {
				$number = 30;
			}

			$cache = intval( trim( $instance['cache'] ) );
			if ( $cache == 0 || $cache < 0 ) {
				$cache = 0;
			} else if ( $cache > 720 ) {
				$cache = 720;
			}		

			$this->number = $number;
			$this->cache = $cache;
			$this->username = trim( $instance['username'] );
			$this->consumer_key = trim( $instance['consumer_key'] );
			$this->consumer_secret = trim( $instance['consumer_secret'] );
			$this->access_token = trim( $instance['access_token'] );
			$this->access_token_secret = trim( $instance['access_token_secret'] );
			
			if ( $this->number == '' || $this->username == '' || $this->consumer_key == '' || $this->consumer_secret == '' || $this->access_token == '' || $this->access_token_secret == '' ) {
				return;
			}			
		
			echo $args['before_widget'];
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
			}
			
			$trans_name = 'bt_tweets';

			if ( $cache == 0 ) {
				delete_transient( $trans_name );
			}

			if ( false == ( $twitter_data = unserialize( base64_decode( get_transient( $trans_name ) ) ) ) ) {
				require_once( 'twitteroauth.php' );
				$twitter_connection = new TwitterOAuth( $this->consumer_key, $this->consumer_secret, $this->access_token, $this->access_token_secret );

				$twitter_data = $twitter_connection->get(
					'statuses/user_timeline',
					array(
						'screen_name'     => $this->username,
						'count'           => $this->number,
						'exclude_replies' => false
					)
				);

				if ( $twitter_connection->http_code != 200 ) {
					$twitter_data = unserialize( base64_decode( get_transient( $trans_name ) ) );
				}

				set_transient( $trans_name, base64_encode( serialize( $twitter_data ) ), 60 * $cache );
			}
			
			echo '<div class="recentTweets">';

			foreach ( $twitter_data as $data ) {
				$link = 'https://twitter.com/' . $this->username . '/status/' . $data->id_str;
				
				$text = mb_convert_encoding( utf8_encode( $data->text ), 'HTML-ENTITIES', 'UTF-8' );

				$time = human_time_diff( strtotime( $data->created_at ) );

				echo '<small><a href="' . esc_url( $link ) . '">@' . $this->username . ' - ' . $time . '</a></small>';
				echo '<p>' . $this->parse( $data->text ) . '</p>';
			}
			
			echo '</div>';
				
			echo $args['after_widget'];
		}
		
		public function form( $instance ) {
			$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Twitter', 'bt_plugin' );
			$number = ! empty( $instance['number'] ) ? $instance['number'] : '5';
			$cache = ! empty( $instance['cache'] ) ? $instance['cache'] : '0';
			$username = ! empty( $instance['username'] ) ? $instance['username'] : '';
			$consumer_key = ! empty( $instance['consumer_key'] ) ? $instance['consumer_key'] : '';
			$consumer_secret = ! empty( $instance['consumer_secret'] ) ? $instance['consumer_secret'] : '';
			$access_token = ! empty( $instance['access_token'] ) ? $instance['access_token'] : '';
			$access_token_secret = ! empty( $instance['access_token_secret'] ) ? $instance['access_token_secret'] : '';
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of tweets:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>">			
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"><?php _e( 'Username:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" type="text" value="<?php echo esc_attr( $username ); ?>">			
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'cache' ) ); ?>"><?php _e( 'Cache (minutes):', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cache' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cache' ) ); ?>" type="text" value="<?php echo esc_attr( $cache ); ?>">			
			</p>			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'consumer_key' ) ); ?>"><?php _e( 'Consumer key:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'consumer_key' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'consumer_key' ) ); ?>" type="text" value="<?php echo esc_attr( $consumer_key ); ?>">			
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'consumer_secret' ) ); ?>"><?php _e( 'Consumer secret:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'consumer_secret' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'consumer_secret' ) ); ?>" type="text" value="<?php echo esc_attr( $consumer_secret ); ?>">			
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'access_token' ) ); ?>"><?php _e( 'Access token:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'access_token' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'access_token' ) ); ?>" type="text" value="<?php echo esc_attr( $access_token ); ?>">			
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'access_token_secret' ) ); ?>"><?php _e( 'Access token secret:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'access_token_secret' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'access_token_secret' ) ); ?>" type="text" value="<?php echo esc_attr( $access_token_secret ); ?>">			
			</p>			
			<?php 
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
			$instance['username'] = ( ! empty( $new_instance['username'] ) ) ? strip_tags( $new_instance['username'] ) : '';
			$instance['cache'] = ( ! empty( $new_instance['cache'] ) ) ? strip_tags( $new_instance['cache'] ) : '';
			$instance['consumer_key'] = ( ! empty( $new_instance['consumer_key'] ) ) ? strip_tags( $new_instance['consumer_key'] ) : '';
			$instance['consumer_secret'] = ( ! empty( $new_instance['consumer_secret'] ) ) ? strip_tags( $new_instance['consumer_secret'] ) : '';
			$instance['access_token'] = ( ! empty( $new_instance['access_token'] ) ) ? strip_tags( $new_instance['access_token'] ) : '';
			$instance['access_token_secret'] = ( ! empty( $new_instance['access_token_secret'] ) ) ? strip_tags( $new_instance['access_token_secret'] ) : '';

			return $instance;
		}
		
		private function parse( $text ) {
			$text = preg_replace( '/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i', '<a href="$1" class="twitter-link">$1</a>', $text );
			$text = preg_replace( '/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i', '<a href="http://$1" class="twitter-link">$1</a>', $text );

			$text = preg_replace( '/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i', '<a href="mailto://$1" class="twitter-link">$1</a>', $text );

			$text = preg_replace( '/([\.|\,|\:|\|\|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', '$1<a href="https://twitter.com/hashtag/$2" class="twitter-link">#$2</a>$3 ', $text );
			
			$text = preg_replace( '/([\.|\,|\:|\|\|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', '$1<a href="https://twitter.com/$2" class="twitter-user">@$2</a>$3 ', $text );			
			
			return $text;
		}
	}
}

if ( ! function_exists( 'register_bt_widgets' ) ) {
	function register_bt_widgets() {
		register_widget( 'BT_Gallery' );
		register_widget( 'BT_Text_Image' );
		register_widget( 'BT_Icon_Widget' );
		register_widget( 'BT_Recent_Posts' );
		register_widget( 'BT_Recent_Comments' );
		register_widget( 'BT_Instagram' );
		register_widget( 'BT_Twitter' );
	}
}
add_action( 'widgets_init', 'register_bt_widgets' );

// portfolio
if ( ! function_exists( 'bt_create_portfolio' ) ) {
	function bt_create_portfolio() {
		register_post_type( 'portfolio',
			array(
				'labels' => array(
					'name'          => __( 'Portfolio', 'bt_plugin' ),
					'singular_name' => __( 'Portfolio Item', 'bt_plugin' )
				),
				'public'        => true,
				'has_archive'   => true,
				'menu_position' => 5,
				'supports'      => array( 'title', 'editor', 'thumbnail', 'author', 'comments', 'excerpt' ),
				'rewrite'       => array( 'with_front' => false, 'slug' => 'portfolio' )
			)
		);
		register_taxonomy( 'portfolio_category', 'portfolio', array( 'hierarchical' => true, 'label' => __( 'Portfolio Categories', 'bt_plugin' ) ) );
	}
}
add_action( 'init', 'bt_create_portfolio' );

if ( ! function_exists( 'bt_rewrite_flush' ) ) {
	function bt_rewrite_flush() {
		// First, we "add" the custom post type via the above written function.
		// Note: "add" is written with quotes, as CPTs don't get added to the DB,
		// They are only referenced in the post_type column with a post entry, 
		// when you add a post of this CPT.
		bt_create_portfolio();

		// ATTENTION: This is *only* done during plugin activation hook in this example!
		// You should *NEVER EVER* do this on every page load!!
		flush_rewrite_rules();
	}
}
register_activation_hook( __FILE__, 'bt_rewrite_flush' );