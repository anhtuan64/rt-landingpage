<?php
/*-----------------------------------------------------------------------------------

	Widget Name: RT - Image ADS

-----------------------------------------------------------------------------------*/
// add_action('admin_enqueue_scripts', 'my_admin_scripts2');
// // Thêm các script cần thiết cho bộ upload trong theme options
// function my_admin_scripts2() {
//         wp_enqueue_media();
//         wp_register_script('my-admin-js2', get_stylesheet_directory_uri() .'/lib/js/upload.js', array('jquery'));
//         wp_enqueue_script('my-admin-js2');

// }


if ( ! function_exists( 'rt_image_ads' ) ) {
	add_action( 'widgets_init', 'rt_image_ads' );
	function rt_image_ads() {
		register_widget( 'Gtid_image_ads' );
	}
}

class Gtid_image_ads extends WP_Widget {
	function Gtid_image_ads() {
		$widget_ops         = array( 'classname' => 'image-ads-widget', 'description' => __( 'Add Images Ads on website', RT_LANGUAGE ) );
		$control_ops        = array( 'width' => 600, 'height' => 250, 'id_base' => 'images-ads' );
		$this->WP_Widget( 'images-ads', __('RT - Images Ads', RT_LANGUAGE ), $widget_ops, $control_ops );
	}

