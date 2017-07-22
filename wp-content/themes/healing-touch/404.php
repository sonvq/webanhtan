<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package SKT Healing Touch
 */

get_header(); ?>

<div id="content">
    <div class="site-aligner">
        <section class="site-main" id="sitemain">
 
                <h1 class="entry-title"><?php _e( '404 Not Found', 'healing-touch' ); ?></h1>
 
            <div class="page-content">
                <p class="text-404"><?php _e( 'Looks like you have taken a wrong turn..... Don\'t worry... it happens to the best of us.', 'healing-touch' ); ?></p>
               
            </div><!-- .page-content -->
        </section>
        <div class="clear"></div>
    </div>
</div>

<?php get_footer(); ?>