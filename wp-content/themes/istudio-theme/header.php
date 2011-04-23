<?php if(istOption('SearchKey')&&istOption('SearchKeyword')){$SearchKey=istOption('SearchKeyword');}else{$SearchKey=NULL;}
if(istOption('CustomFeed')&&istOption('CustomRssUrl')){$CustomFeed=istOption('CustomRssUrl');}else{$CustomFeed=NULL;}?>
<!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
<meta charset="<?php bloginfo('charset');?>" />
<link rel="theme author" href="Xu.hel,xu@xuui.net" />
<title><?php if(is_single()){	single_post_title();echo ' - ';bloginfo('name');}elseif(is_home()||is_front_page()){bloginfo('name');istudio_page_number();}elseif(is_page()){single_post_title(''); echo ' - ';bloginfo('name');}elseif(is_search()){printf( __('Search results for "%s"','iStudio'),esc_html($s));istudio_page_number();echo ' - '; bloginfo('name');}elseif(is_404()){_e('Error 404 - Not Found','iStudio');echo ' - ';bloginfo('name');}else{wp_title('');echo ' - ';bloginfo('name');istudio_page_number();}?></title>
<?php if (is_single()){if($post->post_excerpt){$description=$post->post_excerpt;}else{$description=substr(strip_tags($post->post_content),0,110);}$keywords='';$tags=wp_get_post_tags($post->ID);foreach($tags as $tag){$keywords=$keywords.$tag->name.', ';}}?>
<meta name="description" content="<?php if(is_single()){echo $description;}else{bloginfo('description');}?>" />
<meta name="keywords" content="<?php if($SearchKey)echo $SearchKey;if(is_single())echo ', '.$keywords;?>" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url');?>" />
<link rel="Shortcut Icon" href="<?php echo get_template_directory_uri();?>/resources/favicon.ico" type="image/x-icon" />
<?php istudio_custom_feed();?>
<link rel="pingback" href="<?php bloginfo('pingback_url');?>" />
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/resources/scripts/html5.js"></script><![endif]-->   
<?php istudio_enqueue_script();
if(is_singular()&& get_option('thread_comments'))wp_enqueue_script('comment-reply');
wp_head();?>
</head>
<body <?php body_class();?>>
<section id="wrapper">
<header>
  <section class="hgroup"><?php istudio_get_logo();?></section>
  <nav>
  	<a class="feedrss" href="<?php if($CustomFeed){echo $CustomFeed;}else{bloginfo('rss2_url');}?>" title="<?php bloginfo('name');?> RSS Feed">Feed Rss</a>
    <?php wp_nav_menu(array('container'=>'ul','container_id'=>'','container_class'=>'','menu_id'=>'navmenus'));?>
  </nav>
</header>
<hr />