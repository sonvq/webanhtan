<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?> <?php boldthemes_theme_data(); ?>>
<head>
	
	<?php
	
	boldthemes_set_override();
	boldthemes_header_init();
	boldthemes_header_meta();

	wp_head();

	$body_style = '';
	
	if ( boldthemes_get_option( 'page_background' ) ) {
		$body_style = ' style="background-image:url(' . boldthemes_get_option( 'page_background' ) . ')"';
	}
	
	?>
	
</head>

<body <?php body_class( boldthemes_get_body_class() ); ?> data-autoplay="<?php echo intval( boldthemes_get_option( 'autoplay_interval' ) ); ?>" id="btBody" <?php echo wp_kses_post( $body_style ); ?>>

<?php echo boldthemes_preloader_html(); ?>

<div class="btPageWrap" id="top">
	
    <header class="mainHeader btClear">
		<?php if ( ! boldthemes_get_option( 'top_tools_in_menu' ) ) echo boldthemes_top_bar_html( 'top' ); ?>
        <div class="port">
			<div class="menuHolder btClear">
				<span class="btVerticalMenuTrigger">&nbsp;<?php echo boldthemes_get_icon_html( 'fa_f0c9', '#', '', 'btIcoSmallSize btIcoDefaultColor btIcoDefaultType' ); ?></span>
				<span class="btHorizontalMenuTrigger">&nbsp;<?php echo boldthemes_get_icon_html( 'fa_f0c9', '#', '', 'btIcoSmallSize btIcoDefaultColor btIcoDefaultType' ); ?></span>
				<div class="logo">
					<span>
						<?php boldthemes_logo( 'header' ); ?>
					</span>
				</div><!-- /logo -->
				<?php 
					if ( boldthemes_get_option( 'menu_type' ) == 'hLeftBelow' || boldthemes_get_option( 'menu_type' ) == 'hRightBelow' ) {
						echo boldthemes_top_bar_html( 'menu-half' );
					}
				?>

				<div class="menuPort">
						<?php 
							if ( boldthemes_get_option( 'top_tools_in_menu' ) ) {
								echo boldthemes_top_bar_html( 'menu' );
							} 
						?>
					<nav>
						<?php boldthemes_nav_menu(); ?>
					</nav>
				</div><!-- .menuPort -->
				
			</div><!-- /menuHolder -->
		</div><!-- /port -->
		
    </header><!-- /.mainHeader -->
	
	<div class="btContentWrap btClear">
		<?php if ( MedicareTheme::$boldthemes_page_for_header_id != '' && ! is_search() ) {
			$content = get_post( MedicareTheme::$boldthemes_page_for_header_id );
			$top_content = $content->post_content;
			if ( $top_content != '' ) {
				$top_content = do_shortcode( $top_content );
			}
			echo '<div class = "btBlogHeaderContent">' . $top_content . '</div>';
		} ?>
		<?php boldthemes_header_headline() ?>
		<div class="btContentHolder">
			<div class="btContent">	