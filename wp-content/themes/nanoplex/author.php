<?php get_header(); ?>
<div id="content">
	
	<?php
		global $curauth;
		if(isset($_GET['author_name'])) :
			$curauth = get_userdatabylogin($author_name);
	    else :
			$curauth = get_userdata(intval($author));
		endif;
	?>
	<div class="over-post-container">
	<div class="author-post single_post post">
	<div class="post-inners">
		<div class="post-title"><p class="supertitle">About: <?php echo $curauth->display_name; ?></p>
		<p></p></div>
		<div class="author-content">
		<div class="avatar">
			<!-- Displays the Gravatar based on the author's email address. Visit Gravatar.com for info on Gravatars -->
			<?php if(function_exists('get_avatar')) { echo get_avatar( $curauth->user_email, $size = '180' ); } ?>
		</div>
		<div class="author-info-container">
		<div class="author-info"><!-- Displays the author's description from their Wordpress profile -->
		<?php if($curauth->description !="") { ?>
			<p><?php echo $curauth->description; ?></a></p>
		<?php } ?>
		</div>
		</div>
	</div><!-- post-content-->
	</div><!-- post-inners-->
	</div><!--.author-->
			<div class="clear"></div>

	</div><!-- over post container... to give the thing an expandable height-->
	
	<div class="cat_title"><div class="cat_title_content"><?php printf( __( 'Recent Posts by: %s' ), '<span>' . $curauth->display_name . '</span>' ); ?></div></div>
	<!-- displays the category's description from the Wordpress admin -->
	<?php
		/* Run the loop to output the posts.
		 * If you want to overload this in a child theme then include a file
		 * called loop-index.php and that will be used instead.
		 */
		 get_template_part( 'loop', 'author' );
	?>	

	<div id="comments">
	<div class="author-commentInners commentInners">
	<div class="comment-content">
		<div class="post-title"><p>Recent Comments by: <?php echo $curauth->display_name; ?></p></div>
		<?php
			$count = 1;
			$number=6; // number of recent comments to display
			$comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_approved = '1' and comment_author_email='$curauth->user_email' ORDER BY comment_date_gmt DESC LIMIT $number");
		?>
		
			<?php
			
				if ( $comments ) : echo '<ul>'; foreach ( (array) $comments as $comment) :					
					echo  '<li class="comment-replies  comment-replies-left top-level">';
					if($count%2==0) $evenodd = 'even'; else $evenodd = 'odd';
					echo '<div id="comment-'.$comment->comment_ID . '" class="comment '. $evenodd . ' "><div class="comment-num-div"><p class="comment-num">' . $count . '</p></div>';
			?>
			<div class="comment-meta">
				<div class="comment-info">
				<?php echo get_comment_date('m-d') . ' on <a href="'. get_comment_link($comment->comment_ID) . '">' . get_the_title($comment->comment_post_ID) . '</a>';?>
				</div>
				<p class="gravatar"><?php if(function_exists('get_avatar')) { echo get_avatar($comment, '36'); } ?></p>
			</div>
			<div class="comment-text comment-text-css">
	            <?php comment_text(); ?>
            </div><!--.commentText-->			
				<?php echo '</div></li>';
				if($count%2==0) { 
					echo '<div class="comment-height-giver"></div>'; 
					echo '<div class="clear"></div>';
				}
				$count++;
			endforeach; echo '</ul>'; else: ?>
            	<p class="no-comments">
            		No comments by <?php echo $curauth->display_name; ?> yet.
            	</p>
			<?php endif; ?>
        <div class="clear"></div>

	</div><!-- comment-content -->
	</div><!-- commentInners -->
	</div><!--#comments-->
</div><!--#content-->
<?php get_footer(); ?>