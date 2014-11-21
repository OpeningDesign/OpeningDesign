<?php
/**
 * Template Name: Contact
 */
get_header(); ?>

	<?php if ( have_posts() ) while ( have_posts() ) : the_post();

		$custom_header = get_post_meta( $post->ID, 'krown_custom_header_set', true); 

		if ( get_post_meta( $post->ID, 'krown_show_map', true ) == 'w-custom-header-map') {

			// Set map variables
			
			$custom_header = 'w-custom-header';
			$show_map = true;

			// Load the proper javascript

			wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?sensor=false', NULL, true );

		} else {
			$show_map = false;
		}

		?>

		<article class="<?php echo $custom_header; ?> map-<?php echo $show_map; ?>">

			<?php if ( $custom_header == 'w-custom-header' && ! $show_map ) : ?>

				<header class="format-image">

					<div class="post-format-content is-other" data-background="<?php echo get_post_meta( $post->ID, 'krown_custom_header_img', true); ?>">

						<div class="page-title-holder-1"><div class="page-title-holder-2">
							<h1 class="page-title" style="color:<?php echo get_post_meta( $post->ID, 'krown_custom_header_color', true ); ?>">
								<?php the_title(); ?>
								<span><?php echo get_post_meta( $post->ID, 'krown_custom_header_subtitle', true); ?></span>
							</h1>
						</div></div>

					</div>

				</header>

			<?php elseif ( $custom_header == 'w-custom-header' && $show_map ) : ?>

				<header class="format-image a-map" data-map-lat="<?php echo get_post_meta( $post->ID, 'krown_map_lat', true ); ?>" data-map-long="<?php echo get_post_meta( $post->ID, 'krown_map_long', true ); ?>" data-marker-img="<?php echo get_post_meta( $post->ID, 'krown_map_img', true ); ?>" data-zoom="<?php echo get_post_meta( $post->ID, 'krown_map_zoom', true ); ?>" data-greyscale="d-<?php echo get_post_meta( $post->ID, 'krown_map_style', true ); ?>" data-marker="d-<?php echo get_post_meta( $post->ID, 'krown_map_marker', true ); ?>">

					<div class="post-format-content is-other">
						<div id="insert-map"></div>
					</div>

				</header>

			<?php endif; ?>

			<div class="page-content">

				<?php if ( $custom_header == 'wout-custom-header' ) : ?>
					<h1 class="page-title"><?php the_title(); ?></h1>
				<?php endif; 

				the_content();
				wp_link_pages();

				if( comments_open() && ot_get_option( 'rb_allow_page_comments', 'false' ) == 'true' ) {
					comments_template( '', true );
				}

				?>

			</div>

		</article>

		<?php krown_page_sidebar( $post->ID ); ?>

	<?php endwhile;     

get_footer(); ?>