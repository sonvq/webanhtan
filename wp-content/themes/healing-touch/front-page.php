<?php
/**
 * The template for displaying front page.
 *
 *
 * @package SKT Healing Touch
 */
get_header(); ?>

<div class="all-box" <?php if( get_theme_mod( 'hide_slider' ) != '') { ?> style="margin-bottom:0px !important; top:0px !important;"<?php } ?>>
<?php if( get_theme_mod( 'hide_boxes' ) == '') { ?>
  <div class="feature-box-main site-aligner">
    <?php for($f=1; $f<5; $f++) { ?>
    <?php if( get_theme_mod('page-setting'.$f)) { ?>
    <?php $queryvar = new WP_query('page_id='.get_theme_mod('page-setting'.$f,true)); ?>
    <?php while( $queryvar->have_posts() ) : $queryvar->the_post(); ?>
    <div class="feature-box <?php if($f%4==0){ ?>last<?php } ?>">
      <?php the_post_thumbnail(); ?>
      <div class="feature-title">
        <?php the_title(); ?>
      </div>
      <!-- feature-title -->
      <div class="feature-content"><?php echo healing_touch_content(18); ?></div>
      <a href="<?php the_permalink(); ?>" class="read-btn">
      <?php esc_html_e('Read More','healing-touch'); ?>
      </a> </div>
    <!-- feature-box -->
    <?php if($f%4==0) { ?>
    <div class="clear"></div>
    <?php } ?>
    <?php endwhile; ?>
    <?php wp_reset_query(); ?>
    <?php } else { ?>
    <div class="feature-box <?php if($f%4==0){ ?>last<?php } ?>"> <img class="iconset" src="<?php echo get_template_directory_uri(); ?>/images/icon<?php echo $f; ?>.png" />
      <div class="feature-title">
        <?php esc_html_e('Page Title','healing-touch'); ?>
        <?php echo $f; ?></div>
      <!-- feature-title -->
      <div class="feature-content">
        <?php esc_html_e('Here at medicenter we have individual doctor s lists. Click read more below to see services and current timetable for our doctors.','healing-touch'); ?>
      </div>
      <a href="#" class="read-btn">
      <?php esc_html_e('Read More','healing-touch'); ?>
      </a> </div>
    <!-- feature-box -->
    <?php if($f%4==0) { ?>
    <div class="clear"></div>
    <?php } ?>
    <?php } ?>
    <?php }  ?>
  </div>
  <?php } ?>
  <?php
    if ( 'posts' == get_option( 'show_on_front' ) ) {
    ?>
    <?php if(get_theme_mod( 'hide_slider' ) == '' & get_theme_mod( 'hide_boxes' ) != '') { ?><div class="space150"></div><?php } ?>  <?php if(get_theme_mod( 'hide_slider' ) != '' & get_theme_mod( 'hide_boxes' ) == '') { ?><div class="space40"></div><?php } ?>  <section class="latest-blog">
    <div class="site-aligner">
    <section class="site-main content-left" id="sitemain">
 		<div class="welcome_title">
        <?php esc_html_e('Latest News','healing-touch'); ?>
      </div>
      <div>
        <?php $k = 0; ?>
        <?php global $wp_query; ?>
        <?php while( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
        <?php $k++; ?>
        <div class="four_fifth <?php if($k%1==0){?>last_column<?php } ?>">
        
        <div class="blogbox-left">          <p><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
            <?php if( has_post_thumbnail() ) { ?>
            <?php the_post_thumbnail(); ?>
            <?php } else {  ?>
            <img src="<?php echo get_template_directory_uri(); ?>/images/img_404.png" />
            <?php } ?>
            </a> </p></div>
        <div class="blogbox-right"><div class="recent-post-title"><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
            </a> </div>
          <div class="recent-meta"><?php _e('By','healing-touch');?> <?php if (get_the_author_meta()) { ?><a href="<?php the_author_meta(); ?>"><?php the_author(); ?></a><?php } else { the_author(); } ?> <?php _e('On','healing-touch');?>  <?php echo get_the_date(); ?> |
            <?php comments_number(); ?>
          </div>
          <p><?php echo healing_touch_content(25); ?></p></div>
		 <div class="clear"></div>
          </div>
        <?php if($k%1==0){?>
        <div class="clear"></div>
        <?php } ?>
        <?php endwhile; ?>
      </div>
      <div class="clear"></div>
        </section>
        <div class="sidebar_right">
        <?php get_sidebar();?>
        </div><!-- sidebar_right -->
        <div class="clear"></div>
    </div>
  </section>
  <?php
	}
	else
	{
    ?>
  <?php if(get_theme_mod( 'hide_slider' ) == '' & get_theme_mod( 'hide_boxes' ) != '') { ?><div class="space150"></div><?php } ?>  <?php if(get_theme_mod( 'hide_slider' ) != '' & get_theme_mod( 'hide_boxes' ) == '') { ?><div class="space40"></div><?php } ?>
  <section class="welcome-box">
    <div class="site-aligner">
    <section class="site-main content-left" id="sitemain">
    <?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
      <div class="welcome_title">
        <?php the_title(); ?>
      </div>
      <div class="clear"></div>
      <div class="welcome-content">
	  <?php the_content(); ?>
      <?php
            //If comments are open or we have at least one comment, load up the comment template
            if ( comments_open() || '0' != get_comments_number() )
            comments_template();
      ?>
      </div>
      <?php endwhile; else : endif; ?>
      <div class="clear"></div><!-- blog-post -->
             </section>
        <div class="sidebar_right">
        <?php get_sidebar();?>
        </div><!-- sidebar_right -->
        <div class="clear"></div>
    </div>
  </section>
  <?php
	}
	?>
</div>
<!-- content -->
<div class="clear"></div>
<?php get_footer(); ?>