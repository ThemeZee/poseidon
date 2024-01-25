<?php
/**
 * Post Settings
 *
 * Register Post Settings section, settings and controls for Theme Customizer
 *
 * @package Poseidon
 */

/**
 * Adds post settings in the Customizer
 *
 * @param object $wp_customize / Customizer Object.
 */
function poseidon_customize_register_post_settings( $wp_customize ) {

	// Add Section for Post Settings.
	$wp_customize->add_section(
		'poseidon_section_post',
		array(
			'title'    => esc_html__( 'Post Settings', 'poseidon' ),
			'priority' => 30,
			'panel'    => 'poseidon_options_panel',
		)
	);

	// Add Post Layout Settings for single posts.
	$wp_customize->add_setting(
		'poseidon_theme_options[post_layout_single]',
		array(
			'default'           => 'header',
			'type'              => 'option',
			'transport'         => 'refresh',
			'sanitize_callback' => 'poseidon_sanitize_select',
		)
	);

	$wp_customize->add_control(
		'poseidon_theme_options[post_layout_single]',
		array(
			'label'    => esc_html__( 'Single Post Layout', 'poseidon' ),
			'section'  => 'poseidon_section_post',
			'settings' => 'poseidon_theme_options[post_layout_single]',
			'type'     => 'select',
			'priority' => 10,
			'choices'  => array(
				'header' => esc_html__( 'Show featured image as header image', 'poseidon' ),
				'top'    => esc_html__( 'Show featured image above content', 'poseidon' ),
				'none'   => esc_html__( 'Hide featured image', 'poseidon' ),
			),
		)
	);

	// Add Post Details Headline.
	$wp_customize->add_control(
		new Poseidon_Customize_Header_Control(
			$wp_customize,
			'poseidon_theme_options[postmeta_headline]',
			array(
				'label'    => esc_html__( 'Post Details', 'poseidon' ),
				'section'  => 'poseidon_section_post',
				'settings' => array(),
				'priority' => 50,
			)
		)
	);

	// Add Meta Date setting and control.
	$wp_customize->add_setting(
		'poseidon_theme_options[meta_date]',
		array(
			'default'           => true,
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'poseidon_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'poseidon_theme_options[meta_date]',
		array(
			'label'    => esc_html__( 'Display date', 'poseidon' ),
			'section'  => 'poseidon_section_post',
			'settings' => 'poseidon_theme_options[meta_date]',
			'type'     => 'checkbox',
			'priority' => 60,
		)
	);

	// Add Meta Author setting and control.
	$wp_customize->add_setting(
		'poseidon_theme_options[meta_author]',
		array(
			'default'           => true,
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'poseidon_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'poseidon_theme_options[meta_author]',
		array(
			'label'    => esc_html__( 'Display author', 'poseidon' ),
			'section'  => 'poseidon_section_post',
			'settings' => 'poseidon_theme_options[meta_author]',
			'type'     => 'checkbox',
			'priority' => 70,
		)
	);

	// Add Meta Category setting and control.
	$wp_customize->add_setting(
		'poseidon_theme_options[meta_category]',
		array(
			'default'           => true,
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'poseidon_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'poseidon_theme_options[meta_category]',
		array(
			'label'    => esc_html__( 'Display categories', 'poseidon' ),
			'section'  => 'poseidon_section_post',
			'settings' => 'poseidon_theme_options[meta_category]',
			'type'     => 'checkbox',
			'priority' => 80,
		)
	);

	// Add Single Posts Headline.
	$wp_customize->add_control(
		new Poseidon_Customize_Header_Control(
			$wp_customize,
			'poseidon_theme_options[single_posts_headline]',
			array(
				'label'    => esc_html__( 'Single Posts', 'poseidon' ),
				'section'  => 'poseidon_section_post',
				'settings' => array(),
				'priority' => 90,
			)
		)
	);

	// Add Meta Tags setting and control.
	$wp_customize->add_setting(
		'poseidon_theme_options[meta_tags]',
		array(
			'default'           => false,
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'poseidon_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'poseidon_theme_options[meta_tags]',
		array(
			'label'    => esc_html__( 'Display tags', 'poseidon' ),
			'section'  => 'poseidon_section_post',
			'settings' => 'poseidon_theme_options[meta_tags]',
			'type'     => 'checkbox',
			'priority' => 100,
		)
	);

	// Add Post Navigation setting and control.
	$wp_customize->add_setting(
		'poseidon_theme_options[post_navigation]',
		array(
			'default'           => true,
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'poseidon_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'poseidon_theme_options[post_navigation]',
		array(
			'label'    => esc_html__( 'Display previous/next post navigation', 'poseidon' ),
			'section'  => 'poseidon_section_post',
			'settings' => 'poseidon_theme_options[post_navigation]',
			'type'     => 'checkbox',
			'priority' => 110,
		)
	);
}
add_action( 'customize_register', 'poseidon_customize_register_post_settings' );
