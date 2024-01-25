<?php
/**
 * Add theme support for the Gutenberg Editor
 *
 * @package Poseidon
 */

/**
 * Registers support for various Gutenberg features.
 *
 * @return void
 */
function poseidon_gutenberg_support() {

	// Add theme support for dimension controls.
	add_theme_support( 'custom-spacing' );

	// Add theme support for custom line heights.
	add_theme_support( 'custom-line-height' );

	// Define block color palette.
	$color_palette = apply_filters(
		'poseidon_color_palette',
		array(
			'primary_color'    => '#22aadd',
			'secondary_color'  => '#0084b7',
			'tertiary_color'   => '#005e91',
			'accent_color'     => '#dd2e22',
			'highlight_color'  => '#00b734',
			'light_gray_color' => '#eeeeee',
			'gray_color'       => '#777777',
			'dark_gray_color'  => '#404040',
		)
	);

	// Add theme support for block color palette.
	add_theme_support(
		'editor-color-palette',
		apply_filters(
			'poseidon_editor_color_palette_args',
			array(
				array(
					'name'  => esc_html_x( 'Primary', 'block color', 'poseidon' ),
					'slug'  => 'primary',
					'color' => esc_html( $color_palette['primary_color'] ),
				),
				array(
					'name'  => esc_html_x( 'Secondary', 'block color', 'poseidon' ),
					'slug'  => 'secondary',
					'color' => esc_html( $color_palette['secondary_color'] ),
				),
				array(
					'name'  => esc_html_x( 'Tertiary', 'block color', 'poseidon' ),
					'slug'  => 'tertiary',
					'color' => esc_html( $color_palette['tertiary_color'] ),
				),
				array(
					'name'  => esc_html_x( 'Accent', 'block color', 'poseidon' ),
					'slug'  => 'accent',
					'color' => esc_html( $color_palette['accent_color'] ),
				),
				array(
					'name'  => esc_html_x( 'Highlight', 'block color', 'poseidon' ),
					'slug'  => 'highlight',
					'color' => esc_html( $color_palette['highlight_color'] ),
				),
				array(
					'name'  => esc_html_x( 'White', 'block color', 'poseidon' ),
					'slug'  => 'white',
					'color' => '#ffffff',
				),
				array(
					'name'  => esc_html_x( 'Light Gray', 'block color', 'poseidon' ),
					'slug'  => 'light-gray',
					'color' => esc_html( $color_palette['light_gray_color'] ),
				),
				array(
					'name'  => esc_html_x( 'Gray', 'block color', 'poseidon' ),
					'slug'  => 'gray',
					'color' => esc_html( $color_palette['gray_color'] ),
				),
				array(
					'name'  => esc_html_x( 'Dark Gray', 'block color', 'poseidon' ),
					'slug'  => 'dark-gray',
					'color' => esc_html( $color_palette['dark_gray_color'] ),
				),
				array(
					'name'  => esc_html_x( 'Black', 'block color', 'poseidon' ),
					'slug'  => 'black',
					'color' => '#000000',
				),
			)
		)
	);

	// Check if block style functions are available.
	if ( function_exists( 'register_block_style' ) ) {

		// Register Widget Title Block style.
		register_block_style(
			'core/heading',
			array(
				'name'         => 'widget-title',
				'label'        => esc_html__( 'Widget Title', 'poseidon' ),
				'style_handle' => 'poseidon-stylesheet',
			)
		);
	}
}
add_action( 'after_setup_theme', 'poseidon_gutenberg_support' );


/**
 * Enqueue block styles and scripts for Gutenberg Editor.
 */
function poseidon_block_editor_assets() {

	// Enqueue Editor Styling.
	wp_enqueue_style( 'poseidon-editor-styles', get_theme_file_uri( '/assets/css/editor-styles.css' ), array(), '20210306', 'all' );
}
add_action( 'enqueue_block_editor_assets', 'poseidon_block_editor_assets' );
