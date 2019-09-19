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

				<!-- Custom Code -->

				<!-- Best Deals Row -->
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
						<div><a href="/resolution/apply/">분쟁 조정 신청하기</a></div>
					</div> <!-- .container -->
				</div> <!-- .best_deals_wrapper -->
				<!-- End Best Deals Row -->

				<!-- Best Mediators Row -->
				<div class="best_mediators_wrapper">
					<div class="container">
						<h2 class="best_mediators_row_title">조정인 소개</h2>
						<div class="row">
							<?php
							$query = new WP_Query(
								array('post_type' => 'mediators', 'tag' => 'best')
							);

							if ($query->have_posts()) :
								while ($query->have_posts()) : $query->the_post(); ?>

									<article id="post-<?php the_ID(); ?>" <?php post_class('et_pb_post col-12 col-lg-6'); ?>>
										<div class="article-content-wrapper">

											<div class="article-img">
												<?php
														$thumb = '';

														$width = (int) apply_filters('et_pb_index_blog_image_width', 1080);

														$height = (int) apply_filters('et_pb_index_blog_image_height', 675);
														$classtext = 'et_pb_post_main_image';
														$titletext = get_the_title();
														$thumbnail = get_thumbnail($width, $height, $classtext, $titletext, $titletext, false, 'Blogimage');
														$thumb = $thumbnail["thumb"];

														et_divi_post_format_content();

														if (!in_array($post_format, array('link', 'audio', 'quote'))) {
															if ('video' === $post_format && false !== ($first_video = et_get_first_video())) :
																printf(
																	'<div class="et_main_video_container">
									%1$s
								</div>',
																	et_core_esc_previously($first_video)
																);
															elseif (!in_array($post_format, array('gallery')) && 'on' === et_get_option('divi_thumbnails_index', 'on') && '' !== $thumb) : ?>
														<a class="entry-featured-image-url" href="<?php the_permalink(); ?>">
															<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height); ?>
														</a>
												<?php
															elseif ('gallery' === $post_format) :
																et_pb_gallery_images();
															endif;
														} ?>
												<div class="mediator-more"><a href="<?php the_permalink(); ?>">더 알아보기</a></div>
											</div>
											<div class="article-content">
												<?php if (!in_array($post_format, array('link', 'audio', 'quote'))) : ?>
													<?php if (!in_array($post_format, array('link', 'audio'))) : ?>
														<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
													<?php endif; ?>

													<?php et_divi_post_meta(); ?>

													<div class="article-post-content">
														<?php
																	if ('on' !== et_get_option('divi_blog_style', 'false') || (is_search() && ('on' === get_post_meta(get_the_ID(), '_et_pb_use_builder', true)))) {
																		truncate_post(270);
																	} else {
																		the_content();
																	}
																	?>
													</div>

												<?php endif; ?>

												<!-- Repeater Field -->
												<div class="const-data-container">

													<?php if (have_rows('consultant-attr')) : //parent group field

																while (have_rows('consultant-attr')) : the_row();

																	// vars
																	$const_num = get_sub_field('const-num');
																	$const_name = get_sub_field('const-name');
																	$const_phone = get_sub_field('const-phone');
																	$const_email = get_sub_field('const-email');
																	$const_area = get_sub_field('const-area');
																	$const_specialty = get_sub_field('const-specialty');
																	$const_avail = get_sub_field('const-avail');
																	$const_tamount = get_sub_field('const-tamount');
																	$const_tcount = get_sub_field('const-tcount');
																	$const_popular = get_sub_field('const-popular');

																	?>
															<div class="const-deal-data">
																<ul>
																	<li><span>전화번호:&nbsp</span>
																		<p><?php print_r($const_phone) ?></p>
																	</li>
																	<li><span>이메일:&nbsp</span>
																		<p><?php print_r($const_email) ?></p>
																	</li>
																	<li><span>지역:&nbsp</span>
																		<p><?php print_r($const_area) ?></p>
																	</li>
																	<li><span>전문분야:&nbsp</span>
																		<p><?php print_r($const_specialty) ?></p>
																	</li>
																	<li><span>고객 선호도:&nbsp</span>
																		<p><?php print_r($const_popular) ?></p>
																	</li>
																</ul>
															</div>

														<?php endwhile; ?>
													<?php endif; ?>
												</div> <!-- .const-data-container -->
												<!-- End Repeater Field -->

											</div> <!-- .article-content -->
										</div> <!-- .article-content-wrapper -->
									</article>

								<?php endwhile; ?>
							<?php endif; ?>
						</div> <!-- .row -->
						<div class="best_btn_group">
							<ul>
								<li class="view_more">
									<a href="/mediators/">조정인 더보기</a>
								</li>
							</ul>
						</div>
						<div><a href="/resolution/apply/">분쟁 조정 신청하기</a></div>
					</div> <!-- .container -->
				</div> <!-- .best_mediators_wrapper -->
				<!-- End Best Mediators Row -->

				<!-- End Custom Code -->

				<?php if (!$is_page_builder_used) : ?>

				</div> <!-- #left-area -->

				<?php get_sidebar(); ?>
			</div> <!-- #content-area -->
		</div> <!-- .container -->

	<?php endif; ?>

</div> <!-- #main-content -->

<?php

get_footer();
