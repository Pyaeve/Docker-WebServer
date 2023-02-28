<?php
/**
 * Banner Section
 *
 * @package Parablog
 */

$wp_customize->add_section(
	'parablog_banner_section',
	array(
		'panel' => 'parablog_front_page_options',
		'title' => esc_html__( 'Banner Section', 'parablog' ),
	)
);

// Banner Section - Enable Section.
$wp_customize->add_setting(
	'parablog_enable_banner_section',
	array(
		'default'           => false,
		'sanitize_callback' => 'parablog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Parablog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'parablog_enable_banner_section',
		array(
			'label'    => esc_html__( 'Enable Banner Section', 'parablog' ),
			'section'  => 'parablog_banner_section',
			'settings' => 'parablog_enable_banner_section',
		)
	)
);

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'parablog_enable_banner_section',
		array(
			'selector' => '#parablog_banner_section .section-link',
			'settings' => 'parablog_enable_banner_section',
		)
	);
}

// Banner Section - Banner Slider Content Type.
$wp_customize->add_setting(
	'parablog_banner_slider_content_type',
	array(
		'default'           => 'post',
		'sanitize_callback' => 'parablog_sanitize_select',
	)
);

$wp_customize->add_control(
	'parablog_banner_slider_content_type',
	array(
		'label'           => esc_html__( 'Select Banner Slider Content Type', 'parablog' ),
		'section'         => 'parablog_banner_section',
		'settings'        => 'parablog_banner_slider_content_type',
		'type'            => 'select',
		'active_callback' => 'parablog_is_banner_slider_section_enabled',
		'choices'         => array(
			'page' => esc_html__( 'Page', 'parablog' ),
			'post' => esc_html__( 'Post', 'parablog' ),
		),
	)
);

for ( $i = 1; $i <= 4; $i++ ) {
	// Banner Section - Select Banner Post.
	$wp_customize->add_setting(
		'parablog_banner_slider_content_post_' . $i,
		array(
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'parablog_banner_slider_content_post_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Select Post %d', 'parablog' ), $i ),
			'section'         => 'parablog_banner_section',
			'settings'        => 'parablog_banner_slider_content_post_' . $i,
			'active_callback' => 'parablog_is_banner_slider_section_and_content_type_post_enabled',
			'type'            => 'select',
			'choices'         => parablog_get_post_choices(),
		)
	);

	// Banner Section - Select Banner Page.
	$wp_customize->add_setting(
		'parablog_banner_slider_content_page_' . $i,
		array(
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'parablog_banner_slider_content_page_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Select Page %d', 'parablog' ), $i ),
			'section'         => 'parablog_banner_section',
			'settings'        => 'parablog_banner_slider_content_page_' . $i,
			'active_callback' => 'parablog_is_banner_slider_section_and_content_type_page_enabled',
			'type'            => 'select',
			'choices'         => parablog_get_page_choices(),
		)
	);

}
