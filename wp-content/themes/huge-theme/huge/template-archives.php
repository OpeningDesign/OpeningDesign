<?php
/*---------------------------------
	Template Name: Archives
------------------------------------*/

get_header(); ?>

	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

		<?php the_content(); ?>

		<div class="krown-column-row clearfix">

			<section class="widget widget_archive span4 krown-column-container clearfix first">
				<div class="widget-title">
					<h4><?php _e('Archives by month', 'krown'); ?></h4>
				</div>
			   <ul><?php wp_get_archives('type=monthly&limit=12&show_post_count=1'); ?></ul> 
			</section>

			<section class="widget widget_archive span4 krown-column-container clearfix first">
				<div class="widget-title">
					<h4><?php _e('Archives by subject', 'krown'); ?></h4>
				</div>
			   <ul><?php wp_list_categories('show_count=1&title_li='); ?></ul> 
			</section>

			<section class="widget widget_archive span4 krown-column-container clearfix first">
				<div class="widget-title">
					<h4><?php _e('Archives by year', 'krown'); ?></h4>
				</div>
			   <ul><?php wp_get_archives('type=yearly&show_post_count=1'); ?></ul> 
			</section>

		</div>

		<div class="krown-column-row clearfix">
			
			<section class="widget widget_archive span8 krown-column-container clearfix first">
				<div class="widget-title">
					<h4><?php _e('Latest 20 posts', 'krown'); ?></h4>
				</div>
			   <ul><?php wp_get_archives('type=postbypost&limit=20&show_post_count=1'); ?></ul> 
			</section>

			<section class="widget widget_archive span4 krown-column-container clearfix first">
				<div class="widget-title">
					<h4><?php _e('Archives by tags', 'krown'); ?></h4>
				</div>
			   <?php wp_tag_cloud('format=list'); ?>
			</section>

		</div>

	<?php endwhile; ?>      

<?php get_footer(); ?>