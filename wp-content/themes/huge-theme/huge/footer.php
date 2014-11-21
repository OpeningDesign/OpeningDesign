<?php
/**
 * The footer of the theme
 */
?>

	<!-- Main Wrapper End -->
	</div>

	<!-- Preloader -->
	<div id="loader"></div>

	<!-- IE7 Message Start -->
	<div id="oldie">
		<p><?php _e('This is a unique website which will require a more modern browser to work!', 'krown'); ?><br /><br />
		<a href="https://www.google.com/chrome/" target="_blank"><?php _e('Please upgrade today!', 'krown'); ?></a>
		</p>
	</div>
	<!-- IE7 Message End -->

	<!-- No Scripts Message Start -->
	<noscript id="scriptie">
		<div>
			<p><?php _e('This is a modern website which will require Javascript to work. <br />Please turn it on!', 'krown'); ?>
			</p>
		</div>
	</noscript>
	<!-- No Scripts Message End -->

	<!-- GTT Button -->
	<a id="top" href="#" class="krown-icon-right-open"></a> 

	<?php wp_footer(); ?>

</body>
</html>