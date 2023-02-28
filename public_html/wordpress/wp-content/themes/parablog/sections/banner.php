<?php
if ( ! get_theme_mod( 'parablog_enable_banner_section', false ) ) {
	return;
}

$slider_content_ids  = array();
$slider_content_type = get_theme_mod( 'parablog_banner_slider_content_type', 'post' );

for ( $i = 1; $i <= 4; $i++ ) {
	$slider_content_ids[] = get_theme_mod( 'parablog_banner_slider_content_' . $slider_content_type . '_' . $i );
}
	$banner_slider_args = array(
		'post_type'           => $slider_content_type,
		'post__in'            => array_filter( $slider_content_ids ),
		'orderby'             => 'post__in',
		'posts_per_page'      => absint( 4 ),
		'ignore_sticky_posts' => true,
	);

	$banner_slider_args = apply_filters( 'parablog_banner_section_args', $banner_slider_args );

	parablog_render_banner_section( $banner_slider_args );

	/**
	 * Render Banner Section.
	 */
	function parablog_render_banner_section( $banner_slider_args ) {
		?>

	<section id="parablog_banner_section" class="banner-section banner-style-2">
			<?php
			if ( is_customize_preview() ) :
				parablog_section_link( 'parablog_banner_section' );
			endif;
			?>
		<div class="banner-section-wrapper">
			<?php
			$query = new WP_Query( $banner_slider_args );
			if ( $query->have_posts() ) :
				$slider_autoplay = get_theme_mod( 'parablog_enable_banner_slider_autoplay', false ) ? 'true' : 'false';
				?>
				<div class="parablog-slider-wrapper banner-slider parablog-carousel-slider-navigation"  data-slick='{"autoplay": false }'>
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();
						?>
						<div class="carousel-item">
							<div class="mag-post-single has-image tile-design">
								<div class="mag-post-img">
									<a href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail( 'full', array( 'class' => 'blog-parallax' ) ); ?>
									</a>
								</div>
								<div class="mag-post-detail">
									<div class="ascendoor-wrapper">
										<div class="mag-post-category with-background">
											<?php parablog_categories_list(); ?>
										</div>
										<h3 class="mag-post-title">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</h3>
										<div class="mag-post-meta">
											<span class="post-author">
												<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><i class="fas fa-user"></i><?php echo esc_html( get_the_author() ); ?></a>
											</span>
											<span class="post-date">
												<a href="<?php the_permalink(); ?>"><i class="far fa-clock"></i><?php echo esc_html( get_the_date() ); ?></a>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php
					endwhile;
					wp_reset_postdata();
					?>
				</div>
				<?php
				endif;
			?>
		</div>
	</section>

		<?php
	}
