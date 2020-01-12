<?php
/**
 * Initiate CPT 조정인
 *
 * @package Pentamint_WP_Theme
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Create CPT 조정인
if (!function_exists('mediators_init')) {

    function mediators_init() {
        $labels = array(
            'name'					=> __('조정인'),
            'singular_name' 		=> __('조정인'),
            'add_new'				=> __('신규 등록하기'),
            'add_new_item'			=> __('신규 조정인 등록하기'),
            'edit_item'				=> __('조정인 수정하기'),
            'new_item'				=> __('신규 조정인'),
            'all_item'				=> __('조정인 전체보기'),
            'view_item'				=> __('조정인 보기'),
            'search_item'			=> __('조정인 검색하기'),
            'not_found'				=> __('조정인이 없습니다'),
            'not_found_in_trash'	=> __('휴지통에 조정인이 없습니다.'),
            'parent_item_colon'		=> __(''),
            'menu_name'				=> __('조정인')
        );
        $args = array(
            'labels' 				=> $labels,
            'taxonomies' 			=> array('post_tag'),
            'public' 				=> true,
            'publicly_queryable'	=> true,
            'show_ui' 				=> true,
            'show_in_menu'			=> true,
            'query_var' 			=> true,
            'rewrite' 				=> array('slug' => 'mediators'),
            'capability_type' 		=> 'post',
            'has_archive'			=> 'mediators',
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
                'page-attributes',
            )
        );
        register_post_type('mediators', $args);
    }

    add_action('init', 'mediators_init');

}

// Add Custom Taxonomy Specialty for CPT 조정인
if (!function_exists('mediators_custom_taxonomy_specialty')) {

    function mediators_custom_taxonomy_specialty() {
        $labels = array(
            'name' => _x('전문분야', 'taxonomy general name'),
            'singular_name' => _x('전문분야', 'taxonomy singular name'),
            'search_items' =>  __('전문분야 검색하기'),
            'all_items' => __('전문분야 전체보기'),
            'parent_item' => __('상위 전문분야'),
            'parent_item_colon' => __('상위 전문분야:'),
            'edit_item' => __('전문분야 수정하기'),
            'update_item' => __('전문분야 적용하기'),
            'add_new_item' => __('신규 전문분야 등록하기'),
            'new_item_name' => __('신규 전문분야 이름'),
            'menu_name' => __('전문분야'),
        );
        register_taxonomy('specialty', array('mediators'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'specialty'),
        ));
    }

    add_action('init', 'mediators_custom_taxonomy_specialty', 0);
    
}

// Add Custom Taxonomy Locations for CPT 조정인
if (!function_exists('mediators_custom_taxonomy_location')) {

    function mediators_custom_taxonomy_clocation() {
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
        register_taxonomy('clocation', array('mediators'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'clocation'),
        ));
    }

    add_action('init', 'mediators_custom_taxonomy_clocation', 0);

}