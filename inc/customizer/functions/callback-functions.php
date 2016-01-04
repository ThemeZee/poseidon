<?php
/**
 * Callback Functions
 *
 * Used to determine whether an option setting is displayed or not. 
 * Called via the active_callback parameter of the add_control() function
 *
 * @package Poseidon
 */

 
/**
 * Adds a callback function to retrieve wether post content is set to excerpt or not
 *
 * @param object $control / Instance of the Customizer Control 
 * @return bool
 */
function poseidon_control_post_content_callback( $control ) {
	
	// Check if excerpt mode is selected
	if ( $control->manager->get_setting('poseidon_theme_options[post_content]')->value() == 'excerpt' ) :
		return true;
	else :
		return false;
	endif;
	
}


/**
 * Adds a callback function to retrieve wether slider is activated or not
 *
 * @param object $control / Instance of the Customizer Control 
 * @return bool
 */
function poseidon_slider_activated_callback( $control ) {
	
	// Check if Slider is turned on
	if ( $control->manager->get_setting('poseidon_theme_options[slider_blog]')->value() == 1 ) :
		return true;
	elseif ( $control->manager->get_setting('poseidon_theme_options[slider_magazine]')->value() == 1 ) :
		return true;
	else :
		return false;
	endif;
	
}