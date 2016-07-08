<?php
/**
 * All the main shortcode functions.
 *
 * @since  1.0
 * @author KingKongThemes
 * @link   http://www.kingkongthemes.com
 */

if ( ! function_exists( 'rt_refresh_mce' ) ) {
	function rt_refresh_mce( $ver ) {
		$ver += 3;
		return $ver;
	}
}
// init process for button control
add_filter( 'tiny_mce_version', 'rt_refresh_mce' );


if ( ! function_exists( 'rt_pre_add_shortcode_buttons' ) ) {
	function rt_pre_add_shortcode_buttons() {
		// Don't bother doing this stuff if the current user lacks permissions
		if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) )
			return;

		// Add only in Rich Editor mode
		if ( get_user_option( 'rich_editing' ) == 'true' ) {
			add_filter( 'mce_external_plugins', 'rt_pre_add_shortcodes_tinymce_plugin' );
			add_filter( 'mce_buttons', 'rt_pre_register_shortcode_buttons' );
		}
	}
	
	add_action( 'init', 'rt_pre_add_shortcode_buttons' );
}

if ( ! function_exists( 'rt_pre_register_shortcode_buttons' ) ) {
	function rt_pre_register_shortcode_buttons( $buttons ) {
		array_push( $buttons, 'rt_pre_shortcodes_button' );
		return $buttons;
	}
}

// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
if ( ! function_exists( 'rt_pre_add_shortcodes_tinymce_plugin' ) ) {
	function rt_pre_add_shortcodes_tinymce_plugin( $plugin_array ) {
		$plugin_array['rt_pre_shortcodes_button'] = RT_THEME_URL . '/mce/js/mce.js';
		return $plugin_array;
	}
}
