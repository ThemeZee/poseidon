<?php
/**
 * Returns theme options
 *
 * Uses sane defaults in case the user has not configured any theme options yet.
 *
 * @package Neptune
 */


/**
 * Get saved user settings from database or theme defaults
 *
 * @return array
 */
function neptune_theme_options() {
    
	// Merge Theme Options Array from Database with Default Options Array
	$theme_options = wp_parse_args( 
		
		// Get saved theme options from WP database
		get_option( 'neptune_theme_options', array() ), 
		
		// Merge with Default Options if setting was not saved yet
		neptune_default_options() 
		
	);

	// Return theme options
	return $theme_options;
	
}


/**
 * Returns the default settings of the theme
 *
 * @return array
 */
function neptune_default_options() {

	$default_options = array(
		'layout' 							=> 'right-sidebar',
		'post_content' 						=> 'excerpt',
		'excerpt_length' 					=> 30,
		'post_thumbnail_archives'			=> true,
		'post_thumbnail_single'				=> true,
		'meta_date'							=> true,
		'meta_author'						=> true,
		'meta_category'						=> true,
		'meta_comments'						=> false,
		'meta_tags'							=> true
	);
	
	return $default_options;
}