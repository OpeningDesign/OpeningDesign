<?php
/**
 * The Template for displaying all single posts.
 */
get_header(); ?>

	<?php if ( have_posts() ) while ( have_posts() ) : the_post();

		$post_format = get_post_format() == '' ? 'standard' : get_post_format(); ?>

		<article id="post-<?php echo $post->ID; ?>" class="format-<?php echo $post_format; ?> post-body clearfix">

				<div class="page-content">

					<div class="post-format-content is-<?php echo $post_format == 'gallery' ? 'gallery' : 'other'; ?>">

						<?php krown_post_format_content( $post->ID, $post_format ); ?>

					</div>

					<header class="post-header clearfix">

						<h1 class="post-title"><?php the_title(); ?></h1>

						<ul class="post-meta">
							<li class="category"><?php krown_categories( $post->ID, 'category', ', ', 'name', true, true ); ?></li>
							<li class="author"><?php the_author_posts_link(); ?></li>
							<li class="date"><?php the_time( __( 'd M Y', 'krown' ) ); ?></li>
							<li class="comments"><?php comments_number( __( '0 Comments', 'krown' ), __( '1 Comments', 'krown' ) ); ?></li>
						</ul>

					</header>

					<section class="post-content">
						<?php
							the_content();
							wp_link_pages( array(
								'before' => '<p class="wp-link-pages"><span>' . __( 'Pages:', 'krown' ) . '</span>'
								)
							);
						?>
					</section>

					<div class="post-tags"><?php the_tags( __( 'Tagged with: ', 'krown' ) ); ?></div>

					<footer class="post-footer me-buttons-alt clearfix"> 

						<?php 

						next_post_link( '%link',  '<i class="krown-icon-arrow_left"></i>' . __( 'Previous Post', 'krown' ) );
						krown_share_buttons( $post->ID, 'single' );
						previous_post_link( '%link', __( 'Next Post', 'krown' ) . '<i class="krown-icon-arrow_right"></i>'  ); 

						?>

					</footer>

					<?php if( comments_open() )
						comments_template( '', true ); ?>

				</div>

			<?php krown_blog_sidebar(); ?>

		</article>

	<?php endwhile; ?>

<?php get_footer(); ?>