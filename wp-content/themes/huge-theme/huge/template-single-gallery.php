<?php
/**
 * Template Name: Single Gallery
 */
get_header(); ?>

	<?php while ( have_posts() ) : the_post();

		$slides = explode( ',', get_post_meta( $post->ID, 'pp_gallery_slider', true ) );
		$thumbs_ratio = get_post_meta( $post->ID, 'thumbs_ratio', true );
		$retina = krown_retina();

	?>
	
	<div id="gallery" class="<?php echo $thumbs_ratio; ?> get-ratio clearfix">

		<?php if ( ! empty( $slides ) ) : 

			foreach ( $slides as $slide_id ) : 

				$img = wp_get_attachment_image_src( $slide_id, 'full' );

				switch ( $thumbs_ratio ) {
					case 'ratio_1-1':
						$thumb = $retina === 'true' ? aq_resize( $img[0], '680', '680', true, false ) : aq_resize( $img[0], '340', '340', true, false );
						break;
					case 'ratio_16-9':
						$thumb = $retina === 'true' ? aq_resize( $img[0], '680', '382', true, false ) : aq_resize( $img[0], '340', '191', true, false );
						break;
					case 'ratio_16-10':
						$thumb = $retina === 'true' ? aq_resize( $img[0], '680', '424', true, false ) : aq_resize( $img[0], '340', '212', true, false );
						break;
					default:
						$thumb = $retina === 'true' ? aq_resize( $img[0], '680', '510', true, false ) : aq_resize( $img[0], '340', '255', true, false );
						break;
				}

				if ( ! empty( $thumb ) ) : ?>

					<a href="<?php echo $img[0]; ?>" target="_blank" data-fancybox-group="gallery" class="gallery-item isotope-hidden fancybox"><img src="<?php echo $thumb[0]; ?>" width="<?php echo $thumb[1]; ?>" height="<?php echo $thumb[2]; ?>" alt="" /></a>

				<?php endif;

			endforeach;

		endif; ?>

	</div>

	<?php endwhile; ?>

<?php get_footer(); ?>