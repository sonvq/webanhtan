<?php
/**
 * Single Product title
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );

$review_count = $product->get_review_count();
$rating_count = $product->get_rating_count();
$average      = $product->get_average_rating();

$subtitle = '';

if ( get_option( 'woocommerce_enable_review_rating' ) !== 'no' ) {

	if ( comments_open() ) {
		
		$subtitle = '<span class="btNoStarRating"></span>';	

	}

	if ( $rating_count > 0 ) { 

		$subtitle = $product->get_rating_html();

	}
	if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) {
		
		$sku = $product->get_sku() ? $product->get_sku() : esc_html__( 'N/A', 'woocommerce' );
		$subtitle .= '<span class = "btProductSKU">' . esc_html__( 'SKU:', 'woocommerce' ) . ' ' . $sku . '</span>'; 

	}
}

$supertitle = '<span class = "btArticleCategories">' . $product->get_categories( '', '<span class="btArticleCategory">', '</span>' ) . "</span>";

$dash = boldthemes_get_option( 'shop_use_dash' );
if ( $dash != '' ) {
	$dash = 'bottom';
}

echo boldthemes_get_heading_html( $supertitle, get_the_title(), $subtitle, 'large', $dash, 'btAlternateDash', '' ) ;

?>
