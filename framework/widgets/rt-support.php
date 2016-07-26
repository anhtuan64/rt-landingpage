<?php
/*-----------------------------------------------------------------------------------

	Widget Name: RT - Support Online

-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'rt_support_online' ) ) {
	add_action( 'widgets_init', 'rt_support_online' );
	function rt_support_online() {
		register_widget( 'Gtid_Support_Online' );
	}
}

class Gtid_Support_Online extends WP_Widget {
	function Gtid_Support_Online() {
		$widget_ops 		= array( 'classname' => 'support-online-widget', 'description' => __( 'Add nick yahoo, skype on website', RT_LANGUAGE ) );
		$control_ops 		= array( 'width' => 505, 'height' => 250, 'id_base' => 'support-online' );
		$this->WP_Widget( 'support-online', __('RT - Support Online', RT_LANGUAGE ), $widget_ops, $control_ops );
	}

	function widget($args, $instance) {
		extract($args);
		$instance = wp_parse_args( (array)$instance, array(
			'title' 				=> '',
			'support_style'			=> '',
			'number_supporter' 		=> 1,
			'tel' 					=> '',
			'hotline' 				=> '',
			'email' 				=> '',
		) );

		wp_enqueue_style( 'rt-support' );

		$before_widget = str_replace( 'class="', 'class="style-'. $instance['support_style'] .' ', $before_widget );

		echo $before_widget;
		if ( ! empty( $instance['title'] ) ) {
			echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title;
		}
			
		echo '<div class = "wrap">';
		$url = get_stylesheet_directory_uri();
		?>

		<div class="supporter-info">
			<?php for( $i = 1; $i <= $instance['number_supporter']; $i++ ) { ?>
				<div id="support-<?php echo $i; ?>" class="supporter">
					<div class="info">
						<?php if( ! empty( $instance['supporter_'.$i.'_name'] ) ) : ?><span class="name"><?php echo $instance['supporter_'.$i.'_name']; ?></span><?php endif; ?>
						<?php if( ! empty( $instance['supporter_'.$i.'_phone'] ) ) : ?><span class="phone"><?php echo $instance['supporter_'.$i.'_phone']; ?></span><?php endif; ?>
						<?php if( ! empty( $instance['supporter_'.$i.'_landline'] ) ) : ?><span class="phone"><?php echo $instance['supporter_'.$i.'_landline']; ?></span><?php endif; ?>
					</div>
					<div class="online">
						<?php if( ! empty( $instance['supporter_'.$i.'_yahoo'] ) ) : ?><p class="yahoo"><a href="<?php echo 'ymsgr:sendim?' . $instance['supporter_'.$i.'_yahoo']; ?>"><img src="<?php echo 'http://opi.yahoo.com/online?u='.$instance['supporter_'.$i.'_yahoo'].'&amp;m=g&amp;t='.$instance['supporter_'.$i.'_yahoo_status']; ?>" alt="<?php _e('Support Online',RT_LANGUAGE ); ?>" /></a></p><?php endif; ?>
						<?php if( ! empty( $instance['supporter_'.$i.'_skype'] ) ) : ?>
							<p class="skypeassets">
								<a href="<?php echo 'skype:'.$instance['supporter_'.$i.'_skype'].'?chat'; ?>">
									<img src="<?php echo $url.'/assets/images/icon-skype.png' ?>" style="border: none; width:auto; height: 24px;" width="100" height="24" alt="My status" />
								</a>
							</p>
						<?php endif; ?>
						<?php if( ! empty( $instance['supporter_'.$i.'_email'] ) ) : ?>
							<p class="skypeassets">
								<a href="<?php echo 'mailto:'.$instance['supporter_'.$i.'_email'].''; ?>">
									<?php echo $instance['supporter_'.$i.'_email'];?>
								</a>
							</p>
						<?php endif; ?>
					</div>
				</div>
			<?php } ?>
		</div>

		<?php
		echo '<div class="clear"></div>';
		echo '</div>';
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( ( array ) $instance, array(
			'title' 				=> '',
			'support_style'			=> '',
			'number_supporter' 		=> 1,
			'tel' 					=> '',
			'hotline' 				=> '',
			'email' 				=> '',
		) );
?>

		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title', RT_LANGUAGE ); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:95%;" /></p>

		<hr />

		<p><label for="<?php echo $this->get_field_id('support_style'); ?>"><?php _e('Support Style', RT_LANGUAGE ); ?>:</label>
			<select id="<?php echo $this->get_field_id('support_style'); ?>" name="<?php echo $this->get_field_name('support_style'); ?>">
				<option value="1" <?php selected( $instance['support_style'], '1' ); ?>><?php _e( 'Style 1', RT_LANGUAGE );?></option>
				<option value="2" <?php selected( $instance['support_style'], '2' ); ?>><?php _e( 'Style 2', RT_LANGUAGE );?></option>
			</select>
		</p>

		<p><label for="<?php echo $this->get_field_id('number_supporter'); ?>"><?php _e('Number of supporter', RT_LANGUAGE ); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id('number_supporter'); ?>" name="<?php echo $this->get_field_name('number_supporter'); ?>" value="<?php echo esc_attr( $instance['number_supporter'] ); ?>" style="width:20%;" />
		<input type="submit" name="savewidget" id="savewidget" class="button-primary widget-control-save" value="Lưu" />
		<img alt="" style="padding-bottom: 4px;" title="" class="ajax-feedback " src="<?php echo home_url('/'); ?>wp-admin/images/wpspin_light.gif"></p>

		<?php for($i = 1;$i<=$instance['number_supporter'];$i++){   ?>
			<div style="width: 47%; padding: 5px; margin: 5px 0; background: #eee; <?php echo $i % 2 ==0 ? 'float: right;' : 'float: left;'; ?>"  >
			<strong><?php _e( 'Information', RT_LANGUAGE ); echo $i; ?></strong>
			<p><label for="<?php echo $this->get_field_id('supporter_'.$i.'_name'); ?>"><?php _e( 'Name', RT_LANGUAGE ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id('supporter_'.$i.'_name'); ?>" name="<?php echo $this->get_field_name('supporter_'.$i.'_name'); ?>" value="<?php echo esc_attr( $instance['supporter_'.$i.'_name'] ); ?>" style="width:95%;" /></p>

			<p><label for="<?php echo $this->get_field_id('supporter_'.$i.'_phone'); ?>"><?php _e( 'Phone number', RT_LANGUAGE ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id('supporter_'.$i.'_phone'); ?>" name="<?php echo $this->get_field_name('supporter_'.$i.'_phone'); ?>" value="<?php echo esc_attr( $instance['supporter_'.$i.'_phone'] ); ?>" style="width:95%;" /></p>

			<p><label for="<?php echo $this->get_field_id('supporter_'.$i.'_landline'); ?>"><?php _e( 'Landline', RT_LANGUAGE ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id('supporter_'.$i.'_landline'); ?>" name="<?php echo $this->get_field_name('supporter_'.$i.'_landline'); ?>" value="<?php echo esc_attr( $instance['supporter_'.$i.'_landline'] ); ?>" style="width:95%;" /></p>

			<p><label for="<?php echo $this->get_field_id('supporter_'.$i.'_yahoo'); ?>"><?php _e( 'Yahoo ID (don\'t have @yahoo.com)', RT_LANGUAGE ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id('supporter_'.$i.'_yahoo'); ?>" name="<?php echo $this->get_field_name('supporter_'.$i.'_yahoo'); ?>" value="<?php echo esc_attr( $instance['supporter_'.$i.'_yahoo'] ); ?>" style="width:95%;" /></p>

			<p><label for="<?php echo $this->get_field_id('supporter_'.$i.'_yahoo_status'); ?>"><?php _e( 'Yahoo Icon', RT_LANGUAGE ); ?>:</label>
			<select name="<?php echo $this->get_field_name('supporter_'.$i.'_yahoo_status'); ?>" id="<?php echo $this->get_field_id('supporter_'.$i.'_yahoo_status'); ?>">
				<?php  for($j = 1; $j < 23; $j++ ) : ?>
					<option value="<?php echo $j; ?>" <?php checked($j, $instance['supporter_'.$i.'_yahoo_status']); ?>><?php echo $j; ?></option>
				<?php endfor; ?>
			</select>
			</p>

			<p><label for="<?php echo $this->get_field_id('supporter_'.$i.'_skype'); ?>"><?php _e( 'Skype ID ', RT_LANGUAGE ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id('supporter_'.$i.'_skype'); ?>" name="<?php echo $this->get_field_name('supporter_'.$i.'_skype'); ?>" value="<?php echo esc_attr( $instance['supporter_'.$i.'_skype'] ); ?>" style="width:95%;" /></p>

			<p><label for="<?php echo $this->get_field_id('supporter_'.$i.'_email'); ?>"><?php _e( 'Email ', RT_LANGUAGE ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id('supporter_'.$i.'_email'); ?>" name="<?php echo $this->get_field_name('supporter_'.$i.'_email'); ?>" value="<?php echo esc_attr( $instance['supporter_'.$i.'_email'] ); ?>" style="width:95%;" /></p>
			</div>
		<?php } ?>
		<div class="clear"></div>

	<?php
	}
}
if ( ! is_admin() ) {
	if ( ! function_exists( 'add_skype_js' ) ) {
		function add_skype_js() {
			wp_enqueue_script( 'skype-js', 'http://www.skypeassets.com/i/scom/js/skype-uri.js', array('jquery'), '', false );
		}
		add_action( 'wp_enqueue_scripts', 'add_skype_js' );
	}
}
?>