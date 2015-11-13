<?php
/**
 * Callback Functions
 *
 * Used to determine whether an option setting is displayed or not. 
 * Called via the active_callback parameter of the add_control() function
 *
 * @package Neptune
 */

 
/**
 * Adds a callback function to retrieve wether post content is set to excerpt or not
 *
 * @param object $control / Instance of the Customizer Control 
 * @return bool
 */
function neptune_control_post_content_callback( $control ) {
	
	// Check if excerpt mode is selected
	if ( $control->manager->get_setting('neptune_theme_options[post_content]')->value() == 'excerpt' ) :
		return true;
	else :
		return false;
	endif;
	
}