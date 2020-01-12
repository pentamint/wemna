<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if (!function_exists('chld_thm_cfg_parent_css')) :
	function chld_thm_cfg_parent_css()
	{
		wp_enqueue_style('chld_thm_cfg_parent', trailingslashit(get_template_directory_uri()) . 'style.css', array());
	}
endif;
add_action('wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10);

// END ENQUEUE PARENT ACTION

// PENTAMINT CUSTOM

/**
 * Plugin name: WP Trac #42573: Fix for theme template file caching.
 * Description: Flush the theme file cache each time the admin screens are loaded which uses the file list.
 * Plugin URI: https://core.trac.wordpress.org/ticket/42573
 * Author: Weston Ruter, XWP.
 * Author URI: https://weston.ruter.net
 */
function wp_42573_fix_template_caching(WP_Screen $current_screen) {
	// Only flush the file cache with each request to post list table, edit post screen, or theme editor.
	if (!in_array($current_screen->base, array('post', 'edit', 'theme-editor'), true)) {
		return;
	}
	$theme = wp_get_theme();
	if (!$theme) {
		return;
	}
	$cache_hash = md5($theme->get_theme_root() . '/' . $theme->get_stylesheet());
	$label = sanitize_key('files_' . $cache_hash . '-' . $theme->get('Version'));
	$transient_key = substr($label, 0, 29) . md5($label);
	delete_transient($transient_key);
}
add_action('current_screen', 'wp_42573_fix_template_caching');

$pentamint_wp_theme_includes = array(
	// '/setup.php',						   // Theme setup and custom theme supports.
	'/cpt-cases.php',                          // Initiate Custom Post Type - Cases
	'/cpt-mediators.php',                      // Initiate Custom Post Type - Mediators
	// '/menus.php',                           // Register custom menus.
	'/widgets.php',                            // Register widget area.
	'/enqueue.php',                            // Enqueue scripts and styles.
	// '/template-tags.php',                   // Custom template tags for this theme.
	// '/pagination.php',                      // Custom pagination for this theme.
	// '/hooks.php',                           // Custom hooks.
	// '/extras.php',                          // Custom functions that act independently of the theme templates.
	// '/customizer.php',                      // Customizer additions.
	// '/custom-comments.php',                 // Custom Comments file.
	// '/jetpack.php',                         // Load Jetpack compatibility file.
	// '/class-wp-bootstrap-navwalker.php',    // Load custom WordPress nav walker.
	// '/woocommerce.php',                     // Load WooCommerce functions.
	// '/editor.php',                          // Load Editor functions.
	// '/deprecated.php',                      // Load deprecated functions.
	// '/module-ajax-filter.php'			   // Load AJAX filter module.
	// '/filter-byrepeater-sample.php',           // Filter by Subfield - Sample
);

foreach ( $pentamint_wp_theme_includes as $file ) {
	$filepath = locate_template( 'inc' . $file );
	if ( ! $filepath ) {
		trigger_error( sprintf( 'Error locating /inc%s for inclusion', $file ), E_USER_ERROR );
	}
	require_once $filepath;
}

// ------------------------- To be Removed

/**
 * Custom AJAX Filters - Load More & Paginations
 */
// Enqueue Load More Script
add_action('wp_enqueue_scripts', 'pm_script_and_styles');

function pm_script_and_styles()
{
	// absolutely need it, because we will get $wp_query->query_vars and $wp_query->max_num_pages from it.
	global $wp_query;

	// when you use wp_localize_script(), do not enqueue the target script immediately
	wp_register_script('pm_ajax_filter_scripts', get_stylesheet_directory_uri() . '/js/ajax_filter.js', array('jquery'), time(), true);

	// passing parameters here
	// actually the <script> tag will be created and the object "pm_loadmore_params" will be inside it 
	wp_localize_script('pm_ajax_filter_scripts', 'pm_loadmore_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
		'posts' => json_encode($wp_query->query_vars), // everything about your loop is here
		'current_page' => $wp_query->query_vars['paged'] ? $wp_query->query_vars['paged'] : 1,
		'max_page' => $wp_query->max_num_pages
	));

	wp_enqueue_script('pm_ajax_filter_scripts');
}

