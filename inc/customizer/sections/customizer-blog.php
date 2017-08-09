<?php
/**
 * Blog Settings
 *
 * Register Blog Settings section, settings and controls for Theme Customizer
 *
 * @package Poseidon
 */

/**
 * Adds blog settings in the Customizer
 *
 * @param object $wp_customize / Customizer Object.
 */
function poseidon_customize_register_blog_settings( $wp_customize ) {

	// Add Sections for Post Settings.
	$wp_customize->add_section( 'poseidon_section_blog', array(
		'title'    => esc_html__( 'Blog Settings', 'poseidon' ),
		'priority' => 25,
		'panel'    => 'poseidon_options_panel',
	) );

	// Add Blog Title setting and control.
	$wp_customize->add_setting( 'poseidon_theme_options[latest_posts_title]', array(
		'default'           => '',
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_kses_post',
	) );

	$wp_customize->add_control( 'poseidon_theme_options[latest_posts_title]', array(
		'label'    => esc_html__( 'Blog Title', 'poseidon' ),
		'section'  => 'poseidon_section_blog',
		'settings' => 'poseidon_theme_options[latest_posts_title]',
		'type'     => 'text',
		'priority' => 10,
	) );

	$wp_customize->selective_refresh->add_partial( 'poseidon_theme_options[latest_posts_title]', array(
		'selector'         => '.blog-header .blog-title',
		'render_callback'  => 'poseidon_customize_partial_blog_title',
		'fallback_refresh' => false,
	) );

	// Add Blog Description setting and control.
	$wp_customize->add_setting( 'poseidon_theme_options[blog_description]', array(
		'default'           => '',
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_kses_post',
	) );

	$wp_customize->add_control( 'poseidon_theme_options[blog_description]', array(
		'label'    => esc_html__( 'Blog Description', 'poseidon' ),
		'section'  => 'poseidon_section_blog',
		'settings' => 'poseidon_theme_options[blog_description]',
		'type'     => 'textarea',
		'priority' => 20,
	) );

	$wp_customize->selective_refresh->add_partial( 'poseidon_theme_options[blog_description]', array(
		'selector'         => '.blog-header .blog-description',
		'render_callback'  => 'poseidon_customize_partial_blog_description',
		'fallback_refresh' => false,
	) );

	// Add Post Layout Settings for archive posts.
	$wp_customize->add_setting( 'poseidon_theme_options[post_layout_archives]', array(
		'default'           => 'left',
		'type'              => 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'poseidon_sanitize_select',
	) );

	$wp_customize->add_control( 'poseidon_theme_options[post_layout_archives]', array(
		'label'    => esc_html__( 'Blog Layout', 'poseidon' ),
		'section'  => 'poseidon_section_blog',
		'settings' => 'poseidon_theme_options[post_layout_archives]',
		'type'     => 'select',
		'priority' => 30,
		'choices'  => array(
			'left' => esc_html__( 'Show featured image beside content', 'poseidon' ),
			'top'  => esc_html__( 'Show featured image above content', 'poseidon' ),
			'none' => esc_html__( 'Hide featured image', 'poseidon' ),
		),
	) );

	// Add Settings and Controls for post content.
	$wp_customize->add_setting( 'poseidon_theme_options[post_content]', array(
		'default'           => 'excerpt',
		'type'              => 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'poseidon_sanitize_select',
	) );

	$wp_customize->add_control( 'poseidon_theme_options[post_content]', array(
		'label'    => esc_html__( 'Post length on archives', 'poseidon' ),
		'section'  => 'poseidon_section_blog',
		'settings' => 'poseidon_theme_options[post_content]',
		'type'     => 'radio',
		'priority' => 40,
		'choices'  => array(
			'index'   => esc_html__( 'Show full posts', 'poseidon' ),
			'excerpt' => esc_html__( 'Show post excerpts', 'poseidon' ),
		),
	) );

	// Add Setting and Control for Excerpt Length.
	$wp_customize->add_setting( 'poseidon_theme_options[excerpt_length]', array(
		'default'           => 30,
		'type'              => 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'poseidon_theme_options[excerpt_length]', array(
		'label'           => esc_html__( 'Excerpt Length', 'poseidon' ),
		'section'         => 'poseidon_section_blog',
		'settings'        => 'poseidon_theme_options[excerpt_length]',
		'type'            => 'text',
		'active_callback' => 'poseidon_control_post_content_callback',
		'priority'        => 50,
	) );

	// Add Magazine Widgets Headline.
	$wp_customize->add_control( new Poseidon_Customize_Header_Control(
		$wp_customize, 'poseidon_theme_options[blog_magazine_widgets_title]', array(
			'label'    => esc_html__( 'Magazine Widgets', 'poseidon' ),
			'section'  => 'poseidon_section_blog',
			'settings' => array(),
			'priority' => 60,
		)
	) );

	// Add Setting and Control for Magazine widgets.
	$wp_customize->add_setting( 'poseidon_theme_options[blog_magazine_widgets]', array(
		'default'           => true,
		'type'              => 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'poseidon_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'poseidon_theme_options[blog_magazine_widgets]', array(
		'label'    => esc_html__( 'Display Magazine widgets on blog index', 'poseidon' ),
		'section'  => 'poseidon_section_blog',
		'settings' => 'poseidon_theme_options[blog_magazine_widgets]',
		'type'     => 'checkbox',
		'priority' => 70,
	) );
}
add_action( 'customize_register', 'poseidon_customize_register_blog_settings' );

/**
 * Render the blog title for the selective refresh partial.
 */
function poseidon_customize_partial_blog_title() {
	$theme_options = poseidon_theme_options();
	echo wp_kses_post( $theme_options['latest_posts_title'] );
}

/**
 * Render the blog description for the selective refresh partial.
 */
function poseidon_customize_partial_blog_description() {
	$theme_options = poseidon_theme_options();
	echo wp_kses_post( $theme_options['blog_description'] );
}
