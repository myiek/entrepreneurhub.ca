<?php $pagenavnum=istOption('pagenavnum');
get_header();?>
<section id="content">
<?php istudio_randompic();?>
<section class="postlist">
<?php if(have_posts()){?>
  <section class="archive">
    <span class="title"><?php _e('Search Results', 'iStudio');?></span>
  </section>
  <?php while(have_posts()):the_post();?>
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
	<nav class="navigation">
  <?php if($pagenavnum=='default'){
		if(function_exists('wp_pagenavi')){wp_pagenavi();}else{?>
		<section class="alignleft"><?php next_posts_link('&laquo; Older Entries');?></section>
    <section class="alignright"><?php previous_posts_link('Newer Entries &raquo;');?></section>
    <section class="clear"></section> 
	<?php }
	}else{istudio_pagenavi();}?>
  </nav>
	<?php }else{?>
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