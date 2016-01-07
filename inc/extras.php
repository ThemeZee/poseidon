<?php
/**
 * Custom functions that are not template related
 *
 * @package Poseidon
 */

 
if ( ! function_exists( 'poseidon_default_menu' ) ) :
/**
 * Display default page as navigation if no custom menu was set
 *
 */
function poseidon_default_menu() {
	
	echo '<ul id="menu-main-navigation" class="main-navigation-menu menu">'. wp_list_pages('title_li=&echo=0') .'</ul>';
	
}
endif;


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function poseidon_body_classes( $classes ) {
	
	// Get Theme Options from Database
	$theme_options = poseidon_theme_options();
		
	// Switch Sidebar Layout to left
	if ( 'left-sidebar' == $theme_options['layout'] ) {
		$classes[] = 'sidebar-left';
	}
	
	// Add Sticky Header class
	if ( true == $theme_options['sticky_header'] ) {
		$classes[] = 'sticky-header';
	}
	
	// Add Small Post Layout class
	if ( ( is_archive() or is_home() ) and 'left' == $theme_options['post_layout_archives'] ) {
		$classes[] = 'post-layout-small';
	}

	return $classes;
}
add_filter( 'body_class', 'poseidon_body_classes' );


/**
 * Change excerpt length for default posts
 *
 * @param int $length Length of excerpt in number of words
 * @return int
 */
function poseidon_excerpt_length($length) {
	
	// Get Theme Options from Database
	$theme_options = poseidon_theme_options();

	// Return Excerpt Text
	if ( isset($theme_options['excerpt_length']) and $theme_options['excerpt_length'] >= 0 ) :
		return absint( $theme_options['excerpt_length'] );
	else :
		return 30; // number of words
	endif;
}
add_filter('excerpt_length', 'poseidon_excerpt_length');


/**
 * Function to change excerpt length for posts in category posts widgets
 *
 * @param int $length Length of excerpt in number of words
 * @return int
 */
function poseidon_magazine_posts_excerpt_length($length) {
    return 15;
}


/**
 * Set wrapper start for wooCommerce
 *
 */
function poseidon_wrapper_start() {
	echo '<section id="primary" class="content-area">';
	echo '<main id="main" class="site-main" role="main">';
}
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
add_action('woocommerce_before_main_content', 'poseidon_wrapper_start', 10);


/**
 * Set wrapper end for wooCommerce
 *
 */
function poseidon_wrapper_end() {
	echo '</main><!-- #main -->';
	echo '</section><!-- #primary -->';
}
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_after_main_content', 'poseidon_wrapper_end', 10);


/**
 * Returns the themezee.com links
 *
 * @param string $link Which link should be displayed
 * @return string $url URL to correct ThemeZee.com page
 */
function poseidon_theme_links( $link ) {
    
	// Set Language Variable
	$language = get_locale();
	
	// Theme Links
	$theme_links = array(
		'homepage' 		=> 'https://themezee.com/',
		'theme_page' 	=> 'https://themezee.com/themes/poseidon/',
		'documentation' => 'https://themezee.com/docs/poseidon-documentation/',
		'pro_version' 	=> 'https://themezee.com/themes/poseidon/',
		'toolkit' 		=> 'https://themezee.com/plugins/toolkit/',
		'plugins' 		=> 'https://themezee.com/plugins/',
	);
	
	// Links for German website
	$theme_links_german = array(
		'homepage' 		=> 'https://themezee.com/de/',
		'theme_page' 	=> 'https://themezee.com/de/themes/poseidon/',
		'documentation' => 'https://themezee.com/de/docs/poseidon-dokumentation/',
		'pro_version' 	=> 'https://themezee.com/de/themes/poseidon/',
		'toolkit' 		=> 'https://themezee.com/de/plugins/toolkit/',
		'plugins' 		=> 'https://themezee.com/de/plugins/',
	);
	
	// Use URLs for German website when site language is German
	if( 'de_DE' ==  $language or 'de_DE_formal' == $language or 'de_CH' == $language ) {
		$theme_links = $theme_links_german;
	}
	
	// Return URL
	if( array_key_exists( $link, $theme_links ) ) {
		
		return $theme_links[$link];
	
	} else {
		
		return $theme_links['homepage'];
		
	}
	
}