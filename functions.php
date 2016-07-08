<?php

define( 'RT_THEME_URL', get_stylesheet_directory_uri() . '/' );
define( 'RT_LANGUAGE', 'Avada' );

/**
 *
 * Language Setting
 *
 * @param    
 * @return  
 *
 */
function rt_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( RT_LANGUAGE, $lang );
}
add_action( 'after_setup_theme', 'rt_lang_setup' );

/**
 *
 * Include files on theme
 *
 *
 */
require_once( 'mce/mce.php' );
require_once( 'woocommerce/func-woocommerce.php' );
require_once( 'framework/widgets/func-widget.php' );
require_once( 'framework/theme-options/func-options.php' );
require_once( 'custom-func.php' );
require_once( 'framework/func.php' );
if ( class_exists( 'Woocommerce' ) ) {
	require_once( 'framework/func-woo.php' );
}
require_once( 'framework/func-ajax.php' );

/**
 *
 * Add Thumb Size
 *
 *
 */
add_image_size( 'rt_thumb600x300', 600, 300, array( 'center', 'center' ) );
add_image_size( 'rt_thumb300x200', 300, 200, array( 'center', 'center' ) );
add_image_size( 'rt_thumb150x100', 150, 100, array( 'center', 'center' ) );
add_image_size( 'rt_thumb400x320', 400, 320, array( 'center', 'center' ) ); // For Blog Page style medium
add_image_size( 'rt_thumb400x150', 400, 150, array( 'center', 'center' ) ); // For Blog Page style medium
add_image_size( 'rt_thumb60x60', 60, 60, array( 'center', 'center' ) ); // For rt-blog-carousel shortcode
add_image_size( 'rt_thumb210x145', 210, 145, array( 'center', 'center' ) ); // for rt-blog-carousel sidebar widget
/**
 *
 * Avada child theme
 *
 * @param    
 * @return  
 *
 */
function theme_enqueue_styles() {
	global $smof_data;
	// Enqueue Avada Style
	wp_enqueue_style( 'avada-parent-stylesheet', get_template_directory_uri() . '/style.css' );

	/*----------- RCarousel Master -----------*/
	wp_register_style( 'rcarousel-master-rcarousel', RT_THEME_URL . 'assets/third-party/rcarousel-master/css/rcarousel.css' );
	wp_register_script( 'rcarousel-master-ui-core', RT_THEME_URL . 'assets/third-party/rcarousel-master/js/jquery.ui.core.js', array(), '1.0', true );
	wp_register_script( 'rcarousel-master-ui-widget', RT_THEME_URL . 'assets/third-party/rcarousel-master/js/jquery.ui.widget.js', array(), '1.0', true );
	wp_register_script( 'rcarousel-master-ui-rcarousel', RT_THEME_URL . 'assets/third-party/rcarousel-master/js/jquery.ui.rcarousel.js', array(), '1.0', true );

	/*----------- Owl Carousel -----------*/
	wp_register_style( 'owl-carousel', RT_THEME_URL . 'assets/css/third-party/owl-carousel/owl.carousel.min.css' );
	wp_register_style( 'owl-carousel-theme-default', RT_THEME_URL . 'assets/css/third-party/owl-carousel/owl.theme.default.min.css' );
	wp_register_script( 'owl-carousel', RT_THEME_URL . 'assets/js/third-party/owl-carousel/owl.carousel.min.js', array(), '1.0', true );

	/*-----------------------------------------------------------------*/
	wp_register_style( 'magnific-popup', RT_THEME_URL . 'assets/css/third-party/magnific-popup.css' );

	// Register shortcodes css
	wp_register_style( 'rt-rtblog', RT_THEME_URL . 'assets/css/shortcodes/rt-rtblog.css' );
	wp_register_style( 'rt-rtblog-carousel', RT_THEME_URL . 'assets/css/shortcodes/rt-rtblog-carousel.css' );

	// Enqueue RT Style
	wp_enqueue_style( 'rt-widgets', RT_THEME_URL . 'assets/css/widgets.css' );
	wp_enqueue_style( 'rt-main-style', RT_THEME_URL . 'assets/css/main-style.css' );
	wp_enqueue_style( 'rt-custom-style', RT_THEME_URL . 'assets/css/custom-style.css' );

	if ( Avada()->settings->get( 'responsive' ) ) {
		wp_enqueue_style( 'rt-responsive', RT_THEME_URL . 'assets/css/responsive.css' );
	}

	/*-----------------------------------------------------------------*/
	wp_register_script( 'magnific-popup', RT_THEME_URL . 'assets/js/third-party/jquery.magnific-popup.min.js', array(), '1.0', true );
	wp_enqueue_script( 'stickyfloat', RT_THEME_URL . 'assets/js/third-party/stickyfloat/stickyfloat.js', array(), '1.0', true );

	// Enqueue RT Script
	wp_enqueue_script( 'rt-main', RT_THEME_URL . 'assets/js/main.js', array(), '1.0', true );
	wp_localize_script( 'rt-main', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

	// Localize script
	$AvadaParams = array();
	if ( isset( $smof_data['offcanvas-swipe'] ) && $smof_data['offcanvas-swipe'] ) {
		$AvadaParams['offcanvas_turnon'] = $smof_data['offcanvas-turnon'];
	}
	if ( isset( $smof_data['woocommerce_product_thumb_design'] ) && ! empty( $smof_data['woocommerce_product_thumb_design'] ) ) {
		$AvadaParams['woocommerce_product_thumb_design'] = $smof_data['woocommerce_product_thumb_design'];
	}
	wp_localize_script( 'avada', 'AvadaParams', $AvadaParams );

}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 11 );	



