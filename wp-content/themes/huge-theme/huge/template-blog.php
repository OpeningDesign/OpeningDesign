<?php
/**
 * Template Name: Blog
 */
get_header(); ?>

	<?php while ( have_posts() ) : the_post();

		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );

		$args = array(
			'paged' => $paged, 
			'post_type' => 'post'
		);
		$all_posts = new WP_Query( $args );

	?>
		<?php if ( get_option(' krown_blog_style', 'blog-style-fixed' ) == 'blog-style-fixed' ) : ?>

			<div class="clearfix blog-grid">

				<?php while( $all_posts->have_posts() ) : $all_posts->the_post();

					get_template_part( 'content' );

				endwhile; ?>

			</div>

			<?php krown_pagination( $all_posts ); ?>

		<?php else : ?>

		<div class="post-body blog-grid-alt clearfix">

			<div class="page-content">

				<?php while( $all_posts->have_posts() ) : $all_posts->the_post();

					get_template_part( 'content' );

				endwhile; ?>

				<?php krown_pagination( $all_posts ); ?>

			</div>

			<?php krown_blog_sidebar(); ?>

		</div>

		<?php endif; ?>

	<?php endwhile; ?>

<?php get_footer(); ?>