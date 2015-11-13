<?php
/**
 * General Settings
 *
 * Register General section, settings and controls for Theme Customizer
 *
 * @package Neptune
 */


/**
 * Adds all general settings to the Customizer
 *
 * @param object $wp_customize / Customizer Object
 */
function neptune_customize_register_general_settings( $wp_customize ) {

	// Add Section for Theme Options
	$wp_customize->add_section( 'neptune_section_general', array(
        'title'    => esc_html__( 'General Settings', 'neptune' ),
        'priority' => 10,
		'panel' => 'neptune_options_panel' 
		)
	);
	
	// Add Settings and Controls for Layout
	$wp_customize->add_setting( 'neptune_theme_options[layout]', array(
        'default'           => 'right-sidebar',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'neptune_sanitize_layout'
		)
	);
    $wp_customize->add_control( 'neptune_control_layout', array(
        'label'    => esc_html__( 'Theme Layout', 'neptune' ),
        'section'  => 'neptune_section_general',
        'settings' => 'neptune_theme_options[layout]',
        'type'     => 'radio',
		'priority' => 1,
        'choices'  => array(
            'left-sidebar' => esc_html__( 'Left Sidebar', 'neptune' ),
            'right-sidebar' => esc_html__( 'Right Sidebar', 'neptune' )
			)
		)
	);
	
}
add_action( 'customize_register', 'neptune_customize_register_general_settings' );