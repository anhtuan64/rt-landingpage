<?php
/**
 * Shortcode RT Blog.
 *
 * @since  1.0
 * @author TuanNA
 * @link   http://ceotuanna.com
 */
class rt_home_product_shortcode {

	public static $args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

		add_shortcode( 'home_product', array( $this, 'render' ) );

	}

	/**
	 * Render the shortcode
	 * @param  array $args	 Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string		  HTML output
	 */
	function render( $atts, $content = '') {
		$product_category 			= Avada()->settings->get( 'product_home_page_category' );
		$product_per_page 			= Avada()->settings->get( 'product_home_page_per_page' );
		$product_columns 			= Avada()->settings->get( 'product_home_page_columns' );
		$product_orderby 			= Avada()->settings->get( 'product_home_page_orderby' );
		$product_order 				= Avada()->settings->get( 'product_home_page_order' );

		return do_shortcode('[product_category category="'. $product_category .'" per_page="'. $product_per_page .'" columns="'. $product_columns .'" orderby="'. $product_orderby .'" order="'. $product_order .'"]');
	}

}
new rt_home_product_shortcode();

