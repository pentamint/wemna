<?php
/**
 * Declaring widgets
 *
 * @package Pentamint_WP_Theme
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if (!function_exists('pentamint_wp_theme_widgets_init')) {

	function pentamint_wp_theme_widgets_init() {
		// Global sidebar area
		register_sidebar(array(
			'name'          => 'Fullwidth Header Banner', 'pentamint_wp_theme',
			'id'            => 'fullwidth-header-banner',
			'description'   => 'Add widgets here.', 'pentamint_wp_theme',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		));
	}

	add_action('widgets_init', 'pentamint_wp_theme_widgets_init');
	
} // endif function_exists( 'pentamint_wp_theme_widgets_init' ).
