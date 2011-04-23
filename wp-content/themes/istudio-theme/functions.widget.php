<?php // Widget functions.
class istudio_RCommentsWidget extends WP_Widget{
	function istudio_RCommentsWidget(){
		$widget_ops=array('classname'=>'istudio_RCommentsWidget','description'=>__('This are iStudio\'s recent comments.','iStudio'));
		$this->WP_Widget('istudio_RCommentsWidget',__('iStudio Recent Comments','iStudio'),$widget_ops);
		$this->alt_option_name='istudio_RCommentsWidget';
	}
	function widget($args,$instance){
		extract($args);
		$title=apply_filters('widget_title',empty($instance['title'])?__('Recent Comments','iStudio'):$instance['title']);
		if(!$number=(int)$instance['number'])$number=5;
 		elseif($number<1)$number=1;
		echo $before_widget;
		if($title)echo $before_title.$title.$after_title;
		echo '<ul class="comment">'."\n";
		istudio_rcomments($number);
		echo '</ul>'."\n";
		echo $after_widget;
	}
	function update($new_instance,$old_instance){return $new_instance;}
	function form($instance){
		$title=isset($instance['title'])?esc_attr($instance['title']):'';
		$number=isset($instance['number'])?absint($instance['number']):5;?>
		<p><label for="<?php echo $this->get_field_id('title');?>"><?php _e('Title:','iStudio');?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title');?>" name="<?php echo $this->get_field_name('title');?>" type="text" value="<?php echo $title;?>" /></p>
		<p><label for="<?php echo $this->get_field_id('number');?>"><?php _e('Number of comments to show:','iStudio');?></label>
		<input id="<?php echo $this->get_field_id('number');?>" name="<?php echo $this->get_field_name('number');?>" type="text" value="<?php echo $number;?>" size="2" />
	<?php }
}
add_action('widgets_init',create_function('','return register_widget("istudio_RCommentsWidget");'));
?>