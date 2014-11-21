<?php
/**
 * Template Name: Single Image
 */
get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>
	
	<div class="single-image" class="clearfix" data-background="<?php echo get_post_meta( $post->ID, 'krown_single_image_back', true) ; ?>">

		<div class="single-image-content">

			<?php 

			if ( get_post_meta( $post->ID, 'krown_single_image_obj1', true) != '' ) {
				echo '<div class="obj-1">' . get_post_meta( $post->ID, 'krown_single_image_obj1', true) . '</div>';
			}

			if ( get_post_meta( $post->ID, 'krown_single_image_obj2', true) != '' ) {
				echo '<div class="obj-2">' . get_post_meta( $post->ID, 'krown_single_image_obj2', true) . '</div>';
			}

			if ( get_post_meta( $post->ID, 'krown_single_image_obj3', true) != '' ) {
				echo '<div class="obj-3">' . get_post_meta( $post->ID, 'krown_single_image_obj3', true) . '</div>';
			}

			?>

		</div>

		<div id="single-image-loader"></div>

	</div>

	<?php endwhile; ?>

<?php get_footer(); ?>