<?php
	// enables wigitized sidebars
	if ( function_exists('register_sidebar') )
	
	$widgetStyle = '';
	if(($widgetStyle = get_option( 'nnpl_max_widget_width' ))!=-1) {
		$widgetStyle = 'style="max-width:' . $widgetStyle . 'px"';
	}else {
		$widgetStyle = '';
	}

	// The Alert Widget
	// Location: displayed on the top of the home page, right after the header, right before the loop, within the contend area
	register_sidebar(array('name'=>'Top',
		'before_widget' => '<div class="widget widget-alert" '. $widgetStyle . ' >',
		'after_widget' => '</div></div>',
		'before_title' => '<div class="post-title">',
		'after_title' => '</div><div class="widget-content">',
	));
	
	// Footer Widget
	// Location: at the top of the footer, above the copyright
	register_sidebar(array('name'=>'Footer',
		'before_widget' => '<div class="widget widget-footer" '. $widgetStyle . ' >',
		'after_widget' => '</div></div>',
		'before_title' => '<div class="post-title">',
		'after_title' => '</div><div class="widget-content">',
	));
	
	// Check for static widgets in widget-ready areas
	function is_sidebar_active( $index ){
	  global $wp_registered_sidebars;
	  $widgetcolums = wp_get_sidebars_widgets();	   
	  if (isset($widgetcolums[$index])&&!empty($widgetcolums[$index])) return true;
	  return false;
	} // end is_sidebar_active
	
	// alternate styles for widgets
	function np_alternate_widget_styles( $params ) {
		global $np_widget_count;
		if(!$np_widget_count) $np_widget_count = 0;
		if($np_widget_count%4>1) $float = 'even';
		else $float = 'odd';
		$params[0]['before_widget'] = preg_replace('/class="widget"/', 'class="widget '.$float.' "', $params[0]['before_widget']);
		$np_widget_count++;
		return $params;
	}
	add_filter('dynamic_sidebar_params', 'np_alternate_widget_styles');
	
	
	// post thumbnail support
	add_theme_support( 'post-thumbnails' );
	add_theme_support('automatic-feed-links');
	set_post_thumbnail_size( 130, 130, true );
	add_image_size( 'single-post-thumbnail', 250, 250 );
	add_image_size( 'home-thumbnail', 130, 130 );
	
	// custom header support
	define('NO_HEADER_TEXT', true );
	define('HEADER_TEXTCOLOR', '');
	define('HEADER_IMAGE', '%s/images/default_header.png'); // %s is the template dir uri
	define('HEADER_IMAGE_WIDTH', 1026); // use width and height appropriate for your theme
	define('HEADER_IMAGE_HEIGHT', 256);
	 	
	// gets included in the site header
	function header_style() {
	    ?><style type="text/css">
	        #headerimg {
	            background: url(<?php header_image(); ?>);
	        }
	    </style><?php
	}
	
	// gets included in the admin header
	function admin_header_style() {
	    ?><style type="text/css">
	        #headimg {
	            width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
	            height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	        }
	    </style><?php
	}
	
	add_custom_image_header('header_style', 'admin_header_style');
	
	// add editor style
	add_theme_support('editor_style');
	add_editor_style('editor-style.css');

	
	// custom menu support
	add_theme_support( 'menus' );
	if ( function_exists( 'register_nav_menus' ) ) {
	  	register_nav_menus(
	  		array(
	  		  'header_menu' => 'Header Menu',
	  		  'footer_menu' => 'Footer Menu'
	  		)
	  	);
	}
	
	// options panel
	include_once('library/theme-options.php');

	
	// custom background support
	add_custom_background('nanoplex_custom_background');
	function nanoplex_custom_background() {
	    $background = get_background_image();
	    $color = get_background_color();
	    if ( ! $background && ! $color )
	        return;
	
	    $style = $color ? "background: #$color;" : '';
	
	    if ( $background ) {
	        $image = " background-image: url('$background');";
	
	        $repeat = get_theme_mod( 'background_repeat', 'repeat' );
	        if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
			$repeat = 'repeat';
			$repeat = " background-repeat: $repeat;";
	
	        $position = get_theme_mod( 'background_position_x', 'left' );
            if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
                    $position = 'left';
            $position = " background-position: top $position;";
            $attachment = get_theme_mod( 'background_attachment', 'scroll' );
            if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
                    $attachment = 'scroll';
            $attachment = " background-attachment: $attachment;";

            $style .= $image . $repeat . $position . $attachment;
	    }
	?>
	<style type="text/css">
	body { <?php echo trim( $style ); ?> }
	</style>
	<?php
	}
	
	// removes detailed login error information for security
	add_filter('login_errors',create_function('$a', "return null;"));
	
	// Removes Trackbacks from the comment cout
	add_filter('get_comments_number', 'comment_count', 0);
	function comment_count( $count ) {
		if ( ! is_admin() ) {
			global $id;
			$comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $id));
			return count($comments_by_type['comment']);
		} else {
			return $count;
		}
	}
	
	// custom excerpt ellipses for 2.9+
	function custom_excerpt_more($more) {
		//return 'Read More &raquo;';
		return ' . . . . . .';
	}
	add_filter('excerpt_more', 'custom_excerpt_more');
	
	// change the length of excerpts
	function new_excerpt_length($length) {
		if (is_sticky()) return 130;
		return 100;
	}
	add_filter('excerpt_length', 'new_excerpt_length');
	
	// no more jumping for read more link
	function no_more_jumping($text) {
		global $post;
		return '<a href="'.get_permalink($post->ID).'" class="read-more">'. $text .'</a>';
	}
	add_filter('excerpt_more', 'no_more_jumping');
	
	// category id in body and post class
	function category_id_class($classes) {
		global $post;
		if($post==null) return $classes; // no posts
		foreach((get_the_category($post->ID)) as $category)
			$classes [] = 'cat-' . $category->cat_ID . '-id';
			return $classes;
	}
	add_filter('post_class', 'category_id_class');
	add_filter('body_class', 'category_id_class');
	
	// check if post is sticky and on front page
	function is_front_sticky() {
		if (is_home()&&!is_paged()&&is_sticky()) {
			return true;
		}
		return false;
	}
	
	// check if post is the top sticky post on home page, count is the number of sticky posts so far :D really no point but whatever
	function is_front_top_sticky($count) {
		if (is_front_sticky()&&$count==1) return true;
		return false;
	}
	

	function nb_get_links() {
		$returnLinks = '<li class="links"><a href="" title="links" class="linktext">Links</a>';
		$arr_links = get_bookmarks(); 
		
		if ($arr_links) {
			$returnLinks = $returnLinks . '<ul class="children linksul">';
			foreach ($arr_links as $link) { 
				$returnLinks = $returnLinks . '<li class="page_item">' . '<a href="'. $link->link_url .'" title="'. $link->link_name .'">'
					. $link->link_name . '</a></li>';
			}
			$returnLinks = $returnLinks . '</ul>';
		}
		return $returnLinks . '</li>';
	}
	function nb_add_links_over_weird_menu($content) {
		//$content = preg_replace('/<a /', '<a class="rightlink" ', $content, 1); //change the first link to have rounded corner
		$content = preg_replace('/<li/', '<li class="menu-links"><a href="" class="menu-links"></a></li><li', $content, 1); //replace the first li, add a new one
		$content = substr_replace($content, nb_get_links() . '<li class="clear"></li>', -1, 0); //insert right before ending </ul>
		return $content;
	}
	function nb_add_links_over_menu($content) {
		//$content = preg_replace('/<a /', '<a class="rightlink" ', $content, 1); //change the first link to have rounded corner
		$content = preg_replace('/<li/', '<li class="menu-links"><a href="" class="menu-links"></a></li><li', $content, 1); //replace the first li, add a new one
		return preg_replace('/<\/ul>/', nb_get_links() . '<li class="clear"></li></ul>', $content, 1);
	}
	add_filter('wp_nav_menu', 'nb_add_links_over_menu');
	add_filter('wp_list_pages', 'nb_add_links_over_weird_menu');
	
	// add authors class to authors post link
	function nb_add_author_class($link) {
		return preg_replace('/<a/', '<a class="author"', $link, 1);
	}
	add_filter('the_author_posts_link', 'nb_add_author_class');
	
	// checks if the post has an image
	function nb_has_post_image($image_size, $post_content) {
		global $post;
				
		if (get_option( 'nnpl_should_get_additional_thumbnails' ) == 'true') {
			$addthumb = true;
		}
		else {
			$addthumb = false;
		}
		if (get_option( 'nnpl_should_get_additional_thumbnails_via_links' ) == 'true') {
			$addthumblinks = true;
		}
		else {
			$addthumblinks = false;
		}
		
		//true false = default set... yes no = user set.
		
		if ($addthumb==true) {
			$args = array( 'post_type' => 'attachment', 'posts_per_page' => -1, 'post_status' => null, 'post_parent' => $post->ID ); 
			$attachments = get_posts($args);
			if ($attachments) {
				$first = count($attachments);
				return nb_the_post_image($attachments[$first-1], $image_size); //for some reason $attachments is ordered from last image to first image in post
			}
		}
		
		if ($addthumblinks ==true) {
			// if it gets here, that means the post doesn't have an attachment
			
			include_once('includes/simple_html_dom.php');
	
			// Create DOM from string, find img tags, and check!
			$nb_html = str_get_html($post_content);	
			$img = $nb_html->find('img', 0);
			
			if ($img) {
				$site_address = preg_replace('/\//', '\/', get_option('siteurl', 'unknown'));
				//if (!preg_match('/' . $site_address . '/', $img->src))
					return '<div class="thumbnail-cropper">' . $img . '</div>';
			}
		}
		
		// if it gets here, the post probably doesn't have a usable image
		return '';
	}

	
	// returns a thumbnail from an image in post content
	function nb_the_post_image($attachment, $image_size) {
		$img = wp_get_attachment_image($attachment->ID, $image_size);
		return $img;
	}
	
	// checks if the passed in string is a link, and if so, adds an <img /> tag around it. Else it already has an img tag and do nothing
	function nb_add_img_stuff($nb_img) {
		//echo '<p>' . $nb_img . 'HIIIII</p>';
		if($nb_img) {
			if(preg_match('/<img /', $nb_img)) return $nb_img;
			else return '<img src="' . $nb_img . '" alt="' . $nb_img . '" />';
		}
		else return '';
	}
	
	// returns whether to display the freak arm for featured posts or not
	function nb_display_arm() {
		global $post;
		if(get_post_meta($post->ID, '_np_display_arm', true)=='yes') return true;
		return false;
	}
	
	// limit the size of the title
	function nb_limit_title_size($title) {
		if( is_home()) {
			global $post;
			
			$title_length = 34;
			if( get_post_meta( $post->ID, '_np_is_image_post', true ) == 'yes') {
				$successful = false;
				// is an image post
				if( $stored_values = get_post_meta( $post->ID, '_np_image_sizes', true ) ) {
					$stored_values = explode(" ", $stored_values); // $stored_values is converted to array of values
					if( count($stored_values) == 4 ) {
						//get the values
						list($h1, $w1, $h2, $w2) = $stored_values;
						$title_length = (int)($w2/19);
						$successful = true;
					}
				}
				if (!$successful) $title_length = 16;
			}
			if (strlen($title) > $title_length) {
				$title = substr($title, 0, $title_length-1) . '...';
			}
		}
		return $title;
	}
	add_filter('the_title', 'nb_limit_title_size');
	
	// retrieve thumbnail
	function nb_retrieve_thumbnail($content) {
		global $post;
		
		
		if (get_option( 'nnpl_no_thumbnails' ) == 'true') { // user disabled thumbnails
			if (!get_post_meta($post->ID, '_np_thumbnail', true) == 'yes') { //the post isn't explicitly set to ovveride and get a thumbnail
				echo '">';
				return;
			}
		} else { // thumbnails wanted!
			if (get_post_meta($post->ID, '_np_thumbnail', true) == 'yes') { //the post doesn't want a thumbnail..
				echo '">';
				return;
			}
		}
		if ( has_post_thumbnail() ) { 
			echo ' has-thumbnail"><!-- loades the post\'s featured thumbnail, requires Wordpress 3.0+ -->';
			echo '<div class="featured-thumbnail">'; 
			the_post_thumbnail('thumbnail'); 
			echo '</div>'; 
		} else if ( $attachment = nb_has_post_image('thumbnail', $content) ){
			echo ' has-thumbnail"><!-- loades the post\'s featured thumbnail, requires Wordpress 3.0+ -->';
			echo '<div class="featured-thumbnail">'; 
			//nb_the_post_image($attachment, 'thumbnail'); 
			echo $attachment;
			echo '</div>'; 
		} else {
			echo '">';
		}
	}
	
	// custom fields
	include_once('library/custom-fields.php');
	
	// Nanoplex COmments
	function nanoplex_comments($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		global $i; // see comments.php
		if($depth == 1)
				$i++; 
		$not_approved = false;
		$extracommentclass = '';
		?><li class="comment-replies <?php if($i%2>0) echo ' comment-replies-left'; else echo ' comment-replies-right'; if($depth==1) echo ' top-level';?>"><?php
		
		switch ( $comment->comment_type ) :
			case 'comment':
			case '' :
		?>
		<?php if ($comment->comment_approved == '0') {$extracommentclass = 'awaiting-approval '; $not_approved = true;} ?>
		<div id="comment-<?php comment_ID(); ?>" <?php comment_class($extracommentclass); ?>>
			<div class="comment-num-div"><?php if($depth==1)echo '<p class="comment-num">' . $i; else echo '<p class="comment-rep comment-num">~'; ?></p></div>
			<div class="comment-meta">
		    	<div class="comment-edit-link-div"><?php edit_comment_link('Edit', '', '');  ?></div>
		        <?php if ($not_approved) : ?> <!-- if comment is awaiting approval -->
		            <div class="comment-info">Your comment is awaiting approval.</div>
		        <?php else: ?>
		            <div class="comment-info" >by <?php comment_author_link(); ?> | <?php comment_date('m-d'); ?> | <?php comment_time(); ?></div>
		        <?php endif; ?>
		        <p class="gravatar"><?php if(function_exists('get_avatar')) { echo get_avatar($comment, '36'); } ?></p>	
				<div class="reply comment-edit-link-div">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div><!-- .reply -->
			</div><!-- commentMeta-->
			<div class="comment-text comment-text-css">
	            <?php comment_text(); ?>
            </div><!--.commentText--></div><!-- comment -->
	
		<?php
			if($i%2==0) { 
				echo '<div class="comment-height-giver"></div>'; 
				echo '<div class="clear"></div>';
			}
		?><?php
			// wordpress automatically adds the ending /li	
				break;
			case 'pingback'  :
			case 'trackback' :
		?>
		<li class="comment-replies post_pingback <?php if($i%2>0) echo ' comment-replies-left'; else echo ' comment-replies-right'; if($depth==1) echo ' top-level';?>"><div class="comment <?php if($i%2>0) { echo '  odd ';} else {echo ' even ';} ?>">
		<div class="comment-num-div"><?php if($depth==1)echo '<p class="comment-num">' . $i; else echo '<p class="comment-rep comment-num">~'; ?></p></div>
			<div class="comment-meta">
				<div class="comment-edit-link-div"><?php edit_comment_link('Edit', '', '');  ?></div>
		        <div class="comment-info" >Pingback | <?php comment_date('m-d'); ?> | <?php comment_time(); ?></div>
		        <p class="gravatar"><?php if(function_exists('get_avatar')) { echo get_avatar($comment, '36'); } ?></p>	
			</div><!-- commentMeta-->
			<div class="comment-text comment-text-css">
	            <p><?php echo 'Pingback: '; ?> <?php comment_author_link(); ?></p>
            </div><!--.commentText--></div><!-- comment -->
			
		<?php
			if($i%2==0) { 
				echo '<div class="comment-height-giver"></div>'; 
				echo '<div class="clear"></div>';
			}
			break;
		endswitch;
   }
	   
	function nano_fields($fields) {
		$commenter = wp_get_current_commenter();
	
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$fields =  array(
			'author' => '<div class="comment-form-author">' . '<label for="author">' . __( 'Name' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
			            '<div class="input-container"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div></div>',
			'email'  => '<div class="comment-form-email"><label for="email">' . __( 'Email' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
			            '<div class="input-container"><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div></div>',
			'url'    => '<div class="comment-form-url"><label for="url">' . __( 'Website' ) . '</label>' .
			            '<div class="input-container"><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div></div>',
		);
		return $fields;
	}
	add_filter('comment_form_default_fields','nano_fields');

?>