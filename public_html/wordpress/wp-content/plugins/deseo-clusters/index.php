	<?php
	// Add Shortcode
	function deseo_cluster_shortcodem_callback( $atts, $titlte ) {

		// Attributes
		$atts = shortcode_atts(
			array(
				'cat' => '1',
				'post' => '1',
				'max' => '3',
			),
			$atts,
			'deseo_cluster_shortcode'
		);

		//query arguments
		$args = array(
		    
		    'post_status' => 'publish',
		    'posts_per_page' => $atts['max'],
		    'orderby' => 'rand',
		    
		    'post__not_in' => array ($atts['post']),
		);
		
		//the query
		$posts = new WP_Query( $args );
		$html = '<h3></h3>';
		//loop through query
		if($relatedPosts->have_posts()){
	   	 $html .= '<ul>';
	    while($posts->have_posts()){ 
	        $posts->the_post();
	        $html .= '<li><a href="'.the_permalink().'">'.the_title().'"></a></li>';

	    }
	    $html .= '</ul>';
	}else{
	    //no posts found
	}

		return $html;
	}
	add_shortcode( 'deseo_cluster_shortcode', 'deseo_cluster_shortcodem_callback' );	