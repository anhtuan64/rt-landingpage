<?php
global $smof_data;

/**
 *
 * Child Theme hook body class
 *
 * @param    
 * @return $classes
 *
 */
if ( ! function_exists( 'rt_browser_body_class' ) ) {
	function rt_browser_body_class( $classes ) {
		global $smof_data;

		// if ( is_archive() || is_author() ) {
		// 	if ( isset( $smof_data['custom_blog_archive_layout'] ) && ! empty( $smof_data['custom_blog_archive_layout'] ) ) {
		// 		$classes[] = 'blog-' . $smof_data['custom_blog_archive_layout'];
		// 	}
		// }

		if ( isset( $smof_data['woocommerce_disable_cart'] ) && ! empty( $smof_data['woocommerce_disable_cart'] ) && $smof_data['woocommerce_disable_cart'] == 1 ) {
			$classes[] = 'woocommerce-no-cart';
		}
		return $classes;
	}

	add_filter( 'body_class', 'rt_browser_body_class' );
}

/**
 *
 * Header: Hook top menu
 *
 * @param    
 * @return 
 *
 */
if ( ! function_exists( 'rt_hook_top_menu' ) ) {
	add_action( 'avada_header', 'rt_hook_top_menu' );
	function rt_hook_top_menu() {
		if ( is_active_sidebar( 'rt-top-header-left' ) || is_active_sidebar( 'rt-top-header-right' ) ) {
			echo '<div class="fusion-secondary-header rt-top-header"><div class="fusion-row">';
			if ( is_active_sidebar( 'rt-top-header-left' ) ) {
				echo '<div class="fusion-alignleft">';
				dynamic_sidebar( 'rt-top-header-left' );
				echo '</div>';
			}
			if ( is_active_sidebar( 'rt-top-header-right' ) ) {
				echo '<div class="fusion-alignright">';
				dynamic_sidebar( 'rt-top-header-right' );
				echo '</div>';
			}
			echo '</div></div>';
		}
	}
}

/**
 *
 * Header: Hook query
 *
 * @param    
 * @return 
 *
 */
if ( ! function_exists( 'rt_hook_query' ) ) {
	function rt_hook_query( $query ) {
		$orderby = Avada()->settings->get( 'woocommerce_archive_orderby' );
		$order = Avada()->settings->get( 'woocommerce_archive_order' );

		if ( is_tax( 'product_cat' ) ) {
			set_query_var( 'orderby', $orderby );
			set_query_var( 'order', $order );
		}
	}
	add_action( "pre_get_posts", "rt_hook_query" );
}

/**
 * Custom breadcrumbs.
 *
 * @since 1.0
 */
