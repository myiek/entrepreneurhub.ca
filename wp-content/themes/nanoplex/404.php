<?php get_header(); ?>
<div id="content" class="search">

	<div class="cat_title"><div class="cat_title_content"><span>Whoops! Something bad happened!</span></div></div>

		<div id="no-results" class="normal_post no-results post type-post status-publish format-default front_page"><!-- once again the divs are for CSS layout stuff --> 
			<div class="post-inners"> 
			<div class="post-title"> 
				<a class="superlink" href="" title="Nothing Found." rel="bookmark"></a> 
				<a class="supertitle" href="" title="Nothing Found" rel="bookmark">404 Error: Not Found</a> 
				<p>by <a class="author" href="" title="">the author</a> | 01-01-1111</p> 
				<a href="" title="Whoops! Something Went Wrong."><img src="<?php echo get_template_directory_uri(); ?>/images/go.png" alt="post-arrow" /></a>  <!-- arrow for navigation --> 
			</div> 
				<div class="post-content">
					<p><strong>Something went wrong! This page doesn't exist.</strong></p>
					<p>We apologize for any inconvenience, please <a href="<?php echo home_url(); ?>/" title="<?php bloginfo('description'); ?>">return to the home page</a> or use the search form below.</p>
					<?php get_search_form(); ?> <!-- outputs the default Wordpress search form-->
					<div class="clear"></div> 
				</div><!-- post-content --> 
			</div><!-- postInners --> 
			</div> <!-- post -->
	
</div><!-- #content --><?php get_footer(); ?>