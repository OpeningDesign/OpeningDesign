<?php
/**
 * The template for displaying search results.
 */
get_header(); ?>

	<?php if ( get_option(' krown_blog_style', 'blog-style-fixed' ) == 'blog-style-fixed' ) : ?>

		<?php if ( have_posts() ) : ?>

			<div class="clearfix blog-grid">

				<?php while ( have_posts() ) : the_post();
					get_template_part( 'content' );
				endwhile; ?>

			</div>

			<?php krown_pagination(); ?>

		<?php else : ?>

			<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'krown' ); ?></p>

		<?php endif; ?>

	<?php else : ?>

	<div class="post-body blog-grid-alt clearfix">

		<div class="page-content">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post();
					get_template_part( 'content' );
				endwhile; ?>

				<?php krown_pagination(); ?>

			<?php else : ?>

				<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'krown' ); ?></p>

			<?php endif; ?>

		</div>

		<?php krown_blog_sidebar(); ?>

	</div>

<?php endif; ?>
	
<?php get_footer(); ?>