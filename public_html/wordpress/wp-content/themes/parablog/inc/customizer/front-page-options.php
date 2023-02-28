<?php
/**
 * Front Page Options
 *
 * @package Parablog
 */

$wp_customize->add_panel(
	'parablog_front_page_options',
	array(
		'title'    => esc_html__( 'Front Page Options', 'parablog' ),
		'priority' => 130,
	)
);

// Banner Section.
require get_template_directory() . '/inc/customizer/front-page-options/banner.php';

// Categories Section.
require get_template_directory() . '/inc/customizer/front-page-options/categories.php';
