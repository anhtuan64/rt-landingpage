<?php

add_action( 'init', 'rt_of_options', 30 );

if( ! function_exists( 'rt_of_options_array') )
{
	function rt_of_options_array()
	{
		$arr_product_cat = array(
			'' => __( 'Select Category', RT_LANGUAGE )
		);
		$product_categories = get_terms( 'product_cat', array() );
		if ( count( $product_categories ) > 0 ) {
			foreach ( $product_categories as $key => $obj ) {
				$arr_product_cat[$obj->slug] = $obj->name;
			}
		}

		// Get all pages
		$args = array(
			'sort_order' => 'asc',
			'sort_column' => 'post_title',
			'hierarchical' => 1,
			'exclude' => '',
			'include' => '',
			'meta_key' => '',
			'meta_value' => '',
			'authors' => '',
			'child_of' => 0,
			'parent' => -1,
			'exclude_tree' => '',
			'number' => '',
			'offset' => 0,
			'post_type' => 'page',
			'post_status' => 'publish'
		); 
		$arr_pages = array(
			'' => __("Select page", RT_LANGUAGE),
		);
		$pages = get_pages($args); 
		if ( count( $pages ) ) {
			foreach ( $pages as $key => $obj ) {
				$arr_pages[$obj->post_name] = $obj->post_title;
			}
		}

		$of_options = array();

		/*-----------------------------------------------------------------------------------*/
		/* The Options Array */
		/*-----------------------------------------------------------------------------------*/

		// Theme Setup
		$of_options[] = array( "name" => __("Theme Setup", RT_LANGUAGE),
			"id" => "theme_setup",
			"type" => "heading"
		);

		$of_options[] = array( "name" => __("Footer page", RT_LANGUAGE),
			"id" => "theme_setup_footer_page",
			"type" => "select",
			"options" => $arr_pages
		);

		$of_options[] = array( "name" => __("Enable admin theme", RT_LANGUAGE),
			"id" => "theme_setup_admin_theme",
			"std" => "default",
			"type" => "select",
			"options" => array(
				"default" => __("Default", RT_LANGUAGE),
				"admin-theme-1" => __("Admin Theme 1", RT_LANGUAGE),
			)
		);

		$of_options[] = array( "name" => __("Support Developer Level 1", RT_LANGUAGE),
			"id" => "theme_setup_developer_level_1",
			"std" => 1,
			"on" 		=> "Enable",
			"off" 		=> "Disable",
			"type" 		=> "switch"
		);

		$of_options[] = array( "name" => __("Enable Customer Support", RT_LANGUAGE),
			"desc" => __('Disable this feature If you are a developer', RT_LANGUAGE),
			"id" => "theme_setup_customer_support",
			"std" => 1,
			"on" 		=> "Enable",
			"off" 		=> "Disable",
			"type" 		=> "switch"
		);

		$of_options[] = array( "name" => __("Enable Top Header", RT_LANGUAGE),
			"id" => "theme_setup_top_header",
			"std" => 0,
			"on" 		=> "Enable",
			"off" 		=> "Disable",
			"type" 		=> "switch"
		);

		$of_options[] = array( "name" => __("Enable Statistic", RT_LANGUAGE),
			"desc" => __('Enabled Statistics to measure website traffic', RT_LANGUAGE),
			"id" => "theme_setup_statistics",
			"std" => 0,
			"on" 		=> "Enable",
			"off" 		=> "Disable",
			"type" 		=> "switch"
		);

		// Product Home Page Options
		$of_options[] = array( "name" => __("Product Home Page", RT_LANGUAGE),
			"id" => "product_home_page",
			"type" => "heading"
		);

		$of_options[] = array( "name" => __("Select Category", RT_LANGUAGE),
			"id" => "product_home_page_category",
			"std" => "default",
			"type" => "select",
			"options" => $arr_product_cat
		);

		$of_options[] = array( "name" => __("Product show at most", RT_LANGUAGE),
			"id" => "product_home_page_per_page",
			"std" => "12",
			"type" => "text"
		);

		$of_options[] = array( "name" => __("Columns", RT_LANGUAGE),
			"id" => "product_home_page_columns",
			"std" => "4",
			"type" => "text"
		);

		$of_options[] = array( "name" => __("Orderby", RT_LANGUAGE),
			"id" => "product_home_page_orderby",
			"type" => "select",
			"options" => array(
				"none" 				=> __("None", RT_LANGUAGE),
				"ID" 				=> __("ID", RT_LANGUAGE),
				"author" 			=> __("Author", RT_LANGUAGE),
				"title" 			=> __("Title", RT_LANGUAGE),
				"name" 				=> __("Name", RT_LANGUAGE),
				"type" 				=> __("Type", RT_LANGUAGE),
				"date" 				=> __("Date", RT_LANGUAGE),
				"modified" 			=> __("Modified", RT_LANGUAGE),
				"parent" 			=> __("Parent", RT_LANGUAGE),
				"rand" 				=> __("Rand", RT_LANGUAGE),
				"comment_count" 	=> __("Comment Count", RT_LANGUAGE),
			)
		);

		$of_options[] = array( "name" => __("Order", RT_LANGUAGE),
			"id" => "product_home_page_order",
			"type" => "select",
			"options" => array(
				"desc" 		=> __("DESC", RT_LANGUAGE),
				"asc" 		=> __("ASC", RT_LANGUAGE),
			)
		);

		// Custom Woocommerce
		$of_options[] = array( "name" => __("Custom Woocommerce", RT_LANGUAGE),
			"id" => "custom_woocommerce",
			"type" => "heading"
		);

		$of_options[] = array( "name" => __("Disable shopping cart", RT_LANGUAGE),
			"desc" => __('Disable shopping cart on site (support some theme in RT Library)', RT_LANGUAGE),
			"id" => "woocommerce_disable_cart",
			"std" => 0,
			"on" 		=> "Enable",
			"off" 		=> "Disable",
			"type" 		=> "switch"
		);

		$of_options[] = array( "name" => __("Enable Compare Products", RT_LANGUAGE),
			"desc" => __('Enable/Disable Compare products. Click <a target="_blank" href="'. get_admin_url() .'/admin.php?page=yith_woocompare_panel">Here</a> to setup feature.', RT_LANGUAGE),
			"id" => "woocommerce_compare_products",
			"std" => 0,
			"on" 		=> "Enable",
			"off" 		=> "Disable",
			"type" 		=> "switch"
		);

		$of_options[] = array( "name" => __("Enable Wishlist Products", RT_LANGUAGE),
			"desc" => __('Enable/Disable Wishlist products.', RT_LANGUAGE),
			"id" => "woocommerce_wishlist_products",
			"std" => 0,
			"on" 		=> "Enable",
			"off" 		=> "Disable",
			"type" 		=> "switch"
		);

		$of_options[] = array( "name" => __("Price Text", RT_LANGUAGE),
			"id" => "woocommerce_price_text",
			"std" => "Giá: ",
			"type" => "text"
		);

		$of_options[] = array( "name" => __("Shop Page", RT_LANGUAGE),
			"desc" => "",
			"id" => "shop_page_code",
			"std" => "<h3 style='margin: 0;'>" . __("Shop Page", RT_LANGUAGE) . "</h3>",
			"icon" => true,
			"type" => "info"
		);

		$of_options[] = array( "name" => __("Shop Page Filter Display?", RT_LANGUAGE),
			"desc" => __("Enable/Disable filter on shop page", RT_LANGUAGE),
			"id" => "woocommerce_shop_filter_display",
			"std" => 0,
			"on" 		=> "Enable",
			"off" 		=> "Disable",
			"type" 		=> "switch"
		);

		$of_options[] = array( "name" => __("Shop Page Thumbnail Hover Effect", RT_LANGUAGE),
			"desc" => __("Choose Thumbnail Hover Effect in Shop Page", RT_LANGUAGE),
			"id" => "woocommerce_shop_thumb_hover_effect",
			"std" => "default",
			"type" => "select",
			"options" => array(
				"default" => __("Default", RT_LANGUAGE),
				"hover-zoom" => __("Zoom Thumbnail", RT_LANGUAGE),
			)
		);

		$of_options[] = array( "name" => __("Shop Page Thumbnail Click Effect", RT_LANGUAGE),
			"desc" => __("Choose Thumbnail Click Effect in Shop Page", RT_LANGUAGE),
			"id" => "woocommerce_shop_thumb_click_effect",
			"std" => "default",
			"type" => "select",
			"options" => array(
				"default" => __("Default", RT_LANGUAGE),
				"popup-image" => __("Popup Image", RT_LANGUAGE),
				"popup-image-zoom" => __("Popup Image and Zoom", RT_LANGUAGE),
				"popup-gallery" => __("Popup Gallery", RT_LANGUAGE),
				"popup-gallery-zoom" => __("Popup Gallery and Zoom", RT_LANGUAGE),
			)
		);

		$of_options[] = array( "name" => __("Archive Page", RT_LANGUAGE),
			"desc" => "",
			"id" => "archive_page_code",
			"std" => "<h3 style='margin: 0;'>" . __("Archive Page", RT_LANGUAGE) . "</h3>",
			"icon" => true,
			"type" => "info"
		);

		$of_options[] = array( "name" => __("Orderby", RT_LANGUAGE),
			"id" => "woocommerce_archive_orderby",
			"type" => "select",
			"options" => array(
				"none" 				=> __("None", RT_LANGUAGE),
				"ID" 				=> __("ID", RT_LANGUAGE),
				"author" 			=> __("Author", RT_LANGUAGE),
				"title" 			=> __("Title", RT_LANGUAGE),
				"name" 				=> __("Name", RT_LANGUAGE),
				"type" 				=> __("Type", RT_LANGUAGE),
				"date" 				=> __("Date", RT_LANGUAGE),
				"modified" 			=> __("Modified", RT_LANGUAGE),
				"parent" 			=> __("Parent", RT_LANGUAGE),
				"rand" 				=> __("Rand", RT_LANGUAGE),
				"comment_count" 	=> __("Comment Count", RT_LANGUAGE),
			)
		);

		$of_options[] = array( "name" => __("Order", RT_LANGUAGE),
			"id" => "woocommerce_archive_order",
			"type" => "select",
			"options" => array(
				"desc" 		=> __("DESC", RT_LANGUAGE),
				"asc" 		=> __("ASC", RT_LANGUAGE),
			)
		);

		$of_options[] = array( "name" => __("Single Product", RT_LANGUAGE),
			"desc" => "",
			"id" => "single_product_code",
			"std" => "<h3 style='margin: 0;'>" . __("Single Product", RT_LANGUAGE) . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Enable Zoom Thumbnail", RT_LANGUAGE),
			"desc" => __('Enable to use zoom thumbnail effect. Click <a target="_blank" href="'. get_admin_url() .'/admin.php?page=yith_woocommerce_zoom-magnifier_panel">Here</a> to setup effect.', RT_LANGUAGE),
			"id" => "woocommerce_product_zoom_thumb",
			"std" => 0,
			"on" 		=> "Enable",
			"off" 		=> "Disable",
			"type" 		=> "switch"
		);

		$of_options[] = array( "name" => __("Single Product thumbnail gallery design", RT_LANGUAGE),
			"desc" => __("Choose if the thumbnail gallery on the single product page are vertical or horizontal.", RT_LANGUAGE),
			"id" => "woocommerce_product_thumb_design",
			"std" => "horizontal",
			"type" => "select",
			"options" => array(
				"horizontal" => __("Horizontal Design", RT_LANGUAGE),
				"vertical" => __("Vertical Design", RT_LANGUAGE)
			)
		);

		// Custom Blog
		// $of_options[] = array( "name" => __("Custom Blog", RT_LANGUAGE),
		// 	"id" => "heading_custom_blog",
		// 	"type" => "heading"
		// );

		// $of_options[] = array( "name" => __("General Blog Options", RT_LANGUAGE),
		// 	"desc" => "",
		// 	"id" => "custom_blog_single_post",
		// 	"std" => "<h3 style='margin: 0;'>" . __("General Blog Options", RT_LANGUAGE) . "</h3>",
		// 	"icon" => true,
		// 	"type" => "info"
		// );

		// $of_options[] = array( "name" => __("Blog Archive/Category Layout", RT_LANGUAGE),
		// 	"desc" => __("Select the layout for the blog archive/category pages.", RT_LANGUAGE),
		// 	"id" => "custom_blog_archive_layout",
		// 	"std" => "Large",
		// 	"type" => "select",
		// 	"options" => array(
		// 		'' => 'None',
		// 		'medium-1' => 'Medium 1',
		// 	)
		// );

		// Banner Siteout
		$of_options[] = array( "name" => __("Banner Left And Right", RT_LANGUAGE),
			"id" => "heading_banner_siteout",
			"type" => "heading"
		);

		$of_options[] = array( "name" => __("Enable Banner side out", RT_LANGUAGE),
			"id" => "theme_setup_banner_site_out_enable",
			"std" => 0,
			"on" 		=> "Enable",
			"off" 		=> "Disable",
			"type" 		=> "switch"
		);

		$of_options[] = array( "name" => __("Banner left and right width", RT_LANGUAGE),
			"desc" => __("In pixels or percentage, ex: 10px or 10%.", RT_LANGUAGE),
			"id" => "theme_setup_banner_width",
			"std" => "200px",
			"type" => "text"
		);

		$of_options[] = array( "name" => __("Banner left", RT_LANGUAGE),
			"id" => "theme_setup_banner_site_out_left",
			"std" => "",
			"mod" => "",
			"type" => "media"
		);

		$of_options[] = array( "name" => __("Banner right", RT_LANGUAGE),
			"id" => "theme_setup_banner_site_out_right",
			"std" => "",
			"mod" => "",
			"type" => "media"
		);

		$of_options[] = array( "name" => __("Banner Easing", RT_LANGUAGE),
			"desc" => __("Effect of banner left and right", RT_LANGUAGE),
			"id" => "theme_setup_banner_site_out_easing",
			"std" => "Large",
			"type" => "select",
			"options" => array(
				'linear' => 'Linear',
				'swing' => 'Swing',
			)
		);

		$of_options[] = array( "name" => __("Banner cssTransition", RT_LANGUAGE),
			"id" => "theme_setup_banner_site_out_csstransition",
			"std" => 0,
			"on" 		=> "Enable",
			"off" 		=> "Disable",
			"type" 		=> "switch"
		);

		

		return $of_options;
	}
}

