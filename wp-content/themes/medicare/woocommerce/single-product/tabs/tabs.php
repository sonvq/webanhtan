<?php
/**
 * Single Product tabs
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

global $post, $product;

$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );

if ( ! empty( $tabs ) ) { ?>

	<div class="btClear"></div>
	<div class="btTabs tabsHorizontal">
		<ul class="tabsHeader">
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<li class="<?php echo esc_attr( $key ); ?>_tab">
					<a href="#tab-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="tabPanes tabPanesTabs">
		<?php foreach ( $tabs as $key => $tab ) : ?>
			<div class="tabPane" id="tab-<?php echo esc_attr( $key ); ?>">
				<?php call_user_func( $tab['callback'], $key, $tab ); ?>
			</div>
		<?php endforeach; ?>
		</div>
	</div>

<?php } ?>

<div class="boldRow topSmallSpaced bottomSmallSpaced">
	<div class="product_meta rowItem col-sm-6 tagsRowItem btTextLeft">
		<?php do_action( 'woocommerce_product_meta_start' ); ?>
		<?php echo '<div class="btTags"><ul>' . $product->get_tags( '</li><li> ', '<li>', '</li>' ) . '</ul></div>'; ?>
		<?php do_action( 'woocommerce_product_meta_end' ); ?>
	</div>
	<div class="rowItem col-sm-6 cellRight shareRowItem btTextRight">
		<div class="socialRow"><?php echo boldthemes_get_share_html( get_permalink(), 'shop', 'btIcoSmallSize' ); ?></div>
	</div>
</div>