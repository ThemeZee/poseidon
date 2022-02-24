/* global poseidonScreenReaderText */
/**
 * Theme Navigation
 *
 * @package Poseidon
 */

 (function() {

	// Create dropdown toggle button.
	function createDropdownToggle() {
		var dropdownToggle = document.createElement( 'button' );

		// Add classes and aria attributes.
		dropdownToggle.classList.add( 'dropdown-toggle' );
		dropdownToggle.setAttribute( 'aria-expanded', 'false' );

		// Add icon to dropdown toggle.
		var icon = new DOMParser().parseFromString( poseidonScreenReaderText.icon, 'text/html' ).body.firstElementChild;
		dropdownToggle.appendChild( icon);

		// Add screenreader text.
		var screenReaderText = document.createElement( 'span' );
		screenReaderText.classList.add( 'screen-reader-text' );
		screenReaderText.textContent = poseidonScreenReaderText.expand;
		dropdownToggle.appendChild( screenReaderText );

		return dropdownToggle.cloneNode(true);
	}

	function initNavigation( containerClass, naviClass ) {
		var container  = document.querySelector( containerClass );
		var navigation = document.querySelector( naviClass );

		// Return early if navigation is missing.
		if ( navigation === null ) {
			return;
		}

		// Enable menuToggle.
		(function() {
			var menuToggle = container.querySelector( '.menu-toggle' );

			// Return early if menuToggle is missing.
			if ( menuToggle === null ) {
				return;
			}

			// Add an initial value for the attribute.
			menuToggle.setAttribute( 'aria-expanded', 'false' );

			// Menu Toggle click event.
			menuToggle.addEventListener( 'click', function() {
				navigation.classList.toggle( 'toggled-on' );
				menuToggle.setAttribute( 'aria-expanded', navigation.classList.contains( 'toggled-on' ) );
			});
		})();

		// Enable dropdownToggles that displays child menu items.
		(function() {

			// Insert dropdown toggles in navigation menu.
			navigation.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' ).forEach( function( menuItem ) {
				menuItem.after( createDropdownToggle() );
			});

			// Set the active submenu dropdown toggle button initial state.
			navigation.querySelectorAll( '.current-menu-ancestor > button' ).forEach( function( activeToggle ) {
				activeToggle.classList.add( 'toggled-on' );
				activeToggle.setAttribute( 'aria-expanded', 'true' );
				activeToggle.querySelector( '.screen-reader-text' ).textContent = poseidonScreenReaderText.collapse;
			});

			// Set the active submenu initial state.
			navigation.querySelectorAll( '.current-menu-ancestor > .sub-menu' ).forEach( function( activeSubmenu ) {
				activeSubmenu.classList.add( 'toggled-on' );
			});
	
			// Dropdown Toggles click events.
			navigation.querySelectorAll( '.dropdown-toggle' ).forEach( function( dropdownItem ) {
				dropdownItem.addEventListener( 'click', function() {
					dropdownItem.classList.toggle( 'toggled-on' );
					dropdownItem.setAttribute( 'aria-expanded', dropdownItem.classList.contains( 'toggled-on' ) );
					dropdownItem.querySelector( '.screen-reader-text' ).textContent = dropdownItem.classList.contains( 'toggled-on' ) ? poseidonScreenReaderText.collapse : poseidonScreenReaderText.expand;
					dropdownItem.nextElementSibling.classList.toggle( 'toggled-on' );
				});
			});
		})();

		// Toggle focus class to allow keyboard navigation.
		(function() {

			function toggleFocusClass( menuItem ) {

				// Loop through all parent elements up to the menus root.
				var parent = menuItem.parentNode;
				while ( ! parent.classList.contains( 'menu' ) ) {

					// Check if we pass any li elements which have submenus.
					if ( parent.classList.contains( 'menu-item-has-children' ) ) {
						parent.classList.toggle( 'focus' );
					}

					parent = parent.parentNode;
				}
			}			

			navigation.querySelectorAll( '.menu-item-has-children a, .page_item_has_children a' ).forEach( function( menuItem ) {
				menuItem.addEventListener( 'focus', function() {
					toggleFocusClass( menuItem );
				});
				menuItem.addEventListener( 'blur', function() {
					toggleFocusClass( menuItem );
				});
			});

		})();
	}

	document.addEventListener( 'DOMContentLoaded', function() {

		// Init Main Navigation.
		initNavigation( '.header-main', '.main-navigation' );

		// Init Top Navigation.
		initNavigation( '.header-bar', '.top-navigation' );

	} );

}() );
