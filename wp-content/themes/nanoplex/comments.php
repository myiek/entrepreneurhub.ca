<div id="comments">
	<div class="commentInners">
	<div class="comment-content">
	<!-- Prevents loading the file directly -->
	<?php if(!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) : ?>
	    <?php die('Please do not load this page directly or we will hunt you down. Thanks and have a great day!'); ?>
	<?php endif; ?>
	
	<!-- Password Required -->
	<?php if ( post_password_required() ) : ?>
				<p class="nopassword"><?php echo 'This post is password protected. Enter the password to view any comments.'; ?></p>
			</div><!-- comment-content -->
			</div><!-- commentInners -->
		</div><!--#comments-->
	<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
	endif;?>
	
	
	<?php if($comments) : ?>
		<div class="post-title"><p><?php comments_number('No comments', 'One comment', '% comments'); ?></p></div>
		<?php global $i;
			$i = ( intval(get_query_var('cpage')) - 1 ) * ((int) get_query_var('comments_per_page'));
			if(!$i || $i<0) $i = 0;
		?> <!-- variable for alternating comment styles --> 
	    <ul>
	    <?php wp_list_comments(array(
		    'max_depth'         => 3,
		    'callback'          => 'nanoplex_comments',
		    'type'              => 'all',
		    'avatar_size'       => 32
		    )
		    ); 
		
		if($i%2==1) { 
			echo '<li class="comment-height-giver"></li>'; echo '<li class="clear"></li>';
		}?>
	    </ul>
	<?php else : ?>
	    <p class="no-comments">No comments yet. You should be kind and add one!</p>
	<?php endif; ?>
	
	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
	<div class="comment-navigation">
			<?php 
			$older = get_next_comments_link('Newer Comments <span class="meta-nav">&rarr;</span>');
			$newer = get_previous_comments_link( '<span class="meta-nav">&larr;</span> Older Comments');
			if($older) {
				if(!$newer) {
					echo '<div class="comment-nav-previous comment-nav big">' . $older . '</div>';
				}else echo '<div class="comment-nav-previous comment-nav">' . $older . '</div>';
			}
			if($newer) {
				if(!$older){
					echo  '<div class="comment-nav-next comment-nav big">' . $newer . '</div>';	
				}else echo  '<div class="comment-nav-next comment-nav">' . $newer . '</div>';
			}?>
	</div>
			
	<?php endif; // check for comment navigation ?>

	<div id="over_respond">
		<div class="form-holder"><?php if(comments_open()) comment_form(); 
		else echo '<div id="respond" ><h3 id="reply-title" class="long">' . 'Comments are closed for this post.' . '</h3></div>';
		?><div class="clear"></div></div>
	</div><!--.form=holder-->
	</div><!-- comment-content -->
	</div><!-- commentInners -->
</div><!--#comments-->