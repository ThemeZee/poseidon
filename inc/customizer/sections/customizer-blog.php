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

	// Add Section for Blog Settings.
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

	// Add Blog Layout setting and control.
	$wp_customize->add_setting( 'poseidon_theme_options[post_layout_archives]', array(
		'default'           => 'left',
		'type'              => 'option',
		'transport'         => 'postMessage',
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
		'transport'         => 'postMessage',
		'sanitize_callback' => 'poseidon_sanitize_select',
	) );

	$wp_customize->add_control( 'poseidon_theme_options[post_content]', array(
		'label'    => esc_html__( 'Blog Content', 'poseidon' ),
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
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'poseidon_theme_options[excerpt_length]', array(
		'label'    => esc_html__( 'Excerpt Length', 'poseidon' ),
		'section'  => 'poseidon_section_blog',
		'settings' => 'poseidon_theme_options[excerpt_length]',
		'type'     => 'text',
		'priority' => 50,
	) );

	// Add Setting and Control for Excerpt More Text.
	$wp_customize->add_setting( 'poseidon_theme_options[excerpt_more]', array(
		'default'           => '[...]',
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_attr',
	) );

	$wp_customize->add_control( 'poseidon_theme_options[excerpt_more]', array(
		'label'    => esc_html__( 'Excerpt More Text', 'poseidon' ),
		'section'  => 'poseidon_section_blog',
		'settings' => 'poseidon_theme_options[excerpt_more]',
		'type'     => 'text',
		'priority' => 60,
	) );

	// Add Partial for Blog Layout, Blog Display and Excerpt Length.
	$wp_customize->selective_refresh->add_partial( 'poseidon_blog_layout_partial', array(
		'selector'         => '.site-main .post-wrapper',
		'settings'         => array(
			'poseidon_theme_options[post_layout_archives]',
			'poseidon_theme_options[post_content]',
			'poseidon_theme_options[excerpt_length]',
			'poseidon_theme_options[excerpt_more]',
		),
		'render_callback'  => 'poseidon_customize_partial_blog_layout',
		'fallback_refresh' => false,
	) );

	// Add Setting and Control for Read More Text.
	$wp_customize->add_setting( 'poseidon_theme_options[read_more_text]', array(
		'default'           => esc_html__( 'Read more', 'poseidon' ),
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'poseidon_theme_options[read_more_text]', array(
		'label'    => esc_html__( 'Read More Text', 'poseidon' ),
		'section'  => 'poseidon_section_blog',
		'settings' => 'poseidon_theme_options[read_more_text]',
		'type'     => 'text',
		'priority' => 70,
	) );

	// Add Magazine Widgets Headline.
	$wp_customize->add_control( new Poseidon_Customize_Header_Control(
		$wp_customize, 'poseidon_theme_options[blog_magazine_widgets_title]', array(
			'label'    => esc_html__( 'Magazine Widgets', 'poseidon' ),
			'section'  => 'poseidon_section_blog',
			'settings' => array(),
			'priority' => 80,
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
		'priority' => 90,
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

/**
 * Render the blog layout for the selective refresh partial.
 */
function poseidon_customize_partial_blog_layout() {
	$theme_options = poseidon_theme_options();
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', esc_attr( $theme_options['post_content'] ) );
	}
}
