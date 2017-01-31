/**
 * Navigation Plugin
 * Includes responsiveMenu() function
 *
 * Copyright 2016 ThemeZee
 * Free to use under the GPLv2 and later license.
 * http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Author: Thomas Weichselbaumer (themezee.com)
 *
 * @package Poseidon
 */

(function($) {

	/**--------------------------------------------------------------
	# Responsive Navigation for WordPress menus
	--------------------------------------------------------------*/
	$.fn.responsiveMenu = function( options ) {

		if ( options === undefined ) {
			options = {};
		}

		/* Set Defaults */
		var defaults = {
			menuClass: 'menu',
			toggleClass: 'menu-toggle',
			toggleText: '',
			maxWidth: '60em'
		};

		/* Set Variables */
		var vars = $.extend( {}, defaults, options ),
			menuClass = vars.menuClass,
			toggleID = ( vars.toggleID ) ? vars.toggleID : vars.toggleClass,
			toggleClass = vars.toggleClass,
			toggleText = vars.toggleText,
			maxWidth = vars.maxWidth,
			$this = $( this ),
			$menu = $( '.' + menuClass );

		/*********************
		* Desktop Navigation *
		**********************/

		/* Set and reset dropdown animations based on screen size */
		if ( typeof matchMedia == 'function' ) {
			var mq = window.matchMedia( '(max-width: ' + maxWidth + ')' );
			mq.addListener( widthChange );
			widthChange( mq );
		}
		function widthChange( mq ) {

			if ( mq.matches ) {

				/* Reset desktop navigation menu dropdown animation on smaller screens */
				$menu.find( 'ul.sub-menu' ).css( { display: 'block' } );
				$menu.find( 'li ul.sub-menu' ).css( { visibility: 'visible', display: 'block' } );
				$menu.find( 'li.menu-item-has-children' ).unbind( 'mouseenter mouseleave' );

				$menu.find( 'li.menu-item-has-children ul.sub-menu' ).each( function() {
					$( this ).hide();
					$( this ).parent().find( '.submenu-dropdown-toggle' ).removeClass( 'active' );
				} );

				/* Remove ARIA states on mobile devices */
				$menu.find( 'li.menu-item-has-children > a' ).unbind( 'focus.aria mouseenter.aria blur.aria  mouseleave.aria' );

			} else {

				/* Add dropdown animation for desktop navigation menu */
				$menu.find( 'ul.sub-menu' ).css( { display: 'none' } );
				$menu.find( 'li.menu-item-has-children' ).hover( function() {
					$( this ).find( 'ul:first' ).css( { visibility: 'visible', display: 'none' } ).slideDown( 300 );
				}, function() {
					$( this ).find( 'ul:first' ).css( { visibility: 'hidden' } );
				} );

				/* Make sure menu does not fly off the right of the screen */
				$menu.find( 'li ul.sub-menu li.menu-item-has-children' ).mouseenter( function() {
					if ( $( this ).children( 'ul.sub-menu' ).offset().left + 250 > $( window ).width() ) {
						$( this ).children( 'ul.sub-menu' ).css( { right: '100%', left: 'auto' } );
					}
				});

				// Add menu items with submenus to aria-haspopup="true".
				$menu.find( 'li.menu-item-has-children' ).attr( 'aria-haspopup', 'true' ).attr( 'aria-expanded', 'false' );

				/* Properly update the ARIA states on focus (keyboard) and mouse over events */
				$menu.find( 'li.menu-item-has-children > a' ).on( 'focus.aria mouseenter.aria', function() {
					$( this ).parents( '.menu-item' ).attr( 'aria-expanded', true ).find( 'ul:first' ).css( { visibility: 'visible', display: 'block' } );
				} );

				/* Properly update the ARIA states on blur (keyboard) and mouse out events */
				$menu.find( 'li.menu-item-has-children > a' ).on( 'blur.aria  mouseleave.aria', function() {

					if( ! $(this).parent().next( 'li' ).length > 0 && ! $(this).next('ul').length > 0 ) {

						$( this ).closest( 'li.menu-item-has-children' ).attr( 'aria-expanded', false ).find( '.sub-menu' ).css( { display: 'none' } );

					}

				} );

			}

		}

		/********************
		* Mobile Navigation *
		*********************/

		/* Add Menu Toggle Button for mobile navigation */
		$this.before( '<button id=\"' + toggleID + '\" class=\"' + toggleClass + '\">' + toggleText + '</button>' );

		/* Add dropdown toggle for submenus on mobile navigation */
		$menu.find( 'li.menu-item-has-children' ).prepend( '<span class=\"submenu-dropdown-toggle\"></span>' );

		/* Add dropdown slide animation for mobile devices */
		$( '#' + toggleID ).on( 'click', function() {
			$menu.slideToggle();
			$( this ).toggleClass( 'active' );
		});

		/* Add dropdown animation for submenus on mobile navigation */
		$menu.find( 'li.menu-item-has-children .sub-menu' ).each( function () {
			$( this ).hide();
		} );
		$menu.find( '.submenu-dropdown-toggle' ).on( 'click', function() {
			$( this ).parent().find( 'ul:first' ).slideToggle();
			$( this ).toggleClass( 'active' );
		});

	};

	/**--------------------------------------------------------------
	# Setup Navigation Menus
	--------------------------------------------------------------*/
	$( document ).ready( function() {

		/* Setup Main Navigation */
		$( '#main-navigation' ).responsiveMenu( {
			menuClass: 'main-navigation-menu',
			toggleClass: 'main-navigation-toggle',
			maxWidth: '60em'
		} );

		/* Setup Top Navigation */
		$( '#top-navigation' ).responsiveMenu( {
			menuClass: 'top-navigation-menu',
			toggleClass: 'top-navigation-toggle',
			maxWidth: '60em'
		} );

	} );

}(jQuery));
