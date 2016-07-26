<?php
/*-----------------------------------------------------------------------------------

	Widget Name: RT - Blog

-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'rt_blog' ) ) {
	add_action( 'widgets_init', 'rt_blog' );
	function rt_blog() {
		register_widget( 'Gtid_blog' );
	}
}

class Gtid_blog extends WP_Widget {
	function Gtid_blog() {
		$widget_ops 		= array( 'classname' => 'blog-widget', 'description' => __( 'Add Blog on website', RT_LANGUAGE ) );
		$control_ops 		= array( 'id_base' => 'blog' );
		$this->WP_Widget( 'blog', __('RT - Blog', RT_LANGUAGE ), $widget_ops, $control_ops );
	}

	function widget($args, $instance) {
		extract($args);
		$instance = wp_parse_args( (array)$instance, array(
			'title' 				=> '',
			'list_cat' 				=> '',
			'posts_per_page'		=> '5',
			'stype' 				=> '1',
			'orderby' 				=> 'date',
			'order' 				=> 'ASC',
		) );


		$args = array(
			'post_type'  			=> 'post',
			'posts_per_page'		=> $posts_per_page,
		);

		if ( count( $list_cat ) > 0 ) {
			$args['category__in'] = $list_cat;
		}

		$the_query = new WP_Query( $args );

		$i = 0;
		if ( $the_query->have_posts() ) {
			echo $before_widget;
			if ( ! empty( $instance['title'] ) ) {
				echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title;
			}
			echo '<div class="widget-blog-style-'. $instance['stype'] .'">';
			while ( $the_query->have_posts() ) { $the_query->the_post(); $i++; $html = '';
				switch ( $instance['stype'] ) {
					case '1':
						echo $this->get_blog_style_1_html( $i );
						break;
					case '2':
						echo $this->get_blog_style_2_html();
						break;
					default:
						echo $this->get_blog_style_1_html( $i );
						break;
				}
				
			}
			echo '</div>';
			echo $after_widget;
		}
		
	}

	function get_blog_style_1_html( $i = 0 ) {
		$image_size = 'rt_thumb300x200';
		$html .= '<article id="post-'. get_the_ID() .'" class="'. implode( ' ', get_post_class() ) .'"><div class="post-inner">';
		if ( $i == 1 ) {
			// Check display thumb of post
			if ( has_post_thumbnail() ) :
				$html .= '<div class="entry-thumb">';
				$html .= '<a href="'. get_permalink() .'" title="'. get_the_title() .'">' . get_the_post_thumbnail( get_the_ID(), $image_size ) . '</a>';
				$html .= '</div>';
			endif;
			$html .= '<div class="entry-content">';
				$html .= '<h3 class="entry-title"><a href="'. get_permalink() .'" title="'. get_the_title() .'">'. get_the_title() .'</a></h3>';
				$html .= '<div class="entry-description">'. get_the_excerpt() .'</div>';
			$html .= '</div>';
		} else {
			$html .= '<h3 class="entry-title"><a href="'. get_permalink() .'" title="'. get_the_title() .'">'. get_the_title() .'</a></h3>';
		}
		$html .= '</div></article>';
		return $html;
	}

	function get_blog_style_2_html() {
		$image_size = 'rt_thumb300x200';
		$html .= '<article id="post-'. get_the_ID() .'" class="'. implode( ' ', get_post_class() ) .'"><div class="post-inner">';
		if ( has_post_thumbnail() ) :
			$html .= '<div class="entry-thumb">';
			$html .= '<a href="'. get_permalink() .'" title="'. get_the_title() .'">' . get_the_post_thumbnail( get_the_ID(), $image_size ) . '</a>';
			$html .= '</div>';
		endif;
		$html .= '<div class="entry-content">';
			$html .= '<h3 class="entry-title"><a href="'. get_permalink() .'" title="'. get_the_title() .'">'. get_the_title() .'</a></h3>';
		$html .= '</div>';
		$html .= '</div></article>';
		return $html;
	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( ( array ) $instance, array(
			'title' 				=> '',
			'list_cat' 				=> '',
			'posts_per_page'		=> '5',
			'stype' 				=> '1',
			'orderby' 				=> 'date',
			'order' 				=> 'ASC',
		) );
		// var_dump($instance);
?>

		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title', RT_LANGUAGE ); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:95%;" /></p>

		<hr />

		<p><label for="<?php echo $this->get_field_id('list_cat'); ?>"><?php _e('Select Categories', RT_LANGUAGE ); ?>:</label>
			<select multiple id="<?php echo $this->get_field_id('list_cat'); ?>" name="<?php echo $this->get_field_name('list_cat'); ?>[]"> 
				<?php 
					$categories = get_categories(); 
					foreach ($categories as $category) {
						$data = $instance['list_cat'];
						if ( in_array( $category->term_id, $data ) ) {
							$option = '<option value="'. $category->term_id .'" selected="selected">';
						} else {
							$option = '<option value="'. $category->term_id .'">';
						}
						$option .= $category->cat_name;
						$option .= '</option>';
						echo $option;
					}
				?>
			</select>
		</p>

		<p><label for="<?php echo $this->get_field_id('posts_per_page'); ?>"><?php _e('Number post display', RT_LANGUAGE ); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id('posts_per_page'); ?>" name="<?php echo $this->get_field_name('posts_per_page'); ?>" value="<?php echo esc_attr( $instance['posts_per_page'] ); ?>" style="width:95%;" /></p>
		
		<p><label for="<?php echo $this->get_field_id('stype'); ?>"><?php _e('Blog stype', RT_LANGUAGE ); ?>:</label>
			<select id="<?php echo $this->get_field_id('stype'); ?>" name="<?php echo $this->get_field_name('stype'); ?>">
				<option value="1" <?php selected( $instance['stype'], '1' ); ?>><?php _e( 'Style 1', RT_LANGUAGE );?></option>
				<option value="2" <?php selected( $instance['stype'], '2' ); ?>><?php _e( 'Style 2', RT_LANGUAGE );?></option>
				<option value="3" <?php selected( $instance['stype'], '3' ); ?>><?php _e( 'Style 3', RT_LANGUAGE );?></option>
			</select>
		</p>

		<p><label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Blog Orderby', RT_LANGUAGE ); ?>:</label>
			<select id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>">
				<option value="date" <?php selected( $instance['orderby'], 'date' ); ?>><?php _e( 'Date', RT_LANGUAGE );?></option>
				<option value="ID" <?php selected( $instance['orderby'], 'ID' ); ?>><?php _e( 'ID', RT_LANGUAGE );?></option>
				<option value="title" <?php selected( $instance['orderby'], 'title' ); ?>><?php _e( 'Title', RT_LANGUAGE );?></option>
				<option value="name" <?php selected( $instance['orderby'], 'name' ); ?>><?php _e( 'Name', RT_LANGUAGE );?></option>
				<option value="rand" <?php selected( $instance['orderby'], 'rand' ); ?>><?php _e( 'Random', RT_LANGUAGE );?></option>
			</select>
		</p>

		<p><label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Blog Order', RT_LANGUAGE ); ?>:</label>
			<select id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
				<option value="ASC" <?php selected( $instance['order'], 'ASC' ); ?>><?php _e( 'ASC', RT_LANGUAGE );?></option>
				<option value="DESC" <?php selected( $instance['order'], 'DESC' ); ?>><?php _e( 'DESC', RT_LANGUAGE );?></option>
			</select>
		</p>

	<?php
	}
}