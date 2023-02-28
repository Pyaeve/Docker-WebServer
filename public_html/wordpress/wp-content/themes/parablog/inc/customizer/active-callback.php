<?php

/**
 * Active Callbacks
 *
 * @package Parablog
 */

// Theme Options.
function parablog_is_pagination_enabled( $control ) {
	return ( $control->manager->get_setting( 'parablog_enable_pagination' )->value() );
}
function parablog_is_breadcrumb_enabled( $control ) {
	return ( $control->manager->get_setting( 'parablog_enable_breadcrumb' )->value() );
}

// Banner Slider Section.
function parablog_is_banner_slider_section_enabled( $control ) {
	return ( $control->manager->get_setting( 'parablog_enable_banner_section' )->value() );
}
function parablog_is_banner_slider_section_and_content_type_post_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'parablog_banner_slider_content_type' )->value();
	return ( parablog_is_banner_slider_section_enabled( $control ) && ( 'post' === $content_type ) );
}
function parablog_is_banner_slider_section_and_content_type_page_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'parablog_banner_slider_content_type' )->value();
	return ( parablog_is_banner_slider_section_enabled( $control ) && ( 'page' === $content_type ) );
}

// Categories Section.
function parablog_is_categories_section_enabled( $control ) {
	return ( $control->manager->get_setting( 'parablog_enable_categories_section' )->value() );
}
