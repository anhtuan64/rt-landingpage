<?php
/*-----------------------------------------------------------------------------------

	Widget Name: RT - Custom Post Type Slider

-----------------------------------------------------------------------------------*/
	
if ( ! function_exists( 'rt_custom_post_type_slide' ) ){
	add_action( 'widgets_init', 'rt_custom_post_type_slide' );
	function rt_custom_post_type_slide() {
		register_widget( 'Gtid_Custom_Post_Type_Slide_Widget' );
	}
}

class Gtid_Custom_Post_Type_Slide_Widget extends WP_Widget {

	function Gtid_Custom_Post_Type_Slide_Widget() {
		$widget_ops 		= array( 'classname' => 'rt-custom-post-type-slide', 'description' => __( 'Select Taxonomy to display custom post type', RT_LANGUAGE ) );
		$control_ops 		= array( /*'width' => 505, 'height' => 250,*/ 'id_base' => 'custom-post-type-slide' );
		$this->WP_Widget( 'custom-post-type-slide', __( 'RT - Custom Post Type Slide', RT_LANGUAGE ), $widget_ops, $control_ops );
	}


	function widget($args, $instance) {
		extract($args);
		extract( wp_parse_args( (array)$instance, array(
			'title' 				=> '',
			
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
		) ) );

		echo $before_widget;
		if ( ! empty( $instance['title'] ) ) {
			echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title;
		}

		echo do_shortcode( '[rtblog_carousel custom_post_type="'. $custom_post_type .'" taxonomy="'. $taxonomy .'" category="'. $category .'" posts_per_page="'. $number_to_show .'"
			style="'. $style .'" slide_type="'. $slide_type .'" posts_per_slide="'. $posts_per_slide .'" autoplay="'. $autoplay .'" margin="'. $margin .'"
			width="'. $width .'" height="'. $height .'" hide_category="'. $hide_category .'" hide_description="'. $hide_description .'"][/rtblog_carousel]' );
		

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	function form($instance) {
		$instance = wp_parse_args( ( array ) $instance, array(
			'title' 				=> '',
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
		) );

		$post_types = get_post_types( array( 'public'   => true ) );
		$taxonomies = get_object_taxonomies( 'post', 'objects' );
		$categories = get_terms( 'category' );

		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title', RT_LANGUAGE ); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:95%;" /></p>

		<hr />
		<p><label for="<?php echo $this->get_field_id('custom_post_type'); ?>"><?php _e('Select custom post type', RT_LANGUAGE ); ?>:</label>
			<select id="<?php echo $this->get_field_id('custom_post_type'); ?>" name="<?php echo $this->get_field_name('custom_post_type'); ?>" onchange="custom_post_type_slide_custom_type(jQuery(this))">
				<?php
					if ( count( $post_types ) ) {
						foreach ( $post_types as $key => $value ) {
							echo '<option value="'. $key .'" '. selected( $instance['custom_post_type'], $key ) .'>'. $value .'</option>';
						}
					}
				?>
			</select>
		</p>

		<p><label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e('Select taxonomy', RT_LANGUAGE ); ?>:</label>
			<select id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>" onchange="custom_post_type_slide_taxonomy(jQuery(this))" class="rt-custom-post-type-slide-taxonomy">
				<?php
					if ( count( $taxonomies ) ) {
						foreach ( $taxonomies as $key => $obj ) {
							echo '<option value="'. $key .'" '. selected( $instance['taxonomy'], $key ) .'>'. $obj->labels->name .'</option>';
						}
					}
				?>
			</select>
		</p>

		<p><label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Select category', RT_LANGUAGE ); ?>:</label>
			<select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" class="rt-custom-post-type-slide-category">
				<option value="all" <?php selected( $instance['category'], 'all' ); ?>><?php _e( 'All', RT_LANGUAGE );?></option>
				<?php
					if ( count( $categories ) ) {
						foreach ( $categories as $key => $obj ) {
							echo '<option value="'. $obj->term_id .'" '. selected( $instance['category'], $obj->term_id ) .'>'. $obj->name .'</option>';			
						}
					}
				?>
			</select>
		</p>

		<p><label for="<?php echo $this->get_field_id('style'); ?>"><?php _e('Slide Stype', RT_LANGUAGE ); ?>:</label>
			<select id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>">
				<option value="blog-1" <?php selected( $instance['style'], 'blog-1' ); ?>><?php _e( 'Blog Template 1', RT_LANGUAGE );?></option>
				<option value="blog-2" <?php selected( $instance['style'], 'blog-2' ); ?>><?php _e( 'Blog Template 2', RT_LANGUAGE );?></option>
				<option value="pro-1" <?php selected( $instance['style'], 'pro-1' ); ?>><?php _e( 'Product Template 1', RT_LANGUAGE );?></option>
			</select>
		</p>
		
		<p><label for="<?php echo $this->get_field_id('posts_per_page'); ?>"><?php _e( 'Number To Show', RT_LANGUAGE ); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id('posts_per_page'); ?>" name="<?php echo $this->get_field_name('posts_per_page'); ?>" value="<?php echo esc_attr( $instance['posts_per_page'] ); ?>" style="width:95%;" /></p>

		<p><label for="<?php echo $this->get_field_id('slide_type'); ?>"><?php _e('Slide Type', RT_LANGUAGE ); ?>:</label>
			<select id="<?php echo $this->get_field_id('slide_type'); ?>" name="<?php echo $this->get_field_name('slide_type'); ?>">
				<option value="horizontal" <?php selected( $instance['slide_type'], 'horizontal' ); ?>><?php _e( 'Horizontal', RT_LANGUAGE );?></option>
				<option value="vertical" <?php selected( $instance['slide_type'], 'vertical' ); ?>><?php _e( 'Vertical', RT_LANGUAGE );?></option>
			</select>
		</p>

		<p><label for="<?php echo $this->get_field_id('posts_per_slide'); ?>"><?php _e( 'Number post / slide', RT_LANGUAGE ); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id('posts_per_slide'); ?>" name="<?php echo $this->get_field_name('posts_per_slide'); ?>" value="<?php echo esc_attr( $instance['posts_per_slide'] ); ?>" style="width:95%;" /></p>

		<p><label for="<?php echo $this->get_field_id('autoplay'); ?>"><?php _e('Auto Slide?', RT_LANGUAGE ); ?>:</label>
			<select id="<?php echo $this->get_field_id('autoplay'); ?>" name="<?php echo $this->get_field_name('autoplay'); ?>">
				<option value="true" <?php selected( $instance['autoplay'], 'true' ); ?>><?php _e( 'Auto', RT_LANGUAGE );?></option>
				<option value="false" <?php selected( $instance['autoplay'], 'false' ); ?>><?php _e( 'Not Auto', RT_LANGUAGE );?></option>
			</select>
		</p>

		<p><label for="<?php echo $this->get_field_id('margin'); ?>"><?php _e( 'Margin betwen 2 elements', RT_LANGUAGE ); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id('margin'); ?>" name="<?php echo $this->get_field_name('margin'); ?>" value="<?php echo esc_attr( $instance['margin'] ); ?>" style="width:95%;" /></p>
		
		<p><label for="<?php echo $this->get_field_id('width'); ?>"><?php _e( 'Width of 1 element (only support Vertical type)', RT_LANGUAGE ); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo esc_attr( $instance['width'] ); ?>" style="width:95%;" /></p>

		<p><label for="<?php echo $this->get_field_id('height'); ?>"><?php _e( 'Height of 1 element (only support Vertical type)', RT_LANGUAGE ); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" value="<?php echo esc_attr( $instance['height'] ); ?>" style="width:95%;" /></p>

		<p><label for="<?php echo $this->get_field_id('hide_category'); ?>"><?php _e('Disable Category?', RT_LANGUAGE ); ?>:</label>
			<select id="<?php echo $this->get_field_id('hide_category'); ?>" name="<?php echo $this->get_field_name('hide_category'); ?>">
				<option value="1" <?php selected( $instance['hide_category'], '1' ); ?>><?php _e( 'Enable', RT_LANGUAGE );?></option>
				<option value="0" <?php selected( $instance['hide_category'], '0' ); ?>><?php _e( 'Disable', RT_LANGUAGE );?></option>
			</select>
		</p>

		<p><label for="<?php echo $this->get_field_id('hide_description'); ?>"><?php _e('Disable Description?', RT_LANGUAGE ); ?>:</label>
			<select id="<?php echo $this->get_field_id('hide_description'); ?>" name="<?php echo $this->get_field_name('hide_description'); ?>">
				<option value="1" <?php selected( $instance['hide_description'], '1' ); ?>><?php _e( 'Enable', RT_LANGUAGE );?></option>
				<option value="0" <?php selected( $instance['hide_description'], '0' ); ?>><?php _e( 'Disable', RT_LANGUAGE );?></option>
			</select>
		</p>
	<?php
	}

}