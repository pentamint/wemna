<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array(  ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );

// END ENQUEUE PARENT ACTION

// PENTAMINT CUSTOM

// Register Custom Sidebar
function wemna_widgets_init() {
	register_sidebar( array(
		'name'          => 'Fullwidth Header Banner', 'WeMnA',
		'id'            => 'fullwidth-header-banner',
		'description'   => 'Add widgets here.', 'WeMnA',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'wemna_widgets_init' );

// Register Custom Scripts
function wemna_scripts() {
	wp_enqueue_script( 'main-js', get_stylesheet_directory_uri() . '/js/main.js', array('jquery'),  time(), true );
	wp_enqueue_script( 'ofi-min-js', get_stylesheet_directory_uri() . '/js/ofi.min.js', array(), '3.2.4', true );
}
add_action( 'wp_enqueue_scripts', 'wemna_scripts' );

// Create CPT M&A매물
function deals_init() {
	$labels = array(
		'name'                => __( 'M&A매물' ),
		'singular_name'       => __( 'M&A매물'),
		'menu_name'           => __( 'M&A매물'),
		'parent_item_colon'   => __( '상위 M&A매물:'),
		'all_items'           => __( 'M&A매물 전체보기'),
		'view_item'           => __( 'M&A매물 보기'),
		'add_new_item'        => __( '신규 M&A매물 등록하기'),
		'add_new'             => __( '신규 등록하기'),
		'edit_item'           => __( 'M&A매물 수정하기'),
		'update_item'         => __( 'M&A매물 적용하기'),
		'search_items'        => __( 'M&A매물 검색하기'),
		'not_found'           => __( '매물이 없습니다.'),
		'not_found_in_trash'  => __( '휴지통에 매물이 없습니다.')
	);
    $args = array(
		'label'               => __( 'deals'),
		'description'         => __( 'WeMnA M&A매물'),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields'),
		'public'              => true,
		'hierarchical'        => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'query_var' 		  => true,
		'has_archive'         => 'deals',
		'can_export'          => true,
		'exclude_from_search' => false,
	        'yarpp_support'     => true,
		'taxonomies' 	      => array('post_tag'),
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'query_var' 		  => true,
		'rewrite' 			  => array('slug' => 'deals'),
		'menu_icon' 	      => 'dashicons-admin-post',
        );
    register_post_type( 'deals', $args );
}
add_action( 'init', 'deals_init' );

// Add Custom Taxonomy Industry for CPT Deals
function deals_custom_taxonomy_industry() {
	$labels = array(
		'name' => _x( '업종', 'taxonomy general name' ),
		'singular_name' => _x( '업종', 'taxonomy singular name' ),
		'search_items' =>  __( '업종 검색하기' ),
		'all_items' => __( '업종 전체보기' ),
		'parent_item' => __( '상위 업종' ),
		'parent_item_colon' => __( '상위 업종:' ),
		'edit_item' => __( '업종 수정하기' ), 
		'update_item' => __( '업종 적용하기' ),
		'add_new_item' => __( '신규 업종 등록하기' ),
		'new_item_name' => __( '신규 업종 이름' ),
		'menu_name' => __( '업종' ),
	); 	
	register_taxonomy('industry',array('deals'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'industry' ),
	));
}
add_action( 'init', 'deals_custom_taxonomy_industry', 0 );

// Add Custom Taxonomy Locations for CPT Deals
function deals_custom_taxonomy_location() {
	$labels = array(
		'name' => _x( '지역', 'taxonomy general name' ),
		'singular_name' => _x( '지역', 'taxonomy singular name' ),
		'search_items' =>  __( '지역 검색하기' ),
		'all_items' => __( '지역 전체보기' ),
		'parent_item' => __( '상위 지역' ),
		'parent_item_colon' => __( '상위 지역:' ),
		'edit_item' => __( '지역 수정하기' ), 
		'update_item' => __( '지역 적용하기' ),
		'add_new_item' => __( '신규 지역 등록하기' ),
		'new_item_name' => __( '신규 지역 이름' ),
		'menu_name' => __( '지역' ),
	); 	
	register_taxonomy('location',array('deals'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'location' ),
	));
}
add_action( 'init', 'deals_custom_taxonomy_location', 0 );

// Create Custom Post Type 컨설턴트
function consultants_init() {
    $labels = array(
		'name'					=> '컨설턴트',
		'singular_name' 		=> '컨설턴트',
		'add_new'				=> 'Add New',
		'add_new_item'			=> 'Add New consultants',
		'edit_item'				=> 'Edit consultant',
		'new_item'				=> 'New consultant',
		'all_item'				=> 'All consultants',
		'view_item'				=> 'View consultant',
		'search_item'			=> 'Search consultants',
		'not_found'				=> 'No consultants found',
		'not_found_in_trash'	=> 'No consultants found in Trash',
		'parent_item_colon'		=> '',
		'menu_name'				=> '컨설턴트'
	);
    $args = array(
     	'labels' 				=> $labels,
        'taxonomies' 			=> array('post_tag'),
		'public' 				=> true,
		'publicly_queryable'	=> true,
        'show_ui' 				=> true,
		'show_in_menu'			=> true,
		'query_var' 			=> true,
		'rewrite' 				=> array('slug' => 'consultants'),
		'capability_type' 		=> 'post',
		'has_archive'			=> 'consultants',
		'hierarchical' 			=> false,
		'menu_icon' 			=> 'dashicons-admin-post',
        'supports' 				=> array(
            'title',
            'editor',
            'excerpt',
            'trackbacks',
            'custom-fields',
            'comments',
            'revisions',
            'thumbnail',
            'author',
            'page-attributes',)
        );
    register_post_type( 'consultants', $args );
}
add_action( 'init', 'consultants_init' );

