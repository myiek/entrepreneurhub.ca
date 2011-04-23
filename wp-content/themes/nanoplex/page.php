<?php get_header(); ?>
<div id="content">
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(array('single_post', 'normal_post', 'page-block', 'post')); ?>>
			<div class="post-inners">

				<div class="post-title">
					<a class="superlink" href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"></a>
					<a class="supertitle" href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
					<p>Page</p>
					<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/go-inv.png" alt="post-arrow" /></a>  <!-- arrow for navigation -->
				</div>

				<div class="post-content">
					<?php 
						if ( has_post_thumbnail() ) { 
							echo '<!-- loades the post\'s featured thumbnail, requires Wordpress 3.0+ -->';
							echo '<div class="featured-thumbnail">'; 
							the_post_thumbnail('thumbnail'); 
							echo '</div>'; 
						}
						the_content();
					?>
					<div class="clear"></div>
					<div class="pagination">
						<?php wp_link_pages('before=<div class="pagination">&after=</div>'); ?>
					</div><!--.pagination-->
				</div><!--#post-content-->
			
				
			<div class="clear meta_bottom"></div>

			
			<!-- If a user fills out their bio info, it's included here -->
			
			</div><!--.post-inners-->

		</div><!-- #post-## -->

		<nav class="oldernewer" id="single_on">
			
			<?php 
			
			if(!get_adjacent_post(false, '', false))
				previous_post_link('%link', '<div class="older big"><p>&laquo; %title</p></div><!--.older-->');
			else previous_post_link('%link', '<div class="older"><p>&laquo; %title</p></div><!--.older-->');
			
			if(!get_adjacent_post(false, '', true))
				next_post_link('%link', '<div class="newer big"><p>%title &raquo;</p></div><!--.older-->');
			else next_post_link('%link', '<div class="newer"><p>%title &raquo;</p></div><!--.older-->');
			
			?>
			
		</nav><!--.oldernewer-->

		<?php comments_template( '', true ); ?>

	<?php endwhile; ?><!--end loop-->
</div><!--#content-->
<?php //get_sidebar(); ?>
<?php get_footer(); ?>