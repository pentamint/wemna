<?php get_header(); ?>

<div id="main-content">

	<!-- Custom Code -->
	<?php if ( is_active_sidebar ( 'fullwidth-header-banner' ) ) : ?>
		<div class="header-widget header-banner" role="complementary">
			<h2 class="custom-title">매물 검색하기</h2>
			<?php dynamic_sidebar ( 'fullwidth-header-banner' ); ?>
		</div>
	<?php endif; ?>
	<!-- Custom Code -->

	<div class="container">

		<!-- Custom Filter -->
	<?php if( have_rows('deal-attr') ): //parent group field ?> 

		<?php while( have_rows('deal-attr') ): the_row(); ?>
	
		<div id="archive-filters">

		<?php foreach( $GLOBALS['deal_query_filters'] as $key => $name ): ?>
			
				<?php

				// get the field's settings without attempting to load a value
				$field = get_sub_field_object($key, false, false);

				?>
			
				<?php
				// set value if available
				if( isset($_GET[ $name ]) ) {
					
					$field['value'] = explode(',', $_GET[ $name ]);
					
				}
			
				// create filter
				?>
			<div class="filter" data-filter="<?php echo $name; ?>">
				<?php create_field( $field ); ?>
			</div>
			
		<?php endforeach; ?>
		</div>

		<?php endwhile; ?>

	<?php endif; ?>


		<script type="text/javascript">
		(function($) {
			
			// change
			$('#archive-filters').on('change', 'input[type="select"]', function(){

				// vars
				var url = '<?php echo home_url('deals'); ?>';
					args = {};
					
				// loop over filters
				$('#archive-filters .filter').each(function(){
					
					// vars
					var filter = $(this).data('filter'),
						vals = [];
					
					// find checked inputs
					$(this).find('input:selected').each(function(){
			
						vals.push( $(this).val() );
			
					});
					
					// append to args
					args[ filter ] = vals.join(',');
					
				});
				
				// update url
				url += '?';
				
				// loop over args
				$.each(args, function( name, value ){
					
					url += name + '=' + value + '&';
					
				});
				
				// remove last &
				url = url.slice(0, -1);
				
				// reload page
				window.location.replace( url );
				
			});

		})(jQuery);
		</script>

		<!-- End Custom Filter -->

		<div id="content-area" class="clearfix">
			<div id="left-area">
		<?php
			if ( have_posts() ) :
				while ( have_posts() ) : the_post();
					$post_format = et_pb_post_format(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>

				<?php
					$thumb = '';

					$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

					$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
					$classtext = 'et_pb_post_main_image';
					$titletext = get_the_title();
					$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
					$thumb = $thumbnail["thumb"];

					et_divi_post_format_content();

					if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) {
						if ( 'video' === $post_format && false !== ( $first_video = et_get_first_video() ) ) :
							printf(
								'<div class="et_main_video_container">
									%1$s
								</div>',
								et_core_esc_previously( $first_video )
							);
						elseif ( ! in_array( $post_format, array( 'gallery' ) ) && 'on' === et_get_option( 'divi_thumbnails_index', 'on' ) && '' !== $thumb ) : ?>
							<a class="entry-featured-image-url" href="<?php the_permalink(); ?>">
								<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height ); ?>
							</a>
					<?php
						elseif ( 'gallery' === $post_format ) :
							et_pb_gallery_images();
						endif;
					} ?>

				<?php if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) : ?>
					<?php if ( ! in_array( $post_format, array( 'link', 'audio' ) ) ) : ?>
						<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php endif; ?>

					<?php
						et_divi_post_meta();

						if ( 'on' !== et_get_option( 'divi_blog_style', 'false' ) || ( is_search() && ( 'on' === get_post_meta( get_the_ID(), '_et_pb_use_builder', true ) ) ) ) {
							truncate_post( 270 );
						} else {
							the_content();
						}
					?>
				<?php endif; ?>

					<!-- Custom Field -->

					<div class="deal-data-container">

						<?php if( have_rows('deal-attr') ): //parent group field

							while( have_rows('deal-attr') ): the_row(); 

							// vars
							$industry = get_sub_field('industry');
							$threeperf = get_sub_field('3yr-perf');
							$location = get_sub_field('location');
							$saleprice = get_sub_field('sale-price');
							$subsbalance = get_sub_field('subs-balance');

						?>
						<div class="deal-data">
							<ul>
								<li><span>업종:&nbsp</span><p><?php echo $industry ?></p></li>
								<li><span>3년 누적실적:&nbsp</span><p><?php echo $threeperf ?></p></li>
								<li><span>지역:&nbsp</span><p><?php echo $location ?></p></li>
								<li><span>양도가:&nbsp</span><p><?php echo $saleprice ?></p></li>
								<li><span>출자좌수/잔액:&nbsp</span><p><?php echo $subsbalance ?></p></li>
							</ul>
						</div>
						<button><a href="<?php the_permalink(); ?>">상세보기</a></button>

					<?php endwhile; ?>
					<?php endif; ?>
				</div>

					<!-- End Custom Field -->

					</article> <!-- .et_pb_post -->
					
			<?php
					endwhile;

					if ( function_exists( 'wp_pagenavi' ) )
						wp_pagenavi();
					else
						get_template_part( 'includes/navigation', 'index' );
				else :
					get_template_part( 'includes/no-results', 'index' );
				endif;
			?>
			</div> <!-- #left-area -->

			<?php get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->
</div> <!-- #main-content -->

<?php

get_footer();
