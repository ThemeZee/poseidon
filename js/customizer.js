/**
 * Customizer Live Preview
 *
 * Reloads changes on Theme Customizer Preview asynchronously for better usability
 *
 * @package Poseidon
 */

( function( $ ) {

	/* Default WordPress Customizer settings */
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '#logo .site-title' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '#logo .site-description' ).text( to );
		} );
	} );

} )( jQuery );
