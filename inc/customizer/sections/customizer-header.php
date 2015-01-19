<?php
/**
 * Register Header Content section, settings and controls for Theme Customizer
 *
 */

// Add Theme Colors section to Customizer
add_action( 'customize_register', 'leeway_customize_register_header_settings' );

function leeway_customize_register_header_settings( $wp_customize ) {

	// Add Sections for Header Content
	$wp_customize->add_section( 'leeway_section_header', array(
        'title'    => __( 'Header Settings', 'leeway' ),
        'priority' => 20,
		'panel' => 'leeway_options_panel' 
		)
	);

	// Add Header Content Header
	$wp_customize->add_setting( 'leeway_theme_options[header_content]', array(
        'default'           => '',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( new Leeway_Customize_Header_Control(
        $wp_customize, 'leeway_control_header_content', array(
            'label' => __( 'Header Content', 'leeway' ),
            'section' => 'leeway_section_header',
            'settings' => 'leeway_theme_options[header_content]',
            'priority' => 2
            )
        )
    );
	$wp_customize->add_setting( 'leeway_theme_options[header_content_description]', array(
        'default'           => '',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( new Leeway_Customize_Description_Control(
        $wp_customize, 'leeway_control_header_content_description', array(
            'label' =>  __( 'The Header Content configured below will be displayed on the right hand side of the header area.', 'leeway' ),
            'section' => 'leeway_section_header',
            'settings' => 'leeway_theme_options[header_content_description]',
            'priority' => 3
            )
        )
    );

	// Add Settings and Controls for Header
	$wp_customize->add_setting( 'leeway_theme_options[header_search]', array(
        'default'           => false,
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'leeway_sanitize_checkbox'
		)
	);
    $wp_customize->add_control( 'leeway_control_header_search', array(
        'label'    => __( 'Display search field on header area', 'leeway' ),
        'section'  => 'leeway_section_header',
        'settings' => 'leeway_theme_options[header_search]',
        'type'     => 'checkbox',
		'priority' => 4
		)
	);

	$wp_customize->add_setting( 'leeway_theme_options[header_icons]', array(
        'default'           => false,
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'leeway_sanitize_checkbox'
		)
	);
    $wp_customize->add_control( 'leeway_control_header_icons', array(
        'label'    => __( 'Display Social Icons on header area', 'leeway' ),
        'section'  => 'leeway_section_header',
        'settings' => 'leeway_theme_options[header_icons]',
        'type'     => 'checkbox',
		'priority' => 5
		)
	);
	
}

?>