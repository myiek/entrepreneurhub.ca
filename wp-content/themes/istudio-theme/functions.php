<?php define("themename","iStudio");
if(function_exists('register_sidebar')){register_sidebar(array('name'=>themename.' Sidebar','description'=>themename.' RightSideBar','before_widget'=>'<ul><li id=\"%1$s\" class=\"widget %2$s\">','after_widget'=>'</li></ul>','before_title'=>'<h3 class=\"widgettitle\">','after_title'=>'</h3>' ));}
if(function_exists('add_theme_support'))add_theme_support('post-thumbnails');
add_action('admin_menu','istudio_excerpt_meta_box');
function istudio_excerpt_meta_box(){add_meta_box('postexcerpt',__('Excerpt'),'post_excerpt_meta_box','page','normal','core');}
function new_excerpt_length($length){return 20;}
add_filter('excerpt_length','new_excerpt_length');
function new_excerpt_more($more){return '...';}
add_filter('excerpt_more','new_excerpt_more');
add_theme_support('automatic-feed-links');
register_nav_menu('istudio_navmenu','iStudio Navigation Menu');
add_custom_background();
function home_page_menu_args($args){$args['show_home']=true;return $args;}
add_filter('wp_page_menu_args','home_page_menu_args');
if(!isset($content_width))$content_width=640;
function istudio_rcomments($limit){
	$comments=get_comments(array('number'=>$limit,'status'=>'approve'));
	$wpchres=get_option('blog_charset');
	$istorcoutput='';
	foreach($comments as $comment){
		$istorcoutput.='<li><a href="'.get_permalink($comment->comment_post_ID).'#comment-'.$comment->comment_ID.'" title="On '.get_the_title($comment->comment_post_ID).'">'.stripslashes($comment->comment_author).'</a>: '.mb_substr($comment->comment_content,0,25,$wpchres).'...</li>'."\n";
	}echo ent2ncr($istorcoutput);
}
function RandomShow($rsnum){if(!$rsnum){$rsnum=3;}$num=rand(1,$rsnum);$random='show'.$num;return $random;}
function istudio_page_number(){global $paged;if($paged>=2)echo ' - '.sprintf('Page %s',$paged);}
// Themes Options Page.
function istOption($option){
	$options=get_option('iStudio_Options');
	if(($option=='SearchKeyword')or($option=='pagenavnum')or($option=='CustomRssUrl')or($option=='rShow_num')or($option=='GrowlInfo')or($option=='googleId')or($option=='widgetInfo')or($option=='adfloat')or($option=='adcode_singlecont')or($option=='adcode_single')or($option=='adcode_sidebar')or($option=='adcode_rShow')){return ent2ncr($options[$option]);
	}else{return esc_attr($options[$option]);}
}
class iStudioOptions{
	function getOptions(){
		$options=get_option('iStudio_Options');
		if(!is_array($options)){
			$options['imageLogo']=false;
			$options['SearchKey']=false;
			$options['SearchKeyword']='';
			$options['pagenavnum']='theme';
			$options['showside']=false;
			$options['pageside']=false;
			$options['CustomFeed']=false;
			$options['CustomRssUrl']='';
			$options['rShow_num']='3';
			$options['rShow_ads']=false;
			$options['GrowlSwitch']=false;
			$options['GrowlInfo']='';
			$options['googleSearch']=false;
			$options['googleId']='';
			$options['ctrlentry']=false;
			$options['recommend_widget']=false;
			$options['widgetInfo']='';
			$options['adfloat']='left';
			$options['ad_show_singlecont']=false;
			$options['ad_show_single']=false;
			$options['ad_show_sidebar']=false;
			$options['ad_show_rShow']=false;
			$options['adcode_singlecont']='';
			$options['adcode_single']='';
			$options['adcode_sidebar']='';
			$options['adcode_rShow']='';
			update_option('iStudio_Options',$options);
		}return $options;
	}
	function resOptions(){delete_option('iStudio_Options');}
	function addOptions(){
		if(isset($_POST['save_submit'])){
			$options=iStudioOptions::getOptions();
			if($_POST['imageLogo']){$options['imageLogo']=(bool)true;
			}else{$options['imageLogo']=(bool)false;}
			if($_POST['SearchKey']){$options['SearchKey']=(bool)true;
			}else{$options['SearchKey']=(bool)false;}
			$options['SearchKeyword']=stripslashes($_POST['SearchKeyword']);
			$options['pagenavnum']=stripslashes($_POST['pagenavnum']);
			if($_POST['showside']){$options['showside']=(bool)true;
			}else{$options['showside']=(bool)false;}
			if($_POST['pageside']){$options['pageside']=(bool)true;
			}else{$options['pageside']=(bool)false;}
			if($_POST['CustomFeed']){$options['CustomFeed']=(bool)true;
			}else{$options['CustomFeed']=(bool)false;}
			$options['CustomRssUrl']=stripslashes($_POST['CustomRssUrl']);
			if(!$_POST['rShow_num']){$options['rShow_num']=stripslashes(3);
			}elseif($_POST['rShow_num']<3){$options['rShow_num']=stripslashes(3);
			}else{$options['rShow_num']=stripslashes($_POST['rShow_num']);}
			if($_POST['rShow_ads']){$options['rShow_ads']=(bool)true;
			}else{$options['rShow_ads']=(bool)false;}
			if($_POST['GrowlSwitch']){$options['GrowlSwitch']=(bool)true;
			}else{$options['GrowlSwitch']=(bool)false;}
			$options['GrowlInfo']=stripslashes($_POST['GrowlInfo']);
			if($_POST['googleSearch']){$options['googleSearch']=(bool)true;
			}else{$options['googleSearch']=(bool)false;}
			$options['googleId']=stripslashes($_POST['googleId']);
			if($_POST['recommend_widget']){$options['recommend_widget']=(bool)true;
			}else{$options['recommend_widget']=(bool)false;}
			$options['widgetInfo']=stripslashes($_POST['widgetInfo']);
			if($_POST['ctrlentry']){$options['ctrlentry']=(bool)true;
			}else{$options['ctrlentry']=(bool)false;}
			$options['adfloat']=stripslashes($_POST['adfloat']);
			if($_POST['ad_show_singlecont']){$options['ad_show_singlecont']=(bool)true;
			}else{$options['ad_show_singlecont']=(bool)false;}
			if($_POST['ad_show_single']){$options['ad_show_single']=(bool)true;
			}else{$options['ad_show_single']=(bool)false;}
			if($_POST['ad_show_sidebar']){$options['ad_show_sidebar']=(bool)true;
			}else{$options['ad_show_sidebar']=(bool)false;}
			if($_POST['ad_show_rShow']){$options['ad_show_rShow']=(bool)true;
			}else{$options['ad_show_rShow']=(bool)false;}
			$options['adcode_singlecont']=stripslashes($_POST['adcode_singlecont']);
			$options['adcode_single']=stripslashes($_POST['adcode_single']);
			$options['adcode_sidebar']=stripslashes($_POST['adcode_sidebar']);
			$options['adcode_rShow']=stripslashes($_POST['adcode_rShow']);
			update_option('iStudio_Options',$options);
			echo "<div id='message' class='updated fade'><p><strong>".__('Settings saved.','iStudio')."</strong></p></div>";
		}else{iStudioOptions::getOptions();}
		if(isset($_REQUEST['restore-defaults'])){
			iStudioOptions::resOptions();
			echo "<div id='message' class='updated fade'><p><strong>".__('Settings have been restored to default.','iStudio')."</strong></p></div>";
		}add_theme_page(__(themename.' Options'),__(themename.' Options'),'edit_themes',basename(__FILE__),array('iStudioOptions','OptionsPage')); 
	}
	function OptionsPage(){$options=iStudioOptions::getOptions();?>
<script type="text/javascript">
(function(jQuery){istojQ=jQuery.noConflict();istojQ(document).ready(function(){istojQ('.iStudio_fold').find('.iSfold').hide();istojQ('.iStudio_fold').find('legend').mouseup(function(){var answer=istojQ(this).next();if(answer.is(':visible')){answer.slideUp();}else{answer.slideDown();}});});})(jQuery);
</script>
<style type="text/css">
.wrap{padding:10px;}
fieldset{border:1px solid #ddd;margin:5px 0 10px;padding:5px 15px 15px;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;}
fieldset:hover{border-color:#bbb;}
fieldset legend{padding:0 5px;color:#666;font-size:14px;font-weight:700;}
fieldset .line{border-bottom:1px solid #e5e5e5;padding-bottom:15px;}
</style>
<div class="wrap">
  <div id="icon-options-general" class="icon32"></div>
  <h2><?php echo themename;?> <?php _e('Options','iStudio');?></h2>
  <p><?php _e('Thank you for using iStudio. This Theme is Designed by Xu.hel.','iStudio');?></p>
  <p><?php _e('You can click the donate button at the bottom of this page if you think this is a very nice WordPress theme.  Thank you.','iStudio');?></p>
  <fieldset>
  	<legend><?php _e('Custom Shortcode','iStudio');?></legend>
    <div style="padding-left:1em;">
      <p><?php _e('Shortcode format:','iStudio');?></p>
      <p><?php _e('Insert Download: <code>[Downlink href="URL"]Filename[/Downlink]</code>','iStudio');?></p>
      <p><?php _e('Insert FLV Video: <code>[flv auto="1"]FLV URL[/flv]</code>','iStudio');?></p>
      <p><?php _e('Insert MP3 Music: <code>[mp3 auto="1" replay="0"]MP3 URL[/mp3]</code>','iStudio');?></p>
    </div>
  </fieldset>
  <div>
  <form action="#" method="post" enctype="multipart/form-data" name="options_form" id="options_form" class="iStudio_fold">
    <fieldset>
      <legend><?php _e('General','iStudio');?></legend>
      <div style="padding-left:1em;">
        <p><?php _e('Page Number style is displayed as:','iStudio');?><label style="margin-right:20px;"><input name="pagenavnum" type="radio" value="theme" <?php if($options['pagenavnum']!='default')echo "checked='checked'";?> /><?php _e('Theme Styles','iStudio');?></label><label><input name="pagenavnum" type="radio" value="default" <?php if($options['pagenavnum']=='default')echo "checked='checked'";?> /><?php _e('Default Styles','iStudio');?></label></p>
        <p><label><input name="imageLogo" type="checkbox" value="checkbox" <?php if($options['imageLogo'])echo "checked='checked'";?> > <?php _e('Use the Picture Logo.','iStudio');?></label></p>
        <p><label><input name="showside" type="checkbox" value="checkbox" <?php if($options['showside'])echo "checked='checked'";?> /> <?php _e('Show sidebar in single pages.','iStudio');?></label></p>
        <p><label><input name="pageside" type="checkbox" value="checkbox" <?php if($options['pageside'])echo "checked='checked'";?> /> <?php _e('Show sidebar in pages.','iStudio');?></label></p>
        <p><label><input name="ctrlentry" type="checkbox" value="checkbox" <?php if($options['ctrlentry'])echo "checked='checked'";?> /> <?php _e('Use Ctrl+Enter to Reply Comments.','iStudio');?></label></p>
      </div>
    </fieldset>
    <fieldset>
      <legend><label><input name="SearchKey" type="checkbox" value="checkbox" <?php if($options['SearchKey'])echo "checked='checked'";?> /> <?php _e('Enable keywords for search engine.','iStudio');?></label></legend>
      <div<?php if(!$options['SearchKey'])echo ' class="iSfold"';?> style="padding-left:1em;">
        <p><?php _e('Search engine keywords values fill in the following input box. Each keyword with "," separated.','iStudio');?></p>
        <input name="SearchKeyword" type="text" value="<?php echo($options['SearchKeyword']);?>" size="80" />
      </div>
    </fieldset>
    <fieldset>
      <legend><label><input name="CustomFeed" type="checkbox" value="checkbox" <?php if($options['CustomFeed'])echo "checked='checked'";?> > <?php _e('Custom RSS Subscription','iStudio');?></label></legend>
      <div<?php if(!$options['CustomFeed'])echo ' class="iSfold"';?> style="padding-left:1em;">
        <p><?php _e('Please enter a new RSS subscription address (if not set is to use WordPress\'s default subscription address).','iStudio');?></p>
        <input name="CustomRssUrl" type="text" value="<?php echo($options['CustomRssUrl']);?>" size="80" />
      </div>
    </fieldset>
    <fieldset>
      <legend><label><input name="GrowlSwitch" type="checkbox" value="checkbox" <?php if($options['GrowlSwitch'])echo "checked='checked'";?> > <?php _e('Enable GrowlBox pop-up tips','iStudio');?></label></legend>
      <div<?php if(!$options['GrowlSwitch'])echo ' class="iSfold"';?> style="padding-left:1em;">
        <p><?php _e('GrowlBox the content of the pop-up tips(Use HTML code.):','iStudio');?></p>
        <input name="GrowlInfo" type="text" value="<?php echo(esc_html($options['GrowlInfo']));?>" size="80" />
      </div>
    </fieldset>
    <fieldset>
      <legend><label><input name="googleSearch" type="checkbox" value="checkbox" <?php if($options['googleSearch'])echo "checked='checked'";?> /> <?php _e('Use google custom search engine','iStudio');?></label></legend>
      <div<?php if(!$options['googleSearch'])echo ' class="iSfold"';?> style="padding-left:1em;">
        <p><?php _e('Find <code>name="cx"</code> in the <strong>Search box code</strong> of <a href="http://www.google.com/coop/cse/">Google Custom Search Engine</a>, and enter the <code>value</code> here.<br/>For example: <code>014782006753236413342:1ltfrybsbz4</code>','iStudio');?></p>
        <input name="googleId" type="text" value="<?php echo($options['googleId']);?>" size="80" />
      </div>
    </fieldset>
    <fieldset>
      <legend><label><input name="recommend_widget" type="checkbox" value="checkbox" <?php if($options['recommend_widget'])echo "checked='checked'";?> /> <?php _e('Open the article Recommendation Widgets','iStudio');?></label></legend>
      <div<?php if(!$options['recommend_widget'])echo ' class="iSfold"';?> style="padding-left:1em;">
        <p><?php _e('Recommended articles to be linked with the HTML code written in the input box below:','iStudio');?></p>
        <textarea name="widgetInfo" cols="80" rows="3"><?php echo($options['widgetInfo']);?></textarea>
      </div>
    </fieldset>
    <fieldset>
      <legend><label><?php _e('Random Image','iStudio');?></label></legend>
      <div style="padding-left:1em;">
        <p><label><?php _e('Number of images:','iStudio');?><input name="rShow_num" type="text" value="<?php echo $options['rShow_num'];?>" size="3" maxlength="3"<?php if($options['rShow_ads'])echo ' readonly="readonly"';?> /></label><?php _e('3 images at minimum.','iStudio');?></p>
        <fieldset>
        	<legend><label><input name="rShow_ads" type="checkbox" value="checkbox" <?php if($options['rShow_ads'])echo "checked='checked'";?> /> <?php _e('Use ads to replace random pictures.','iStudio');?></label></legend>   
        <div<?php if(!$options['rShow_ads'])echo ' class="iSfold"';?> style="padding-left:1em;">
        	<p><?php _e('Ads code to replace the random pictures: (Max size: 860x120)','iStudio');?><label><input name="ad_show_rShow" type="checkbox" value="checkbox" <?php if($options['ad_show_rShow'])echo "checked='checked'";?> /> <?php _e('Hide after user logged in','iStudio');?></label></p>
        	<textarea name="adcode_rShow" cols="80" rows="3"><?php echo($options['adcode_rShow']);?></textarea>
      	</div> 
        </label>  
      </div>
    </fieldset>
    <fieldset>
      <legend><?php _e('Ad Code Settings','iStudio');?></legend>
      <div>
      <div style="padding-left:1em;" class="line">
        <p><?php _e('Ads code will not be displayed as long as the ad code box was emptied.','iStudio');?></p>
        <p><?php _e('Ad code embedded in the article: (Max size: 300x250)','iStudio');?></p>
        <p style="text-indent:2em;"><?php _e('Embedded ads appear here:','iStudio');?><label style="margin-right:20px;"><input name="adfloat" type="radio" value="left" <?php if($options['adfloat']!='right')echo "checked='checked'";?> /><?php _e('left','iStudio');?></label><label><input name="adfloat" type="radio" value="right" <?php if($options['adfloat']=='right')echo "checked='checked'";?> /><?php _e('right','iStudio');?></label><label style="margin-left:20px;"><input name="ad_show_singlecont" type="checkbox" value="checkbox" <?php if($options['ad_show_singlecont'])echo "checked='checked'";?> /> <?php _e('Hide after user logged in','iStudio');?></label></p>
        <textarea name="adcode_singlecont" cols="80" rows="3"><?php echo($options['adcode_singlecont']);?></textarea>
      </div>
      <div style="padding-left:1em;" class="line">
        <p><?php _e('Ad code displayed inside single article: (Max size: 728x90)','iStudio');?><label><input name="ad_show_single" type="checkbox" value="checkbox" <?php if($options['ad_show_single'])echo "checked='checked'";?> /> <?php _e('Hide after user logged in','iStudio');?></label></p>
        <textarea name="adcode_single" cols="80" rows="3"><?php echo($options['adcode_single']);?></textarea>
      </div>
      <div style="padding-left:1em;">
        <p><?php _e('Ad code displayed in the sidebar: (Max size: 200x220)','iStudio');?><label><input name="ad_show_sidebar" type="checkbox" value="checkbox" <?php if($options['ad_show_sidebar'])echo "checked='checked'";?> /> <?php _e('Hide after user logged in','iStudio');?></label></p>
        <textarea name="adcode_sidebar" cols="80" rows="3"><?php echo($options['adcode_sidebar']);?></textarea>
      </div>
      </div>
    </fieldset>
    <p class="submit">
      <input type="submit" name="save_submit" class="button-primary" value="<?php _e('Save Changes','iStudio');?>" />
      <input name="restore-defaults" id="restore-defaults" onclick="return confirmDefaults();" value="<?php _e('Revert to Defaults','iStudio');?>" class="button-secondary" type="submit">
    </p>
  </form>
  </div>
  <hr size="1" color="#bbb" />
  <h3>Donation</h3>
  <div>
  	<p>If you find my work useful and you want to encourage the development of more free resources, you can do it by donating...</p>
  	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
      <input type="hidden" name="cmd" value="_s-xclick">
      <input type="hidden" name="hosted_button_id" value="4839415">
      <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
      <img alt="" border="0" src="https://www.paypal.com/zh_XC/i/scr/pixel.gif" width="1" height="1">
    </form>
  </div>
  </fieldset>
</div>
<?php }
}
add_action('admin_menu',array('iStudioOptions','addOptions'));
function istudio_get_logo(){
	$logoImage=istOption('imageLogo');
	if($logoImage){?>
  <h1 class="hidden"><a href="<?php echo home_url('/');?>"><?php bloginfo('name');?></a></h1>
  <div class="hidden"><?php bloginfo('description');?></div>
  <a class="logo" href="<?php echo home_url('/');?>"></a>
  <?php }else{?>
  <h1><a href="<?php bloginfo('url');?>"><?php bloginfo('name');?></a></h1>
  <div class="description"><?php bloginfo('description');?></div>
  <?php }
}
function istudio_Shortpage(){?>
<style type="text/css">
fieldset{border:1px solid #ddd;margin:5px 0 10px;padding:0 15px;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;}
fieldset:hover{border-color:#bbb;}
fieldset legend{padding:0 5px;font-size:14px;}
</style>
<div class="wrap">
<div id="icon-upload" class="icon32"><br></div>
<h2><?php _e('iStudio Shortcode','iStudio');?></h2>
<fieldset>
  	<legend><?php _e('iStudio Custom Shortcode format','iStudio');?></legend>
    <div style="padding-left:1em;">
    	<h4><?php _e('Insert Download','iStudio');?></h4>
      <p><?php _e('Insert the following code into the editor, you will be able to use the built-in download button style.','iStudio');?></p>
      <p><?php _e('Code format: <code>[Downlink href="http://www.xxx.com/xxx.zip"]download xxx.zip[/Downlink]</code>','iStudio');?></p>
      <h4><?php _e('Insert MP3 music','iStudio');?></h4>
      <p><?php _e('Insert the following code into the editor, you will be able to use the built-in MP3 music player..','iStudio');?></p>
      <p><?php _e('Only supports mp3 file URL.','iStudio');?></p>
      <p><?php _e('Code format: <code>[mp3]http://www.xxx.com/xxx.mp3[/mp3]</code>','iStudio');?></p>
      <p><?php _e('Auto Play: <code>[mp3 auto="1"]http://www.xxx.com/xxx.mp3[/mp3]</code>','iStudio');?></p>
      <p><?php _e('Repeat Play: <code>[mp3 replay="1"]http://www.xxx.com/xxx.mp3[/mp3]</code>','iStudio');?></p>
      <p><?php _e('Auto Play and Repeat Play: <code>[mp3 auto="1" replay="1"]http://www.xxx.com/xxx.mp3[/mp3]</code>','iStudio');?></p>
      <h4><?php _e('Insert FLV video','iStudio');?></h4>
      <p><?php _e('Insert the following code into the editor, you will be able to use the built-in video player to play FLV video.','iStudio');?></p>
      <p><?php _e('Only supports flv file URL.','iStudio');?></p>
      <p><?php _e('Code format: <code>[flv]http://www.xxx.com/xxx.flv[/flv]</code>','iStudio');?></p>
      <p><?php _e('Auto Play: <code>[flv auto="1"]http://www.xxx.com/xxx.flv[/flv]</code>','iStudio');?></p>
    </div>
  </fieldset>
</div>
<?php }
function istudio_ShortLink_page(){add_posts_page(__('iStudio Shortcode','iStudio'),__('iStudio Shortcode','iStudio'),'edit_posts',basename(__FILE__),'istudio_Shortpage');}
add_action('admin_menu','istudio_ShortLink_page');
// Custom Comments List.
if(function_exists('wp_list_comments')){
	function comment_count($commentcount){
		global $id;
		$_commnets=get_comments('status=approve&post_id='.$id);
		$comments_by_type=&separate_comments($_commnets);
		return count($comments_by_type['comment']);
	}
}
function istudio_custom_comments($comment,$args,$depth){
	$GLOBALS['comment']=$comment;
	global $commentcount;
	if(!$commentcount){$commentcount=0;}?>
<li <?php comment_class();?> id="comment-<?php comment_ID();?>">
  <div class="list">
    <?php if($comment->comment_author_email==get_the_author_meta('email')){?>
    <table class="inc" border="0" cellspacing="0" cellpadding="0">
      <tr><td align="right" valign="bottom"><table border="0" cellpadding="0" cellspacing="0">
          <tr><td class="topleft"></td><td class="top"></td><td class="topright"></td></tr>
          <tr><td class="left"></td>
            <td align="left" class="conmts"><?php comment_text();?></td>
            <td class="right"></td></tr>
          <tr><td class="bottomleft"></td><td class="bottom"></td><td class="bottomright"></td></tr>
        </table></td>
        <td class="icontd" align="right" valign="bottom"><?php if(function_exists('get_avatar')){?><div class="gravatar2"><?php echo get_avatar($comment,32);?></div><?php }?></td></tr>
    </table>
    <div class="comment_textr">
      <cite><?php comment_author_link();?></cite> at <a href="#comment-<?php comment_ID();?>" title=""><?php comment_date();?> <?php comment_time();?></a><?php if ($comment->comment_approved=='0'){?><em>Your comment is awaiting moderation.</em><?php }?>
      <small class="commentmetadata"><?php edit_comment_link('Edit','&nbsp;&nbsp;',' | ');?> <a onclick='istoJSCM.goReply("<?php comment_ID();?>", "<?php comment_author();?>")' href="#respond" style="cursor:pointer;"/><?php _e('Reply');?></a></small>
    </div>
		<?php }else{?>
    <table class="out" border="0" cellspacing="0" cellpadding="0">
      <tr><td class="icontd" align="left" valign="bottom"><?php if(function_exists('get_avatar')){?><div class="gravatar"><?php echo get_avatar($comment,32);?></div><?php }?></td>
        <td align="left" valign="bottom"><table border="0" cellspacing="0" cellpadding="0">
          <tr><td class="topleft"></td><td class="top"></td><td class="topright"></td></tr>
          <tr><td class="left"></td>
            <td class="conmts"><?php comment_text();?></td>
          	<td class="right"></td></tr>
          <tr><td class="bottomleft"></td><td class="bottom"></td><td class="bottomright"></td></tr>
        </table></td></tr>
    </table>
    <div class="comment_text">
      <cite><?php comment_author_link();?></cite> at <a href="#comment-<?php comment_ID();?>" title=""><?php comment_date();?> <?php comment_time();?></a><?php if ($comment->comment_approved=='0'){?><em>Your comment is awaiting moderation.</em><?php }?>
      <small class="commentmetadata"><?php edit_comment_link('Edit','&nbsp;&nbsp;',' | ');?> <a onclick='istoJSCM.goReply("<?php comment_ID();?>", "<?php comment_author();?>")' href="#respond" style="cursor:pointer;"/><?php _e('Reply');?></a></small>    
    </div>
    <?php }?>
  </div>
</li>
<?php }
// Custom Trackbacks List.
function istudio_custom_pings($comment,$args,$depth){
$GLOBALS['comment']=$comment;?>
<li <?php echo $oddcomment;?>id="comment-<?php comment_ID()?>">
	<div class="list">    
    <table class="out" border="0" cellspacing="0" cellpadding="0">
    	<tr><td class="topleft"></td><td class="top"></td><td class="topright"></td></tr><tr><td class="left"></td><td class="conmts">
      	<cite><?php comment_author_link();?></cite> 
      	<small>(<?php echo $pingtype;?>,<?php if ($comment->comment_approved=='0'){?><em>Your comment is awaiting moderation.</em><?php }?><?php comment_date();?></small>)
      	<?php comment_text();?>
      </td><td class="right"></td>
      </tr><tr><td class="bottomleft"></td><td class="bottom"></td><td class="bottomright"></td></tr>
    </table>  
  </div>
</li>
<?php }
// Page Nav.
function istudio_pagenavi(){global $wp_query;$options=array('pages_text'=>'Page %CURRENT_PAGE% of %TOTAL_PAGES%','current_text'=>'%PAGE_NUMBER%','page_text'=>'%PAGE_NUMBER%','prev_text'=>'&laquo;','next_text'=>'&raquo;','dotleft_text'=>'...','dotright_text'=>'...','num_pages'=>7,'always_show'=>false);$posts_per_page=intval(get_query_var('posts_per_page'));$paged=absint(get_query_var('paged'));if(!$paged){$paged=1;}$total_pages=absint($wp_query->max_num_pages);if(!$total_pages){$total_pages=1;}if(1==$total_pages && !$options['always_show']){return;}$request=$wp_query->request;$numposts=$wp_query->found_posts;$pages_to_show=absint($options['num_pages']);$pages_to_show_minus_1=$pages_to_show-1;$half_page_start=floor($pages_to_show_minus_1/2);$half_page_end=ceil($pages_to_show_minus_1/2);$start_page=$paged-$half_page_start;if($start_page<=0){$start_page=1;}$end_page=$paged+$half_page_end;if(($end_page-$start_page)!=$pages_to_show_minus_1){$end_page=$start_page+$pages_to_show_minus_1;}if($end_page>$total_pages){$start_page=$total_pages-$pages_to_show_minus_1;$end_page=$total_pages;}if($start_page<=0){$start_page=1;}$out='';if($start_page>=2 && $pages_to_show<$total_pages){if(!empty($options['prev_text']))$out.=istudio_getpreviouslink($options['prev_text']);if(!empty($options['dotleft_text'])){$out.="<span class='extend'>{$options['dotleft_text']}</span>";}}foreach(range($start_page,$end_page)as $i){if($i==$paged && !empty($options['current_text'])){$current_page_text=str_replace('%PAGE_NUMBER%',number_format_i18n($i),$options['current_text']);$out.="<span class='current'>$current_page_text</span>";}else{$out.=istudio_pagenum($i,'page',$options['page_text']);}}if($end_page < $total_pages){if(!empty($options['dotright_text'])){$out.="<span class='extend'>{$options['dotright_text']}</span>";}if(!empty($options['next_text'])){$out.=istudio_getnextlink($options['next_text'],$total_pages);}$larger_page_end=0;}$out="<div class='istudio_pagenavi'>\n$out\n</div>\n";echo apply_filters('istudio_pagenavi',$out);}function istudio_getnextlink($label='Next Page &raquo;',$max_page=0){global $paged,$wp_query;if(!$max_page){$max_page=$wp_query->max_num_pages;}if(!$paged){$paged=1;}$nextpage=intval($paged)+1;if(!is_single()&&(empty($paged)|| $nextpage<=$max_page)){$attr=apply_filters('next_posts_link_attributes','');return '<a class="next" href="'.next_posts($max_page,false)."\" $attr>".preg_replace('/&([^#])(?![a-z]{1,8};)/i','&#038;$1',$label).'</a>';}}function istudio_getpreviouslink($label='&laquo; Previous Page'){global $paged;if(!is_single()&&$paged>1){$attr=apply_filters('previous_posts_link_attributes','');return '<a class="prev" href="'.previous_posts(false)."\" $attr>".preg_replace('/&([^#])(?![a-z]{1,8};)/','&#038;$1',$label).'</a>';}}function istudio_pagenum($page,$class,$raw_text,$format='%PAGE_NUMBER%'){if(empty($raw_text)){return '';}$text=str_replace($format,number_format_i18n($page),$raw_text);return "<a href='".esc_url(get_pagenum_link($page))."' class='$class'>$text</a>";}
// Random images show.
function istudio_randompic(){
	$rShow_num=istOption('rShow_num');
	if(istOption('rShow_ads')&&istOption('adcode_rShow')){$rShow_code=istOption('adcode_rShow');$rShowshow=istOption('ad_show_rShow');}else{$rShow_code=NULL;}
	echo '<section id="RandomShow">'."\n";
	if($rShow_code){if($rShowshow){if(!is_user_logged_in())echo $rShow_code;}else{echo $rShow_code;}}else{
		echo '<img src="'.get_template_directory_uri().'/showpic/stu'.RandomShow($rShow_num).'.jpg" alt="" />'."\n";}
	echo '</section>'."\n";
}
// Custom languages.
function istudio_theme_init(){load_theme_textdomain('iStudio',TEMPLATEPATH.'/resources/languages');}
add_action('init','istudio_theme_init');
// Custom Login Style.
function istudio_custom_login(){echo '<link rel="stylesheet" tyssspe="text/css" href="'.get_template_directory_uri().'/resources/custom-login/custom-login.css" />';}
add_action('login_head','istudio_custom_login');
// Custom Shortcode.
function istudio_downlink($atts,$content=null){
	extract(shortcode_atts(array("href"=>'http://'),$atts));
	return '<div class="but_down"><a href="'.$href.'"target="_blank"><span>'.$content.'</span></a><div class="clear"></div></div>';
}
function istudio_flvlink($atts,$content=null){
	extract(shortcode_atts(array("auto"=>'0'),$atts));
	return'<embed src="'.get_template_directory_uri().'/resources/flvideo.swf?auto='.$auto.'&flv='.$content.'" menu="false" quality="high" wmode="transparent" bgcolor="#ffffff" width="560" height="315" name="flvideo" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer_cn" />';
}
function istudio_mp3link($atts, $content=null){
	extract(shortcode_atts(array("auto"=>'0',"replay"=>'0',),$atts));	
	return '<embed src="'.get_template_directory_uri().'/resources/dewplayer.swf?mp3='.$content.'&amp;autostart='.$auto.'&amp;autoreplay='.$replay.'" wmode="transparent" height="20" width="200" type="application/x-shockwave-flash" />';
}
add_shortcode('Downlink','istudio_downlink');
add_shortcode('flv','istudio_flvlink');
add_shortcode('mp3','istudio_mp3link');
// Enqueue Script.
function istudio_enqueue_script(){	
	wp_enqueue_script('theme_scripts',get_template_directory_uri().'/resources/scripts/scripts.js');
	wp_enqueue_script('jquery');
	if(istOption('GrowlSwitch')&&istOption('GrowlInfo')){wp_enqueue_script('jgrowl',get_template_directory_uri().'/resources/scripts/jquery.jgrowl.js');}
	wp_enqueue_script('jqmenus',get_template_directory_uri().'/resources/scripts/jqmenus.js');
}
function istudio_headjscript(){
	if(istOption('GrowlSwitch')&&istOption('GrowlInfo')){?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/resources/scripts/jquery.jgrowl.css" type="text/css"/>
<?php }
}
add_action('wp_head','istudio_headjscript');
function istudio_custom_feed(){
	if(istOption('CustomFeed')&&istOption('CustomRssUrl')){remove_action('wp_head', 'feed_links_extra');$CustomFeed=istOption('CustomRssUrl');?>
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name');?> RSS Feed" href="<?php echo $CustomFeed;?>" />
	<?php }
}
// Hello IE6 User.
function istudio_helloIe6_msg(){?>
<!--[if IE 6]>
<script type="text/javascript">
/*Load jQuery if not already loaded*/if(typeof jQuery=='undefined'){document.write("<script type=\"text/javascript\" src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js\"></"+"script>");var __noconflict=true;}
var IE6UPDATE_OPTIONS={icons_path:"<?php echo get_template_directory_uri();?>/resources/scripts/ie6upimg/"}
</script>
<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/resources/scripts/ie6update.js"></script>
<![endif]-->
<?php }
add_action('wp_head','istudio_helloIe6_msg');
get_template_part('functions.widget');// Custom Widget.
get_template_part('functions.custom');// Custom Functions.
// WordPress Hack.
remove_action('wp_head','wp_generator');?>