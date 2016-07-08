<?php
/*-----------------------------------------------------------------------------------

	Widget Name: RT - Google Badge

-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'rt_google_badge' ) ) {
	add_action( 'widgets_init', 'rt_google_badge' );
	function rt_google_badge() {
		register_widget( 'Gtid_google_badge' );
	}
}

class Gtid_google_badge extends WP_Widget {
	function Gtid_google_badge() {
		$widget_ops 		= array( 'classname' => 'google-badge-widget', 'description' => __( 'Add Google Badge on website', RT_LANGUAGE ) );
		$control_ops 		= array( 'width' => 505, 'height' => 250, 'id_base' => 'google-badge' );
		$this->WP_Widget( 'google-badge', __('RT - Google Badge', RT_LANGUAGE ), $widget_ops, $control_ops );
	}

	function widget($args, $instance) {
		extract($args);
		$instance = wp_parse_args( (array)$instance, array(
			'title' 				=> '',
			'id' 					=> '',
			'type' 					=> 'g-person',
			'layout' 				=> 'portrait',
			'theme' 				=> 'light',
		) );


		if ( ! empty( $instance['id'] ) ) {
			echo $before_widget;
			if ( ! empty( $instance['title'] ) ) {
				echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title;
			}

			// Check community option
			if ( $instance['type'] == 'g-community' ) $instance['id'] = 'communities/' . $instance['id'];
			
			echo '<script src="https://apis.google.com/js/platform.js" async defer></script>
				<div data-width="253" class="'. $instance['type'] .'" data-layout="'. $instance['layout'] .'" data-theme="'. $instance['theme'] .'" data-href="https://plus.google.com/'. $instance['id'] .'"></div>';
			
			echo $after_widget;
		}
		
	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( ( array ) $instance, array(
			'title' 				=> '',
			'id' 					=> '',
			'type' 					=> 'g-person',
			'layout' 				=> 'portrait',
			'theme' 				=> 'light',
		) );
?>

		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title', RT_LANGUAGE ); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:95%;" /></p>

		<hr />

		<p><label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('ID of Page, Profile or Community', RT_LANGUAGE ); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" value="<?php echo esc_attr( $instance['id'] ); ?>" style="width:95%;" /></p>
		
		<p><label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Google Badge type', RT_LANGUAGE ); ?>:</label>
			<select id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>">
				<option value="g-person" <?php selected( $instance['type'], 'g-person' ); ?>><?php _e( 'Profile', RT_LANGUAGE );?></option>
				<option value="g-page" <?php selected( $instance['type'], 'g-page' ); ?>><?php _e( 'Page', RT_LANGUAGE );?></option>
				<option value="g-community" <?php selected( $instance['type'], 'g-community' ); ?>><?php _e( 'Community', RT_LANGUAGE );?></option>
			</select>
		</p>

		<p><label for="<?php echo $this->get_field_id('layout'); ?>"><?php _e('Google Badge layout', RT_LANGUAGE ); ?>:</label>
			<select id="<?php echo $this->get_field_id('layout'); ?>" name="<?php echo $this->get_field_name('layout'); ?>">
				<option value="portrait" <?php selected( $instance['layout'], 'portrait' ); ?>><?php _e( 'Portrait', RT_LANGUAGE );?></option>
				<option value="landscape" <?php selected( $instance['layout'], 'landscape' ); ?>><?php _e( 'Landscape', RT_LANGUAGE );?></option>
			</select>
		</p>

		<p><label for="<?php echo $this->get_field_id('theme'); ?>"><?php _e('Google Badge style', RT_LANGUAGE ); ?>:</label>
			<select id="<?php echo $this->get_field_id('theme'); ?>" name="<?php echo $this->get_field_name('theme'); ?>">
				<option value="light" <?php selected( $instance['theme'], 'light' ); ?>><?php _e( 'Light', RT_LANGUAGE );?></option>
				<option value="dark" <?php selected( $instance['theme'], 'dark' ); ?>><?php _e( 'Dark', RT_LANGUAGE );?></option>
			</select>
		</p>

	<?php
	}
}