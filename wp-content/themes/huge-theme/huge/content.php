<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 */
?>

	<?php 

	$post_format = get_post_format() == '' ? 'standard' : get_post_format();
	
	if ( get_option(' krown_blog_style', 'blog-style-fixed' ) == 'blog-style-fixed' ) : ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class('isotope-hidden clearfix'); ?>>

			<?php krown_post_format_content( $post->ID, $post_format, true ); ?>

			<div class="post-content clearfix">

				<h2 class="post-title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>

				<p class="post-excerpt"><?php echo krown_excerpt( 'krown_excerptlength_post'); ?></p>

				<ul class="post-meta">
					<li class="date"><a href="<?php echo get_permalink(); ?>"><?php the_time( __( 'd M Y', 'krown' ) ); ?></a></li>
					<li class="comments"><a href="<?php echo get_permalink(); ?>#comments"><?php comments_number( __( '0 Comments', 'krown' ), __( '1 Comments', 'krown' ) ); ?></a></li>
				</ul>

			</div>

		</article>

	<?php else : ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

			<div class="post-content clearfix">

				<?php if ( $post_format != 'link' && $post_format != 'quote' ) : ?>

					<h2 class="post-title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>

					<ul class="post-meta">
							<li class="category"><?php krown_categories( $post->ID, 'category', ', ', 'name', true, true ); ?></li>
							<li class="author"><?php the_author_posts_link(); ?></li>
							<li class="date"><a href="<?php echo get_permalink(); ?>"><?php the_time( __( 'd M Y', 'krown' ) ); ?></a></li>
							<li class="comments"><a href="<?php echo get_permalink(); ?>#comments"><?php comments_number( __( '0 Comments', 'krown' ), __( '1 Comments', 'krown' ) ); ?></a></li>
						</ul>

				<?php endif; ?>

				<?php krown_post_format_content( $post->ID, $post_format ); ?>

				<?php if ( $post_format == 'link' || $post_format == 'quote' ) : ?>

					<ul class="post-meta">
							<li class="category"><?php krown_categories( $post->ID, 'category', ', ', 'name', true, true ); ?></li>
							<li class="author"><?php the_author_posts_link(); ?></li>
							<li class="date"><a href="<?php echo get_permalink(); ?>"><?php the_time( __( 'd M Y', 'krown' ) ); ?></a></li>
							<li class="comments"><a href="<?php echo get_permalink(); ?>#comments"><?php comments_number( __( '0 Comments', 'krown' ), __( '1 Comments', 'krown' ) ); ?></a></li>
						</ul>

				<?php endif; ?>

				<p class="post-excerpt"><?php echo krown_excerpt( 'krown_excerptlength_post_big' ); ?></p>

				<a href="<?php echo get_permalink(); ?>" class="krown-button read-more"><?php _e( 'Continue Reading', 'krown' ); ?><i class="krown-icon-arrow_right"></i></a>

			</div>

		</article>

	<?php endif; ?>