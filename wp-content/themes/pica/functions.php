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
		add_image_size( 'extra-large', 1300, 574, false ); 
		
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
		}

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
					'post_mime_type' => 'image', 
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