// Create Custom Function for AJAX Handler
add_action('wp_ajax_loadmorebutton', 'pm_loadmore_ajax_handler');
add_action('wp_ajax_nopriv_loadmorebutton', 'pm_loadmore_ajax_handler');

function pm_loadmore_ajax_handler()
{

	// prepare our arguments for the query
	$args = json_decode(stripslashes($_POST['query']), true); // query_posts() takes care of the necessary sanitization 
	$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
	$args['post_status'] = 'publish';

	// it is always better to use WP_Query but not here
	query_posts($args);

	if (have_posts()) :

		// run the loop
		while (have_posts()) : the_post();
			$pm_post = get_post();
			$pm_post_title = get_the_title();
			?>

<article id="post-<?php the_ID(); ?>" <?php post_class('et_pb_post col-12 col-sm-6 col-md-3'); ?>>

	<!-- Custom Field -->
	<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php echo $pm_post_title; ?></a></h2>

	<?php
							if (have_rows('case-attr')) : //parent group field
								while (have_rows('case-attr')) : the_row();
									// vars
									$caseres = get_sub_field('case-res');
									$caseamt = get_sub_field('case-amt');
									?>
	<div class="case-data">
		<ul>
			<li><span>분야:&nbsp</span>
				<p>
					<?php $terms = wp_get_post_terms($pm_post->ID, 'industry');
															if ($terms) {
																$out = array();
																foreach ($terms as $term) {
																	$out[] = $term->name;
																}
																echo join(', ', $out);
															} ?>
				</p>
			</li>
			<li><span>지역:&nbsp</span>
				<p>
					<?php $terms = wp_get_post_terms($pm_post->ID, 'location');
															if ($terms) {
																$out = array();
																foreach ($terms as $term) {
																	$out[] = $term->name;
																}
																echo join(', ', $out);
															} ?>
				</p>
			</li>
			<li><span>결과:&nbsp</span>
				<p><?php echo $caseres ?></p>
			</li>
			<li><span>분쟁액수:&nbsp</span>
				<p><?php echo $caseamt ?></p>
			</li>
		</ul>
	</div>
	<button><a href="<?php the_permalink(); ?>">상세보기</a></button>

	<?php endwhile; ?>
	<?php endif; ?>

	<!-- End Custom Field -->

</article> <!-- .et_pb_post -->
<?php
				the_post_thumbnail();
			endwhile;
			wp_reset_postdata();
		endif;
		die; // here we exit the script and even no wp_reset_query() required!
	}

	// ----- Custom Filter Module ----- //
	// Process Filter Requests

	add_action('wp_ajax_pmfilter', 'pm_filter_function'); // wp_ajax_{ACTION HERE} 
	add_action('wp_ajax_nopriv_myfilter', 'pm_filter_function');

	function pm_filter_function()
	{

		$args = array(
			'post_type' => 'cases'
		);

		$args['tax_query'] = array();

		$args['tax_query'] = array('relation' => 'AND');

		$alltermsind = get_terms('industry');
		$alltermsloc = get_terms('location');

		if (isset($_POST['cases-industry-filter']) && !empty($_POST['cases-industry-filter']))
			// $terms1[] = $_POST['cases-industry-filter'];
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'industry',
					'field' => 'id',
					'terms' => $_POST['cases-industry-filter']
				)
			);

		if (isset($_POST['cases-location-filter']) && !empty($_POST['cases-location-filter']))
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'location',
					'field' => 'id',
					'terms' => $_POST['cases-location-filter']
				)
			);

		if ((isset($_POST['cases-industry-filter']) && !empty($_POST['cases-industry-filter'])) && (isset($_POST['cases-location-filter']) && !empty($_POST['cases-location-filter'])))
			$args['tax_query'] = array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'industry',
					'field' => 'id',
					'terms' => $_POST['cases-industry-filter']
				),
				array(
					'taxonomy' => 'location',
					'field' => 'id',
					'terms' => $_POST['cases-location-filter']
				)
			);

		if ((!isset($_POST['cases-industry-filter']) && empty($_POST['cases-industry-filter'])) && (!isset($_POST['cases-location-filter']) && empty($_POST['cases-location-filter'])))
			$args['tax_query'] = array(
				// 'relation' => 'OR',
				array(
					'taxonomy' => 'industry',
					'field' => 'id',
					'terms' => $alltermsind
				),
				array(
					'taxonomy' => 'location',
					'field' => 'id',
					'terms' => $alltermsloc
				)
			);

		$query = new WP_Query($args); ?>

