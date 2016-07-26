<?php
/**
 * Shortcode RT Blog Carousel.
 *
 * @since  1.0
 * @author TuanNA
 * @link   http://ceotuanna.com
 */
class rt_rtblog_carousel_shortcode {

	private $alert_class;
	private $icon_class;

	public static $args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

		add_shortcode( 'rtblog_carousel', array( $this, 'render' ) );

	}

	/**
	 * Render the shortcode
	 * @param  array $args	 Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string		  HTML output
	 */
	function render( $atts, $content = '') {
		$html = '';
		extract( shortcode_atts( array(
			'custom_post_type'		=> 'post',
			'taxonomy' 				=> '',
			'category' 				=> '',
			'posts_per_page'		=> '5',
			// General
			'style'   				=> '1',
			'slide_type'   			=> 'horizontal',
			'posts_per_slide'		=> '1',
			'autoplay'				=> 'true',
			'margin'				=> '0',
			// Only vertical slide type
			'width'					=> '300',
			'height'				=> '250',
			// 
			'hide_category'			=> '1',
			'hide_description'		=> '1',
		), $atts ) );

		wp_enqueue_style( 'rt-rtblog-carousel' );

		$args = array(
			'post_type'  			=> 'post',
			'posts_per_page'		=> $posts_per_page,
		);

		if ( ! empty( $custom_post_type ) ) {
			$args['post_type'] = $custom_post_type;
		}
		if ( ( ! empty( $category ) && $category != 'all' ) && ! empty( $taxonomy ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'ID',
					'terms'    => $category,
				),
			);
		} elseif( ! empty( $category ) && $category != 'all' ) {
			// $category_arr = explode(",", $category, 1);
			if ( is_numeric( $category ) ) {
				$args['cat'] = $category;
			} else {
				$args['category_name'] = $category;
			}
		}

		$the_query = new WP_Query( $args ); //var_dump($the_query->posts);

		// The Loop
		if ( $the_query->have_posts() ) {

			// Get content of carousel with multi style
			$content_html = $this->rt_blog_style( $the_query, $atts );

			// Check horizontal or vertical
			if ( $slide_type == 'horizontal' ){
				wp_enqueue_style( 'owl-carousel' );
				wp_enqueue_style( 'owl-carousel-theme-default' );
				wp_enqueue_script( 'owl-carousel' );

				$html .= '<div class="style-'. $style .' '. $slide_type .' rt-shortcodes rt-blog-carousel-shortcode">';
				$html .= '<div class="owl-carousel owl-theme" data-items="'. $posts_per_slide .'" data-autoplay="'. $autoplay .'" data-margin="'. $margin .'" data-loop="true" data-center="false" data-nav="true"
							data-dots="true" data-autoheight="true" data-mobile="1" data-tablet="1" data-desktop="1">';
				$html .= $content_html;
				$html .= '</div>';
				$html .= '</div>';
			}
			else {

				wp_enqueue_style( 'rcarousel-master-rcarousel' );
				wp_enqueue_script( 'rcarousel-master-ui-core' );
				wp_enqueue_script( 'rcarousel-master-ui-widget' );
				wp_enqueue_script( 'rcarousel-master-ui-rcarousel' );

				$html .= '<div class="style-'. $style .' '. $slide_type .' rt-shortcodes rt-blog-carousel-shortcode rcarousel-master-parrent">';
				$html .= '<div class="rcarousel-master" data-items="'. $posts_per_slide .'" data-autoplay="'. $autoplay .'" data-margin="'. $margin .'" data-width="'. $width .'" data-height="'. $height .'" >';
				$html .= $content_html;
				$html .= '</div>';
				$html .= '<a href="#" id="ui-carousel-next"><i class="fa fa-angle-up"></i></a>
					<a href="#" id="ui-carousel-prev"><i class="fa fa-angle-down"></i></a>
					<div id="pages"></div>';
				$html .= '</div>';
			}
			
		}

		return $html;
	}

	/**
	 *
	 * Blog shortcode style 1
	 *
	 * @param  $the_query: Query get data; $atts: attribute
	 * @return $html: html of blog shortcode style 1
	 *
	 */
	function rt_blog_style ( $the_query, $atts ) {

		extract( shortcode_atts( array(
			'style'   						=> '1',
		), $atts ) );

		$i = 0;
		$html = '';
		
		while ( $the_query->have_posts() ) { $the_query->the_post(); $i++;
			// $post_class = array( 'element', 'hentry', 'post-item', 'owl-item' );
			$post_class = array( 'slide' );

			switch ( $style ) {
				case 'pro-1':
					$image_size = 'rt_thumb60x60';
					$html .= $this->rt_general_product_html( $post_class, $atts, $image_size );
					break;
				case 'blog-1':
					$image_size = 'rt_thumb210x145';
					$atts['hide_category'] = '0';
				default:
					$html .= $this->rt_general_post_html( $post_class, $atts, $image_size );
					break;
			}
		}
		return $html;
	}

	/**
	 *
	 * General post html
	 *
	 * @param  $post_class: class of post
	 * @return $html: html of post
	 *
	 */
	function rt_general_post_html ( $post_class = array(), $atts = array(), $image_size = 'rt_thumb300x200' ) {
		extract( shortcode_atts( array(
			'style'   						=> '1',
			'posts_per_page'				=> '5',
			'hide_thumb'					=> '1',
			'hide_category'					=> '1',
			'hide_description'				=> '1',
		), $atts ) );

		$html = '';
		$html .= '<article id="post-'. get_the_ID() .'" class="'. implode( ' ', get_post_class( $post_class ) ) .'"><div class="post-inner">';
		// Check display thumb of post
		if ( $hide_thumb == '1' && has_post_thumbnail() ) :
			$html .= '<div class="entry-thumb">';
			$html .= '<a href="'. get_permalink() .'" title="'. get_the_title() .'">' . get_the_post_thumbnail( get_the_ID(), $image_size ) . '</a>';
			$html .= '</div>';
		endif;
		$html .= '<div class="entry-content">';
			// Check display category
			if ( $hide_category == '1' ) {
				$categories = wp_get_post_categories( get_the_ID() );
				if ( count( $categories ) > 0 ) {
					$html .= '<div class="entry-cat">';
					foreach ( $categories as $key => $cat_id ) {
						$category = get_category( $cat_id );
						if ( $key == ( count( $categories ) - 1 ) ) {
							$html .= '<a href="'. get_term_link( $category ) .'" title="'. $category->name .'">'. $category->name .'</a>';	
						} else {
							$html .= '<a href="'. get_term_link( $category ) .'" title="'. $category->name .'">'. $category->name .'</a>, ';
						}
					}
					$html .= '</div>';
				}
			}
			$html .= '<h3 class="entry-title"><a href="'. get_permalink() .'" title="'. get_the_title() .'">'. get_the_title() .'</a></h3>';
			// Metadata
			$html .= '<div class="meta">';
				$html .= '<span class="date-time"><i class="fa fa-clock-o" aria-hidden="true"></i>'. get_the_date() .'</span>';
				$comments_count = wp_count_comments( get_the_ID() );
				$html .= '<span class="number-comment"><i class="fa fa-commenting-o" aria-hidden="true"></i>'. $comments_count->approved . ' ' . __( 'Comments', RT_LANGUAGE ) . '</span>';
			$html .= '</div>';
			// Check display description
			if ( $hide_description == '1' ) {
				$html .= '<div class="entry-description">'. get_the_excerpt() .'</div>';
			}
			$html .= '<p class="read-more"><a href="'. get_permalink() .'" title="'. get_the_title() .'">'. __( 'View More', RT_LANGUAGE ) .'</a></p>';
		$html .= '</div>';
		$html .= '</div></article>';
		return $html;
	}

	/**
	 *
	 * General post html
	 *
	 * @param  $post_class: class of post
	 * @return $html: html of post
	 *
	 */
	function rt_general_product_html ( $post_class = array(), $atts = array(), $image_size = 'rt_thumb300x200' ) {
		extract( shortcode_atts( array(
			'style'   						=> '1',
			'posts_per_page'				=> '5',
			'hide_thumb'					=> '1',
			'hide_category'					=> '1',
			'hide_description'				=> '1',
		), $atts ) );

		global $product;

		$html = '';
		$html .= '<article id="post-'. get_the_ID() .'" class="'. implode( ' ', get_post_class( $post_class ) ) .'"><div class="post-inner">';
		// Check display thumb of post
		if ( $hide_thumb == '1' && has_post_thumbnail() ) :
			$html .= '<div class="entry-thumb">';
			$html .= '<a href="'. get_permalink() .'" title="'. get_the_title() .'">' . get_the_post_thumbnail( get_the_ID(), $image_size ) . '</a>';
			$html .= '</div>';
		endif;
		$html .= '<div class="entry-content">';
			// Check display category
			if ( $hide_category == '1' ) {
				$categories = wp_get_post_categories( get_the_ID() );
				if ( count( $categories ) > 0 ) {
					$html .= '<div class="entry-cat">';
					foreach ( $categories as $key => $cat_id ) {
						$category = get_category( $cat_id );
						if ( $key == ( count( $categories ) - 1 ) ) {
							$html .= '<a href="'. get_term_link( $category ) .'" title="'. $category->name .'">'. $category->name .'</a>';	
						} else {
							$html .= '<a href="'. get_term_link( $category ) .'" title="'. $category->name .'">'. $category->name .'</a>, ';
						}
					}
					$html .= '</div>';
				}
			}
			$html .= '<h3 class="entry-title"><a href="'. get_permalink() .'" title="'. get_the_title() .'">'. get_the_title() .'</a></h3>';
			// Price
			$html .= '<div class="product-price">'. $product->get_price_html() .'</div>';
			// Check display description
			if ( $hide_description == '1' ) {
				$html .= '<div class="entry-description">'. get_the_excerpt() .'</div>';
			}
		$html .= '</div>';
		$html .= '</div></article>';
		return $html;
	}

}

new rt_rtblog_carousel_shortcode();
