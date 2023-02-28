<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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
			<?php
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="archive-description">', '</div>' );
			?>
		</header><!-- .page-header -->
		<div class="parablog-archive-layout <?php echo esc_attr( $layout_additional_class ); ?>">
			<?php
				/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				* Include the Post-Type-specific template for the content.
				* If you want to override this in a child theme, then include a file
				* called content-___.php (where ___ is the Post Type name) and that will be used instead.
				*/
				get_template_part( 'template-parts/content', get_post_type() );

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
