<?php

/**
 *
 * Woocommerce Init
 *
 * @param    
 * @return 
 *
 */
if ( ! function_exists( 'rt_woocommerce_init' ) ) {
	add_action('init', 'rt_woocommerce_init');
	function rt_woocommerce_init() {
		$woocommerce_product_box_design = Avada()->settings->get( 'woocommerce_product_box_design' );


		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );


		/* Remoe Action on woocommerce */
		// remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

		if ( $woocommerce_product_box_design == 'classic-3' ) {

			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 10 );

			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
			
		}
	}
}

/**
 *
 * Woocommerce hook billing
 *
 * @param    
 * @return 
 *
 */
if ( ! function_exists( 'rt_custom_override_checkout_fields' ) ) {
	add_filter( 'woocommerce_checkout_fields','rt_custom_override_checkout_fields' );
	function rt_custom_override_checkout_fields( $fields ) {
		unset($fields['billing']['billing_country']);
		unset($fields['billing']['billing_postcode']);
		unset($fields['billing']['billing_address_2']);
		unset($fields['billing']['billing_city']);
		unset($fields['billing']['billing_state']);
		return $fields;
	}
}

/**
 *
 * Woocommerce hook on sale
 *
 * @param    
 * @return 
 *
 */
if ( ! function_exists( 'rt_woocommerce_hook_onsale' ) ) {
	add_filter( 'woocommerce_sale_flash', 'rt_woocommerce_hook_onsale' );
	function rt_woocommerce_hook_onsale() {
		$price = get_post_meta( get_the_ID(), '_regular_price', true);
		$sale = get_post_meta( get_the_ID(), '_sale_price', true);
		$pecent = 100 - ( $sale * 100 / $price );
		$pecent = number_format( $pecent, 0 );
		return '<span class="onsale">-' . $pecent . '%</span>';
	}
}

/**
 *
 * Hook woocommerce meta
 *
 * @param    
 * @return 
 *
 */
if ( ! function_exists( 'rt_hook_woo_meta' ) ) {
	add_action( 'woocommerce_after_shop_loop_item_title', 'rt_hook_woo_meta', 10 );
	function rt_hook_woo_meta(){
		global $smof_data, $product;

		if ( $smof_data[ 'woocommerce_product_box_design' ] == 'classic-1' ) {
			$sku 		= $product->get_sku();
			$stock 		= $product->is_in_stock();

			// Display Sku of woocommerce
			if ( ! empty( $sku ) ) {
				echo '<span class="sku">' . 'Sku: ' . $sku . '</span>';
			}

			// Display stock status of woocommerce
			if ( $stock ) {
				echo '<span class="stock-status">'. __( 'In stock', RT_LANGUAGE ) .'</span>';
			}else {
				echo '<span class="stock-status">'. __( 'Sold Out', RT_LANGUAGE ) .'</span>';
			}
		}
	}
}

/**
 *
 * Hook woocommerce meta of classic-1 style
 *
 * @param    
 * @return 
 *
 */
// if ( ! function_exists( 'woocommerce_template_loop_price' ) ) {
// 	// add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
// 	function woocommerce_template_loop_price(){
// 		global $smof_data, $product;

// 		$price_text = ! empty( $smof_data['woocommerce_price_text'] ) ? $smof_data['woocommerce_price_text'] : __( 'Price: ', RT_LANGUAGE );
// 		echo '<span class="price"><span class="price-text">'. $price_text .'</span>' . $product->get_price_html() . '</span>';
// 	}
// }


