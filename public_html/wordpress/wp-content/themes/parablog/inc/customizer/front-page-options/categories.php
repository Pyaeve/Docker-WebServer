<?php
/**
 * Categories Section
 *
 * @package Parablog
 */

$wp_customize->add_section(
	'parablog_categories_section',
	array(
		'panel' => 'parablog_front_page_options',
		'title' => esc_html__( 'Categories Section', 'parablog' ),
	)
);

// Categories Section - Enable Section.
$wp_customize->add_setting(
	'parablog_enable_categories_section',
	array(
		'default'           => false,
		'sanitize_callback' => 'parablog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Parablog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'parablog_enable_categories_section',
		array(
			'label'    => esc_html__( 'Enable Categories Section', 'parablog' ),
			'section'  => 'parablog_categories_section',
			'settings' => 'parablog_enable_categories_section',
		)
	)
);

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'parablog_enable_categories_section',
		array(
			'selector' => '#parablog_categories_section .section-link',
			'settings' => 'parablog_enable_categories_section',
		)
	);
}

// Categories Section - Section Title.
$wp_customize->add_setting(
	'parablog_categories_title',
	array(
		'default'           => __( 'Categories', 'parablog' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'parablog_categories_title',
	array(
		'label'           => esc_html__( 'Section Title', 'parablog' ),
		'section'         => 'parablog_categories_section',
		'settings'        => 'parablog_categories_title',
		'type'            => 'text',
		'active_callback' => 'parablog_is_categories_section_enabled',
	)
);

for ( $i = 1; $i <= 4; $i++ ) {

	// Categories Section - Select Category.
	$wp_customize->add_setting(
		'parablog_categories_content_category_' . $i,
		array(
			'sanitize_callback' => 'parablog_sanitize_select',
		)
	);

	$wp_customize->add_control(
		'parablog_categories_content_category_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Select Category %d', 'parablog' ), $i ),
			'section'         => 'parablog_categories_section',
			'settings'        => 'parablog_categories_content_category_' . $i,
			'active_callback' => 'parablog_is_categories_section_enabled',
			'type'            => 'select',
			'choices'         => parablog_get_post_cat_choices(),
		)
	);

	// Categories Section - Category Image.
	$wp_customize->add_setting(
		'parablog_category_category_image_' . $i,
		array(
			'sanitize_callback' => 'parablog_sanitize_image',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'parablog_category_category_image_' . $i,
			array(
				'label'           => sprintf( esc_html__( 'Category Image %d', 'parablog' ), $i ),
				'section'         => 'parablog_categories_section',
				'settings'        => 'parablog_category_category_image_' . $i,
				'active_callback' => 'parablog_is_categories_section_enabled',
			)
		)
	);

}
