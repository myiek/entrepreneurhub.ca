<?php 
	global $livefyre_admin_url, $livefyre_http_url, $livefyre_plugin_version;
	if ( livefyre_comments_off() ) {
	?>
        <div class="livefyre_install_incomplete" style="<?php echo (current_user_can( 'install_plugins' ) ? '' : 'display:none;');?>">
			You have not completed the Livefyre plugin installation. Go to the Livefyre plugin's <a href="<?php echo admin_url( 'edit-comments.php?page=livefyre' ); ?>">settings page</a> in the WordPress admin area to complete setup.
        </div>
<?php } else { 
	if (livefyre_show_comments()) { 

		?>
		<div id='lf_comment_stream' livefyre_title="<?php echo $post->post_title?>">
			<?php
			
		if($parent_id = wp_is_post_revision($post->ID)) {
			$post_id = $parent_id;
		} else {
			$post_id = $post->ID;
		}
		
	    if( !class_exists( 'WP_Http' ) )
	        include_once( ABSPATH . WPINC. '/class-http.php' );

	    $url = $livefyre_admin_url.'/fyres/show_partial/0/' . get_option( 'livefyre_blogname' ) . '/' . $post_id . '/?comments_open=' . comments_open();
	    $request = new WP_Http;
	    $result = $request->request( $url, array( 'method' => 'GET' ) );
	    if ( is_array( $result ) && $result['response'] )
			echo $result['body'];
		?>
		</div>
  <?php }
 	echo "<!-- Livefyre Comments Version: ".$livefyre_plugin_version."-->";
	if ( pings_open() ) { ?>
		<?php
		$num_pings = count( get_comments( array( 'post_id' => $post->ID, 'type' => 'pingback', 'status' => 'approve' ) ) ) + count( get_comments( array( 'post_id'=>$post->ID, 'type'=>'trackback', 'status'=>'approve' ) ) );
		if ( $num_pings > 0 ):
		?>
		<div style="font-family: arial !important;" id="lf_pings">
			<h3>Trackbacks</h3>
			<ol class="commentlist">
				<?php wp_list_comments( array( 'type'=>'pings', 'reply_text' => '' ) ); ?>
			</ol>
		</div>

		<?php endif;
 }  
} ?>