<?php
/**
 * Returns theme options
 *
 * Uses sane defaults in case the user has not configured any theme options yet.
 *
 * @package Poseidon
 */

/**
* Get a single theme option
*
* @return mixed
*/
function poseidon_get_option( $option_name = '' ) {

	// Get all Theme Options from Database.
	$theme_options = poseidon_theme_options();

	// Return single option.
	if ( isset( $theme_options[ $option_name ] ) ) {
		return $theme_options[ $option_name ];
	}

	return false;
}


/**
 * Get saved user settings from database or theme defaults
 *
 * @return array
 */
function poseidon_theme_options() {

	// Merge theme options array from database with default options array.
	$theme_options = wp_parse_args( get_option( 'poseidon_theme_options', array() ), poseidon_default_options() );

	// Return theme options.
	return $theme_options;
}


/**
 * Returns the default settings of the theme
 *
 * @return array
 */
function poseidon_default_options() {

	$default_options = array(
		'retina_logo'           => false,
		'site_title'            => true,
		'site_description'      => false,
		'custom_header_link'    => '',
		'custom_header_hide'    => false,
		'layout'                => 'right-sidebar',
		'sticky_header'         => false,
		'post_layout_archives'  => 'left',
		'post_layout_single'    => 'header',
		'latest_posts_title'    => esc_html__( 'Latest Posts', 'poseidon' ),
		'blog_description'      => '',
		'post_content'          => 'excerpt',
		'excerpt_length'        => 20,
		'read_more_text'        => esc_html__( 'Read more', 'poseidon' ),
		'blog_magazine_widgets' => true,
		'excerpt_more'          => '[...]',
		'meta_date'             => true,
		'meta_author'           => true,
		'meta_category'         => true,
		'meta_tags'             => false,
		'post_navigation'       => true,
		'slider_magazine'       => false,
		'slider_blog'           => false,
		'slider_category'       => 0,
		'slider_limit'          => 8,
		'slider_animation'      => 'slide',
		'slider_speed'          => 7000,
	);

	return $default_options;
}