/**
 *
 * Load style in admin page
 *
 * @param    
 * @return  
 *
 */
if ( ! function_exists( 'rt_load_admin_style' ) ) {
	function load_custom_wp_admin_style() {
		wp_enqueue_style( 'rt-login', RT_THEME_URL . 'admin/assets/css/login.css' );
		wp_enqueue_style( 'rt-admin-style-theme', RT_THEME_URL . 'admin/assets/css/admin-style.css' );
		wp_enqueue_style('thickbox');

		wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js', false, '1.4.4');

		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_script( 'rt-main', RT_THEME_URL . 'admin/assets/js/admin-main.js', array(), '1.0', true );
		$AvadaParams = array();
		$AvadaParams['ajaxurl'] = admin_url( 'admin-ajax.php' );
		wp_localize_script( 'rt-main', 'AvadaParams', $AvadaParams );
	}
	add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );
	add_action( 'login_enqueue_scripts', 'load_custom_wp_admin_style' );
}

/**
 *
 * Hook body_class
 *
 * @param    
 * @return  
 *
 */
if ( ! function_exists( 'rt_hook_body_class' ) ) {
	add_filter( 'body_class', 'remove_class' );
	function remove_class( $classes ) {
		global $smof_data;

		// Add Woocommerce style class
		$classes[] = 'woo-style-' . $smof_data[ 'woocommerce_product_box_design' ];

		// return the $classes array
		return $classes;
	}
}

/**
 *
 * Hook admin body_class
 *
 * @param    
 * @return  
 *
 */
if ( ! function_exists( 'rt_add_admin_theme_body_class' ) ) {
	add_filter('admin_body_class', 'rt_add_admin_theme_body_class');
	function rt_add_admin_theme_body_class( $classes ) {
		//global $current_user;
		$current_user = wp_get_current_user();

		$classes .= ' ' . $current_user->data->user_login;
		return $classes;
	}
}

/**
 *
 * Active Plugins
 *
 * @param    
 * @return  
 *
 */
