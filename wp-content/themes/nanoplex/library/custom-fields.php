<?php
/*
* CUSTOM CUSTOM FIELDS :D 
* credits to http://sltaylor.co.uk/blog/control-your-own-wordpress-custom-fields/, 
* with some modifications
*/

if( function_exists('slt_cf_register_box')) {
	slt_cf_setting( 'prefix', '_np_' );
	slt_cf_setting( 'hide_default_custom_meta_box', false );
	
	slt_cf_register_box(array(  
			'type'=> array( "post" ),  
		    'id' => 'postsets',  
		    'title'     => 'Main Post Settings',  
		    'context'   => 'normal',  
		    'priority'  => 'high',  
		    'fields'        => array(
		        array(  
		            'name'          => 'is_image_post',  
		            'label'         => 'Is this an Image Post?',  
		            'description'   => 'Whether or not this post should be displayed in a special image format on the front page.<br/><font color=\"#D41717\">NOTE: Needs at least two images to work.</font>',  
		            'type'          => 'checkbox',
		            'scope'         => array( 'post' ),  
		            'capabilities'  => array( 'edit_posts' )
		        )
		    )
		)
	);
	$thumblabel = 'Disable thumbnail';
	$thumbdescrp = 'Check if you don\'t want thumbnail abilities for your post.';
	if (get_option( 'nnpl_no_thumbnails' ) == 'true') {
		$thumblabel = 'Enable thumbnail';
		$thumbdescrp = 'Check if you want thumbnail abilities for your post.';
	}
	slt_cf_register_box(array(  
			'type'=> array( "post" ),  
		    'id' => 'thumbsets',  
		    'title'     => 'Thumbnail Settings',  
		    'context'   => 'normal',  
		    'priority'  => 'high',  
		    'fields'        => array(
		        array(  
		            'name'          => 'thumbnail',  
		            'label'         => $thumblabel,  
		            'description'   => $thumbdescrp,  
		            'type'          => 'checkbox',
		            'scope'         => array( 'post' ),  
		            'capabilities'  => array( 'edit_posts' )//,
		            //'default' => 'no'
		        )/*,
		        array(  
		            'name'          => 'url_image_positioning',  
		            'label'         => 'Position a URL-retrieved thumbnail (See previous option)',  
		            'description'   => 'Set how you want the url-retrieved thumbnail to clip <font color=\"#D41717\">(NOTE: only if the above setting is applied)</font>',  
		            'type'          => 'checkbox',
		            'scope'         => array( 'post' ),  
		            'capabilities'  => array( 'edit_posts' )
		        )*/
		    )
		)
	);
	slt_cf_register_box(array(  
			'type'=> array( "post", "page" ),  
		    'id' => 'img2sets',  
		    'title'     => 'Secondary Featured Image Settings',  
		    'context'   => 'normal',  
		    'priority'  => 'high',  
		    'fields'        => array(
		        array(  
		            'name'          => 'second-image',  
		            'label'         => 'Special Image',  
		            'description'   => "An additional, special image used to beautify the first sticky post, like a second featured image. Paste an image link in here (for example, upload under 'Media' and copy the direct link here), or write an image tag.<br/>Feel free to include CSS to position the image to your taste.<br/><font color=\"#509FB3\">For Example: &lt;img style=\"right:40px\" src=\"http://gardening.savvy-cafe.com/wp-content/uploads/2007/09/orchid-white-bg-rs.jpg\" alt=\"example\"/&gt;</font>",  
		            'type'          => 'textarea',  
		            'scope'         => array( 'post', 'page' ),  
		            'capabilities'  => array( 'edit_pages', 'edit_posts' ),
		            'allowtags' => array( 'img' ),
		            'default' => ''  
		        ),
		        array(  
		            'name'          => 'display_arm',  
		            'label'         => 'The Arm',  
		            'description'   => 'Should this post have an "arm" if it is the first sticky post? Don\'t understand? Try it out and see. It displays the second image if there is one.<br/><font color=\"#D41717\">NOTE: Only applies to sticky posts, and the first sticky post at that.</font>',  
		            'type'          => 'checkbox',
		            'scope'         => array( 'post' ),  
		            'capabilities'  => array( 'edit_posts' ),
		            'default' => 'no'
		        ) 
		    )
		)
	);
}
else {
	
	if ( !class_exists('myCustomFields') ) {
	
		class myCustomFields {
			/**
			* @var  string  $prefix  The prefix for storing custom fields in the postmeta table
			*/
			var $prefix = '_np_';
			/**
			* @var  array  $postTypes  An array of public custom post types, plus the standard "post" and "page" - add the custom types you want to include here
			*/
			var $postTypes = array( "page", "post" );
			/**
			* @var  array  $customFields  Defines the custom fields available
			*/
			var $thumblabel = 'Disable thumbnail';
			var $thumbdescrp = 'Check if you don\'t want thumbnail abilities for your post.';
			
			var $customFields =	array(
				array(  
		            'name'          => 'is_image_post',  
		            'title'         => 'Is this an Image Post?',  
		            'description'   => 'Whether or not this post should be displayed in a special image format on the front page.<br/><font color=\"#D41717\">NOTE: Needs at least two images to work.</font>',  
		            'type'          => 'checkbox',
		            'scope'         => array( 'post' ),  
		            'capability'  => 'edit_posts'
		        ), 
		        array(  
		            'name'          => 'thumbnail',  
		            'title'         => 'Disable thumbnail',  
		            'description'   => 'Check if you don\'t want thumbnail abilities for your post.',  
		            'type'          => 'checkbox',
		            'scope'         => array( 'post' ),  
		            'capability'  => 'edit_posts'
		            //'default' => 'no'
		        )/*,
		        array(  
		            'name'          => 'url_image_positioning',  
		            'title'         => 'Position a URL-retrieved thumbnail (See previous option)',  
		            'description'   => 'Set how you want the url-retrieved thumbnail to clip <font color=\"#D41717\">(NOTE: only if the above setting is applied)</font>',  
		            'type'          => 'checkbox',
		            'scope'         => array( 'post' ),  
		            'capability'  => 'edit_posts'
		        )*/,

				array(
					"name"			=> "second-image",
					"title"			=> "Special Image",
					"description"	=> "An additional, special image used to beautify the first sticky post, like a second featured image. Paste an image link in here (for example, upload under 'Media' and copy the direct link here), or paste an img tag.<br/>Feel free to include CSS to position the image to your taste.<br/><font color=\"#509FB3\">For Example: &lt;img style=\"right:40px\" src=\"http://gardening.savvy-cafe.com/wp-content/uploads/2007/09/orchid-white-bg-rs.jpg\" alt=\"example\"/&gt;</font>",
					"type"			=> "chooseimage",
					"scope"			=>	array( "post", "page" ),
					"capability"	=> "edit_pages"
				),
				array(  
		            'name'          => 'display_arm',  
		            'title'         => 'The Arm',  
		            'description'   => 'Should this post have an "arm" if it is the first sticky post? Don\'t understand? Try it out and see. It displays the second image if there is one.<br/><font color=\"#D41717\">NOTE: Only applies to sticky posts, and the first sticky post at that.</font>',  
		            'type'          => 'checkbox',
		            'scope'         => array( 'post' ),  
		            'capability'  => 'edit_posts'
		        )
			);
			/**
			* PHP 4 Compatible Constructor
			*/
			function myCustomFields() { $this->__construct(); }
			/**
			* PHP 5 Constructor
			*/
			function __construct() {
				if (get_option( 'nnpl_no_thumbnails' ) == 'true') {
					$thumblabel = 'Enable thumbnail';
					$thumbdescrp = 'Check if you want thumbnail abilities for your post.';
				}
				add_action( 'admin_menu', array( &$this, 'createCustomFields' ) );
				add_action( 'save_post', array( &$this, 'saveCustomFields' ), 1, 2 );
				// Comment this line out if you want to keep default custom fields meta box
				//add_action( 'do_meta_boxes', array( &$this, 'removeDefaultCustomFields' ), 10, 3 );
				
			}
			/**
			* Remove the default Custom Fields meta box
			*/
			function removeDefaultCustomFields( $type, $context, $post ) {
				foreach ( array( 'normal', 'advanced', 'side' ) as $context ) {
					foreach ( $this->postTypes as $postType ) {
						remove_meta_box( 'postcustom', $postType, $context );
					}
				}
			}
			/**
			* Create the new Custom Fields meta box
			*/
			function createCustomFields() {
				if ( function_exists( 'add_meta_box' ) ) {
					foreach ( $this->postTypes as $postType ) {
						add_meta_box( 'my-custom-fields', 'Cool Settings', array( &$this, 'displayCustomFields' ), $postType, 'normal', 'high' );
					}
				}
			}
			/**
			* Display the new Custom Fields meta box
			*/
			function displayCustomFields() {
				global $post;
				?>
				<div class="form-wrap">
					<?php
					wp_nonce_field( 'my-custom-fields', 'my-custom-fields_wpnonce', false, true );
					foreach ( $this->customFields as $customField ) {
						// Check scope
						$scope = $customField[ 'scope' ];
						$output = false;
						foreach ( $scope as $scopeItem ) {
							switch ( $scopeItem ) {
								default: {
									if ( $post->post_type == $scopeItem )
										$output = true;
									break;
								}
							}
							if ( $output ) break;
						}
						// Check capability
						if ( !current_user_can( $customField['capability'], $post->ID ) )
							$output = false;
						// Output if allowed
						if ( $output ) { ?>
							<div class="form-field form-required">
								<?php
								switch ( $customField[ 'type' ] ) {
									case "checkbox": {
										// Checkbox
										echo '<label for="' . $this->prefix . $customField[ 'name' ] .'" style="display:inline;"><b>' . $customField[ 'title' ] . '</b></label>&nbsp;&nbsp;';
										echo '<input type="checkbox" name="' . $this->prefix . $customField['name'] . '" id="' . $this->prefix . $customField['name'] . '" value="yes"';
										if ( ($temp = get_post_meta( $post->ID, $this->prefix . $customField['name'], true ) == "yes")||$temp == "true" )
											echo ' checked="checked"';
										echo '" style="width: auto;" />';
										break;
									}
									case "chooseimage":
									case "textarea":
									case "wysiwyg": {
										// Text area
										echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
										echo '<textarea name="' . $this->prefix . $customField[ 'name' ] . '" id="' . $this->prefix . $customField[ 'name' ] . '" columns="30" rows="3">' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '</textarea>';
										// WYSIWYG
										if ( $customField[ 'type' ] == "wysiwyg" ) { ?>
											<script type="text/javascript">
												jQuery( document ).ready( function() {
													jQuery( "<?php echo $this->prefix . $customField[ 'name' ]; ?>" ).addClass( "mceEditor" );
													if ( typeof( tinyMCE ) == "object" && typeof( tinyMCE.execCommand ) == "function" ) {
														tinyMCE.execCommand( "mceAddControl", false, "<?php echo $this->prefix . $customField[ 'name' ]; ?>" );
													}
												});
											</script>
										<?php }
										break;
									}
									default: {
										// Plain text field
										echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
										echo '<input type="text" name="' . $this->prefix . $customField[ 'name' ] . '" id="' . $this->prefix . $customField[ 'name' ] . '" value="' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '" />';
										break;
									}
								}
								?>
								<?php if ( $customField[ 'description' ] ) echo '<p>' . $customField[ 'description' ] . '</p>'; ?>
							</div>
						<?php
						}
					} ?>
				</div>
				<?php
			}
			/**
			* Save the new Custom Fields values
			*/
			function saveCustomFields( $post_id, $post ) {
				if ( !isset( $_POST[ 'my-custom-fields_wpnonce' ] ) || !wp_verify_nonce( $_POST[ 'my-custom-fields_wpnonce' ], 'my-custom-fields' ) )
					return;
				if ( !current_user_can( 'edit_post', $post_id ) )
					return;
				if ( ! in_array( $post->post_type, $this->postTypes ) )
					return;
				foreach ( $this->customFields as $customField ) {
					if ( current_user_can( $customField['capability'], $post_id ) ) {
						if ( isset( $_POST[ $this->prefix . $customField['name'] ] ) && trim( $_POST[ $this->prefix . $customField['name'] ] ) ) {
							$value = $_POST[ $this->prefix . $customField['name'] ];
							// Auto-paragraphs for any WYSIWYG
							if ( $customField['type'] == "wysiwyg" ) $value = wpautop( $value );
							update_post_meta( $post_id, $this->prefix . $customField[ 'name' ], $value );
						} else {
							delete_post_meta( $post_id, $this->prefix . $customField[ 'name' ] );
						}
					}
				}
			}
	
		} // End Class
	
	} // End if class exists statement
	
	// Instantiate the class
	if ( class_exists('myCustomFields') ) {
		$myCustomFields_var = new myCustomFields();
	}
}?>