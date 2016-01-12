/**
 * jQuery Navigation Plugin
 * Includes responsiveMenu() function
 *
 * Copyright 2015 ThemeZee
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
	
		if (options === undefined) options = {};
		
		/* Set Defaults */
		var defaults = {
			menuClass: "menu",
			toggleClass: "menu-toggle",
			toggleText: "",
			maxWidth: "60em"
		};
		
		/* Set Variables */
		var vars = $.extend({}, defaults, options),
			menuClass = vars.menuClass,
			toggleID = (vars.toggleID) ? vars.toggleID : vars.toggleClass,
			toggleClass = vars.toggleClass,
			toggleText = vars.toggleText,
			maxWidth = vars.maxWidth,
			$this = $(this),
			$menu = $('.' + menuClass);
		

		/*********************
		* Desktop Navigation *
		**********************/				
		
		/* Set and reset dropdown animations based on screen size */
		if(typeof matchMedia == 'function') {
			var mq = window.matchMedia('(max-width: ' + maxWidth + ')');
			mq.addListener(widthChange);
			widthChange(mq);
		}
		function widthChange(mq) {
			
			if (mq.matches) {
		
				/* Reset desktop navigation menu dropdown animation on smaller screens */
				$menu.find('ul').css({display: 'block'});
				$menu.find('li ul').css({visibility: 'visible', display: 'block'});
				$menu.find('li').unbind('mouseenter mouseleave');
				
				$menu.find('li.menu-item-has-children ul').each( function () {
					$( this ).hide();
					$(this).parent().find('.submenu-dropdown-toggle').removeClass('active');
				} );
				
			} else {
				
				/* Add dropdown animation for desktop navigation menu */
				$menu.find('ul').css({display: 'none'});
				$menu.find('li').hover(function(){
					$(this).find('ul:first').css({visibility: 'visible',display: 'none'}).slideDown(300);
				},function(){
					$(this).find('ul:first').css({visibility: 'hidden'});
				});
				
			}
			
		}
		
		
		/********************
		* Mobile Navigation *
		*********************/	
		
		/* Add Menu Toggle Button for mobile navigation */
		$this.before('<button id=\"' + toggleID + '\" class=\"' + toggleClass + '\">' + toggleText + '</button>');
				
		/* Add dropdown toggle for submenus on mobile navigation */
		$menu.find('li.menu-item-has-children').prepend('<span class=\"submenu-dropdown-toggle\"></span>');
		
		/* Add dropdown slide animation for mobile devices */
		$('#' + toggleID).on('click', function(){
			$menu.slideToggle();
			$(this).toggleClass('active');
		});
		
		/* Add dropdown animation for submenus on mobile navigation */
		$menu.find('li.menu-item-has-children ul').each( function () {
			$( this ).hide();
		} );
		$menu.find('.submenu-dropdown-toggle').on('click', function(){
			$(this).parent().find('ul:first').slideToggle();
			$(this).toggleClass('active');
		});

	};
	
	
	/**--------------------------------------------------------------
	# Setup Navigation Menus
	--------------------------------------------------------------*/
	$( document ).ready( function() {
		
		/* Setup Main Navigation */
		$("#main-navigation").responsiveMenu({
			menuClass: "main-navigation-menu",
			toggleClass: "main-navigation-toggle",
			maxWidth: "60em"
		});
		
		/* Setup Top Navigation */
		$("#top-navigation").responsiveMenu({
			menuClass: "top-navigation-menu",
			toggleClass: "top-navigation-toggle",
			maxWidth: "60em"
		});
		
		/* Setup Top Navigation */
		$("#footer-links").responsiveMenu({
			menuClass: "footer-navigation-menu",
			toggleClass: "footer-navigation-toggle",
			maxWidth: "60em"
		});
		
		/* Setup Footer Navigation 
		$('.footer-navigation-menu').before('<button id=\"footer-links-toggle\" class=\"footer-navigation-toggle\"></button>');
		
		$('#footer-links-toggle').on('click', function(){
			$('.footer-navigation-menu').slideToggle();
			$(this).toggleClass('active');
		});*/

	} );

}(jQuery));