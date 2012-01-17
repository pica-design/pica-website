<?php

	/* Wordpress Hook / Function Overrides */
	remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
	remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
	remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
	remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
	remove_action( 'wp_head', 'index_rel_link' ); // index link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); // Display relational links for the posts adjacent to the current post.
	remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version
	remove_action( 'wp_head', 'rel_canonical'); //Remove the wp canonical url
	add_filter( 'next_post_rel_link', 'disable_stuff' );
	function disable_stuff( $data ) { return false; }
	
	/* Pica Theme Setup Action */
	add_action( 'init', 'pica_theme_setup' );
		
		//Adding thumbnail images into Posts
		add_theme_support( 'post-thumbnails', array('post', 'page', 'work'));
		//Set our post thumbnail image dimensions
		set_post_thumbnail_size( 360, 244, true ); // Normal post thumbnails
		//Add our extra-large image size for media uploads
		add_image_size( 'extra-large', 1250, 500, true ); 
		add_image_size( 'blogroll', 355, 125, true);
		add_image_size( 'portfolio', 1130, 650, true);
		
		
		
		
		
		function custom_excerpt_length( $length ) {
			return 15;
		}
		add_filter( 'excerpt_length', 'custom_excerpt_length', 30 );
		
		function pica_theme_setup() {
			// This theme styles the visual editor with editor-style.css to match the theme style.
			add_editor_style();		
			// This theme uses wp_nav_menu() in one location.
			register_nav_menu( 'primary', __( 'Primary Menu', 'pica' ) );
			//Create the 'Work' post type
			register_post_type( 'work',
				array(
					'labels' => array(
						'name' => __( 'Work' ),
						'singular_name' => __( 'Work Item' ),
						'add_new_item' => 'Add New Work Item',
						'edit_item' => 'Edit Work Items',
						'new_item' => 'New Work Item',
						'search_items' => 'Search Work Items',
						'not_found' => 'No Work Items found',
						'not_found_in_trash' => 'No Work Items found in trash',
				   ),
					'public' => true,
					'hierarchical' => true,
					'supports' => array('title','editor','thumbnail','gallery')
				)	
			);
						
			//Create the 'Type' taxonomy for the 'Work' post type
			register_taxonomy('type', 'work',
				array(
					'hierarchical' => true,
					'label' => 'Work Categories',	// the human-readable taxonomy name
					'query_var' => true,	// enable taxonomy-specific querying
					'rewrite' => array( 'slug' => 'work-categories'),	// pretty permalinks for your taxonomy?
				)
			);
			
			//Create a new column 'Type' on the admin 'Work' page to display the types of each work item
			add_filter('manage_edit-work_columns', 'manage_work_admin_columns');
			//Populate the contents of the new columns we just created
			add_action('manage_work_posts_custom_column', 'manage_work_admin_columns_content');
			//Tell WordPress those new columns can be sortable within the admin
			add_filter('manage_edit-work_sortable_columns', 'work_type_column_register_sortable' );
		}
		
		//The following function is triggered when the admin views the list of 'Location' posts 
		//We want to tap in and add a column for the location ID and a column for the location region taxonomy term
		function manage_work_admin_columns ($columns) {
			$new_columns['cb'] = '<input type="checkbox" />';
			$new_columns['title'] = _x('Work Name', 'column name');
			$new_columns['type'] = __('Type');
			$new_columns['author'] = __('Author');
			$new_columns['date'] = _x('Date', 'column name');
			return $new_columns;
		}
		// Register the new 'Location' columns as sortable
		function work_type_column_register_sortable( $columns ) {
			$columns['type'] = 'type';
			return $columns;
		}
		//Create the contents of our new 'Location' columns
		function manage_work_admin_columns_content ($column) {
			global $post;
			switch ($column) :
				case 'type':
					$terms = get_the_terms( $post->ID, 'type');
					if ($terms) :
						$count = 0;
						foreach ($terms as $term) :
							echo '<a href="'.get_bloginfo('url').'/wp-admin/edit-tags.php?action=edit&taxonomy=type&post_type=work&tag_ID='.$term->term_id.'">'.$term->name.'</a>';
							if ($count != (count($terms) - 1)) :
								echo ", ";
							endif;
							$count++;
						endforeach;
					endif;
				break;
			endswitch;
		}
		
	
	//Display a custom meta box on the cpt 'Portfolio' posts 
	if (is_admin()) {
		add_action ('load-post.php', 'add_page_meta_gallery_selection');
	}
		//Add a nextgen gallery selection meta box to pages
		function add_page_meta_gallery_selection () {
			return new gallery_selection ();
		}
			//Class controller for adding a ngg gallery selection meta box to pages
			class gallery_selection {
				//Initilize our meta box class
				public function __construct () {
					add_action('add_meta_boxes', array(&$this, 'add_meta_boxes'));
					add_action('save_post', array(&$this, 'save_meta_box_data'));
				}
				//Add the meta box
				public function add_meta_boxes () {
					add_meta_box(
						'Gallery Picker',
						__( 'Attach a Gallery'),
						array( &$this, 'render_gallery_meta_box_content'),
						'work',
						'side',
						'default'
					);
					add_meta_box(
						'Text Color',
						__( 'Text Color'),
						array( &$this, 'render_work_text_color_choice'),
						'work',
						'side',
						'default'
					);
					add_meta_box(
						'Background Color',
						__( 'Background Color'),
						array( &$this, 'render_work_bg_color_choice'),
						'work',
						'side',
						'default'
					);
					add_meta_box(
						'Gallery Picker',
						__( 'Attach a Gallery'),
						array( &$this, 'render_gallery_meta_box_content'),
						'page',
						'side',
						'default'
					);
				}
				//Render the contents of our meta box
				public function render_gallery_meta_box_content () {
					global $post, $wpdb;
					//Define the meta box output
					$galleries = $wpdb->get_results("SELECT * FROM wp_ngg_gallery");
					$selectedGallery = get_post_meta($post->ID, 'gallery', true);
					
					?><select name="gallery"><option value=""></option><?php
					foreach ($galleries as $key => $gallery) :
						if ($gallery->gid == $selectedGallery) : $active = "selected='selected'"; 
						else : $active = ""; endif ;
						?><option value="<?php echo $gallery->gid ?>" <?php echo $active ?>><?php echo $gallery->title ?></option><?php
					endforeach;
					?>
						</select>
						<div style="margin-top: 8px ;">
							<a href="<?php bloginfo('url') ?>/wp-admin/admin.php?page=nggallery-add-gallery">
								Create new gallery
							</a>
						</div>
					<?php
				}
				
				public function render_work_text_color_choice () {
					global $post;
					?>
                    <input name="work_text_color" value="<?php echo get_post_meta($post->ID, 'work_text_color', true) ?>" />
                    <?php
				}
				
				public function render_work_bg_color_choice () {
					global $post;
					?>
                    <input name="work_bg_color" value="<?php echo get_post_meta($post->ID, 'work_bg_color', true) ?>" />
                    <?php
				}
				
				//Store the meta box data
				public function save_meta_box_data ($post_id) {
					global $post;
					//Ensure we're only saving meta data for the published post and not a revision
					if ($post->ID == $post_id) :
						//Save the meta data
						update_post_meta($post_id, 'work_text_color', $_POST['work_text_color']);
						update_post_meta($post_id, 'work_bg_color', $_POST['work_bg_color']);						
						update_post_meta($post_id, 'gallery', $_POST['gallery']);
					endif;
				}
			}//END gallery_selection class
	
	//The Post Gallery class issues objects containing an post's attachment 'gallery' and returns an array of that data
	class Post_Gallery {
		public function __construct () {
			//Make the current post global - !!!! This should be passed in, or at least the option to do so !!!!
			global $post;
			$this->attachments = get_children( 
				array ( //Pass in our arguments
					'post_parent' => $post->ID, 
					'post_status' => 'inherit', 
					'post_type' => 'attachment', 
					//'post_mime_type' => 'image', 
					'order' => 'ASC', 
					'orderby' => 'menu_order ID'
				), 
				ARRAY_A 
			);//end get_children()
			
			////Merge some additional attachment data into our main object
			foreach ($this->attachments as &$attachment) :
				//Grab the attachment's meta data
				$attachment['meta_data'] = get_post_custom($attachment['ID']);
				
				//Some of our meta data needs to be unserialized for use to user it
				$attachment['meta_data']['_wp_attachment_metadata'] = @unserialize($attachment['meta_data']['_wp_attachment_metadata'][0]);
			endforeach;
			
			$this->attachments = array_values($this->attachments);
		}//End __construct
	}
?>