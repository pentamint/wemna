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

// Register Custom Sidebar
function wemna_widgets_init()
{
	register_sidebar(array(
		'name'          => 'Fullwidth Header Banner', 'WeMnA',
		'id'            => 'fullwidth-header-banner',
		'description'   => 'Add widgets here.', 'WeMnA',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));
}
add_action('widgets_init', 'wemna_widgets_init');

// Register Custom Scripts
function wemna_scripts()
{
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
add_action('wp_enqueue_scripts', 'wemna_scripts');

// Create CPT M&A매물
function deals_init()
{
	$labels = array(
		'name'                => __('M&A매물'),
		'singular_name'       => __('M&A매물'),
		'menu_name'           => __('M&A매물'),
		'parent_item_colon'   => __('상위 M&A매물:'),
		'all_items'           => __('M&A매물 전체보기'),
		'view_item'           => __('M&A매물 보기'),
		'add_new_item'        => __('신규 M&A매물 등록하기'),
		'add_new'             => __('신규 등록하기'),
		'edit_item'           => __('M&A매물 수정하기'),
		'update_item'         => __('M&A매물 적용하기'),
		'search_items'        => __('M&A매물 검색하기'),
		'not_found'           => __('매물이 없습니다.'),
		'not_found_in_trash'  => __('휴지통에 매물이 없습니다.')
	);
	$args = array(
		'label'               => __('deals'),
		'description'         => __('WeMnA M&A매물'),
		'labels'              => $labels,
		'supports'            => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields'),
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
	register_post_type('deals', $args);
}
add_action('init', 'deals_init');

// Add Custom Taxonomy Industry for CPT Deals
function deals_custom_taxonomy_industry()
{
	$labels = array(
		'name' => _x('업종', 'taxonomy general name'),
		'singular_name' => _x('업종', 'taxonomy singular name'),
		'search_items' =>  __('업종 검색하기'),
		'all_items' => __('업종 전체보기'),
		'parent_item' => __('상위 업종'),
		'parent_item_colon' => __('상위 업종:'),
		'edit_item' => __('업종 수정하기'),
		'update_item' => __('업종 적용하기'),
		'add_new_item' => __('신규 업종 등록하기'),
		'new_item_name' => __('신규 업종 이름'),
		'menu_name' => __('업종'),
	);
	register_taxonomy('industry', array('deals'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'industry'),
	));
}
add_action('init', 'deals_custom_taxonomy_industry', 0);

// Add Custom Taxonomy Locations for CPT Deals
function deals_custom_taxonomy_location()
{
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
	register_taxonomy('location', array('deals'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'location'),
	));
}
add_action('init', 'deals_custom_taxonomy_location', 0);

// Create Custom Post Type 컨설턴트
function consultants_init()
{
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
			'page-attributes',
		)
	);
	register_post_type('consultants', $args);
}
add_action('init', 'consultants_init');

// Add Custom Taxonomy Specialty for CPT Consultants
function consultants_custom_taxonomy_specialty()
{
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
	register_taxonomy('specialty', array('consultants'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'specialty'),
	));
}
add_action('init', 'consultants_custom_taxonomy_specialty', 0);

// Add Custom Taxonomy Specialty for CPT Consultants
function consultants_custom_taxonomy_clocation()
{
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
	register_taxonomy('clocation', array('consultants'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'clocation'),
	));
}
add_action('init', 'consultants_custom_taxonomy_clocation', 0);

/*
    in this example I have a repeater field named "consultant-attr"
    one of the rows of this repeater is named "const-area"
    and I want to be able to search, sort and filter by this field
*/

// create a function that will convert this repeater during the acf/save_post action
// priority of 20 to run after ACF is done saving the new values
add_filter('acf/save_post', 'convert_constarea_to_standard_wp_meta', 20);

