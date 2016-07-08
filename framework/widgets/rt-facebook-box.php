<?php
/*-----------------------------------------------------------------------------------

	Widget Name: RT - Fanpage Facebook

-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'rt_fanpage_facebook' ) ) {
	add_action( 'widgets_init', 'rt_fanpage_facebook' );
	function rt_fanpage_facebook() {
		register_widget( 'Facebook_Fanpage' );
	}
}

class Facebook_Fanpage extends WP_Widget {

   	function __construct() {
		parent::__construct(
			'facebook_boxlike', // Base ID
			__( 'RT - Facebook Fanpage', RT_LANGUAGE ), // Name
			array( 'description' => __( 'Display fanpage facebook', RT_LANGUAGE ) ) // Args
		);
	}

	function widget( $args, $instance ) {

		extract($args);
		$page_url 		= $instance['page_url'];
		// width box
		if ( ! empty( $instance['width'] ) ) {
			$width = $instance['width'];
		}
		// height box
		if ( ! empty( $instance['height'] ) ) {
			$height = $instance['height'];
		} else {
			$height = '70';
		}
		$show_faces 	= isset( $instance['show_faces'] ) ? 'true' : 'false';
		$timeline 		= isset( $instance['timeline'] ) ? 'timeline' : ' ';
		$events 		= isset( $instance['events'] ) ? 'events' : ' ';
		$messages 		= isset( $instance['messages'] ) ? 'messages' : ' ';
		$hide_cover 	= isset( $instance['hide_cover'] ) ? 'true' : 'false';
		$small_header 	= isset( $instance['small_header'] ) ? 'true' : 'false';

		echo $before_widget;

		if ( ! empty( $instance['title'] ) ) {
			echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title;
		}

		if($page_url): ?>
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.6";
				fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
			</script>
			<div class="fb-page" 
				data-href = "<?php echo $page_url; ?>" 
				<?php if( ! empty( $timeline ) || ! empty( $events ) || ! empty( $messages ) ) {
					echo 'data-tabs="'.$timeline.','.$events.','.$messages.'"';
				} ?>
				data-width = "<?php echo $width; ?>" 
				data-height = "<?php echo $height; ?>" 
				data-show-facepile = "<?php echo $show_faces; ?>" 
				data-hide-cover = "<?php echo $hide_cover; ?>" 
				data-small-header = "<?php echo $small_header; ?>"
			>
			</div>
		<?php endif;

		echo $after_widget;
	}

	function form( $instance ) {
		$default = array(
            'title' 	=> '',
            'width' 	=> '180',
            'height'	=> '70' ,
        );
        $instance = wp_parse_args( (array) $instance, $default );

		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title', RT_LANGUAGE) ; ?>:</label>
			<input type="text" class="widefat" style="width: 275px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('page_url'); ?>"><?php _e( 'Link Fanpage', RT_LANGUAGE ); ?>:</label>
			<input type="text" class="widefat" style="width: 275px;" id="<?php echo $this->get_field_id('page_url'); ?>" name="<?php echo $this->get_field_name('page_url'); ?>" value="<?php echo $instance['page_url']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('width'); ?>"><?php _e( 'Width box ( min 180 and max 500 )', RT_LANGUAGE ); ?>:</label>
			<input type="text" class="widefat" style="width: 275px;" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo $instance['width']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('height'); ?>"><?php _e( 'Height box ( min 70 )', RT_LANGUAGE ); ?>:</label>
			<input type="text" class="widefat" style="width: 275px;" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" value="<?php echo $instance['height']; ?>" />
		</p>

		<p>
			<label><?php _e('Display Tab',RT_LANGUAGE ); ?>:</label>
		</p>

		<hr />

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['timeline'], 'on'); ?> id="<?php echo $this->get_field_id('timeline'); ?>" name="<?php echo $this->get_field_name('timeline'); ?>" />
			<label for="<?php echo $this->get_field_id('timeline'); ?>"><?php _e( 'Display tab timeline', RT_LANGUAGE ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['events'], 'on'); ?> id="<?php echo $this->get_field_id('events'); ?>" name="<?php echo $this->get_field_name('events'); ?>" />
			<label for="<?php echo $this->get_field_id('events'); ?>"><?php _e( 'Display tab event', RT_LANGUAGE ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['messages'], 'on'); ?> id="<?php echo $this->get_field_id('messages'); ?>" name="<?php echo $this->get_field_name('messages'); ?>" />
			<label for="<?php echo $this->get_field_id('messages'); ?>"><?php _e( 'Display tab send message to fanpage', RT_LANGUAGE ); ?></label>
		</p>
		<p>
			<label><?php _e( 'Other settings display' ,RT_LANGUAGE ); ?>:</label>
		</p>

		<hr />

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_faces'], 'on'); ?> id="<?php echo $this->get_field_id('show_faces'); ?>" name="<?php echo $this->get_field_name('show_faces'); ?>" />
			<label for="<?php echo $this->get_field_id('show_faces'); ?>"><?php _e( 'Display member like page', RT_LANGUAGE ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['hide_cover'], 'on'); ?> id="<?php echo $this->get_field_id('hide_cover'); ?>" name="<?php echo $this->get_field_name('hide_cover'); ?>" />
			<label for="<?php echo $this->get_field_id('hide_cover'); ?>"><?php _e( 'Hide image cover fanpage facebook', RT_LANGUAGE ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['small_header'], 'on'); ?> id="<?php echo $this->get_field_id('small_header'); ?>" name="<?php echo $this->get_field_name('small_header'); ?>" />
			<label for="<?php echo $this->get_field_id('small_header'); ?>"><?php _e( 'Use header small for box', RT_LANGUAGE ); ?></label>
		</p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}
}