if ( ! function_exists( 'rt_breadcrumbs' ) ) {
	function rt_breadcrumbs(){
		$text['home']     = __( 'Home', RT_LANGUAGE ); // text for the 'Home' link
		$text['blog']     = __( 'Blog', RT_LANGUAGE ); // text for the 'Blog' link
		$text['category'] = __( 'Archive by Category "%s"', RT_LANGUAGE ); // text for a category page
		$text['tax'] 	  = __( '%s', RT_LANGUAGE ); // text for a taxonomy page
		$text['search']   = __( 'Search Results for "%s"', RT_LANGUAGE ); // text for a search results page
		$text['tag']      = __( 'Posts Tagged "%s"', RT_LANGUAGE ); // text for a tag page
		$text['author']   = __( 'Articles Posted by %s', RT_LANGUAGE ); // text for an author page
		$text['404']      = __( 'Error 404', RT_LANGUAGE ); // text for the 404 page
		$text['shop']     = __( 'Lincoln Store', RT_LANGUAGE ); // text for the 404 page

		$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
		$delimiter   = ''; // delimiter between crumbs
		$before      = '<li class="current">'; // tag before the current crumb
		$after       = '</li>'; // tag after the current crumb

		global $post;
		$homeLink   = home_url();
		$linkBefore = '<li typeof="v:Breadcrumb">';
		$linkAfter  = '</li>';
		$linkAttr   = ' rel="v:url" property="v:title"';
		$link       = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

		if ( is_front_page() ) {
			echo '<ul class="rt-breadcrumbs"><a href="' . esc_url( $homeLink ) . '">' . esc_html( $text['home'] ) . '</a></ul>';
		} elseif ( is_home() ) {
			echo '<ul class="rt-breadcrumbs"><a href="' . esc_url( $homeLink ) . '">' . esc_html( $text['blog'] ) . '</a></ul>';
		} else {

			echo '<ul class="rt-breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">' . sprintf( $link, esc_url( $homeLink ), esc_html( $text['home'] ) ) . $delimiter;
			
			if ( is_category() ) {
				$thisCat = get_category( get_query_var( 'cat' ), false );
				if ( $thisCat->parent != 0 ) {
					$cats = get_category_parents( $thisCat->parent, TRUE, $delimiter );
					$cats = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats );
					$cats = str_replace( '</a>', '</a>' . $linkAfter, $cats );
					echo ( $cats );
				}
				echo ( $before . sprintf( $text['category'], single_cat_title( '', false ) ) . $after );

			} elseif ( is_tax() ) {
				$thisCat = get_category( get_query_var( 'cat' ), false );
				if ( $thisCat ) {
					if ( ! empty( $thisCat->parent ) ) {
						$cats = get_category_parents( $thisCat->parent, TRUE, $delimiter );
						$cats = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats );
						$cats = str_replace( '</a>', '</a>' . $linkAfter, $cats);
						echo ( $cats );
					}
					echo ( $before . sprintf( $text['tax'], single_cat_title( '', false ) ) . $after );
				}
			}elseif ( is_search() ) {
				echo ( $before . sprintf( $text['search'], get_search_query() ) . $after );
			} elseif ( is_day() ) {
				echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;
				echo sprintf( $link, get_month_link( get_the_time( 'Y' ),get_the_time( 'm' ) ), get_the_time( 'F' ) ) . $delimiter;
				echo ( $before . get_the_time( 'd' ) . $after );
			} elseif ( is_month() ) {
				echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;
				echo ( $before . get_the_time( 'F' ) . $after );
			} elseif ( is_year() ) {
				echo ( $before . get_the_time( 'Y' ) . $after );
			} elseif ( function_exists( 'is_product' ) && is_product() ) {
				$id = get_the_ID();
				$product_cat = wp_get_post_terms( $id, 'product_cat' );
				$title = $slug = array();
				if ( $product_cat ) {
					foreach ( $product_cat as $category ) {
						$title[] = "{$category->name}";
						$slug[]  = "{$category->slug}";
					}
					echo '<li class="current"><a href="' . get_term_link( $slug[0], 'product_cat' ) . '">' . esc_html( $title[0] ) . '</a></li>';
				}
				
			} elseif ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
				echo '<li class="current">' . $text['shop'] . '</li>';
			} elseif ( is_single() && !is_attachment() ) {
				if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					printf( $link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name );
					if ( $showCurrent == 1 ) echo ( $delimiter . $before . get_the_title() . $after );
				} else {
					$cat = get_the_category(); $cat = $cat[0];
					$cats = get_category_parents( $cat, TRUE, $delimiter );
					if ( $showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats );
					$cats = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats);
					$cats = str_replace( '</a>', '</a>' . $linkAfter, $cats);
					echo ( $cats );
					if ( $showCurrent == 1 ) echo ( $before . get_the_title() . $after );
				}

			} elseif ( ! is_single() && !is_page() && get_post_type() != 'post' && ! is_404() ) {
				$post_type = get_post_type_object(get_post_type() );
				echo ( $before . $post_type->labels->singular_name . $after );

			} elseif ( is_attachment() ) {
				$parent = get_post( $post->post_parent );
				$cat = get_the_category( $parent->ID );
				$cat = $cat[0];
				$cats = get_category_parents( $cat, TRUE, $delimiter );
				$cats = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats );
				$cats = str_replace( '</a>', '</a>' . $linkAfter, $cats );
				echo ( $cats );
				printf( $link, get_permalink( $parent ), $parent->post_title );
				if ( $showCurrent == 1 ) echo ( $delimiter . $before . get_the_title() . $after );

			} elseif ( is_page() && !$post->post_parent ) {
				if ( $showCurrent == 1 ) echo ( $before . get_the_title() . $after );

			} elseif ( is_page() && $post->post_parent ) {
				$parent_id  = $post->post_parent;
				$breadcrumbs = array();
				while ( $parent_id) {
					$page = get_page( $parent_id );
					$breadcrumbs[] = sprintf( $link, get_permalink( $page->ID ), get_the_title( $page->ID ) );
					$parent_id  = $page->post_parent;
				}
				$breadcrumbs = array_reverse( $breadcrumbs );
				for ( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
					echo ( $breadcrumbs[$i] );
					if ( $i != count( $breadcrumbs)-1) echo ( $delimiter );
				}
				if ( $showCurrent == 1 ) echo ( $delimiter . $before . get_the_title() . $after );

			} elseif ( is_tag() ) {
				echo ( $before . sprintf( $text['tag'], single_tag_title( '', false ) ) . $after );

			} elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata( $author );
				echo ( $before . sprintf( $text['author'], $userdata->display_name ) . $after );

			} elseif ( is_404() ) {
				echo ( $before . $text['404'] . $after );
			} elseif ( is_post_type_archive() ) {
				echo '' . $current_before;
					post_type_archive_title();
				echo '' . $current_after;
			}

			if ( get_query_var( 'paged' ) ) {
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo '(';
				echo __( 'Page', RT_LANGUAGE ) . ' ' . get_query_var( 'paged' );
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
			}

			echo '</ul>';

		}
	}
}