<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @package WordPress
 * @subpackage Nanoplex
 * @since Nanoplex 1.0
 */
?>
		<?php if (is_sidebar_active( 'sidebar-1' )) : global $np_widget_count; $np_widget_count = 0;?>
		<div id="widget-holder">
		<?php if ( ! dynamic_sidebar( 'Top' ) ) : ?>
			<!--Wigitized 'Alert' for the home page-->	
		<?php endif; ?>
		<div class="clear"></div>
		</div>
		<?php endif;
		$count = 0; //the number of sticky posts 
		if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php
				//figure out whether we have a normal or an image post
				$content = get_the_content();
				$content = apply_filters('the_content', $content);
				$content = str_replace(']]>', ']]&gt;', $content);
				$textpost = true;
				
				$probability = (int)get_option( 'nnpl_random_layout_posts_probability', 35 ); // probability of generating a left-post out of 100
				
				global $more; 
				$more = 1; // ignores <!--more--> tag
								
			//if ( preg_match('/<!--image(.*?)?-->/', $content) ) :
			/*$split =  preg_split('/>[^<>]*\w[^<>]*?</', $content); //is not <> and has a /w... checks if there is text in the middle
			if ( count($split) == 1):*/
			
			//embed an if stament in a do while so we can break out of it
			do if((get_post_meta( $post->ID, '_np_is_image_post', true )=='yes') || !preg_match('/>[^<>]*[^\s][^<>]*?</', $content)) { //checks that "if it doesn't have text in the post (aka is an image post)"; preg_match more efficient than preg_split?>
				
			<?php 
				include_once('includes/simple_html_dom.php');
				$textpost = false;
				
				// Create DOM from URL or file
				$html = str_get_html($content);	
				// get the two images that make up front of image post	
				$img1 = $html->find('img', 0); 
				$img2 = $html->find('img', 1);
	
				if(!$img1 || !$img2) {
					//go do the other kind of post
					$textpost = true;
					break;
				}
								 
				// resize the images using html
				
				/*
				* in order to conserve processing power
				* and make it faster or whatnot
				* first check if the calculations have already been done
				* (it probably has)
				* custom field ($key = 'image_sizes' ) dependant image heights and widths (first 2 images of post)
				* FORMAT: "h1 w1 h2 w2"
				*/
				$stored_values = get_post_meta( $post->ID, '_np_image_sizes', true );
				$successful = false;
				if( $stored_values ) {
					$stored_values = explode(" ", $stored_values); // $stored_values is converted to array of values
					if( count($stored_values) == 4 ) {
						//get the values
						list($h1, $w1, $h2, $w2) = $stored_values;
						if( $h1 && $w1 && $h2 && $w2 ) {
							$successful = true;
						}
					}
				}
				
				if(!$successful) :
				
				
				/*
				* calculation land!
				* you have two images with known ratios between their heights and widths
				* their widths added up = 743 pixels (800 - 12 - 12 - 12 - 21)
				* img1 is 40 pixels taller than img2
				* find h1, w1, w2, and h2!
				* eventually, where ratio img1 is a and img2 is b
				* h1 = (743 + 40b)/(a+b)
				*/
				// original heights and widths
				$origw1 = $img1->width;
				$origh1 = $img1->height;
				$origw2 = $img2->width;
				$origh2 = $img2->height;
								
				// if that didn't work (probably because height and width weren't specified in html
				if( $origw1 == 0 || $origh1 == 0) {
					//use php's function
					list($origw1, $origh1, $type, $attr) = getimagesize($img1->src);
				}
				
				if( $origw2 == 0 || $origh2 == 0) {
					//use php's function
					list($origw2, $origh2, $type, $attr) = getimagesize($img2->src);
				}
				
				if( $origw1 != 0 && $origw2 != 0 && $origh1 != 0 && $origh2 != 0) { // if they are still 0, don't calculate
					
					// find ratios of w/h of img1 and 2
					$rat1 = $origw1/$origh1; // to conserve accuracy don't convert to int yet
					$rat2 = $origw2/$origh2;
					// calculate using predetermined formula (handwritten algebra, it's easy)
					$h1 = (743 + (40 * $rat2)) / ($rat1 + $rat2);
					$w1 = (int)($rat1 * $h1);
					$h2 = (int)($h1 - 40); // 40 is the amount of space the header of the post takes, thus the img2 is $height of img1 - 40. padding takes care of itself
					$w2 = (int)($rat2 * $h2);
					// now convert h1 to integer
					$h1 = (int)$h1;
					
					// store the values so we don't have to recalculate them with each page load
					update_post_meta( $post->ID, '_np_image_sizes', $h1 . ' ' . $w1 . ' ' . $h2 . ' ' . $w2 );
					
					$successful = true;
				
				}
				
				endif; //if not successful
				
				if($successful) {
					$img1->style = 'width: ' . $w1 . 'px; height: ' . $h1 . 'px;';
					$img2->style = 'width: '  . $w2 . 'px; height: ' . $h2 . 'px;'; 
					update_post_meta( $post->ID, '_np_is_image_post', 'yes' );
				} else {
					// could not calculate image sizes
					echo '<p>Image sizes could not be determined. The layout of the theme may be severely distorted.</p>';
					$textpost = true;
					update_post_meta( $post->ID, '_np_is_image_post', 'no' );
					break;
				}
			?>
			<div id="post-<?php the_ID(); ?>" <?php if (is_front_sticky()) { post_class(array('post', 'sticky_post', 'images-only')); $count++;} else { post_class('images-only'); }?>>
			<div class="left-banner" style = "margin-right: <?php echo 800 - ($w1 + 12) ?>px"></div>
			<div class="post-inners">
			<!--<div class="featured-thumbnail"></div>--> 
			<div <?php if($h1 != 0): ?>style="height: <?php echo ($h1+24); //the height includes the padding, which is 12. 12 x 2 = 24.?>px" <?php endif; ?>class="post-content">  
				<div class="first-image">
			<?php // first image
				$img1a = $img1; // the two 
				$img1b = $img1; // ghost images
				$img1 = $img1->outertext; // convert to a string to avoid object reference pointing stuff... for some reasons the ghost images point to the original
				$img1a->class = 'three'; // add classes necessary
				$img1a = $img1a->outertext; // see img1 comment
				$img1b->class = 'two'; // for css ghost positioning
				$img1b = $img1b->outertext; // see img1 comment

				echo $img1a . $img1b; // print ghost images
			?>
			<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php echo $img1; ?></a> <!-- link image to post -->
			
				</div> 
				
				<div class="second-image"> 
				<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php echo $img2; ?></a> <!-- link images to post -->
								
				<div class="post-title">
					<a class="supertitle" href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
					<p><?php the_author_posts_link() ?><br/> <?php the_time('m-d-Y'); ?></p>
				</div>
				</div> 
			</div> 
			
			</div><!-- postInners --> 
			</div> <!-- post -->
		
			<?php } while(false)/*endif*/; if($textpost): 	$leftpost = false; //the actual text-style post?>
		
			<div id="post-<?php the_ID(); ?>" <?php if (is_front_sticky()) { post_class(array('post', 'single_post', 'sticky_post', 'front_page', 'normal_post')); $count++;} else { 
				$randNum = rand(0, 100);
				// should we have a left-aligned post?
				if (($randNum <= $probability)&&(!get_option( 'nnpl_random_layout_posts'))) {
					post_class(array('post', 'front_page', 'normal_post', 'left-post')); 
					$leftpost = true;
				}
				else post_class(array('post', 'front_page', 'normal_post')); 
			} ?>><!-- once again the divs are for CSS layout stuff -->
			<div class="post-inners">
			<div class="post-title">
				<a class="superlink" href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"></a>
				<a class="supertitle" href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
				<p>by <?php the_author_posts_link() ?> | <?php the_time('m-d-Y'); ?></p>
				<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php 
				if (is_front_top_sticky($count)&&($nb_img=get_post_meta($post->ID, '_np_second-image', true))&& nb_display_arm()) {?>
					<img src="<?php echo get_template_directory_uri(); ?>/images/go-inv.png" alt="post-arrow" />
				<?php } else if (is_front_sticky()){ ?>
					<img style="right:0px" src="<?php echo get_template_directory_uri(); ?>/images/go-inv.png" alt="post-arrow" />
				<?php } else if($leftpost) {?>
					<img src="<?php echo get_template_directory_uri(); ?>/images/go-inv.png" alt="post-arrow" />
				<?php } else {?>
					<img src="<?php echo get_template_directory_uri(); ?>/images/go.png" alt="post-arrow" />
				<?php } ?>
				</a>  <!-- arrow for navigation -->
			</div>
			<?php if (is_front_top_sticky($count) && $nb_img && nb_display_arm()) { 
				$nb_img = nb_add_img_stuff($nb_img); // if it's just a link (a src), add an <img /> around it
				echo '<div class = "arm"><div class="shadowhider"></div><div class="hiderhider"></div><div class = "arm-content">' . $nb_img . '</div></div>'; 
			}
			else if (is_front_top_sticky($count)&& nb_display_arm()) {echo '<div class="arm"></div>';} // a little deco ?>
			<div class="post-content
				<?php 
					//make sure you close the above div tag! 
					nb_retrieve_thumbnail($content);
					the_excerpt();
				?>
				<div class="clear"></div>

			</div><!-- post-content -->
			</div><!-- post-inners --> 
			</div> <!-- post -->
			<div class="clear"></div>
			
			<?php endif; ?>
			
			
		<?php endwhile; else: ?>
			<div id="no-results" class="normal_post no-results post type-post status-publish format-default front_page"><!-- once again the divs are for CSS layout stuff --> 
			<div class="post-inners"> 
			<div class="post-title"> 
				<a class="superlink" href="" title="Whoops! Something Went Wrong." rel="bookmark"></a> 
				<a class="supertitle" href="" title="Whoops! Something Went Wrong." rel="bookmark">Whoops! Something Went Wrong.</a> 
				<p>by <a class="author" href="" title="">the author</a> | 01-01-1111</p> 
				<a href="" title="Whoops! Something Went Wrong."><img src="<?php echo get_template_directory_uri(); ?>/images/go.png" alt="post-arrow" /></a>  <!-- arrow for navigation --> 
			</div> 
				<div class="post-content">
					<p><strong>There has been an error.</strong></p>
					<p>We apologize for any inconvenience, please <a href="<?php echo home_url(); ?>/" title="<?php bloginfo('description'); ?>">return to the home page</a> or use the search form below.</p>
					<?php get_search_form(); ?> <!-- outputs the default Wordpress search form-->
					<div class="clear"></div> 
				</div><!-- post-content --> 
			</div><!-- postInners --> 
			</div> <!-- post -->
			<?php endif; ?>
		
					
			<?php 
			$older = get_next_posts_link('<div class="older"><p>&laquo; Older Entries</p></div><!--.older-->');   // encloses the entire div in a link
			$newer = get_previous_posts_link('<div class="newer"><p>Newer Entries &raquo;</p></div><!--.older-->'); // encloses the entire div in a link
			if(!$newer)
				$older = get_next_posts_link('<div class="older big"><p>&laquo; Older Entries</p></div><!--.older-->');
			if(!$older)
				$newer = get_previous_posts_link('<div class="newer big"><p>Newer Entries &raquo;</p></div><!--.older-->');
			
			if($newer || $older):
			?>
			<nav class="oldernewer">
			<?php echo $older . $newer;?>
			</nav><!--.oldernewer-->
	<?php endif; ?>
