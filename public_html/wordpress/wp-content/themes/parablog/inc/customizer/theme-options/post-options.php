<?php
/**
 * Post Options
 *
 * @package Parablog
 */

$wp_customize->add_section(
	'parablog_post_options',
	array(
		'title' => esc_html__( 'Post Options', 'parablog' ),
		'panel' => 'parablog_theme_options',
	)
);

// Post Options - Hide Date.
$wp_customize->add_setting(
	'parablog_post_hide_date',
	array(
		'default'           => false,
		'sanitize_callback' => 'parablog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Parablog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'parablog_post_hide_date',
		array(
			'label'   => esc_html__( 'Hide Date', 'parablog' ),
			'section' => 'parablog_post_options',
		)
	)
);

// Post Options - Hide Author.
$wp_customize->add_setting(
	'parablog_post_hide_author',
	array(
		'default'           => false,
		'sanitize_callback' => 'parablog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Parablog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'parablog_post_hide_author',
		array(
			'label'   => esc_html__( 'Hide Author', 'parablog' ),
			'section' => 'parablog_post_options',
		)
	)
);

// Post Options - Hide Category.
$wp_customize->add_setting(
	'parablog_post_hide_category',
	array(
		'default'           => false,
		'sanitize_callback' => 'parablog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Parablog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'parablog_post_hide_category',
		array(
			'label'   => esc_html__( 'Hide Category', 'parablog' ),
			'section' => 'parablog_post_options',
		)
	)
);

// Post Options - Hide Tag.
$wp_customize->add_setting(
	'parablog_post_hide_tags',
	array(
		'default'           => false,
		'sanitize_callback' => 'parablog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Parablog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'parablog_post_hide_tags',
		array(
			'label'   => esc_html__( 'Hide Tag', 'parablog' ),
			'section' => 'parablog_post_options',
		)
	)
);

// Post Options - Related Post Label.
$wp_customize->add_setting(
	'parablog_post_related_post_label',
	array(
		'default'           => __( 'Related Posts', 'parablog' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'parablog_post_related_post_label',
	array(
		'label'    => esc_html__( 'Related Posts Label', 'parablog' ),
		'section'  => 'parablog_post_options',
		'settings' => 'parablog_post_related_post_label',
		'type'     => 'text',
	)
);

// Post Options - Hide Related Posts.
$wp_customize->add_setting(
	'parablog_post_hide_related_posts',
	array(
		'default'           => false,
		'sanitize_callback' => 'parablog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Parablog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'parablog_post_hide_related_posts',
		array(
			'label'   => esc_html__( 'Hide Related Posts', 'parablog' ),
			'section' => 'parablog_post_options',
		)
	)
);
