<?php
/**
 * Custom functions that are not template related
 *
 * @package Poseidon
 */

 
if ( ! function_exists( 'poseidon_default_menu' ) ) :
/**
 * Display default page as navigation if no custom menu was set
 *
 */
function poseidon_default_menu() {
	
	echo '<ul id="menu-main-navigation" class="main-navigation-menu menu">'. wp_list_pages('title_li=&echo=0') .'</ul>';
	
}
endif;


/**
 * Adds custom theme layout and sticky navigation class to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function poseidon_body_classes( $classes ) {
	
	// Get Theme Options from Database
	$theme_options = poseidon_theme_options();
		
	// Switch Sidebar Layout to left
	if ( 'left-sidebar' == $theme_options['layout']  ) :
		$classes[] = 'sidebar-left';
	endif;

	return $classes;
}
add_filter( 'body_class', 'poseidon_body_classes' );


/**
 * Change excerpt length for default posts
 *
 * @param int $length Length of excerpt in number of words
 * @return int
 */
function poseidon_excerpt_length($length) {
	
	// Get Theme Options from Database
	$theme_options = poseidon_theme_options();

	// Return Excerpt Text
	if ( isset($theme_options['excerpt_length']) and $theme_options['excerpt_length'] >= 0 ) :
		return absint( $theme_options['excerpt_length'] );
	else :
		return 30; // number of words
	endif;
}
add_filter('excerpt_length', 'poseidon_excerpt_length');


/**
 * Function to change excerpt length for posts in category posts widgets
 *
 * @param int $length Length of excerpt in number of words
 * @return int
 */
function poseidon_category_posts_excerpt_length($length) {
    return 15;
}