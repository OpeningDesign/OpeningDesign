<?php
/**
 * Template Name: Gallery
 */
get_header(); ?>
	
	<div id="portfolio-holder" class="clearfix <?php echo get_option( 'krown_gal_hover_3d' ); ?>">

		<?php while (have_posts()) : the_post();

			/* Get Portfolio Variables */

			$thumbs_ratio = get_option( 'krown_gal_thumbs_ratio', 'ratio_4-3' );
			$thumbs_width = get_option( 'krown_gal_thumbs_width', '340' );

			$gallery_filter = isset( $_GET['filter'] ) ? $_GET['filter'] : '';

			// Retina ready

			$retina = krown_retina();
			if ( $retina === 'true' ) {
				$thumbs_width *= 2;
			}

		?>

		<section id="portfolio" class="folio-grid <?php echo $thumbs_ratio; ?> get-ratio clearfix" data-url="<?php echo substr( get_permalink(), strpos( get_permalink(), '/', 9) ); ?>">

			<?php 

			/* Query */

			$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );

			$args = array( 
				'posts_per_page' => ( get_option( 'krown_gallery_pagination', 'folio-pagination-off' ) == 'folio-pagination-on' ? get_option( 'krown_gallery_items', '24' ) : -1 ), 
				'offset'=> 0,
				'gallery_category' => $gallery_filter,
				'post_type' => 'gallery',
				'paged' => $paged 
			);

			$all_posts = new WP_Query( $args );

			while( $all_posts->have_posts() ) : $all_posts->the_post();

				$thumb = get_post_thumbnail_id();
				$img_url = wp_get_attachment_url( $thumb, 'full' );
				switch ( $thumbs_ratio ) {
					case 'ratio_1-1':
						$image = aq_resize( $img_url, $thumbs_width, $thumbs_width, true, false );
						break;
					case 'ratio_16-9':
						$image = aq_resize( $img_url, $thumbs_width, floor($thumbs_width / 1.77777 ), true, false );
						break;
					case 'ratio_16-10':
						$image = aq_resize( $img_url, $thumbs_width, floor($thumbs_width / 1.6 ), true, false );
						break;
					default:
						$image = aq_resize( $img_url, $thumbs_width, floor($thumbs_width / 1.33333 ), true, false );
				}

				if ( get_post_meta( $post->ID, 'krown_project_custom_url', true ) != '' ) {
					$project_url_atts = 'href="' . get_post_meta( $post->ID, 'krown_project_custom_url', true ) . '" target="' . get_post_meta( $post->ID, 'krown_project_custom_target', true ) . '" data-custom-url="yes"';
				} else {
					$project_url_atts = 'href="' . get_permalink() . '"';
				}

			?>

			<a id="post-<?php echo $post->ID; ?>" class="folio-item <?php krown_categories( $post->ID, 'gallery_category', ' ', 'slug' ); ?> <?php echo $thumbs_ratio; ?> bg-dark-<?php echo get_option( 'krown_gal_hover_bg', 'false' ); ?> isotope-hidden" href="<?php echo get_permalink(); ?>" data-custom-filter="0" data-slug="<?php echo $post->post_name; ?>" data-title="<?php echo get_the_title( $post->ID ) . ' | ' . get_bloginfo( 'name' ); ?>" data-type="horizontal">

				<div class="folio-cube">
					<div class="front">
						<img src="<?php echo $image[0]; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" alt="<?php the_title(); ?>" />
					</div>
					<div class="bottom" style="background-color: <?php echo get_post_meta( $post->ID, '_thumb_color', true); ?>">
						<div class="folio-caption">
							<h3><?php the_title(); ?></h3>
							<span><?php krown_categories( $post->ID, 'gallery_category' ); ?></span>
						</div>
					</div>
				</div>

			</a>

			<?php endwhile; ?>

		</section>

		<?php krown_pagination( $all_posts, true );

		endwhile; ?>

	</div>

<?php get_footer(); ?>