<?php
/**
 * Excerpt
 *
 * @package Parablog
 */

$wp_customize->add_section(
	'parablog_excerpt_options',
	array(
		'panel' => 'parablog_theme_options',
		'title' => esc_html__( 'Excerpt', 'parablog' ),
	)
);

// Excerpt - Excerpt Length.
$wp_customize->add_setting(
	'parablog_excerpt_length',
	array(
		'default'           => 20,
		'sanitize_callback' => 'parablog_sanitize_number_range',
		'validate_callback' => 'parablog_validate_excerpt_length',
	)
);

$wp_customize->add_control(
	'parablog_excerpt_length',
	array(
		'label'       => esc_html__( 'Excerpt Length (no. of words)', 'parablog' ),
		'section'     => 'parablog_excerpt_options',
		'settings'    => 'parablog_excerpt_length',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 1,
			'max'  => 100,
			'step' => 1,
		),
	)
);
