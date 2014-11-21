<?php
/**
 * Template Name: Twofolio
 */
get_header(); 

/* PLEASE READ!! There are three places where you want to change "twofolio" into your custom post type name.

	1. At line 38: 'post_type' => 'twofolio'
	2. In the two places where it appears as 'twofolio_category'

*/

?>

	<div id="portfolio-holder" class="clearfix <?php echo get_option( 'krown_hover_3d' ); ?>">

		<?php while (have_posts()) : the_post();

			/* Get Twofolio Variables */

			$thumbs_ratio = get_option( 'krown_thumbs_ratio', 'ratio_4-3' );
			$thumbs_width = get_option( 'krown_thumbs_width', '340' );
			
			// Retina ready

			global $retina;
			if ( $retina === 'true' ) {
				$thumbs_width *= 2;
			}

			$portfolio_filter = isset( $_GET['filter'] ) ? $_GET['filter'] : '';

		?>

		<section id="portfolio" class="folio-grid <?php echo $thumbs_ratio; ?> get-ratio clearfix" data-url="<?php echo substr( get_permalink(), strpos( get_permalink(), '/', 9) ); ?>">

			<?php 

			/* Query */

			$paged_string = is_home() || is_front_page() ? 'page' : 'paged';
			$paged = get_query_var( $paged_string ) ? get_query_var( $paged_string ) : 1;

			$args = array( 
				'posts_per_page' => -1, 
				'offset'=> 0,
				'post_type' => 'twofolio',
				'paged' => $paged_string 
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

			<a id="post-<?php echo $post->ID; ?>" class="folio-item <?php krown_categories( $post->ID, 'twofolio_category', ' ', 'slug' ); ?> <?php echo $thumbs_ratio; ?> bg-dark-<?php echo get_option( 'krown_hover_bg', 'false' ); ?> isotope-hidden" <?php echo $project_url_atts; ?> data-custom-filter="0" data-slug="<?php echo $post->post_name; ?>" data-title="<?php echo get_the_title( $post->ID ) . ' | ' . get_bloginfo( 'name' ); ?>" data-type="<?php echo get_post_meta( $post->ID, 'krown_project_type', true ); ?>">

				<div class="folio-cube">
					<div class="front">
						<img src="<?php echo $image[0]; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" alt="<?php the_title(); ?>" />
					</div>
					<div class="bottom" <?php if( get_option( 'krown_hover_color', 'true' ) == 'true' ) : ?> style="background-color: <?php echo get_post_meta( $post->ID, '_thumb_color', true); ?>"<?php endif; ?>>
						<div class="folio-caption">
							<h3><?php the_title(); ?></h3>
							<span><?php krown_categories( $post->ID, 'twofolio_category' ); ?></span>
						</div>
					</div>
				</div>

			</a>

			<?php endwhile; ?>

		</section>

		<?php endwhile; ?>

	</div>

<?php get_footer(); ?>