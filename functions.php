<?php
/**
 * Poseidon functions and definitions
 *
 * @package Poseidon
 */

/**
 * Poseidon only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}


if ( ! function_exists( 'poseidon_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function poseidon_setup() {

		// Make theme available for translation. Translations can be filed in the /languages/ directory.
		load_theme_textdomain( 'poseidon', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Set detfault Post Thumbnail size.
		set_post_thumbnail_size( 840, 560, true );

		// Register Navigation Menu.
		register_nav_menu( 'primary', esc_html__( 'Main Navigation', 'poseidon' ) );

		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'poseidon_custom_background_args', array( 'default-color' => 'ffffff' ) ) );

		// Set up the WordPress core custom logo feature.
		add_theme_support( 'custom-logo', apply_filters( 'poseidon_custom_logo_args', array(
			'height'      => 50,
			'width'       => 250,
			'flex-height' => true,
			'flex-width'  => true,
		) ) );

		// Set up the WordPress core custom header feature.
		add_theme_support( 'custom-header', apply_filters( 'poseidon_custom_header_args', array(
			'header-text' => false,
			'width'       => 2500,
			'height'      => 625,
			'flex-height' => true,
		) ) );

		// Add Theme Support for wooCommerce.
		add_theme_support( 'woocommerce' );

		// Add extra theme styling to the visual editor.
		add_editor_style( array( 'assets/css/editor-style.css' ) );

		// Add Theme Support for Selective Refresh in Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for responsive embed blocks.
		add_theme_support( 'responsive-embeds' );
	}
endif;
add_action( 'after_setup_theme', 'poseidon_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function poseidon_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'poseidon_content_width', 840 );
}
add_action( 'after_setup_theme', 'poseidon_content_width', 0 );


/**
 * Register widget areas and custom widgets.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function poseidon_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'poseidon' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'Appears on posts and pages except the full width template.', 'poseidon' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="widget-header"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Magazine Homepage', 'poseidon' ),
		'id'            => 'magazine-homepage',
		'description'   => esc_html__( 'Appears on blog index and Magazine Homepage template. You can use the Magazine widgets here.', 'poseidon' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-header"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );
}
add_action( 'widgets_init', 'poseidon_widgets_init' );


/**
 * Enqueue scripts and styles.
 */
