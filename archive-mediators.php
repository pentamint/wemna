<?php get_header(); ?>

<div id="main-content">

	<!-- Custom Code -->
	<?php if (is_active_sidebar('fullwidth-header-banner')) : ?>
		<div class="header-widget header-banner" role="complementary">
			<h2 class="custom-title">조정인 검색하기</h2>
			<?php dynamic_sidebar('fullwidth-header-banner'); ?>
		</div>
	<?php endif; ?>
	<!-- Custom Code -->

	<div class="container">

		<!-- Custom Filter -->

		<div id="content-area" class="clearfix">
			<div id="left-area" class="row">
				<?php
				if (have_posts()) :
					while (have_posts()) : the_post();
						$post_format = et_pb_post_format(); ?>

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

									<!-- Custom Field -->

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

									<!-- End Custom Field -->
								</div> <!-- .article-content -->
							</div> <!-- .article-content-wrapper -->
						</article> <!-- .et_pb_post -->

				<?php
					endwhile;

					if (function_exists('wp_pagenavi'))
						wp_pagenavi();
					else
						get_template_part('includes/navigation', 'index');
				else :
					get_template_part('includes/no-results', 'index');
				endif;
				?>
			</div> <!-- #left-area -->

			<?php get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->
</div> <!-- #main-content -->

<?php

get_footer();
