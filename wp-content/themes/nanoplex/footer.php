	</div><!--.container-->
	<div class="clear"></div>
	<footer>
		<div class="sizer">
		<div class="container">
		<div class="content">
			<?php get_search_form(); ?> <!-- outputs the default Wordpress search form-->
			
			<nav class="footer">
					<?php wp_nav_menu( array( 'container_class' => 'menu', 'menu_class' => 'menu', 'theme_location' => 'footer_menu' )); ?> <!-- editable within the Wordpress backend -->
			</nav>
			
			<?php wp_meta(); ?>
			
			<p class="copyright">
				&copy; <?php echo date("Y") ?> <a href="<?php echo home_url(); ?>/" title="<?php bloginfo('description'); ?>"><?php bloginfo('name'); ?></a>. All Rights Reserved.
			</p>
			<p class="rss">
				<a href="<?php bloginfo('rss2_url'); ?>" rel="nofollow">Entries (RSS)</a> | <a href="<?php bloginfo('comments_rss2_url'); ?>" rel="nofollow">Comments (RSS)</a>
			</p>
			<p class="credits"> 
				Powered by <a href="http://wordpress.org">WordPress</a> and the <a href="http://nanothoughts.com">Nanoplex Theme.</a>
			</p> 
		</div>
		</div><!--.container-->
		<div class="clear"></div>
		
		<?php $needbottom = false; if (is_sidebar_active( 'sidebar-2' )) : global $np_widget_count; $np_widget_count = 0;?>
		<div id="entire-widget-footer"><div id="widget-holder-footer">
		<?php if ( ! dynamic_sidebar( 'Footer' ) ) : ?>
			<!--Wigitized 'Alert' for the home page-->	
		<?php 
		endif; ?>
		<div class="clear"></div>
		</div>
		</div>
		<?php else :
			$needbottom = true; endif;?>
		</div>
	</footer>
	
	<?php if($needbottom) echo '<div class="bottom-margin"></div>'; ?>
	
</div><!--#main-->
<?php wp_footer(); ?> <!-- this is used by many Wordpress features and for plugins to work proporly -->
</body>
</html>