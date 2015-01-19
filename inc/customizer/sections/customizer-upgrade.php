<?php
/**
 * Register PRO Version section, settings and controls for Theme Customizer
 *
 */

// Add Theme Colors section to Customizer
add_action( 'customize_register', 'leeway_customize_register_upgrade_settings' );

function leeway_customize_register_upgrade_settings( $wp_customize ) {

	// Add Sections for Post Settings
	$wp_customize->add_section( 'leeway_section_upgrade', array(
        'title'    => __( 'Leeway Pro', 'leeway' ),
        'priority' => 70,
		'panel' => 'leeway_options_panel' 
		)
	);

	// Add PRO Version Section
	$wp_customize->add_setting( 'leeway_theme_options[pro_version_label]', array(
        'default'           => '',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( new Leeway_Customize_Header_Control(
        $wp_customize, 'leeway_control_pro_version_label', array(
            'label' => __( 'Need more features?', 'leeway' ),
            'section' => 'leeway_section_upgrade',
            'settings' => 'leeway_theme_options[pro_version_label]',
            'priority' => 	1
            )
        )
    );
	$wp_customize->add_setting( 'leeway_theme_options[pro_version]', array(
        'default'           => '',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( new Leeway_Customize_Text_Control(
        $wp_customize, 'leeway_control_pro_version', array(
            'label' =>  __( 'Check out the PRO version which comes with additional features and advanced customization options.', 'leeway' ),
            'section' => 'leeway_section_upgrade',
            'settings' => 'leeway_theme_options[pro_version]',
            'priority' => 	2
            )
        )
    );
	$wp_customize->add_setting( 'leeway_theme_options[pro_version_button]', array(
        'default'           => '',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( new Leeway_Customize_Button_Control(
        $wp_customize, 'leeway_control_pro_version_button', array(
            'label' => __('Learn more about Leeway Pro', 'leeway'),
			'section' => 'leeway_section_upgrade',
            'settings' => 'leeway_theme_options[pro_version_button]',
            'priority' => 	3
            )
        )
    );

}

?>