/**
 * Magazine Widget Area Control
 *
 * Adds extra class if Magazine widgets are added to widget area.
 *
 * @package Poseidon
 */

( function( wp, $ ) {

 	if ( ! wp || ! wp.customize ) { return; }

	$( document ).ready( function() {

		$( '.customize-control-sidebar_widgets' ).find( '.add-new-widget' ).on( 'click', function() {

            // Remove Magazine Homepage sections for default sidebars.
            $( 'body' ).removeClass( 'adding-magazine-widget' );

			if ( $( this ).hasClass( 'add-new-magazine-widget' ) && $( 'body' ).hasClass( 'adding-widget' ) ) {
				$( 'body' ).addClass( 'adding-magazine-widget' );
			} else {
				$( 'body' ).removeClass( 'adding-magazine-widget' );
			}
		} );

	} );

} )( window.wp, jQuery );
