<?php
/**
 * Sidebar Position
 *
 * @package Parablog
 */

$wp_customize->add_section(
	'parablog_sidebar_position',
	array(
		'title' => esc_html__( 'Sidebar Position', 'parablog' ),
		'panel' => 'parablog_theme_options',
	)
);

// Sidebar Position - Global Sidebar Position.
$wp_customize->add_setting(
	'parablog_sidebar_position',
	array(
		'sanitize_callback' => 'parablog_sanitize_select',
		'default'           => 'right-sidebar',
	)
);

$wp_customize->add_control(
	'parablog_sidebar_position',
	array(
		'label'   => esc_html__( 'Global Sidebar Position', 'parablog' ),
		'section' => 'parablog_sidebar_position',
		'type'    => 'select',
		'choices' => array(
			'right-sidebar' => esc_html__( 'Right Sidebar', 'parablog' ),
			'left-sidebar'  => esc_html__( 'Left Sidebar', 'parablog' ),
			'no-sidebar'    => esc_html__( 'No Sidebar', 'parablog' ),
		),
	)
);

// Sidebar Position - Post Sidebar Position.
$wp_customize->add_setting(
	'parablog_post_sidebar_position',
	array(
		'sanitize_callback' => 'parablog_sanitize_select',
		'default'           => 'right-sidebar',
	)
);

$wp_customize->add_control(
	'parablog_post_sidebar_position',
	array(
		'label'   => esc_html__( 'Post Sidebar Position', 'parablog' ),
		'section' => 'parablog_sidebar_position',
		'type'    => 'select',
		'choices' => array(
			'right-sidebar' => esc_html__( 'Right Sidebar', 'parablog' ),
			'left-sidebar'  => esc_html__( 'Left Sidebar', 'parablog' ),
			'no-sidebar'    => esc_html__( 'No Sidebar', 'parablog' ),
		),
	)
);

// Sidebar Position - Page Sidebar Position.
$wp_customize->add_setting(
	'parablog_page_sidebar_position',
	array(
		'sanitize_callback' => 'parablog_sanitize_select',
		'default'           => 'right-sidebar',
	)
);

$wp_customize->add_control(
	'parablog_page_sidebar_position',
	array(
		'label'   => esc_html__( 'Page Sidebar Position', 'parablog' ),
		'section' => 'parablog_sidebar_position',
		'type'    => 'select',
		'choices' => array(
			'right-sidebar' => esc_html__( 'Right Sidebar', 'parablog' ),
			'left-sidebar'  => esc_html__( 'Left Sidebar', 'parablog' ),
			'no-sidebar'    => esc_html__( 'No Sidebar', 'parablog' ),
		),
	)
);