<div id="pm_posts_wrap" class="row">
	<?php
			if ($query->have_posts()) :
				while ($query->have_posts()) : $query->the_post();
					$pm_post = get_post();
					$pm_post_title = get_the_title();
					?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('et_pb_post col-12 col-sm-6 col-md-3'); ?>>

		<!-- Custom Field -->
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php echo $pm_post_title; ?></a></h2>

		<?php
								if (have_rows('case-attr')) : //parent group field
									while (have_rows('case-attr')) : the_row();
										// vars
										$caseres = get_sub_field('case-res');
										$caseamt = get_sub_field('case-amt');
										?>
		<div class="case-data">
			<ul>
				<li><span>분야:&nbsp</span>
					<p>
						<?php $terms = wp_get_post_terms($pm_post->ID, 'industry');
																if ($terms) {
																	$out = array();
																	foreach ($terms as $term) {
																		$out[] = $term->name;
																	}
																	echo join(', ', $out);
																} ?>
					</p>
				</li>
				<li><span>지역:&nbsp</span>
					<p>
						<?php $terms = wp_get_post_terms($pm_post->ID, 'location');
																if ($terms) {
																	$out = array();
																	foreach ($terms as $term) {
																		$out[] = $term->name;
																	}
																	echo join(', ', $out);
																} ?>
					</p>
				</li>
				<li><span>결과:&nbsp</span>
					<p><?php echo $caseres ?></p>
				</li>
				<li><span>분쟁액수:&nbsp</span>
					<p><?php echo $caseamt ?></p>
				</li>
			</ul>
		</div>
		<button><a href="<?php the_permalink(); ?>">상세보기</a></button>

		<?php endwhile; ?>
		<?php endif; ?>

		<!-- End Custom Field -->

	</article> <!-- .et_pb_post -->
	<?php
					the_post_thumbnail();
				endwhile;
				wp_reset_postdata();
			else :
				echo '필터 조건을 충족하는 검색결과가 없습니다.';
			endif;
			?>
