<?php

// Author Info Widget.
require get_template_directory() . '/inc/widgets/info-author-widget.php';

// Trending Posts Carousel Widgets.
require get_template_directory() . '/inc/widgets/trending-posts-carousel-widget.php';

// Social Icons Widget.
require get_template_directory() . '/inc/widgets/social-icons-widget.php';

/**
 * Register Widgets
 */
function parablog_register_widgets() {

	register_widget( 'Parablog_Author_Info_Widget' );

	register_widget( 'Parablog_Trending_Posts_Carousel_Widget' );

	register_widget( 'Parablog_Social_Icons_Widget' );

}
add_action( 'widgets_init', 'parablog_register_widgets' );
