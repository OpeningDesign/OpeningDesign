<?php
/**
 * Template Name: Fullscreen Slider
 */
get_header(); ?>

	<?php while ( have_posts() ) : the_post();

		$slides = get_post_meta( $post->ID, 'krown_slideshow_slider', true );

	?>
	
	<div id="slideshow" class="swiper-container horizontal-gallery swiper-container align-middle fill clearfix">

		<div class="swiper-wrapper">

		<?php if ( ! empty( $slides ) ) : ?>

			<?php foreach ( $slides as $slide ) : ?>

				<div class="swiper-slide">

					<img src="<?php echo $slide['image']; ?>" />

					<?php if ( $slide['img_obj1'] != '' ) : ?>

					<span class="single-image">

						<span class="single-image-content">

							<?php 

							if ( $slide['img_obj1'] != '' ) {
								echo '<span class="obj-1">' . $slide['img_obj1'] . '</span>';
							}

							if ( $slide['img_obj2'] != '' ) {
								echo '<span class="obj-2">' . $slide['img_obj2'] . '</span>';
							}

							if ( $slide['img_obj3'] != '' ) {
								echo '<span class="obj-3">' . $slide['img_obj3'] . '</span>';
							}

							?>

						</span>

					</span>

					<?php endif; ?>

				</div>

			<?php endforeach; ?>

		<?php endif; ?>

		</div>

	</div>

	<?php endwhile; ?>

<?php get_footer(); ?>