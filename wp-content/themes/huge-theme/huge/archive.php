<?php
/**
 * The template for displaying archives.
 */
get_header(); ?>

	<?php if ( get_option(' krown_blog_style', 'blog-style-fixed' ) == 'blog-style-fixed' ) : ?>

		<div class="clearfix blog-grid">

			<?php while ( have_posts() ) : the_post();
				get_template_part( 'content' );
			endwhile; ?>

		</div>

		<?php krown_pagination(); ?>

	<?php else : ?>

	<div class="post-body blog-grid-alt clearfix">

		<div class="page-content">

			<?php while ( have_posts() ) : the_post();
				get_template_part( 'content' );
			endwhile; ?>

			<?php krown_pagination(); ?>

		</div>

		<?php krown_blog_sidebar(); ?>

	</div>

<?php endif; ?>

<?php get_footer(); ?>