if ( ! function_exists( 'rt_of_options' ) )
{
	function rt_of_options()
	{
		global $of_options;

		foreach ( $of_options as $key => $option ) {
			if ( $option['id'] == 'woocommerce_product_box_design' ) { 
				$of_options[$key]['options'] = array(
					"classic" => "Classic",
					"classic-1" => "Classic 1",
					"classic-2" => "Classic 2",
					"classic-3" => "Classic 3",
					"clean" => "Clean",

				);
			}

			// Change value of Blog Options
			if ( $option['id'] == 'blog_archive_layout' ) {
				$of_options[$key]['options'] = array(
					'Large' => 'Large',
					'Medium' => 'Medium',
					'medium-1' => 'Medium 1',
					'Large Alternate' => 'Large Alternate',
					'Medium Alternate' => 'Medium Alternate',
					'Grid' => 'Grid',
					'Timeline' => 'Timeline',
					'1' => 'Custom style 1',
					'2' => 'Custom style 2',
					'3' => 'Custom style 3',
					'4' => 'Custom style 4',
					'5' => 'Custom style 5',
					'6' => 'Custom style 6',
					'7' => 'Custom style 7',
				);
			}

			// Set default font
			if ( $option['id'] == 'google_body' || $option['id'] == 'google_nav' ) {
				$of_options[$key]['std'] = 'None';
			}
			if ( $option['id'] == 'google_headings' || $option['id'] == 'google_footer_headings' || $option['id'] == 'google_button' ) {
				$of_options[$key]['std'] = 'Open Sans';
			}
			if ( $option['id'] == 'standard_body' || $option['id'] == 'standard_nav' || $option['id'] == 'standard_headings' || $option['id'] == 'standard_footer_headings' || $option['id'] == 'standard_button' ) {
				$of_options[$key]['std'] = 'Arial, Helvetica, sans-serif';
			}

			
		}

		$of_options = array_merge( $of_options, rt_of_options_array() );
		// End Avada Edit
	}//End function: of_options()
}//End chack if function exists: of_options()

