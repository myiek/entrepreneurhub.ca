<aside>
	<?php if(istOption('recommend_widget')&&istOption('recommend_widget')){$hotWidget=istOption('widgetInfo');}else{$hotWidget=Null;}
		if(istOption('adcode_sidebar')){$sidebarad=istOption('adcode_sidebar');$sidebarshow=istOption('ad_show_sidebar');}else{$sidebarad=NULL;}
		if($hotWidget){?>
	<section class="showidget"><?php echo $hotWidget;?></section>
	<?php }
	get_search_form();
	if(!function_exists('dynamic_sidebar')||!dynamic_sidebar()){?>
	<ul class="clear"><?php wp_list_categories('show_count=0&title_li=<h3>'.__('Categories','iStudio').'</h3>');?></ul>
  <?php if(is_home()&&function_exists('get_most_viewed')){?>
	<ul>
		<li>
			<h3><?php _e('Most Popular Articles','iStudio');?></h3>
			<ul><?php get_most_viewed('post',5,0,true,true);?></ul>
		</li>
	</ul>
	<?php }?> 
	<ul>
		<li>
			<h3><?php _e('Archives','iStudio');?></h3>
			<ul><?php wp_get_archives('type=monthly&limit=6');?></ul>
		</li>
	</ul>
	<ul>
		<li class="comment">
			<h3><?php _e('Recent Comments','iStudio');?></h3>
			<ul><?php istudio_rcomments(6);?></ul>
		</li>
	</ul>
	<ul>
		<li>
			<h3><?php _e('Meta','iStudio');?></h3>
			<ul>
				<?php wp_register();?>
				<li><?php wp_loginout();?></li>
				<li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>
				<?php wp_meta();?>
			</ul>
		</li>
	</ul>
	<?php }
	if($sidebarad){if($sidebarshow){
		if(!is_user_logged_in()){echo "<section style=\"padding:10px;\">\n".$sidebarad."</section>\n";}
	}else{echo "<section style=\"padding:10px;\">\n".$sidebarad."</section>";}
	}?>
</aside>