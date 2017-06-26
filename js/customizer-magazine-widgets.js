/**
 * Magazine Widget Area Control
 *
 * Adds extra class if Magazine Sections are added to Magazine widget area.
 *
 * @package Poseidon
 */

( function( wp, $ ) {

 	if ( ! wp || ! wp.customize ) { return; }

	$( document ).ready( function() {

		$( '.customize-control-sidebar_widgets' ).find( '.add-new-widget' ).on( 'click', function() {

            // Remove Magazine Homepage sections for default sidebars.
            $( 'body' ).removeClass( 'adding-magazine-section' );

			if ( $( this ).hasClass( 'add-new-magazine-section' ) && $( 'body' ).hasClass( 'adding-widget' ) ) {
				$( 'body' ).addClass( 'adding-magazine-section' );
			} else {
				$( 'body' ).removeClass( 'adding-magazine-section' );
			}
		} );

	} );

} )( window.wp, jQuery );
