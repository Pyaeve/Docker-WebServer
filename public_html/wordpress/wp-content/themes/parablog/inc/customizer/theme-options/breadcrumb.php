<?php
/**
 * Breadcrumb
 *
 * @package Parablog
 */

$wp_customize->add_section(
	'parablog_breadcrumb',
	array(
		'title' => esc_html__( 'Breadcrumb', 'parablog' ),
		'panel' => 'parablog_theme_options',
	)
);

// Breadcrumb - Enable Breadcrumb.
$wp_customize->add_setting(
	'parablog_enable_breadcrumb',
	array(
		'sanitize_callback' => 'parablog_sanitize_switch',
		'default'           => true,
	)
);

$wp_customize->add_control(
	new Parablog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'parablog_enable_breadcrumb',
		array(
			'label'   => esc_html__( 'Enable Breadcrumb', 'parablog' ),
			'section' => 'parablog_breadcrumb',
		)
	)
);

// Breadcrumb - Separator.
$wp_customize->add_setting(
	'parablog_breadcrumb_separator',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => '/',
	)
);

$wp_customize->add_control(
	'parablog_breadcrumb_separator',
	array(
		'label'           => esc_html__( 'Separator', 'parablog' ),
		'active_callback' => 'parablog_is_breadcrumb_enabled',
		'section'         => 'parablog_breadcrumb',
	)
);
