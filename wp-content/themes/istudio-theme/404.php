<?php if(istOption('SearchKey')&&istOption('SearchKeyword')){$SearchKey=istOption('SearchKeyword');}else{$SearchKey=NULL;}
if(istOption('CustomFeed')&&istOption('CustomRssUrl')){$CustomFeed=istOption('CustomRssUrl');}else{$CustomFeed=NULL;}?>
<!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
<meta charset="<?php bloginfo('charset');?>" />
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /><![endif]-->
<title><?php 	_e('Error 404 - Not Found','iStudio');echo ' - ';bloginfo( 'name' );?></title>
<meta name="description" content="<?php bloginfo('description');?>" />
<meta name="keywords" content="<?php if($SearchKey)echo $SearchKey;?>" />
<style type="text/css" media="screen">@import url(<?php bloginfo('stylesheet_url');?>);</style>
<link rel="Shortcut Icon" href="<?php bloginfo('template_directory');?>/resources/favicon.ico" type="image/x-icon" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name');?> RSS Feed" href="<?php if($CustomFeed){echo $CustomFeed;}else{bloginfo('rss2_url');}?>" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name');?> Comments RSS Feed" href="<?php bloginfo('comments_rss2_url');?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url');?>" />
<?php wp_head();?>
</head>
<body style="background:#dee0e0 url(<?php bloginfo('template_url');?>/resources/bg.png) repeat-x 0 -114px;" class="error">
<section id="wrapper">
<?php $num=rand(1,4);if($num==4){?>
<img src="<?php bloginfo('template_url');?>/resources/error404.png" alt="Error 404" border=0>
<?php }else{?>
<img src="<?php bloginfo('template_url');?>/resources/error404<?php echo $num;?>.jpg" alt="Error 404" border=0>
<?php }?>
<p class="button"><a class="backhome" href="<?php echo home_url('/');?>">Back to Home</a></p>
<footer>
	<p>&copy;2006-2010 <a href="<?php echo home_url('/');?>/"><?php bloginfo('name');?></a></p>
  <!--<?php echo get_num_queries();?> queries. <?php timer_stop(1);?> seconds. -->
</footer>
</section>
<?php wp_footer();?>
</body>
</html>