function convert_constarea_to_standard_wp_meta($post_id)
{

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
function wp_42573_fix_template_caching(WP_Screen $current_screen)
{
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

/**
 * Custom AJAX Filters - Load More & Paginations
 */
// Enqueue Load snMore Script
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

			<article id="post-<?php the_ID(); ?>" <?php post_class('et_pb_post col-12 col-sm-6 col-md-4'); ?>>

				<!-- Custom Field -->
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php echo $pm_post_title; ?></a></h2>

				<?php
				if (have_rows('deal-attr')) : //parent group field
					while (have_rows('deal-attr')) : the_row();
						// vars
						$threeperf = get_sub_field('3yr-perf');
						$saleprice = get_sub_field('sale-price');
						$subsbalance = get_sub_field('subs-balance');
						?>
						<div class="deal-data">
							<ul>
								<li><span>업종:&nbsp</span>
									<p>
										<?php $terms = wp_get_post_terms($pm_post->ID, 'industry');
										if ($terms) {
											$out = array();
											foreach ($terms as $term) {
												// $out[] = '<a class="' . $term->slug . '" href="' . get_term_link($term->slug, 'industry') . '">' . $term->name . '</a>';
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
												// $out[] = '<a class="' . $term->slug . '" href="' . get_term_link($term->slug, 'location') . '">' . $term->name . '</a>';
												$out[] = $term->name;
											}
											echo join(', ', $out);
										} ?>
									</p>
								</li>
								<li><span>3년 누적실적:&nbsp</span>
									<p><?php echo $threeperf ?></p>
								</li>
								<li><span>양도가:&nbsp</span>
									<p><?php echo $saleprice ?></p>
								</li>
								<li><span>출자좌수/잔액:&nbsp</span>
									<p><?php echo $subsbalance ?></p>
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
		'orderby' => 'date', // we will sort posts by date
		'order'	=> $_POST['date'], // ASC or DESC
		'post_type' => 'deals'
	);

	$args['tax_query'] = array();

	$args['tax_query'] = array('relation' => 'AND');

	if (isset($_POST['deals-industry-filter']) && !empty($_POST['deals-industry-filter']))
		// $terms1[] = $_POST['deals-industry-filter'];
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'industry',
				'field' => 'id',
				'terms' => $_POST['deals-industry-filter']
			)
		);

	if (isset($_POST['deals-location-filter']) && !empty($_POST['deals-location-filter']))
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'location',
				'field' => 'id',
				'terms' => $_POST['deals-location-filter']
			)
		);

	if ((isset($_POST['deals-industry-filter']) && !empty($_POST['deals-industry-filter'])) && (isset($_POST['deals-location-filter']) && !empty($_POST['deals-location-filter'])))
		$args['tax_query'] = array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'industry',
				'field' => 'id',
				'terms' => $_POST['deals-industry-filter']
			),
			array(
				'taxonomy' => 'location',
				'field' => 'id',
				'terms' => $_POST['deals-location-filter']
			)
		);

	$query = new WP_Query($args); ?>

	<div id="pm_posts_wrap" class="row">
		<?php
		if ($query->have_posts()) :
			while ($query->have_posts()) : $query->the_post();
				$post = get_post();
				$pm_post_title = get_the_title();
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class('et_pb_post col-12 col-sm-6 col-md-4'); ?>>

					<!-- Custom Field -->
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php echo $pm_post_title; ?></a></h2>

					<?php
					if (have_rows('deal-attr')) : //parent group field
						while (have_rows('deal-attr')) : the_row();
							// vars
							$threeperf = get_sub_field('3yr-perf');
							$saleprice = get_sub_field('sale-price');
							$subsbalance = get_sub_field('subs-balance');
							?>
							<div class="deal-data">
								<ul>
									<li><span>업종:&nbsp</span>
										<p>
											<?php $terms = wp_get_post_terms($post->ID, 'industry');
											if ($terms) {
												$out = array();
												foreach ($terms as $term) {
													// $out[] = '<a class="' . $term->slug . '" href="' . get_term_link($term->slug, 'industry') . '">' . $term->name . '</a>';
													$out[] = $term->name;
												}
												echo join(', ', $out);
											} ?>
										</p>
									</li>
									<li><span>지역:&nbsp</span>
										<p>
											<?php $terms = wp_get_post_terms($post->ID, 'location');
											if ($terms) {
												$out = array();
												foreach ($terms as $term) {
													// $out[] = '<a class="' . $term->slug . '" href="' . get_term_link($term->slug, 'location') . '">' . $term->name . '</a>';
													$out[] = $term->name;
												}
												echo join(', ', $out);
											} ?>
										</p>
									</li>
									<li><span>3년 누적실적:&nbsp</span>
										<p><?php echo $threeperf ?></p>
									</li>
									<li><span>양도가:&nbsp</span>
										<p><?php echo $saleprice ?></p>
									</li>
									<li><span>출자좌수/잔액:&nbsp</span>
										<p><?php echo $subsbalance ?></p>
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
