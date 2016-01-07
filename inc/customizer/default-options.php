<?php
/**
 * Returns theme options
 *
 * Uses sane defaults in case the user has not configured any theme options yet.
 *
 * @package Poseidon
 */


/**
 * Get saved user settings from database or theme defaults
 *
 * @return array
 */
function poseidon_theme_options() {
    
	// Merge Theme Options Array from Database with Default Options Array
	$theme_options = wp_parse_args( 
		
		// Get saved theme options from WP database
		get_option( 'poseidon_theme_options', array() ), 
		
		// Merge with Default Options if setting was not saved yet
		poseidon_default_options() 
		
	);

	// Return theme options
	return $theme_options;
	
}


/**
 * Returns the default settings of the theme
 *
 * @return array
 */
function poseidon_default_options() {

	$default_options = array(
		'custom_header_link'				=> '',
		'custom_header_hide'				=> false,
		'layout' 							=> 'right-sidebar',
		'sticky_header'						=> false,
		'post_layout_archives'				=> 'left',
		'post_layout_single' 				=> 'header',
		'latest_posts_title'				=> esc_html__( 'Latest Posts', 'poseidon' ),
		'post_content' 						=> 'excerpt',
		'excerpt_length' 					=> 20,
		'meta_date'							=> true,
		'meta_author'						=> true,
		'meta_category'						=> true,
		'meta_tags'							=> false,
		'post_navigation'					=> true,
		'slider_magazine' 					=> false,
		'slider_blog' 						=> false,
		'slider_category' 					=> 0,
		'slider_limit' 						=> 8,
		'slider_animation' 					=> 'slide',
		'slider_speed' 						=> 7000,
	);
	
	return $default_options;
}