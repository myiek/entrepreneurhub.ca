<?php /* Template Name: GuestBook */
if(istOption('pagenavnum')=='default'){$pnavcalss='navigation';}else{$pnavcalss='page-links';}
get_header();?>
<section id="content_post">
<?php istudio_randompic();
if(have_posts()){while(have_posts()):the_post();?>
  <article id="post-<?php the_ID();?>" <?php post_class();?>>
    <section class="title">
      <h2><?php the_title();?></h2>
    </section>
    <section class="entry">
      <?php the_content('More');
      wp_link_pages('before=<section id="'.$pnavcalss.'">&after=</section>&next_or_number=number&pagelink=<span>%</span>');?>
    </section>
    <p class="postmeta"><?php edit_post_link('Edit this entry.','[', ']');?></p>
  </article>
  <?php comments_template('',true);?>
  <?php endwhile;}?>
</section>
<?php get_footer();?>