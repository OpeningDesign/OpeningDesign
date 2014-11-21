<?php
/**
 * 404 Page Template
 */
get_header();
?>
	<article>

		<div class="page-content">

			<h1 class="page-title"><?php _e( 'Uh oh! (404 Error)', 'krown' ); ?></h1>

			<h2 class="page-404"><?php _e( 'We are really sorry but the page you requested is missing :(', 'krown' ); ?></h2>

	<?php rewind_posts(); ?>
<?php get_footer(); ?>