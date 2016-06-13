<?php
/**
 * Pro Version Upgrade Section
 *
 * Registers Upgrade Section for the Pro Version of the theme
 *
 * @package Poseidon
 */

/**
 * Adds pro version description and CTA button
 *
 * @param object $wp_customize / Customizer Object.
 */
function poseidon_customize_register_upgrade_settings( $wp_customize ) {

	// Add Upgrade / More Features Section.
	$wp_customize->add_section( 'poseidon_section_upgrade', array(
		'title'    => esc_html__( 'More Features', 'poseidon' ),
		'priority' => 70,
		'panel' => 'poseidon_options_panel',
		)
	);

	// Add custom Upgrade Content control.
	$wp_customize->add_setting( 'poseidon_theme_options[upgrade]', array(
		'default'           => '',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'esc_attr',
		)
	);
	$wp_customize->add_control( new Poseidon_Customize_Upgrade_Control(
		$wp_customize, 'poseidon_theme_options[upgrade]', array(
		'section' => 'poseidon_section_upgrade',
		'settings' => 'poseidon_theme_options[upgrade]',
		'priority' => 1,
		)
	) );

}
add_action( 'customize_register', 'poseidon_customize_register_upgrade_settings' );