if ( ! function_exists( 'rt_active_plugins' ) ) {
	function rt_active_plugins () {
		global $smof_data;

		activate_plugin ( 'fusion-core/fusion-core.php' );
		activate_plugin ( 'rt-customer-support/rt-customer-support.php' );

		if ( $smof_data['theme_setup_admin_theme'] == 'admin-theme-1' ) {
			activate_plugin ( 'slate-admin-theme/slate-admin-theme.php' );
		} else {
			deactivate_plugins( 'slate-admin-theme/slate-admin-theme.php' );
		}

		if ( $smof_data['woocommerce_compare_products'] ) {
			activate_plugin ( 'yith-woocommerce-compare/init.php' );
		} else {
			deactivate_plugins( 'yith-woocommerce-compare/init.php' );
		}

		if ( $smof_data['woocommerce_wishlist_products'] ) {
			activate_plugin ( 'yith-woocommerce-wishlist/init.php' );
		} else {
			deactivate_plugins( 'yith-woocommerce-wishlist/init.php' );
		}

		if ( $smof_data['woocommerce_product_zoom_thumb'] ) {
			activate_plugin ( 'yith-woocommerce-zoom-magnifier/init.php' );
		} else {
			deactivate_plugins( 'yith-woocommerce-zoom-magnifier/init.php' );
		}

		if ( $smof_data['theme_setup_statistics'] ) {
			activate_plugin ( 'wp-statistics/wp-statistics.php' );
		} else {
			deactivate_plugins( 'wp-statistics/wp-statistics.php' );
		}
	}
	add_action( 'admin_init', 'rt_active_plugins' );
}

/**
 *
 * Register Widgets
 *
 * @param    
 * @return  
 *
 */
if ( ! function_exists( 'rt_register_widget' ) ) {
	function rt_register_widget() {
		global $smof_data;
		if ( $smof_data['theme_setup_top_header'] ) {
			register_sidebar( array(
				'name'          => 'Top Header Left',
				'id'            => 'rt-top-header-left',
				'description'   => __( 'Sidebar of Left Top Header', RT_LANGUAGE ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<div class="heading"><h4 class="widget-title">',
				'after_title'   => '</h4></div>',
			) );

			register_sidebar( array(
				'name'          => 'Top Header Right',
				'id'            => 'rt-top-header-right',
				'description'   => __( 'Sidebar of Right Top Header', RT_LANGUAGE ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<div class="heading"><h4 class="widget-title">',
				'after_title'   => '</h4></div>',
			) );
		}
	}
	add_action( 'widgets_init', 'rt_register_widget' );
}

/**
 *
 * Return List Shortcodes
 *
 * @param    
 * @return $shortcodes: list shortcodes in site
 *
 */
if ( ! function_exists( 'rt_return_list_shortcode' ) ) {
	function rt_return_list_shortcode() {
		$shortcodes = 'rtblog, rtblog-carousel, rthome-product';
		return $shortcodes;
	}
}

/**
 *
 * Register Shortcodes
 *
 */
$shortcodes = rt_return_list_shortcode();
$shortcodes = explode( ",", $shortcodes );
$shortcodes = array_map( "trim", $shortcodes );
foreach ( $shortcodes as $shortcode ) {
	require_once( 'framework/shortcodes/rt-' . $shortcode . '.php' );
}

/*------------------------------ Security Theme -----------------------------------*/
define( 'DISALLOW_FILE_EDIT', true );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
add_filter( 'xmlrpc_enabled', '__return_false' );
if ( ! function_exists( 'rt_remove_version' ) ) {
	function rt_remove_version() {
		return '';
	}
	add_filter( 'the_generator', 'rt_remove_version' );
}
if ( ! function_exists( 'rt_wrong_login' ) ) {
	function rt_wrong_login() {
		return __( 'Wrong username or password.', RT_LANGUAGE );
	}
	add_filter( 'login_errors', 'rt_wrong_login' );
}

