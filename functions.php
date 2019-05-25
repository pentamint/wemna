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

// Creating Custom Post Type 매물

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

// Creating Custom Post Type 컨설턴트
function consultants_init() {
    $args = array(
      'label' => '컨설턴트',
        'taxonomies' => array('category', 'post_tag'),
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => array('slug' => 'consultants'),
        'query_var' => true,
        'menu_icon' => 'dashicons-admin-post',
        'supports' => array(
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


// END PENTAMINT CUSTOM

