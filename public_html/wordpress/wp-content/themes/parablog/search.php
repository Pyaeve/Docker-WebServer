<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Parablog
 */

get_header();

$archive_layout          = get_theme_mod( 'parablog_archive_style', 'grid-layout' );
$layout_additional_class = '';
if ( 'grid-layout' === $archive_layout ) {
	$layout_additional_class = 'grid-layout grid-style-3 column-3';
}
if ( 'list-layout' === $archive_layout ) {
	$layout_additional_class = 'list-layout list-style-4';
}

?>

<main id="primary" class="site-main">

	<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<h1 class="page-title">
				<?php
				/* translators: %s: search query. */
				printf( esc_html__( 'Search Results for: %s', 'parablog' ), '<span>' . get_search_query() . '</span>' );
				?>
			</h1>
		</header><!-- .page-header -->
		<div class="parablog-archive-layout <?php echo esc_attr( $layout_additional_class ); ?>">
			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

			endwhile;

			?>

		</div>

		<?php

		do_action( 'parablog_posts_pagination' );

	else :

		get_template_part( 'template-parts/content', 'none' );

	endif;
	?>

</main><!-- #main -->

<?php
if ( parablog_is_sidebar_enabled() ) {
	get_sidebar();
}
get_footer();
