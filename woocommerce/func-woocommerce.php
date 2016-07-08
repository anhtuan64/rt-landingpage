<?php

/**
 *
 * Woocommerce hook body class
 *
 * @param    
 * @return $classes
 *
 */
if ( ! function_exists( 'rt_woo_browser_body_class' ) ) {
	function rt_woo_browser_body_class( $classes ) {
		global $smof_data;

		if ( class_exists( 'WooCommerce' ) ) {

			// Add Class product thumb design in single product page
			if ( isset( $smof_data['woocommerce_product_thumb_design'] ) && ! empty( $smof_data['woocommerce_product_thumb_design'] ) ) {
				$classes[] = 'woo-thumb-design-' . $smof_data['woocommerce_product_thumb_design'];
			}

			// Add Class product thumb effect in shop page
			if ( isset( $smof_data['woocommerce_shop_thumb_hover_effect'] ) && ! empty( $smof_data['woocommerce_shop_thumb_hover_effect'] ) ) {
				$classes[] = 'woo-thumb-hover-effect-' . $smof_data['woocommerce_shop_thumb_hover_effect'];
			}
			if ( isset( $smof_data['woocommerce_shop_thumb_click_effect'] ) && ! empty( $smof_data['woocommerce_shop_thumb_click_effect'] ) ) {
				if ( in_array( $smof_data['woocommerce_shop_thumb_click_effect'], array( 'popup-image', 'popup-image-zoom', 'popup-gallery', 'popup-gallery-zoom' ) ) ) {
					$classes[] = 'woo-thumb-click-effect-popup woo-thumb-click-effect-' . $smof_data['woocommerce_shop_thumb_click_effect'];
				}
			}
		}

		return $classes;
	}

	add_filter( 'body_class', 'rt_woo_browser_body_class' );
}

/**
 *
 * Hook filter cart counter
 *
 * @param    
 * @return
 *
 */
if ( ! function_exists( 'woocommerce_header_add_to_cart_fragment' ) ) {
	add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );
	function woocommerce_header_add_to_cart_fragment( $fragments ) {
		ob_start();
		?>
		<div class="rt-cart-counter">
			<a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>">
				<i class="fa fa-cart-plus" aria-hidden="true"></i>
				<span class="counter"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
				<span class="text-price">
					<span class="text"><?php _e( 'Cart', RT_LANGUAGE );?> <i class="fa fa-angle-down" aria-hidden="true"></i></span>
					<?php if ( WC()->cart->get_cart_contents_count() > 0 ) :?>
						<span class="total">( <?php echo WC()->cart->get_cart_total(); ?> )</span>
					<?php endif;?>
				</span>			
			</a>
		</div>
		<?php
		
		$fragments['a.cart-contents'] = ob_get_clean();
		
		return $fragments;
	}
}

// ------------------------------- Hook Functions ---------------------------------- //

/**
 *
 * Shop Page Hook Thumbnail
 *
 * @param    
 * @return
 *
 */
if ( ! function_exists( 'hook_woocommerce_shop_thumb_click_effect' ) ) {
	function hook_woocommerce_shop_thumb_click_effect() {
		global $post, $woocommerce, $smof_data;

		if ( isset( $smof_data['woocommerce_shop_thumb_click_effect'] ) && ! empty( $smof_data['woocommerce_shop_thumb_click_effect'] ) ) {
			if ( in_array( $smof_data['woocommerce_shop_thumb_click_effect'], array( 'popup-image', 'popup-image-zoom', 'popup-gallery', 'popup-gallery-zoom' ) ) ) {
				wp_enqueue_script( 'magnific-popup' );
				wp_enqueue_style( 'magnific-popup' );
				if ( in_array( $smof_data['woocommerce_shop_thumb_click_effect'], array( 'popup-gallery', 'popup-gallery-zoom' ) ) ) {
					wp_localize_script( 'rt-main', 'check_popup_gallery', 'true' );
				}
				if ( in_array( $smof_data['woocommerce_shop_thumb_click_effect'], array( 'popup-image-zoom', 'popup-gallery-zoom' ) ) ) {
					wp_localize_script( 'rt-main', 'check_popup_gallery_zoom', 'true' );
				}

				echo '</a>';
				echo '<a class="product-images popup-gallery" title="'. $post->post_title .'" href="'. wp_get_attachment_url( get_post_thumbnail_id($post->ID) ) .'">';
			}
		}
	} 
	add_action( 'woocommerce_before_shop_loop_item_title', 'hook_woocommerce_shop_thumb_click_effect', 10);
}