function poseidon_scripts() {

	// Get theme options from database.
	$theme_options = poseidon_theme_options();

	// Get Theme Version.
	$theme_version = wp_get_theme()->get( 'Version' );

	// Register and Enqueue Stylesheet.
	wp_enqueue_style( 'poseidon-stylesheet', get_stylesheet_uri(), array(), $theme_version );

	// Register and Enqueue HTML5shiv to support HTML5 elements in older IE versions.
	wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/assets/js/html5shiv.min.js', array(), '3.7.3' );
	wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

	// Register and enqueue navigation.min.js.
	if ( ( has_nav_menu( 'primary' ) || has_nav_menu( 'secondary' ) ) && ! poseidon_is_amp() ) {
		wp_enqueue_script( 'poseidon-navigation', get_theme_file_uri( '/assets/js/navigation.min.js' ), array( 'jquery' ), '20200822', true );
		$poseidon_l10n = array(
			'expand'   => esc_html__( 'Expand child menu', 'poseidon' ),
			'collapse' => esc_html__( 'Collapse child menu', 'poseidon' ),
			'icon'     => poseidon_get_svg( 'expand' ),
		);
		wp_localize_script( 'poseidon-navigation', 'poseidonScreenReaderText', $poseidon_l10n );
	}

	// Register and enqueue sticky-header.js.
	if ( true == $theme_options['sticky_header'] && ! poseidon_is_amp() ) {
		wp_enqueue_script( 'poseidon-jquery-sticky-header', get_template_directory_uri() . '/assets/js/sticky-header.js', array( 'jquery' ), '20170203' );
	}

	// Enqueue svgxuse to support external SVG Sprites in Internet Explorer.
	if ( ! poseidon_is_amp() ) {
		wp_enqueue_script( 'svgxuse', get_theme_file_uri( '/assets/js/svgxuse.min.js' ), array(), '1.2.6' );
	}

	// Register Comment Reply Script for Threaded Comments.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'poseidon_scripts' );


/**
* Enqueue theme fonts.
*/
function poseidon_theme_fonts() {
	$fonts_url = poseidon_get_fonts_url();

	// Load Fonts if necessary.
	if ( $fonts_url ) {
		require_once get_theme_file_path( 'inc/wptt-webfont-loader.php' );
		wp_enqueue_style( 'poseidon-theme-fonts', wptt_get_webfont_url( $fonts_url ), array(), '20201110' );
	}
}
add_action( 'wp_enqueue_scripts', 'poseidon_theme_fonts', 1 );
add_action( 'enqueue_block_editor_assets', 'poseidon_theme_fonts', 1 );


/**
 * Retrieve webfont URL to load fonts locally.
 */
function poseidon_get_fonts_url() {
	$font_families = array(
		'Ubuntu:400,400italic,700,700italic',
		'Raleway:400,400italic,700,700italic',
	);

	$query_args = array(
		'family'  => urlencode( implode( '|', $font_families ) ),
		'subset'  => urlencode( 'latin,latin-ext' ),
		'display' => urlencode( 'swap' ),
	);

	return apply_filters( 'poseidon_get_fonts_url', add_query_arg( $query_args, 'https://fonts.googleapis.com/css' ) );
}


/**
 * Add custom sizes for featured images
 */
function poseidon_add_image_sizes() {

	// Add Custom Header Image Size.
	add_image_size( 'poseidon-header-image', 1920, 480, true );

	// Add different thumbnail sizes for widgets and post layouts.
	add_image_size( 'poseidon-thumbnail-small', 120, 80, true );
	add_image_size( 'poseidon-thumbnail-medium', 360, 240, true );
	add_image_size( 'poseidon-thumbnail-large', 600, 400, true );
	add_image_size( 'poseidon-thumbnail-single', 840, 420, true );
}
add_action( 'after_setup_theme', 'poseidon_add_image_sizes' );


/**
 * Make custom image sizes available in Gutenberg.
 */
function poseidon_add_image_size_names( $sizes ) {
	return array_merge( $sizes, array(
		'post-thumbnail'            => esc_html__( 'Poseidon Blog Post', 'poseidon' ),
		'poseidon-thumbnail-single' => esc_html__( 'Poseidon Single Post', 'poseidon' ),
		'poseidon-thumbnail-large'  => esc_html__( 'Poseidon Magazine Post', 'poseidon' ),
		'poseidon-thumbnail-small'  => esc_html__( 'Poseidon Thumbnail', 'poseidon' ),
	) );
}
add_filter( 'image_size_names_choose', 'poseidon_add_image_size_names' );


/**
 * Include Files
 */

// Include Theme Info page.
require get_template_directory() . '/inc/theme-info.php';

// Include Theme Customizer Options.
require get_template_directory() . '/inc/customizer/customizer.php';
require get_template_directory() . '/inc/customizer/default-options.php';

// Include SVG Icon Functions.
require get_template_directory() . '/inc/icons.php';

// Include Extra Functions.
require get_template_directory() . '/inc/extras.php';

// Include Template Functions.
require get_template_directory() . '/inc/template-tags.php';

// Include Gutenberg Features.
require get_template_directory() . '/inc/gutenberg.php';

// Include support functions for Theme Addons.
require get_template_directory() . '/inc/addons.php';

// Include Post Slider Setup.
require get_template_directory() . '/inc/slider.php';

// Include Magazine Functions.
require get_template_directory() . '/inc/magazine.php';

// Include Widget Files.
require get_template_directory() . '/inc/widgets/widget-magazine-posts-columns.php';
require get_template_directory() . '/inc/widgets/widget-magazine-posts-grid.php';
require get_template_directory() . '/inc/widgets/widget-magazine-posts-horizontal-box.php';
require get_template_directory() . '/inc/widgets/widget-magazine-posts-vertical-box.php';
