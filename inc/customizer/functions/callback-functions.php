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
 * Adds a callback function to retrieve wether slider is activated or not
 *
 * @param object $control / Instance of the Customizer Control.
 * @return bool
 */
function poseidon_slider_activated_callback( $control ) {

	// Check if Slider is turned on.
	if ( true === $control->manager->get_setting( 'poseidon_theme_options[slider_blog]' )->value() ) :
		return true;
	elseif ( true === $control->manager->get_setting( 'poseidon_theme_options[slider_magazine]' )->value() ) :
		return true;
	else :
		return false;
	endif;

}
