<hr />
<footer>
	<p>&copy;2010 <a href="<?php echo home_url('/');?>/"><?php bloginfo('name');?></a>
    <?php _e('&#183;');?>Powered by <a href="http://wordpress.org/">WordPress <?php bloginfo('version');?></a>.<br />
		<a href="http://xuui.net/wordpress/istudio-theme-release.html"><?php echo themename;?></a> Designed by <a href="http://xuui.net/">Xu.hel</a>.
		<!--<?php echo get_num_queries();?> queries. <?php timer_stop(1);?> seconds. -->
	</p>
</footer>
</section>
<?php if(is_home()&&istOption('GrowlSwitch')&&istOption('GrowlInfo')){$GrowlInfos=istOption('GrowlInfo');?>
<script type="text/javascript">
<!--
var istoup_info='<?php echo $GrowlInfos;?>';
istojGrowlt(istoup_info,8000);
-->
</script>
<?php }
wp_footer();?>
</body>
</html>