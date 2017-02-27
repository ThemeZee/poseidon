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

		echo '<ul id="menu-main-navigation" class="main-navigation-menu menu">' . wp_list_pages( 'title_li=&echo=0' ) . '</ul>';

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

	// Check if sidebar widget area is empty or switch sidebar layout to left.
	if ( ! is_active_sidebar( 'sidebar' ) ) {
		$classes[] = 'no-sidebar';
	} elseif ( 'left-sidebar' == $theme_options['layout'] ) {
		$classes[] = 'sidebar-left';
	}

	// Add small post layout class.
	if ( ( is_archive() or is_home() or is_search() ) and 'left' == $theme_options['post_layout_archives'] ) {
		$classes[] = 'post-layout-small';
	}

	// Hide Date?
	if ( false === $theme_options['meta_date'] ) {
		$classes[] = 'date-hidden';
	}

	// Hide Author?
	if ( false === $theme_options['meta_author'] ) {
		$classes[] = 'author-hidden';
	}

	// Hide Categories?
	if ( false === $theme_options['meta_category'] ) {
		$classes[] = 'categories-hidden';
	}

	return $classes;
}
add_filter( 'body_class', 'poseidon_body_classes' );


/**
 * Hide Elements with CSS.
 *
 * @return void
 */
function poseidon_hide_elements() {

	// Get theme options from database.
	$theme_options = poseidon_theme_options();

	$elements = array();

	// Hide Site Title?
	if ( false === $theme_options['site_title'] ) {
		$elements[] = '.site-title';
	}

	// Hide Site Description?
	if ( false === $theme_options['site_description'] ) {
		$elements[] = '.site-description';
	}

	// Hide Post Tags?
	if ( false === $theme_options['meta_tags'] ) {
		$elements[] = '.type-post .entry-footer .entry-tags';
	}

	// Hide Post Navigation?
	if ( false === $theme_options['post_navigation'] ) {
		$elements[] = '.type-post .entry-footer .post-navigation';
	}

	// Return early if no elements are hidden.
	if ( empty( $elements ) ) {
		return;
	}

	// Create CSS.
	$classes = implode( ', ', $elements );
	$custom_css = $classes . ' { position: absolute; clip: rect(1px, 1px, 1px, 1px); }';

	// Add Custom CSS.
	wp_add_inline_style( 'poseidon-stylesheet', $custom_css );
}
add_filter( 'wp_enqueue_scripts', 'poseidon_hide_elements', 11 );


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
 * Get Magazine Post IDs
 *
 * @param String $cache_id        Magazine Widget Instance.
 * @param int    $category        Category ID.
 * @param int    $number_of_posts Number of posts.
 * @return array Post IDs
 */
function poseidon_get_magazine_post_ids( $cache_id, $category, $number_of_posts ) {

	$cache_id = sanitize_key( $cache_id );
	$post_ids = get_transient( 'poseidon_magazine_post_ids' );

	if ( ! isset( $post_ids[ $cache_id ] ) ) {

		// Get Posts from Database.
		$query_arguments = array(
			'fields'              => 'ids',
			'cat'                 => (int) $category,
			'posts_per_page'      => (int) $number_of_posts,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		);
		$query = new WP_Query( $query_arguments );

		// Create an array of all post ids.
		$post_ids[ $cache_id ] = $query->posts;

		// Set Transient.
		set_transient( 'poseidon_magazine_post_ids', $post_ids );
	}

	return apply_filters( 'poseidon_magazine_post_ids', $post_ids[ $cache_id ], $cache_id );
}


/**
 * Delete Cached Post IDs
 *
 * @return void
 */
function poseidon_flush_magazine_post_ids() {
	delete_transient( 'poseidon_magazine_post_ids' );
}
add_action( 'save_post', 'poseidon_flush_magazine_post_ids' );
add_action( 'deleted_post', 'poseidon_flush_magazine_post_ids' );
add_action( 'switch_theme', 'poseidon_flush_magazine_post_ids' );


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
