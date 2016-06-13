<?php
/**
 * Custom functions that are not template related
 *
 * @package Poseidon
 */

if ( ! function_exists( 'poseidon_default_menu' ) ) :
/**
 * Display default page as navigation if no custom menu was set
 */
function poseidon_default_menu() {

	echo '<ul id="menu-main-navigation" class="main-navigation-menu menu">'. wp_list_pages( 'title_li=&echo=0' ) .'</ul>';

}
endif;


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function poseidon_body_classes( $classes ) {

	// Get theme options from database.
	$theme_options = poseidon_theme_options();

	// Switch sidebar layout to left.
	if ( 'left-sidebar' == $theme_options['layout'] ) {
		$classes[] = 'sidebar-left';
	}

	// Add sticky header class.
	if ( true == $theme_options['sticky_header'] ) {
		$classes[] = 'sticky-header';
	}

	// Add small post layout class.
	if ( ( is_archive() or is_home() ) and 'left' == $theme_options['post_layout_archives'] ) {
		$classes[] = 'post-layout-small';
	}

	return $classes;
}
add_filter( 'body_class', 'poseidon_body_classes' );


/**
 * Change excerpt length for default posts
 *
 * @param int $length Length of excerpt in number of words.
 * @return int
 */
function poseidon_excerpt_length( $length ) {

	// Get theme options from database.
	$theme_options = poseidon_theme_options();

	// Return excerpt text.
	if ( isset( $theme_options['excerpt_length'] ) and $theme_options['excerpt_length'] >= 0 ) :
		return absint( $theme_options['excerpt_length'] );
	else :
		return 30; // Number of words.
	endif;
}
add_filter( 'excerpt_length', 'poseidon_excerpt_length' );


/**
 * Function to change excerpt length for posts in category posts widgets
 *
 * @param int $length Length of excerpt in number of words.
 * @return int
 */
function poseidon_magazine_posts_excerpt_length( $length ) {
	return 15;
}


/**
 * Change excerpt more text for posts
 *
 * @param String $more_text Excerpt More Text.
 * @return string
 */
function poseidon_excerpt_more( $more_text ) {

	// Get theme options from database.
	$theme_options = poseidon_theme_options();

	return esc_attr( $theme_options['excerpt_more'] );

}
add_filter( 'excerpt_more', 'poseidon_excerpt_more' );


/**
 * Set wrapper start for wooCommerce
 */
function poseidon_wrapper_start() {
	echo '<section id="primary" class="content-area">';
	echo '<main id="main" class="site-main" role="main">';
}
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
add_action( 'woocommerce_before_main_content', 'poseidon_wrapper_start', 10 );


/**
 * Set wrapper end for wooCommerce
 */
function poseidon_wrapper_end() {
	echo '</main><!-- #main -->';
	echo '</section><!-- #primary -->';
}
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_after_main_content', 'poseidon_wrapper_end', 10 );
