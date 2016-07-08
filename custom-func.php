<?php 

/**
 *
 * Hook After Shop Loop Item Title
 *
 * @param    
 * @return  
 *
 */
if ( ! function_exists( 'rt_action_woocommerce_after_shop_loop_item_title' ) ) {
	function action_woocommerce_after_shop_loop_item_title() {
		global $post;
		if ( ! empty( $post->post_excerpt ) ) {
			echo '<div class="entry-desc">'. apply_filters( 'woocommerce_short_description', $post->post_excerpt ) .'</div>';
		}
	}
	add_action( 'woocommerce_after_shop_loop_item_title', 'action_woocommerce_after_shop_loop_item_title', 10, 2 );
}

/**
 *
 * Remove tab Attribute
 *
 * @param    
 * @return  
 *
 */
if ( ! function_exists( 'woo_remove_product_tabs' ) ) {
	add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
	function woo_remove_product_tabs( $tabs ) {

	unset( $tabs['additional_information'] ); // Remove the additional information tab

	return $tabs;

	}
}
/**
 *
 * add data Attribute 
 *
 * @param    
 * @return  
 *
 */
if ( ! function_exists( 'add_attribut_woocommerce' ) ) {
	function add_attribut_woocommerce() {
		global $product;
		$has_row    = false;
		$alt        = 1;
		$attributes = $product->get_attributes();
		$class		= '';
		if ( count( $attributes ) % 2 == 0 && wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) {
			$class = 'number-one';
		}elseif( count( $attributes ) % 2 == 0 && ( !wc_product_sku_enabled() || !$product->get_sku() || !$product->is_type( 'variable' ) ) ) {
			$class = 'number-two';
		}elseif ( count( $attributes ) % 2 != 0 && wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) {
			$class = 'number-two';
		}elseif ( count( $attributes ) == 0 && ( !wc_product_sku_enabled() || !$product->get_sku() || !$product->is_type( 'variable' ) ) ) {
			$class = 'number-zezo';
		}else {
			$class = 'number-one';
		}
		if ( $class != 'number-zezo' ) {
		echo "<ul class='attribute-single ". $class ."'>";
		if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : 
	?>	
			<li class="sku_wrapper">
				<span class="left"><?php _e( 'SKU:', 'woocommerce' ); ?></span>
				<span class="right" itemprop="sku">
					<?php echo ( $sku = $product->get_sku() ) ? $sku : __( 'N/A', 'woocommerce' ); ?>
				</span>
			</li>

	<?php 
		endif;
		$x =2;
	 	foreach ( $attributes as $attribute ) :
			if ( empty( $attribute['is_visible'] ) || ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) ) {
				continue;
			} else {
				$has_row = true;
			}
			?>
			<li>
				<span class="left"><?php echo wc_attribute_label( $attribute['name'] ) . ': '; ?></span>
				<span class="right"><?php
					if ( $attribute['is_taxonomy'] ) {

						$values = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) );
						echo strip_tags( apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values ) );

					} else {

						// Convert pipes to commas and display values
						$values = array_map( 'trim', explode( WC_DELIMITER, $attribute['value'] ) );
						echo strip_tags( apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values ) );

					}
				?></span>
			</li>
	<?php 
		$x++;
		endforeach;
		echo "</ul>";
		}
	}
	add_action('woocommerce_single_product_summary','add_attribut_woocommerce',11);
}
remove_action('woocommerce_single_product_summary','woocommerce_template_single_excerpt',20);
remove_action('woocommerce_single_product_summary','woocommerce_template_single_meta',40);

/**
 *
 * add cart single product 
 *
 * @param    
 * @return  
 *
 */
if ( ! function_exists( 'add_cart' ) ) {
	function add_cart() {
	?>
		<a class="cart-single" href="<?php echo WC_Cart::get_checkout_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>">
			<i class="fa fa-usd" aria-hidden="true"></i><span>Mua ngay</span>
		</a>

	<?php
	}
	add_action('woocommerce_after_add_to_cart_button','add_cart');
}
/**
 *
 * add like share widget single product
 *
 * @param    
 * @return  
 *
 */
if ( ! function_exists( 'add_like_share_widget' ) ) {
	function add_like_share_widget() {
	?>
		<div class="mangxh">
			<span><?php dd_fbshare_generate('Compact'); ?> </span>
			<span><?php dd_fblike_xfbml_generate('Like Button Count'); ?></span>
			<span><?php dd_google1_generate('Compact (24px)'); ?></span>
		</div>
		<div class="widget-single-product"> 
			<?php dynamic_sidebar( 'widget single product' ); ?>
		</div>
	<?php
	}
	add_action('woocommerce_single_product_summary','add_like_share_widget',51);
}