	function widget($args, $instance) {
		extract($args);
		extract( wp_parse_args( (array)$instance, array(
			'title' 	=> '',
			'link' 		=> '',
			'img_num' 	=> 0,
			'type'		=> 'static',
			'width'		=> '300',
			'height'	=> '250',
		) ) );

		echo $before_widget;
		if ( ! empty( $instance['title'] ) ) {
			echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title;
		}

		// Set image list to $image_list
		$image_list = '';
		for( $i = 0; $i < $img_num; $i++ ) :
			if ( ! empty( $instance['img_src_'.$i] ) ) {
				$image_list .= '<aside class="slide">';
				$image_list .= ( ! empty( $instance['img_link_'.$i] ) ) ? '<a class="img-ads-image" href="'. $instance['img_link_'.$i] .'" title="">' : '<span class="img-ads-image">';
				$image_list .= '<img src="'. $instance['img_src_'.$i] .'" />';
				$image_list .= ( ! empty( $instance['img_title_'.$i] ) ) ? '<span class="img-ads-title">'. $instance['img_title_'.$i] .'</span>' : '';
				$image_list .= ( ! empty( $instance['img_link_'.$i] ) ) ? '</a>' : '</span>';

				$image_list .= '</aside>';
			}
		endfor;

		echo '<div class="widget-image-slider">';
		switch ( $type ) {
			case 'horizontal':
				wp_enqueue_style( 'owl-carousel' );
				wp_enqueue_style( 'owl-carousel-theme-default' );
				wp_enqueue_script( 'owl-carousel' );
				echo '<div class="owl-carousel owl-theme" data-items="1" data-autoplay="auto" data-margin="0" data-loop="true" data-center="false" data-nav="true"
							data-dots="false" data-autoheight="true" data-mobile="1" data-tablet="1" data-desktop="1">';
				echo $image_list;
				echo '</div>';
				break;
			case 'vertical':
				wp_enqueue_style( 'rcarousel-master-rcarousel' );
				wp_enqueue_script( 'rcarousel-master-ui-core' );
				wp_enqueue_script( 'rcarousel-master-ui-widget' );
				wp_enqueue_script( 'rcarousel-master-ui-rcarousel' );

				echo '<div class="rcarousel-master-parrent">';
				echo '<div class="rcarousel-master" data-items="1" data-autoplay="true" data-margin="0" data-width="'. $width .'" data-height="'. $height .'" >';
				echo $image_list;
				echo '</div>';
				echo '<a href="#" id="ui-carousel-next"><i class="fa fa-angle-up"></i></a>
					<a href="#" id="ui-carousel-prev"><i class="fa fa-angle-down"></i></a>
					<div id="pages"></div>';
				echo '</div>';
				break;
			default:
				echo $image_list;
				break;
		}
		echo '</div>';

		echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( ( array ) $instance, array(
			'title' 	=> '',
			'link' 		=> '',
			'img_num' 	=> 0,
			'type'		=> 'static',
			'width'		=> '300',
			'height'	=> '250',
		) );
?>

		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', RT_LANGUAGE); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:99%;" /></p>

		<p><label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Slide Stype', RT_LANGUAGE ); ?>:</label>
			<select id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>">
				<option value="static" <?php selected( $instance['type'], 'static' ); ?>><?php _e( 'Static', RT_LANGUAGE );?></option>
				<option value="horizontal" <?php selected( $instance['type'], 'horizontal' ); ?>><?php _e( 'Horizontal', RT_LANGUAGE );?></option>
				<option value="vertical" <?php selected( $instance['type'], 'vertical' ); ?>><?php _e( 'Vertical', RT_LANGUAGE );?></option>
			</select>
		</p>

		<div style="overflow: hidden;"><label for="<?php echo $this->get_field_id('img_num'); ?>"><?php _e('Number of image', RT_LANGUAGE); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id('img_num'); ?>" name="<?php echo $this->get_field_name('img_num'); ?>" value="<?php echo esc_attr( $instance['img_num'] ); ?>" size="2" />
			<div class="alignright">
				<img alt="" title="" class="ajax-feedback " src="<?php bloginfo('url'); ?>/wp-admin/images/wpspin_light.gif" style="visibility: hidden;" />
				<input type="submit" value="<?php _e('Save', RT_LANGUAGE); ?>" class="button-primary widget-control-save" id="savewidget" name="savewidget" />
			</div>
		</div>

		<?php for($i = 0; $i < $instance['img_num']; $i++) : ?>
			<div style="background: #F5F5F5; margin-top: 10px; margin-bottom: 10px; padding: 3%; width: 44%; float: left;">
				<p><label for="<?php echo $this->get_field_id('img_src_'.$i); ?>"><?php _e('Url of image ', RT_LANGUAGE); echo $i+1; ?>:</label>
					<input name="<?php echo $this->get_field_name('img_src_'.$i); ?>" id="<?php echo $this->get_field_id('img_src_'.$i); ?>" class="widefat" type="text" style="width:90%;" value="<?php echo esc_attr( $instance['img_src_'.$i] ); ?>" />
					<input class="upload_image_button" type="button" value="Upload Image" />
				</p>

				<p><label for="<?php echo $this->get_field_id('img_title_'.$i); ?>"><?php _e('Title of image ', RT_LANGUAGE); echo $i+1; ?>:</label>
					<input type="text" id="<?php echo $this->get_field_id('img_title_'.$i); ?>" name="<?php echo $this->get_field_name('img_title_'.$i); ?>" value="<?php echo esc_attr( $instance['img_title_'.$i] ); ?>" style="width:90%;" />
				</p>

				<p><label for="<?php echo $this->get_field_id('img_link_'.$i); ?>"><?php _e('Link of image ', RT_LANGUAGE); echo $i+1; ?>:</label>
					<input type="text" id="<?php echo $this->get_field_id('img_link_'.$i); ?>" name="<?php echo $this->get_field_name('img_link_'.$i); ?>" value="<?php echo esc_attr( $instance['img_link_'.$i] ); ?>" style="width:90%;" />
				</p>
			</div>
		<?php endfor; ?>

		<p><label for="<?php echo $this->get_field_id('width'); ?>"><?php _e( 'Width of slide (only support Vertical type)', RT_LANGUAGE ); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo esc_attr( $instance['width'] ); ?>" style="width:95%;" /></p>

		<p><label for="<?php echo $this->get_field_id('height'); ?>"><?php _e( 'Height of slide (only support Vertical type)', RT_LANGUAGE ); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" value="<?php echo esc_attr( $instance['height'] ); ?>" style="width:95%;" /></p>
		<div class="clear"></div>
	<?php
	}
}