<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Parablog
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function parablog_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	$classes[] = parablog_sidebar_layout();

	$classes[] = 'parallax-body';

	$classes[] = 'light-theme';

	return $classes;
}
add_filter( 'body_class', 'parablog_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function parablog_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'parablog_pingback_header' );


/**
 * Get all posts for customizer Post content type.
 */
function parablog_get_post_choices() {
	$choices = array( '' => esc_html__( '--Select--', 'parablog' ) );
	$args    = array( 'numberposts' => -1 );
	$posts   = get_posts( $args );

	foreach ( $posts as $post ) {
		$id             = $post->ID;
		$title          = $post->post_title;
		$choices[ $id ] = $title;
	}

	return $choices;
}

/**
 * Get all pages for customizer Page content type.
 */
function parablog_get_page_choices() {
	$choices = array( '' => esc_html__( '--Select--', 'parablog' ) );
	$pages   = get_pages();

	foreach ( $pages as $page ) {
		$choices[ $page->ID ] = $page->post_title;
	}

	return $choices;
}

/**
 * Get all categories for customizer Category content type.
 */
function parablog_get_post_cat_choices() {
	$choices = array( '' => esc_html__( '--Select--', 'parablog' ) );
	$cats    = get_categories();

	foreach ( $cats as $cat ) {
		$choices[ $cat->term_id ] = $cat->name;
	}

	return $choices;
}

if ( ! function_exists( 'parablog_excerpt_length' ) ) :
	/**
	 * Excerpt length.
	 */
	function parablog_excerpt_length( $length ) {
		if ( is_admin() ) {
			return $length;
		}

		return get_theme_mod( 'parablog_excerpt_length', 20 );
	}
endif;
add_filter( 'excerpt_length', 'parablog_excerpt_length', 999 );

if ( ! function_exists( 'parablog_excerpt_more' ) ) :
	/**
	 * Excerpt more.
	 */
	function parablog_excerpt_more( $more ) {
		if ( is_admin() ) {
			return $more;
		}

		return '&hellip;';
	}
endif;
add_filter( 'excerpt_more', 'parablog_excerpt_more' );

if ( ! function_exists( 'parablog_validate_excerpt_length' ) ) :
	function parablog_validate_excerpt_length( $validity, $value ) {
		$value = intval( $value );
		if ( empty( $value ) || ! is_numeric( $value ) ) {
			$validity->add( 'required', esc_html__( 'You must supply a valid number.', 'parablog' ) );
		} elseif ( $value < 1 ) {
			$validity->add( 'min_no_of_words', esc_html__( 'Minimum no of words is 1', 'parablog' ) );
		} elseif ( $value > 100 ) {
			$validity->add( 'max_no_of_words', esc_html__( 'Maximum no of words is 100', 'parablog' ) );
		}
		return $validity;
	}
endif;

if ( ! function_exists( 'parablog_sidebar_layout' ) ) {
	/**
	 * Get sidebar layout.
	 */
	function parablog_sidebar_layout() {
		$sidebar_position      = get_theme_mod( 'parablog_sidebar_position', 'right-sidebar' );
		$sidebar_position_post = get_theme_mod( 'parablog_post_sidebar_position', 'right-sidebar' );
		$sidebar_position_page = get_theme_mod( 'parablog_page_sidebar_position', 'right-sidebar' );

		if ( is_single() ) {
			$sidebar_position = $sidebar_position_post;
		} elseif ( is_page() ) {
			$sidebar_position = $sidebar_position_page;
		}

		return $sidebar_position;
	}
}

if ( ! function_exists( 'parablog_is_sidebar_enabled' ) ) {
	/**
	 * Check if sidebar is enabled.
	 */
	function parablog_is_sidebar_enabled() {
		$sidebar_position      = get_theme_mod( 'parablog_sidebar_position', 'right-sidebar' );
		$sidebar_position_post = get_theme_mod( 'parablog_post_sidebar_position', 'right-sidebar' );
		$sidebar_position_page = get_theme_mod( 'parablog_page_sidebar_position', 'right-sidebar' );

		$sidebar_enabled = true;
		if ( is_home() || is_archive() || is_search() ) {
			if ( 'no-sidebar' === $sidebar_position ) {
				$sidebar_enabled = false;
			}
		} elseif ( is_single() ) {
			if ( 'no-sidebar' === $sidebar_position || 'no-sidebar' === $sidebar_position_post ) {
				$sidebar_enabled = false;
			}
		} elseif ( is_page() ) {
			if ( 'no-sidebar' === $sidebar_position || 'no-sidebar' === $sidebar_position_page ) {
				$sidebar_enabled = false;
			}
		}
		return $sidebar_enabled;
	}
}

if ( ! function_exists( 'parablog_get_homepage_sections ' ) ) {
	/**
	 * Returns homepage sections.
	 */
	function parablog_get_homepage_sections() {
		$sections = array(
			'banner'     => esc_html__( 'Banner Section', 'parablog' ),
			'categories' => esc_html__( 'Categories Section', 'parablog' ),
		);
		return $sections;
	}
}

/**
 * Renders customizer section link
 */
function parablog_section_link( $section_id ) {
	$section_name      = str_replace( 'parablog_', ' ', $section_id );
	$section_name      = str_replace( '_', ' ', $section_name );
	$starting_notation = '#';
	?>
	<span class="section-link">
		<span class="section-link-title"><?php echo esc_html( $section_name ); ?></span>
	</span>
	<style type="text/css">
		<?php echo $starting_notation . $section_id; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>:hover .section-link {
			visibility: visible;
		}
	</style>
	<?php
}

/**
 * Adds customizer section link css
 */
function parablog_section_link_css() {
	if ( is_customize_preview() ) {
		?>
		<style type="text/css">
			.section-link {
				visibility: hidden;
				background-color: black;
				position: relative;
				top: 80px;
				z-index: 99;
				left: 40px;
				color: #fff;
				text-align: center;
				font-size: 20px;
				border-radius: 10px;
				padding: 20px 10px;
				text-transform: capitalize;
			}
			.section-link-title {
				padding: 0 10px;
			}
		</style>
		<?php
	}
}
add_action( 'wp_head', 'parablog_section_link_css' );

/**
 * Breadcrumb.
 */
function parablog_breadcrumb( $args = array() ) {
	if ( ! get_theme_mod( 'parablog_enable_breadcrumb', true ) ) {
		return;
	}

	$args = array(
		'show_on_front' => false,
		'show_title'    => true,
		'show_browse'   => false,
	);
	breadcrumb_trail( $args );
}
add_action( 'parablog_breadcrumb', 'parablog_breadcrumb', 10 );

/**
 * Add separator for breadcrumb trail.
 */
function parablog_breadcrumb_trail_print_styles() {
	$breadcrumb_separator = get_theme_mod( 'parablog_breadcrumb_separator', '/' );

	$style = '
		.trail-items li::after {
			content: "' . $breadcrumb_separator . '";
		}'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	$style = apply_filters( 'parablog_breadcrumb_trail_inline_style', trim( str_replace( array( "\r", "\n", "\t", '  ' ), '', $style ) ) );

	if ( $style ) {
		echo "\n" . '<style type="text/css" id="breadcrumb-trail-css">' . $style . '</style>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
add_action( 'wp_head', 'parablog_breadcrumb_trail_print_styles' );

/**
 * Pagination for archive.
 */
function parablog_render_posts_pagination() {
	$is_pagination_enabled = get_theme_mod( 'parablog_enable_pagination', true );
	if ( $is_pagination_enabled ) {
		$pagination_type = get_theme_mod( 'parablog_pagination_type', 'default' );
		if ( 'default' === $pagination_type ) :
			the_posts_navigation();
		else :
			the_posts_pagination();
		endif;
	}
}
add_action( 'parablog_posts_pagination', 'parablog_render_posts_pagination', 10 );

/**
 * Pagination for single post.
 */
function parablog_render_post_navigation() {
	the_post_navigation(
		array(
			'prev_text' => '<span>&#10229;</span> <span class="nav-title">%title</span>',
			'next_text' => '<span class="nav-title">%title</span> <span>&#10230;</span>',
		)
	);
}
add_action( 'parablog_post_navigation', 'parablog_render_post_navigation' );

/**
 * Adds footer copyright text.
 */
function parablog_output_footer_copyright_content() {
	$theme_data = wp_get_theme();
	$search     = array( '[the-year]', '[site-link]' );
	$replace    = array( date( 'Y' ), '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>' );
	/* translators: 1: Year, 2: Site Title with home URL. */
	$copyright_default = sprintf( esc_html_x( 'Copyright &copy; %1$s %2$s', '1: Year, 2: Site Title with home URL', 'parablog' ), '[the-year]', '[site-link]' );
	$copyright_text    = get_theme_mod( 'parablog_footer_copyright_text', $copyright_default );
	$copyright_text    = str_replace( $search, $replace, $copyright_text );
	$copyright_text   .= esc_html( $theme_data->get( 'Name' ) ) . '&nbsp;' . esc_html__( 'by', 'parablog' ) . '&nbsp;<a target="_blank" href="' . esc_url( $theme_data->get( 'AuthorURI' ) ) . '">' . esc_html( ucwords( $theme_data->get( 'Author' ) ) ) . '</a>';
	/* translators: %s: WordPress.org URL */
	$copyright_text .= sprintf( esc_html__( ' | Powered by %s', 'parablog' ), '<a href="' . esc_url( __( 'https://wordpress.org/', 'parablog' ) ) . '" target="_blank">WordPress</a>. ' );
	?>
		<span><?php echo wp_kses_post( $copyright_text ); ?></span>					
	<?php
}
add_action( 'parablog_footer_copyright', 'parablog_output_footer_copyright_content' );
