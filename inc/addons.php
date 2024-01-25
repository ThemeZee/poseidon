<?php
/**
 * Add Support for Theme Addons
 *
 * @package Poseidon
 */

/**
 * Register support for Jetpack and theme addons
 */
function poseidon_theme_addons_setup() {

	// Add theme support for Poseidon Pro plugin.
	add_theme_support( 'poseidon-pro' );

	// Add theme support for ThemeZee Plugins.
	add_theme_support( 'themezee-breadcrumbs' );
	add_theme_support( 'themezee-mega-menu', array( 'primary', 'secondary' ) );

	// Add theme support for Widget Bundle.
	add_theme_support(
		'themezee-widget-bundle',
		array(
			'thumbnail_size' => array( 90, 65 ),
		)
	);

	// Add theme support for Related Posts.
	add_theme_support(
		'themezee-related-posts',
		array(
			'thumbnail_size' => array( 480, 320 ),
		)
	);

	// Add theme support for Infinite Scroll.
	add_theme_support(
		'infinite-scroll',
		array(
			'container'      => 'main',
			'footer_widgets' => array( 'footer-left', 'footer-center-left', 'footer-center-right', 'footer-right' ),
			'render'         => 'poseidon_infinite_scroll_render',
		)
	);

	// Add theme support for AMP.
	add_theme_support( 'amp' );

}
add_action( 'after_setup_theme', 'poseidon_theme_addons_setup' );


/**
 * Custom render function for Infinite Scroll.
 */
function poseidon_infinite_scroll_render() {

	// Get theme options from database.
	$theme_options = poseidon_theme_options();

	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', $theme_options['post_content'] );
	}
}


/**
 * Checks if AMP page is rendered.
 */
function poseidon_is_amp() {
	return function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
}


/**
 * Adds amp support for menu toggle.
 */
function poseidon_amp_menu_toggle() {
	if ( poseidon_is_amp() ) {
		echo "[aria-expanded]=\"primaryMenuExpanded? 'true' : 'false'\" ";
		echo 'on="tap:AMP.setState({primaryMenuExpanded: !primaryMenuExpanded})"';
	}
}


/**
 * Adds amp support for mobile dropdown navigation menu.
 */
function poseidon_amp_menu_is_toggled() {
	if ( poseidon_is_amp() ) {
		echo "[class]=\"'main-navigation' + ( primaryMenuExpanded ? ' toggled-on' : '' )\"";
	}
}


/**
 * Filter the HTML output of a nav menu item to add the AMP dropdown button to reveal the sub-menu.
 * This is only used for AMP since in JS it is added via initNavigation() in navigation.js.
 * Source: https://amp-wp.org/documentation/playbooks/navigation-sub-menu-buttons/
 *
 * @param string $item_output   Nav menu item HTML.
 * @param object $item          Nav menu item.
 * @return string Modified nav menu item HTML.
 */
function poseidon_amp_menu_dropdown_toggles( $item_output, $item, $depth, $args ) {

	// Return early if AMP is not used.
	if ( ! poseidon_is_amp() ) {
		return $item_output;
	}

	// Check if primary or secondary navigation is filtered.
	if ( 'primary' !== $args->theme_location && 'secondary' !== $args->theme_location ) {
		return $item_output;
	}

	// Skip when the item has no sub-menu.
	if ( ! in_array( 'menu-item-has-children', $item->classes, true ) ) {
		return $item_output;
	}

	// Obtain the initial expanded state.
	$expanded = in_array( 'current-menu-ancestor', $item->classes, true );

	// Generate a unique state ID.
	static $nav_menu_item_number = 0;
	$nav_menu_item_number++;
	$expanded_state_id = 'navMenuItemExpanded' . $nav_menu_item_number;

	// Create new state for managing storing the whether the sub-menu is expanded.
	$item_output .= sprintf(
		'<amp-state id="%s"><script type="application/json">%s</script></amp-state>',
		esc_attr( $expanded_state_id ),
		wp_json_encode( $expanded )
	);

	/*
	* Create the toggle button which mutates the state and which has class and
	* aria-expanded attributes which react to the state changes.
	*/
	$dropdown_button  = '<button';
	$dropdown_class   = 'dropdown-toggle';
	$toggled_class    = 'toggled-on';
	$dropdown_button .= sprintf(
		' class="%s" [class]="%s"',
		esc_attr( $dropdown_class . ( $expanded ? " $toggled_class" : '' ) ),
		esc_attr( sprintf( "%s + ( $expanded_state_id ? %s : '' )", wp_json_encode( $dropdown_class ), wp_json_encode( " $toggled_class" ) ) )
	);
	$dropdown_button .= sprintf(
		' aria-expanded="%s" [aria-expanded]="%s"',
		esc_attr( wp_json_encode( $expanded ) ),
		esc_attr( "$expanded_state_id ? 'true' : 'false'" )
	);
	$dropdown_button .= sprintf(
		' on="%s"',
		esc_attr( "tap:AMP.setState( { $expanded_state_id: ! $expanded_state_id } )" )
	);
	$dropdown_button .= '>';

	// Add SVG icon.
	$dropdown_button .= $expanded ? poseidon_get_svg( 'collapse' ) : poseidon_get_svg( 'expand' );

	// Let the screen reader text in the button also update based on the expanded state.
	$dropdown_button .= sprintf(
		'<span class="screen-reader-text" [text]="%s">%s</span>',
		esc_attr( sprintf( "$expanded_state_id ? %s : %s", wp_json_encode( esc_html__( 'Collapse child menu', 'poseidon' ) ), wp_json_encode( esc_html__( 'Expand child menu', 'poseidon' ) ) ) ),
		esc_html( $expanded ? esc_html__( 'Collapse child menu', 'poseidon' ) : esc_html__( 'Expand child menu', 'poseidon' ) )
	);

	$dropdown_button .= '</button>';

	$item_output .= $dropdown_button;
	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'poseidon_amp_menu_dropdown_toggles', 10, 4 );
