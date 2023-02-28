<?php get_header(); ?>
        <section class="section lb">
            <div class="container">
                <div class="row">
                    <div class="content col-md-9 col-sm-12">
                      
                            <?php if (have_posts()): while (have_posts()) : the_post(); ?>
                                  <div class="blog-micro-wrapper">
                            <div class="post-micro clearfix text-center">
                                <div class="post-media clearfix">
                                    <a href="single.html" title=""><img src="upload/single.png" alt="" class="img-responsive"></a>
                                </div><!-- end post-media -->
    
                                <div class="large-post-meta">
                                    <span class="avatar"><a href="author.html"><img src="upload/avatar_01.png" alt="" class="img-circle"> Jenny DOE</a></span>
                                    <small>&#124;</small>
                                    <span><a href="category.html"><i class="fa fa-clock-o"></i> 21 May 2016</a></span>
                                    <small class="hidden-xs">&#124;</small>
                                    <span class="hidden-xs"><a href="single.html#comments"><i class="fa fa-comments-o"></i> 12</a></span>
                                    <small class="hidden-xs">&#124;</small>
                                    <span class="hidden-xs"><a href="single.html"><i class="fa fa-eye"></i> 444</a></span>
                                </div><!-- end meta -->
                            
                                    <!-- post title -->
                                      <h3 class="entry-title">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                                          </h3>
                                <div class="post-sharing clearfix">
                                    <ul class="list-inline social-small">
                                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                    </ul>
                                </div><!-- end post-sharing -->
                            </div><!-- end post-micro -->

                            <div class="post-desc clearfix">
                               <?php the_content(); // Dynamic Content ?>
                                <div class="tags clearfix">
                                    <?php the_tags( __( 'Tags: ', 'wpbootstrapsass' ), ', ', '<li>'); // Separated by commas with a line break at the end ?>
                                   
                                </div><!-- end tags -->
                            </div><!--end post-desc -->
                        </div><!-- end wrapper -->
                    <?php endwhile; ?>
                <?php endif; ?>
                       
                     
                      
                    </div><!-- end content -->
                   
               
                 <?php get_sidebar(); ?>
                </div><!-- end row -->
            </div><!-- end container -->  
        </section>
<?php get_footer(); ?>
