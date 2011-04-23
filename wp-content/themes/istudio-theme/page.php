<?php $pageside=istOption('pageside');
if(istOption('pagenavnum')=='default'){$pnavcalss='navigation';}else{$pnavcalss='page-links';}
get_header();
if($pageside){?>
<section id="content">
<section class="postlist">
<?php }else{?>
<section id="content_post">
<?php }
if(have_posts()){while(have_posts()):the_post();?>
  <article id="post-<?php the_ID();?>" <?php post_class();?>>
    <section class="title">
      <h2><?php the_title();?></h2>
    </section>
    <section class="entry">
      <?php the_content();
	  wp_link_pages('before=<nav class="'.$pnavcalss.'">&after=</nav>&next_or_number=number&pagelink=<span>%</span>');?>
    </section>
    <p class="postmeta"><?php edit_post_link('Edit this entry.','[',']');?></p>
  </article>
  <?php comments_template('',true);
  endwhile;}
if($pageside){?>
</section>
<?php get_sidebar();?>
<section class="clear"></section>  
</section>
<?php }else{?>
</section>
<?php }
get_footer();?>