<?php
/**
 * The Template for displaying all portfolio projects.
 */
get_header(); ?>

	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); 

	$project_type = get_post_meta( $post->ID, 'krown_project_type', true );

	$project_share = get_post_meta( $post->ID, 'krown_project_share', true );
	$project_m_width = get_post_meta( $post->ID, 'krown_project_m_width', true );
	$project_m_height = get_post_meta( $post->ID, 'krown_project_m_height', true );
	$project_m_slider_width = get_post_meta( $post->ID, 'krown_project_m_slider_width', true );
	
	$background_style = '';

	if ( get_post_meta( $post->ID, 'krown_project_n_color', true ) != '' ) {
		$background_style = 'background-color:' . get_post_meta( $post->ID, 'krown_project_n_color', true ) . '';
	} else if ( get_post_meta( $post->ID, 'krown_project_n_gradient', true ) != '' ) {
		$background_style = '' . get_post_meta( $post->ID, 'krown_project_n_gradient', true ) . '';
		preg_replace( "/\r|\n/", "", $background_style );
	} else if ( get_post_meta( $post->ID, 'krown_project_n_image', true ) != '' ) {
		$background_style = 'background-image:url(' . get_post_meta( $post->ID, 'krown_project_n_image', true ) . ')';
	}

	$project_slider_align = get_post_meta( $post->ID, 'krown_project_slider_align', true );
	$project_slider_style = get_post_meta( $post->ID, 'krown_project_slider_style', true );

	switch( $project_type ) {

		case 'modal' : ?>

		<!-- Modal Project Start -->

		<article id="post-<?php echo $post->ID; ?>" <?php post_class('project-modal project clearfix'); ?> style="width:<?php echo $project_m_width; ?>px;height:<?php echo $project_m_height; ?>px;margin-left:-<?php echo $project_m_width/2-20; ?>px;margin-top:-<?php echo $project_m_height/2; ?>px" data-type="modal" data-project-width="<?php echo $project_m_width; ?>" data-project-height="<?php echo $project_m_height; ?>" data-slider-width="<?php echo $project_m_slider_width; ?>">

			<?php krown_modal_gallery( $post->ID, $project_m_slider_width, $project_m_height, $background_style, $project_slider_align, 'full' ); ?>


			<?php krown_nav_buttons( 'portfolio_category', 'krown_folio_page', 'default', 'white' ); ?>

			<section id="project-content" class="content" style="width:<?php echo $project_m_width - $project_m_slider_width; ?>px">

				<div>

					<h1><?php the_title(); ?></h1>

					<?php the_content();

					if ( $project_share == 'show' ) {
						krown_share_buttons( $post->ID ); 
					} ?>

				</div>

			</section>

		</article>

		<!-- Modal Project End -->

		<?php break;
		
		case 'vertical' : ?>

		<!-- Normal (content on right) Project Start -->

		<article id="post-<?php echo $post->ID; ?>" <?php post_class('project-vertical project clearfix'); ?> data-type="vertical">

			<?php krown_vertical_gallery( $post->ID, $background_style ); ?>

			<section id="project-content" class="content">

				<div>

					<?php krown_nav_buttons( 'portfolio_category', 'krown_folio_page', 'default', 'white' ); ?>

					<h1><?php the_title(); ?></h1>

					<?php the_content();

					if ( $project_share == 'show' ) {
						krown_share_buttons( $post->ID ); 
					} ?>

				</div>

			</section>

		</article>

		<!-- Normal (content on right) Project End -->

		<?php break;
		case 'horizontal' : ?>

		<!-- Normal (content on bottom) Project Start -->

		<article id="post-<?php echo $post->ID; ?>" <?php post_class('project-horizontal project clearfix'); ?> data-type="horizontal">

			<?php 

			?>

			<div class="gallery-holder">

				<?php krown_horizontal_gallery( $post->ID, $background_style, $project_slider_align, $project_slider_style ); ?>

			</div>

			<?php krown_nav_buttons(); ?>

			<section id="project-content" class="content">

				<div>

					<div class="head">

						<div>

							<h1><?php the_title(); ?></h1>

							<ul class="post-meta">
								<li class="category"><?php krown_categories( $post->ID, 'portfolio_category', ', ', 'name' ); ?></li>
								<li class="author"><?php echo get_post_meta( $post->ID, 'krown_project_meta_2', true); ?></li>
								<li class="date"><?php echo get_post_meta( $post->ID, 'krown_project_meta_3', true); ?></li>
								<li class="skills"><?php echo get_post_meta( $post->ID, 'krown_project_meta_4', true); ?></li>
							</ul>

						</div>

					</div>

					<div class="body">

						<?php the_content();

						if ( $project_share == 'show' ) {
							krown_share_buttons( $post->ID ); 
						} ?>

					</div>

				</div>

			</section>

		</article>

		<!-- Normal (content on bottom) Project End -->

		<?php break;

	} ?>

	<?php endwhile; ?>

<?php get_footer(); ?>