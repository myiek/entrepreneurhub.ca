<?php /* Template Name: Links */
get_header();?>
<section id="content_post">
  <article>
    <section id="linkpage">
      <ul><?php wp_list_bookmarks();?></ul>
    </section>
    <p class="postmeta"><?php edit_post_link('Edit this entry.','[',']');?></p>
  </article>
</section>
<?php get_footer();?>