<?php
global $livefyre_quill_url;
if (function_exists( 'home_url' )) {
	$home_url=home_url();
} else {
	$home_url=get_option('home');
}
if (livefyre_returned_from_setup()) {
	/*-post to livefyre with "start session"
        -if "ok" set livefyre_import_status 'started'
        -if not "ok" show error
	*/
	update_option('livefyre_blogname', $_GET['site_id']);
	update_option('livefyre_secret', $_GET['secretkey']);
	$_GET['new_import']='1';
	$bn=$_GET['site_id'];
} else {
	$bn=get_option('livefyre_blogname',''); 
}
?>

<script type="text/javascript">
/*{"status": "created", "conversations_processed_count": 0, "last_modified": "2011-03-01T07:54:31", "aborted": false, "messages": "2011-03-01 07:54:31.910405\nCreated\n--------------------------------------------------\n", "conversation_count": 0}*/
//Lightweight JSONP fetcher - www.nonobtrusive.com
var JSONP=(function(){var a=0,c,f,b,d=this;function e(j){var i=document.createElement("script"),h=false;i.src=j;i.async=true;i.onload=i.onreadystatechange=function(){if(!h&&(!this.readyState||this.readyState==="loaded"||this.readyState==="complete")){h=true;i.onload=i.onreadystatechange=null;if(i&&i.parentNode){i.parentNode.removeChild(i)}}};if(!c){c=document.getElementsByTagName("head")[0]}c.appendChild(i)}function g(h,j,k){f="?";j=j||{};for(b in j){if(j.hasOwnProperty(b)){f+=b+"="+j[b]+"&"}}var i="json"+(++a);d[i]=function(l){k(l);d[i]=null;try{delete d[i]}catch(m){}};e(h+f+"callback="+i);return i}return{get:g}}());
var livefyre_wp_plugin_polled=false;
function checkStatusLF(){
	JSONP.get( '<?php echo $livefyre_quill_url ?>/import/wordpress/<?php echo get_option("livefyre_blogname") ?>/status', {param1:'none'}, function(data){
		if (data['status']=='does-not-exist' || data['status']=='complete') {
			clearInterval(checkStatusInterval);
			document.getElementById('livefyre_results').innerHTML='<br/>Import status: completed';
			document.getElementById('working').style.display = 'none';
		} else {
			if (data['status']=='failed' && !livefyre_wp_plugin_polled) {
				//existing job failed. retry!
				
			}
			document.getElementById('livefyre_results').innerHTML='Import status: '+(data['status']=='assembling' ? 'assembling - this may take several minutes if you have a lot of comments' : data['status']);
			document.getElementById('showresults').style.display = 'block';
			if (typeof(data['conversations_processed_count'])!='undefined' && parseInt(data['conversations_processed_count'])!=0) {
				document.getElementById('show_conv_processed').style.display = 'block';
				document.getElementById( 'convs_processed' ).innerHTML=data['conversations_processed_count'];
			}
			if (typeof(data['conversation_count'])!='undefined' && parseInt(data['conversation_count'])!=0) {
				document.getElementById('show_conv_count').style.display = 'block';
				document.getElementById( 'convs' ).innerHTML=data['conversation_count'];
			}
		}
		livefyre_wp_plugin_polled=true;
	});
}
<?php 
if (function_exists( 'home_url' )) {
	$home_url=home_url();
} else {
	$home_url=get_option('home');
}
?>
function checkStatusWP(){
	JSONP.get( '<?php echo $home_url  ?>/', {"lf_active_sync_status":"1"}, function(data){
		if (data['status']=='off') {
			clearInterval(checkWPStatusInterval);
			reloadPage();
		}
	});
}

function reloadPage(){
	document.location.reload();
}

function wordpress_start_ajax() {
	window.checkWPStatusInterval=setInterval(
		checkStatusWP, 
		5000
	);
	checkStatusWP();	
}
function livefyre_start_ajax() {
	window.checkStatusInterval=setInterval(
		checkStatusLF, 
		5000
	);
	checkStatusLF();
}
</script>


<div class="wrap">
<h2>Livefyre Settings</h2>
<?php
$new_import=(isset($_GET['new_import']) && $_GET['new_import']=='1');
if (get_option('livefyre_import_status','')=='started' && !$new_import) {
	$printthis = "Refreshing, just a moment..."; // . $result['body'];
	?>
	<script type="text/javascript">
		livefyre_start_ajax();
	</script>
	<?php
} else if ($bn!='' && $new_import) {
	if (get_option('livefyre_active_sync','')=='1') {
		livefyre_schedule_sync(true);
		$printthis = "<strong>The Livefyre plugin is currently synchronizing data back to WordPress.</strong><img src=\"http://livefyre.com/wjs/images/snake-loader.gif\"/>";
		?>
		<script type="text/javascript">
			wordpress_start_ajax();
		</script>
	
		<?php		
	} else {
		$printthis = "Requesting a new import session...";
		if (livefyre_new_import_session()) {
			?>
			<script type="text/javascript">
				livefyre_start_ajax();
			</script>
		
			<?php
		} else {
			$printthis = "Error requesting livefyre import session."; #TODO send chris and jenna email
		}
	}
}
if (get_option('livefyre_import_status','')=='csv_uploaded' && get_option('livefyre_active_sync','')!='1') {
	$printthis = "It looks like you're done...start using livefyre!"; // . $result['body'];
}

?>
<p><span id='livefyre_results'><?php echo $printthis; ?></span></p>
<div id='showresults' style="display:none;">
<p>Livefyre is importing comments from your WordPress database.  The Livefyre widget is now on your site and users can leave comments, however existing comments may not appear until this process has completed.</p>
<strong id='working'>Working...<img src="http://livefyre.com/wjs/images/snake-loader.gif"/></strong>
<p id="show_conv_count" style="display:none;">conversations: <label id='convs'></label></p>
<p id="show_conv_processed" style="display:none;">conversations processed: <label id='convs_processed'></label></p>

</div>

