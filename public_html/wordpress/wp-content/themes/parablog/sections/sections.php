<?php
/**
 * Render homepage sections.
 */

function parablog_homepage_sections() {

	$homepage_sections = array_keys( parablog_get_homepage_sections() );

	foreach ( $homepage_sections as $section ) {
		require get_template_directory() . '/sections/' . $section . '.php';
	}

}
