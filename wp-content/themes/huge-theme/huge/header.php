<!DOCTYPE html>
<!--[if lt IE 9]> <html <?php language_attributes(); ?> class="no-js ie7" xmlns="http://www.w3.org/1999/xhtml"> <![endif]-->
<!--[if IE 9]> <html <?php language_attributes(); ?> class="no-js ie9" xmlns="http://www.w3.org/1999/xhtml"> <![endif]-->
<!--[if gt IE 9]><!--> <html <?php language_attributes(); ?> xmlns="http://www.w3.org/1999/xhtml"> <!--<![endif]-->
<head>

	<!-- META -->

	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta name="format-detection" content="telephone=no">

	<?php krown_indexing_meta(); ?>

	<!-- TITLE -->

	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<!-- LINKS -->

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php if( get_option('krown_fav' ) != '' ) : ?>

	<link rel="shortcut icon" type="image/x-icon" href="<?php echo get_option( 'krown_fav' ); ?>" />

	<?php endif; ?>

	<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

	<!-- WP HEAD -->

	<?php wp_head(); ?>
		
</head>

<body id="body" <?php body_class( get_option( 'krown_sidebar_hide', 'sidebar-hide' ) . ' ' . krown_check_portfolio() . ' ' . krown_sidebar_status() . ' ' . krown_blog_style() . ' ' . get_option( 'krown_parallax', 'parallax-enabled' ) . ' ' . get_option( 'krown_sidebar_3d', 'sidebar-use3d' ) . ' no-touch' ); ?>>

	<!-- Sidebar Start -->
	<header id="sidebar" class="clearfix">

		<div class="content">

			<div id="theme-sidebar">

				<?php 

					$logo = get_option( 'krown_logo' );
					$logo_x2 = get_option( 'krown_logo_x2' );

					if($logo == '') {
						$logo = get_template_directory_uri() . '/images/logo.png';
					}
					if($logo_x2 == '') {
						$logo_x2 = $logo;
					}

				?>

				<a id="logo" href="<?php echo home_url(); ?>" style="width:<?php echo get_option('krown_logo_width', '91'); ?>px;height:<?php echo get_option('krown_logo_height', '44'); ?>px">
					<img class="default" src="<?php echo $logo; ?>" alt="<?php bloginfo('name'); ?>" />
					<img class="retina" src="<?php echo $logo_x2; ?>" alt="<?php bloginfo('name'); ?>" />
				</a>

				<nav id="menu" class="clearfix" data-responsive-title="<?php _e( 'Navigation' , 'krown' ); ?>">

					<?php if ( has_nav_menu( 'primary' ) ) {

						wp_nav_menu( array(
							'container' => false,
							'menu_class' => 'clearfix top-menu',
							'echo' => true,
							'before' => '',
							'after' => '',
							'link_before' => '',
							'link_after' => '',
							'depth' => 2,
							'theme_location' => 'primary',
							'walker' => new Krown_Nav_Walker()
							)
						);

					} ?>

				</nav>	

				<?php if ( is_active_sidebar( 'krown_footer_widget_area') ) : ?>
				<div id="sidebar-widgets" class="clearfix">
					<?php dynamic_sidebar( 'krown_footer_widget_area' ); ?>
				</div>
				<?php endif; ?>

			</div>

			<?php add_krown_customizer(); ?>

		</div>

		<div class="button">

			<span class="open-close lines"></span>

		</div>

	</header>

	<!-- Sidebar End -->

	<!-- Main Wrapper Start -->

	<div id="content" class="<?php krown_sidebar_class(); ?> clearfix">