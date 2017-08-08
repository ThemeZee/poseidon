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
		'panel' => 'poseidon_options_panel',
	) );

	// Add Blog Title setting and control.
	$wp_customize->add_setting( 'poseidon_theme_options[latest_posts_title]', array(
		'default'           => '',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'wp_kses_post',
	) );

	$wp_customize->add_control( 'poseidon_theme_options[latest_posts_title]', array(
		'label'    => esc_html__( 'Blog Title', 'poseidon' ),
		'section'  => 'poseidon_section_blog',
		'settings' => 'poseidon_theme_options[latest_posts_title]',
		'type'     => 'text',
		'priority' => 10,
	) );

	// Add Post Layout Settings for archive posts.
	$wp_customize->add_setting( 'poseidon_theme_options[post_layout_archives]', array(
		'default'           => 'left',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'poseidon_sanitize_select',
	) );

	$wp_customize->add_control( 'poseidon_theme_options[post_layout_archives]', array(
		'label'    => esc_html__( 'Blog Layout', 'poseidon' ),
		'section'  => 'poseidon_section_blog',
		'settings' => 'poseidon_theme_options[post_layout_archives]',
		'type'     => 'select',
		'priority' => 20,
		'choices'  => array(
			'left' => esc_html__( 'Show featured image beside content', 'poseidon' ),
			'top'  => esc_html__( 'Show featured image above content', 'poseidon' ),
			'none' => esc_html__( 'Hide featured image', 'poseidon' ),
		),
	) );

	// Add Settings and Controls for post content.
	$wp_customize->add_setting( 'poseidon_theme_options[post_content]', array(
		'default'           => 'excerpt',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'poseidon_sanitize_select',
	) );

	$wp_customize->add_control( 'poseidon_theme_options[post_content]', array(
		'label'    => esc_html__( 'Post length on archives', 'poseidon' ),
		'section'  => 'poseidon_section_blog',
		'settings' => 'poseidon_theme_options[post_content]',
		'type'     => 'radio',
		'priority' => 30,
		'choices'  => array(
			'index'   => esc_html__( 'Show full posts', 'poseidon' ),
			'excerpt' => esc_html__( 'Show post excerpts', 'poseidon' ),
		),
	) );

	// Add Setting and Control for Excerpt Length.
	$wp_customize->add_setting( 'poseidon_theme_options[excerpt_length]', array(
		'default'           => 30,
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'poseidon_theme_options[excerpt_length]', array(
		'label'           => esc_html__( 'Excerpt Length', 'poseidon' ),
		'section'         => 'poseidon_section_blog',
		'settings'        => 'poseidon_theme_options[excerpt_length]',
		'type'            => 'text',
		'active_callback' => 'poseidon_control_post_content_callback',
		'priority' => 40,
	) );

	// Add Magazine Widgets Headline.
	$wp_customize->add_control( new Poseidon_Customize_Header_Control(
		$wp_customize, 'poseidon_theme_options[blog_magazine_widgets_title]', array(
			'label'    => esc_html__( 'Magazine Widgets', 'poseidon' ),
			'section'  => 'poseidon_section_blog',
			'settings' => array(),
			'priority' => 50,
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
		'priority' => 60,
	) );
}
add_action( 'customize_register', 'poseidon_customize_register_blog_settings' );
