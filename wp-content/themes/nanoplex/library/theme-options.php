<?php


// Theme options shamelessly stolen from the Erudite them, which stole it from the Thematic Framework, which itself adapted from "A Theme Tip For WordPress Theme Authors"
// http://literalbarrage.org/blog/archives/2007/05/03/a-theme-tip-for-wordpress-theme-authors/

$themename = 'Nanoplex';
$shortname = 'nnpl_';
global $nnpl_nonce;
$nnpl_nonce = 'nnpl_nonce';

// Create theme options
global $nnpl_options;
$nnpl_options = array (
	array(
		'name' => 'Edit Post Layout',
		'desc' => 'Disable different kinds of layouts for your posts.',
		'id' => $shortname.'random_layout_posts',
		'std' => false,
		'type' => 'checkbox'
	),
	array(
		'name' => 'Random Layout Probability',
		'desc' => 'If random post layouts are enabled (see above), here you can specify the probability of a left-aligned post appearing. (Default is 35) Please enter an integer.',
		'id' => $shortname.'random_layout_posts_probability',
		'std' => '35',
		'type' => 'text'
	),
	array(
		'name' => 'Maximum Widget Width',
		'desc' => 'If widgets are employed, you can specify a maximum width for them. If you would like it to be the default size specify -1. (Note: size is in pixels!)',
		'id' => $shortname.'max_widget_width',
		'std' => '-1',
		'type' => 'text'
	),
	array(
		'name' => 'No Thumbnails?',
		'desc' => 'Don\'t like the thumbnails? Disable them.',
		'id' => $shortname.'no_thumbnails',
		'std' => true,
		'type' => 'checkbox'
	),
	array(
		'name' => 'Retrieve Hosted Images as thumbnails?',
		'desc' => 'If no images are set, should Nanoplex retrieve another (uploaded) image in the post as a thumbnail?',
		'id' => $shortname.'should_get_additional_thumbnails',
		'std' => true,
		'type' => 'checkbox'
	),
	array(
		'name' => 'Retrieve Externally Hosted Images as thumbnails?',
		'desc' => 'If no images are set, should Nanoplex retrieve another image (specified by url) in the post as a thumbnail?',
		'id' => $shortname.'should_get_additional_thumbnails_via_links',
		'std' => true,
		'type' => 'checkbox'
	)
);
		
$nnpl_options = apply_filters('nnpl_options', $nnpl_options);

function nnpl_add_admin() {

    global $themename, $shortname, $nnpl_options, $nnpl_nonce;

	if ( isset($_GET['page']) && $_GET['page'] == basename(__FILE__) && isset($_POST[$nnpl_nonce]) && wp_verify_nonce($_POST[$nnpl_nonce], $nnpl_nonce ) && isset($_REQUEST['action']) ) {

		if ( 'save' == $_REQUEST['action'] ) {
			foreach ( $nnpl_options as $value ) {
				if ( isset( $_REQUEST[ $value['id'] ] ) ) { 
					update_option( $value['id'], $_REQUEST[ $value['id'] ]  );
				} 
				else {
					delete_option( $value['id'] );
				}
			}
			$_REQUEST['saved'] = 1;
		} 
		else if ( 'reset' == $_REQUEST['action'] ) {
			foreach ($nnpl_options as $value) {
				delete_option( $value['id'] );
			}
			$_REQUEST['reset'] = 1;
		}
	}

    add_theme_page($themename.' '.__('Options', 'erudite'), $themename.' '.__('Options', 'erudite'), 'edit_themes', basename(__FILE__), 'nnpl_admin');

}

function nnpl_admin() {

    global $themename, $shortname, $nnpl_options, $nnpl_nonce;

    if ( isset( $_REQUEST['saved'] ) ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' '.__('settings saved.','erudite').'</strong></p></div>';
    if ( isset( $_REQUEST['reset'] ) ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' '.__('settings reset.','erudite').'</strong></p></div>';
    
?>
<div class="wrap">
<?php if ( function_exists('screen_icon') ) screen_icon(); ?>
<h2><?php echo $themename . ' '; _e('Options', 'erudite'); ?></h2>

<form method="post" action="">

<table class="form-table">

<?php foreach ($nnpl_options as $value) { 
	
	switch ( $value['type'] ) {
		case 'text': ?>
		<tr valign="top"> 
		    <th scope="row"><?php echo __($value['name'],'erudite'); ?>:</th>
		    <td>
		        <input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo get_option( $value['id'] ); } else { echo $value['std']; } ?>" />
			    <?php echo __($value['desc'],'erudite'); ?>
		    </td>
		</tr>
		<?php
		break;
		
		case 'select': ?>
		<tr valign="top"> 
	        <th scope="row"><?php echo __($value['name'],'erudite'); ?>:</th>
	        <td>
	            <select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
	                <?php foreach ($value['options'] as $option) { ?>
	                <option<?php if ( get_option( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
	                <?php } ?>
	            </select>
	        </td>
	    </tr>
		<?php
		break;
		
		case 'textarea':
		$ta_options = $value['options']; ?>
		<tr valign="top"> 
	        <th scope="row"><?php echo __($value['name'],'erudite'); ?>:</th>
	        <td>
			    <?php echo __($value['desc'],'erudite'); ?>
				<textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" cols="<?php echo $ta_options['cols']; ?>" rows="<?php echo $ta_options['rows']; ?>"><?php 
				if( get_option($value['id']) != "") {
						echo __(stripslashes(get_option($value['id'])),'erudite');
					}else{
						echo __($value['std'],'erudite');
				}?></textarea>
	        </td>
	    </tr>
		<?php
		break;

		case "radio": ?>
		<tr valign="top"> 
	        <th scope="row"><?php echo __($value['name'],'erudite'); ?>:</th>
	        <td>
	            <?php foreach ($value['options'] as $key=>$option) { 
				$radio_setting = get_option($value['id']);
				if($radio_setting != ''){
		    		if ($key == get_option($value['id']) ) {
						$checked = "checked=\"checked\"";
						} else {
							$checked = "";
						}
				}else{
					if($key == $value['std']){
						$checked = "checked=\"checked\"";
					}else{
						$checked = "";
					}
				}?>
	            <input type="radio" name="<?php echo $value['id']; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> /> <?php echo $option; ?><br />
	            <?php } ?>
	        </td>
	    </tr>
		<?php
		break;
		
		case "checkbox": ?>
			<tr valign="top"> 
		        <th scope="row"><?php echo __($value['name'],'erudite'); ?>:</th>
		        <td>
		           <?php $checked = ( get_option($value['id']) ) ? 'checked="checked"' : ''; ?>
		           <label> <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
			    <?php echo __($value['desc'],'erudite'); ?></label>
		        </td>
		    </tr>
			<?php
		break;

		default:

		break;
	}
}
?>

</table>

<p class="submit">
<input name="save" type="submit" value="<?php _e('Save changes','erudite'); ?>" class="button-primary" />    
<input type="hidden" name="action" value="save" />
<?php wp_nonce_field($nnpl_nonce, $nnpl_nonce, false); ?>
</p>
</form>
<form method="post" action="">
<p class="submit">
<input name="reset" type="submit" value="<?php _e('Reset','erudite'); ?>" />
<input type="hidden" name="action" value="reset" />
<?php wp_nonce_field($nnpl_nonce, $nnpl_nonce, false); ?>
</p>
</form>
</div>

<?php
}

add_action('admin_menu' , 'nnpl_add_admin'); 


?>
