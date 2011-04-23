<?php /* Template Name: Archives */
get_header();?>
<section id="content_post">
  <?php if(have_posts()){while(have_posts()):the_post();?>
  <article id="post-<?php the_ID();?>" <?php post_class();?>>
    <section class="title">
      <h2><?php the_title();?></h2>
    </section>
    <section id="archives" class="entry">
      <section id="arslink">
        <ul><?php wp_get_archives('type=monthly');?></ul>
      </section>
      <section class="line">
        <?php _e('Recent Articles','iStudio');?>
      </section>
      <ul class="ul"><?php wp_get_archives('type=postbypost&limit=25');?></ul>
    </section>
    <?php endwhile;}?>
    <p class="postmeta"><?php edit_post_link('Edit this entry.','[',']');?></p>
  </article>
</section>
<?php get_footer();?>