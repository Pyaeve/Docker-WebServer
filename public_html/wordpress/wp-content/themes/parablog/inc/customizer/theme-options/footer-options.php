<?php
/**
 * Footer Options
 *
 * @package Parablog
 */

$wp_customize->add_section(
	'parablog_footer_options',
	array(
		'panel' => 'parablog_theme_options',
		'title' => esc_html__( 'Footer Options', 'parablog' ),
	)
);

// Footer Options - Copyright Text.
/* translators: 1: Year, 2: Site Title with home URL. */
$copyright_default = sprintf( esc_html_x( 'Copyright &copy; %1$s %2$s', '1: Year, 2: Site Title with home URL', 'parablog' ), '[the-year]', '[site-link]' );
$wp_customize->add_setting(
	'parablog_footer_copyright_text',
	array(
		'default'           => $copyright_default,
		'sanitize_callback' => 'wp_kses_post',
	)
);

$wp_customize->add_control(
	'parablog_footer_copyright_text',
	array(
		'label'    => esc_html__( 'Copyright Text', 'parablog' ),
		'section'  => 'parablog_footer_options',
		'settings' => 'parablog_footer_copyright_text',
		'type'     => 'textarea',
	)
);

// Footer Options - Scroll Top.
$wp_customize->add_setting(
	'parablog_scroll_top',
	array(
		'sanitize_callback' => 'parablog_sanitize_switch',
		'default'           => true,
	)
);

$wp_customize->add_control(
	new Parablog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'parablog_scroll_top',
		array(
			'label'   => esc_html__( 'Enable Scroll Top Button', 'parablog' ),
			'section' => 'parablog_footer_options',
		)
	)
);
