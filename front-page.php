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

				<!-- Best Mediators Row -->
				<div class="best_mediators best_mediators_wrapper">
					<div class="container">
						<h2 class="best_mediators_row_title">조정인 소개</h2>
						<div class="row">
							<?php
							$query = new WP_Query(
								array('post_type' => 'mediators', 'tag' => 'best', 'posts_per_page' => '4',)
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
														?>
												<a class="entry-featured-image-url" href="<?php the_permalink(); ?>">
													<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height); ?>
												</a>
												<div class="mediator-more"><a href="<?php the_permalink(); ?>">더 알아보기</a></div>
											</div>
											<div class="article-content">
												<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
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

												<!-- Repeater Field -->
												<div class="const-data-container">

													<?php if (have_rows('consultant-attr')) : //parent group field

																while (have_rows('consultant-attr')) : the_row();

																	// vars
																	$const_phone = get_sub_field('const-phone');
																	$const_email = get_sub_field('const-email');
																	$const_tcount = get_sub_field('const-tcount');
																	$const_yr = get_sub_field('const-yr');
																	$const_popular = get_sub_field('const-popular');

																	?>
															<div class="const-deal-data">
																<ul>
																	<li><span>지역:&nbsp</span>
																		<p>
																			<?php $terms = wp_get_post_terms($post->ID, 'clocation');
																							if ($terms) {
																								$out = array();
																								foreach ($terms as $term) {
																									$out[] = $term->name;
																								}
																								echo join(', ', $out);
																							} ?>
																		</p>
																	</li>
																	<li><span>전문분야:&nbsp</span>
																		<p>
																			<?php $terms = wp_get_post_terms($post->ID, 'specialty');
																							if ($terms) {
																								$out = array();
																								foreach ($terms as $term) {
																									$out[] = $term->name;
																								}
																								echo join(', ', $out);
																							} ?>
																		</p>
																	</li>
																	<li><span>조정 성사 건수:&nbsp</span>
																		<p><?php print_r($const_tcount) ?></p>
																	</li>
																	<li><span>조정 경력:&nbsp</span>
																		<p><?php print_r($const_yr) ?>년</p>
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
								<li class="best_apply">
									<a href="/apply/">조정인 등록 신청하기</a>
								</li>
							</ul>
						</div>
					</div> <!-- .container -->
				</div> <!-- .best_mediators_wrapper -->
				<!-- End Best Mediators Row -->

				<!-- Best cases Row -->
				<div class="best_cases best_cases_wrapper">
					<div class="container">
						<h2 class="best_cases_row_title">조정사례</h2>
						<div class="row">
							<?php
							$query = new WP_Query(
								array('post_type' => 'cases', 'tag' => 'best')
							);

							if ($query->have_posts()) :
								while ($query->have_posts()) : $query->the_post(); ?>

									<article class="cases_item col-12 col-sm-6 col-md-3">
										<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

										<!-- Repeater Field -->
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
																<?php $terms = wp_get_post_terms($post->ID, 'industry');
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
																<?php $terms = wp_get_post_terms($post->ID, 'location');
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
										<!-- End Repeater Field -->

									</article>

								<?php endwhile; ?>
							<?php endif; ?>
						</div> <!-- .row -->
						<div class="best_btn_group">
							<ul>
								<li class="view_more">
									<a href="/cases/">사례 더보기</a>
								</li>
								<li class="best_apply">
									<a href="/procedure/apply/">분쟁 조정 신청하기</a>
								</li>
							</ul>
						</div>
					</div> <!-- .container -->
				</div> <!-- .best_cases_wrapper -->
				<!-- End Best cases Row -->

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
