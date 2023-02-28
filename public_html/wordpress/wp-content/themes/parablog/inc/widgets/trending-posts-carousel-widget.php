<?php
if ( ! class_exists( 'Parablog_Trending_Posts_Carousel_Widget' ) ) {
	/**
	 * Adds Parablog_Trending_Posts_Carousel_Widget Widget.
	 */
	class Parablog_Trending_Posts_Carousel_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			$parablog_trending_posts_carousel_widget_ops = array(
				'classname'   => 'ascendoor-widget parablog-trending-carousel-section',
				'description' => __( 'Retrive Trending Posts Carousel Widgets', 'parablog' ),
			);
			parent::__construct(
				'parablog_trending_posts_carousel_widget',
				__( 'Ascendoor Trending Posts Carousel Widget', 'parablog' ),
				$parablog_trending_posts_carousel_widget_ops
			);
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {
			if ( ! isset( $args['widget_id'] ) ) {
				$args['widget_id'] = $this->id;
			}
			$trending_carousal_title    = ( ! empty( $instance['title'] ) ) ? ( $instance['title'] ) : '';
			$trending_carousal_title    = apply_filters( 'widget_title', $trending_carousal_title, $instance, $this->id_base );
			$trending_carousal_count    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 6;
			$trending_carousal_offset   = isset( $instance['offset'] ) ? absint( $instance['offset'] ) : '';
			$trending_carousal_category = isset( $instance['category'] ) ? absint( $instance['category'] ) : '';
			$trending_carousal_orderby  = isset( $instance['orderby'] ) && in_array( $instance['orderby'], array( 'title', 'date' ) ) ? $instance['orderby'] : 'date';
			$trending_carousal_order    = isset( $instance['order'] ) && in_array( $instance['order'], array( 'asc', 'desc' ) ) ? $instance['order'] : 'asc';

			echo $args['before_widget'];
			?>
			<?php if ( ! empty( $trending_carousal_title ) ) { ?>	
				<div class="section-header">
					<?php
					echo $args['before_title'] . esc_html( $trending_carousal_title ) . $args['after_title'];
					?>
				</div>
			<?php } ?>
			<div class="parablog-section-body">
				<div class="parablog-trending-carousel-section-wrapper trending-carousel">
					<?php
					$trending_carousel_widgets_args = array(
						'post_type'      => 'post',
						'posts_per_page' => absint( $trending_carousal_count ),
						'offset'         => absint( $trending_carousal_offset ),
						'orderby'        => $trending_carousal_orderby,
						'order'          => $trending_carousal_order,
						'cat'            => absint( $trending_carousal_category ),
					);

					$query = new WP_Query( $trending_carousel_widgets_args );
					if ( $query->have_posts() ) :
						$i = 1;
						while ( $query->have_posts() ) :
							$query->the_post();
							?>
							<div class="carousel-item">
								<div class="mag-post-single has-image list-design">
									<div class="mag-post-img">
										<a href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail( 'post-thumbnail', array( 'class' => 'blog-parallax' ) ); ?>
										</a>
										<span class="trending-no"><?php echo absint( $i ); ?></span>
									</div>
									<div class="mag-post-detail">
										<h3 class="mag-post-title">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</h3>
									</div>
								</div>
							</div>
							<?php
							$i++;
						endwhile;
						wp_reset_postdata();
					endif;
					?>
				</div>
			</div>
			<?php
			echo $args['after_widget'];
		}

		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {
			$trending_carousal_title    = isset( $instance['title'] ) ? ( $instance['title'] ) : '';
			$trending_carousal_count    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 6;
			$trending_carousal_offset   = isset( $instance['offset'] ) ? absint( $instance['offset'] ) : '';
			$trending_carousal_category = isset( $instance['category'] ) ? absint( $instance['category'] ) : '';
			$trending_carousal_orderby  = isset( $instance['orderby'] ) && in_array( $instance['orderby'], array( 'title', 'date' ) ) ? $instance['orderby'] : 'date';
			$trending_carousal_order    = isset( $instance['order'] ) && in_array( $instance['order'], array( 'asc', 'desc' ) ) ? $instance['order'] : 'asc';
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Section Title:', 'parablog' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $trending_carousal_title ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of posts to show ( Minimum number of post should be 6 ):', 'parablog' ); ?></label>
				<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" max="6" value="<?php echo absint( $trending_carousal_count ); ?>" size="3" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>"><?php esc_html_e( 'Number of posts to displace or pass over:', 'parablog' ); ?></label>
				<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'offset' ) ); ?>" type="number" step="1" min="0" value="<?php echo absint( $trending_carousal_offset ); ?>" size="3" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Select the category to show posts:', 'parablog' ); ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>" class="widefat" style="width:100%;">
					<?php
					$categories = parablog_get_post_cat_choices();
					foreach ( $categories as $category => $value ) {
						?>
						<option value="<?php echo absint( $category ); ?>" <?php selected( $trending_carousal_category, $category ); ?>><?php echo esc_html( $value ); ?></option>
						<?php
					}
					?>
				</select>
			</p>
			<p>
				<label><?php esc_html_e( 'Order By:', 'parablog' ); ?></label>
				<ul>
					<li>
						<label>
							<input id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>" type="radio" value="date" <?php checked( 'date', $trending_carousal_orderby ); ?> /> 
									<?php esc_html_e( 'Published Date', 'parablog' ); ?>
						</label>
					</li>
					<li>
						<label>
							<input id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>" type="radio" value="title" <?php checked( 'title', $trending_carousal_orderby ); ?> /> 
									<?php esc_html_e( 'Alphabetical Order', 'parablog' ); ?>
						</label>
					</li>
				</ul>
			</p>
			<p>
				<label><?php esc_html_e( 'Sort By:', 'parablog' ); ?></label>
				<ul>
					<li>
						<label>
							<input id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" type="radio" value="asc" <?php checked( 'asc', $trending_carousal_order ); ?> /> 
									<?php esc_html_e( 'Ascending Order', 'parablog' ); ?>
						</label>
					</li>
					<li>
						<label>
							<input id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" type="radio" value="desc" <?php checked( 'desc', $trending_carousal_order ); ?> /> 
									<?php esc_html_e( 'Descending Order', 'parablog' ); ?>
						</label>
					</li>
				</ul>
			</p>
			<?php
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance             = $old_instance;
			$instance['title']    = sanitize_text_field( $new_instance['title'] );
			$instance['number']   = (int) $new_instance['number'];
			$instance['offset']   = (int) $new_instance['offset'];
			$instance['category'] = (int) $new_instance['category'];
			$instance['orderby']  = wp_strip_all_tags( $new_instance['orderby'] );
			$instance['order']    = wp_strip_all_tags( $new_instance['order'] );
			return $instance;
		}

	}
}
