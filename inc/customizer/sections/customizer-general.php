<?php
/**
 * General Settings
 *
 * Register General section, settings and controls for Theme Customizer
 *
 * @package Poseidon
 */


/**
 * Adds all general settings to the Customizer
 *
 * @param object $wp_customize / Customizer Object
 */
function poseidon_customize_register_general_settings( $wp_customize ) {

	// Add Section for Theme Options
	$wp_customize->add_section( 'poseidon_section_general', array(
        'title'    => esc_html__( 'General Settings', 'poseidon' ),
        'priority' => 10,
		'panel' => 'poseidon_options_panel' 
		)
	);
	
	// Add Settings and Controls for Layout
	$wp_customize->add_setting( 'poseidon_theme_options[layout]', array(
        'default'           => 'right-sidebar',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'poseidon_sanitize_select'
		)
	);
    $wp_customize->add_control( 'poseidon_theme_options[layout]', array(
        'label'    => esc_html__( 'Theme Layout', 'poseidon' ),
        'section'  => 'poseidon_section_general',
        'settings' => 'poseidon_theme_options[layout]',
        'type'     => 'radio',
		'priority' => 1,
        'choices'  => array(
            'left-sidebar' => esc_html__( 'Left Sidebar', 'poseidon' ),
            'right-sidebar' => esc_html__( 'Right Sidebar', 'poseidon' )
			)
		)
	);
	
	// Add Sticky Navigation Setting
	$wp_customize->add_setting( 'poseidon_theme_options[sticky_nav_headline]', array(
        'default'           => '',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( new Poseidon_Customize_Header_Control(
        $wp_customize, 'poseidon_theme_options[sticky_nav_headline]', array(
            'label' => esc_html__( 'Sticky Navigation', 'poseidon' ),
            'section' => 'poseidon_section_general',
            'settings' => 'poseidon_theme_options[sticky_nav_headline]',
            'priority' => 2
            )
        )
    );
	$wp_customize->add_setting( 'poseidon_theme_options[sticky_nav]', array(
        'default'           => false,
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'poseidon_sanitize_checkbox'
		)
	);
    $wp_customize->add_control( 'poseidon_theme_options[sticky_nav]', array(
        'label'    => esc_html__( 'Enable sticky menu on large screens', 'poseidon' ),
        'section'  => 'poseidon_section_general',
        'settings' => 'poseidon_theme_options[sticky_nav]',
        'type'     => 'checkbox',
		'priority' => 3
		)
	);

	
}
add_action( 'customize_register', 'poseidon_customize_register_general_settings' );