<?php
/**
 * Typography
 *
 * @package Parablog
 */

$wp_customize->add_section(
	'parablog_typography',
	array(
		'panel' => 'parablog_theme_options',
		'title' => esc_html__( 'Typography', 'parablog' ),
	)
);

// Typography - Site Title Font.
$wp_customize->add_setting(
	'parablog_site_title_font',
	array(
		'default'           => 'Catamaran',
		'sanitize_callback' => 'parablog_sanitize_google_fonts',
	)
);

$wp_customize->add_control(
	'parablog_site_title_font',
	array(
		'label'    => esc_html__( 'Site Title Font Family', 'parablog' ),
		'section'  => 'parablog_typography',
		'settings' => 'parablog_site_title_font',
		'type'     => 'select',
		'choices'  => parablog_get_all_google_font_families(),
	)
);

// Typography - Site Description Font.
$wp_customize->add_setting(
	'parablog_site_description_font',
	array(
		'default'           => 'Nanum Gothic',
		'sanitize_callback' => 'parablog_sanitize_google_fonts',
	)
);

$wp_customize->add_control(
	'parablog_site_description_font',
	array(
		'label'    => esc_html__( 'Site Description Font Family', 'parablog' ),
		'section'  => 'parablog_typography',
		'settings' => 'parablog_site_description_font',
		'type'     => 'select',
		'choices'  => parablog_get_all_google_font_families(),
	)
);

// Typography - Header Font.
$wp_customize->add_setting(
	'parablog_header_font',
	array(
		'default'           => 'Catamaran',
		'sanitize_callback' => 'parablog_sanitize_google_fonts',
	)
);

$wp_customize->add_control(
	'parablog_header_font',
	array(
		'label'    => esc_html__( 'Header Font Family', 'parablog' ),
		'section'  => 'parablog_typography',
		'settings' => 'parablog_header_font',
		'type'     => 'select',
		'choices'  => parablog_get_all_google_font_families(),
	)
);

// Typography - Body Font.
$wp_customize->add_setting(
	'parablog_body_font',
	array(
		'default'           => 'Nanum Gothic',
		'sanitize_callback' => 'parablog_sanitize_google_fonts',
	)
);

$wp_customize->add_control(
	'parablog_body_font',
	array(
		'label'    => esc_html__( 'Body Font Family', 'parablog' ),
		'section'  => 'parablog_typography',
		'settings' => 'parablog_body_font',
		'type'     => 'select',
		'choices'  => parablog_get_all_google_font_families(),
	)
);
