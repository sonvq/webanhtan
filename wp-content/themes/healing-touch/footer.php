<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package SKT Healing Touch
 */
?>

<footer id="footer">
  <div class="site-aligner">
    <div class="widget-column">
      <div class="cols">
        <?php if ( '' !== get_theme_mod( 'contact_title' ) ){  ?>
        <h2>
		<?php echo esc_html( get_theme_mod( 'contact_title' , __('Skt Healing Touch' , 'healing-touch' ))); ?></h2>
        <?php } ?>
        <?php if ( '' !== get_theme_mod( 'contact_desc' ) ){  ?>
        <p><?php echo esc_html( get_theme_mod( 'contact_desc' , __('Lorem Ipsum is simply dummy text of the printing and typesetting industry.' , 'healing-touch' ))); ?></p>
        <?php } ?>
        <?php if ( '' !== get_theme_mod( 'contact_no' ) ){  ?>
        <div class="foot-label">
          <?php _e('Tel : ','healing-touch'); ?>
        </div>
        <div class="phone-content"><?php echo esc_attr( get_theme_mod('contact_no', __('+123 456 7890','healing-touch') ) )?> </div>
        <div class="clear"></div>
        <?php } ?>
        <?php if ( '' !== get_theme_mod( 'contact_fax' ) ){  ?>
        <div class="foot-label">
          <?php _e('Fax : ','healing-touch'); ?>
        </div>
        <div class="add-content"> <?php echo esc_attr( get_theme_mod('contact_fax', __('+9876543210','healing-touch') ) )?> </div>
        <div class="clear"></div>
        <?php } ?>
        <?php if ( '' !== get_theme_mod( 'contact_mail' ) ){  ?>
        <div class="foot-label">
          <?php _e('E-mail : ','healing-touch'); ?>
        </div>
        <div class="mail-content"><a href="mailto:<?php echo get_theme_mod('contact_mail',sanitize_email('contact@company.com'),'healing-touch'); ?>"><?php echo get_theme_mod('contact_mail',sanitize_email('contact@company.com'),'healing-touch'); ?></a></div>
        <!-- mail-content -->
        <div class="clear"></div>
        <?php } ?>
        <div class="clear"></div>
        <div class="social">
          <?php if ( get_theme_mod('fb_link') != "") { ?>
          <a target="_blank" href="<?php echo esc_url(get_theme_mod('fb_link','#facebook')); ?>" title="Facebook" >
          <div class="fb icon"></div>
          </a>
          <?php } ?>
          <?php if ( get_theme_mod('twitt_link') != "") { ?>
          <a target="_blank" href="<?php echo esc_url(get_theme_mod('twitt_link','#twitter')); ?>" title="Twitter" >
          <div class="twitt icon"></div>
          </a>
          <?php } ?>
          <?php if ( get_theme_mod('gplus_link') != "") { ?>
          <a target="_blank" href="<?php echo esc_url(get_theme_mod('gplus_link','#gplus')); ?>" title="Google Plus" >
          <div class="gplus icon"></div>
          </a>
          <?php } ?>
          <?php if ( get_theme_mod('linked_link') != "") { ?>
          <a target="_blank" href="<?php echo esc_url(get_theme_mod('linked_link','#linkedin')); ?>" title="Linkedin" >
          <div class="linkedin icon"></div>
          </a>
          <?php } ?>
        </div>
      </div>
      <!-- cols --> 
    </div>
    <!-- widget-column -->
    <div class="widget-column">
      <div class="cols">
        <h2>
          <?php _e('Menu','healing-touch'); ?>
        </h2>
        <?php wp_nav_menu(array('theme_location' => 'primary')); ?>
      </div>
      <!-- cols --> 
    </div>
    <!-- widget-column -->
    <div class="widget-column">
      <div class="cols">
        <h2>
          <?php _e('Recent Posts','healing-touch'); ?>
        </h2>
        <?php $args = array( 'posts_per_page' => 6, 'post__not_in' => get_option('sticky_posts'), 'orderby' => 'date', 'order' => 'desc' );
			query_posts( $args ); ?>
        <ul>
          <?php while ( have_posts() ) :  the_post(); ?>
          <li><a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
            </a></li>
          <?php endwhile; ?>
        </ul>
      </div>
      <!-- cols --> 
    </div>
    <!-- widget-column -->
    <div class="widget-column last">
      <?php if(!dynamic_sidebar('twitter-wid')) : ?>
      <div class="cols">
        <h2>
          <?php _e('Latest Tweets','healing-touch'); ?>
        </h2>
        <p>
          <?php _e('Use twitter widget for twitter feed.','healing-touch'); ?>
        </p>
      </div>
      <!-- cols -->
      <?php endif; ?>
    </div>
    <!-- widget-column -->
    <div class="clear"></div>
  </div>
  <!-- site-aligner --> 
</footer>
<div id="copyright">
  <div class="site-aligner">
    <div class="right">
      <?php if (function_exists('healing_touch_credit')) { healing_touch_credit(); } ?>
    </div>
    <div class="clear"></div>
  </div>
</div>
<!-- copyright -->
</div>
<!-- wrapper -->
<?php wp_footer(); ?>
</body></html>