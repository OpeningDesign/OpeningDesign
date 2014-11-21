<?php
/**
 * The Template for displaying all gallery projects.
 */
get_header(); ?>

	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); 

		$project_share = get_post_meta( $post->ID, 'krown_project_share', true );
		$resize_rule = get_post_meta( $post->ID, 'krown_resize_rule', true );
		$project_captions = get_post_meta( $post->ID, 'krown_project_captions', true );
		$project_slider_style = get_post_meta( $post->ID, 'krown_project_slider_style', true );

		$background_style = '';

		if ( get_post_meta( $post->ID, 'krown_project_n_color', true ) != '' ) {
			$background_style = 'background-color:' . get_post_meta( $post->ID, 'krown_project_n_color', true ) . '';
		} else if ( get_post_meta( $post->ID, 'krown_project_n_gradient', true ) != '' ) {
			$background_style = '' . get_post_meta( $post->ID, 'krown_project_n_gradient', true ) . '';
			preg_replace( "/\r|\n/", "", $background_style );
		} else if ( get_post_meta( $post->ID, 'krown_project_n_image', true ) != '' ) {
			$background_style = 'background-image:url(' . get_post_meta( $post->ID, 'krown_project_n_image', true ) . ')';
		}

	?>

	<article id="post-<?php echo $post->ID; ?>" <?php post_class('project-gallery project-horizontal project captions-' . $project_captions . ' clearfix'); ?> data-type="horizontal">

			<div class="gallery-holder">

				<?php krown_horizontal_gallery( $post->ID, $background_style, 'middle', $project_slider_style, $project_captions ); ?>

			</div>

			<?php krown_nav_buttons( 'gallery_category', 'krown_gallery_page', 'horizontal' ); ?>

			<div class="gallery-meta">

				<?php if ( $project_captions == 'show' ) : ?>
					<div class="gallery-caption"></div>
				<?php endif;

				if ( $project_share == 'show' ) {
					krown_share_buttons( $post->ID ); 
				} ?>

			</div>

		</article>

	<?php endwhile; ?>

<?php get_footer(); ?>