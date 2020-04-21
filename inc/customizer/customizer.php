<?php
/**
 * Implement theme options in the Customizer
 *
 * @package Poseidon
 */

// Load Customizer Helper Functions.
require( get_template_directory() . '/inc/customizer/functions/sanitize-functions.php' );
require( get_template_directory() . '/inc/customizer/functions/callback-functions.php' );

// Load Custom Controls.
require( get_template_directory() . '/inc/customizer/controls/category-dropdown-control.php' );
require( get_template_directory() . '/inc/customizer/controls/header-control.php' );
require( get_template_directory() . '/inc/customizer/controls/links-control.php' );
require( get_template_directory() . '/inc/customizer/controls/magazine-widget-area-control.php' );
require( get_template_directory() . '/inc/customizer/controls/plugin-control.php' );
require( get_template_directory() . '/inc/customizer/controls/upgrade-control.php' );

// Load Customizer Section Files.
require( get_template_directory() . '/inc/customizer/sections/customizer-general.php' );
require( get_template_directory() . '/inc/customizer/sections/customizer-blog.php' );
require( get_template_directory() . '/inc/customizer/sections/customizer-post.php' );
require( get_template_directory() . '/inc/customizer/sections/customizer-magazine.php' );
require( get_template_directory() . '/inc/customizer/sections/customizer-slider.php' );
require( get_template_directory() . '/inc/customizer/sections/customizer-info.php' );
require( get_template_directory() . '/inc/customizer/sections/customizer-website.php' );

/**
 * Registers Theme Options panel and sets up some WordPress core settings
 *
 * @param object $wp_customize / Customizer Object.
 */
function poseidon_customize_register_options( $wp_customize ) {

	// Add Theme Options Panel.
	$wp_customize->add_panel( 'poseidon_options_panel', array(
		'priority'       => 180,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => esc_html__( 'Theme Options', 'poseidon' ),
	) );

	// Change default background section.
	$wp_customize->get_control( 'background_color' )->section = 'background_image';
	$wp_customize->get_section( 'background_image' )->title   = esc_html__( 'Background', 'poseidon' );
}
add_action( 'customize_register', 'poseidon_customize_register_options' );


/**
 * Embed JS file to make Theme Customizer preview reload changes asynchronously.
 */
function poseidon_customize_preview_js() {
	wp_enqueue_script( 'poseidon-customize-preview', get_template_directory_uri() . '/assets/js/customize-preview.js', array( 'customize-preview' ), '20200410', true );
}
add_action( 'customize_preview_init', 'poseidon_customize_preview_js' );


/**
 * Embed JS for Customizer Controls.
 */
function poseidon_customizer_controls_js() {
	wp_enqueue_script( 'poseidon-customizer-controls', get_template_directory_uri() . '/assets/js/customizer-controls.js', array(), '20200410', true );
}
add_action( 'customize_controls_enqueue_scripts', 'poseidon_customizer_controls_js' );


/**
 * Embed CSS styles for the theme options in the Customizer
 */
function poseidon_customize_preview_css() {
	wp_enqueue_style( 'poseidon-customizer-css', get_template_directory_uri() . '/assets/css/customizer.css', array(), '20200410' );
}
add_action( 'customize_controls_print_styles', 'poseidon_customize_preview_css' );
