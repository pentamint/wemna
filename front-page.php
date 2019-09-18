<?php

get_header();

$is_page_builder_used = et_pb_is_pagebuilder_used(get_the_ID());

?>

<div id="main-content">

	<?php if (!$is_page_builder_used) : ?>

		<div class="container">
			<div id="content-area" class="clearfix">
				<div id="left-area">

				<?php endif; ?>

				<?php while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<?php if (!$is_page_builder_used) : ?>

							<h1 class="entry-title main_title"><?php the_title(); ?></h1>
							<?php
							$thumb = '';

							$width = (int) apply_filters('et_pb_index_blog_image_width', 1080);

							$height = (int) apply_filters('et_pb_index_blog_image_height', 675);
							$classtext = 'et_featured_image';
							$titletext = get_the_title();
							$thumbnail = get_thumbnail($width, $height, $classtext, $titletext, $titletext, false, 'Blogimage');
							$thumb = $thumbnail["thumb"];

							if ('on' === et_get_option('divi_page_thumbnails', 'false') && '' !== $thumb)
								print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height);
							?>

						<?php endif; ?>

						<div class="entry-content">
							<?php
							the_content();

							if (!$is_page_builder_used)
								wp_link_pages(array('before' => '<div class="page-links">' . esc_html__('Pages:', 'Divi'), 'after' => '</div>'));
							?>
						</div> <!-- .entry-content -->

						<?php
						if (!$is_page_builder_used && comments_open() && 'on' === et_get_option('divi_show_pagescomments', 'false')) comments_template('', true);
						?>

					</article> <!-- .et_pb_post -->

				<?php endwhile; ?>

				<!-- Custom Row -->
				<div class="best_deals best_deals_wrapper">
					<div class="container">
						<h2 class="best_deals_row_title">조정사례</h2>
						<div class="row">
							<?php
							$query = new WP_Query(
								array('post_type' => 'deals', 'tag' => 'best')
							);

							if ($query->have_posts()) :
								while ($query->have_posts()) : $query->the_post(); ?>

									<article class="deals_item col-12 col-sm-6 col-md-3">
										<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

										<!-- Repeater Field -->
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
										<!-- End Repeater Field -->

									</article>

								<?php endwhile; ?>
							<?php endif; ?>
						</div> <!-- .row -->
						<div class="best_btn_group">
							<ul>
								<li class="view_more">
									<a href="/deals/">사례 더보기</a>
								</li>
							</ul>
						</div>
						<button><a href="/resolution/apply/">분쟁 조정 신청하기</a></button>
					</div> <!-- .container -->
				</div> <!-- .best_deals_wrapper -->
				<!-- End Custom Row -->

				<?php if (!$is_page_builder_used) : ?>

				</div> <!-- #left-area -->

				<?php get_sidebar(); ?>
			</div> <!-- #content-area -->
		</div> <!-- .container -->

	<?php endif; ?>

</div> <!-- #main-content -->

<?php

get_footer();
