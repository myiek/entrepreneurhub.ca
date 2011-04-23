<?php
/*
Template Name: Archive
*/
?>
<?php

/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Nanoplex
 * @since Nanoplex 1.0
 */?>
 <?php get_header(); ?>
<div id="content">

	<div class="cat_title"><div class="cat_title_content">
		<?php if ( is_day() ) : ?> <!-- if the daily archive is loaded -->
			<?php printf( __( '<span>Daily Archives: %s</span>' ), get_the_date() ); ?>
		<?php elseif ( is_month() ) : ?> <!-- if the montly archive is loaded -->
			<?php printf( __( '<span>Monthly Archives: %s</span>' ), get_the_date('F Y') ); ?>
		<?php elseif ( is_year() ) : ?> <!-- if the yearly archive is loaded -->
			<?php printf( __( '<span>Yearly Archives: %s</span>' ), get_the_date('Y') ); ?>
		<?php else : ?> <!-- if anything else is loaded, ex. if the tags or categories template is missing this page will load -->
			<?php echo '<span>Tag Archives: ' . single_tag_title( '', false ) . '</span>'; ?>
		<?php endif; ?>
	</div></div>

	<?php get_template_part( 'loop', 'archive' );?>


</div><!--#content-->
<?php //get_sidebar(); ?>
<?php get_footer(); ?>
