<?php if(istOption('showside')){$showside='sidecomments';}else{$showside='postcomments';}
if(istOption('pagenavnum')=='default'){$pnavcalss='navigation';}else{$pnavcalss='istudio_pagenavi';}
$ctrlentry=istOption('ctrlentry');?>
<section class="<?php echo $showside;?>">
  <script type="text/javascript" src="<?php bloginfo('template_url');?>/resources/scripts/comment.js"></script>
  <?php if(!empty($post->post_password)&&$_COOKIE['wp-postpass_'.COOKIEHASH]!=$post->post_password){?>
  <p class="comments">This post is password protected. Enter the password to view comments.</p>
  <?php return;}?>
  <?php if(function_exists('wp_list_comments')){$trackbacks=$comments_by_type['pings'];}?>
  <?php if($comments||comments_open()){?>
  <h3 id="comments"><?php _e('Responses to ','iStudio');?>&#8220;<?php the_title();?>&#8221;</h3>
  <section id="comments">
    <section id="cmtswitcher">
      <?php if(pings_open()){?>
      <a id="commenttab" class="curtab" href="javascript:void(0);" onclick="istoJS.switchTab('thecomments,commentnavi','thetrackbacks','commenttab','curtab','trackbacktab','tab');"><?php _e('Comments','iStudio');echo (' ('.(count($comments)-count($trackbacks)).')');?></a>
      <a id="trackbacktab" class="tab" href="javascript:void(0);" onclick="istoJS.switchTab('thetrackbacks','thecomments,commentnavi','trackbacktab','curtab','commenttab','tab');"><?php _e('Trackbacks','iStudio');echo (' ('.count($trackbacks).')');?></a>
      <?php }else{?>
      <a id="commenttab" class="curtab" href="javascript:void(0);"><?php _e('Comments','iStudio');echo(' ('.(count($comments)-count($trackbacks)).')');?></a>
      <?php }?>
      <?php if(comments_open()){?>
      <span class="addcomment"><a href="#respond"><?php _e('Leave a comment','iStudio');?></a></span>
      <?php }?>
      <?php if(pings_open()){?>
      <span class="addtrackback"><a href="<?php trackback_url();?>"><?php _e('Trackback url', 'iStudio');?></a></span>
      <?php }?>
      <section class="clear"></section>      
    </section>    
    <section id="commentlist">
      <ol id="thecomments" class="commentlist">
			<?php if($comments&&count($comments)-count($trackbacks)>0){
				wp_list_comments('type=comment&callback=istudio_custom_comments');
			}else{?>
      	<li class="messagebox"><?php _e('No comments yet.','iStudio');?></li>
			<?php }?>
      </ol>
      <?php if(get_option('page_comments')){
				$comment_pages=paginate_comments_links('echo=0');
				if($comment_pages){?>
      <section class="navigation">
      	<section class="<?php echo $pnavcalss;?>"><!--span class="pages"><?php _e('Comment Page:','iStudio');?></span--><?php echo $comment_pages;?></section>
      	<section class="clear"></section>
      </section>
      <?php }	}
			if(pings_open()){?>
      <ol id="thetrackbacks" class="pingbacklist">
        <?php if($trackbacks){$trackbackcount=0;
				foreach($trackbacks as $comment):?>
        <li <?php echo $oddcomment;?>id="comment-<?php comment_ID();?>">
          <div class="list">    
          	<table class="out" border="0" cellspacing="0" cellpadding="0">
          		<tr><td class="topleft"></td><td class="top"></td><td class="topright"></td></tr><tr><td class="left"></td><td class="conmts">
          			<cite><?php comment_author_link();?></cite> 
          			<small>(<?php echo $pingtype;?>,<?php if($comment->comment_approved=='0'){?><em>Your comment is awaiting moderation.</em><?php }comment_date();?></small>)
          			<?php comment_text();?>
          		</td><td class="right"></td>
          		</tr><tr><td class="bottomleft"></td><td class="bottom"></td><td class="bottomright"></td></tr>
          	</table>  
          </div>
        </li>
        <?php endforeach;?>
        <?php }else{?>
        <li class="messagebox"><?php _e('No trackbacks yet.','iStudio');?></li>
        <?php }?>
      </ol>
      <?php }?>
      <section class="clear"></section>
    </section>
  </section>
<?php }
comment_form('comment_notes_after=');
if(($comments||comments_open())&&$ctrlentry){?>
<script type="text/javascript">
istoJS.loadCommentShortcut();(function(jQuery){istojQ=jQuery.noConflict();istojQ(document).ready(function(){istojQ("#respond #commentform .form-submit #submit").after("<label class=\"cereply\"><?php echo _e('Use Ctrl+Enter to Reply Comments.','iStudio');?></label>");});})(jQuery);
</script><?php }?>
</section>