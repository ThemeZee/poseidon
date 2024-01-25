<?php
/**
 * Slider Settings
 *
 * Register Post Slider section, settings and controls for Theme Customizer
 *
 * @package Poseidon
 */

/**
 * Adds slider settings in the Customizer
 *
 * @param object $wp_customize / Customizer Object.
 */
function poseidon_customize_register_slider_settings( $wp_customize ) {

	// Add Sections for Slider Settings.
	$wp_customize->add_section(
		'poseidon_section_slider',
		array(
			'title'    => esc_html__( 'Post Slider', 'poseidon' ),
			'priority' => 60,
			'panel'    => 'poseidon_options_panel',
		)
	);

	// Add settings and controls for Post Slider.
	$wp_customize->add_setting(
		'poseidon_theme_options[slider_activate]',
		array(
			'default'           => '',
			'type'              => 'option',
			'transport'         => 'refresh',
			'sanitize_callback' => 'esc_attr',
		)
	);
	$wp_customize->add_control(
		new Poseidon_Customize_Header_Control(
			$wp_customize,
			'poseidon_theme_options[slider_activate]',
			array(
				'label'    => esc_html__( 'Activate Post Slider', 'poseidon' ),
				'section'  => 'poseidon_section_slider',
				'settings' => 'poseidon_theme_options[slider_activate]',
				'priority' => 1,
			)
		)
	);
	$wp_customize->add_setting(
		'poseidon_theme_options[slider_magazine]',
		array(
			'default'           => false,
			'type'              => 'option',
			'transport'         => 'refresh',
			'sanitize_callback' => 'poseidon_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'poseidon_theme_options[slider_magazine]',
		array(
			'label'    => esc_html__( 'Show Slider on Magazine Homepage', 'poseidon' ),
			'section'  => 'poseidon_section_slider',
			'settings' => 'poseidon_theme_options[slider_magazine]',
			'type'     => 'checkbox',
			'priority' => 2,
		)
	);
	$wp_customize->add_setting(
		'poseidon_theme_options[slider_blog]',
		array(
			'default'           => false,
			'type'              => 'option',
			'transport'         => 'refresh',
			'sanitize_callback' => 'poseidon_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'poseidon_theme_options[slider_blog]',
		array(
			'label'    => esc_html__( 'Show Slider on posts page', 'poseidon' ),
			'section'  => 'poseidon_section_slider',
			'settings' => 'poseidon_theme_options[slider_blog]',
			'type'     => 'checkbox',
			'priority' => 3,
		)
	);

	// Add Setting and Control for Slider Category.
	$wp_customize->add_setting(
		'poseidon_theme_options[slider_category]',
		array(
			'default'           => 0,
			'type'              => 'option',
			'transport'         => 'refresh',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		new Poseidon_Customize_Category_Dropdown_Control(
			$wp_customize,
			'poseidon_theme_options[slider_category]',
			array(
				'label'           => esc_html__( 'Slider Category', 'poseidon' ),
				'section'         => 'poseidon_section_slider',
				'settings'        => 'poseidon_theme_options[slider_category]',
				'active_callback' => 'poseidon_slider_activated_callback',
				'priority'        => 4,
			)
		)
	);

	// Add Setting and Control for Number of Posts.
	$wp_customize->add_setting(
		'poseidon_theme_options[slider_limit]',
		array(
			'default'           => 8,
			'type'              => 'option',
			'transport'         => 'refresh',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'poseidon_theme_options[slider_limit]',
		array(
			'label'           => esc_html__( 'Number of Posts', 'poseidon' ),
			'section'         => 'poseidon_section_slider',
			'settings'        => 'poseidon_theme_options[slider_limit]',
			'type'            => 'text',
			'active_callback' => 'poseidon_slider_activated_callback',
			'priority'        => 5,
		)
	);

	// Add Setting and Control for Slider Animation.
	$wp_customize->add_setting(
		'poseidon_theme_options[slider_animation]',
		array(
			'default'           => 'slide',
			'type'              => 'option',
			'transport'         => 'refresh',
			'sanitize_callback' => 'poseidon_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'poseidon_theme_options[slider_animation]',
		array(
			'label'           => esc_html__( 'Slider Animation', 'poseidon' ),
			'section'         => 'poseidon_section_slider',
			'settings'        => 'poseidon_theme_options[slider_animation]',
			'type'            => 'radio',
			'priority'        => 6,
			'active_callback' => 'poseidon_slider_activated_callback',
			'choices'         => array(
				'slide' => esc_html__( 'Slide Effect', 'poseidon' ),
				'fade'  => esc_html__( 'Fade Effect', 'poseidon' ),
			),
		)
	);

	// Add Setting and Control for Slider Speed.
	$wp_customize->add_setting(
		'poseidon_theme_options[slider_speed]',
		array(
			'default'           => 7000,
			'type'              => 'option',
			'transport'         => 'refresh',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'poseidon_theme_options[slider_speed]',
		array(
			'label'           => esc_html__( 'Slider Speed (in ms)', 'poseidon' ),
			'section'         => 'poseidon_section_slider',
			'settings'        => 'poseidon_theme_options[slider_speed]',
			'type'            => 'number',
			'active_callback' => 'poseidon_slider_activated_callback',
			'priority'        => 7,
			'input_attrs'     => array(
				'min'  => 1000,
				'step' => 100,
			),
		)
	);

}
add_action( 'customize_register', 'poseidon_customize_register_slider_settings' );
