<?php
/**
 * Theme enqueue scripts
 *
 * @package Pentamint_WP_Theme
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'pentamint_wp_theme_scripts' ) ) {
	/**
	 * Load theme's JavaScript and CSS sources.
	 */
	function pentamint_wp_theme_scripts() {
		// Initiate Default Wordpress jQuery
		wp_enqueue_script('jquery');

		// Bootstrap Support
		wp_enqueue_script('popper.js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', array(), null, true);
		wp_enqueue_script('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array(), null, true);

		// Theme Custom
		wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap', false);
		wp_enqueue_style('nanum-fonts-nanumsquareround', 'https://cdn.rawgit.com/innks/NanumSquareRound/master/nanumsquareround.min.css', false);
		wp_enqueue_style('animate.css', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css', true);
		wp_enqueue_script('ofi-min-js', get_stylesheet_directory_uri() . '/js/ofi.min.js', array(), '3.2.4', true);
		wp_enqueue_script('main-js', get_stylesheet_directory_uri() . '/js/main.js', array('jquery'),  time(), true);
	}

	add_action( 'wp_enqueue_scripts', 'pentamint_wp_theme_scripts' );
	
} // endif function_exists( 'pentamint_wp_theme_scripts' )
