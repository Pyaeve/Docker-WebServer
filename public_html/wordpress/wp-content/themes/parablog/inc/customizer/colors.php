<?php
/**
 * Color Option
 *
 * @package Parablog
 */

// Primary Color.
$wp_customize->add_setting(
	'primary_color',
	array(
		'default'           => '#24c4f8',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'primary_color',
		array(
			'label'    => __( 'Primary Color', 'parablog' ),
			'section'  => 'colors',
			'priority' => 5,
		)
	)
);
