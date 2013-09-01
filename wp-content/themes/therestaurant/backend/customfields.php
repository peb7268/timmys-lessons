<?php
if ( !class_exists('myCustomFields') ) {
	class myCustomFields {
		/**
		* @var  string  $prefix  The prefix for storing custom fields in the postmeta table
		*/
		var $prefix = '';
		/**
		* @var  array  $customFields  Defines the custom fields available
		*/
		var $customFields =	array(
			array(
				"name"			=> "price",
				"title"			=> "Menu card price",
				"description"	=> "The price for this item. This will show up on the menu card page",
				"type"			=>	"text",
				"scope"			=>	array( "post" ),
				"capability"	=> "edit_posts"
			),
			array(
				"name"			=> "postlink",
				"title"			=> "Link title to full post",
				"description"	=> "Check this if you want to link the item title on the menu card to the full post",
				"type"			=>	"checkbox",
				"scope"			=>	array( "post" ),
				"capability"	=> "edit_posts"
			),
			array(
				"name"			=> "description",
				"title"			=> "Description of the menu card item",
				"description"	=> "The description for this item. This will show up on the menu card page",
				"type"			=>	"textarea",
				"scope"			=>	array( "post" ),
				"capability"	=> "edit_posts"
			),
			array(
				"name"			=> "sidebar",
				"title"			=> "Use a custom sidebar",
				"description"	=> "Use a custom sidebar for this page",
				"type"			=>	"sidebar",
				"scope"			=>	array( "page" ),
				"capability"	=> "edit_page"
			),
			array(
				"name"			=> "sidebarpos",
				"title"			=> "Position of the sidebar",
				"description"	=> "The page specific position of the sidebar",
				"options"		=> "Global setting (in theme settings),Left,Right,Hidden",
				"type"			=>	"dropdown",
				"scope"			=>	array( "page" ),
				"capability"	=> "edit_page"
			),
			array(
				"name"			=> "sliderheight",
				"title"			=> "Slider height",
				"description"	=> "The height of the slider on this page (in pixels)",
				"type"			=>	"text",
				"scope"			=>	array( "page" ),
				"capability"	=> "edit_page"
			),
			array(
				"name"			=> "imageheight",
				"title"			=> "Featured image height for the blog and gallery page template",
				"description"	=> "The height of the featured image (in pixels). The image will automaticly be vertically centered. Leave empty to show full image (default).",
				"type"			=>	"text",
				"scope"			=>	array( "page" ),
				"capability"	=> "edit_page"
			),
			array(
				"name"			=> "categories",
				"title"			=> "Page categories for the Menu Card, Gallery or Blog page template",
				"description"	=> "The categories to use for the Menu Card, Gallery or Blog page. Please don't use the same categories on multiple pages. Drag & drop the items to change the order!",
				"type"			=>	"categories",
				"scope"			=>	array( "page" ),
				"capability"	=> "edit_page"
			),
			array(
				"name"			=> "number",
				"title"			=> "Number of items per page",
				"description"	=> "The number of items to show on one page (for the blog and gallery page-template). The rest of the items can be viewed via the pagination.",
				"type"			=>	"text",
				"scope"			=>	array( "page" ),
				"capability"	=> "edit_page"
			),
			array(
				"name"			=> "slidelink",
				"title"			=> "Slide link",
				"description"	=> "The link this slide should link to (optional)",
				"type"			=>	"text",
				"scope"			=>	array( "slide" ),
				"capability"	=> "edit_post"
			),
			array(
				"name"			=> "newwindow",
				"title"			=> "Open link in new window",
				"description"	=> "Open the link in a new window rather then in the current one",
				"type"			=>	"checkbox",
				"scope"			=>	array( "slide" ),
				"capability"	=> "edit_post"
			),
			array(
				"name"			=> "hidetitle",
				"title"			=> "Hide the title",
				"description"	=> "This will hide the title in the slide, showing only the image",
				"type"			=>	"checkbox",
				"scope"			=>	array( "slide" ),
				"capability"	=> "edit_post"
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
			add_action( 'admin_menu', array( &$this, 'createCustomFields' ) );
			add_action( 'save_post', array( &$this, 'saveCustomFields' ), 1, 2 );
			// Comment this line out if you want to keep default custom fields meta box
			add_action( 'do_meta_boxes', array( &$this, 'removeDefaultCustomFields' ), 10, 3 );
		}
		/**
		* Remove the default Custom Fields meta box
		*/
		function removeDefaultCustomFields( $type, $context, $post ) {
			foreach ( array( 'normal', 'advanced', 'side' ) as $context ) {
				//remove_meta_box( 'postcustom', 'post', $context );
				//remove_meta_box( 'postcustom', 'page', $context );
				//Use the line below instead of the line above for WP versions older than 2.9.1
				remove_meta_box( 'pagecustomdiv', 'page', $context );
			}
		}
		/**
		* Create the new Custom Fields meta box
		*/
		function createCustomFields() {
			if ( function_exists( 'add_meta_box' ) ) {
				add_meta_box( 'my-custom-fields', 'Additional Settings', array( &$this, 'displayCustomFields' ), 'page', 'normal', 'high' );
				add_meta_box( 'my-custom-fields', 'Additional Settings', array( &$this, 'displayCustomFields' ), 'post', 'normal', 'high' );
				add_meta_box( 'my-custom-fields', 'Additional Settings', array( &$this, 'displayCustomFields' ), 'slide', 'normal', 'high' );
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
							case "post": {
								// Output on any post screen
								if ( $post->post_type=="post" )
									$output = true;
								break;
							}
							case "page": {
								// Output on any page screen
								if ( $post->post_type=="page" )
									$output = true;
								break;
							}
							case "slide": {
								// Output on any slide screen
								if ($post->post_type=="slide" )
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
									if ( get_post_meta( $post->ID, $this->prefix . $customField['name'], true ) == "yes" )
										echo ' checked="checked"';
									echo '" style="width: auto;" />';
									break;
								}
								case "textarea": {
									// Text area
									echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
									echo '<textarea name="' . $this->prefix . $customField[ 'name' ] . '" id="' . $this->prefix . $customField[ 'name' ] . '" columns="30" rows="3">' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '</textarea>';
									break;
								}
								case "upload": {
									// Upload field
									echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
									echo '<input type="text" name="' . $this->prefix . $customField[ 'name' ] . '" class="upload_field" id="' . $this->prefix . $customField[ 'name' ] . '" value="' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '" />';
									echo '<div><input class="upload_button" style="width:auto;" type="button" value="Browse" /></div>';
									break;
								}
								case "categories": {
									// Category list
                                    echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
									echo '<div class="sortable-list" style="overflow:auto;width:280px;height:200px;border: 1px solid #DFDFDF;display:inline-block;">';
									$category_array = get_post_meta( $post->ID, $this->prefix . $customField['name'], true );
									$temp_array = explode(',',$category_array);
									foreach ($temp_array as $catid) {
										if ($catid) {
											//$child_cats = get_categories('child_of='.$catid);
											echo '<div class="sortable">';
											echo '<input type="checkbox" checked name="' . $this->prefix . $customField['name'] . '[]" id="' . $this->prefix . $customField['name'] . '" value="' . $catid .'" />' . get_cat_name($catid);
											if ($child_cats) {
												echo '<div class="child-cats">';
												foreach ($child_cats as $child_cat) {
													echo '<div class="sortable">';
													echo '<input type="checkbox" checked name="' . $this->prefix . $customField['name'] . '[]" id="' . $this->prefix . $customField['name'] . '" value="child-' . $child_cat->term_id .'" />' . get_cat_name($child_cat->term_id) . '<br />';
													echo '</div>';
												}
												echo '</div>';
											}
											echo '</div>';
										}
									}
									$categories = get_categories('order_by=name&order=asc&hide_empty=0');
									foreach ($categories as $cat) {
										if ($cat->category_parent == 0 && !in_array($cat->term_id, $temp_array)) {
											echo '<div class="sortable">';
											echo '<input type="checkbox" name="' . $this->prefix . $customField['name'] . '[]" id="' . $this->prefix . $customField['name'] . '" value="' . $cat->term_id .'" />' . $cat->name;
											echo '</div>';
										}
									}
									echo '</div>';
									break;
								}
								case "dropdown": {
									// Dropdown field
									echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
									echo '<select name="' . $this->prefix . $customField[ 'name' ] .'" id="' . $this->prefix . $customField[ 'name' ] .'">';
									$options = explode(',',$customField['options']);
									foreach ($options as $option) {
										$selected = '';
										if (get_post_meta($post->ID, $this->prefix.$customField['name'], true) == $option) {
											$selected = 'selected="selected"';
										}
										echo '<option '.$selected.' value="'.$option.'">'.$option.'</option>';
									}
									echo '</select>';
									break;
								}
								case "sidebar": {
									// Dropdown field
									echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
									echo '<select name="' . $this->prefix . $customField[ 'name' ] .'" id="' . $this->prefix . $customField[ 'name' ] .'">';
									echo '<option value="sidebar">Sidebar</option>';
									
									$theme_options = get_option('therestaurant');
									if ($theme_options['cp_sidebar_name[]']) {
										foreach ($theme_options['cp_sidebar_name[]'] as $i=>$value) {
											if ($value) {
												$selected = '';
												$option = $theme_options['cp_sidebar_name[]'][$i];
												if (get_post_meta($post->ID, $this->prefix.$customField['name'], true) == $option) {
													$selected = 'selected="selected"';
												}
												echo '<option '.$selected.' value="'.$option.'">'.$option.'</option>';
											}
										}
									}
									echo '</select>';
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
			if ( !wp_verify_nonce( $_POST[ 'my-custom-fields_wpnonce' ], 'my-custom-fields' ) )
				return;
			if ( !current_user_can( 'edit_post', $post_id ) )
				return;
			if ( $post->post_type != 'page' && $post->post_type != 'post' && $post->post_type != 'slide' )
				return;
			foreach ( $this->customFields as $customField ) {
				if ( current_user_can( $customField['capability'], $post_id ) ) {
					if ( isset( $_POST[ $this->prefix . $customField['name'] ] ) && trim((is_array($_POST[$this->prefix.$customField['name']]) ? implode(",",$_POST[$this->prefix.$customField['name']]) : $_POST[$this->prefix.$customField['name']]))) {
						update_post_meta( $post_id, $this->prefix . $customField[ 'name' ], (is_array($_POST[$this->prefix.$customField['name']]) ? implode(",",$_POST[$this->prefix.$customField['name']]) : $_POST[$this->prefix.$customField['name']]) );
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
?>