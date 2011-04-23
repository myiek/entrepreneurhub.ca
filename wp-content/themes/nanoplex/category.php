<?php get_header(); ?>
	<div id="content">
		<div class="cat_title"><div class="cat_title_content"><?php printf( __( 'Category Archives: %s' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?></div></div>
		<!-- displays the category's description from the Wordpress admin -->
		<?php echo category_description(); ?>
		<?php
			/* Run the loop to output the posts.
			 * If you want to overload this in a child theme then include a file
			 * called loop-index.php and that will be used instead.
			 */
			 get_template_part( 'loop', 'index' );
		?>

	</div>
<?php /*get_sidebar(); */?>
<?php get_footer(); ?>
