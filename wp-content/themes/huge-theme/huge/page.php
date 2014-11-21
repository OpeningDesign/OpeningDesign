<?php
/**
 * The Template for displaying all pages.
 */
get_header(); ?>

	<?php if ( have_posts() ) while ( have_posts() ) : the_post();

		$custom_header = get_post_meta( $post->ID, 'krown_custom_header_set', true); 

		?>

		<article class="<?php echo $custom_header; ?>">

			<?php if ( $custom_header == 'w-custom-header' ) : ?>

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