/**
 *
 * Shop Page Hook Fillter by Category
 *
 * @param    
 * @return
 *
 */
if ( ! function_exists( 'hook_woocommerce_shop_filter' ) ) {
	function hook_woocommerce_shop_filter() {
		global $post, $woocommerce, $smof_data;

		if ( $smof_data['woocommerce_shop_filter_display'] ) {
			// $pro_cats 				= $_GET['pro-cat'];
			$search_query 			= get_search_query();


			$args = array(
				'parent'     				=> 0,
				'hide_empty'				=> 0,
			);
			$product_categories = get_terms( 'product_cat', $args );
			$count = count($product_categories);
			if ( $count > 0 ) {
				echo '<div class="gform_wrapper rt-filter-categories">';
					echo '<form method="get" accept-charset="UTF-8">';
						echo '<input class="rt-filter-search" type="text" value="'. $search_query .'" name="s" placeholder="'. __( 'Seach...', RT_LANGUAGE ) .'" />';
						echo '<select class="category-parent" name="pro-cat[]">';
							echo '<option value="">'. __( 'Select Category', RT_LANGUAGE ) .'</option>';
							foreach ( $product_categories as $product_category ) {
								echo '<option value="'. $product_category->term_id .'">' . $product_category->name . '</option>';
							}
						echo '</select>';
						echo '<select class="category-parent" name="pro-cat[]">';
							echo '<option value="">'. __( 'Select Category', RT_LANGUAGE ) .'</option>';
						echo '</select>';
						echo '<select class="category-parent" name="pro-cat[]">';
							echo '<option value="">'. __( 'Select Category', RT_LANGUAGE ) .'</option>';
						echo '</select>';
						echo '<input type="submit" class="fusion-button button-default button-small rt-filter-submit" value="'. __( 'Search', RT_LANGUAGE ) .'">';
						echo '<div class="loading"><div></div></div>';
					echo '</form>';
				echo '</div>';
			}
		}
	}
	add_action( 'woocommerce_before_shop_loop', 'hook_woocommerce_shop_filter');
}

/**
 *
 * Shop Page Hook Shop Page query
 *
 * @param    
 * @return
 *
 */
if ( ! function_exists( 'hook_woocommerce_shop_query' ) ) {
	function hook_woocommerce_shop_query( $q ){
		global $smof_data;
		if ( $smof_data['woocommerce_shop_filter_display'] ) {
			$pro_cats 				= $_GET['pro-cat'];
			$search_query 			= get_search_query();

			if ( is_array( $pro_cats ) && count( $pro_cats ) > 0 ) {
				foreach ( $pro_cats as $key => $cat ) {
					if ( ! isset( $pro_cats[$key + 1] ) || empty( $pro_cats[$key + 1] ) ) {
						if ( isset( $cat ) && ! empty( $cat ) && is_numeric( $cat ) ) {
							$q->set( 'tax_query', array( array(
								'taxonomy' => 'product_cat',
								'field'    => 'term_id',
								'terms'    => array( $cat ),
							) ) );
						}
					}
				}
			}
			
			if ( isset( $search_query ) && ! empty( $search_query ) ) {
				$q->set( 's', $search_query );
			}
		}
	}
	add_action( 'woocommerce_product_query', 'hook_woocommerce_shop_query' );
}



// ------------------------------- Ajax Functions ---------------------------------- //
/**
 *
 * Load product categories child ajax
 *
 * @param    
 * @return
 *
 */
if ( ! function_exists( 'load_product_categories_child' ) ) {
	function load_product_categories_child() {	
		$parent 				= $_GET['parent'];
		if ( isset( $parent ) && ! empty( $parent ) ) {
			$args = array(
				'parent'     				=> $parent,
				'hide_empty'				=> 0,
			);
			$product_categories = get_terms( 'product_cat', $args );
			if ( count( $product_categories ) > 0 ) {
				// echo '<select class="category-parent">';
				foreach ( $product_categories as $product_category ) {
					echo '<option value="'. $product_category->term_id .'">' . $product_category->name . '</option>';
				}
				// echo '</select>';
			}
		}
		die();
		
	}
	add_action( 'wp_ajax_load_product_categories_child', 'load_product_categories_child' );
	add_action( 'wp_ajax_nopriv_load_product_categories_child', 'load_product_categories_child' );
}
