<?php $pagenavnum=istOption('pagenavnum');
get_header();?>
<section id="content">
<?php istudio_randompic();?>
<section class="postlist">
<?php if(have_posts()){?>
    <section class="archive">
    <?php $post = $posts[0];if(is_category()){?>
    <span class="title">Archive for the &#8216;<?php single_cat_title();?>&#8217; Category</span>
    <?php }elseif(is_tag()){?>
    <span class="title">Posts Tagged &#8216;<?php single_tag_title();?>&#8217;</span>
    <?php }elseif(is_day()){?>
    <span class="title">Archive for <?php the_time('F jS, Y');?></span>
    <?php }elseif(is_month()){?>
    <span class="title">Archive for <?php the_time('F, Y');?></span>
    <?php }elseif(is_year()){?>
    <span class="title">Archive for <?php the_time('Y');?></span>
    <?php }elseif(is_author()){?>
    <span class="title">Author Archive</span>
    <?php }elseif(isset($_GET['paged'])&&!empty($_GET['paged'])){?>
    <span class="title">Blog Archives</span>
    <?php }?>
  </section>
  <?php if(is_category()){
  	$limit = get_option('posts_per_page');
  	$paged=(get_query_var('paged'))?get_query_var('paged'):1;
  	query_posts('cat='.$cat.'&showposts=10&paged='.$paged);
  }
	while(have_posts()):the_post();?>
  <article id="post-<?php the_ID();?>" <?php post_class();?>>
  	<section class="title">
     	<h3><?php the_time('F jS, Y');?></h3>
     	<h2><a href="<?php the_permalink();?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute();?>"><?php the_title();?></a></h2>
			<small><?php comments_popup_link('No Comments','1 Comment','% Comments');?>, <?php the_category(', ');?>, by <?php the_author();?><?php if(function_exists('the_views')){?>, <?php the_views();}?>.<?php edit_post_link('Edit',' [',']&#187;');?></small>
		</section>
    <section class="entry">
      <?php the_excerpt();?> 
    </section>
    <p class="postmeta"><?php the_tags('Tags: ',', ','');?></p>
  </article>
  <?php endwhile;?>
	<section class="navigation">
  <?php if($pagenavnum=='default'){
		if(function_exists('wp_pagenavi')){wp_pagenavi();}else{?>
		<section class="alignleft"><?php next_posts_link('&laquo; Older Entries');?></section>
    <section class="alignright"><?php previous_posts_link('Newer Entries &raquo;');?></section>
    <section class="clear"></section> 
	<?php }	
	}else{istudio_pagenavi();}?>
  </section>
	<?php if(is_category()){wp_reset_query();}}else{?>
  <article>
   	<section class="title">
			<h2><?php _e('Not Found','iStudio');?></h2>
		</section>
		<section class="entry">
			<p><?php _e('Sorry, but you are looking for something that isn\'t here.','iStudio');?></p>
		</section>
  </article>
	<?php }?>
</section>
<?php get_sidebar();?>
<section class="clear"></section>   
</section>
<?php get_footer();?>