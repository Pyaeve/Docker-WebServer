                 <?php if (have_posts()): while (have_posts()) : the_post(); ?>       
                        <div class="blog-micro-wrapper">
                            <div class="row post-micro clearfix">
                                <div class="col-md-4">
                                    <div class="post-media clearfix">
                                       
                                        <!-- post thumbnail -->
        <?php if ( has_post_thumbnail()) : // Check if thumbnail exists ?>
            
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                <?php the_post_thumbnail('medium_large', array('class' => 'img-fluid') ); // Declare pixel size you need inside the array ?>
            </a>
            
        <?php endif; ?>
        <!-- /post thumbnail -->
                                    </div><!-- end post-media -->

                                </div><!-- end col -->

                                <div class="col-md-8">
                                    <div class="large-post-meta">
                                        <span class="avatar"><a href="author.html"><img src="upload/avatar_01.png" alt="" class="img-circle"> Jenny DOE</a></span>
                                        <small>&#124;</small>
                                        <span><a href="category.html"><i class="fa fa-clock-o"></i> 21 May 2016</a></span>
                                        <small class="hidden-xs">&#124;</small>
                                        <span class="hidden-xs"><a href="single.html#comments"><i class="fa fa-comments-o"></i> 12</a></span>
                                        <small class="hidden-xs">&#124;</small>
                                        <span class="hidden-xs"><a href="single.html"><i class="fa fa-eye"></i> 444</a></span>
                                    </div><!-- end meta -->
                                    <h3 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                                    <div class="post-sharing clearfix">
                                        <ul class="list-inline social-small">
                                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                        </ul>
                                    </div><!-- end post-sharing -->
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="readmore">Continuar Leyendo..</a>
                                </div><!-- end col -->
                            </div><!-- end post-micro -->
                        </div><!-- end wrapper -->
                    <?php endwhile; ?>
                    <?php endif;?>