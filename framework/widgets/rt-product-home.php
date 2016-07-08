<?php
/*-----------------------------------------------------------------------------------

	Widget Name: RT - Product Home

-----------------------------------------------------------------------------------*/
	
if ( ! function_exists( 'rt_product_home' ) ){
	add_action( 'widgets_init', 'rt_product_home' );
	function rt_product_home() {
		register_widget( 'Gtid_Product_Home_Widget' );
	}
}

class Gtid_Product_Home_Widget extends WP_Widget {

	function Gtid_Product_Home_Widget() {
		$widget_ops 		= array( 'classname' => 'rt-product-home', 'description' => __( 'Select Taxonomy to display custom post type', RT_LANGUAGE ) );
		$control_ops 		= array( /*'width' => 505, 'height' => 250,*/ 'id_base' => 'product-home' );
		$this->WP_Widget( 'product-home', __( 'RT - Product Home', RT_LANGUAGE ), $widget_ops, $control_ops );
	}


	function widget($args, $instance) {
		extract($args);
		extract( wp_parse_args( (array)$instance, array(
			// 'title' 				=> '',
			'category'				=> '',
			'product_show' 			=> '12',
			'columns' 				=> '4',
			'orderby'				=> 'none',
			'order'   				=> 'desc',
			
		) ) );

		if ( ! empty( $category ) ) {
			echo do_shortcode('[product_category category="'. $category .'" per_page="'. $product_show .'" columns="'. $columns .'" orderby="'. $orderby .'" order="'. $order .'"]');
		}
	}

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	function form($instance) {
		$instance = wp_parse_args( ( array ) $instance, array(
			// 'title' 				=> '',
			'category'				=> '',
			'product_show' 			=> '12',
			'columns' 				=> '4',
			'orderby'				=> 'none',
			'order'   				=> 'desc',
		) );


		// $post_types = get_post_types( array( 'public'   => true ) );
		// $taxonomies = get_object_taxonomies( 'post', 'objects' );
		// $categories = get_terms( 'category' );

		$product_categories = get_terms( 'product_cat', array() );

		?>
		<p><label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Select Category', RT_LANGUAGE ); ?>:</label>
			<select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
				<option value="" <?php selected( $instance['category'], '' ); ?>><?php _e( 'Select Category', RT_LANGUAGE );?></option>
				<?php
				if ( count( $product_categories ) > 0 ) {
					foreach ( $product_categories as $key => $obj ) {
				?>
					<option value="<?php echo $obj->slug;?>" <?php selected( $instance['category'], $obj->slug ); ?>><?php echo $obj->name;?></option>
				<?php
					}
				}
				?>
			</select>
		</p>

		<p><label for="<?php echo $this->get_field_id('product_show'); ?>"><?php _e( 'Product show at most', RT_LANGUAGE ); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id('product_show'); ?>" name="<?php echo $this->get_field_name('product_show'); ?>" value="<?php echo esc_attr( $instance['product_show'] ); ?>" style="width:95%;" /></p>

		<p><label for="<?php echo $this->get_field_id('columns'); ?>"><?php _e('Columns', RT_LANGUAGE ); ?>:</label>
			<select id="<?php echo $this->get_field_id('columns'); ?>" name="<?php echo $this->get_field_name('columns'); ?>">
				<option value="1" <?php selected( $instance['columns'], '1' ); ?>><?php _e( '1', RT_LANGUAGE );?></option>
				<option value="2" <?php selected( $instance['columns'], '2' ); ?>><?php _e( '2', RT_LANGUAGE );?></option>
				<option value="3" <?php selected( $instance['columns'], '3' ); ?>><?php _e( '3', RT_LANGUAGE );?></option>
				<option value="4" <?php selected( $instance['columns'], '4' ); ?>><?php _e( '4', RT_LANGUAGE );?></option>
				<option value="5" <?php selected( $instance['columns'], '5' ); ?>><?php _e( '5', RT_LANGUAGE );?></option>
				<option value="6" <?php selected( $instance['columns'], '6' ); ?>><?php _e( '6', RT_LANGUAGE );?></option>
			</select>
		</p>

		<p><label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Orderby', RT_LANGUAGE ); ?>:</label>
			<select id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>">
				<option value="none" <?php selected( $instance['orderby'], 'none' ); ?>><?php _e( 'None', RT_LANGUAGE );?></option>
				<option value="ID" <?php selected( $instance['orderby'], 'ID' ); ?>><?php _e( 'ID', RT_LANGUAGE );?></option>
				<option value="author" <?php selected( $instance['orderby'], 'author' ); ?>><?php _e( 'Author', RT_LANGUAGE );?></option>
				<option value="title" <?php selected( $instance['orderby'], 'title' ); ?>><?php _e( 'Title', RT_LANGUAGE );?></option>
				<option value="name" <?php selected( $instance['orderby'], 'name' ); ?>><?php _e( 'Name', RT_LANGUAGE );?></option>
				<option value="type" <?php selected( $instance['orderby'], 'type' ); ?>><?php _e( 'Type', RT_LANGUAGE );?></option>
				<option value="date" <?php selected( $instance['orderby'], 'date' ); ?>><?php _e( 'Date', RT_LANGUAGE );?></option>
				<option value="modified" <?php selected( $instance['orderby'], 'modified' ); ?>><?php _e( 'Modified', RT_LANGUAGE );?></option>
				<option value="parent" <?php selected( $instance['orderby'], 'parent' ); ?>><?php _e( 'Parent', RT_LANGUAGE );?></option>
				<option value="rand" <?php selected( $instance['orderby'], 'rand' ); ?>><?php _e( 'Rand', RT_LANGUAGE );?></option>
				<option value="comment_count" <?php selected( $instance['orderby'], 'comment_count' ); ?>><?php _e( 'Comment Count', RT_LANGUAGE );?></option>
			</select>
		</p>

		<p><label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order', RT_LANGUAGE ); ?>:</label>
			<select id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
				<option value="desc" <?php selected( $instance['order'], 'desc' ); ?>><?php _e( 'DESC', RT_LANGUAGE );?></option>
				<option value="asc" <?php selected( $instance['order'], 'asc' ); ?>><?php _e( 'ASC', RT_LANGUAGE );?></option>
			</select>
		</p>

	<?php
	}

}