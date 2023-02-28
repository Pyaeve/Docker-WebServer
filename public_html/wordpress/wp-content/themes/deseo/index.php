<?php get_header(); ?>
      <section id="page-header" class="visual">
            <div class="container">
                <div class="text-block">
                    <div class="heading-holder">
                        <h1>SEO BLOG</h1>
                    </div>
                    <p class="tagline">Latest search engine optimization tips, tricks, trends</p>
                </div>
            </div>
        </section>

        <section class="section lb">
            <div class="container">
                <div class="row">
                    <div class="content col-md-9 col-sm-12">

					<?php get_template_part('loop'); ?>

					<?php get_template_part('pagination'); ?>

					</div>
					
						<?php get_sidebar() ?>
					
					<!-- /sidebar -->
				</div><!-- /.row -->
			</div><!-- /.container -->
		</section>
		<!-- /section -->
<?php get_footer(); ?>
