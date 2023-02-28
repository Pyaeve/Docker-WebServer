<?php

/**
 * Dynamic CSS
 */
function parablog_dynamic_css() {

	$primary_color         = get_theme_mod( 'primary_color', '#24c4f8' );
	$site_title_font       = get_theme_mod( 'parablog_site_title_font', 'Catamaran' );
	$site_description_font = get_theme_mod( 'parablog_site_description_font', 'Nanum Gothic' );
	$header_font           = get_theme_mod( 'parablog_header_font', 'Catamaran' );
	$body_font             = get_theme_mod( 'parablog_body_font', 'Nanum Gothic' );

	$custom_css  = '';
	$custom_css .= '
    /* Color */
    :root {
        --primary-color: ' . esc_attr( $primary_color ) . ';
        --header-text-color: ' . esc_attr( '#' . get_header_textcolor() ) . ';
    }
    ';

	$custom_css .= '
    /* Typograhpy */
    :root {
        --font-heading: "' . esc_attr( $header_font ) . '", serif;
        --font-main: -apple-system, BlinkMacSystemFont,"' . esc_attr( $body_font ) . '", "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
    }

    body,
	button, input, select, optgroup, textarea {
        font-family: "' . esc_attr( $body_font ) . '", serif;
	}

	.site-title a {
        font-family: "' . esc_attr( $site_title_font ) . '", serif;
	}
    
	.site-description {
        font-family: "' . esc_attr( $site_description_font ) . '", serif;
	}
    ';

	wp_add_inline_style( 'parablog-style', $custom_css );

}
add_action( 'wp_enqueue_scripts', 'parablog_dynamic_css', 99 );
