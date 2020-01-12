<?php
/**
 * Initiate CPT 조정사례
 *
 * @package Pentamint_WP_Theme
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Create CPT 조정사례
if (!function_exists('cases_init')) {

    function cases_init() {
        $labels = array(
            'name'                => __('조정사례'),
            'singular_name'       => __('조정사례'),
            'menu_name'           => __('조정사례'),
            'parent_item_colon'   => __(''),
            'all_items'           => __('조정사례 전체보기'),
            'view_item'           => __('조정사례 보기'),
            'add_new_item'        => __('신규 조정사례 등록하기'),
            'add_new'             => __('신규 등록하기'),
            'edit_item'           => __('조정사례 수정하기'),
            'update_item'         => __('조정사례 적용하기'),
            'search_items'        => __('조정사례 검색하기'),
            'not_found'           => __('조정사례이 없습니다.'),
            'not_found_in_trash'  => __('휴지통에 조정사례이 없습니다.')
        );
        $args = array(
            'label'               => __('cases'),
            'description'         => __('ASK 조정사례'),
            'labels'              => $labels,
            'supports'            => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields'),
            'public'              => true,
            'hierarchical'        => false,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'query_var' 		  => true,
            'has_archive'         => 'cases',
            'can_export'          => true,
            'exclude_from_search' => false,
            'yarpp_support'     => true,
            'taxonomies' 	      => array('post_tag'),
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
            'query_var' 		  => true,
            'rewrite' 			  => array('slug' => 'cases'),
            'menu_icon' 	      => 'dashicons-admin-post',
        );
        register_post_type('cases', $args);
    }

    add_action('init', 'cases_init');

}

// Add Custom Taxonomy Industry for CPT 조정사례
if (!function_exists('cases_custom_taxonomy_industry')) {

    function cases_custom_taxonomy_industry() {
        $labels = array(
            'name' => _x('분야', 'taxonomy general name'),
            'singular_name' => _x('분야', 'taxonomy singular name'),
            'search_items' =>  __('분야 검색하기'),
            'all_items' => __('분야 전체보기'),
            'parent_item' => __('상위 분야'),
            'parent_item_colon' => __('상위 분야:'),
            'edit_item' => __('분야 수정하기'),
            'update_item' => __('분야 적용하기'),
            'add_new_item' => __('신규 분야 등록하기'),
            'new_item_name' => __('신규 분야 이름'),
            'menu_name' => __('분야'),
        );
        register_taxonomy('industry', array('cases'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'industry'),
        ));
    }

    add_action('init', 'cases_custom_taxonomy_industry', 0);
    
}

// Add Custom Taxonomy Locations for CPT 조정사례
if (!function_exists('cases_custom_taxonomy_location')) {
    
    function cases_custom_taxonomy_location() {
        $labels = array(
            'name' => _x('지역', 'taxonomy general name'),
            'singular_name' => _x('지역', 'taxonomy singular name'),
            'search_items' =>  __('지역 검색하기'),
            'all_items' => __('지역 전체보기'),
            'parent_item' => __('상위 지역'),
            'parent_item_colon' => __('상위 지역:'),
            'edit_item' => __('지역 수정하기'),
            'update_item' => __('지역 적용하기'),
            'add_new_item' => __('신규 지역 등록하기'),
            'new_item_name' => __('신규 지역 이름'),
            'menu_name' => __('지역'),
        );
        register_taxonomy('location', array('cases'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'location'),
        ));
    }

    add_action('init', 'cases_custom_taxonomy_location', 0);

}