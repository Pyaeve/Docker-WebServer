<?php
/**
 * Pagination
 *
 * @package Parablog
 */

$wp_customize->add_section(
	'parablog_pagination',
	array(
		'panel' => 'parablog_theme_options',
		'title' => esc_html__( 'Pagination', 'parablog' ),
	)
);

// Pagination - Enable Pagination.
$wp_customize->add_setting(
	'parablog_enable_pagination',
	array(
		'default'           => true,
		'sanitize_callback' => 'parablog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Parablog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'parablog_enable_pagination',
		array(
			'label'    => esc_html__( 'Enable Pagination', 'parablog' ),
			'section'  => 'parablog_pagination',
			'settings' => 'parablog_enable_pagination',
			'type'     => 'checkbox',
		)
	)
);

// Pagination - Pagination Type.
$wp_customize->add_setting(
	'parablog_pagination_type',
	array(
		'default'           => 'default',
		'sanitize_callback' => 'parablog_sanitize_select',
	)
);

$wp_customize->add_control(
	'parablog_pagination_type',
	array(
		'label'           => esc_html__( 'Pagination Type', 'parablog' ),
		'section'         => 'parablog_pagination',
		'settings'        => 'parablog_pagination_type',
		'active_callback' => 'parablog_is_pagination_enabled',
		'type'            => 'select',
		'choices'         => array(
			'default' => __( 'Default (Older/Newer)', 'parablog' ),
			'numeric' => __( 'Numeric', 'parablog' ),
		),
	)
);
