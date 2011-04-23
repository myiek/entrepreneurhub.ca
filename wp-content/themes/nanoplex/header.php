<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title>
	<?php if ( is_tag() ) {
			echo 'Tag Archive for &quot;'.$tag.'&quot; | '; bloginfo( 'name' );
		} elseif ( is_archive() ) {
			wp_title(); echo ' Archive | '; bloginfo( 'name' );
		} elseif ( is_search() ) {
			echo 'Search for &quot;'.esc_html($s).'&quot; | '; bloginfo( 'name' );
		} elseif ( is_home() ) {
			bloginfo( 'name' ); echo ' | '; bloginfo( 'description' );
		}  elseif ( is_404() ) {
			echo 'Error 404 Not Found | '; bloginfo( 'name' );
		} else {
			echo wp_title( ' | ', false, 'right' ); bloginfo( 'name' );
		} ?>
	</title>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<!-- Loads jQuery if it hasn't been loaded already -->
	<?php wp_enqueue_script("jquery"); ?>
	
	<!-- The HTML5 Shim is required for older browsers, mainly older versions IE -->
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<!--[if gte IE 6]>
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_directory_uri(); ?>/includes/ie.css" />
	<![endif]-->
	<!--[if lte IE 7]>
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_directory_uri(); ?>/includes/ie7u.css" />
	<![endif]-->
	
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' );?>
	<?php if ( ! isset( $content_width ) ) $content_width = 775;?>
	<?php wp_head(); ?> <!-- this is used by many Wordpress features and for plugins to work proporly -->
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/extras.js"></script>
</head>

<body <?php body_class(); ?>>



<div id="main"><!-- this encompasses the entire Web site -->
	<header>
		<div class="sizer"><!-- all these divs are for some wacko css layout stuff -->
		<?php /*if(($post!=null) && is_single()&& ($img = nb_add_img_stuff(get_post_meta($post->ID, '_np_second-image', true)))) {
			$nb_styles = get_post_meta($post->ID, '_np_nb-styles', true);
			if($nb_styles == 'yes') $nb_styles = 'overflow:visible;';
			echo '<div class="deco-banner" style="'. $nb_styles .'">'.$img.'</div>';
		} */?>
		<div class="banner">
		<div class="head-content"> 
			<div class="title">
			<?php if( is_front_page() || is_home() ) { ?>
				<h1><a href="<?php echo home_url(); ?>/" title="<?php bloginfo('description'); ?>"><?php bloginfo('name'); ?></a></h1>
			<?php } else { ?>
				<h1><a href="<?php echo home_url(); ?>/" title="<?php bloginfo('description'); ?>"><?php bloginfo('name'); ?></a></h1>
			<?php } ?>
			<p><?php bloginfo('description'); ?></p></div><!-- title-->
		</div><!-- headcontent -->
		<div class="head_banner">
			<a href="<?php echo home_url(); ?>/" title="<?php bloginfo('description'); ?>">
			<div id="headerimg"></div>
			</a>
			<nav class="primary">
				<a class="homelink" href="<?php echo home_url(); ?>/" title="<?php bloginfo('description'); ?>"></a>
				<?php wp_nav_menu( array( 'container_class' => 'menu', 'menu_class' => 'menu', 'theme_location' => 'header_menu' )); ?> <!-- editable within the Wordpress backend -->
			</nav><!--.primary-->
		</div><!-- headbanner -->
			<?php if ( ! dynamic_sidebar( 'Header' ) ) : ?>
				<!-- Wigitized Header -->
			<?php endif ?>
		</div><!-- banner -->
		</div><!-- sizer -->
	</header>
	<div class="clear"></div>
	<div class="container" id="body-content">