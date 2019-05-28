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

// Create Custom Post Type 매물
function deals_init() {
	$labels = array(
		'name'					=> 'M&A매물',
		'singular_name' 		=> 'M&A매물',
		'add_new'				=> 'Add New',
		'add_new_item'			=> 'Add New Deal',
		'edit_item'				=> 'Edit Deal',
		'new_item'				=> 'New Deal',
		'all_item'				=> 'All Deals',
		'view_item'				=> 'View Deal',
		'search_item'			=> 'Search Deals',
		'not_found'				=> 'No deals found',
		'not_found_in_trash'	=> 'No deals found in Trash',
		'parent_item_colon'		=> '',
		'menu_name'				=> 'M&A매물'
	);
    $args = array(
     	'labels' 				=> $labels,
        'taxonomies' 			=> array('post_tag'),
		'public' 				=> true,
		'publicly_queryable'	=> true,
        'show_ui' 				=> true,
		'show_in_menu'			=> true,
		'query_var' 			=> true,
		'rewrite' 				=> array('slug' => 'deals'),
		'capability_type' 		=> 'post',
		'has_archive'			=> 'deals',
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
    register_post_type( 'deals', $args );
}
add_action( 'init', 'deals_init' );

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

// Create Custom Post Filter
// array of filters (field key => field name)
$GLOBALS['deal_query_filters'] = array( 
	'field_5cb2d3b24e890'	=> 'industry', 
	'field_5cb2d0673f66a'	=> 'location',
);

$GLOBALS['const_query_filters'] = array( 
	'field_5cd58b387f009'	=> 'const-area',
	'field_5cd58ffa7f00a'	=> 'const-specialty'
);

// action
add_action('pre_get_posts', 'my_pre_get_posts', 10, 1);

function my_pre_get_posts( $query ) {
	
	// bail early if is in admin
	if( is_admin() ) return;
	
	// bail early if not main query
	// - allows custom code / plugins to continue working
	if( !$query->is_main_query() ) return;
	
	// get meta query
	$meta_query = $query->get('meta_query');

	// loop over filters
	foreach( $GLOBALS['deal_query_filters'] as $key => $name ) {
		
		// continue if not found in url
		if( empty($_GET[ $name ]) ) {
			
			continue;
			
		}
		
		// get the value for this filter
		// eg: http://www.website.com/events?city=melbourne,sydney
		$value = explode(',', $_GET[ $name ]);
		
		// append meta query
    	$meta_query[] = array(
            'key'		=> $name,
            'value'		=> $value,
            'compare'	=> '=',
        );
        
	}

	// loop over filters
	foreach( $GLOBALS['const_query_filters'] as $key => $name ) {
		
		// continue if not found in url
		if( empty($_GET[ $name ]) ) {
			
			continue;
			
		}
		
		// get the value for this filter
		// eg: http://www.website.com/events?city=melbourne,sydney
		$value = explode(',', $_GET[ $name ]);
		
		// append meta query
    	$meta_query[] = array(
            'key'		=> $name,
            'value'		=> $value,
            'compare'	=> '=',
        );
        
	} 
	
	// update meta query
	$query->set('meta_query', $meta_query);

}

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

// END PENTAMINT CUSTOM

