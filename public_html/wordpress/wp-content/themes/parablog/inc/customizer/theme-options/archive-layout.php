<?php
/**
 * Archive Layout
 *
 * @package Parablog
 */

$wp_customize->add_section(
	'parablog_archive_layout',
	array(
		'title' => esc_html__( 'Archive Layout', 'parablog' ),
		'panel' => 'parablog_theme_options',
	)
);

// Archive Layout - Post Display Style.
$wp_customize->add_setting(
	'parablog_archive_style',
	array(
		'default'           => 'grid-layout',
		'sanitize_callback' => 'parablog_sanitize_select',
	)
);

$wp_customize->add_control(
	'parablog_archive_style',
	array(
		'label'   => esc_html__( 'Post Display Style', 'parablog' ),
		'section' => 'parablog_archive_layout',
		'type'    => 'select',
		'choices' => array(
			'grid-layout' => __( 'Grid Layout', 'parablog' ),
			'list-layout' => __( 'List Layout', 'parablog' ),
		),
	)
);