/*
    in this example I have a repeater field named "consultant-attr"
    one of the rows of this repeater is named "const-area"
    and I want to be able to search, sort and filter by this field
*/
 
// create a function that will convert this repeater during the acf/save_post action
// priority of 20 to run after ACF is done saving the new values
add_filter('acf/save_post', 'convert_constarea_to_standard_wp_meta', 20);
 
function convert_constarea_to_standard_wp_meta($post_id) {
   
  // pick a new meta_key to hold the values of the color field
  // I generally name this field by suffixing _wp to the field name
  // as this makes it easy for me to remember this field name
  // also note, that this is not an ACF field and will not
  // appear when editing posts, it is just a db field that we
  // will use for searching
  $meta_key = 'constarea_wp';
   
  // the next step is to delete any values already stored
  // so that we can update it with new values
  // and we don't need to worry about removing a value
  // when it's deleted from the ACF repeater
  delete_post_meta($post_id, $meta_key);
   
  // create an array to hold values that are already added
  // this way we won't add the same meta value more than once
  // because having the same value to search and filter by
  // would be pointless
  $saved_values = array();
   
  // now we'll look at the repeater and save any values
  if (have_rows('consultant-attr', $post_id)) {
    while (have_rows('consultant-attr', $post_id)) {
      the_row();
       
      // get the value of this row
      $constarea = get_sub_field('const-area');
       
      // see if this value has already been saved
      // note that I am using isset rather than in_array
      // the reason for this is that isset is faster than in_array
      if (isset($saved_values[$constarea])) {
        // no need to save this one we already have it
        continue;
      }
       
      // not already save, so add it using add_post_meta()
      // note that we are using false for the 4th parameter
      // this means that this meta key is not unique
      // and can have more then one value
      add_post_meta($post_id, $meta_key, $constarea, false);
       
      // add it to the values we've already saved
      $saved_values[$constarea] = $constarea;
       
    } // end while have rows
  } // end if have rows
} // end function
 
/**
 * Plugin name: WP Trac #42573: Fix for theme template file caching.
 * Description: Flush the theme file cache each time the admin screens are loaded which uses the file list.
 * Plugin URI: https://core.trac.wordpress.org/ticket/42573
 * Author: Weston Ruter, XWP.
 * Author URI: https://weston.ruter.net
 */
function wp_42573_fix_template_caching( WP_Screen $current_screen ) {
	// Only flush the file cache with each request to post list table, edit post screen, or theme editor.
	if ( ! in_array( $current_screen->base, array( 'post', 'edit', 'theme-editor' ), true ) ) {
		return;
	}
	$theme = wp_get_theme();
	if ( ! $theme ) {
		return;
	}
	$cache_hash = md5( $theme->get_theme_root() . '/' . $theme->get_stylesheet() );
	$label = sanitize_key( 'files_' . $cache_hash . '-' . $theme->get( 'Version' ) );
	$transient_key = substr( $label, 0, 29 ) . md5( $label );
	delete_transient( $transient_key );
}
add_action( 'current_screen', 'wp_42573_fix_template_caching' );

// ----- Custom Filter Module ----- //
// Process Filter Requests

add_action('wp_ajax_myfilter', 'pm_filter_function'); // wp_ajax_{ACTION HERE} 
add_action('wp_ajax_nopriv_myfilter', 'pm_filter_function');
 
function pm_filter_function(){

	$args = array(
		'orderby' => 'date', // we will sort posts by date
		'order'	=> $_POST['date'], // ASC or DESC
		'post_type' => 'deals',
	);

	// for taxonomies / categories
	if( isset( $_POST['deals_industry_filter'] ) && $_POST['deals_industry_filter'] ) {
		$industrydata = $_POST['deals_industry_filter'];
		$locationdata = $_POST['deals_location_filter'];

	$args['meta_query'][] = array (
		'key' => 'industry',
		'value' => array(''),
		'terms' => $_POST['deals_industry_filter'],
		'relation' => 'OR',

	);
	}
	$args['tax_query'][] = array(
		'taxonomy' => 'industry', 
		'field' => 'id',
		'terms' => $_POST['deals-industry-filter']
	);

	$args['tax_query'][] = array(
		'taxonomy' => 'location', 
		'field' => 'id',
		'terms' => $_POST['deals-location-filter']
	);

	if( isset( $_POST['deals-industry-filter'] ) && $_POST['deals-industry-filter'] || isset( $_POST['deals-location-filter'] ) && $_POST['deals-location-filter'] )
		$args['tax_query'][] = array('relation'=>'AND' );


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