</div>
<?php die();
}
// pm_paginator( $_POST['first_page'] );
// Create Custom Function for AJAX Pagination
function pm_paginator($first_page_url)
{

	// the function works only with $wp_query that's why we must use query_posts() instead of WP_Query()
	global $wp_query;

	// remove the trailing slash if necessary
	$first_page_url = untrailingslashit($first_page_url);


	// it is time to separate our URL from search query
	$first_page_url_exploded = array(); // set it to empty array
	$first_page_url_exploded = explode("/?", $first_page_url);
	// by default a search query is empty
	$search_query = '';
	// if the second array element exists
	if (isset($first_page_url_exploded[1])) {
		$search_query = "/?" . $first_page_url_exploded[1];
		$first_page_url = $first_page_url_exploded[0];
	}

	// get parameters from $wp_query object
	// how much posts to display per page (DO NOT SET CUSTOM VALUE HERE!!!)
	$posts_per_page = (int) $wp_query->query_vars['posts_per_page'];
	// current page
	$current_page = (int) $wp_query->query_vars['paged'];
	// the overall amount of pages
	$max_page = $wp_query->max_num_pages;

	// we don't have to display pagination or load more button in this case
	if ($max_page <= 1) return;

	// set the current page to 1 if not exists
	if (empty($current_page) || $current_page == 0) $current_page = 1;

	// you can play with this parameter - how much links to display in pagination
	$links_in_the_middle = 4;
	$links_in_the_middle_minus_1 = $links_in_the_middle - 1;

	// the code below is required to display the pagination properly for large amount of pages
	// I mean 1 ... 10, 12, 13 .. 100
	// $first_link_in_the_middle is 10
	// $last_link_in_the_middle is 13
	$first_link_in_the_middle = $current_page - floor($links_in_the_middle_minus_1 / 2);
	$last_link_in_the_middle = $current_page + ceil($links_in_the_middle_minus_1 / 2);

	// some calculations with $first_link_in_the_middle and $last_link_in_the_middle
	if ($first_link_in_the_middle <= 0) $first_link_in_the_middle = 1;
	if (($last_link_in_the_middle - $first_link_in_the_middle) != $links_in_the_middle_minus_1) {
		$last_link_in_the_middle = $first_link_in_the_middle + $links_in_the_middle_minus_1;
	}
	if ($last_link_in_the_middle > $max_page) {
		$first_link_in_the_middle = $max_page - $links_in_the_middle_minus_1;
		$last_link_in_the_middle = (int) $max_page;
	}
	if ($first_link_in_the_middle <= 0) $first_link_in_the_middle = 1;

	// begin to generate HTML of the pagination
	$pagination = '<nav id="pm_pagination" class="navigation pagination" role="navigation"><div class="nav-links">';

	// when to display "..." and the first page before it
	if ($first_link_in_the_middle >= 3 && $links_in_the_middle < $max_page) {
		$pagination .= '<a href="' . $first_page_url . $search_query . '" class="page-numbers">1</a>';

		if ($first_link_in_the_middle != 2)
			$pagination .= '<span class="page-numbers extend">...</span>';
	}

	// arrow left (previous page)
	if ($current_page != 1)
		$pagination .= '<a href="' . $first_page_url . '/page/' . ($current_page - 1) . $search_query . '" class="prev page-numbers">' . '<i class="fas fa-chevron-left"></i>' . '</a>';


	// loop page links in the middle between "..." and "..."
	for ($i = $first_link_in_the_middle; $i <= $last_link_in_the_middle; $i++) {
		if ($i == $current_page) {
			$pagination .= '<span class="page-numbers current">' . $i . '</span>';
		} else {
			$pagination .= '<a href="' . $first_page_url . '/page/' . $i . $search_query . '" class="page-numbers">' . $i . '</a>';
		}
	}

	// arrow right (next page)
	if ($current_page != $last_link_in_the_middle)
		$pagination .= '<a href="' . $first_page_url . '/page/' . ($current_page + 1) . $search_query . '" class="next page-numbers">' . '<i class="fas fa-chevron-right"></i>' . '</a>';


	// when to display "..." and the last page after it
	if ($last_link_in_the_middle < $max_page) {

		if ($last_link_in_the_middle != ($max_page - 1))
			$pagination .= '<span class="page-numbers extend">...</span>';

		$pagination .= '<a href="' . $first_page_url . '/page/' . $max_page . $search_query . '" class="page-numbers">' . $max_page . '</a>';
	}

	// end HTML
	$pagination .= "</div></nav>\n";

	// haha, this is our load more posts link
	if ($current_page < $max_page)
		$pagination .= '<div id="pm_loadmore">글 더보기</div>';

	// replace first page before printing it
	echo str_replace(array("/page/1?", "/page/1\""), array("?", "\""), $pagination);
}

// END PENTAMINT CUSTOM