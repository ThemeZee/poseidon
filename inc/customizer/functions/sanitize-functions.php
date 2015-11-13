<?php
/**
 * Sanitize Functions
 *
 * Used to validate the user input of the theme settings
 *
 * @package Neptune
 */


/**
 * Sanitize Checkbox Settings
 *
 * @param string $value / Value of the setting
 * @return bool
 */
function neptune_sanitize_checkbox( $value ) {

	if ( $value == 1) :
        return 1;
	else:
		return '';
	endif;
}


/**
 * Sanitize the layout sidebar value.
 *
 * @param string $value / Value of the setting
 * @return string
 */
function neptune_sanitize_layout( $value ) {

	if ( ! in_array( $value, array( 'left-sidebar', 'right-sidebar' ), true ) ) :
        $value = 'right-sidebar';
	endif;

    return $value;
}


/**
 * Sanitize the post length value.
 *
 * @param string $value / Value of the setting
 * @return string
 */
function neptune_sanitize_post_content( $value ) {

	if ( ! in_array( $value, array( 'index', 'excerpt' ), true ) ) :
        $value = 'excerpt';
	endif;

    return $value;
}