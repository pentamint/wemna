<?php

add_action('wp_ajax_myfilter', 'pm_filter_function'); // wp_ajax_{ACTION HERE} 
add_action('wp_ajax_nopriv_myfilter', 'pm_filter_function');
 
function pm_filter_function(){

	$args = array(
		'orderby' => 'date', // we will sort posts by date
		'order'	=> $_POST['date'] // ASC or DESC
	);

	if( isset( $_POST['deals_industry_filter'] ) )
		$args['tax_query'] = array(
			array(
		        'taxonomy' => 'industry',
			    'field' => 'id',
			    'terms' => $_POST['deals_industry_filter']
		    )
		);


    
	// $args['tax_query'] = array();
	// $args['tax_query'] = array( 'relation' => 'AND' );
	
	// $terms1 = array();
	// $terms2 = array();

	// if( isset( $_POST['deals_industry_filter'] ) ) {
	// 	$terms1[] = $_POST['deals_industry_filter'];
	// }

	// $args['tax_query'][] = array(
	// 	'taxonomy' => 'industry',
	// 	'field' => 'id',
	// 	'terms' => $terms1
	// );

	// if( isset( $_POST['deals_industry_filter'] ) )
	// 	$args['tax_query'] = array(
	// 		array(
	// 	        'taxonomy' => 'industry',
	// 		    'field' => 'id',
	// 		    'terms' => $_POST['deals_industry_filter']
	// 	    )
	// 	);
	
	// if( isset( $_POST['deals_location_filter'] ) ) {
	// 	$terms2[] = $_POST['deals_location_filter'];
	// }

	// $args['tax_query'][] = array(
	// 	'taxonomy' => 'location',
	// 	'field' => 'id',
	// 	'terms' => $terms2
	// );

	// if( isset( $_POST['deals_location_filter'] ) )
	// 	$args['tax_query'][] = array(
	// 		'taxonomy' => 'location',
	// 		'field' => 'id',
	// 		'terms' => $_POST['deals_location_filter']
	// 	);

	// create $args['meta_query'] array if one of the following fields is filled
	if( isset( $_POST['price_min'] ) && $_POST['price_min'] || isset( $_POST['price_max'] ) && $_POST['price_max'] || isset( $_POST['featured_image'] ) && $_POST['featured_image'] == 'on' )
		$args['meta_query'] = array( 'relation'=>'AND' ); // AND means that all conditions of meta_query should be true
 
	// if both minimum price and maximum price are specified we will use BETWEEN comparison
	if( isset( $_POST['price_min'] ) && $_POST['price_min'] && isset( $_POST['price_max'] ) && $_POST['price_max'] ) {
		$args['meta_query'][] = array(
			'key' => '_price',
			'value' => array( $_POST['price_min'], $_POST['price_max'] ),
			'type' => 'numeric',
			'compare' => 'between'
		);
	} else {
		// if only min price is set
		if( isset( $_POST['price_min'] ) && $_POST['price_min'] )
			$args['meta_query'][] = array(
				'key' => '_price',
				'value' => $_POST['price_min'],
				'type' => 'numeric',
				'compare' => '>'
			);
 
		// if only max price is set
		if( isset( $_POST['price_max'] ) && $_POST['price_max'] )
			$args['meta_query'][] = array(
				'key' => '_price',
				'value' => $_POST['price_max'],
				'type' => 'numeric',
				'compare' => '<'
			);
	}
 
 
	// if post thumbnail is set
	if( isset( $_POST['featured_image'] ) && $_POST['featured_image'] == 'on' )
		$args['meta_query'][] = array(
			'key' => '_thumbnail_id',
			'compare' => 'EXISTS'
		);
	// if you want to use multiple checkboxed, just duplicate the above 5 lines for each checkbox
 
	$query = new WP_Query( $args );
 
	if( $query->have_posts() ) :
		while( $query->have_posts() ): $query->the_post();
			?>
			<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
			<?php
			the_post_thumbnail();
		endwhile;
		wp_reset_postdata();
	else :
		echo 'No posts found';
	endif;
 
	die();
}

// END PENTAMINT CUSTOM
