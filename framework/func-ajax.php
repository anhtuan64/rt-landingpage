<?php
//--------------------------------- Front-End ---------------------------------//






//--------------------------------- Back-End ---------------------------------//
/**
 *
 * Widget: custom post type slide - load all Taxonomy of Custom Post Type when custom post type selected
 *
 * @param    
 * @return
 *
 */
if ( ! function_exists( 'rt_custom_post_type_slide_custom_type' ) ) {
	function rt_custom_post_type_slide_custom_type() {
		$custom_type = $_GET['custom_type'];

		if ( ! empty( $custom_type ) ) {
			$taxonomies = get_object_taxonomies( $custom_type, 'objects' );	
			echo '<option value="default">'. __( 'Default', RT_LANGUAGE ) .'</option>';
			if ( count( $taxonomies ) ) {
				foreach ( $taxonomies as $key => $obj ) {
					echo '<option value="'. $key .'">'. $obj->labels->name .'</option>';
				}
			}	
		}
		die();
	}
	add_action('wp_ajax_rt_custom_post_type_slide_custom_type', 'rt_custom_post_type_slide_custom_type');
	add_action('wp_ajax_nopriv_rt_custom_post_type_slide_custom_type', 'rt_custom_post_type_slide_custom_type');
}

/**
 *
 * Widget: custom post type slide - load all category of taxonomy when taxonomy selected
 *
 * @param    
 * @return
 *
 */
if ( ! function_exists( 'rt_custom_post_type_slide_taxonomy' ) ) {
	function rt_custom_post_type_slide_taxonomy() {
		$taxonomy = $_GET['taxonomy'];

		if ( ! empty( $taxonomy ) ) {
			$categories = get_terms( $taxonomy );	
			echo '<option value="all">'. __( 'All', RT_LANGUAGE ) .'</option>';
			if ( count( $categories ) ) {
				foreach ( $categories as $key => $obj ) {
					echo '<option value="'. $obj->term_id .'">'. $obj->name .'</option>';			
				}
			}	
		}
		die();
	}
	add_action('wp_ajax_rt_custom_post_type_slide_taxonomy', 'rt_custom_post_type_slide_taxonomy');
	add_action('wp_ajax_nopriv_rt_custom_post_type_slide_taxonomy', 'rt_custom_post_type_slide_taxonomy');
}