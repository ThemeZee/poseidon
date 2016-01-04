<?php
/**
 * Post Images Settings
 *
 * Register images section, settings and controls for Theme Customizer
 *
 * @package Poseidon
 */


/**
 * Adds featured image settings to the Customizer
 *
 * @param object $wp_customize / Customizer Object
 */
function poseidon_customize_register_post_image_settings( $wp_customize ) {

	// Add Sections for Post Settings
	$wp_customize->add_section( 'poseidon_section_images', array(
        'title'    => esc_html__( 'Post Images', 'poseidon' ),
        'priority' => 50,
		'panel' => 'poseidon_options_panel' 
		)
	);

	// Add Post Images Settings for archive posts
	$wp_customize->add_setting( 'poseidon_theme_options[post_layout_archives]', array(
        'default'           => 'left',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'poseidon_sanitize_select'
		)
	);
    $wp_customize->add_control( 'poseidon_theme_options[post_layout_archives]', array(
        'label'    => esc_html__( 'Post Images (archive pages)', 'poseidon' ),
        'section'  => 'poseidon_section_images',
        'settings' => 'poseidon_theme_options[post_layout_archives]',
        'type'     => 'radio',
		'priority' => 1,
        'choices'  => array(
            'left' => esc_html__( 'Show featured image beside content.', 'poseidon' ),
            'top' => esc_html__( 'Show featured image above content.', 'poseidon' ),
			'none' => esc_html__( 'Hide featured image.', 'poseidon' )
			)
		)
	);
	
	// Add Post Images Settings for single posts
	$wp_customize->add_setting( 'poseidon_theme_options[post_image_single_header]', array(
        'default'           => '',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( new Poseidon_Customize_Header_Control(
        $wp_customize, 'poseidon_theme_options[post_image_single_header]', array(
            'label' => esc_html__( 'Post Image (single posts)', 'poseidon' ),
            'section' => 'poseidon_section_images',
            'settings' => 'poseidon_theme_options[post_image_single_header]',
            'priority' => 2
            )
        )
    );
	$wp_customize->add_setting( 'poseidon_theme_options[post_image_single]', array(
        'default'           => true,
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'poseidon_sanitize_checkbox'
		)
	);
    $wp_customize->add_control( 'poseidon_theme_options[post_image_single]', array(
        'label'    => esc_html__( 'Show featured image on single posts.', 'poseidon' ),
        'section'  => 'poseidon_section_images',
        'settings' => 'poseidon_theme_options[post_image_single]',
        'type'     => 'checkbox',
		'priority' => 3
		)
	);

}
add_action( 'customize_register', 'poseidon_customize_register_post_image_settings' );