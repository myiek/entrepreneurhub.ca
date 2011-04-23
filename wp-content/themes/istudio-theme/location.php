<?php /* Template Name: Location to */
if(have_posts()){while(have_posts()):the_post();
$locationURL=get_post_meta($post->ID,"LocationURL",$single=true);
header("location:$locationURL");
endwhile;}?>